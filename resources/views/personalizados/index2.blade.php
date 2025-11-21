@extends('layouts.app')

@section('content')
<section class="bg-white py-4 md:py-4">
    <div class="container mx-auto px-6 max-w-6xl grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
        <!-- Imagen principal -->
        <div class="flex justify-center h-[580px] overflow-hidden rounded-lg shadow-lg">
            <img
                src="{{ asset($content->get('hero.image')) }}"
                alt="Imanes personalizados Imani Magnets"
                class="w-full h-full object-cover">
        </div>


        <!-- Descripción del producto -->
        <div>
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-spartan font-bold text-dark-turquoise mb-4 leading-none whitespace-pre-line">
                {!! $content->get('hero.title') !!}
            </h1>
            <p class="text-gray-700 mb-4 leading-relaxed">
                {{ $content->get('hero.subtitle') }}
            </p>
            <p class="text-gray-700 mb-4">{{ $content->get('landing.description_1') }}</p>

            <p class="text-gray-700 mb-4">{{ $content->get('landing.description_2') }}</p>

            <div class="flex items-center justify-between mt-6">
                <div>
                    <p class="text-2xl font-bold text-dark-turquoise">{{ $content->get('landing.price') }} USD</p>
                    <p class="text-sm text-gray-500 italic">{!! $content->get('landing.shipping_note') !!}</p>
                </div>
            </div>

            <!-- Selector de cantidad -->
            <div class="flex items-center mt-6 space-x-3">
                <a href="{{ route('personalizados.crear') }}"
                    class="btn-primary inline-block px-8 md:px-10 py-3 bg-gray-orange hover:bg-[#a89980] text-white rounded-lg font-spartan font-semibold text-sm md:text-base tracking-wider uppercase">
                    {{ $content->get('landing.button_text') }}
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Sección: Cómo funciona -->
<section class="bg-gray-50 py-12 md:py-14 lg:py-16">
    <div class="container mx-auto px-6 max-w-6xl">
        <h2 class="font-spartan text-2xl md:text-3xl font-bold text-dark-turquoise mb-10 text-left">
            {{ $content->get('info.title') }}
        </h2>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Paso 1 -->
            <div class="bg-[#E9E6DF] rounded-md p-8 text-center shadow-sm hover:shadow-md transition relative">
                <div class="absolute -top-5 left-1/2 transform -translate-x-1/2">
                    <div class="bg-dark-turquoise text-white w-10 h-10 flex items-center justify-center rounded-full font-bold">
                        1
                    </div>
                </div>
                <h3 class="mt-2 text-lg md:text-xl font-spartan font-extrabold text-dark-turquoise uppercase tracking-wide mb-3">
                    {{ $content->get('landing.step1_title') }}
                </h3>
                <p class="text-gray-700 text-sm leading-relaxed">
                    {{ $content->get('landing.step1_desc') }}
                </p>
            </div>

            <!-- Paso 2 -->
            <div class="bg-[#E9E6DF] rounded-md p-8 text-center shadow-sm hover:shadow-md transition relative">
                <div class="absolute -top-5 left-1/2 transform -translate-x-1/2">
                    <div class="bg-dark-turquoise text-white w-10 h-10 flex items-center justify-center rounded-full font-bold">
                        2
                    </div>
                </div>
                <h3 class="mt-2 text-lg md:text-xl font-spartan font-extrabold text-dark-turquoise uppercase tracking-wide mb-3">
                    {{ $content->get('landing.step2_title') }}
                </h3>
                <p class="text-gray-700 text-sm leading-relaxed">
                    {{ $content->get('landing.step2_desc') }}
                </p>
            </div>

            <!-- Paso 3 -->
            <div class="bg-[#E9E6DF] rounded-md p-8 text-center shadow-sm hover:shadow-md transition relative">
                <div class="absolute -top-5 left-1/2 transform -translate-x-1/2">
                    <div class="bg-dark-turquoise text-white w-10 h-10 flex items-center justify-center rounded-full font-bold">
                        3
                    </div>
                </div>
                <h3 class="mt-2 text-lg md:text-xl font-spartan font-extrabold text-dark-turquoise uppercase tracking-wide mb-3">
                    {{ $content->get('landing.step3_title') }}
                </h3>
                <p class="text-gray-700 text-sm leading-relaxed">
                    {{ $content->get('landing.step3_desc') }}
                </p>
            </div>
        </div>
    </div>
</section>

@endsection