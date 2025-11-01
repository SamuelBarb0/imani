@extends('layouts.app')

@section('title', 'Editar Perfil - Imani Magnets')

@section('content')

<section class="bg-white py-4">
    <div class="container mx-auto px-6 max-w-6xl text-center">
        <h1 class="font-spartan text-2xl lg:text-3xl font-bold text-dark-turquoise mb-2">
            EDITAR PERFIL
        </h1>
    </div>
</section>

<section class="bg-gray-50 py-12">
    <div class="container mx-auto px-6 max-w-2xl">
        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('user.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-brown mb-2">Nombre Completo *</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-brown mb-2">Email *</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-brown mb-2">Teléfono</label>
                    <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent">
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="flex-1 px-6 py-3 bg-gray-orange text-white rounded-full font-spartan font-semibold text-sm tracking-wider uppercase hover:bg-gray-brown transition-all duration-300">
                        GUARDAR CAMBIOS
                    </button>
                    <a href="{{ route('user.profile') }}" class="flex-1 px-6 py-3 bg-gray-200 text-gray-brown text-center rounded-full font-spartan font-semibold text-sm tracking-wider uppercase hover:bg-gray-300 transition-all duration-300">
                        CANCELAR
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection
