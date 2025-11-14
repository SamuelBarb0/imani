@extends('layouts.app')

@section('content')
<section class="bg-white py-12 md:py-16">
    <div class="container mx-auto px-6 max-w-4xl">
        <!-- Título -->
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-spartan font-bold text-dark-turquoise mb-3 text-left">
                {{ $content->get('header.title') }}
            </h1>
            <p class="text-gray-brown text-[17px] leading-relaxed text-left">
                {{ $content->get('header.subtitle') }}
            </p>
        </div>

        <!-- Mensajes de éxito/error -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        <!-- Formulario -->
        <div class="bg-white border border-[#c2b49a] rounded-lg shadow-sm p-8">
            <form action="{{ route('contacto.submit') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Nombre -->
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="nombre" class="block text-dark-turquoise font-semibold mb-1">{{ $content->get('form.label_nombre') }}</label>
                        <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" placeholder="{{ $content->get('form.placeholder_nombre') }}" required
                            class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-gray-orange focus:outline-none @error('nombre') border-red-500 @enderror">
                        @error('nombre')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="apellido" class="block text-dark-turquoise font-semibold mb-1">{{ $content->get('form.label_apellido') }}</label>
                        <input type="text" id="apellido" name="apellido" value="{{ old('apellido') }}" placeholder="{{ $content->get('form.placeholder_apellido') }}" required
                            class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-gray-orange focus:outline-none @error('apellido') border-red-500 @enderror">
                        @error('apellido')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Correo -->
                <div>
                    <label for="correo" class="block text-dark-turquoise font-semibold mb-1">{{ $content->get('form.label_correo') }}</label>
                    <input type="email" id="correo" name="correo" value="{{ old('correo') }}" placeholder="{{ $content->get('form.placeholder_correo') }}" required
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-gray-orange focus:outline-none @error('correo') border-red-500 @enderror">
                    @error('correo')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Comentarios -->
                <div>
                    <label for="comentarios" class="block text-dark-turquoise font-semibold mb-1">{{ $content->get('form.label_comentarios') }}</label>
                    <textarea id="comentarios" name="comentarios" rows="5" placeholder="{{ $content->get('form.placeholder_comentarios') }}" required
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-gray-orange focus:outline-none @error('comentarios') border-red-500 @enderror">{{ old('comentarios') }}</textarea>
                    @error('comentarios')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Botón -->
                <div class="text-center">
                    <button type="submit"
                       class="btn-primary inline-block px-8 md:px-10 py-3 md:py-4 bg-gray-orange hover:bg-[#a89980] text-white rounded-lg font-spartan font-semibold text-sm md:text-base tracking-wider uppercase">
                        {{ $content->get('form.button_submit') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
