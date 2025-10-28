@extends('layouts.app')

@section('content')
<section class="bg-white py-12 md:py-16 text-[17px] md:text-[18px] leading-relaxed">
    <div class="container mx-auto px-6 max-w-6xl">
        <!-- Encabezado -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-start mb-12">
            <div>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-spartan font-bold text-dark-turquoise mb-4 leading-snug">
                    COLECCIONES DE IMANES <br> <span class="text-xl md:text-xl font-semibold">(SET DE 6)</span>
                </h1>
                <p class="text-gray-700 mb-4">
                    Descubre nuestras colecciones únicas, diseñadas con amor y atención al detalle.
                    Cada imán cuenta una historia: lugares, emociones y momentos que inspiran.
                </p>
                <p class="text-gray-700 mb-4">
                    Elige tu favorita y llena tus espacios de estilo y significado.
                </p>
                <p class="text-gray-700">
                    Cada imán mide <strong>2" x 2"</strong> (5.08 x 5.08 cm).
                </p>
            </div>

            <div class="flex justify-center h-[380px] md:h-[380px] overflow-hidden rounded-lg shadow-lg">
                <img 
                    src="{{ asset('images/IMG-20251016-WA0038.jpg') }}" 
                    alt="Colecciones de imanes" 
                    class="h-full w-auto object-cover"
                >
            </div>
        </div>

        <!-- Nuestras Colecciones -->
        <h2 class="font-spartan text-3xl md:text-4xl font-bold text-dark-turquoise mb-10 tracking-wide">
            NUESTRAS COLECCIONES
        </h2>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- ECUADOR I -->
            <div class="bg-[#F7F6F2] rounded-md p-6 shadow-sm hover:shadow-md transition text-center">
                <div class="w-full h-[230px] overflow-hidden rounded-md mb-4">
                    <img src="{{ asset('images/IMG-20251016-WA0038.jpg') }}" alt="Ecuador I" class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                </div>
                <h3 class="text-xl font-bold text-dark-turquoise mb-3 uppercase">ECUADOR I</h3>
                <p class="text-gray-700 text-base mb-3">Primera colección con imanes de:</p>
                <ul class="text-gray-700 text-base list-disc list-inside mb-4 text-left inline-block">
                    <li>Cuenca</li>
                    <li>Mindo</li>
                    <li>Galápagos</li>
                    <li>Quito</li>
                    <li>Mitad del Mundo</li>
                    <li>Quilotoa</li>
                </ul>

                <p class="font-bold text-dark-turquoise text-lg">19.99 USD</p>
                <p class="text-sm text-gray-500 italic mb-5">Envío calculado al finalizar la compra.</p>

                <div class="flex items-center justify-center space-x-3 mb-6">
                    <label for="cantidad1" class="text-gray-700 text-sm font-medium">Cantidad</label>
                    <div class="flex border border-gray-300 rounded-md overflow-hidden">
                        <button class="px-3 py-1 bg-gray-100 text-gray-700">-</button>
                        <input type="number" id="cantidad1" value="1" min="1" class="w-12 text-center border-0 focus:ring-0">
                        <button class="px-3 py-1 bg-gray-100 text-gray-700">+</button>
                    </div>
                </div>

                <button class="btn-primary inline-block px-8 md:px-10 py-3 md:py-4 bg-gray-orange hover:bg-[#a89980] text-white rounded-lg font-spartan font-semibold text-sm md:text-base tracking-wider uppercase">
                    PEDIR AHORA
                </button>
            </div>

            <!-- ECUADOR II -->
            <div class="bg-[#F7F6F2] rounded-md p-6 shadow-sm hover:shadow-md transition text-center">
                <div class="w-full h-[230px] overflow-hidden rounded-md mb-4">
                    <img src="{{ asset('images/IMG-20251016-WA0039.jpg') }}" alt="Ecuador II" class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                </div>
                <h3 class="text-xl font-bold text-dark-turquoise mb-3 uppercase">ECUADOR II</h3>
                <p class="text-gray-700 text-base mb-3">Segunda colección con imanes de:</p>
                <ul class="text-gray-700 text-base list-disc list-inside mb-4 text-left inline-block">
                    <li>Otavalo</li>
                    <li>Cotopaxi</li>
                    <li>Baños</li>
                    <li>Quito</li>
                    <li>Guayaquil</li>
                    <li>Amazonas</li>
                </ul>

                <p class="font-bold text-dark-turquoise text-lg">19.99 USD</p>
                <p class="text-sm text-gray-500 italic mb-5">Envío calculado al finalizar la compra.</p>

                <div class="flex items-center justify-center space-x-3 mb-6">
                    <label for="cantidad2" class="text-gray-700 text-sm font-medium">Cantidad</label>
                    <div class="flex border border-gray-300 rounded-md overflow-hidden">
                        <button class="px-3 py-1 bg-gray-100 text-gray-700">-</button>
                        <input type="number" id="cantidad2" value="1" min="1" class="w-12 text-center border-0 focus:ring-0">
                        <button class="px-3 py-1 bg-gray-100 text-gray-700">+</button>
                    </div>
                </div>

                <button class="btn-primary inline-block px-8 md:px-10 py-3 md:py-4 bg-gray-orange hover:bg-[#a89980] text-white rounded-lg font-spartan font-semibold text-sm md:text-base tracking-wider uppercase">
                    PEDIR AHORA
                </button>
            </div>

            <!-- GALÁPAGOS -->
            <div class="bg-[#F7F6F2] rounded-md p-6 shadow-sm hover:shadow-md transition text-center">
                <div class="w-full h-[230px] overflow-hidden rounded-md mb-4">
                    <img src="{{ asset('images/IMG-20251016-WA0038.jpg') }}" alt="Animales de Galápagos" class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                </div>
                <h3 class="text-xl font-bold text-dark-turquoise mb-3 uppercase">ANIMALES DE GALÁPAGOS</h3>
                <p class="text-gray-700 text-base mb-4 leading-relaxed">
                    Una selección de imágenes que capturan la esencia de los viajes, 
                    los colores y los instantes que merecen quedarse contigo.
                </p>

                <p class="font-bold text-dark-turquoise text-lg">19.99 USD</p>
                <p class="text-sm text-gray-500 italic mb-5">Envío calculado al finalizar la compra.</p>

                <div class="flex items-center justify-center space-x-3 mb-6">
                    <label for="cantidad3" class="text-gray-700 text-sm font-medium">Cantidad</label>
                    <div class="flex border border-gray-300 rounded-md overflow-hidden">
                        <button class="px-3 py-1 bg-gray-100 text-gray-700">-</button>
                        <input type="number" id="cantidad3" value="1" min="1" class="w-12 text-center border-0 focus:ring-0">
                        <button class="px-3 py-1 bg-gray-100 text-gray-700">+</button>
                    </div>
                </div>

                <button class="btn-primary inline-block px-8 md:px-10 py-3 md:py-4 bg-gray-orange hover:bg-[#a89980] text-white rounded-lg font-spartan font-semibold text-sm md:text-base tracking-wider uppercase">
                    PEDIR AHORA
                </button>
            </div>
        </div>
    </div>
</section>
@endsection
