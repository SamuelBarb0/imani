@extends('layouts.app')

@section('title', 'Iniciar Sesión - Imani Magnets')

@section('content')

<!-- Hero Section -->
<section class="bg-white py-4">
    <div class="container mx-auto px-6 max-w-6xl text-center">
        <h1 class="font-spartan text-2xl lg:text-3xl font-bold text-dark-turquoise mb-2">
            INICIAR SESIÓN
        </h1>
        <p class="text-sm text-gray-brown">
            Accede a tu cuenta para ver tus pedidos
        </p>
    </div>
</section>

<!-- Login Section -->
<section class="bg-gray-50 py-12">
    <div class="container mx-auto px-6 max-w-md">

        <div class="bg-white rounded-lg shadow-md p-8">

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-dark-turquoise mb-2">E-mail *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-dark-turquoise mb-2">Contraseña *</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="mr-2">
                        <span class="text-sm text-gray-brown">Recordarme</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-primary w-full px-6 py-3 bg-gray-orange text-white rounded-full font-spartan font-semibold text-sm tracking-wider uppercase hover:bg-gray-brown mb-4">
                    INICIAR SESIÓN
                </button>

                <!-- Register Link -->
                <div class="text-center">
                    <p class="text-sm text-gray-brown">
                        ¿No tienes cuenta?
                        <a href="{{ route('register') }}" class="text-dark-turquoise hover:underline font-semibold">Regístrate aquí</a>
                    </p>
                </div>

            </form>

        </div>

    </div>
</section>

@endsection
