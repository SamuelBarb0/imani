<?php

namespace App\Http\Controllers;

use App\Mail\NewOrderNotification;
use App\Mail\OrderConfirmedEmail;
use App\Mail\OrderPendingTransferEmail;
use App\Mail\WelcomeEmail;
use App\Models\Cart;
use App\Models\City;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Services\PayPhoneService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Display checkout page
     */
    public function index()
    {
        $cart = $this->getCart();

        if (!$cart || $cart->items->count() === 0) {
            return redirect()->route('carrito.index')
                ->with('error', 'Tu carrito está vacío');
        }

        $cart->load('items');

        // Load shipping zones data
        $provincias = \App\Models\ShippingZone::getProvincias();

        // If there's old input, load cantones and parroquias
        $cantones = [];
        $parroquias = [];
        if (old('shipping_provincia')) {
            $cantones = \App\Models\ShippingZone::getCantones(old('shipping_provincia'));
        }
        if (old('shipping_canton')) {
            $parroquias = \App\Models\ShippingZone::getParroquias(old('shipping_provincia'), old('shipping_canton'));
        }

        return view('checkout.index', [
            'cart' => $cart,
            'items' => $cart->items,
            'provincias' => $provincias,
            'cantones' => $cantones,
            'parroquias' => $parroquias,
            'subtotal' => $cart->getTotal(),
            'shippingCost' => 5.00, // Default, will be calculated when zone is selected
            'total' => $cart->getTotal() + 5.00,
        ]);
    }

    /**
     * Process checkout and create order
     */
    public function process(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'document_type' => 'required|in:cedula,pasaporte,ruc',
            'document_number' => 'required|string|max:20',
            'billing_address' => 'required|string',
            'billing_provincia' => 'required|string|max:100',
            'billing_canton' => 'required|string|max:100',
            'billing_parroquia' => 'required|string|max:100',
            'billing_zip' => 'required|string|max:20',
            'billing_country' => 'required|string|max:100',
            'same_as_billing' => 'nullable|boolean',
            'shipping_name' => 'nullable|string|max:255',
            'shipping_address' => 'nullable|string',
            'shipping_provincia' => 'nullable|string|max:100',
            'shipping_canton' => 'nullable|string|max:100',
            'shipping_parroquia' => 'nullable|string|max:100',
            'shipping_zip' => 'required_if:same_as_billing,false|nullable|string|max:20',
            'shipping_country' => 'nullable|string|max:100',
            'payment_method' => 'required|in:payphone,transfer',
            'notes' => 'nullable|string|max:1000',
            'newsletter_subscription' => 'nullable|boolean',
            'social_media_consent' => 'nullable|boolean',
            'accept_terms' => 'required|accepted',
        ]);

        $cart = $this->getCart();

        if (!$cart || $cart->items->count() === 0) {
            return back()->with('error', 'Tu carrito está vacío');
        }

        // Determine shipping location based on same_as_billing checkbox
        $sameAsBilling = $validated['same_as_billing'] ?? true;
        $shippingProvincia = $sameAsBilling ? $validated['billing_provincia'] : $validated['shipping_provincia'];
        $shippingCanton = $sameAsBilling ? $validated['billing_canton'] : $validated['shipping_canton'];
        $shippingParroquia = $sameAsBilling ? $validated['billing_parroquia'] : $validated['shipping_parroquia'];

        // Get shipping zone
        $zone = \App\Models\ShippingZone::byLocation(
            $shippingProvincia,
            $shippingCanton,
            $shippingParroquia
        )->first();

        if (!$zone) {
            return back()->with('error', 'Zona de envío no encontrada')->withInput();
        }

        // Calculate totals BEFORE transaction
        // Prices include 15% IVA, so we need to extract it
        $subtotalWithIVA = $cart->getTotal();
        $shippingCostWithIVA = $this->calculateShippingByZone($zone, $subtotalWithIVA);

        // Calculate base amounts without IVA
        $subtotal = round($subtotalWithIVA / 1.15, 2);
        $shippingCost = round($shippingCostWithIVA / 1.15, 2);

        // Calculate IVA (15%)
        $tax = round(($subtotal + $shippingCost) * 0.15, 2);

        // Calculate total
        $total = $subtotal + $shippingCost + $tax;

        // Generate order number first (needed for welcome email)
        $orderNumber = Order::generateOrderNumber();

        // Find or create user account BEFORE transaction (so it persists even if order fails)
        $user = $this->findOrCreateUser(
            $validated['customer_email'],
            $validated['customer_name'],
            $validated['customer_phone'] ?? null,
            $orderNumber,
            $validated['newsletter_subscription'] ?? false,
            $validated['social_media_consent'] ?? false
        );

        DB::beginTransaction();

        try {

            // Create order
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => $user ? $user->id : Auth::id(),
                'session_id' => session()->getId(),
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'] ?? null,
                'document_type' => $validated['document_type'],
                'document_number' => $validated['document_number'],
                'billing_address' => $validated['billing_address'],
                'billing_provincia' => $validated['billing_provincia'],
                'billing_canton' => $validated['billing_canton'],
                'billing_parroquia' => $validated['billing_parroquia'],
                'billing_zip' => $validated['billing_zip'],
                'billing_country' => $validated['billing_country'],
                'same_as_billing' => $sameAsBilling,
                'shipping_name' => $sameAsBilling ? $validated['customer_name'] : ($validated['shipping_name'] ?? null),
                'shipping_address' => $sameAsBilling ? $validated['billing_address'] : ($validated['shipping_address'] ?? null),
                'shipping_city' => $shippingParroquia,
                'shipping_state' => $shippingProvincia,
                'shipping_canton' => $shippingCanton,
                'shipping_zip' => $sameAsBilling ? $validated['billing_zip'] : ($validated['shipping_zip'] ?? null),
                'shipping_country' => $sameAsBilling ? $validated['billing_country'] : ($validated['shipping_country'] ?? 'Ecuador'),
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'tax' => $tax,
                'total' => $total,
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'pending',
                'status' => 'pending',
                'notes' => $validated['notes'] ?? null,
            ]);

            // Create order items from cart
            foreach ($cart->items as $cartItem) {
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product_name' => $cartItem->getProductName(),
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                    'subtotal' => $cartItem->getSubtotal(),
                    'custom_data' => $cartItem->custom_data,
                ]);

                // Generate template for custom products
                if ($cartItem->product_id === 'custom-magnets-9') {
                    $this->generateTemplate($orderItem);
                }
            }

            // Clear cart
            $cart->items()->delete();

            // Process payment
            $paymentResult = $this->processPayment($order, $validated['payment_method'], $validated['customer_phone']);

            if ($paymentResult['success']) {
                // Update order with transaction details
                $order->update([
                    'payment_status' => $validated['payment_method'] === 'payphone' ? 'pending' : 'pending',
                    'status' => 'pending',
                    'transaction_id' => $paymentResult['transaction_id'] ?? null,
                    'payphone_transaction_id' => $paymentResult['transactionId'] ?? null,
                ]);

                DB::commit();

                if ($validated['payment_method'] === 'payphone') {
                    return redirect()->route('checkout.pending', $order->order_number)
                        ->with('success', 'Solicitud de pago enviada. Por favor confirma el pago en tu app PayPhone.');
                } else {
                    // Send order pending transfer email for bank transfer
                    try {
                        Mail::to($order->customer_email)->send(new OrderPendingTransferEmail($order));
                        Log::info('Order pending transfer email sent', ['order' => $order->order_number, 'email' => $order->customer_email]);
                    } catch (\Exception $mailError) {
                        Log::error('Failed to send order pending transfer email', [
                            'order' => $order->order_number,
                            'email' => $order->customer_email,
                            'error' => $mailError->getMessage(),
                        ]);
                    }

                    // Send new order notification to admin
                    try {
                        Mail::to('pedidos@imanimagnets.com')
                            ->cc('5o8abrkdt3@pomail.net')
                            ->send(new NewOrderNotification($order));
                        Log::info('New order notification sent to admin', [
                            'order' => $order->order_number
                        ]);
                    } catch (\Exception $mailError) {
                        Log::error('Failed to send new order notification', [
                            'order' => $order->order_number,
                            'error' => $mailError->getMessage(),
                        ]);
                    }

                    return redirect()->route('checkout.success', $order->order_number)
                        ->with('success', 'Pedido creado. Por favor envía tu comprobante de transferencia.');
                }
            } else {
                throw new \Exception('Payment failed: ' . $paymentResult['message']);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout failed: ' . $e->getMessage());

            return back()->with('error', 'Hubo un error al procesar tu pedido. Por favor intenta de nuevo.')
                ->withInput();
        }
    }

    /**
     * Save checkout data to session (for PayPhone Box)
     */
    public function saveData(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'document_type' => 'required|string',
            'document_number' => 'required|string',
            'address' => 'nullable|string',
            'provincia' => 'nullable|string',
            'canton' => 'nullable|string',
            'parroquia' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'zip' => 'nullable|string',
            'country' => 'nullable|string',
            'notes' => 'nullable|string',
            'newsletter_subscription' => 'nullable|boolean',
            'social_media_consent' => 'nullable|boolean',
            'client_transaction_id' => 'required|string',
            'shipping_cost' => 'nullable|numeric',
            'subtotal_base' => 'nullable|numeric',
            'shipping_base' => 'nullable|numeric',
            'tax' => 'nullable|numeric',
            'total' => 'nullable|numeric',
        ]);

        // Store in session
        $request->session()->put('checkout', $data);

        return response()->json(['success' => true]);
    }

    /**
     * Display payment page with PayPhone button
     */
    public function payment()
    {
        $cart = $this->getCart();

        if (!$cart || $cart->items->count() === 0) {
            return redirect()->route('carrito.index')
                ->with('error', 'Tu carrito está vacío');
        }

        $checkoutData = session('checkout');

        if (!$checkoutData) {
            return redirect()->route('checkout.index')
                ->with('error', 'Datos de checkout no encontrados. Por favor completa el formulario nuevamente.');
        }

        // Use calculated values from session if available, otherwise calculate them
        if (isset($checkoutData['subtotal_base']) && isset($checkoutData['shipping_base']) && isset($checkoutData['tax']) && isset($checkoutData['total'])) {
            // Use values from session (already calculated in checkout)
            $subtotalBase = $checkoutData['subtotal_base'];
            $shippingBase = $checkoutData['shipping_base'];
            $tax = $checkoutData['tax'];
            $total = $checkoutData['total'];

            // Calculate the original values with IVA for PayPhone API
            // subtotalBase already includes IVA (it's the base for tax calculation)
            $subtotalWithIVA = round($subtotalBase, 2);
            $shippingWithIVA = round($shippingBase, 2);
        } else {
            // Fallback: calculate if not in session
            $city = null;
            if (isset($checkoutData['city'])) {
                $city = City::with(['courierPrices.courier', 'province'])->find($checkoutData['city']);
            }

            $subtotalWithIVA = $cart->getTotal();
            $shippingWithIVA = $this->calculateShipping($cart, $city);

            // Calculate base amounts without IVA
            $subtotalBase = round($subtotalWithIVA / 1.15, 2);
            $shippingBase = round($shippingWithIVA / 1.15, 2);
            $tax = round(($subtotalBase + $shippingBase) * 0.15, 2);
            $total = $subtotalBase + $shippingBase + $tax;
        }

        // Generate a fresh unique client transaction ID for each payment attempt
        // This prevents duplicate transaction errors when user reloads the page
        $clientTransactionId = 'IM-' . time() . '-' . uniqid() . '-' . substr(md5(session()->getId()), 0, 8);

        return view('checkout.payment', [
            'subtotalBase' => $subtotalBase,
            'shippingBase' => $shippingBase,
            'tax' => $tax,
            'total' => $total,
            'subtotalWithIVA' => $subtotalWithIVA,
            'shippingWithIVA' => $shippingWithIVA,
            'customerData' => $checkoutData,
            'clientTransactionId' => $clientTransactionId,
        ]);
    }

    /**
     * Display order success page
     */
    public function success($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with('items')
            ->firstOrFail();

        return view('checkout.success', compact('order'));
    }

    /**
     * Display payment pending page (for PayPhone)
     */
    public function pending($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with('items')
            ->firstOrFail();

        return view('checkout.pending', compact('order'));
    }

    /**
     * Check PayPhone payment status
     */
    public function checkPaymentStatus($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        if ($order->payment_method !== 'payphone') {
            return response()->json([
                'success' => false,
                'message' => 'This order does not use PayPhone',
            ]);
        }

        $payPhoneService = new PayPhoneService();
        $paymentData = $payPhoneService->getPaymentByClientTransactionId($order->order_number);

        if (!$paymentData) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to retrieve payment status',
            ]);
        }

        $isApproved = $payPhoneService->isPaymentApproved($paymentData);

        if ($isApproved) {
            $order->update([
                'payment_status' => 'completed',
                'status' => 'processing',
            ]);

            return response()->json([
                'success' => true,
                'status' => 'approved',
                'message' => 'Payment confirmed!',
            ]);
        }

        return response()->json([
            'success' => true,
            'status' => 'pending',
            'message' => 'Payment still pending',
        ]);
    }

    /**
     * Handle PayPhone return callback
     * PayPhone redirects here with: ?id={transactionId}&clientTransactionID={orderNumber}
     */
    public function payphoneReturn(Request $request)
    {
        $transactionId = $request->query('id');
        $clientTransactionId = $request->query('clientTransactionID');

        Log::info('PayPhone return callback', [
            'transactionId' => $transactionId,
            'clientTransactionId' => $clientTransactionId,
        ]);

        if (!$clientTransactionId) {
            return redirect()->route('home')
                ->with('error', 'Invalid payment response');
        }

        // Find order by client transaction ID (order number)
        $order = Order::where('order_number', $clientTransactionId)->first();

        if (!$order) {
            return redirect()->route('home')
                ->with('error', 'Order not found');
        }

        // Verify payment with PayPhone API
        $payPhoneService = new PayPhoneService();
        $paymentData = $payPhoneService->getPaymentByTransactionId($transactionId);

        if (!$paymentData) {
            return redirect()->route('checkout.pending', $order->order_number)
                ->with('error', 'Unable to verify payment status');
        }

        // Check if payment was approved
        if ($payPhoneService->isPaymentApproved($paymentData)) {
            $order->update([
                'payment_status' => 'completed',
                'status' => 'processing',
                'payphone_transaction_id' => $transactionId,
            ]);

            // Send confirmation email to customer
            try {
                Mail::to($order->customer_email)->send(new OrderConfirmedEmail($order));
                $order->update(['email_order_confirmed' => true]);
                Log::info('Order confirmation email sent after PayPhone payment', [
                    'order' => $order->order_number,
                    'email' => $order->customer_email
                ]);
            } catch (\Exception $mailError) {
                Log::error('Failed to send order confirmation email', [
                    'order' => $order->order_number,
                    'email' => $order->customer_email,
                    'error' => $mailError->getMessage(),
                ]);
            }

            // Send new order notification to admin
            try {
                Mail::to('pedidos@imanimagnets.com')
                    ->cc('5o8abrkdt3@pomail.net')
                    ->send(new NewOrderNotification($order));
                Log::info('New order notification sent to admin', [
                    'order' => $order->order_number
                ]);
            } catch (\Exception $mailError) {
                Log::error('Failed to send new order notification', [
                    'order' => $order->order_number,
                    'error' => $mailError->getMessage(),
                ]);
            }

            return redirect()->route('checkout.success', $order->order_number)
                ->with('success', '¡Pago completado exitosamente!');
        } else {
            // Payment was cancelled or rejected
            $order->update([
                'payment_status' => 'failed',
                'status' => 'cancelled',
            ]);

            return redirect()->route('checkout.index')
                ->with('error', 'El pago fue cancelado o rechazado. Por favor intenta nuevamente.');
        }
    }

    /**
     * Generate template for custom magnet products
     */
    private function generateTemplate(OrderItem $orderItem): void
    {
        $customData = $orderItem->custom_data;

        if (!isset($customData['images']) || count($customData['images']) !== 9) {
            \Log::warning("Order item {$orderItem->id} doesn't have 9 images");
            return;
        }

        // Mark as pending template generation (will be generated via Job later)
        $orderItem->update([
            'template_path' => 'pending_generation',
        ]);
    }

    /**
     * Process payment
     */
    private function processPayment(Order $order, string $paymentMethod, string $phoneNumber): array
    {
        if ($paymentMethod === 'payphone') {
            // PayPhone payment integration
            $payPhoneService = new PayPhoneService();
            $result = $payPhoneService->createPayment($order, $phoneNumber);

            if ($result['success']) {
                return [
                    'success' => true,
                    'transaction_id' => $result['clientTransactionId'] ?? $order->order_number,
                    'transactionId' => $result['transactionId'] ?? null,
                    'message' => $result['message'],
                ];
            }

            return $result;

        } elseif ($paymentMethod === 'transfer') {
            // Bank transfer - awaiting confirmation
            return [
                'success' => true,
                'transaction_id' => 'TRANSFER_' . strtoupper(uniqid()),
                'message' => 'Bank transfer pending - Send receipt within 1 hour',
            ];
        }

        // Default fallback
        return [
            'success' => false,
            'transaction_id' => null,
            'message' => 'Invalid payment method',
        ];
    }

    /**
     * Get shipping cost for a specific city (AJAX endpoint)
     */
    public function getShippingCost($cityId)
    {
        $city = City::with(['courierPrices.courier', 'province'])->find($cityId);

        if (!$city) {
            return response()->json([
                'success' => false,
                'cost' => 10.00,
                'message' => 'Ciudad no encontrada'
            ]);
        }

        $cart = $this->getCart();
        $shippingCost = $this->calculateShipping($cart, $city);
        $subtotal = $cart ? $cart->getTotal() : 0;

        return response()->json([
            'success' => true,
            'cost' => $shippingCost,
            'subtotal' => $subtotal,
            'total' => $subtotal + $shippingCost,
            'city_name' => $city->name,
            'province_name' => $city->province->name
        ]);
    }

    /**
     * Calculate shipping cost based on city (Legacy - for backward compatibility)
     */
    private function calculateShipping(Cart $cart, ?City $city = null): float
    {
        if (!$city) {
            return 5.00; // Default shipping if no city provided
        }

        // Get the first available courier price for this city
        $courierPrice = $city->courierPrices()
            ->whereHas('courier', function($query) {
                $query->where('is_active', true);
            })
            ->orderBy('price', 'asc')
            ->first();

        if ($courierPrice) {
            return (float) $courierPrice->price;
        }

        // Fallback if no courier price found for this city
        return 5.00;
    }

    /**
     * Calculate shipping cost based on shipping zone
     */
    private function calculateShippingByZone(\App\Models\ShippingZone $zone, float $subtotal = 0): float
    {
        // Free shipping for orders over $50 USD (with IVA included)
        if ($subtotal >= 50.00) {
            return 0.00;
        }

        $cost = $zone->getShippingCost();

        if ($cost === null) {
            // No price code assigned - return default
            return 5.00;
        }

        return $cost;
    }

    /**
     * Get current cart
     */
    private function getCart(): ?Cart
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::id())->first();
        } else {
            return Cart::where('session_id', session()->getId())->first();
        }
    }

    /**
     * Find existing user or create new account
     * Creates account automatically for guest checkouts
     */
    private function findOrCreateUser(
        string $email,
        string $name,
        ?string $phone,
        ?string $orderNumber = null,
        bool $newsletterSubscription = false,
        bool $socialMediaConsent = false
    ): ?User {
        // If user is already logged in, return the authenticated user
        if (Auth::check()) {
            return Auth::user();
        }

        // Try to find existing user by email
        $user = User::where('email', $email)->first();

        if ($user) {
            // Update preferences if user exists (don't overwrite if they already opted in)
            if ($newsletterSubscription && !$user->newsletter_subscription) {
                $user->newsletter_subscription = true;
            }
            if ($socialMediaConsent && !$user->social_media_consent) {
                $user->social_media_consent = true;
            }
            $user->save();

            Log::info('Found existing user for order', ['email' => $email, 'user_id' => $user->id]);
            return $user;
        }

        // Create new user account
        try {
            $password = Str::random(12); // Generate random password

            $user = User::create([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'password' => Hash::make($password),
                'newsletter_subscription' => $newsletterSubscription,
                'social_media_consent' => $socialMediaConsent,
            ]);

            Log::info('Created new user account after payment', [
                'email' => $email,
                'user_id' => $user->id,
                'temp_password' => $password,
            ]);

            // Send welcome email with login credentials
            try {
                Mail::to($user->email)->send(new WelcomeEmail($user, $password, $orderNumber));
                Log::info('Welcome email sent successfully', ['email' => $email]);
            } catch (\Exception $mailError) {
                Log::error('Failed to send welcome email', [
                    'email' => $email,
                    'error' => $mailError->getMessage(),
                ]);
                // Don't fail the user creation if email fails
            }

            return $user;

        } catch (\Exception $e) {
            Log::error('Failed to create user account', [
                'email' => $email,
                'error' => $e->getMessage(),
            ]);

            // Return null if user creation fails - order will still be created
            return null;
        }
    }

    /**
     * Get cantones for a provincia (AJAX endpoint)
     */
    public function getCantones(Request $request)
    {
        $provincia = $request->query('provincia');

        if (!$provincia) {
            return response()->json([]);
        }

        $cantones = \App\Models\ShippingZone::getCantones($provincia);

        return response()->json($cantones);
    }

    /**
     * Get parroquias for a canton (AJAX endpoint)
     */
    public function getParroquias(Request $request)
    {
        $provincia = $request->query('provincia');
        $canton = $request->query('canton');

        if (!$provincia || !$canton) {
            return response()->json([]);
        }

        $parroquias = \App\Models\ShippingZone::getParroquias($provincia, $canton);

        return response()->json($parroquias);
    }

    /**
     * Get shipping cost for zona (AJAX endpoint)
     */
    public function getShippingCostByZone(Request $request)
    {
        $provincia = $request->query('provincia');
        $canton = $request->query('canton');
        $parroquia = $request->query('parroquia');

        if (!$provincia || !$canton || !$parroquia) {
            return response()->json([
                'success' => false,
                'cost' => 5.00,
                'message' => 'Datos incompletos'
            ]);
        }

        $zone = \App\Models\ShippingZone::byLocation($provincia, $canton, $parroquia)->first();

        if (!$zone) {
            return response()->json([
                'success' => false,
                'cost' => 5.00,
                'message' => 'Zona no encontrada'
            ]);
        }

        $cart = $this->getCart();
        $subtotalWithIVA = $cart ? $cart->getTotal() : 0;
        $shippingCostWithIVA = $this->calculateShippingByZone($zone, $subtotalWithIVA);

        // Calculate base amounts without IVA
        $subtotal = round($subtotalWithIVA / 1.15, 2);
        $shippingCost = round($shippingCostWithIVA / 1.15, 2);

        // Calculate IVA (15%)
        $tax = round(($subtotal + $shippingCost) * 0.15, 2);

        // Calculate total
        $total = $subtotal + $shippingCost + $tax;

        return response()->json([
            'success' => true,
            'cost' => $shippingCost,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
            'provincia' => $zone->provincia,
            'canton' => $zone->canton,
            'parroquia' => $zone->parroquia,
            'price_code' => $zone->price_code
        ]);
    }
}
