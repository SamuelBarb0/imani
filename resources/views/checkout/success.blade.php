@extends('layouts.app')

@section('title', 'Pedido Confirmado - Imani Magnets')

@section('content')

<!-- Success Section -->
<section class="bg-gray-50 py-12">
    <div class="container mx-auto px-6 max-w-4xl">

        <!-- Success Icon and Message -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-6 text-center">
            <!-- Success Icon -->
            @if($order->payment_method === 'transfer')
                <!-- Pending Icon for Transfer -->
                <div class="inline-flex items-center justify-center w-20 h-20 bg-yellow-100 rounded-full mb-4">
                    <svg class="w-12 h-12 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            @else
                <!-- Success Icon for other payments -->
                <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                    <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            @endif

            <h1 class="font-spartan text-3xl font-bold text-dark-turquoise mb-2">
                @if($order->payment_method === 'transfer')
                    ¡PEDIDO RECIBIDO!
                @else
                    ¡PEDIDO CONFIRMADO!
                @endif
            </h1>
            <p class="text-gray-brown mb-6">
                @if($order->payment_method === 'transfer')
                    Gracias por tu compra. Tu pedido está <strong class="text-yellow-600">PENDIENTE</strong> hasta que verifiquemos tu comprobante de pago.
                @else
                    Gracias por tu compra. Tu pedido ha sido procesado exitosamente.
                @endif
            </p>

            <!-- Order Number -->
            <div class="inline-block bg-gray-100 px-6 py-3 rounded-lg">
                <p class="text-sm text-gray-brown">Número de pedido:</p>
                <p class="font-spartan text-2xl font-bold text-dark-turquoise">{{ $order->order_number }}</p>
            </div>

            @if($order->payment_method === 'transfer')
                <!-- Status Badge for Transfer -->
                <div class="mt-4 inline-flex items-center px-4 py-2 bg-yellow-100 border-2 border-yellow-300 rounded-full">
                    <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-semibold text-yellow-800 text-sm">Estado: PENDIENTE DE VERIFICACIÓN</span>
                </div>
            @endif
        </div>

        @if($order->payment_method === 'transfer')
            <!-- Transfer Payment Alert -->
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 mb-6 rounded-lg">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-yellow-600 mr-3 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div class="flex-grow">
                        <h3 class="font-bold text-yellow-900 text-lg mb-2">Tu pedido está PENDIENTE de verificación</h3>
                        <p class="text-yellow-800 text-sm mb-3">
                            Tu pedido ha sido registrado exitosamente pero <strong>NO será procesado</strong> hasta que verifiquemos tu comprobante de pago.
                        </p>
                        <div class="bg-white p-4 rounded border border-yellow-200">
                            <p class="font-semibold text-yellow-900 text-sm mb-2">📤 ¿Ya realizaste la transferencia?</p>
                            <p class="text-yellow-800 text-xs mb-2">Envía tu comprobante de pago lo antes posible a:</p>
                            <div class="flex flex-col space-y-1 text-sm">
                                <p class="text-yellow-900">
                                    <strong>📧 Email:</strong>
                                    <a href="mailto:comprobantes@imanimagnets.com?subject=Comprobante - Orden {{ $order->order_number }}" class="text-dark-turquoise hover:underline font-semibold">
                                        comprobantes@imanimagnets.com
                                    </a>
                                </p>
                                <p class="text-yellow-900"><strong>📋 Asunto:</strong> Comprobante - Orden {{ $order->order_number }}</p>
                            </div>
                        </div>
                        <p class="text-yellow-700 text-xs mt-3 italic">
                            ⏱️ Una vez recibamos y verifiquemos tu comprobante, procesaremos tu pedido y te enviaremos una confirmación por email.
                        </p>

                        <div class="mt-3 p-3 bg-blue-50 rounded border border-blue-200">
                            <p class="font-semibold text-blue-900 text-xs mb-2">📧 Confirmación por Email</p>
                            <p class="text-blue-800 text-xs">
                                Recibirás un correo de confirmación en <strong>{{ $order->customer_email }}</strong> con los detalles de tu pedido y el estado actual.
                            </p>
                        </div>

                        <div class="mt-3 p-3 bg-green-50 rounded border border-green-200">
                            <p class="font-semibold text-green-900 text-xs mb-2">✅ ¡Cuenta Creada Automáticamente!</p>
                            <p class="text-green-800 text-xs mb-2">
                                Se ha creado una cuenta para <strong class="text-green-900">{{ $order->customer_email }}</strong> al realizar tu pedido.
                            </p>
                            <p class="text-green-700 text-xs">
                                💡 <strong>Accede ahora:</strong> Inicia sesión con tu email para ver el estado actualizado de este pedido y todos tus futuros pedidos en tiempo real.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Order Details -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
            <h2 class="font-spartan text-xl font-bold text-dark-turquoise mb-4 pb-3 border-b border-gray-200">
                DETALLES DEL PEDIDO
            </h2>

            <!-- Customer Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="font-semibold text-gray-brown text-sm mb-2">Información de Contacto</h3>
                    <p class="text-gray-800">{{ $order->customer_name }}</p>
                    <p class="text-gray-600 text-sm">{{ $order->customer_email }}</p>
                    @if($order->customer_phone)
                        <p class="text-gray-600 text-sm">{{ $order->customer_phone }}</p>
                    @endif
                </div>

                <div>
                    <h3 class="font-semibold text-gray-brown text-sm mb-2">Dirección de Envío</h3>
                    <p class="text-gray-800 text-sm">{{ $order->shipping_address }}</p>
                    <p class="text-gray-600 text-sm">
                        {{ $order->shipping_city }}{{ $order->shipping_state ? ', ' . $order->shipping_state : '' }}
                    </p>
                    <p class="text-gray-600 text-sm">{{ $order->shipping_zip }}, {{ $order->shipping_country }}</p>
                </div>
            </div>

            <!-- Order Items -->
            <div class="mb-6">
                <h3 class="font-semibold text-gray-brown text-sm mb-3">Productos</h3>
                <div class="space-y-2">
                    @foreach($order->items as $item)
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <div class="flex-grow">
                                <p class="font-semibold text-gray-800">{!! preg_replace('/<span[^>]*>.*?<\/span>/i', '', nl2br($item->product_name)) !!}</p>
                                <p class="text-xs text-gray-brown">Cantidad: {{ $item->quantity }}</p>
                                @if($item->product_id === 'custom-magnets-9')
                                    <p class="text-xs text-green-600 mt-1">
                                        ✓ Template de impresión en proceso
                                    </p>
                                @endif
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
                        <span class="font-spartan font-bold text-dark-turquoise">Total:</span>
                        <span class="font-spartan font-bold text-dark-turquoise">${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Info -->
            <div class="mt-6 p-4 @if($order->payment_method === 'payphone' || $order->payment_method === 'transfer') bg-yellow-50 @else bg-blue-50 @endif rounded-lg">
                <div class="flex items-start">
                    <svg class="w-5 h-5 @if($order->payment_method === 'payphone' || $order->payment_method === 'transfer') text-yellow-500 @else text-blue-500 @endif mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="flex-grow">
                        <p class="font-semibold @if($order->payment_method === 'payphone' || $order->payment_method === 'transfer') text-yellow-800 @else text-blue-800 @endif text-sm">Método de Pago</p>
                        <p class="@if($order->payment_method === 'payphone' || $order->payment_method === 'transfer') text-yellow-700 @else text-blue-700 @endif text-sm">
                            @if($order->payment_method === 'payphone')
                                PayPhone - Pendiente de confirmación
                            @elseif($order->payment_method === 'transfer')
                                Transferencia Bancaria - Pendiente de confirmación
                            @else
                                {{ ucfirst($order->payment_method) }}
                            @endif
                        </p>
                        @if($order->transaction_id)
                            <p class="@if($order->payment_method === 'payphone' || $order->payment_method === 'transfer') text-yellow-600 @else text-blue-600 @endif text-xs mt-1">ID de Transacción: {{ $order->transaction_id }}</p>
                        @endif

                        @if($order->payment_method === 'payphone' || $order->payment_method === 'transfer')
                            <div class="mt-3 p-3 bg-white rounded border-2 border-yellow-200">
                                <p class="font-bold text-yellow-900 text-sm mb-2">⏰ IMPORTANTE - Tienes 1 hora para completar el pago</p>
                                <p class="text-yellow-800 text-xs mb-2">
                                    Envía el comprobante de pago por:
                                </p>
                                <ul class="text-yellow-800 text-xs space-y-1 ml-4">
                                    <li>📱 <strong>WhatsApp:</strong> [Número de WhatsApp]</li>
                                    <li>📧 <strong>Email:</strong> comprobantes@imanimagnets.com</li>
                                </ul>
                                <p class="text-yellow-800 text-xs mt-2 font-semibold">
                                    📋 Indica tu número de orden: <span class="bg-yellow-100 px-2 py-1 rounded">{{ $order->order_number }}</span> o el correo usado: <span class="bg-yellow-100 px-2 py-1 rounded">{{ $order->customer_email }}</span>
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="text-center space-x-4">
            <a href="{{ route('home') }}" class="inline-block px-8 py-3 bg-gray-orange text-white rounded-full font-spartan font-semibold text-sm tracking-wider uppercase hover:bg-gray-brown transition-all duration-300">
                VOLVER AL INICIO
            </a>
            <a href="{{ route('personalizados.index') }}" class="inline-block px-8 py-3 bg-white border-2 border-gray-orange text-gray-orange rounded-full font-spartan font-semibold text-sm tracking-wider uppercase hover:bg-gray-orange hover:text-white transition-all duration-300">
                CREAR OTRO SET
            </a>
        </div>

    </div>
</section>

@endsection
