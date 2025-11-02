@extends('layouts.app')

@section('content')
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="font-spartan text-4xl font-bold text-dark-turquoise mb-4">
                    Rastrear Mi Pedido
                </h1>
                <p class="text-gray-600">
                    Ingresa tu número de pedido para ver el estado de tu orden
                </p>
            </div>

            <!-- Error Message -->
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Tracking Form -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <form action="{{ route('tracking.track') }}" method="POST">
                    @csrf

                    <div class="space-y-6">
                        <!-- Order Number -->
                        <div>
                            <label for="order_number" class="block text-sm font-semibold text-gray-brown mb-2">
                                Número de Pedido *
                            </label>
                            <input
                                type="text"
                                name="order_number"
                                id="order_number"
                                value="{{ old('order_number') }}"
                                required
                                placeholder="Ej: IM-2025-001234"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent text-lg"
                            >
                            @error('order_number')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">
                                Puedes encontrar tu número de pedido en el correo de confirmación
                            </p>
                        </div>

                        <!-- Email (Optional for security) -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-brown mb-2">
                                Correo Electrónico (Opcional)
                            </label>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                value="{{ old('email') }}"
                                placeholder="tu@email.com"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                            >
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">
                                Ingresa el email usado al realizar la compra para mayor seguridad
                            </p>
                        </div>

                        <!-- Submit Button -->
                        <button
                            type="submit"
                            class="w-full bg-gray-orange hover:bg-gray-brown text-white font-spartan font-semibold py-3 px-6 rounded-full transition-all duration-300 uppercase tracking-wider"
                        >
                            Rastrear Pedido
                        </button>
                    </div>
                </form>
            </div>

            <!-- Help Section -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-600 mb-2">
                    ¿No encuentras tu número de pedido?
                </p>
                <p class="text-sm text-gray-600">
                    Revisa tu correo electrónico o
                    <a href="{{ route('contacto') }}" class="text-dark-turquoise hover:underline font-semibold">
                        contáctanos
                    </a>
                </p>
            </div>

            <!-- Info Cards -->
            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white p-4 rounded-lg shadow text-center">
                    <div class="text-3xl mb-2">📦</div>
                    <h3 class="font-spartan font-semibold text-dark-turquoise mb-1">Estado del Pedido</h3>
                    <p class="text-xs text-gray-600">Ver el estado actual de tu orden</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow text-center">
                    <div class="text-3xl mb-2">🚚</div>
                    <h3 class="font-spartan font-semibold text-dark-turquoise mb-1">Info de Envío</h3>
                    <p class="text-xs text-gray-600">Detalles de envío y tracking</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow text-center">
                    <div class="text-3xl mb-2">📄</div>
                    <h3 class="font-spartan font-semibold text-dark-turquoise mb-1">Detalles Completos</h3>
                    <p class="text-xs text-gray-600">Productos, precios y más</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
