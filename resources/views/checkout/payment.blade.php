@extends('layouts.app')

@section('title', 'Procesar Pago - Imani Magnets')

@push('styles')
<link rel="stylesheet" href="https://cdn.payphonetodoesposible.com/box/v1.1/payphone-payment-box.css">
@endpush

@section('content')

<!-- Payment Section -->
<section class="bg-gray-50 py-12 min-h-screen flex items-center justify-center">
    <div class="container mx-auto px-6 max-w-2xl">

        <!-- Payment Card -->
        <div class="bg-white rounded-lg shadow-xl p-8">

            <!-- Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                </div>
                <h1 class="font-spartan text-3xl font-bold text-dark-turquoise mb-2">
                    Procesar Pago
                </h1>
                <p class="text-gray-brown">
                    Haz clic en el botón para completar tu pago de forma segura
                </p>
            </div>

            <!-- Order Summary -->
            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                <h2 class="font-spartan text-lg font-bold text-dark-turquoise mb-4">
                    Resumen de tu Pedido
                </h2>

                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-brown">Subtotal:</span>
                        <span class="font-semibold">${{ number_format($subtotal / 1.15, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-brown">Envío:</span>
                        <span class="font-semibold">${{ number_format($shippingCost / 1.15, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-brown">IVA (15%):</span>
                        <span class="font-semibold">${{ number_format((($subtotal / 1.15) + ($shippingCost / 1.15)) * 0.15, 2) }}</span>
                    </div>
                    <div class="border-t border-gray-300 pt-3 flex justify-between">
                        <span class="font-spartan font-bold text-dark-turquoise text-lg">Total a Pagar:</span>
                        <span class="font-spartan text-2xl font-bold text-dark-turquoise">${{ number_format($total, 2) }}</span>
                    </div>
                </div>

                <!-- Customer Info -->
                <div class="mt-6 pt-6 border-t border-gray-300">
                    <p class="text-sm text-gray-brown mb-2">
                        <strong>Nombre:</strong> {{ $customerData['name'] ?? 'N/A' }}
                    </p>
                    <p class="text-sm text-gray-brown">
                        <strong>Email:</strong> {{ $customerData['email'] ?? 'N/A' }}
                    </p>
                </div>
            </div>

            <!-- PayPhone Button Container -->
            <div class="mb-6">
                <div id="pp-button" class="flex justify-center"></div>
            </div>

            <!-- Security Info -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-blue-900 mb-1">Pago 100% Seguro</p>
                        <p class="text-xs text-blue-800">
                            Tu información está protegida. Aceptamos Visa, MasterCard, Diners, Discover y saldo PayPhone.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Back Button -->
            <div class="text-center mt-6">
                <a href="{{ route('checkout.index') }}" class="text-sm text-gray-brown hover:text-dark-turquoise transition-colors">
                    ← Volver al checkout
                </a>
            </div>

        </div>

    </div>
</section>

@endsection

@push('scripts')
<script type="module" src="https://cdn.payphonetodoesposible.com/box/v1.1/payphone-payment-box.js"></script>
<script>
    window.addEventListener('DOMContentLoaded', () => {
        // Initialize PayPhone Payment Box
        // Amount = AmountWithTax + AmountWithoutTax + Tax + Service + Tip
        const subtotalCents = {{ round($subtotal * 100) }};
        const shippingCents = {{ round($shippingCost * 100) }};
        const totalCents = subtotalCents + shippingCents;

        const ppb = new PPaymentButtonBox({
            token: '{{ config("payphone.token") }}',
            storeId: '{{ config("payphone.store_id") }}',
            clientTransactionId: '{{ $clientTransactionId }}',
            amount: totalCents,
            amountWithoutTax: subtotalCents,
            amountWithTax: 0,
            tax: 0,
            service: shippingCents,
            tip: 0,
            currency: "USD",
            reference: "Pedido Imani Magnets",
            responseUrl: '{{ route('checkout.payphone.confirm') }}',
            btnHorizontal: true
        }).render('pp-button');

        console.log('PayPhone initialized with:', {
            amount: totalCents,
            amountWithoutTax: subtotalCents,
            service: shippingCents,
            total: totalCents,
            validation: subtotalCents + shippingCents === totalCents,
            responseUrl: '{{ route('checkout.payphone.confirm') }}',
            clientTransactionId: '{{ $clientTransactionId }}'
        });
    });
</script>
@endpush
