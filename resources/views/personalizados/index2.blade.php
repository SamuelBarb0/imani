@extends('layouts.app')

@section('content')
<section class="bg-white py-12 md:py-16">
    <div class="container mx-auto px-6 max-w-6xl grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
        <!-- Imagen principal -->
        <div class="flex justify-center h-[650px] overflow-hidden rounded-lg shadow-lg">
            <img
                src="{{ asset('images/IMG-20251016-WA0037.jpg') }}"
                alt="Imanes personalizados Imani Magnets"
                class="w-full h-full object-cover">
        </div>


        <!-- Descripción del producto -->
        <div>
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-spartan font-bold text-dark-turquoise mb-4 leading-snug">
                IMANES PERSONALIZADOS<br>CON TUS FOTOS (SET DE 9)
            </h1>
            <p class="text-gray-700 mb-4 leading-relaxed">
                Convierte tus recuerdos favoritos en decoración divertida y única con nuestros imanes personalizados con tus fotos en tamaño
                <strong>2"x 2"</strong> (5.08 x 5.08 cm).
            </p>
            <p class="text-gray-700 mb-4">Fabricados con materiales de alta calidad, llenan de vida cualquier espacio</p>

            <p class="text-gray-700 mb-4">Perfectos para regalar o para ti mismo.</p>

            <div class="flex items-center justify-between mt-6">
                <div>
                    <p class="text-lg font-bold text-dark-turquoise">26.99 USD</p>
                    <p class="text-sm text-gray-500 italic">Envío calculado al finalizar la compra.</p>
                </div>
            </div>

            <!-- Selector de cantidad -->
            <div class="flex items-center mt-6 space-x-3">
                <label for="cantidad" class="text-gray-700 font-medium">Cantidad</label>
                <div class="flex border border-gray-300 rounded-md overflow-hidden">
                    <button class="px-3 py-2 bg-gray-100 text-gray-700 hover:bg-gray-200 transition">-</button>
                    <input type="number" id="cantidad" value="1" min="1" class="w-14 text-center border-0 focus:ring-0">
                    <button class="px-3 py-2 bg-gray-100 text-gray-700 hover:bg-gray-200 transition">+</button>
                </div>
                <a href="{{ route('personalizados.crear') }}"
                    class="btn-primary inline-block px-8 md:px-10 py-3 bg-gray-orange hover:bg-[#a89980] text-white rounded-lg font-spartan font-semibold text-sm md:text-base tracking-wider uppercase">
                    PEDIR AHORA
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Sección: Cómo funciona -->
<section class="bg-gray-50 py-12 md:py-14 lg:py-16">
    <div class="container mx-auto px-6 max-w-6xl">
        <h2 class="font-spartan text-2xl md:text-3xl font-bold text-dark-turquoise mb-10 text-left">
            CÓMO FUNCIONA
        </h2>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Paso 1 -->
            <div class="bg-[#E9E6DF] rounded-md p-8 text-center shadow-sm hover:shadow-md transition relative">
                <div class="absolute -top-5 left-1/2 transform -translate-x-1/2">
                    <div class="bg-dark-turquoise text-white w-10 h-10 flex items-center justify-center rounded-full font-bold">
                        1
                    </div>
                </div>
                <h3 class="mt-2 text-lg md:text-xl font-extrabold text-dark-turquoise uppercase tracking-wide mb-3">
                    SUBE TUS FOTOS
                </h3>
                <p class="text-gray-700 text-sm leading-relaxed">
                    Sube tus imágenes favoritas con nuestra interfaz sencilla.
                    Recórtalas, edítalas y prévisualízalas antes de enviarlas.
                </p>
            </div>

            <!-- Paso 2 -->
            <div class="bg-[#E9E6DF] rounded-md p-8 text-center shadow-sm hover:shadow-md transition relative">
                <div class="absolute -top-5 left-1/2 transform -translate-x-1/2">
                    <div class="bg-dark-turquoise text-white w-10 h-10 flex items-center justify-center rounded-full font-bold">
                        2
                    </div>
                </div>
                <h3 class="mt-2 text-lg md:text-xl font-extrabold text-dark-turquoise uppercase tracking-wide mb-3">
                    REALIZA TU PEDIDO
                </h3>
                <p class="text-gray-700 text-sm leading-relaxed">
                    Cuando estés satisfecho/a con tus fotos, agrégalas al carrito,
                    procede al pago e ingresa tu información de envío y correo electrónico.
                </p>
            </div>

            <!-- Paso 3 -->
            <div class="bg-[#E9E6DF] rounded-md p-8 text-center shadow-sm hover:shadow-md transition relative">
                <div class="absolute -top-5 left-1/2 transform -translate-x-1/2">
                    <div class="bg-dark-turquoise text-white w-10 h-10 flex items-center justify-center rounded-full font-bold">
                        3
                    </div>
                </div>
                <h3 class="mt-2 text-lg md:text-xl font-extrabold text-dark-turquoise uppercase tracking-wide mb-3">
                    SIGUE TU PEDIDO
                </h3>
                <p class="text-gray-700 text-sm leading-relaxed">
                    Una vez realizado el pedido, imprimiremos, cortaremos,
                    empacaremos y enviaremos tus imanes. Recibirás un correo
                    con tu número de seguimiento.
                </p>
            </div>
        </div>
    </div>
</section>

@endsection