@extends('layouts.app')

@section('title', 'Pago Pendiente - Imani Magnets')

@section('content')

<!-- Pending Payment Section -->
<section class="bg-gray-50 py-12">
    <div class="container mx-auto px-6 max-w-4xl">

        <!-- Pending Icon and Message -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-6 text-center">
            <!-- Pending Icon -->
            <div class="inline-flex items-center justify-center w-20 h-20 bg-yellow-100 rounded-full mb-4">
                <svg class="w-12 h-12 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            <h1 class="font-spartan text-3xl font-bold text-dark-turquoise mb-2">
                PAGO PENDIENTE
            </h1>
            <p class="text-gray-brown mb-6">
                Tu pedido ha sido creado. Por favor confirma el pago en tu app PayPhone.
            </p>

            <!-- Order Number -->
            <div class="inline-block bg-gray-100 px-6 py-3 rounded-lg">
                <p class="text-sm text-gray-brown">Número de pedido:</p>
                <p class="font-spartan text-2xl font-bold text-dark-turquoise">{{ $order->order_number }}</p>
            </div>

            <!-- Payment Status Check -->
            <div id="payment-status" class="mt-6">
                <div class="inline-flex items-center space-x-2 text-yellow-600">
                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-sm font-semibold">Esperando confirmación de pago...</span>
                </div>
            </div>
        </div>

        <!-- PayPhone Instructions -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
            <div class="bg-yellow-50 border-2 border-yellow-300 rounded-lg p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4 flex-grow">
                        <h3 class="font-spartan text-lg font-bold text-yellow-900 mb-3">
                            INSTRUCCIONES PAYPHONE
                        </h3>
                        <ol class="space-y-3 text-yellow-800">
                            <li class="flex items-start">
                                <span class="flex-shrink-0 w-6 h-6 bg-yellow-500 text-white rounded-full flex items-center justify-center text-xs font-bold mr-2">1</span>
                                <span>Abre tu aplicación PayPhone en tu teléfono</span>
                            </li>
                            <li class="flex items-start">
                                <span class="flex-shrink-0 w-6 h-6 bg-yellow-500 text-white rounded-full flex items-center justify-center text-xs font-bold mr-2">2</span>
                                <span>Revisa la notificación de pago que recibiste</span>
                            </li>
                            <li class="flex items-start">
                                <span class="flex-shrink-0 w-6 h-6 bg-yellow-500 text-white rounded-full flex items-center justify-center text-xs font-bold mr-2">3</span>
                                <span>Confirma el pago usando tu huella digital o PIN</span>
                            </li>
                            <li class="flex items-start">
                                <span class="flex-shrink-0 w-6 h-6 bg-yellow-500 text-white rounded-full flex items-center justify-center text-xs font-bold mr-2">4</span>
                                <span>Tu pedido será procesado automáticamente</span>
                            </li>
                        </ol>

                        <div class="mt-4 p-3 bg-white rounded border border-yellow-300">
                            <p class="text-sm text-yellow-900 font-semibold">
                                ⏰ Tienes 5 minutos para confirmar el pago antes de que expire la solicitud.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Details -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
            <h2 class="font-spartan text-xl font-bold text-dark-turquoise mb-4 pb-3 border-b border-gray-200">
                DETALLES DEL PEDIDO
            </h2>

            <!-- Order Items -->
            <div class="mb-6">
                <h3 class="font-semibold text-gray-brown text-sm mb-3">Productos</h3>
                <div class="space-y-2">
                    @foreach($order->items as $item)
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <div class="flex-grow">
                                <p class="font-semibold text-gray-800">{!! preg_replace('/<span[^>]*>.*?<\/span>/i', '', nl2br($item->product_name)) !!}</p>
                                <p class="text-xs text-gray-brown">Cantidad: {{ $item->quantity }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-dark-turquoise">${{ number_format($item->subtotal, 2) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Totals -->
            <div class="border-t border-gray-200 pt-4">
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-brown">Subtotal:</span>
                        <span class="font-semibold">${{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-brown">Envío:</span>
                        <span class="font-semibold">${{ number_format($order->shipping_cost, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-lg pt-2 border-t border-gray-200">
                        <span class="font-spartan font-bold text-dark-turquoise">Total a Pagar:</span>
                        <span class="font-spartan font-bold text-dark-turquoise">${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Support -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
            <h3 class="font-spartan text-lg font-bold text-dark-turquoise mb-3">
                ¿NECESITAS AYUDA?
            </h3>
            <p class="text-gray-brown text-sm mb-4">
                Si tienes problemas para completar el pago o no recibiste la notificación de PayPhone, contáctanos:
            </p>
            <div class="space-y-2 text-sm">
                <p class="text-gray-800">
                    📱 <strong>WhatsApp:</strong> <a href="https://wa.me/593XXXXXXXXX" class="text-dark-turquoise hover:underline">+593 XX XXX XXXX</a>
                </p>
                <p class="text-gray-800">
                    📧 <strong>Email:</strong> <a href="mailto:soporte@imanimagnets.com" class="text-dark-turquoise hover:underline">soporte@imanimagnets.com</a>
                </p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="text-center">
            <a href="{{ route('home') }}" class="inline-block px-8 py-3 bg-gray-orange text-white rounded-full font-spartan font-semibold text-sm tracking-wider uppercase hover:bg-gray-brown transition-all duration-300">
                VOLVER AL INICIO
            </a>
        </div>

    </div>
</section>

<script>
    // Auto-check payment status every 5 seconds
    let checkInterval;
    let attempts = 0;
    const maxAttempts = 60; // 5 minutes (60 * 5 seconds)

    function checkPaymentStatus() {
        attempts++;

        if (attempts > maxAttempts) {
            clearInterval(checkInterval);
            document.getElementById('payment-status').innerHTML = `
                <div class="inline-flex items-center space-x-2 text-red-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span class="text-sm font-semibold">El tiempo de espera ha expirado. Contacta soporte si completaste el pago.</span>
                </div>
            `;
            return;
        }

        fetch('{{ route("checkout.status", $order->order_number) }}')
            .then(response => response.json())
            .then(data => {
                if (data.success && data.status === 'approved') {
                    clearInterval(checkInterval);
                    document.getElementById('payment-status').innerHTML = `
                        <div class="inline-flex items-center space-x-2 text-green-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-sm font-semibold">¡Pago confirmado! Redirigiendo...</span>
                        </div>
                    `;
                    setTimeout(() => {
                        window.location.href = '{{ route("checkout.success", $order->order_number) }}';
                    }, 2000);
                }
            })
            .catch(error => {
                console.error('Error checking payment status:', error);
            });
    }

    // Start checking payment status
    checkInterval = setInterval(checkPaymentStatus, 5000);

    // Check immediately on page load
    checkPaymentStatus();
</script>

@endsection
