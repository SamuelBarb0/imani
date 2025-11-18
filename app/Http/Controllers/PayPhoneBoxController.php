<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\User;
use App\Mail\WelcomeEmail;
use App\Mail\OrderConfirmedEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PayPhoneBoxController extends Controller
{
    /**
     * Handle PayPhone Payment Box confirmation callback
     * This is called after PayPhone redirects back with payment confirmation
     */
    public function confirm(Request $request)
    {
        // Log all query parameters to see what PayPhone is sending
        Log::info('PayPhone Box callback received - ALL PARAMS', [
            'all_query' => $request->query(),
            'all_input' => $request->all(),
        ]);

        $transactionId = $request->query('id');
        // Try different possible parameter names
        $clientTransactionId = $request->query('clientTransactionId')
                            ?? $request->query('clientTxId')
                            ?? $request->query('client_transaction_id')
                            ?? $request->query('reference');

        Log::info('PayPhone Box callback received', [
            'transactionId' => $transactionId,
            'clientTransactionId' => $clientTransactionId,
        ]);

        if (!$transactionId) {
            return redirect()->route('home')
                ->with('error', 'Invalid payment response - No transaction ID');
        }

        if (!$clientTransactionId) {
            // If we can't get clientTransactionId, we need to fetch it from PayPhone API
            Log::warning('No clientTransactionId in callback, will try to get from PayPhone API');
        }

        // Call PayPhone Confirm API
        $paymentData = $this->callConfirmAPI($transactionId, $clientTransactionId);

        if (!$paymentData) {
            return redirect()->route('checkout.index')
                ->with('error', 'Unable to verify payment. Please contact support.');
        }

        // If we didn't have clientTransactionId from callback, get it from PayPhone response
        if (!$clientTransactionId && isset($paymentData['clientTransactionId'])) {
            $clientTransactionId = $paymentData['clientTransactionId'];
            Log::info('Retrieved clientTransactionId from PayPhone API response', [
                'clientTransactionId' => $clientTransactionId
            ]);
        }

        // Check if payment was approved
        if ($this->isPaymentApproved($paymentData)) {
            // Create order from session data
            $order = $this->createOrderFromPayment($clientTransactionId, $paymentData, $request);

            if ($order) {
                // Clear cart
                $this->clearCart();

                return redirect()->route('checkout.success', $order->order_number)
                    ->with('success', '¡Pago completado exitosamente!');
            } else {
                return redirect()->route('checkout.index')
                    ->with('error', 'Error creating order. Please contact support with transaction ID: ' . $transactionId);
            }
        } else {
            // Payment was cancelled or rejected
            return redirect()->route('checkout.index')
                ->with('error', 'El pago fue cancelado o rechazado. Por favor intenta nuevamente.');
        }
    }

    /**
     * Call PayPhone Confirm API
     */
    private function callConfirmAPI(string $transactionId, ?string $clientTransactionId): ?array
    {
        try {
            $payload = [
                'id' => (int) $transactionId,
            ];

            // Only add clientTxId if we have it
            if ($clientTransactionId) {
                $payload['clientTxId'] = $clientTransactionId;
            }

            Log::info('PayPhone confirm API request', ['payload' => $payload]);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('payphone.token'),
                'Content-Type' => 'application/json',
            ])->post(config('payphone.api_url') . '/button/V2/Confirm', $payload);

            if ($response->successful()) {
                $data = $response->json();
                Log::info('PayPhone confirm API response', ['data' => $data]);
                return $data;
            }

            Log::error('PayPhone confirm API failed', [
                'status' => $response->status(),
                'response' => $response->body(),
            ]);

            return null;

        } catch (\Exception $e) {
            Log::error('PayPhone confirm API exception', [
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Check if payment is approved
     */
    private function isPaymentApproved(array $paymentData): bool
    {
        // transactionStatus: "Approved" or "Canceled"
        // statusCode: 3 = Approved, 2 = Canceled
        return isset($paymentData['transactionStatus']) &&
               $paymentData['transactionStatus'] === 'Approved';
    }

    /**
     * Create order from payment data
     */
    private function createOrderFromPayment(string $clientTransactionId, array $paymentData, Request $request): ?Order
    {
        DB::beginTransaction();

        try {
            // Get cart
            $cart = $this->getCart();

            if (!$cart || $cart->items->count() === 0) {
                throw new \Exception('Cart is empty');
            }

            // Prices include 15% IVA, so we need to extract it
            $subtotalWithIVA = $cart->getTotal();
            $shippingCostWithIVA = $this->calculateShipping($cart);

            // Calculate base amounts without IVA
            $subtotal = round($subtotalWithIVA / 1.15, 2);
            $shippingCost = round($shippingCostWithIVA / 1.15, 2);

            // Calculate IVA (15%)
            $tax = round(($subtotal + $shippingCost) * 0.15, 2);

            // Calculate total
            $total = $subtotal + $shippingCost + $tax;

            // Extract customer data from PayPhone response
            $customerEmail = $paymentData['email'] ?? $request->session()->get('checkout.email', 'no-email@example.com');
            $customerPhone = $paymentData['phoneNumber'] ?? $request->session()->get('checkout.phone', '');
            $customerName = $request->session()->get('checkout.name', 'Customer');
            $newsletterSubscription = $request->session()->get('checkout.newsletter_subscription', false);
            $socialMediaConsent = $request->session()->get('checkout.social_media_consent', false);

            // Find or create user account (passing order number for the welcome email)
            $user = $this->findOrCreateUser(
                $customerEmail,
                $customerName,
                $customerPhone,
                $clientTransactionId,
                $newsletterSubscription,
                $socialMediaConsent
            );

            // Create order
            $order = Order::create([
                'order_number' => $clientTransactionId,
                'user_id' => $user ? $user->id : Auth::id(),
                'session_id' => session()->getId(),
                'customer_name' => $customerName,
                'customer_email' => $customerEmail,
                'customer_phone' => $customerPhone,
                'shipping_address' => $request->session()->get('checkout.address', 'N/A'),
                'shipping_city' => $request->session()->get('checkout.city', 'N/A'),
                'shipping_state' => $request->session()->get('checkout.state'),
                'shipping_zip' => $request->session()->get('checkout.zip', 'N/A'),
                'shipping_country' => $request->session()->get('checkout.country', 'Ecuador'),
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'tax' => $tax,
                'total' => $total,
                'payment_method' => 'payphone_box',
                'payment_status' => 'completed',
                'status' => 'processing',
                'transaction_id' => $clientTransactionId,
                'payphone_transaction_id' => $paymentData['transactionId'] ?? null,
                'notes' => 'Pago con ' . ($paymentData['cardBrand'] ?? 'PayPhone'),
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

            DB::commit();

            // Send order confirmation email
            try {
                Mail::to($order->customer_email)->send(new OrderConfirmedEmail($order));
                $order->update(['email_order_confirmed' => true]);
                Log::info('Order confirmation email sent after PayPhone Box payment', [
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

            return $order;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create order from payment', [
                'error' => $e->getMessage(),
                'clientTransactionId' => $clientTransactionId,
            ]);

            return null;
        }
    }

    /**
     * Generate template for custom magnet products
     */
    private function generateTemplate(OrderItem $orderItem): void
    {
        $customData = $orderItem->custom_data;

        if (!isset($customData['images']) || count($customData['images']) !== 9) {
            Log::warning("Order item {$orderItem->id} doesn't have 9 images");
            return;
        }

        // Mark as pending template generation
        $orderItem->update([
            'template_path' => 'pending_generation',
        ]);
    }

    /**
     * Calculate shipping cost
     */
    private function calculateShipping(Cart $cart): float
    {
        $subtotal = $cart->getTotal();

        // Free shipping for orders over $50 USD (with IVA included)
        if ($subtotal >= 50.00) {
            return 0.00;
        }

        // Default shipping cost (with IVA)
        return 6.00;
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
     * Clear cart after successful order
     */
    private function clearCart(): void
    {
        $cart = $this->getCart();
        if ($cart) {
            $cart->items()->delete();
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
}
