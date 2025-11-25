@extends('layouts.app')

@section('title', 'Gestión de Pedidos - Admin')

@section('content')

<section class="bg-gradient-to-r from-dark-turquoise to-dark-turquoise-alt py-6">
    <div class="container mx-auto px-6 max-w-7xl">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="font-spartan text-3xl font-bold text-dark-turquoise mb-2">
                    GESTIÓN DE PEDIDOS
                </h1>
                <p class="text-gray-900">Total: {{ $orders->total() }} pedidos</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-white text-dark-turquoise rounded-full font-semibold text-sm hover:bg-gray-100">
                ← Volver al Dashboard
            </a>
        </div>
    </div>
</section>

<section class="bg-gray-50 py-8">
    <div class="container mx-auto px-6 max-w-7xl">

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <form method="GET" action="{{ route('admin.orders.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-brown mb-2">Buscar</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="# Pedido, email, nombre..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-brown mb-2">Estado</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise">
                        <option value="">Todos</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pendiente</option>
                        <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>En Proceso</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completado</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-brown mb-2">Estado Pago</label>
                    <select name="payment_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise">
                        <option value="">Todos</option>
                        <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>Pendiente</option>
                        <option value="completed" {{ request('payment_status') === 'completed' ? 'selected' : '' }}>Completado</option>
                        <option value="failed" {{ request('payment_status') === 'failed' ? 'selected' : '' }}>Fallido</option>
                        <option value="refunded" {{ request('payment_status') === 'refunded' ? 'selected' : '' }}>Reembolsado</option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-dark-turquoise text-white rounded-lg font-semibold hover:bg-dark-turquoise-alt">
                        Filtrar
                    </button>
                    <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-gray-200 text-gray-brown rounded-lg font-semibold hover:bg-gray-300">
                        Limpiar
                    </a>
                </div>
            </form>
        </div>

        <!-- Orders Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            @if($orders->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-brown uppercase">Pedido</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-brown uppercase">Cliente</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-brown uppercase">Fecha</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-brown uppercase">Total</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-brown uppercase">Estado</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-brown uppercase">Pago</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-brown uppercase">Factura</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-brown uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-3 px-4">
                                        <p class="font-semibold text-sm">#{{ $order->order_number }}</p>
                                        <p class="text-xs text-gray-500">{{ $order->items->count() }} producto(s)</p>
                                    </td>
                                    <td class="py-3 px-4">
                                        <p class="text-sm">{{ $order->customer_name }}</p>
                                        <p class="text-xs text-gray-500">{{ $order->customer_email }}</p>
                                    </td>
                                    <td class="py-3 px-4 text-sm">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="py-3 px-4 text-sm font-semibold">${{ number_format($order->total, 2) }}</td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                                            @if($order->status === 'completed') bg-green-100 text-green-800
                                            @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                            @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                                            @if($order->payment_status === 'completed') bg-green-100 text-green-800
                                            @elseif($order->payment_status === 'pending') bg-yellow-100 text-yellow-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        @if($order->status === 'shipped' || $order->status === 'completed')
                                            <span class="text-sm font-semibold text-green-600">Enviada</span>
                                        @else
                                            <form action="{{ route('admin.orders.mark-shipped', $order->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="px-3 py-1.5 bg-dark-turquoise text-white text-xs font-semibold rounded hover:bg-dark-turquoise-alt transition-colors">
                                                    Marcar Enviada
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex gap-2">
                                            <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-600 hover:text-blue-800">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.orders.edit', $order->id) }}" class="text-yellow-600 hover:text-yellow-800">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.orders.delete', $order->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este pedido?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-4">
                    {{ $orders->links() }}
                </div>
            @else
                <p class="text-gray-500 text-center py-12">No se encontraron pedidos</p>
            @endif
        </div>

    </div>
</section>

@endsection
