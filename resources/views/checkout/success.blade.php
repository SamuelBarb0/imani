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
        </div>

        @if($order->payment_method === 'transfer')
            <!-- PASO 1 - Realizar la transferencia -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-6 border-l-4 border-dark-turquoise">
                <div class="flex items-start mb-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-dark-turquoise rounded-full flex items-center justify-center mr-4">
                        <span class="text-white font-bold text-lg">$</span>
                    </div>
                    <h2 class="font-spartan text-xl font-bold text-dark-turquoise pt-1">PASO 1 - REALIZA LA TRANSFERENCIA</h2>
                </div>
                <div class="ml-14 space-y-1 text-gray-700">
                    <p><strong>Banco de Guayaquil S.A.</strong></p>
                    <p>Nombre: Julia Schulz</p>
                    <p>Cédula: 1761553880</p>
                    <p>Cuenta de ahorros: 50599480</p>
                </div>
            </div>

            <!-- PASO 2 - Enviar comprobante -->
            <div class="bg-yellow-50 rounded-lg shadow-lg p-8 mb-6 border-l-4 border-gray-orange">
                <div class="flex items-start mb-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-gray-orange rounded-full flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="flex-grow">
                        <h2 class="font-spartan text-xl font-bold text-dark-turquoise mb-1">PASO 2 - ENVÍA TU COMPROBANTE <span class="text-red-600">(OBLIGATORIO)</span></h2>
                    </div>
                </div>
                <div class="ml-14">
                    <p class="text-gray-700 mb-3">Envía tu comprobante de pago lo antes posible por correo o WhatsApp:</p>
                    <div class="space-y-1 text-gray-700 mb-3">
                        <p><strong>Email:</strong> <a href="mailto:comprobantes@imanimagnets.com" class="text-dark-turquoise hover:underline">comprobantes@imanimagnets.com</a></p>
                        <p><strong>WhatsApp:</strong> <a href="https://wa.me/593985959303" class="text-green-600 hover:underline" target="_blank">+593 98 595 9303</a></p>
                    </div>
                    <p class="text-gray-700">Indica tu nombre y número de pedido <strong class="text-dark-turquoise">{{ $order->order_number }}</strong></p>
                </div>
            </div>
        @endif

        @if(in_array($order->payment_method, ['payphone', 'payphone_box']))
            <!-- INFORMACIÓN DE CUENTA (PAYPHONE) - Antes de detalles -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
                <div class="flex items-start mb-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-dark-turquoise rounded-full flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h2 class="font-spartan text-xl font-bold text-dark-turquoise pt-1">TU CUENTA</h2>
                </div>

                <div class="ml-14 space-y-4">
                    <!-- Cuenta creada -->
                    <div>
                        <h3 class="font-bold text-dark-turquoise mb-1">CUENTA CREADA:</h3>
                        <p class="text-gray-700 text-sm">
                            Se ha creado una cuenta para <strong>{{ $order->customer_email }}</strong>. Te llegará un correo con la contraseña para que puedas acceder y consultar el estado de tu orden y el historial de tus pedidos.
                        </p>
                    </div>

                    <!-- Emails enviados -->
                    <div>
                        <h3 class="font-bold text-dark-turquoise mb-1">CORREOS ELECTRÓNICOS:</h3>
                        <p class="text-gray-700 text-sm">
                            Hemos enviado a <strong>{{ $order->customer_email }}</strong> los siguientes correos:
                        </p>
                        <ul class="list-disc list-inside text-gray-700 text-sm mt-2 ml-4">
                            <li>Confirmación de pedido con los detalles de tu compra</li>
                            <li>Credenciales de acceso a tu cuenta</li>
                        </ul>
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
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-brown">IVA (15%):</span>
                        <span class="font-semibold">${{ number_format($order->tax, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-lg pt-2 border-t border-gray-200">
                        <span class="font-spartan font-bold text-dark-turquoise">Total:</span>
                        <span class="font-spartan font-bold text-dark-turquoise">${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>

        </div>

        @if($order->payment_method === 'transfer')
            <!-- ¿QUÉ SIGUE? (TRANSFERENCIA) - Después de detalles -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
                <div class="flex items-start mb-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-gray-orange rounded-full flex items-center justify-center mr-4">
                        <span class="text-white font-bold text-2xl">?</span>
                    </div>
                    <h2 class="font-spartan text-xl font-bold text-dark-turquoise pt-1">¿QUÉ SIGUE?</h2>
                </div>

                <div class="ml-14 space-y-4">
                    <!-- Confirmación por correo -->
                    <div>
                        <h3 class="font-bold text-dark-turquoise mb-1">CONFIRMACIÓN POR CORREO:</h3>
                        <p class="text-gray-700 text-sm">
                            Te enviaremos un correo a <strong>{{ $order->customer_email }}</strong> cuando verifiquemos tu pago, indicándote los próximos pasos.
                        </p>
                    </div>

                    <!-- Cuenta creada -->
                    <div>
                        <h3 class="font-bold text-dark-turquoise mb-1">CUENTA CREADA:</h3>
                        <p class="text-gray-700 text-sm">
                            Se ha creado una cuenta para <strong>{{ $order->customer_email }}</strong>. Te llegará un correo con la contraseña para que puedas acceder y consultar el estado de tu orden y el historial de tus pedidos.
                        </p>
                    </div>
                </div>
            </div>
        @endif

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
