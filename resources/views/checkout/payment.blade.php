@extends('layouts.app')

@section('title', 'Procesar Pago - Imani Magnets')

@push('styles')
<link rel="stylesheet" href="https://cdn.payphonetodoesposible.com/box/v1.1/payphone-payment-box.css">
@endpush

@section('content')

<!-- Payment Section -->
<section class="bg-gray-50 py-12 min-h-screen flex items-center justify-center">
    <div class="container mx-auto px-6 max-w-2xl">

        <!-- Checkout Message (if active) -->
        @php
            $checkoutMessage = \App\Models\CheckoutMessage::getActiveMessage();
        @endphp

        @if($checkoutMessage)
            <div class="mb-6 rounded-lg p-4 border-l-4
                @if($checkoutMessage->type === 'info') bg-blue-50 border-blue-500
                @elseif($checkoutMessage->type === 'warning') bg-yellow-50 border-yellow-500
                @elseif($checkoutMessage->type === 'vacation') bg-orange-50 border-orange-500
                @endif">
                <div class="text-sm whitespace-pre-line
                    @if($checkoutMessage->type === 'info') text-blue-900
                    @elseif($checkoutMessage->type === 'warning') text-yellow-900
                    @elseif($checkoutMessage->type === 'vacation') text-orange-900
                    @endif">{{ $checkoutMessage->content }}</div>
            </div>
        @endif

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
                        <span class="font-semibold">${{ number_format($subtotalBase, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-brown">Envío:</span>
                        <span class="font-semibold">${{ number_format($shippingBase, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-brown">IVA (15%):</span>
                        <span class="font-semibold">${{ number_format($tax, 2) }}</span>
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

            <!-- Loading indicator -->
            <div id="payment-loading" class="mb-6 text-center">
                <div class="inline-flex items-center px-4 py-2 text-sm text-gray-700">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Cargando método de pago...
                </div>
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

@php
    // Calculate cents from the actual total to avoid rounding errors
    $totalCents = round($total * 100);
    $subtotalCents = round($subtotalWithIVA * 100);
    $shippingCents = $totalCents - $subtotalCents; // Use difference to match exact total
@endphp

@push('scripts')
<script>
    // Detect Instagram in-app browser
    function isInstagramBrowser() {
        const ua = navigator.userAgent || navigator.vendor || window.opera;
        return (ua.indexOf('Instagram') > -1);
    }

    // Fix for Instagram webview - prevent body scroll interfering with iframe
    if (isInstagramBrowser()) {
        console.log('Instagram browser detected - applying fixes');

        // Add CSS to improve iframe rendering in Instagram
        const style = document.createElement('style');
        style.textContent = `
            #pp-button iframe {
                width: 100% !important;
                min-height: 400px !important;
                border: none !important;
                display: block !important;
                -webkit-overflow-scrolling: touch !important;
                overflow: auto !important;
            }
            #pp-button {
                -webkit-overflow-scrolling: touch !important;
                overflow: visible !important;
                position: relative !important;
                z-index: 9999 !important;
            }
        `;
        document.head.appendChild(style);
    }

    // Initialize PayPhone Payment Box
    function initializePayPhone() {
        console.log('Initializing PayPhone...');

        // Check if PayPhone is loaded
        if (typeof PPaymentButtonBox === 'undefined') {
            console.warn('PPaymentButtonBox not defined yet');
            return;
        }

        try {
            const subtotalCents = {{ $subtotalCents }};
            const shippingCents = {{ $shippingCents }};
            const totalCents = {{ $totalCents }};

            new PPaymentButtonBox({
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

            console.log('PayPhone initialized successfully');

            // Hide loading indicator when iframe appears
            const checkIframe = setInterval(function() {
                if (document.querySelector('#pp-button iframe')) {
                    clearInterval(checkIframe);
                    const loadingEl = document.getElementById('payment-loading');
                    if (loadingEl) {
                        loadingEl.style.display = 'none';
                    }
                }
            }, 100);

            // Fallback to hide loading after 2 seconds
            setTimeout(function() {
                const loadingEl = document.getElementById('payment-loading');
                if (loadingEl) {
                    loadingEl.style.display = 'none';
                }
            }, 2000);

        } catch (error) {
            console.error('Error initializing PayPhone:', error);
            document.getElementById('payment-loading').innerHTML = `
                <div class="text-red-600 text-sm">
                    Error al inicializar el pago. Por favor recarga la página.
                </div>
            `;
        }
    }

    // Load PayPhone script dynamically
    (function() {
        const script = document.createElement('script');
        script.src = 'https://cdn.payphonetodoesposible.com/box/v1.1/payphone-payment-box.js';
        script.async = true;

        script.onload = function() {
            console.log('PayPhone script loaded');
            // Small delay to ensure PayPhone is fully ready
            setTimeout(initializePayPhone, 100);
        };

        script.onerror = function() {
            console.error('Failed to load PayPhone script');
            document.getElementById('payment-loading').innerHTML = `
                <div class="text-red-600 text-sm">
                    Error al cargar PayPhone. Por favor recarga la página.
                </div>
            `;
        };

        document.head.appendChild(script);
    })();
</script>
@endpush
