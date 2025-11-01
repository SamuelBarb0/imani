<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\PayPhoneService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PayPhoneWebhookController extends Controller
{
    /**
     * Handle PayPhone webhook notifications
     */
    public function handle(Request $request)
    {
        Log::info('PayPhone webhook received', ['payload' => $request->all()]);

        try {
            // PayPhone sends the transaction status in the webhook
            $clientTransactionId = $request->input('clientTransactionId');
            $transactionId = $request->input('id');
            $statusCode = $request->input('statusCode');

            if (!$clientTransactionId) {
                Log::error('PayPhone webhook missing clientTransactionId');
                return response()->json(['error' => 'Missing clientTransactionId'], 400);
            }

            // Find the order
            $order = Order::where('order_number', $clientTransactionId)->first();

            if (!$order) {
                Log::error('PayPhone webhook - order not found', ['clientTransactionId' => $clientTransactionId]);
                return response()->json(['error' => 'Order not found'], 404);
            }

            // Verify payment with PayPhone API
            $payPhoneService = new PayPhoneService();
            $paymentData = $payPhoneService->getPaymentByTransactionId($transactionId);

            if (!$paymentData) {
                Log::error('PayPhone webhook - unable to verify payment', ['transactionId' => $transactionId]);
                return response()->json(['error' => 'Unable to verify payment'], 500);
            }

            // Update order based on payment status
            if ($payPhoneService->isPaymentApproved($paymentData)) {
                $order->update([
                    'payment_status' => 'completed',
                    'status' => 'processing',
                    'payphone_transaction_id' => $transactionId,
                ]);

                Log::info('PayPhone payment approved', [
                    'order' => $order->order_number,
                    'transactionId' => $transactionId,
                ]);

                // TODO: Send confirmation email to customer

            } else {
                $order->update([
                    'payment_status' => 'failed',
                    'status' => 'cancelled',
                ]);

                Log::info('PayPhone payment failed/cancelled', [
                    'order' => $order->order_number,
                    'transactionId' => $transactionId,
                    'statusCode' => $statusCode,
                ]);
            }

            return response()->json(['success' => true], 200);

        } catch (\Exception $e) {
            Log::error('PayPhone webhook exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['error' => 'Internal server error'], 500);
        }
    }
}
