<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PayPhoneService
{
    protected string $token;
    protected string $storeId;
    protected string $apiUrl;
    protected string $countryCode;
    protected string $currency;

    public function __construct()
    {
        $this->token = config('payphone.token');
        $this->storeId = config('payphone.store_id');
        $this->apiUrl = config('payphone.api_url');
        $this->countryCode = config('payphone.country_code');
        $this->currency = config('payphone.currency');
    }

    /**
     * Create a payment request
     *
     * @param Order $order
     * @param string $phoneNumber Customer's PayPhone registered phone number
     * @return array
     */
    public function createPayment(Order $order, string $phoneNumber): array
    {
        try {
            // Convert amount to cents (PayPhone requires integer values)
            $amountInCents = (int) ($order->total * 100);
            $subtotalInCents = (int) ($order->subtotal * 100);
            $shippingInCents = (int) ($order->shipping_cost * 100);
            $taxInCents = (int) ($order->tax * 100);

            // Prepare request payload
            $payload = [
                'amount' => $amountInCents,
                'amountWithoutTax' => $subtotalInCents,
                'amountWithTax' => 0,
                'tax' => $taxInCents,
                'service' => $shippingInCents,
                'tip' => 0,
                'currency' => $this->currency,
                'reference' => $order->order_number,
                'clientTransactionId' => $order->order_number,
                'phoneNumber' => $this->cleanPhoneNumber($phoneNumber),
                'countryCode' => $this->countryCode,
                'responseUrl' => route('checkout.payphone.return'),
            ];

            Log::info('PayPhone payment request', ['order' => $order->order_number, 'payload' => $payload]);

            // Make API request
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl . '/Sale', $payload);

            if ($response->successful()) {
                $data = $response->json();

                Log::info('PayPhone payment created', ['order' => $order->order_number, 'response' => $data]);

                return [
                    'success' => true,
                    'transactionId' => $data['transactionId'] ?? null,
                    'clientTransactionId' => $data['clientTransactionId'] ?? $order->order_number,
                    'message' => 'Payment request sent to customer. Please confirm in PayPhone app.',
                ];
            }

            Log::error('PayPhone payment failed', [
                'order' => $order->order_number,
                'status' => $response->status(),
                'response' => $response->body(),
            ]);

            return [
                'success' => false,
                'message' => 'Failed to create payment request: ' . $response->body(),
            ];

        } catch (\Exception $e) {
            Log::error('PayPhone exception', [
                'order' => $order->order_number,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Payment service error: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Query payment status by transaction ID
     *
     * @param string $transactionId
     * @return array|null
     */
    public function getPaymentByTransactionId(string $transactionId): ?array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
                'Content-Type' => 'application/json',
            ])->get($this->apiUrl . '/Sale/' . $transactionId);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('PayPhone query failed', [
                'transactionId' => $transactionId,
                'status' => $response->status(),
                'response' => $response->body(),
            ]);

            return null;

        } catch (\Exception $e) {
            Log::error('PayPhone query exception', [
                'transactionId' => $transactionId,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Query payment status by client transaction ID (order number)
     *
     * @param string $clientTransactionId
     * @return array|null
     */
    public function getPaymentByClientTransactionId(string $clientTransactionId): ?array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
                'Content-Type' => 'application/json',
            ])->get($this->apiUrl . '/Sale/client/' . $clientTransactionId);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('PayPhone client query failed', [
                'clientTransactionId' => $clientTransactionId,
                'status' => $response->status(),
                'response' => $response->body(),
            ]);

            return null;

        } catch (\Exception $e) {
            Log::error('PayPhone client query exception', [
                'clientTransactionId' => $clientTransactionId,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Check if payment is approved
     *
     * @param array $paymentData
     * @return bool
     */
    public function isPaymentApproved(array $paymentData): bool
    {
        // statusCode: 3 = Approved, 2 = Canceled
        return isset($paymentData['statusCode']) && $paymentData['statusCode'] === 3;
    }

    /**
     * Clean phone number (remove spaces, dashes, etc.)
     *
     * @param string $phoneNumber
     * @return string
     */
    private function cleanPhoneNumber(string $phoneNumber): string
    {
        return preg_replace('/[^0-9]/', '', $phoneNumber);
    }
}
