<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmedEmail;
use App\Mail\OrderPendingTransferEmail;
use App\Models\Cart;
use App\Models\City;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\PayPhoneService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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

        // Load active provinces with their cities grouped
        $provinces = \App\Models\Province::where('is_active', true)
            ->with(['cities' => function($query) {
                $query->where('is_active', true)
                    ->with(['courierPrices.courier'])
                    ->orderBy('name');
            }])
            ->whereHas('cities', function($query) {
                $query->where('is_active', true);
            })
            ->orderBy('name')
            ->get();

        return view('checkout.index', [
            'cart' => $cart,
            'items' => $cart->items,
            'provinces' => $provinces,
            'subtotal' => $cart->getTotal(),
            'shippingCost' => $this->calculateShipping($cart),
            'total' => $cart->getTotal() + $this->calculateShipping($cart),
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
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|exists:cities,id',
            'shipping_state' => 'nullable|string|max:100',
            'shipping_zip' => 'required|string|max:20',
            'shipping_country' => 'required|string|max:100',
            'payment_method' => 'required|in:payphone,transfer',
            'notes' => 'nullable|string|max:1000',
        ]);

        $cart = $this->getCart();

        if (!$cart || $cart->items->count() === 0) {
            return back()->with('error', 'Tu carrito está vacío');
        }

        // Get city details
        $city = City::with('province')->findOrFail($validated['shipping_city']);

        DB::beginTransaction();

        try {
            $subtotal = $cart->getTotal();
            $shippingCost = $this->calculateShipping($cart, $city);
            $total = $subtotal + $shippingCost;

            // Create order
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => Auth::id(),
                'session_id' => session()->getId(),
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'] ?? null,
                'shipping_address' => $validated['shipping_address'],
                'shipping_city' => $city->name,
                'shipping_state' => $city->province->name,
                'shipping_zip' => $validated['shipping_zip'],
                'shipping_country' => $validated['shipping_country'],
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'tax' => 0,
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
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'nullable|string',
            'zip' => 'required|string',
            'country' => 'required|string',
            'notes' => 'nullable|string',
            'client_transaction_id' => 'required|string',
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

        // Get city to calculate correct shipping cost
        $city = null;
        if (isset($checkoutData['city'])) {
            $city = City::with(['courierPrices.courier', 'province'])->find($checkoutData['city']);
        }

        $subtotal = $cart->getTotal();
        $shippingCost = $this->calculateShipping($cart, $city);
        $total = $subtotal + $shippingCost;

        // Generate a fresh unique client transaction ID for each payment attempt
        // This prevents duplicate transaction errors when user reloads the page
        $clientTransactionId = 'IM-' . time() . '-' . uniqid() . '-' . substr(md5(session()->getId()), 0, 8);

        return view('checkout.payment', [
            'subtotal' => $subtotal,
            'shippingCost' => $shippingCost,
            'total' => $total,
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
     * Calculate shipping cost based on city
     */
    private function calculateShipping(Cart $cart, ?City $city = null): float
    {
        if (!$city) {
            return 10.00; // Default shipping if no city provided
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
        return 10.00;
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
}
