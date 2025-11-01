@extends('layouts.app')

@section('title', 'Imani Magnets - De Momentos a Imanes')

@push('styles')
<style>
    /* TAMAÑO DE FUENTE DE BOTONES - Edita estos valores para ajustar el tamaño */
    :root {
        --btn-font-size-mobile: 1.25rem;
        /* 20px - Ajusta aquí para móvil */
        --btn-font-size-desktop: 1.5rem;
        /* 24px - Ajusta aquí para desktop */
    }

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

    .btn-primary {
        font-size: var(--btn-font-size-mobile);
    }

    @media (min-width: 768px) {
        .btn-primary {
            font-size: var(--btn-font-size-desktop);
        }
    }

    .btn-primary:active {
        transform: translateY(0) scale(1.02);
    }

    /* Hero Slideshow Styles */
    .hero-slide {
        position: absolute;
        inset: 0;
        opacity: 0;
        transition: opacity 1s ease-in-out;
    }

    .hero-slide.active {
        opacity: 1;
    }

    .hero-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    /* Slideshow Indicators */
    .slideshow-indicators {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 10px;
        z-index: 10;
    }

    .indicator-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.5);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .indicator-dot.active {
        background-color: #c2b59b;
        transform: scale(1.2);
    }

    .indicator-dot:hover {
        background-color: rgba(255, 255, 255, 0.8);
    }
</style>
@endpush

@section('content')

<!-- Hero Banner - De Momentos a Imanes -->
<section class="relative w-full bg-white overflow-hidden">
    <!-- Mobile/Tablet Version: Banner Layout -->
    <div class="lg:hidden relative h-[550px] md:h-[600px]">
        <!-- Background Slideshow - Top Portion -->
        <div class="absolute inset-x-0 top-0 h-3/5 overflow-hidden" id="mobile-slideshow">
            <div class="hero-slide active">
                <img src="{{ asset($content->get('hero.slide_1')) }}" alt="Collage de fotos Imani 1">
            </div>
            <div class="hero-slide">
                <img src="{{ asset($content->get('hero.slide_2')) }}" alt="Collage de fotos Imani 2">
            </div>
            <div class="hero-slide">
                <img src="{{ asset($content->get('hero.slide_3')) }}" alt="Collage de fotos Imani 3">
            </div>
        </div>

        <!-- Content - Bottom Portion -->
        <div class="relative h-full flex items-end pb-8">
            <div class="container mx-auto px-6">
                <div class="text-center bg-white/95 backdrop-blur-sm rounded-2xl p-6 md:p-8 shadow-xl">
                    <h1 class="font-spartan text-4xl md:text-5xl font-bold text-dark-turquoise leading-tight mb-4 animate-fade-in-up delay-100">
                        {{ $content->get('hero.title_line1') }}<br>
                        A <span class="font-script text-gray-brown text-6xl md:text-7xl">{{ $content->get('hero.title_line2') }}</span>
                    </h1>
                    <p class="text-base md:text-lg text-gray-brown mb-6 max-w-md mx-auto animate-fade-in-up delay-200">
                        {{ $content->get('hero.subtitle') }}
                    </p>
                    <a href="{{ $content->get('hero.cta_link') }}" class="btn-primary inline-block px-8 md:px-10 py-3 md:py-4 bg-gray-orange hover:bg-[#a89980] text-white rounded-lg font-spartan font-semibold text-xl md:text-2xl tracking-wider uppercase shadow-md animate-fade-in-up delay-300">
                        {{ $content->get('hero.cta_text') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Desktop Version: Banner Layout -->
    <div class="hidden lg:block relative h-[700px]">
        <!-- Background Slideshow - Left Side (58%) -->
        <div class="absolute inset-y-0 left-0 w-[58%] overflow-hidden" id="desktop-slideshow">
            <div class="hero-slide active">
                <img class="w-full h-full object-cover" src="{{ asset($content->get('hero.slide_1')) }}" alt="Collage de fotos Imani 1">
            </div>
            <div class="hero-slide">
                <img class="w-full h-full object-cover" src="{{ asset($content->get('hero.slide_2')) }}" alt="Collage de fotos Imani 2">
            </div>
            <div class="hero-slide">
                <img class="w-full h-full object-cover" src="{{ asset($content->get('hero.slide_3')) }}" alt="Collage de fotos Imani 3">
            </div>

            <!-- Slideshow Indicators -->
            <div class="slideshow-indicators">
                <div class="indicator-dot active" data-slide="0"></div>
                <div class="indicator-dot" data-slide="1"></div>
                <div class="indicator-dot" data-slide="2"></div>
            </div>

            <!-- Fade hacia el texto -->
            <div
                class="pointer-events-none absolute inset-y-0 right-0 z-10
               w-64 xl:w-80
               bg-gradient-to-r from-transparent via-white/50 to-white">
            </div>
        </div>

        <!-- Content - Right Side (42% with padding) -->
        <div class="relative h-full flex items-center justify-end">
            <div class="w-[42%] flex items-center justify-center px-8 xl:px-12">
                <div class="max-w-xl">
                    <h1 class="font-spartan text-5xl xl:text-6xl font-bold text-dark-turquoise leading-tight mb-6 text-right animate-fade-in-up delay-100">
                        {{ $content->get('hero.title_line1') }}<br>
                        A <span class="font-script text-dark-turquoise text-8xl xl:text-8xl inline-block mt-2">{{ $content->get('hero.title_line2') }}</span>
                    </h1>
                    <p class="text-lg xl:text-xl text-gray-brown mb-8 text-right animate-fade-in-up delay-200">
                        {{ $content->get('hero.subtitle') }}
                    </p>
                    <div class="flex justify-end animate-fade-in-up delay-300">
                        <a href="{{ $content->get('hero.cta_link') }}" class="btn-primary inline-block px-10 py-4 bg-gray-orange hover:bg-[#a89980] text-white rounded-lg font-spartan font-semibold text-base tracking-wider uppercase shadow-lg">
                            {{ $content->get('hero.cta_text') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quote Section -->
<section class="bg-gray-50 py-12 md:py-12 lg:py-20 mt-4 md:mt-12 lg:mt-12">
    <div class="container mx-auto px-6 max-w-6xl text-center">
        <p class="font-script text-4xl md:text-7xl lg:text-7xl xl:text-7xl text-dark-turquoise mb-6 md:mb-8">
            {{ $content->get('quote.quote_text') }}
        </p>
        <p class="text-base md:text-lg lg:text-xl xl:text-2xl text-gray-brown px-4">
            {!! $content->get('quote.quote_description') !!}
        </p>
    </div>
</section>

<!-- Nuestros Favoritos Section -->
<section class="bg-white py-12 md:py-14 lg:py-16">
    <div class="container mx-auto px-6 max-w-6xl">
        <h2 class="font-spartan text-3xl md:text-4xl lg:text-5xl font-bold text-center text-dark-turquoise mb-10 md:mb-14 lg:mb-16 tracking-wider">
            {{ $content->get('favorites.title') }}
        </h2>

        <!-- Imanes Personalizados -->
        <div class="mb-8 md:mb-12 lg:mb-16">
            <div class="flex flex-col lg:flex-row gap-4 md:gap-6 items-center justify-center">
                <div class="text-center lg:text-right w-full lg:w-[400px] flex-shrink-0">
                    <h3 class="font-spartan text-2xl md:text-3xl lg:text-4xl font-bold text-dark-turquoise mb-6 md:mb-8 leading-tight">
                        {!! nl2br($content->get('favorites.personalizados_title')) !!}
                    </h3>
                    <a href="{{ url('personalizados') }}" class="btn-primary inline-block px-8 md:px-10 py-3 md:py-4 bg-gray-orange hover:bg-[#a89980] text-white rounded-lg font-spartan font-semibold text-sm md:text-base tracking-wider uppercase">
                        {{ $content->get('favorites.personalizados_button') }}
                    </a>
                </div>
                <div class="w-64 h-64 md:w-80 md:h-80 lg:w-96 lg:h-96 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-all duration-500 flex-shrink-0">
                    <img src="{{ asset($content->get('favorites.personalizados_image')) }}" alt="{{ $content->get('favorites.personalizados_title') }}" class="w-full h-full object-cover transform hover:scale-110 transition duration-500">
                </div>
            </div>
        </div>

        <!-- Colecciones de Imanes -->
        <div class="mb-12 md:mb-14 lg:mb-16">
            <div class="flex flex-col lg:flex-row-reverse gap-4 md:gap-6 items-center justify-center">
                <div class="text-center lg:text-left w-full lg:w-[400px] flex-shrink-0">
                    <h3 class="font-spartan text-2xl md:text-3xl lg:text-4xl font-bold text-dark-turquoise mb-6 md:mb-8 leading-tight">
                        {!! nl2br($content->get('favorites.colecciones_title')) !!}
                    </h3>
                    <a href="{{ url('colecciones') }}" class="btn-primary inline-block px-8 md:px-10 py-3 md:py-4 bg-gray-orange hover:bg-[#a89980] text-white rounded-lg font-spartan font-semibold text-sm md:text-base tracking-wider uppercase">
                        {{ $content->get('favorites.colecciones_button') }}
                    </a>
                </div>
                <div class="w-64 h-64 md:w-80 md:h-80 lg:w-96 lg:h-96 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-all duration-500 flex-shrink-0">
                    <img src="{{ asset($content->get('favorites.colecciones_image')) }}" alt="{{ $content->get('favorites.colecciones_title') }}" class="w-full h-full object-cover transform hover:scale-110 transition duration-500">
                </div>
            </div>
        </div>

        <!-- Pedidos Especiales -->
        <div class="mb-8 md:mb-12 lg:mb-16">
            <div class="flex flex-col lg:flex-row gap-4 md:gap-6 items-center justify-center">
                <div class="text-center lg:text-right w-full lg:w-[400px] flex-shrink-0">
                    <h3 class="font-spartan text-2xl md:text-3xl lg:text-4xl font-bold text-dark-turquoise mb-6 md:mb-8 leading-tight">
                        {!! nl2br($content->get('favorites.mayoristas_title')) !!}
                    </h3>
                    <a href="{{ url('contacto') }}" class="btn-primary inline-block px-8 md:px-10 py-3 md:py-4 bg-gray-orange hover:bg-[#a89980] text-white rounded-lg font-spartan font-semibold text-sm md:text-base tracking-wider uppercase">
                        {{ $content->get('favorites.mayoristas_button') }}
                    </a>
                </div>
                <div class="w-64 h-64 md:w-80 md:h-80 lg:w-96 lg:h-96 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-all duration-500 flex-shrink-0">
                    <img src="{{ asset($content->get('favorites.mayoristas_image')) }}" alt="{{ $content->get('favorites.mayoristas_title') }}" class="w-full h-full object-cover transform hover:scale-110 transition duration-500">
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
                <h2 class="font-script text-6xl md:text-8xl lg:text-8xl text-dark-turquoise mb-4 md:mb-6">{{ $content->get('about.greeting') }}</h2>
                <p class="mb-3 md:mb-4 text-sm md:text-base lg:text-lg text-gray-brown">{{ $content->get('about.intro_1') }}</p>
                <p class="mb-3 md:mb-4 text-sm md:text-base lg:text-lg text-gray-brown">{{ $content->get('about.intro_2') }}</p>
                <p class="mb-3 md:mb-4 text-sm md:text-base lg:text-lg text-gray-brown">{{ $content->get('about.intro_3') }}</p>
                <p class="mb-3 md:mb-4 text-sm md:text-base lg:text-lg text-gray-brown">{{ $content->get('about.intro_4') }}</p>
                <p class="mb-6 md:mb-8 text-sm md:text-base lg:text-lg text-gray-brown">{{ $content->get('about.intro_5') }}</p>
                <p class="font-script text-6xl md:text-8xl lg:text-8xl text-dark-turquoise text-right">{{ $content->get('about.signature') }}</p>
            </div>
            <div class="w-64 md:w-80 lg:w-96 rounded-lg overflow-hidden shadow-lg flex-shrink-0">
                <img src="{{ asset($content->get('about.photo')) }}" alt="Jimena - Fundadora de Imani Magnets" class="w-full h-auto">
            </div>
        </div>
    </div>
</section>

<!-- Quality Section -->
<section class="bg-white py-12 md:py-14 lg:py-16">
    <div class="container mx-auto px-6 max-w-7xl">
        <h2 class="font-spartan text-2xl md:text-3xl lg:text-4xl font-bold text-center lg:text-left text-dark-turquoise mb-8 md:mb-10 lg:mb-12 tracking-wide">
            {{ $content->get('quality.title') }}
        </h2>
        <div class="flex flex-col lg:flex-row gap-8 md:gap-10 lg:gap-16 items-center">
            <div class="w-full max-w-xl md:max-w-2xl lg:basis-[1000px] xl:basis-[1100px] lg:h-[450px] xl:h-[500px] rounded-lg overflow-hidden shadow-lg flex-shrink-0">
                <img src="{{ asset($content->get('quality.image')) }}" alt="{{ $content->get('quality.title') }}" class="w-full h-full object-cover">
            </div>
            <div class="lg:flex-1">
                <p class="mb-4 md:mb-6 text-base md:text-lg lg:text-xl text-gray-brown">{{ $content->get('quality.text_1') }}</p>
                <p class="mb-4 md:mb-6 text-base md:text-lg lg:text-xl text-gray-brown">{{ $content->get('quality.text_2') }}</p>
                <p class="text-base md:text-lg lg:text-xl text-gray-brown">{{ $content->get('quality.text_3') }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Instagram Section -->
<section class="bg-gray-50 py-12 md:py-14 lg:py-16">
    <div class="container mx-auto px-6 max-w-7xl">
        <h2 class="font-spartan text-2xl md:text-3xl lg:text-4xl font-bold text-left text-dark-turquoise mb-4 md:mb-6 tracking-wide">
            {{ $content->get('instagram.title') }}
            <i class="fa-brands fa-instagram inline-block w-6 h-6 md:w-8 md:h-8 ml-2 text-dark-turquoise text-2xl md:text-3xl lg:text-4xl"></i>
        </h2>
        <p class="text-left text-sm md:text-base lg:text-lg text-gray-brown mb-8 md:mb-10 lg:mb-12">
            ¡Inspírate! De momentos míos que se vuelven tuyos, y aquellos tuyos que compartes en Instagram.
        </p>

        <!-- Instagram Grid - Responsive -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4 lg:gap-5">
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
        <p class="font-script text-7xl md:text-7xl lg:text-8xl text-dark-turquoise mb-4 md:mb-6">{{ $content->get('cta_final.title') }}</p>
        <p class="text-sm md:text-base lg:text-lg text-gray-brown mb-6 md:mb-8 px-4">
            {!! $content->get('cta_final.description') !!}
        </p>
        <a href="{{ $content->get('cta_final.button_link') }}" class="btn-primary inline-block px-8 md:px-10 py-3 md:py-4 bg-gray-orange hover:bg-[#a89980] text-white rounded-lg font-spartan font-semibold text-sm md:text-base tracking-wider uppercase">
            {{ $content->get('cta_final.button_text') }}
        </a>
    </div>
</section>

<!-- WhatsApp Float Button -->
<a href="https://wa.me/593999999999" target="_blank" class="group fixed bottom-6 right-6 w-16 h-16 bg-green-500 hover:bg-green-600 rounded-full flex items-center justify-center shadow-xl hover:shadow-2xl hover:scale-110 transition-all duration-300 z-50 animate-fade-in delay-500">
    <svg class="w-9 h-9 group-hover:scale-110 transition-transform duration-300" fill="white" viewBox="0 0 24 24">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
    </svg>
</a>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mobile slideshow
        const mobileContainer = document.getElementById('mobile-slideshow');
        if (mobileContainer) {
            const mobileSlides = mobileContainer.querySelectorAll('.hero-slide');
            const mobileIndicators = mobileContainer.querySelectorAll('.indicator-dot');
            startSlideshow(mobileSlides, mobileIndicators);
        }

        // Desktop slideshow
        const desktopContainer = document.getElementById('desktop-slideshow');
        if (desktopContainer) {
            const desktopSlides = desktopContainer.querySelectorAll('.hero-slide');
            const desktopIndicators = desktopContainer.querySelectorAll('.indicator-dot');
            startSlideshow(desktopSlides, desktopIndicators);
        }

        function startSlideshow(slides, indicators) {
            if (slides.length === 0) return;

            let currentSlide = 0;
            let intervalId;

            function goToSlide(index) {
                // Remove active class from current slide and indicator
                slides[currentSlide].classList.remove('active');
                indicators[currentSlide].classList.remove('active');

                // Update current slide
                currentSlide = index;

                // Add active class to new slide and indicator
                slides[currentSlide].classList.add('active');
                indicators[currentSlide].classList.add('active');
            }

            function showNextSlide() {
                const nextSlide = (currentSlide + 1) % slides.length;
                goToSlide(nextSlide);
            }

            // Add click event to indicators
            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', function() {
                    goToSlide(index);
                    // Reset the interval when manually changing slides
                    clearInterval(intervalId);
                    intervalId = setInterval(showNextSlide, 4000);
                });
            });

            // Auto-advance slides every 4 seconds
            intervalId = setInterval(showNextSlide, 4000);
        }
    });
</script>
@endpush