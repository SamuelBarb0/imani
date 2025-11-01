@extends('layouts.app')

@section('title', 'Detalle del Pedido - Imani Magnets')

@section('content')

<section class="bg-white py-4">
    <div class="container mx-auto px-6 max-w-6xl text-center">
        <h1 class="font-spartan text-2xl lg:text-3xl font-bold text-dark-turquoise mb-2">
            DETALLE DEL PEDIDO
        </h1>
        <p class="text-sm text-gray-brown">
            #{{ $order->order_number }}
        </p>
    </div>
</section>

<section class="bg-gray-50 py-12">
    <div class="container mx-auto px-6 max-w-4xl">

        <div class="mb-6">
            <a href="{{ route('user.orders') }}" class="text-dark-turquoise hover:underline">
                ← Volver a Mis Pedidos
            </a>
        </div>

        <!-- Order Info -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="font-spartan text-lg font-bold text-dark-turquoise mb-4">
                        Información del Pedido
                    </h2>
                    <div class="space-y-2">
                        <div>
                            <p class="text-xs font-semibold text-gray-brown">Número de Pedido:</p>
                            <p class="text-sm">{{ $order->order_number }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-brown">Fecha:</p>
                            <p class="text-sm">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-brown">Estado del Pedido:</p>
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                                @if($order->status === 'completed') bg-green-100 text-green-800
                                @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-brown">Estado del Pago:</p>
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                                @if($order->payment_status === 'completed') bg-green-100 text-green-800
                                @elseif($order->payment_status === 'pending') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-brown">Método de Pago:</p>
                            <p class="text-sm">{{ ucfirst($order->payment_method) }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="font-spartan text-lg font-bold text-dark-turquoise mb-4">
                        Información de Envío
                    </h2>
                    <div class="space-y-2">
                        <div>
                            <p class="text-xs font-semibold text-gray-brown">Nombre:</p>
                            <p class="text-sm">{{ $order->customer_name }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-brown">Dirección:</p>
                            <p class="text-sm">{{ $order->shipping_address }}</p>
                            <p class="text-sm">{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}</p>
                            <p class="text-sm">{{ $order->shipping_country }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-brown">Teléfono:</p>
                            <p class="text-sm">{{ $order->customer_phone }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-brown">Email:</p>
                            <p class="text-sm">{{ $order->customer_email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="font-spartan text-lg font-bold text-dark-turquoise mb-4">
                Productos
            </h2>
            <div class="space-y-4">
                @foreach($order->items as $item)
                    <div class="flex justify-between items-center border-b border-gray-200 pb-4">
                        <div class="flex-1">
                            <p class="font-semibold">{{ $item->product_name }}</p>
                            <p class="text-sm text-gray-brown">Cantidad: {{ $item->quantity }}</p>
                            <p class="text-sm text-gray-brown">Precio unitario: ${{ number_format($item->price, 2) }}</p>
                        </div>
                        <p class="font-bold text-dark-turquoise">${{ number_format($item->subtotal, 2) }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Order Summary -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="font-spartan text-lg font-bold text-dark-turquoise mb-4">
                Resumen del Pedido
            </h2>
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-brown">Subtotal:</span>
                    <span>${{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-brown">Envío:</span>
                    <span>${{ number_format($order->shipping_cost, 2) }}</span>
                </div>
                @if($order->tax > 0)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-brown">Impuestos:</span>
                        <span>${{ number_format($order->tax, 2) }}</span>
                    </div>
                @endif
                <div class="border-t border-gray-200 pt-3 flex justify-between">
                    <span class="font-spartan font-bold text-dark-turquoise text-lg">Total:</span>
                    <span class="font-spartan text-xl font-bold text-dark-turquoise">${{ number_format($order->total, 2) }}</span>
                </div>
            </div>

            @if($order->notes)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <p class="text-xs font-semibold text-gray-brown mb-2">Notas:</p>
                    <p class="text-sm">{{ $order->notes }}</p>
                </div>
            @endif
        </div>

    </div>
</section>

@endsection
