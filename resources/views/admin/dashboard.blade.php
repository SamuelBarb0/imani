@extends('layouts.app')

@section('title', 'Panel de Administración - Imani Magnets')

@section('content')

<!-- Hero Section -->
<section class="bg-gradient-to-r from-dark-turquoise to-dark-turquoise-alt py-6">
    <div class="container mx-auto px-6 max-w-7xl">
        <h1 class="font-spartan text-3xl font-bold text-dark-turquoise mb-2">
            PANEL DE ADMINISTRACIÓN
        </h1>
        <p class="text-gray-900">
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
                        <p class="text-sm font-semibold text-gray-600 mb-1">Total Pedidos</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['total_orders'] }}</p>
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
                        <p class="text-sm font-semibold text-gray-600 mb-1">Pendientes</p>
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
                        <p class="text-sm font-semibold text-gray-600 mb-1">En Proceso</p>
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
                        <p class="text-sm font-semibold text-gray-600 mb-1">Completados</p>
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
                        <p class="text-sm font-semibold text-gray-600 mb-1">Ingresos Totales</p>
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
                        <p class="text-sm font-semibold text-gray-600 mb-1">Usuarios</p>
                        <p class="text-3xl font-bold text-purple-600">{{ $stats['total_users'] }}</p>
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
        <h2 class="font-spartan text-2xl font-bold text-gray-900 mb-6">Acciones Rápidas</h2>

        <!-- Gestión de Pedidos y Usuarios -->
        <div class="mb-6">
            <h3 class="font-spartan text-lg font-semibold text-gray-700 mb-4">Pedidos y Usuarios</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <a href="{{ route('admin.orders.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow border-l-4 border-blue-500">
                    <div class="flex items-center mb-2">
                        <svg class="w-6 h-6 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <h3 class="font-spartan text-lg font-bold text-dark-turquoise">Gestionar Pedidos</h3>
                    </div>
                    <p class="text-sm text-gray-600">Ver, editar y administrar todos los pedidos</p>
                </a>

                <a href="{{ route('admin.users.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow border-l-4 border-purple-500">
                    <div class="flex items-center mb-2">
                        <svg class="w-6 h-6 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <h3 class="font-spartan text-lg font-bold text-dark-turquoise">Gestionar Usuarios</h3>
                    </div>
                    <p class="text-sm text-gray-600">Ver y administrar usuarios registrados</p>
                </a>
            </div>
        </div>

        <!-- Gestión de Contenido -->
        <div class="mb-6">
            <h3 class="font-spartan text-lg font-semibold text-gray-700 mb-4">Contenido y Productos</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <a href="{{ route('admin.content.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow border-l-4 border-green-500">
                    <div class="flex items-center mb-2">
                        <svg class="w-6 h-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <h3 class="font-spartan text-lg font-bold text-dark-turquoise">Gestionar Contenido</h3>
                    </div>
                    <p class="text-sm text-gray-600">Editar el contenido de las páginas del sitio</p>
                </a>

                <a href="{{ route('admin.collections.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow border-l-4 border-indigo-500">
                    <div class="flex items-center mb-2">
                        <svg class="w-6 h-6 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <h3 class="font-spartan text-lg font-bold text-dark-turquoise">Gestionar Colecciones</h3>
                    </div>
                    <p class="text-sm text-gray-600">Crear, editar y administrar colecciones de imanes</p>
                </a>
            </div>
        </div>

        <!-- Gestión de Envíos -->
        <div class="mb-6">
            <h3 class="font-spartan text-lg font-semibold text-gray-700 mb-4">Configuración de Envíos</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="{{ route('admin.shipping-prices.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow border-l-4 border-yellow-500">
                    <div class="flex items-center mb-2">
                        <svg class="w-6 h-6 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="font-spartan text-base font-bold text-dark-turquoise">Precios de Envío</h3>
                    </div>
                    <p class="text-sm text-gray-600">Matriz de precios por ciudad</p>
                </a>

                <a href="{{ route('admin.couriers.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow border-l-4 border-orange-500">
                    <div class="flex items-center mb-2">
                        <svg class="w-6 h-6 text-orange-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                        </svg>
                        <h3 class="font-spartan text-base font-bold text-dark-turquoise">Couriers</h3>
                    </div>
                    <p class="text-sm text-gray-600">Gestionar empresas de envío</p>
                </a>

                <a href="{{ route('admin.provinces.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow border-l-4 border-pink-500">
                    <div class="flex items-center mb-2">
                        <svg class="w-6 h-6 text-pink-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                        </svg>
                        <h3 class="font-spartan text-base font-bold text-dark-turquoise">Provincias</h3>
                    </div>
                    <p class="text-sm text-gray-600">Gestionar provincias</p>
                </a>

                <a href="{{ route('admin.cities.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow border-l-4 border-teal-500">
                    <div class="flex items-center mb-2">
                        <svg class="w-6 h-6 text-teal-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <h3 class="font-spartan text-base font-bold text-dark-turquoise">Ciudades</h3>
                    </div>
                    <p class="text-sm text-gray-600">Gestionar ciudades</p>
                </a>
            </div>
        </div>

        <!-- SEO -->
        <div class="mb-8">
            <h3 class="font-spartan text-lg font-semibold text-gray-700 mb-4">Optimización y Marketing</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <a href="{{ route('admin.seo.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow border-l-4 border-red-500">
                    <div class="flex items-center mb-2">
                        <svg class="w-6 h-6 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <h3 class="font-spartan text-lg font-bold text-dark-turquoise">Gestión de SEO</h3>
                    </div>
                    <p class="text-sm text-gray-600">Configurar meta tags y optimización para buscadores</p>
                </a>
            </div>
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
