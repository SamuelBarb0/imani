@extends('layouts.app')

@section('title', 'Mi Perfil - Imani Magnets')

@section('content')

<!-- Hero Section -->
<section class="bg-white py-4">
    <div class="container mx-auto px-6 max-w-6xl text-center">
        <h1 class="font-spartan text-2xl lg:text-3xl font-bold text-dark-turquoise mb-2">
            MI PERFIL
        </h1>
        <p class="text-sm text-gray-brown">
            Bienvenido, {{ $user->name }}
        </p>
    </div>
</section>

<!-- Profile Section -->
<section class="bg-gray-50 py-12">
    <div class="container mx-auto px-6 max-w-6xl">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="font-spartan text-lg font-bold text-dark-turquoise mb-4">Menú</h2>
                    <nav class="space-y-2">
                        <a href="{{ route('user.profile') }}" class="block px-4 py-2 rounded bg-gray-orange text-white font-semibold">
                            Mi Perfil
                        </a>
                        <a href="{{ route('user.orders') }}" class="block px-4 py-2 rounded hover:bg-gray-100 text-gray-brown">
                            Mis Pedidos
                        </a>
                        <a href="{{ route('user.edit') }}" class="block px-4 py-2 rounded hover:bg-gray-100 text-gray-brown">
                            Editar Perfil
                        </a>
                        <a href="{{ route('user.password.form') }}" class="block px-4 py-2 rounded hover:bg-gray-100 text-gray-brown">
                            Cambiar Contraseña
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="mt-4">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 rounded bg-red-500 text-white hover:bg-red-600 font-semibold">
                                Cerrar Sesión
                            </button>
                        </form>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-2">

                <!-- User Info -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="font-spartan text-xl font-bold text-dark-turquoise mb-4">
                        Información Personal
                    </h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm font-semibold text-gray-brown">Nombre:</p>
                            <p class="text-lg">{{ $user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-brown">Email:</p>
                            <p class="text-lg">{{ $user->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-brown">Teléfono:</p>
                            <p class="text-lg">{{ $user->phone ?? 'No especificado' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-brown">Miembro desde:</p>
                            <p class="text-lg">{{ $user->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="font-spartan text-xl font-bold text-dark-turquoise">
                            Pedidos Recientes
                        </h2>
                        <a href="{{ route('user.orders') }}" class="text-sm text-dark-turquoise hover:underline">
                            Ver todos
                        </a>
                    </div>

                    @if($orders->count() > 0)
                        <div class="space-y-4">
                            @foreach($orders as $order)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <p class="font-semibold text-dark-turquoise">
                                                Pedido #{{ $order->order_number }}
                                            </p>
                                            <p class="text-sm text-gray-brown">
                                                {{ $order->created_at->format('d/m/Y H:i') }}
                                            </p>
                                        </div>
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                            @if($order->status === 'completed') bg-green-100 text-green-800
                                            @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                            @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <p class="text-sm text-gray-brown">
                                            {{ $order->items->count() }} producto(s) - Total: ${{ number_format($order->total, 2) }}
                                        </p>
                                        <a href="{{ route('user.order.show', $order->order_number) }}" class="text-sm text-dark-turquoise hover:underline">
                                            Ver detalles →
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">
                            No tienes pedidos aún. ¡Realiza tu primera compra!
                        </p>
                    @endif

                </div>

            </div>

        </div>

    </div>
</section>

@endsection
