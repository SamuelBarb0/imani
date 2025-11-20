@extends('layouts.app')

@section('content')
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="font-spartan text-3xl font-bold text-dark-turquoise mb-2">
                        Pedido #{{ $order->order_number }}
                    </h1>
                    <p class="text-gray-600">
                        Realizado el {{ $order->created_at->format('d/m/Y') }} a las {{ $order->created_at->format('H:i') }}
                    </p>
                </div>
                <a href="{{ route('tracking.index') }}" class="text-dark-turquoise hover:underline font-semibold">
                    ← Rastrear otro pedido
                </a>
            </div>

            <!-- Order Status -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <h2 class="font-spartan text-xl font-bold text-dark-turquoise mb-4">Estado del Pedido</h2>

                <div class="flex items-center justify-between mb-6">
                    <div class="flex-1">
                        @php
                            $statusConfig = [
                                'pending' => [
                                    'label' => 'Pendiente',
                                    'color' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
                                    'icon' => '⏳'
                                ],
                                'processing' => [
                                    'label' => 'En Proceso',
                                    'color' => 'bg-blue-100 text-blue-800 border-blue-300',
                                    'icon' => '⚙️'
                                ],
                                'completed' => [
                                    'label' => 'Completado',
                                    'color' => 'bg-green-100 text-green-800 border-green-300',
                                    'icon' => '✅'
                                ],
                                'cancelled' => [
                                    'label' => 'Cancelado',
                                    'color' => 'bg-red-100 text-red-800 border-red-300',
                                    'icon' => '❌'
                                ]
                            ];

                            $paymentStatusConfig = [
                                'pending' => [
                                    'label' => 'Pago Pendiente',
                                    'color' => 'bg-yellow-100 text-yellow-800 border-yellow-300'
                                ],
                                'paid' => [
                                    'label' => 'Pagado',
                                    'color' => 'bg-green-100 text-green-800 border-green-300'
                                ],
                                'failed' => [
                                    'label' => 'Pago Fallido',
                                    'color' => 'bg-red-100 text-red-800 border-red-300'
                                ]
                            ];

                            $currentStatus = $statusConfig[$order->order_status] ?? $statusConfig['pending'];
                            $currentPaymentStatus = $paymentStatusConfig[$order->payment_status] ?? $paymentStatusConfig['pending'];
                        @endphp

                        <div class="inline-flex items-center px-4 py-2 rounded-lg border-2 {{ $currentStatus['color'] }} font-semibold text-lg">
                            <span class="mr-2">{{ $currentStatus['icon'] }}</span>
                            {{ $currentStatus['label'] }}
                        </div>
                    </div>
                </div>

                <!-- Payment Status -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Estado de Pago:</p>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm border {{ $currentPaymentStatus['color'] }} font-semibold">
                            {{ $currentPaymentStatus['label'] }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Método de Pago:</p>
                        <span class="text-gray-900 font-semibold">
                            {{ $order->payment_method === 'payphone' ? 'PayPhone (Tarjeta/Transferencia)' : 'Transferencia Bancaria' }}
                        </span>
                    </div>
                </div>

                <!-- Tracking Number -->
                @if($order->tracking_number)
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <p class="text-sm text-gray-700 mb-1">Número de Rastreo:</p>
                        <p class="text-xl font-mono font-bold text-dark-turquoise">{{ $order->tracking_number }}</p>
                        <p class="text-xs text-gray-600 mt-1">Usa este número para rastrear tu envío con la courier</p>
                    </div>
                @endif
            </div>

            <!-- Customer & Shipping Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Customer Info -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="font-spartan text-lg font-bold text-dark-turquoise mb-4">Información del Cliente</h3>
                    <div class="space-y-2 text-sm">
                        <div>
                            <span class="text-gray-600">Nombre:</span>
                            <span class="font-semibold ml-2">{{ $order->customer_name }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Email:</span>
                            <span class="font-semibold ml-2">{{ $order->customer_email }}</span>
                        </div>
                        @if($order->customer_phone)
                            <div>
                                <span class="text-gray-600">Teléfono:</span>
                                <span class="font-semibold ml-2">{{ $order->customer_phone }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Shipping Info -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="font-spartan text-lg font-bold text-dark-turquoise mb-4">Dirección de Envío</h3>
                    <div class="space-y-2 text-sm">
                        <p class="font-semibold">{{ $order->shipping_address }}</p>
                        <p>{{ $order->shipping_city }}, {{ $order->shipping_state }}</p>
                        <p>{{ $order->shipping_zip }}, {{ $order->shipping_country }}</p>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <h3 class="font-spartan text-lg font-bold text-dark-turquoise mb-4">Productos</h3>

                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="flex items-start border-b border-gray-200 pb-4 last:border-0 last:pb-0">
                            @if($item->template_path)
                                <div class="flex-shrink-0 w-20 h-20 bg-gray-100 rounded overflow-hidden mr-4">
                                    <img src="{{ asset('storage/' . str_replace('storage/', '', $item->template_path)) }}" alt="Producto" class="w-full h-full object-cover">
                                </div>
                            @else
                                <div class="flex-shrink-0 w-20 h-20 bg-gray-200 rounded flex items-center justify-center mr-4">
                                    <span class="text-3xl">🧲</span>
                                </div>
                            @endif

                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900">{{ strip_tags($item->product_name) }}</h4>
                                @if($item->product_type === 'personalized')
                                    <p class="text-xs text-gray-600 mt-1">Producto Personalizado</p>
                                @endif
                                <div class="flex items-center mt-2 text-sm">
                                    <span class="text-gray-600">Cantidad:</span>
                                    <span class="ml-2 font-semibold">{{ $item->quantity }}</span>
                                    <span class="mx-2">×</span>
                                    <span class="font-semibold">${{ number_format($item->unit_price, 2) }}</span>
                                </div>
                            </div>

                            <div class="text-right">
                                <p class="font-spartan font-bold text-dark-turquoise text-lg">
                                    ${{ number_format($item->subtotal, 2) }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Summary -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="font-spartan text-lg font-bold text-dark-turquoise mb-4">Resumen del Pedido</h3>

                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Subtotal:</span>
                        <span class="font-semibold">${{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Envío:</span>
                        <span class="font-semibold">${{ number_format($order->shipping_cost, 2) }}</span>
                    </div>
                    @if($order->tax > 0)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Impuestos:</span>
                            <span class="font-semibold">${{ number_format($order->tax, 2) }}</span>
                        </div>
                    @endif
                    <div class="border-t border-gray-200 pt-3 flex justify-between">
                        <span class="font-spartan font-bold text-dark-turquoise text-lg">Total:</span>
                        <span class="font-spartan text-2xl font-bold text-dark-turquoise">
                            ${{ number_format($order->total, 2) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            @if($order->notes)
                <div class="bg-gray-100 rounded-lg p-6 mt-6">
                    <h3 class="font-spartan text-lg font-bold text-dark-turquoise mb-2">Notas del Pedido</h3>
                    <p class="text-gray-700">{{ $order->notes }}</p>
                </div>
            @endif

            <!-- Help Section -->
            <div class="mt-8 text-center bg-blue-50 rounded-lg p-6">
                <p class="text-gray-700 mb-2">
                    ¿Necesitas ayuda con tu pedido?
                </p>
                <a href="{{ route('contacto') }}" class="text-dark-turquoise hover:underline font-semibold">
                    Contáctanos →
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
