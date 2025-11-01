@extends('layouts.app')

@section('title', 'Panel de Administración - Imani Magnets')

@section('content')

<!-- Hero Section -->
<section class="bg-gradient-to-r from-dark-turquoise to-dark-turquoise-alt py-6">
    <div class="container mx-auto px-6 max-w-7xl">
        <h1 class="font-spartan text-3xl font-bold text-white mb-2">
            PANEL DE ADMINISTRACIÓN
        </h1>
        <p class="text-white/80">
            Gestión de pedidos y usuarios
        </p>
    </div>
</section>

<!-- Dashboard Section -->
<section class="bg-gray-50 py-12">
    <div class="container mx-auto px-6 max-w-7xl">

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">

            <!-- Total Orders -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-brown mb-1">Total Pedidos</p>
                        <p class="text-3xl font-bold text-dark-turquoise">{{ $stats['total_orders'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pending Orders -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-brown mb-1">Pendientes</p>
                        <p class="text-3xl font-bold text-yellow-600">{{ $stats['pending_orders'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Processing Orders -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-brown mb-1">En Proceso</p>
                        <p class="text-3xl font-bold text-blue-600">{{ $stats['processing_orders'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Completed Orders -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-brown mb-1">Completados</p>
                        <p class="text-3xl font-bold text-green-600">{{ $stats['completed_orders'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Revenue -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-brown mb-1">Ingresos Totales</p>
                        <p class="text-3xl font-bold text-green-600">${{ number_format($stats['total_revenue'], 2) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Users -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-brown mb-1">Usuarios</p>
                        <p class="text-3xl font-bold text-dark-turquoise">{{ $stats['total_users'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <a href="{{ route('admin.orders.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <h3 class="font-spartan text-lg font-bold text-dark-turquoise mb-2">Gestionar Pedidos</h3>
                <p class="text-sm text-gray-brown">Ver, editar y administrar todos los pedidos</p>
            </a>
            <a href="{{ route('admin.users.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <h3 class="font-spartan text-lg font-bold text-dark-turquoise mb-2">Gestionar Usuarios</h3>
                <p class="text-sm text-gray-brown">Ver y administrar usuarios registrados</p>
            </a>
            <a href="{{ route('admin.collections.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <h3 class="font-spartan text-lg font-bold text-dark-turquoise mb-2">Gestionar Colecciones</h3>
                <p class="text-sm text-gray-brown">Crear, editar y administrar colecciones de imanes</p>
            </a>
            <a href="{{ route('admin.content.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <h3 class="font-spartan text-lg font-bold text-dark-turquoise mb-2">Gestionar Contenido</h3>
                <p class="text-sm text-gray-brown">Editar el contenido de las páginas del sitio</p>
            </a>
        </div>

        <!-- Recent Orders -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-spartan text-xl font-bold text-dark-turquoise">
                    Pedidos Recientes
                </h2>
                <a href="{{ route('admin.orders.index') }}" class="text-sm text-dark-turquoise hover:underline">
                    Ver todos →
                </a>
            </div>

            @if($recentOrders->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-brown uppercase">Pedido</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-brown uppercase">Cliente</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-brown uppercase">Fecha</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-brown uppercase">Total</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-brown uppercase">Estado</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-brown uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-3 px-4 text-sm">#{{ $order->order_number }}</td>
                                    <td class="py-3 px-4 text-sm">{{ $order->customer_name }}</td>
                                    <td class="py-3 px-4 text-sm">{{ $order->created_at->format('d/m/Y') }}</td>
                                    <td class="py-3 px-4 text-sm font-semibold">${{ number_format($order->total, 2) }}</td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                                            @if($order->status === 'completed') bg-green-100 text-green-800
                                            @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                            @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-dark-turquoise hover:underline text-sm">
                                            Ver detalles
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No hay pedidos recientes</p>
            @endif
        </div>

    </div>
</section>

@endsection
