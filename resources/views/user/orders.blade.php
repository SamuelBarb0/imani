@extends('layouts.app')

@section('title', 'Mis Pedidos - Imani Magnets')

@section('content')

<section class="bg-white py-4">
    <div class="container mx-auto px-6 max-w-6xl text-center">
        <h1 class="font-spartan text-2xl lg:text-3xl font-bold text-dark-turquoise mb-2">
            MIS PEDIDOS
        </h1>
        <p class="text-sm text-gray-brown">
            Historial completo de tus compras
        </p>
    </div>
</section>

<section class="bg-gray-50 py-12">
    <div class="container mx-auto px-6 max-w-6xl">

        <div class="mb-6">
            <a href="{{ route('user.profile') }}" class="text-dark-turquoise hover:underline">
                ← Volver a Mi Perfil
            </a>
        </div>

        @if($orders->count() > 0)
            <div class="space-y-4">
                @foreach($orders as $order)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex flex-col md:flex-row md:justify-between md:items-start mb-4">
                            <div>
                                <h3 class="font-spartan text-lg font-bold text-dark-turquoise">
                                    Pedido #{{ $order->order_number }}
                                </h3>
                                <p class="text-sm text-gray-brown">
                                    Realizado el {{ $order->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                            <div class="mt-2 md:mt-0 flex gap-2">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($order->payment_status === 'completed') bg-green-100 text-green-800
                                    @elseif($order->payment_status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    Pago: {{ ucfirst($order->payment_status) }}
                                </span>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($order->status === 'completed') bg-green-100 text-green-800
                                    @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                    @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    Estado: {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <p class="text-xs font-semibold text-gray-brown">PRODUCTOS</p>
                                    <p class="text-sm">{{ $order->items->count() }} artículo(s)</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-brown">MÉTODO DE PAGO</p>
                                    <p class="text-sm">{{ ucfirst($order->payment_method) }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-brown">TOTAL</p>
                                    <p class="text-lg font-bold text-dark-turquoise">${{ number_format($order->total, 2) }}</p>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <a href="{{ route('user.order.show', $order->order_number) }}" class="px-4 py-2 bg-gray-orange text-white rounded-full font-spartan font-semibold text-xs tracking-wider uppercase hover:bg-gray-brown transition-all duration-300">
                                    VER DETALLES
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <p class="text-gray-500 mb-4">No tienes pedidos aún</p>
                <a href="{{ route('personalizados') }}" class="inline-block px-6 py-3 bg-gray-orange text-white rounded-full font-spartan font-semibold text-sm tracking-wider uppercase hover:bg-gray-brown transition-all duration-300">
                    EXPLORAR PRODUCTOS
                </a>
            </div>
        @endif

    </div>
</section>

@endsection
