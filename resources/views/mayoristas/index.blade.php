@extends('layouts.app')

@push('styles')
<style>
    /* Estilo para el input date cuando está vacío */
    input[type="date"]:not(:focus):invalid {
        color: #9ca3af;
    }

    input[type="date"]:focus:invalid {
        color: #374151;
    }
</style>
@endpush

@section('content')
<section class="bg-white py-12 md:py-16">
    <div class="container mx-auto px-6 max-w-6xl">
        <!-- Encabezado -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-start mb-12">
            <div>
                <h1 class="text-3xl md:text-4xl font-spartan font-bold text-dark-turquoise mb-4">
                    {{ $content->get('header.title') }}
                </h1>

                <p class="text-gray-brown mb-4 leading-relaxed">
                    {!! $content->get('header.intro') !!}
                </p>

                <div class="bg-[#E9E6DF] p-4 rounded-md mb-4">
                    <p class="text-dark-turquoise font-bold mb-2">{{ $content->get('header.perfect_for_title') }}</p>
                    <ul class="list-disc list-inside text-gray-brown text-[17px]">
                        <li>{{ $content->get('header.use_1') }}</li>
                        <li>{{ $content->get('header.use_2') }}</li>
                        <li>{{ $content->get('header.use_3') }}</li>
                    </ul>
                </div>

                <p class="text-gray-brown mb-4">
                    {!! $content->get('header.help_text') !!}
                </p>

                <p class="text-gray-brown">
                    {!! $content->get('header.contact_info') !!}
                </p>
            </div>

            <!-- Imágenes en columna -->
            <div class="flex flex-col items-center gap-6">
                <div class="rounded-lg overflow-hidden shadow-md w-full max-w-sm">
                    <img
                        src="{{ asset($content->get('header.image_1')) }}"
                        alt="Imanes personalizados al por mayor"
                        class="w-full h-[350px] md:h-[300px] object-cover">
                </div>

                <div class="rounded-lg overflow-hidden shadow-md w-full max-w-sm">
                    <img
                        src="{{ asset($content->get('header.image_2')) }}"
                        alt="Ejemplo de imán personalizado"
                        class="w-full h-[350px] md:h-[300px] object-cover">
                </div>
            </div>
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
        <div class="bg-white border border-gray-300 rounded-lg shadow-sm p-8">
            <form action="{{ route('mayoristas.submit') }}" method="POST" class="space-y-6">
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

                <!-- Correo y celular -->
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="correo" class="block text-dark-turquoise font-semibold mb-1">{{ $content->get('form.label_correo') }}</label>
                        <input type="email" id="correo" name="correo" value="{{ old('correo') }}" placeholder="{{ $content->get('form.placeholder_correo') }}" required
                            class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-gray-orange focus:outline-none @error('correo') border-red-500 @enderror">
                        @error('correo')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="celular" class="block text-dark-turquoise font-semibold mb-1">{{ $content->get('form.label_celular') }}</label>
                        <input type="tel" id="celular" name="celular" value="{{ old('celular') }}" required
                            class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-gray-orange focus:outline-none @error('celular') border-red-500 @enderror">
                        @error('celular')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Cantidad -->
                <div>
                    <label for="cantidad" class="block text-dark-turquoise font-semibold mb-1">{{ $content->get('form.label_cantidad') }}</label>
                    <input type="number" id="cantidad" name="cantidad" value="{{ old('cantidad') }}" min="1" placeholder="{{ $content->get('form.placeholder_cantidad') }}" required
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-gray-orange focus:outline-none @error('cantidad') border-red-500 @enderror">
                    @error('cantidad')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fecha -->
                <div>
                    <label for="fecha" class="block text-dark-turquoise font-semibold mb-1">{{ $content->get('form.label_fecha') }}</label>
                    <input type="date" id="fecha" name="fecha" value="{{ old('fecha') }}" required
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-gray-orange focus:outline-none @error('fecha') border-red-500 @enderror"
                        style="color-scheme: light;">
                    @error('fecha')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Comentarios -->
                <div>
                    <label for="comentarios" class="block text-dark-turquoise font-semibold mb-1">{{ $content->get('form.label_comentarios') }}</label>
                    <textarea id="comentarios" name="comentarios" rows="4" placeholder="{{ $content->get('form.placeholder_comentarios') }}"
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