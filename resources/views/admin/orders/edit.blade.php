@extends('layouts.app')

@section('title', 'Editar Pedido - Admin')

@section('content')

<section class="bg-gradient-to-r from-dark-turquoise to-dark-turquoise-alt py-6">
    <div class="container mx-auto px-6 max-w-4xl">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="font-spartan text-3xl font-bold text-white mb-2">
                    EDITAR PEDIDO #{{ $order->order_number }}
                </h1>
            </div>
            <a href="{{ route('admin.orders.show', $order->id) }}" class="px-4 py-2 bg-white text-dark-turquoise rounded-full font-semibold text-sm hover:bg-gray-100">
                ← Volver
            </a>
        </div>
    </div>
</section>

<section class="bg-gray-50 py-8">
    <div class="container mx-auto px-6 max-w-4xl">

        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Order Status -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-brown mb-2">Estado del Pedido *</label>
                    <select name="status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pendiente</option>
                        <option value="payment_received" {{ $order->status === 'payment_received' ? 'selected' : '' }}>Pago Recibido</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>En Proceso</option>
                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Enviado</option>
                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completado</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Estado actual del pedido</p>
                </div>

                <!-- Payment Status -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-brown mb-2">Estado del Pago *</label>
                    <select name="payment_status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise">
                        <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pendiente</option>
                        <option value="completed" {{ $order->payment_status === 'completed' ? 'selected' : '' }}>Completado</option>
                        <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Fallido</option>
                        <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>Reembolsado</option>
                    </select>
                    @error('payment_status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Estado del pago del pedido</p>
                </div>

                <!-- Admin Notes -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-brown mb-2">Notas Internas</label>
                    <textarea name="admin_notes" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise">{{ old('admin_notes', $order->admin_notes) }}</textarea>
                    @error('admin_notes')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Notas visibles solo para administradores</p>
                </div>

                <!-- Order Info (Read Only) -->
                <div class="border-t border-gray-200 pt-6 mb-6">
                    <h3 class="font-spartan text-lg font-bold text-dark-turquoise mb-4">Información del Pedido</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-xs font-semibold text-gray-brown">Cliente:</p>
                            <p>{{ $order->customer_name }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-brown">Email:</p>
                            <p>{{ $order->customer_email }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-brown">Total:</p>
                            <p class="font-bold text-dark-turquoise">${{ number_format($order->total, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-brown">Productos:</p>
                            <p>{{ $order->items->count() }} artículo(s)</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4">
                    <button type="submit" class="flex-1 px-6 py-3 bg-dark-turquoise text-white rounded-full font-spartan font-semibold text-sm tracking-wider uppercase hover:bg-dark-turquoise-alt transition-all duration-300">
                        GUARDAR CAMBIOS
                    </button>
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="flex-1 px-6 py-3 bg-gray-200 text-gray-brown text-center rounded-full font-spartan font-semibold text-sm tracking-wider uppercase hover:bg-gray-300 transition-all duration-300">
                        CANCELAR
                    </a>
                </div>

            </form>
        </div>

    </div>
</section>

@endsection
