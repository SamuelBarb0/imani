@extends('layouts.app')

@section('content')
<section class="bg-white py-12 md:py-16">
    <div class="container mx-auto px-6 max-w-4xl">
        <!-- Título -->
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-spartan font-bold text-dark-turquoise mb-3 text-left">
                {{ $content->get('header.title') }}
            </h1>
            <p class="text-gray-700 text-[17px] leading-relaxed text-left">
                {{ $content->get('header.subtitle') }}
            </p>
        </div>

        <!-- Formulario -->
        <div class="bg-white border border-[#c2b49a] rounded-lg shadow-sm p-8">
            <form action="#" method="POST" class="space-y-6">
                @csrf

                <!-- Nombre -->
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="nombre" class="block text-dark-turquoise font-semibold mb-1">{{ $content->get('form.label_nombre') }}</label>
                        <input type="text" id="nombre" name="nombre" placeholder="{{ $content->get('form.placeholder_nombre') }}"
                            class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-gray-orange focus:outline-none">
                    </div>
                    <div>
                        <label for="apellido" class="block text-dark-turquoise font-semibold mb-1">{{ $content->get('form.label_apellido') }}</label>
                        <input type="text" id="apellido" name="apellido" placeholder="{{ $content->get('form.placeholder_apellido') }}"
                            class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-gray-orange focus:outline-none">
                    </div>
                </div>

                <!-- Correo -->
                <div>
                    <label for="correo" class="block text-dark-turquoise font-semibold mb-1">{{ $content->get('form.label_correo') }}</label>
                    <input type="email" id="correo" name="correo" placeholder="{{ $content->get('form.placeholder_correo') }}"
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-gray-orange focus:outline-none">
                </div>

                <!-- Comentarios -->
                <div>
                    <label for="comentarios" class="block text-dark-turquoise font-semibold mb-1">{{ $content->get('form.label_comentarios') }}</label>
                    <textarea id="comentarios" name="comentarios" rows="5" placeholder="{{ $content->get('form.placeholder_comentarios') }}"
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-gray-orange focus:outline-none"></textarea>
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
