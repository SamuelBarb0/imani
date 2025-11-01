@extends('layouts.app')

@section('title', 'Crear Cuenta - Imani Magnets')

@section('content')

<!-- Hero Section -->
<section class="bg-white py-4">
    <div class="container mx-auto px-6 max-w-6xl text-center">
        <h1 class="font-spartan text-2xl lg:text-3xl font-bold text-dark-turquoise mb-2">
            CREAR CUENTA
        </h1>
        <p class="text-sm text-gray-brown">
            Regístrate para hacer seguimiento a tus pedidos
        </p>
    </div>
</section>

<!-- Register Section -->
<section class="bg-gray-50 py-12">
    <div class="container mx-auto px-6 max-w-md">

        <div class="bg-white rounded-lg shadow-md p-8">

            <form action="{{ route('register') }}" method="POST">
                @csrf

                <!-- Name -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-brown mb-2">Nombre Completo *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-brown mb-2">Email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-brown mb-2">Teléfono</label>
                    <input type="tel" name="phone" value="{{ old('phone') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent">
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-brown mb-2">Contraseña *</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Mínimo 8 caracteres</p>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-brown mb-2">Confirmar Contraseña *</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent">
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full px-6 py-3 bg-gray-orange text-white rounded-full font-spartan font-semibold text-sm tracking-wider uppercase hover:bg-gray-brown transition-all duration-300 mb-4">
                    CREAR CUENTA
                </button>

                <!-- Login Link -->
                <div class="text-center">
                    <p class="text-sm text-gray-brown">
                        ¿Ya tienes cuenta?
                        <a href="{{ route('login') }}" class="text-dark-turquoise hover:underline font-semibold">Inicia sesión aquí</a>
                    </p>
                </div>

            </form>

        </div>

    </div>
</section>

@endsection
