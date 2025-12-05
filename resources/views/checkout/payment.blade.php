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

            <!-- Instagram In-App Browser Warning -->
            <div id="instagram-warning" class="mb-6 bg-orange-50 border border-orange-200 rounded-lg p-4 hidden">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-orange-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-orange-900 mb-1">Navegador de Instagram detectado</p>
                        <p class="text-xs text-orange-800 mb-3">
                            Para completar tu pago de forma segura, por favor abre esta página en tu navegador (Safari, Chrome, etc.)
                        </p>
                        <button onclick="openInExternalBrowser()" class="text-xs bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg font-semibold transition-colors">
                            Abrir en navegador externo
                        </button>
                    </div>
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

@php
    // Calculate cents from the actual total to avoid rounding errors
    $totalCents = round($total * 100);
    $subtotalCents = round($subtotalWithIVA * 100);
    $shippingCents = $totalCents - $subtotalCents; // Use difference to match exact total
@endphp

@push('scripts')
<script src="https://cdn.payphonetodoesposible.com/box/v1.1/payphone-payment-box.js"></script>
<script>
    // Detect Instagram in-app browser
    function isInstagramBrowser() {
        const ua = navigator.userAgent || navigator.vendor || window.opera;
        return (ua.indexOf('Instagram') > -1);
    }

    // Open current page in external browser
    function openInExternalBrowser() {
        const currentUrl = window.location.href;

        // Try to open in external browser
        // For iOS: This will prompt to open in Safari
        // For Android: This will prompt to open in Chrome/default browser
        window.location.href = currentUrl;

        // Also copy URL to clipboard as fallback
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(currentUrl).then(function() {
                alert('URL copiada al portapapeles. Pégala en tu navegador (Safari, Chrome, etc.)');
            }).catch(function() {
                alert('Por favor copia esta URL y ábrela en tu navegador:\n\n' + currentUrl);
            });
        } else {
            alert('Por favor copia esta URL y ábrela en tu navegador:\n\n' + currentUrl);
        }
    }

    // Show warning if in Instagram browser
    if (isInstagramBrowser()) {
        document.getElementById('instagram-warning').classList.remove('hidden');
        console.warn('Instagram in-app browser detected. Payment may not work correctly.');
    }

    // Multiple initialization strategies for better compatibility with in-app browsers
    function initializePayPhone() {
        // Check if PayPhone is loaded
        if (typeof PPaymentButtonBox === 'undefined') {
            console.log('PayPhone not loaded yet, retrying...');
            setTimeout(initializePayPhone, 100);
            return;
        }

        try {
            // Initialize PayPhone Payment Box
            // Amount = AmountWithTax + AmountWithoutTax + Tax + Service + Tip
            const subtotalCents = {{ $subtotalCents }};
            const shippingCents = {{ $shippingCents }};
            const totalCents = {{ $totalCents }};

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

            console.log('PayPhone initialized successfully with:', {
                amount: totalCents,
                amountWithoutTax: subtotalCents,
                service: shippingCents,
                total: totalCents,
                validation: subtotalCents + shippingCents === totalCents,
                responseUrl: '{{ route('checkout.payphone.confirm') }}',
                clientTransactionId: '{{ $clientTransactionId }}'
            });
        } catch (error) {
            console.error('Error initializing PayPhone:', error);
        }
    }

    // Try multiple initialization events for better compatibility
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializePayPhone);
    } else {
        // DOM is already loaded
        initializePayPhone();
    }

    // Fallback for in-app browsers that might not fire DOMContentLoaded
    window.addEventListener('load', function() {
        if (typeof PPaymentButtonBox !== 'undefined' && !document.querySelector('#pp-button iframe')) {
            initializePayPhone();
        }
    });
</script>
@endpush
