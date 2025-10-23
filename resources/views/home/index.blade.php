@extends('layouts.app')

@section('title', 'Imani Magnets - De Momentos a Imanes')

@push('styles')
<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .animate-fade-in {
        animation: fadeIn 1s ease-out forwards;
    }

    .btn-primary:active {
        transform: translateY(0) scale(1.02);
    }
</style>
@endpush

@section('content')

<!-- Hero Banner - De Momentos a Imanes -->
<section class="relative w-full bg-white overflow-hidden">
    <!-- Mobile/Tablet Version: Banner Layout -->
    <div class="lg:hidden relative h-[550px] md:h-[600px]">
        <!-- Background Image - Top Portion -->
        <div class="absolute inset-x-0 top-0 h-3/5">
            <img src="{{ asset('images/IMG-20251016-WA0030.jpg') }}"
                 alt="Collage de fotos Imani"
                 class="w-full h-full object-cover object-center animate-fade-in">
            <!-- Fade to White Gradient (vertical) -->
            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-white/60 to-white"></div>
        </div>

        <!-- Content - Bottom Portion -->
        <div class="relative h-full flex items-end pb-8">
            <div class="container mx-auto px-6">
                <div class="text-center bg-white/95 backdrop-blur-sm rounded-2xl p-6 md:p-8 shadow-xl">
                    <h1 class="font-spartan text-4xl md:text-5xl font-bold text-dark-turquoise leading-tight mb-4 animate-fade-in-up delay-100">
                        DE MOMENTOS<br>
                        A <span class="font-script text-gray-brown text-5xl md:text-6xl">Imanes</span>
                    </h1>
                    <p class="text-base md:text-lg text-gray-brown mb-6 max-w-md mx-auto animate-fade-in-up delay-200">
                        Tus recuerdos más especiales convertidos en piezas únicas que puedes ver y sentir cada día.
                    </p>
                    <a href="{{ url('personalizados') }}" class="btn-primary inline-block px-8 md:px-10 py-3 md:py-4 bg-gray-orange hover:bg-[#a89980] text-white rounded-full font-spartan font-semibold text-sm md:text-base tracking-wider uppercase shadow-md animate-fade-in-up delay-300">
                        DISEÑA TUS IMANES
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Desktop Version: Banner Layout -->
    <div class="hidden lg:block relative h-[700px]">
        <!-- Background Image - Left Side Only (60%) -->
        <div class="absolute inset-y-0 left-0 w-3/5">
            <img src="{{ asset('images/IMG-20251016-WA0030.jpg') }}"
                 alt="Collage de fotos Imani"
                 class="w-full h-full object-cover object-center animate-fade-in">
            <!-- Fade to White Gradient -->
            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/60 to-white"></div>
        </div>

        <!-- Content - Right Side -->
        <div class="relative h-full flex items-center">
            <div class="container mx-auto px-6 max-w-7xl">
                <div class="flex justify-end">
                    <div class="max-w-2xl text-right">
                        <h1 class="font-spartan text-6xl xl:text-7xl font-bold text-dark-turquoise leading-tight mb-6 animate-fade-in-up delay-100">
                            DE MOMENTOS<br>
                            A <span class="font-script text-gray-brown text-7xl xl:text-8xl">Imanes</span>
                        </h1>
                        <p class="text-xl text-gray-brown mb-8 animate-fade-in-up delay-200">
                            Tus recuerdos más especiales convertidos en piezas únicas que puedes ver y sentir cada día.
                        </p>
                        <div class="flex justify-end animate-fade-in-up delay-300">
                            <a href="{{ url('personalizados') }}" class="btn-primary inline-block px-10 py-4 bg-gray-orange hover:bg-[#a89980] text-white rounded-full font-spartan font-semibold text-base tracking-wider uppercase shadow-lg">
                                DISEÑA TUS IMANES
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quote Section -->
<section class="bg-gray-50 py-8 md:py-10 lg:py-12">
    <div class="container mx-auto px-6 max-w-5xl text-center">
        <p class="font-script text-2xl md:text-3xl lg:text-4xl text-dark-turquoise mb-4 md:mb-6">
            "Las fotos son un boleto de regreso a un momento."
        </p>
        <p class="text-sm md:text-base lg:text-lg text-gray-brown px-4">
            Cada sesión de fotos Imani Magnets es una experiencia diseñada con amor para transformar tus recuerdos en algo tangible, elegante y eterno.
        </p>
    </div>
</section>

<!-- Nuestros Favoritos Section -->
<section class="bg-white py-12 md:py-14 lg:py-16">
    <div class="container mx-auto px-6 max-w-6xl">
        <h2 class="font-spartan text-2xl md:text-3xl lg:text-4xl font-bold text-center text-dark-turquoise mb-10 md:mb-14 lg:mb-16 tracking-wider">
            NUESTROS FAVORITOS
        </h2>

        <!-- Imanes Personalizados -->
        <div class="mb-12 md:mb-14 lg:mb-16">
            <div class="flex flex-col lg:flex-row gap-4 md:gap-6 items-center justify-center">
                <div class="text-center lg:text-left">
                    <h3 class="font-spartan text-2xl md:text-3xl lg:text-5xl font-bold text-dark-turquoise mb-6 md:mb-8 leading-tight">
                        IMANES<br>PERSONALIZADOS
                    </h3>
                    <a href="{{ url('personalizados') }}" class="btn-primary inline-block px-8 md:px-10 py-3 md:py-4 bg-gray-orange hover:bg-[#a89980] text-white rounded-full font-spartan font-semibold text-sm md:text-base tracking-wider uppercase">
                        DISEÑA TUS IMANES
                    </a>
                </div>
                <div class="w-64 h-64 md:w-80 md:h-80 lg:w-96 lg:h-96 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-all duration-500 flex-shrink-0">
                    <img src="{{ asset('images/IMG-20251016-WA0024.jpg') }}" alt="Imanes Personalizados" class="w-full h-full object-cover transform hover:scale-110 transition duration-500">
                </div>
            </div>
        </div>

        <!-- Colecciones de Imanes -->
        <div class="mb-12 md:mb-14 lg:mb-16">
            <div class="flex flex-col lg:flex-row-reverse gap-4 md:gap-6 items-center justify-center">
                <div class="text-center lg:text-right">
                    <h3 class="font-spartan text-2xl md:text-3xl lg:text-5xl font-bold text-dark-turquoise mb-6 md:mb-8 leading-tight">
                        COLECCIONES DE<br>IMANES
                    </h3>
                    <a href="{{ url('colecciones') }}" class="btn-primary inline-block px-8 md:px-10 py-3 md:py-4 bg-gray-orange hover:bg-[#a89980] text-white rounded-full font-spartan font-semibold text-sm md:text-base tracking-wider uppercase">
                        COMPRA TU COLECCIÓN
                    </a>
                </div>
                <div class="w-64 h-64 md:w-80 md:h-80 lg:w-96 lg:h-96 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-all duration-500 flex-shrink-0">
                    <img src="{{ asset('images/IMG-20251016-WA0038.jpg') }}" alt="Colecciones de Imanes" class="w-full h-full object-cover transform hover:scale-110 transition duration-500">
                </div>
            </div>
        </div>

        <!-- Pedidos Especiales -->
        <div class="mb-8 md:mb-12 lg:mb-16">
            <div class="flex flex-col lg:flex-row gap-4 md:gap-6 items-center justify-center">
                <div class="text-center lg:text-left">
                    <h3 class="font-spartan text-2xl md:text-3xl lg:text-5xl font-bold text-dark-turquoise mb-6 md:mb-8 leading-tight">
                        PEDIDOS ESPECIALES Y<br>AL POR MAYOR
                    </h3>
                    <a href="{{ url('contacto') }}" class="btn-primary inline-block px-8 md:px-10 py-3 md:py-4 bg-gray-orange hover:bg-[#a89980] text-white rounded-full font-spartan font-semibold text-sm md:text-base tracking-wider uppercase">
                        ESCRÍBENOS
                    </a>
                </div>
                <div class="w-64 h-64 md:w-80 md:h-80 lg:w-96 lg:h-96 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-all duration-500 flex-shrink-0">
                    <img src="{{ asset('images/instagram/ig-4.jpg') }}" alt="Pedidos Especiales" class="w-full h-full object-cover transform hover:scale-110 transition duration-500">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Hola Section -->
<section class="bg-gray-50 py-12 md:py-14 lg:py-16">
    <div class="container mx-auto px-6 max-w-6xl">
        <div class="flex flex-col lg:flex-row gap-8 md:gap-10 lg:gap-12 items-center">
            <div class="lg:flex-1 lg:pr-8">
                <h2 class="font-script text-4xl md:text-5xl lg:text-6xl text-dark-turquoise mb-4 md:mb-6">Hola!</h2>
                <p class="mb-3 md:mb-4 text-sm md:text-base lg:text-lg text-gray-brown">Que gusto tenerte acá!</p>
                <p class="mb-3 md:mb-4 text-sm md:text-base lg:text-lg text-gray-brown">Soy alemana, fotógrafa de corazón y amante de los pequeños detalles.</p>
                <p class="mb-3 md:mb-4 text-sm md:text-base lg:text-lg text-gray-brown">Vivo en Cumbayá, Ecuador, donde nació la idea de Imani Magnets: transformar momentos especiales en algo tangible, duradero y con alma.</p>
                <p class="mb-3 md:mb-4 text-sm md:text-base lg:text-lg text-gray-brown">Siempre he creído que una foto no solo captura un instante, sino una emoción.</p>
                <p class="mb-6 md:mb-8 text-sm md:text-base lg:text-lg text-gray-brown">Y un imán... te permite revivir esa emoción cada día. Por eso creo cada pieza con dedicación, cuidando la calidad y la historia que hay detrás de cada imagen.</p>
                <p class="font-script text-3xl md:text-4xl lg:text-5xl text-dark-turquoise">x Julia</p>
            </div>
            <div class="w-64 md:w-80 lg:w-96 rounded-lg overflow-hidden shadow-lg flex-shrink-0">
                <img src="{{ asset('images/IMG-20251016-WA0016.jpg') }}" alt="Jimena - Fundadora de Imani Magnets" class="w-full h-auto">
            </div>
        </div>
    </div>
</section>

<!-- Quality Section -->
<section class="bg-white py-12 md:py-14 lg:py-16">
    <div class="container mx-auto px-6 max-w-6xl">
        <h2 class="font-spartan text-xl md:text-2xl lg:text-3xl font-bold text-center text-dark-turquoise mb-8 md:mb-10 lg:mb-12 tracking-wide">
            HECHOS CON PASIÓN, CALIDAD Y CORAZÓN EUROPEO
        </h2>
        <div class="flex flex-col lg:flex-row gap-8 md:gap-10 lg:gap-12 items-center">
            <div class="w-full max-w-sm md:max-w-md lg:w-[500px] rounded-lg overflow-hidden shadow-lg flex-shrink-0">
                <img src="{{ asset('images/instagram/ig-2.jpg') }}" alt="Fabricación de imanes" class="w-full h-auto">
            </div>
            <div class="lg:flex-1">
                <p class="mb-4 md:mb-6 text-sm md:text-base lg:text-lg text-gray-brown">Cada imán está fabricado con materiales de alta calidad importados directamente de Europa. Usamos tecnología de punta para garantizar que cada producto sea duradero bajo estándares alemanes.</p>
                <p class="mb-4 md:mb-6 text-sm md:text-base lg:text-lg text-gray-brown">La impresión es nítida, los colores son fieles a la realidad, y los magnets tienen la fuerza perfecta para decorar tu nevera o cualquier superficie metálica.</p>
                <p class="text-sm md:text-base lg:text-lg text-gray-brown">La calidad, el detalle y la emoción son parte de cada creación.</p>
            </div>
        </div>
    </div>
</section>

<!-- Instagram Section -->
<section class="bg-gray-50 py-12 md:py-14 lg:py-16">
    <div class="container mx-auto px-6 max-w-6xl">
        <h2 class="font-spartan text-2xl md:text-3xl lg:text-4xl font-bold text-center text-dark-turquoise mb-4 md:mb-6 tracking-wide">
            #IMANIMAGNETS
            <svg class="inline-block w-6 h-6 md:w-8 md:h-8 ml-2 text-dark-turquoise" fill="currentColor" viewBox="0 0 24 24">
                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" fill="#fff"></path>
                <circle cx="17.5" cy="6.5" r="1.5" fill="#fff"></circle>
            </svg>
        </h2>
        <p class="text-center text-sm md:text-base lg:text-lg text-gray-brown mb-8 md:mb-10 lg:mb-12 px-4">
            ¡Inspírate! De momentos míos que se vuelven tuyos, y aquellos tuyos que compartes en Instagram.
        </p>

        <!-- Instagram Grid - Responsive -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-2 md:gap-3 lg:gap-4">
            @for ($i = 1; $i <= 8; $i++)
            <div class="relative group aspect-square overflow-hidden rounded-md md:rounded-lg">
                <img src="{{ asset('images/instagram/ig-'.$i.'.jpg') }}" alt="Instagram post {{ $i }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                <div class="absolute inset-0 bg-dark-turquoise/70 opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center">
                    <svg class="w-8 h-8 md:w-10 md:h-10 text-white transform group-hover:scale-110 transition duration-300" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg>
                </div>
            </div>
            @endfor
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="bg-white py-12 md:py-14 lg:py-16">
    <div class="container mx-auto px-6 text-center max-w-4xl">
        <p class="font-script text-3xl md:text-4xl lg:text-5xl text-dark-turquoise mb-4 md:mb-6">Brinda los recuerdos mejores formas.</p>
        <p class="text-sm md:text-base lg:text-lg text-gray-brown mb-6 md:mb-8 px-4">
            Por eso, nos recuerden deben cada una mejor, y aquellos que más importan. Personaliza los imanes, completa los espacios de más importan.
        </p>
        <a href="{{ url('personalizados') }}" class="btn-primary inline-block px-8 md:px-10 py-3 md:py-4 bg-gray-orange hover:bg-[#a89980] text-white rounded-full font-spartan font-semibold text-sm md:text-base tracking-wider uppercase">
            DISEÑA TUS IMANES
        </a>
    </div>
</section>

<!-- WhatsApp Float Button -->
<a href="https://wa.me/593999999999" target="_blank" class="group fixed bottom-6 right-6 w-16 h-16 bg-green-500 hover:bg-green-600 rounded-full flex items-center justify-center shadow-xl hover:shadow-2xl hover:scale-110 transition-all duration-300 z-50 animate-fade-in delay-500">
    <svg class="w-9 h-9 group-hover:scale-110 transition-transform duration-300" fill="white" viewBox="0 0 24 24">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
    </svg>
</a>

@endsection
