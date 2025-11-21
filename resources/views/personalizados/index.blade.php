@extends('layouts.app')

@section('title', 'Imanes Personalizados - Imani Magnets')

@section('content')

<!-- Hero Section -->
<section class="bg-white py-2">
    <div class="container mx-auto px-4 max-w-7xl text-center">
        <h1 class="font-spartan text-xl lg:text-2xl font-bold text-dark-turquoise mb-1">
            IMANES PERSONALIZADOS
        </h1>
        <p class="text-xs text-gray-brown">
            Sube 9 fotos para crear tu set de imanes 2x2"
        </p>
    </div>
</section>

<!-- Editor Section -->
<section class="bg-gray-50 py-3">
    <div class="container mx-auto px-4 max-w-7xl">

        <!-- 2-Column Layout: Upload (left) + Grid (right) -->
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-3">

            <!-- PASO 1: Upload Area (Left Column - 2/5 width on desktop) -->
            <div id="upload-area" class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-lg p-3 h-full flex flex-col">
                    <div class="text-center mb-2">
                        <h2 class="font-spartan text-sm font-bold text-dark-turquoise mb-1">
                            PASO 1: SUBE TUS FOTOS
                        </h2>
                    </div>

                    <!-- Drop Zone -->
                    <div id="dropzone" class="border-2 border-dashed border-gray-orange rounded-lg p-4 text-center cursor-pointer hover:border-dark-turquoise transition-all duration-300 flex-grow flex flex-col items-center justify-center">
                        <div class="mb-2">
                            <svg class="w-8 h-8 mx-auto text-gray-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                        </div>
                        <p class="font-spartan text-xs font-semibold text-dark-turquoise mb-1">
                            HAZ CLIC O ARRASTRA TUS FOTOS AQUÍ
                        </p>
                        <p class="text-xs text-gray-brown mb-2">
                            PNG, JPG o JPEG (máximo 10MB)
                        </p>
                        <input type="file" id="file-input" accept="image/png,image/jpeg,image/jpg" multiple class="hidden">
                        <button id="select-photos-btn" class="btn-primary inline-block px-3 py-1.5 bg-gray-orange hover:bg-gray-brown text-white rounded-full font-spartan font-semibold text-xs tracking-wider uppercase">
                            SELECCIONAR FOTOS
                        </button>
                    </div>

                    <!-- Progress Bar -->
                    <div id="progress-container" class="mt-2 hidden">
                        <div class="flex justify-between text-xs text-gray-brown mb-1">
                            <span>Cargando imágenes...</span>
                            <span id="progress-text">0%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden">
                            <div id="progress-bar" class="bg-dark-turquoise h-1.5 rounded-full transition-all duration-300" style="width: 0%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PASO 2: Image Grid (Right Column - 3/5 width on desktop) -->
            <div id="image-grid-container" class="lg:col-span-3">
                <div class="bg-white rounded-lg shadow-lg p-3 h-full flex flex-col">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 mb-2">
                        <h2 class="font-spartan text-sm font-bold text-dark-turquoise">
                            PASO 2. HACÉ CLIC EN CADA FOTO Y REALIZÁ EL RECORTE DESEADO.
                        </h2>
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-1.5 sm:gap-2 w-full sm:w-auto">
                            <div class="inline-flex items-center gap-1.5 text-xs">
                                <span class="text-gray-brown">Fotos recortadas:</span>
                                <span id="images-ready" class="font-bold text-dark-turquoise">0/9</span>
                            </div>
                            <button onclick="resetUploadArea()" class="text-xs text-gray-brown hover:text-dark-turquoise underline">
                                ← Reiniciar
                            </button>
                        </div>
                    </div>

                    <!-- 3x3 Grid - Responsive and Compact -->
                    <div class="grid grid-cols-3 gap-1.5 mb-2 flex-grow">
                        <!-- Grid items will be generated dynamically -->
                        <div class="grid-item aspect-square bg-gray-100 rounded border-2 border-dashed border-gray-300 flex items-center justify-center cursor-pointer hover:border-dark-turquoise transition-all duration-300" data-index="0">
                            <div class="text-center">
                                <div class="text-2xl text-gray-300 mb-0.5">+</div>
                                <p class="text-xs text-gray-400">Foto 1</p>
                            </div>
                        </div>
                        <div class="grid-item aspect-square bg-gray-100 rounded border-2 border-dashed border-gray-300 flex items-center justify-center cursor-pointer hover:border-dark-turquoise transition-all duration-300" data-index="1">
                            <div class="text-center">
                                <div class="text-2xl text-gray-300 mb-0.5">+</div>
                                <p class="text-xs text-gray-400">Foto 2</p>
                            </div>
                        </div>
                        <div class="grid-item aspect-square bg-gray-100 rounded border-2 border-dashed border-gray-300 flex items-center justify-center cursor-pointer hover:border-dark-turquoise transition-all duration-300" data-index="2">
                            <div class="text-center">
                                <div class="text-2xl text-gray-300 mb-0.5">+</div>
                                <p class="text-xs text-gray-400">Foto 3</p>
                            </div>
                        </div>
                        <div class="grid-item aspect-square bg-gray-100 rounded border-2 border-dashed border-gray-300 flex items-center justify-center cursor-pointer hover:border-dark-turquoise transition-all duration-300" data-index="3">
                            <div class="text-center">
                                <div class="text-2xl text-gray-300 mb-0.5">+</div>
                                <p class="text-xs text-gray-400">Foto 4</p>
                            </div>
                        </div>
                        <div class="grid-item aspect-square bg-gray-100 rounded border-2 border-dashed border-gray-300 flex items-center justify-center cursor-pointer hover:border-dark-turquoise transition-all duration-300" data-index="4">
                            <div class="text-center">
                                <div class="text-2xl text-gray-300 mb-0.5">+</div>
                                <p class="text-xs text-gray-400">Foto 5</p>
                            </div>
                        </div>
                        <div class="grid-item aspect-square bg-gray-100 rounded border-2 border-dashed border-gray-300 flex items-center justify-center cursor-pointer hover:border-dark-turquoise transition-all duration-300" data-index="5">
                            <div class="text-center">
                                <div class="text-2xl text-gray-300 mb-0.5">+</div>
                                <p class="text-xs text-gray-400">Foto 6</p>
                            </div>
                        </div>
                        <div class="grid-item aspect-square bg-gray-100 rounded border-2 border-dashed border-gray-300 flex items-center justify-center cursor-pointer hover:border-dark-turquoise transition-all duration-300" data-index="6">
                            <div class="text-center">
                                <div class="text-2xl text-gray-300 mb-0.5">+</div>
                                <p class="text-xs text-gray-400">Foto 7</p>
                            </div>
                        </div>
                        <div class="grid-item aspect-square bg-gray-100 rounded border-2 border-dashed border-gray-300 flex items-center justify-center cursor-pointer hover:border-dark-turquoise transition-all duration-300" data-index="7">
                            <div class="text-center">
                                <div class="text-2xl text-gray-300 mb-0.5">+</div>
                                <p class="text-xs text-gray-400">Foto 8</p>
                            </div>
                        </div>
                        <div class="grid-item aspect-square bg-gray-100 rounded border-2 border-dashed border-gray-300 flex items-center justify-center cursor-pointer hover:border-dark-turquoise transition-all duration-300" data-index="8">
                            <div class="text-center">
                                <div class="text-2xl text-gray-300 mb-0.5">+</div>
                                <p class="text-xs text-gray-400">Foto 9</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Button (below grid) -->
                    <div class="text-center mt-2">
                        <button id="add-to-cart-btn" disabled class="btn-animate w-full px-4 py-2 bg-gray-300 text-gray-500 rounded-full font-spartan font-semibold text-xs tracking-wider uppercase cursor-not-allowed transition-all duration-300">
                            AGREGAR AL CARRITO
                        </button>
                        <p class="text-xs text-gray-brown mt-1">
                            Asegurate de editar las 9 fotos antes de continuar
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Processing Modal -->
        <div id="processing-modal" class="hidden fixed inset-0 bg-black/80 z-50 flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 max-w-md w-full text-center">
                <div class="mb-3">
                    <svg class="animate-spin h-12 w-12 mx-auto text-dark-turquoise" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
                <h3 class="font-spartan text-lg font-bold text-dark-turquoise mb-1">Agregando al Carrito...</h3>
                <p class="text-sm text-gray-brown">Por favor espera mientras procesamos tus imágenes</p>
            </div>
        </div>

    </div>
</section>

<!-- Image Editor Modal -->
<div id="editor-modal" class="hidden fixed inset-0 bg-black/90 z-50 flex items-center justify-center p-2 sm:p-4">
    <div class="bg-white rounded-lg sm:rounded-2xl shadow-2xl w-full max-w-6xl max-h-[98vh] sm:max-h-[95vh] flex flex-col">

        <!-- Header -->
        <div class="flex items-center justify-between p-3 sm:p-4 md:p-6 border-b border-gray-200">
            <h2 class="font-spartan text-lg sm:text-xl md:text-2xl font-bold text-dark-turquoise">
                Editar Imagen
            </h2>
            <button onclick="closeEditor()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Mode Tabs -->
        <div class="flex border-b border-gray-200 px-2 sm:px-4 md:px-6 overflow-x-auto">
            <button onclick="switchMode('crop')" class="mode-tab active px-3 sm:px-4 md:px-6 py-2 sm:py-3 font-spartan font-semibold text-xs sm:text-sm tracking-wider transition-all border-b-2 border-dark-turquoise text-dark-turquoise whitespace-nowrap" data-mode="crop">
                RECORTAR
            </button>
            <button onclick="switchMode('adjust')" class="mode-tab px-3 sm:px-4 md:px-6 py-2 sm:py-3 font-spartan font-semibold text-xs sm:text-sm tracking-wider transition-all border-b-2 border-transparent text-gray-500 hover:text-dark-turquoise whitespace-nowrap" data-mode="adjust">
                AJUSTAR
            </button>
            <button onclick="switchMode('filters')" class="mode-tab px-3 sm:px-4 md:px-6 py-2 sm:py-3 font-spartan font-semibold text-xs sm:text-sm tracking-wider transition-all border-b-2 border-transparent text-gray-500 hover:text-dark-turquoise whitespace-nowrap" data-mode="filters">
                FILTROS
            </button>
        </div>

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto p-3 sm:p-4 md:p-6">
            <div class="flex flex-col lg:flex-row gap-4 lg:gap-6">

                <!-- Canvas Area -->
                <div class="flex-1 flex items-center justify-center min-h-[300px] sm:min-h-[400px]">
                    <div class="bg-gray-100 rounded-lg p-2 sm:p-4 w-full max-w-[700px]">
                        <!-- Cropper.js container -->
                        <div id="cropper-wrapper" class="w-full mx-auto" style="max-width: 600px;">
                            <img id="crop-image" src="" style="max-width: 100%; display: block;">
                        </div>
                    </div>
                </div>

                <!-- Controls Panel -->
                <div class="w-full lg:w-80 lg:flex-shrink-0">

                    <!-- Crop Mode Controls -->
                    <div id="crop-controls" class="mode-controls">
                        <div class="space-y-4">
                            <h3 class="font-spartan font-bold text-dark-turquoise mb-4">Herramientas de Recorte</h3>

                            <button onclick="rotateImage()" class="btn-primary inline-block w-full px-4 py-3 bg-gray-orange hover:bg-gray-brown text-white rounded-lg font-spartan font-semibold text-sm tracking-wider uppercase flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                ROTAR 90°
                            </button>

                            <div class="p-4 bg-gray-50 rounded-lg">
                                <h4 class="font-spartan font-semibold text-sm text-gray-brown mb-2">Instrucciones:</h4>
                                <ul class="text-xs text-gray-600 space-y-1">
                                    <li>• Arrastra el recuadro para seleccionar la parte de la imagen que quieres ver en el frente de tu imán.</li>
                                    <li>• Usa la rueda del mouse o ajusta las esquinas del cuadrado para cambiar su tamaño.</li>
                                    <li>• El área dentro del cuadrado punteado rojo será visible en el frente del imán.</li>
                                    <li>• La zona rayada quedará plegada hacia atrás del imán y no será visible.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Adjust Mode Controls -->
                    <div id="adjust-controls" class="mode-controls hidden">
                        <div class="space-y-4">
                            <h3 class="font-spartan font-bold text-dark-turquoise mb-4">Ajustes de Imagen</h3>

                            <!-- Brightness -->
                            <div>
                                <label class="flex justify-between text-sm font-semibold text-gray-brown mb-2">
                                    <span>Brillo</span>
                                    <span id="brightness-value">100%</span>
                                </label>
                                <input type="range" id="brightness" min="0" max="200" value="100" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-dark-turquoise">
                            </div>

                            <!-- Contrast -->
                            <div>
                                <label class="flex justify-between text-sm font-semibold text-gray-brown mb-2">
                                    <span>Contraste</span>
                                    <span id="contrast-value">100%</span>
                                </label>
                                <input type="range" id="contrast" min="0" max="200" value="100" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-dark-turquoise">
                            </div>

                            <!-- Saturation -->
                            <div>
                                <label class="flex justify-between text-sm font-semibold text-gray-brown mb-2">
                                    <span>Saturación</span>
                                    <span id="saturation-value">100%</span>
                                </label>
                                <input type="range" id="saturation" min="0" max="200" value="100" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-dark-turquoise">
                            </div>

                            <!-- Exposure -->
                            <div>
                                <label class="flex justify-between text-sm font-semibold text-gray-brown mb-2">
                                    <span>Exposición</span>
                                    <span id="exposure-value">0%</span>
                                </label>
                                <input type="range" id="exposure" min="-100" max="100" value="0" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-dark-turquoise">
                            </div>

                            <!-- Warmth -->
                            <div>
                                <label class="flex justify-between text-sm font-semibold text-gray-brown mb-2">
                                    <span>Temperatura</span>
                                    <span id="warmth-value">0</span>
                                </label>
                                <input type="range" id="warmth" min="-100" max="100" value="0" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-dark-turquoise">
                            </div>

                            <!-- Sepia -->
                            <div>
                                <label class="flex justify-between text-sm font-semibold text-gray-brown mb-2">
                                    <span>Sepia</span>
                                    <span id="sepia-value">0%</span>
                                </label>
                                <input type="range" id="sepia" min="0" max="100" value="0" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-dark-turquoise">
                            </div>

                            <!-- Grayscale -->
                            <div>
                                <label class="flex justify-between text-sm font-semibold text-gray-brown mb-2">
                                    <span>Escala de Grises</span>
                                    <span id="grayscale-value">0%</span>
                                </label>
                                <input type="range" id="grayscale" min="0" max="100" value="0" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-dark-turquoise">
                            </div>

                            <button onclick="resetAdjustments()" class="w-full px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-spartan font-semibold text-xs tracking-wider uppercase hover:bg-gray-300 transition-all">
                                RESETEAR AJUSTES
                            </button>
                        </div>
                    </div>

                    <!-- Filters Mode Controls -->
                    <div id="filters-controls" class="mode-controls hidden">
                        <div class="space-y-3">
                            <h3 class="font-spartan font-bold text-dark-turquoise mb-4">Filtros Preestablecidos</h3>

                            <button onclick="applyFilter('original')" class="filter-btn w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-lg font-spartan font-semibold text-sm tracking-wider uppercase hover:border-dark-turquoise transition-all" data-filter="original">
                                ORIGINAL
                            </button>

                            <button onclick="applyFilter('bw')" class="filter-btn w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-lg font-spartan font-semibold text-sm tracking-wider uppercase hover:border-dark-turquoise transition-all" data-filter="bw">
                                BLANCO Y NEGRO
                            </button>

                            <button onclick="applyFilter('sepia')" class="filter-btn w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-lg font-spartan font-semibold text-sm tracking-wider uppercase hover:border-dark-turquoise transition-all" data-filter="sepia">
                                SEPIA
                            </button>

                            <button onclick="applyFilter('vibrant')" class="filter-btn w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-lg font-spartan font-semibold text-sm tracking-wider uppercase hover:border-dark-turquoise transition-all" data-filter="vibrant">
                                VIBRANTE
                            </button>

                            <button onclick="applyFilter('cool')" class="filter-btn w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-lg font-spartan font-semibold text-sm tracking-wider uppercase hover:border-dark-turquoise transition-all" data-filter="cool">
                                CÁLIDO
                            </button>

                            <button onclick="applyFilter('warm')" class="filter-btn w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-lg font-spartan font-semibold text-sm tracking-wider uppercase hover:border-dark-turquoise transition-all" data-filter="warm">
                                FRIO
                            </button>

                            <button onclick="applyFilter('vintage')" class="filter-btn w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-lg font-spartan font-semibold text-sm tracking-wider uppercase hover:border-dark-turquoise transition-all" data-filter="vintage">
                                VINTAGE
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-2 sm:gap-4 p-3 sm:p-4 md:p-6 border-t border-gray-200">
            <button onclick="closeEditor()" class="px-4 sm:px-6 py-2 sm:py-3 bg-gray-200 text-gray-brown rounded-lg font-spartan font-semibold text-xs sm:text-sm tracking-wider uppercase hover:bg-gray-300 transition-all order-2 sm:order-1">
                CANCELAR
            </button>
            <button onclick="saveImage()" class="btn-animate px-6 sm:px-8 py-2 sm:py-3 bg-dark-turquoise text-white rounded-lg font-spartan font-semibold text-xs sm:text-sm tracking-wider uppercase hover:bg-gray-brown transition-all order-1 sm:order-2">
                GUARDAR CAMBIOS
            </button>
        </div>

    </div>
</div>

<style>
    /* Cropper.js Custom Styles */
    .cropper-container {
        width: 100% !important;
        height: 100% !important;
    }

    .cropper-view-box,
    .cropper-face {
        border-radius: 0 !important;
    }

    /* El crop-box es el recuadro exterior de 644x644 (el que NO debe salirse de la imagen) */
    .cropper-crop-box {
        /* Borde gris exterior del recuadro de 644x644 */
        border: 2px solid #999999 !important;
    }

    /* El view-box (donde se muestra la imagen) - SIN modificar */
    .cropper-view-box {
        outline: none !important;
    }

    /* Rayado diagonal SOLO en el margen proporcional (fuera del rectángulo rojo) */
    .cropper-crop-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: repeating-linear-gradient(45deg,
                transparent,
                transparent 5px,
                rgba(0, 0, 0, 0.15) 5px,
                rgba(0, 0, 0, 0.15) 10px);
        /* Clip-path para recortar solo el marco proporcional (fuera del rectángulo rojo) */
        /* Margen de 3.42% en cada lado (600/644 = 0.9316, margen = (1-0.9316)/2 = 3.42%) */
        clip-path: polygon(
                /* Marco exterior completo */
                0% 0%, 100% 0%, 100% 100%, 0% 100%, 0% 0%,
                /* Recorte interior - área del rectángulo rojo (3.42% desde cada borde) */
                3.42% 3.42%, 3.42% 96.58%,
                96.58% 96.58%,
                96.58% 3.42%, 3.42% 3.42%);
        pointer-events: none;
        z-index: 2;
    }

    /* Recuadro interior ROJO (93.16% del crop-box) - proporcional según la relación 600/644 */
    .cropper-crop-box::after {
        content: '';
        position: absolute;
        top: 3.42%;
        left: 3.42%;
        right: 3.42%;
        bottom: 3.42%;
        /* Fondo TRANSPARENTE para ver la imagen */
        background: transparent;
        /* Borde punteado rojo */
        border: 2px dashed #ef4444;
        pointer-events: none;
        z-index: 3;
    }

    .cropper-line,
    .cropper-point {
        background-color: #12463c !important;
    }

    /* Mobile touch controls - larger hit areas and visual feedback */
    @media (max-width: 768px) {
        .cropper-point {
            width: 20px !important;
            height: 20px !important;
            opacity: 0.8 !important;
        }

        .cropper-point.point-nw,
        .cropper-point.point-ne,
        .cropper-point.point-sw,
        .cropper-point.point-se {
            width: 24px !important;
            height: 24px !important;
        }

        .cropper-line {
            height: 4px !important;
        }

        .cropper-line.line-w,
        .cropper-line.line-e {
            width: 4px !important;
            height: auto !important;
        }

        /* Highlighted state for controls */
        .cropper-controls-highlighted .cropper-point {
            background-color: #c2b59b !important;
            opacity: 1 !important;
            width: 28px !important;
            height: 28px !important;
            box-shadow: 0 0 0 3px rgba(194, 181, 155, 0.3) !important;
            transition: all 0.2s ease !important;
        }

        .cropper-controls-highlighted .cropper-line {
            background-color: #c2b59b !important;
            opacity: 1 !important;
        }

        .cropper-controls-highlighted .cropper-line {
            height: 6px !important;
        }

        .cropper-controls-highlighted .cropper-line.line-w,
        .cropper-controls-highlighted .cropper-line.line-e {
            width: 6px !important;
            height: auto !important;
        }
    }

    .cropper-bg {
        background-image: none !important;
    }

    /* Custom range slider styling */
    input[type="range"]::-webkit-slider-thumb {
        appearance: none;
        width: 20px;
        height: 20px;
        background: #12463c;
        cursor: pointer;
        border-radius: 50%;
    }

    input[type="range"]::-moz-range-thumb {
        width: 20px;
        height: 20px;
        background: #12463c;
        cursor: pointer;
        border-radius: 50%;
        border: none;
    }

    /* Active filter button */
    .filter-btn.active {
        border-color: #12463c !important;
        background-color: #12463c !important;
        color: white !important;
    }

    /* Prevent body scroll when modal is open */
    body.modal-open {
        overflow: hidden;
    }

    /* Animation for mobile crop hint */
    @keyframes fadeInOut {
        0% {
            opacity: 0;
            transform: translateX(-50%) translateY(10px);
        }
        15% {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
        85% {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
        100% {
            opacity: 0;
            transform: translateX(-50%) translateY(-10px);
        }
    }


    /* Touch-friendly controls on mobile */
    @media (max-width: 1024px) {
        .mode-controls input[type="range"] {
            height: 32px;
            -webkit-appearance: none;
            appearance: none;
            background: transparent;
        }

        .mode-controls input[type="range"]::-webkit-slider-thumb {
            width: 24px;
            height: 24px;
        }

        .mode-controls input[type="range"]::-moz-range-thumb {
            width: 24px;
            height: 24px;
        }
    }
</style>

<script>
    // ============================================
    // GLOBAL STATE
    // ============================================
    let uploadedImages = Array(9).fill(null);
    let editedImages = Array(9).fill(null);
    let editStates = Array(9).fill(null); // Store filter and crop states
    let currentEditIndex = null;
    let cropper = null;
    let currentFilters = {
        brightness: 100,
        contrast: 100,
        saturation: 100,
        exposure: 0,
        warmth: 0,
        blur: 0,
        sepia: 0,
        grayscale: 0
    };
    let targetSlotIndex = null; // Track which slot should receive the uploaded image

    // ============================================
    // MOBILE INTERACTION HELPERS
    // ============================================

    /**
     * Show hint message for mobile image interactions
     */
    function showMobileImageHint(message) {
        // Remove any existing hint
        const existingHint = document.querySelector('.mobile-image-hint');
        if (existingHint) {
            existingHint.remove();
        }

        // Create hint element
        const hint = document.createElement('div');
        hint.className = 'mobile-image-hint';
        hint.textContent = message;
        hint.style.cssText = `
            position: fixed;
            top: 80px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(18, 70, 60, 0.95);
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            z-index: 10000;
            animation: fadeInOut 2s ease-in-out;
            pointer-events: none;
            max-width: 90%;
            text-align: center;
        `;

        document.body.appendChild(hint);

        // Remove after animation
        setTimeout(() => {
            hint.remove();
        }, 2000);
    }

    // ============================================
    // UPLOAD FUNCTIONALITY
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        const dropzone = document.getElementById('dropzone');
        const fileInput = document.getElementById('file-input');
        const selectPhotosBtn = document.getElementById('select-photos-btn');

        // Close all overlays when clicking outside on mobile
        document.addEventListener('click', function(e) {
            if (window.innerWidth < 1024) {
                const clickedInsideImage = e.target.closest('.relative.group.cursor-pointer');
                if (!clickedInsideImage) {
                    document.querySelectorAll('.image-overlay').forEach(overlay => {
                        overlay.classList.remove('opacity-100');
                        overlay.classList.add('opacity-0');
                    });
                }
            }
        });

        // Button click handler - only open if there are empty slots
        selectPhotosBtn.addEventListener('click', () => {
            const hasEmptySlot = uploadedImages.some(img => img === null);
            if (hasEmptySlot) {
                fileInput.click();
            }
        });

        // Prevent default drag behaviors
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        // Highlight drop zone when dragging over it
        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            dropzone.classList.add('border-dark-turquoise', 'bg-gray-50');
        }

        function unhighlight(e) {
            dropzone.classList.remove('border-dark-turquoise', 'bg-gray-50');
        }

        // Handle dropped files
        dropzone.addEventListener('drop', handleDrop, false);
        dropzone.addEventListener('click', () => {
            // Only open file picker if there are empty slots
            const hasEmptySlot = uploadedImages.some(img => img === null);
            if (hasEmptySlot) {
                fileInput.click();
            }
        });

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(files);
        }

        // Handle file selection
        fileInput.addEventListener('change', function(e) {
            handleFiles(this.files);
            // Clear the input value to allow re-uploading the same file
            this.value = '';
        });

        function handleFiles(files) {
            if (files.length === 0) {
                targetSlotIndex = null; // Reset if no files
                return;
            }

            const validFiles = Array.from(files).filter(file => {
                if (!file.type.match('image/(png|jpeg|jpg)')) {
                    alert(`El archivo ${file.name} no es una imagen válida (PNG, JPG o JPEG).`);
                    return false;
                }
                if (file.size > 10 * 1024 * 1024) {
                    alert(`El archivo ${file.name} excede el tamaño máximo de 10MB.`);
                    return false;
                }
                return true;
            });

            if (validFiles.length === 0) {
                targetSlotIndex = null; // Reset if no valid files
                return;
            }

            // Check if we're uploading to a specific slot
            if (targetSlotIndex !== null) {
                // Single file upload to specific slot
                const file = validFiles[0];
                const slotIndex = targetSlotIndex; // Store it before reset
                targetSlotIndex = null; // Reset immediately

                const reader = new FileReader();
                reader.onload = function(e) {
                    uploadedImages[slotIndex] = e.target.result;
                    renderGrid();
                };
                reader.readAsDataURL(file);
                return;
            }

            // Multiple file upload to empty slots
            // Show progress
            const progressContainer = document.getElementById('progress-container');
            const progressBar = document.getElementById('progress-bar');
            const progressText = document.getElementById('progress-text');
            progressContainer.classList.remove('hidden');

            let loaded = 0;
            const total = validFiles.length;

            validFiles.forEach((file, index) => {
                const reader = new FileReader();

                reader.onload = function(e) {
                    // Find next empty slot
                    const emptyIndex = uploadedImages.findIndex(img => img === null);
                    if (emptyIndex !== -1 && emptyIndex < 9) {
                        uploadedImages[emptyIndex] = e.target.result;
                        // Render grid immediately after each image is loaded
                        renderGrid();
                    }

                    loaded++;
                    const progress = Math.round((loaded / total) * 100);
                    progressBar.style.width = progress + '%';
                    progressText.textContent = progress + '%';

                    if (loaded === total) {
                        setTimeout(() => {
                            progressContainer.classList.add('hidden');
                            showImageGrid();
                        }, 500);
                    }
                };

                reader.readAsDataURL(file);
            });
        }
    });

    function showImageGrid() {
        // Both areas are always visible now - just render the grid
        renderGrid();
    }

    function renderGrid() {
        const gridItems = document.querySelectorAll('.grid-item');
        let readyCount = 0;

        gridItems.forEach((item, index) => {
            item.innerHTML = '';

            if (editedImages[index] || uploadedImages[index]) {
                const imgSrc = editedImages[index] || uploadedImages[index];
                const isEdited = editedImages[index] !== null;

                const imgContainer = document.createElement('div');
                imgContainer.className = 'relative w-full h-full group';

                const img = document.createElement('img');
                img.className = 'w-full h-full object-cover rounded-lg';

                // Pre-load image to ensure it displays immediately
                img.style.opacity = '0';

                // Use both onload and decode() for better compatibility
                const showImage = () => {
                    img.style.opacity = '1';
                    img.style.transition = 'opacity 0.2s ease-in-out';
                };

                img.onload = showImage;
                img.onerror = () => {
                    console.error('Error loading image at index', index);
                    img.style.opacity = '1'; // Show anyway
                };

                // Set src BEFORE appending to DOM for better loading
                img.src = imgSrc;

                // Use decode() if available for smoother rendering
                if (img.decode) {
                    img.decode().then(showImage).catch(() => showImage());
                }

                // Add green checkmark if image is edited
                if (isEdited) {
                    const checkmark = document.createElement('div');
                    checkmark.className = 'absolute top-1 right-1 bg-green-500 text-white rounded-full p-1 shadow-lg';
                    checkmark.innerHTML = `
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                `;
                    imgContainer.appendChild(checkmark);
                }

                const overlay = document.createElement('div');
                overlay.className = 'image-overlay absolute inset-0 bg-black/50 opacity-0 lg:group-hover:opacity-100 transition-opacity duration-300 rounded-lg';
                overlay.dataset.index = index;

                // Edit button (center)
                const editBtn = document.createElement('button');
                editBtn.innerHTML = `
                <svg class="w-5 h-5 lg:w-4 lg:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            `;
                editBtn.className = 'absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 p-2 lg:p-1.5 bg-yellow-500 text-white rounded-full hover:bg-yellow-600 transition-all shadow-lg overlay-button';
                editBtn.dataset.action = 'edit';
                editBtn.dataset.index = index;
                editBtn.onclick = (e) => {
                    e.stopPropagation();

                    if (window.innerWidth >= 1024) {
                        // Desktop: execute immediately
                        openEditor(index);
                    } else {
                        // Mobile: check if overlay is visible
                        const isVisible = overlay.classList.contains('opacity-100');

                        if (isVisible) {
                            // Overlay is visible, execute action
                            openEditor(index);
                        } else {
                            // Overlay not visible, show it first
                            document.querySelectorAll('.image-overlay').forEach(o => {
                                o.classList.remove('opacity-100');
                                o.classList.add('opacity-0');
                            });
                            overlay.classList.add('opacity-100');
                            overlay.classList.remove('opacity-0');
                            showMobileImageHint('Selecciona una acción');
                        }
                    }
                };

                // Duplicate button (bottom left)
                const duplicateBtn = document.createElement('button');
                duplicateBtn.innerHTML = `
                <svg class="w-5 h-5 lg:w-4 lg:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                </svg>
            `;
                duplicateBtn.className = 'absolute bottom-2 left-2 p-2 lg:p-1.5 bg-blue-500 text-white rounded-full hover:bg-blue-600 transition-all shadow-lg overlay-button';
                duplicateBtn.dataset.action = 'duplicate';
                duplicateBtn.dataset.index = index;
                duplicateBtn.onclick = (e) => {
                    e.stopPropagation();

                    if (window.innerWidth >= 1024) {
                        // Desktop: execute immediately
                        duplicateImage(index);
                    } else {
                        // Mobile: check if overlay is visible
                        const isVisible = overlay.classList.contains('opacity-100');

                        if (isVisible) {
                            // Overlay is visible, execute action
                            duplicateImage(index);
                        } else {
                            // Overlay not visible, show it first
                            document.querySelectorAll('.image-overlay').forEach(o => {
                                o.classList.remove('opacity-100');
                                o.classList.add('opacity-0');
                            });
                            overlay.classList.add('opacity-100');
                            overlay.classList.remove('opacity-0');
                            showMobileImageHint('Selecciona una acción');
                        }
                    }
                };

                // Delete button (bottom right)
                const deleteBtn = document.createElement('button');
                deleteBtn.innerHTML = `
                <svg class="w-5 h-5 lg:w-4 lg:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            `;
                deleteBtn.className = 'absolute bottom-2 right-2 p-2 lg:p-1.5 bg-red-500 text-white rounded-full hover:bg-red-600 transition-all shadow-lg overlay-button';
                deleteBtn.dataset.action = 'delete';
                deleteBtn.dataset.index = index;
                deleteBtn.onclick = (e) => {
                    e.stopPropagation();

                    if (window.innerWidth >= 1024) {
                        // Desktop: execute immediately
                        deleteImage(index);
                    } else {
                        // Mobile: check if overlay is visible
                        const isVisible = overlay.classList.contains('opacity-100');

                        if (isVisible) {
                            // Overlay is visible, execute action
                            deleteImage(index);
                        } else {
                            // Overlay not visible, show it first
                            document.querySelectorAll('.image-overlay').forEach(o => {
                                o.classList.remove('opacity-100');
                                o.classList.add('opacity-0');
                            });
                            overlay.classList.add('opacity-100');
                            overlay.classList.remove('opacity-0');
                            showMobileImageHint('Selecciona una acción');
                        }
                    }
                };

                overlay.appendChild(editBtn);
                overlay.appendChild(duplicateBtn);
                overlay.appendChild(deleteBtn);

                // Desktop: Click on overlay background (not on buttons) to edit
                overlay.onclick = (e) => {
                    if (window.innerWidth >= 1024 && e.target === overlay) {
                        openEditor(index);
                    }
                };

                // Mobile: Single tap to show overlay with options
                imgContainer.onclick = (e) => {
                    if (window.innerWidth < 1024) { // Mobile/tablet
                        e.stopPropagation();

                        const isCurrentlyVisible = overlay.classList.contains('opacity-100');

                        // Hide all other overlays
                        document.querySelectorAll('.image-overlay').forEach(o => {
                            o.classList.remove('opacity-100');
                            o.classList.add('opacity-0');
                        });

                        // Toggle this overlay (show if hidden, hide if visible)
                        if (!isCurrentlyVisible) {
                            overlay.classList.add('opacity-100');
                            overlay.classList.remove('opacity-0');
                            showMobileImageHint('Selecciona una acción');
                        }
                    }
                };
                imgContainer.appendChild(img);
                imgContainer.appendChild(overlay);
                item.appendChild(imgContainer);

                item.classList.remove('border-dashed', 'border-gray-300');
                item.classList.add('border-solid', 'border-dark-turquoise');

                // Only count as ready if image has been edited and saved
                if (isEdited) {
                    readyCount++;
                }
            } else {
                const placeholder = document.createElement('div');
                placeholder.className = 'text-center';
                placeholder.innerHTML = `
                <div class="text-2xl text-gray-300 mb-0.5">+</div>
                <p class="text-xs text-gray-400">Foto ${index + 1}</p>
            `;
                item.appendChild(placeholder);
                item.classList.remove('border-solid', 'border-dark-turquoise');
                item.classList.add('border-dashed', 'border-gray-300');
            }

            // Click handler for empty slots
            item.onclick = uploadedImages[index] ? null : () => {
                const input = document.getElementById('file-input');

                // Clear previous value
                input.value = '';

                // Set target slot index
                targetSlotIndex = index;

                // Open file picker
                input.click();
            };

            // Drag and drop handlers for individual slots
            if (!uploadedImages[index]) {
                // Prevent default drag behaviors
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    item.addEventListener(eventName, function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                    }, false);
                });

                // Highlight slot when dragging over it
                item.addEventListener('dragenter', function(e) {
                    this.classList.add('border-dark-turquoise', 'bg-gray-50');
                });

                item.addEventListener('dragleave', function(e) {
                    // Only remove highlight if we're actually leaving the item
                    if (e.target === this) {
                        this.classList.remove('border-dark-turquoise', 'bg-gray-50');
                    }
                });

                // Handle drop
                item.addEventListener('drop', function(e) {
                    this.classList.remove('border-dark-turquoise', 'bg-gray-50');

                    const files = e.dataTransfer.files;
                    if (files.length > 0) {
                        const file = files[0];

                        // Validate file type
                        if (!file.type.match('image/(png|jpeg|jpg)')) {
                            alert('Por favor selecciona una imagen válida (PNG, JPG o JPEG).');
                            return;
                        }

                        // Validate file size
                        if (file.size > 10 * 1024 * 1024) {
                            alert('El archivo excede el tamaño máximo de 10MB.');
                            return;
                        }

                        // Read and upload the file
                        const reader = new FileReader();
                        reader.onload = function(readerEvent) {
                            uploadedImages[index] = readerEvent.target.result;
                            renderGrid();
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        });

        document.getElementById('images-ready').textContent = `${readyCount}/9`;

        const addToCartBtn = document.getElementById('add-to-cart-btn');
        if (readyCount === 9) {
            addToCartBtn.disabled = false;
            addToCartBtn.classList.remove('bg-gray-300', 'text-gray-500', 'cursor-not-allowed');
            addToCartBtn.classList.add('bg-dark-turquoise', 'text-white', 'cursor-pointer', 'hover:bg-gray-brown');
        } else {
            addToCartBtn.disabled = true;
            addToCartBtn.classList.remove('bg-dark-turquoise', 'text-white', 'cursor-pointer', 'hover:bg-gray-brown');
            addToCartBtn.classList.add('bg-gray-300', 'text-gray-500', 'cursor-not-allowed');
        }
    }

    function deleteImage(index) {
        if (confirm('¿Estás seguro de que quieres eliminar esta imagen?')) {
            uploadedImages[index] = null;
            editedImages[index] = null;
            editStates[index] = null;
            renderGrid();
        }
    }

    function duplicateImage(index) {
        // Find the next empty slot
        const emptySlotIndex = uploadedImages.findIndex(img => img === null);

        if (emptySlotIndex === -1) {
            alert('No hay espacios disponibles. Elimina una imagen primero.');
            return;
        }

        // Duplicate the original image
        uploadedImages[emptySlotIndex] = uploadedImages[index];

        // Duplicate the edited image (if exists)
        if (editedImages[index]) {
            editedImages[emptySlotIndex] = editedImages[index];
        }

        // Duplicate the edit state (filters and crop data)
        if (editStates[index]) {
            editStates[emptySlotIndex] = {
                filters: { ...editStates[index].filters },
                cropData: editStates[index].cropData ? { ...editStates[index].cropData } : null
            };
        }

        // Re-render grid
        renderGrid();
    }

    function resetUploadArea() {
        if (confirm('¿Estás seguro de que quieres volver a empezar? Se perderán todas las imágenes cargadas.')) {
            uploadedImages = Array(9).fill(null);
            editedImages = Array(9).fill(null);
            editStates = Array(9).fill(null);
            document.getElementById('progress-bar').style.width = '0%';
            document.getElementById('progress-text').textContent = '0%';
            renderGrid();
        }
    }

    // ============================================
    // IMAGE EDITOR FUNCTIONALITY
    // ============================================
    function openEditor(index) {
        currentEditIndex = index;
        // Always load the original image so users can re-crop from different areas
        const imageSrc = uploadedImages[index];

        // Show modal and prevent body scroll
        document.getElementById('editor-modal').classList.remove('hidden');
        document.body.classList.add('modal-open');

        // Load saved state if exists, otherwise reset
        if (editStates[index]) {
            currentFilters = {
                ...editStates[index].filters
            };
            updateSliderValues();
        } else {
            resetAllFilters();
        }

        // Clean up existing cropper and listeners BEFORE setting new image
        const existingContainer = document.querySelector('.cropper-container');
        if (existingContainer) {
            existingContainer.removeEventListener('wheel', handleCropBoxZoom);
        }

        if (cropper) {
            cropper.destroy();
            cropper = null;
        }

        // Initialize image
        const cropImage = document.getElementById('crop-image');
        cropImage.src = '';  // Clear first

        // Initialize Cropper.js
        setTimeout(() => {
            // Now set the actual image source
            cropImage.src = imageSrc;

            // Wait for image to load before initializing cropper
            cropImage.onload = function() {
                // Set container height for mobile responsiveness
                const wrapper = document.getElementById('cropper-wrapper');
                const wrapperWidth = wrapper.offsetWidth;
                wrapper.style.height = wrapperWidth + 'px'; // Force square aspect ratio

                // Adjust minimum crop box size for mobile
                const isMobile = window.innerWidth < 768;
                const minCropBoxSize = isMobile ? 150 : 200;

                const cropperOptions = {
                aspectRatio: 1, // Square crop (1:1)
                viewMode: 1, // Crop box (644x644) must stay within the canvas (no puede salirse de la imagen)
                dragMode: 'none', // Imagen fija (no se mueve)
                autoCropArea: 0.9316, // 600/644 = 0.9316 (relación entre cuadro de referencia y guía de recorte)
                restore: false,
                guides: true,
                center: true,
                highlight: true,
                background: true,
                cropBoxMovable: true, // Recuadro SÍ se puede mover
                cropBoxResizable: true, // Recuadro SÍ se puede redimensionar
                toggleDragModeOnDblclick: false,
                movable: false, // La imagen NO se mueve (está fija)
                zoomable: false, // No zoom de imagen
                zoomOnWheel: false, // No zoom con rueda
                minCropBoxWidth: minCropBoxSize,
                minCropBoxHeight: minCropBoxSize,
                ready: function() {
                    // Restore crop data if exists
                    if (editStates[index] && editStates[index].cropData) {
                        cropper.setData(editStates[index].cropData);
                    }
                    // Apply filters once Cropper is ready
                    applyFiltersToImage();

                    // Añadir evento de rueda del ratón para redimensionar crop box
                    // Usar setTimeout para asegurar que el DOM está completamente renderizado
                    setTimeout(() => {
                        const cropperContainer = document.querySelector('.cropper-container');
                        if (cropperContainer) {
                            // Remover listener previo si existe (para evitar duplicados)
                            cropperContainer.removeEventListener('wheel', handleCropBoxZoom);
                            // Agregar nuevo listener
                            cropperContainer.addEventListener('wheel', handleCropBoxZoom, { passive: false });

                            // Mobile double-tap for crop controls
                            if (window.innerWidth < 768) {
                                setupMobileDoubleTap(cropperContainer);
                            }
                        }
                    }, 50);
                }
                };

                cropper = new Cropper(cropImage, cropperOptions);

                // Switch to crop mode
                switchMode('crop');
            };
        }, 100);
    }

    /**
     * Handle mouse wheel to resize crop box (instead of zooming image)
     */
    function handleCropBoxZoom(e) {
        if (!cropper) return;

        e.preventDefault();

        // Get current crop box data
        const cropBoxData = cropper.getCropBoxData();

        // Calculate zoom factor based on wheel direction
        const delta = e.deltaY || e.detail || e.wheelDelta;
        const zoomFactor = delta > 0 ? 0.95 : 1.05; // Scroll down = smaller, scroll up = bigger

        // Calculate new dimensions
        let newWidth = cropBoxData.width * zoomFactor;
        let newHeight = cropBoxData.height * zoomFactor;

        // Get container dimensions to limit max size
        const containerData = cropper.getContainerData();
        const maxSize = Math.min(containerData.width, containerData.height);

        // Set minimum size (same as minCropBoxSize)
        const isMobile = window.innerWidth < 768;
        const minSize = isMobile ? 150 : 200;

        // Apply limits
        newWidth = Math.max(minSize, Math.min(newWidth, maxSize));
        newHeight = Math.max(minSize, Math.min(newHeight, maxSize));

        // Calculate new position to keep crop box centered
        const newLeft = cropBoxData.left + (cropBoxData.width - newWidth) / 2;
        const newTop = cropBoxData.top + (cropBoxData.height - newHeight) / 2;

        // Apply new crop box dimensions
        cropper.setCropBoxData({
            left: newLeft,
            top: newTop,
            width: newWidth,
            height: newHeight
        });
    }

    /**
     * Setup mobile double-tap interaction for crop controls
     */
    function setupMobileDoubleTap(cropperContainer) {
        let touchTimeout = null;
        let isControlsHighlighted = false;
        let controlInteractionEnabled = false;

        // Find the crop box element
        const cropBox = cropperContainer.querySelector('.cropper-crop-box');
        if (!cropBox) return;

        // Handler for first touch - highlight controls
        const handleFirstTouch = (e) => {
            // If controls are already highlighted, allow normal interaction
            if (controlInteractionEnabled) {
                return;
            }

            // Check if user touched a control element
            const isCropControl = e.target.classList.contains('cropper-point') ||
                                  e.target.classList.contains('cropper-line');

            if (isCropControl) {
                e.preventDefault();
                e.stopPropagation();

                // Highlight the controls
                cropperContainer.classList.add('cropper-controls-highlighted');
                isControlsHighlighted = true;

                // Show a brief message
                showMobileCropHint('Toca nuevamente para ajustar');

                // Enable control interaction after highlighting
                setTimeout(() => {
                    controlInteractionEnabled = true;
                }, 300);

                // Auto-hide highlight after 3 seconds
                clearTimeout(touchTimeout);
                touchTimeout = setTimeout(() => {
                    cropperContainer.classList.remove('cropper-controls-highlighted');
                    isControlsHighlighted = false;
                    controlInteractionEnabled = false;
                }, 3000);
            }
        };

        // Handler for touches on the crop box (not controls)
        const handleCropBoxTouch = (e) => {
            // If user touches the crop box (not controls), remove highlight
            const isCropControl = e.target.classList.contains('cropper-point') ||
                                  e.target.classList.contains('cropper-line');

            if (!isCropControl && isControlsHighlighted) {
                cropperContainer.classList.remove('cropper-controls-highlighted');
                isControlsHighlighted = false;
                controlInteractionEnabled = false;
                clearTimeout(touchTimeout);
            }
        };

        // Attach touch event listeners
        cropBox.addEventListener('touchstart', handleFirstTouch, { passive: false });
        cropperContainer.addEventListener('touchstart', handleCropBoxTouch);
    }

    /**
     * Show a brief hint message for mobile crop interaction
     */
    function showMobileCropHint(message) {
        // Remove any existing hint
        const existingHint = document.querySelector('.mobile-crop-hint');
        if (existingHint) {
            existingHint.remove();
        }

        // Create hint element
        const hint = document.createElement('div');
        hint.className = 'mobile-crop-hint';
        hint.textContent = message;
        hint.style.cssText = `
            position: fixed;
            bottom: 120px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(18, 70, 60, 0.95);
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            z-index: 10000;
            animation: fadeInOut 2s ease-in-out;
            pointer-events: none;
        `;

        document.body.appendChild(hint);

        // Remove after animation
        setTimeout(() => {
            hint.remove();
        }, 2000);
    }

    function closeEditor() {
        if (confirm('¿Cerrar el editor? Los cambios no guardados se perderán.')) {
            document.getElementById('editor-modal').classList.add('hidden');
            document.body.classList.remove('modal-open');

            // Remove wheel event listener
            const cropperContainer = document.querySelector('.cropper-container');
            if (cropperContainer) {
                cropperContainer.removeEventListener('wheel', handleCropBoxZoom);
            }

            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
            currentEditIndex = null;
        }
    }

    function saveImage() {
        if (!cropper) return;

        // Save current state (filters and crop data) for future edits
        editStates[currentEditIndex] = {
            filters: {
                ...currentFilters
            },
            cropData: cropper.getData()
        };

        // Get cropped canvas
        const canvas = cropper.getCroppedCanvas({
            width: 600,
            height: 600,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high'
        });

        // Create a new canvas to apply filters
        const finalCanvas = document.createElement('canvas');
        finalCanvas.width = canvas.width;
        finalCanvas.height = canvas.height;
        const ctx = finalCanvas.getContext('2d');

        // Apply CSS filters to the context
        const filterString = buildFilterString();
        ctx.filter = filterString;

        // Draw the cropped image with filters applied
        ctx.drawImage(canvas, 0, 0);

        // Save to edited images as PNG (lossless quality for printing)
        editedImages[currentEditIndex] = finalCanvas.toDataURL('image/png');

        // Close editor
        document.getElementById('editor-modal').classList.add('hidden');
        document.body.classList.remove('modal-open');

        // Remove wheel event listener before destroying cropper
        const cropperContainer = document.querySelector('.cropper-container');
        if (cropperContainer) {
            cropperContainer.removeEventListener('wheel', handleCropBoxZoom);
        }

        if (cropper) {
            cropper.destroy();
            cropper = null;
        }

        // Re-render grid
        renderGrid();
    }

    function rotateImage() {
        if (cropper) {
            cropper.rotate(90);
        }
    }

    // ============================================
    // MODE SWITCHING
    // ============================================
    function switchMode(mode) {
        // Update tabs
        document.querySelectorAll('.mode-tab').forEach(tab => {
            if (tab.dataset.mode === mode) {
                tab.classList.add('active', 'border-dark-turquoise', 'text-dark-turquoise');
                tab.classList.remove('border-transparent', 'text-gray-500');
            } else {
                tab.classList.remove('active', 'border-dark-turquoise', 'text-dark-turquoise');
                tab.classList.add('border-transparent', 'text-gray-500');
            }
        });

        // Update controls
        document.querySelectorAll('.mode-controls').forEach(control => {
            control.classList.add('hidden');
        });

        document.getElementById(`${mode}-controls`).classList.remove('hidden');
    }

    // ============================================
    // ADJUSTMENT CONTROLS
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        // Brightness
        const brightnessSlider = document.getElementById('brightness');
        const brightnessValue = document.getElementById('brightness-value');
        if (brightnessSlider) {
            brightnessSlider.addEventListener('input', function() {
                currentFilters.brightness = this.value;
                brightnessValue.textContent = this.value + '%';
                applyFiltersToImage();
            });
        }

        // Contrast
        const contrastSlider = document.getElementById('contrast');
        const contrastValue = document.getElementById('contrast-value');
        if (contrastSlider) {
            contrastSlider.addEventListener('input', function() {
                currentFilters.contrast = this.value;
                contrastValue.textContent = this.value + '%';
                applyFiltersToImage();
            });
        }

        // Saturation
        const saturationSlider = document.getElementById('saturation');
        const saturationValue = document.getElementById('saturation-value');
        if (saturationSlider) {
            saturationSlider.addEventListener('input', function() {
                currentFilters.saturation = this.value;
                saturationValue.textContent = this.value + '%';
                applyFiltersToImage();
            });
        }

        // Exposure
        const exposureSlider = document.getElementById('exposure');
        const exposureValue = document.getElementById('exposure-value');
        if (exposureSlider) {
            exposureSlider.addEventListener('input', function() {
                currentFilters.exposure = this.value;
                exposureValue.textContent = this.value + '%';
                applyFiltersToImage();
            });
        }

        // Warmth
        const warmthSlider = document.getElementById('warmth');
        const warmthValue = document.getElementById('warmth-value');
        if (warmthSlider) {
            warmthSlider.addEventListener('input', function() {
                currentFilters.warmth = this.value;
                warmthValue.textContent = this.value;
                applyFiltersToImage();
            });
        }

        // Blur
        const blurSlider = document.getElementById('blur');
        const blurValue = document.getElementById('blur-value');
        if (blurSlider) {
            blurSlider.addEventListener('input', function() {
                currentFilters.blur = this.value;
                blurValue.textContent = this.value + 'px';
                applyFiltersToImage();
            });
        }

        // Sepia
        const sepiaSlider = document.getElementById('sepia');
        const sepiaValue = document.getElementById('sepia-value');
        if (sepiaSlider) {
            sepiaSlider.addEventListener('input', function() {
                currentFilters.sepia = this.value;
                sepiaValue.textContent = this.value + '%';
                applyFiltersToImage();
            });
        }

        // Grayscale
        const grayscaleSlider = document.getElementById('grayscale');
        const grayscaleValue = document.getElementById('grayscale-value');
        if (grayscaleSlider) {
            grayscaleSlider.addEventListener('input', function() {
                currentFilters.grayscale = this.value;
                grayscaleValue.textContent = this.value + '%';
                applyFiltersToImage();
            });
        }
    });

    function resetAdjustments() {
        currentFilters = {
            brightness: 100,
            contrast: 100,
            saturation: 100,
            exposure: 0,
            warmth: 0,
            blur: 0,
            sepia: 0,
            grayscale: 0
        };

        // Reset sliders - with null checks
        const brightnessSlider = document.getElementById('brightness');
        const contrastSlider = document.getElementById('contrast');
        const saturationSlider = document.getElementById('saturation');
        const exposureSlider = document.getElementById('exposure');
        const warmthSlider = document.getElementById('warmth');
        const blurSlider = document.getElementById('blur');
        const sepiaSlider = document.getElementById('sepia');
        const grayscaleSlider = document.getElementById('grayscale');

        if (brightnessSlider) {
            brightnessSlider.value = 100;
            document.getElementById('brightness-value').textContent = '100%';
        }
        if (contrastSlider) {
            contrastSlider.value = 100;
            document.getElementById('contrast-value').textContent = '100%';
        }
        if (saturationSlider) {
            saturationSlider.value = 100;
            document.getElementById('saturation-value').textContent = '100%';
        }
        if (exposureSlider) {
            exposureSlider.value = 0;
            document.getElementById('exposure-value').textContent = '0%';
        }
        if (warmthSlider) {
            warmthSlider.value = 0;
            document.getElementById('warmth-value').textContent = '0';
        }
        if (blurSlider) {
            blurSlider.value = 0;
            document.getElementById('blur-value').textContent = '0px';
        }
        if (sepiaSlider) {
            sepiaSlider.value = 0;
            document.getElementById('sepia-value').textContent = '0%';
        }
        if (grayscaleSlider) {
            grayscaleSlider.value = 0;
            document.getElementById('grayscale-value').textContent = '0%';
        }

        applyFiltersToImage();
    }

    function resetAllFilters() {
        resetAdjustments();
        // Remove active class from all filter buttons
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('active');
        });
    }

    // ============================================
    // FILTER PRESETS
    // ============================================
    function applyFilter(filterName) {
        // Remove active from all buttons
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('active');
        });

        // Add active to clicked button
        event.target.classList.add('active');

        switch (filterName) {
            case 'original':
                resetAdjustments();
                break;
            case 'bw':
                currentFilters = {
                    brightness: 100,
                    contrast: 110,
                    saturation: 0,
                    exposure: 0,
                    warmth: 0,
                    blur: 0,
                    sepia: 0,
                    grayscale: 100
                };
                break;
            case 'sepia':
                currentFilters = {
                    brightness: 100,
                    contrast: 90,
                    saturation: 80,
                    exposure: 0,
                    warmth: 0,
                    blur: 0,
                    sepia: 80,
                    grayscale: 0
                };
                break;
            case 'vibrant':
                currentFilters = {
                    brightness: 110,
                    contrast: 120,
                    saturation: 150,
                    exposure: 10,
                    warmth: 0,
                    blur: 0,
                    sepia: 0,
                    grayscale: 0
                };
                break;
            case 'cool':
                currentFilters = {
                    brightness: 100,
                    contrast: 105,
                    saturation: 110,
                    exposure: 0,
                    warmth: -30,
                    blur: 0,
                    sepia: 0,
                    grayscale: 0
                };
                break;
            case 'warm':
                currentFilters = {
                    brightness: 105,
                    contrast: 100,
                    saturation: 120,
                    exposure: 5,
                    warmth: 40,
                    blur: 0,
                    sepia: 0,
                    grayscale: 0
                };
                break;
            case 'vintage':
                currentFilters = {
                    brightness: 95,
                    contrast: 85,
                    saturation: 70,
                    exposure: -5,
                    warmth: 20,
                    blur: 0.5,
                    sepia: 40,
                    grayscale: 0
                };
                break;
        }

        updateSliderValues();
        applyFiltersToImage();
    }

    function updateSliderValues() {
        const brightness = document.getElementById('brightness');
        const brightnessValue = document.getElementById('brightness-value');
        if (brightness && brightnessValue) {
            brightness.value = currentFilters.brightness;
            brightnessValue.textContent = currentFilters.brightness + '%';
        }

        const contrast = document.getElementById('contrast');
        const contrastValue = document.getElementById('contrast-value');
        if (contrast && contrastValue) {
            contrast.value = currentFilters.contrast;
            contrastValue.textContent = currentFilters.contrast + '%';
        }

        const saturation = document.getElementById('saturation');
        const saturationValue = document.getElementById('saturation-value');
        if (saturation && saturationValue) {
            saturation.value = currentFilters.saturation;
            saturationValue.textContent = currentFilters.saturation + '%';
        }

        const exposure = document.getElementById('exposure');
        const exposureValue = document.getElementById('exposure-value');
        if (exposure && exposureValue) {
            exposure.value = currentFilters.exposure;
            exposureValue.textContent = currentFilters.exposure + '%';
        }

        const warmth = document.getElementById('warmth');
        const warmthValue = document.getElementById('warmth-value');
        if (warmth && warmthValue) {
            warmth.value = currentFilters.warmth;
            warmthValue.textContent = currentFilters.warmth;
        }

        const blur = document.getElementById('blur');
        const blurValue = document.getElementById('blur-value');
        if (blur && blurValue) {
            blur.value = currentFilters.blur;
            blurValue.textContent = currentFilters.blur + 'px';
        }

        const sepia = document.getElementById('sepia');
        const sepiaValue = document.getElementById('sepia-value');
        if (sepia && sepiaValue) {
            sepia.value = currentFilters.sepia;
            sepiaValue.textContent = currentFilters.sepia + '%';
        }

        const grayscale = document.getElementById('grayscale');
        const grayscaleValue = document.getElementById('grayscale-value');
        if (grayscale && grayscaleValue) {
            grayscale.value = currentFilters.grayscale;
            grayscaleValue.textContent = currentFilters.grayscale + '%';
        }
    }

    function applyFiltersToImage() {
        const filterString = buildFilterString();

        // Apply filters to the container that Cropper.js uses
        if (cropper) {
            const cropperContainer = document.querySelector('.cropper-container');
            if (cropperContainer) {
                // Apply to the main container
                cropperContainer.style.filter = filterString;
            }

            // Also apply directly to the canvas images
            const cropperWrap = document.querySelector('.cropper-wrap-box');
            if (cropperWrap) {
                cropperWrap.style.filter = filterString;
            }
        }

        // Apply to the original image as fallback
        const cropImage = document.getElementById('crop-image');
        if (cropImage) {
            cropImage.style.filter = filterString;
        }
    }

    function buildFilterString() {
        const filters = [];

        // Calculate combined brightness (base + exposure)
        let totalBrightness = currentFilters.brightness;
        if (currentFilters.exposure !== 0) {
            const exposureFactor = 1 + (currentFilters.exposure / 100);
            totalBrightness = (totalBrightness * exposureFactor);
        }

        filters.push(`brightness(${totalBrightness}%)`);
        filters.push(`contrast(${currentFilters.contrast}%)`);
        filters.push(`saturate(${currentFilters.saturation}%)`);

        // Warmth (simulated with hue rotation)
        if (currentFilters.warmth !== 0) {
            filters.push(`hue-rotate(${currentFilters.warmth * 0.3}deg)`);
        }

        if (currentFilters.blur > 0) {
            filters.push(`blur(${currentFilters.blur}px)`);
        }

        if (currentFilters.sepia > 0) {
            filters.push(`sepia(${currentFilters.sepia}%)`);
        }

        if (currentFilters.grayscale > 0) {
            filters.push(`grayscale(${currentFilters.grayscale}%)`);
        }

        return filters.length > 0 ? filters.join(' ') : 'none';
    }

    /**
     * Process image to 600x600 square (center crop, like object-fit: cover)
     */
    async function processImageToSquare(imageDataUrl) {
        return new Promise((resolve) => {
            const img = new Image();
            img.onload = function() {
                const canvas = document.createElement('canvas');
                const size = 600;
                canvas.width = size;
                canvas.height = size;
                const ctx = canvas.getContext('2d');

                // Calculate dimensions for center crop (like object-fit: cover)
                const scale = Math.max(size / img.width, size / img.height);
                const scaledWidth = img.width * scale;
                const scaledHeight = img.height * scale;

                // Center the image
                const x = (size - scaledWidth) / 2;
                const y = (size - scaledHeight) / 2;

                // Draw image scaled and centered
                ctx.drawImage(img, x, y, scaledWidth, scaledHeight);

                // Convert to PNG (lossless quality)
                resolve(canvas.toDataURL('image/png'));
            };
            img.src = imageDataUrl;
        });
    }

    // ============================================
    // WEBP CONVERSION HELPER WITH RESIZE
    // ============================================
    async function convertToWebP(base64Image, maxSize = 644, quality = 0.65) {
        return new Promise((resolve, reject) => {
            const img = new Image();
            img.onload = function() {
                const canvas = document.createElement('canvas');

                // Resize if image is larger than maxSize
                let width = img.width;
                let height = img.height;

                if (width > maxSize || height > maxSize) {
                    if (width > height) {
                        height = (height / width) * maxSize;
                        width = maxSize;
                    } else {
                        width = (width / height) * maxSize;
                        height = maxSize;
                    }
                }

                canvas.width = width;
                canvas.height = height;

                const ctx = canvas.getContext('2d');
                // Use high-quality scaling
                ctx.imageSmoothingEnabled = true;
                ctx.imageSmoothingQuality = 'high';
                ctx.drawImage(img, 0, 0, width, height);

                // Convert to WebP with quality 65% (excellent visual quality, much smaller)
                const webpDataUrl = canvas.toDataURL('image/webp', quality);
                resolve(webpDataUrl);
            };
            img.onerror = reject;
            img.src = base64Image;
        });
    }

    // ============================================
    // BATCH UPLOAD HELPER (upload images in batches to avoid 403)
    // ============================================
    async function uploadImagesBatch(images, batchSize = 3) {
        const batches = [];
        for (let i = 0; i < images.length; i += batchSize) {
            batches.push(images.slice(i, i + batchSize));
        }

        console.log(`📦 Dividiendo ${images.length} imágenes en ${batches.length} lotes de ${batchSize}`);

        const uploadedPaths = [];

        for (let i = 0; i < batches.length; i++) {
            const batch = batches[i];
            const batchNumber = i + 1;

            console.log(`📤 Subiendo lote ${batchNumber}/${batches.length} (${batch.length} imágenes)...`);

            // Log payload size for debugging
            const payloadSize = JSON.stringify({batch, batch_number: batchNumber}).length;
            console.log(`📏 Tamaño del lote ${batchNumber}: ${(payloadSize / 1024).toFixed(2)}KB`);

            try {
                const response = await fetch('{{ route("personalizados.upload-batch") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        batch: batch,
                        batch_number: batchNumber,
                        total_batches: batches.length
                    })
                }).catch(err => {
                    console.error(`❌ Error de conexión en lote ${batchNumber}:`, err);
                    throw new Error(`Error de conexión: ${err.message}. Verifica que el servidor esté funcionando y que la ruta /upload-batch exista.`);
                });

                console.log(`✅ Respuesta recibida para lote ${batchNumber}, status: ${response.status}`);

                if (!response.ok) {
                    const text = await response.text();
                    console.error(`❌ Error HTTP en lote ${batchNumber}:`, response.status, text);
                    throw new Error(`Error ${response.status} al subir lote ${batchNumber}: ${text}`);
                }

                const data = await response.json();
                console.log(`📄 Datos del lote ${batchNumber}:`, data);

                if (!data.success) {
                    throw new Error(data.message || `Error en lote ${batchNumber}`);
                }

                uploadedPaths.push(...data.paths);
                console.log(`✅ Lote ${batchNumber} completado - ${data.paths.length} rutas agregadas`);

                // Small delay between batches to avoid overwhelming the server
                if (i < batches.length - 1) {
                    await new Promise(resolve => setTimeout(resolve, 500));
                }
            } catch (error) {
                console.error(`❌ Error capturado en lote ${batchNumber}:`, error);
                throw error;
            }
        }

        return uploadedPaths;
    }

    // ============================================
    // ADD TO CART FUNCTIONALITY (with batch upload)
    // ============================================
    document.getElementById('add-to-cart-btn')?.addEventListener('click', async function() {
        if (this.disabled) return;

        // Show processing modal
        document.getElementById('processing-modal').classList.remove('hidden');

        try {
            // Process ALL images to ensure they're 600x600
            const processedImages = await Promise.all(editedImages.map(async (img, index) => {
                // If image was edited, use that version
                if (img) {
                    return img;
                }

                // If not edited, process the original to make it 600x600
                const originalImg = uploadedImages[index];
                if (originalImg) {
                    return await processImageToSquare(originalImg);
                }

                return null;
            }));

            // Convert all images to WebP for smaller payload (maxSize 644px, quality 65%)
            const images = await Promise.all(
                processedImages.map(img => img ? convertToWebP(img, 644, 0.65) : Promise.resolve(null))
            );

            // Log size comparison (for debugging)
            const originalSize = JSON.stringify(processedImages).length;
            const webpSize = JSON.stringify(images).length;
            console.log(`📊 Tamaño original: ${(originalSize / 1024 / 1024).toFixed(2)}MB`);
            console.log(`📊 Tamaño WebP (644px, 65%): ${(webpSize / 1024 / 1024).toFixed(2)}MB`);
            console.log(`✅ Reducción: ${((1 - webpSize/originalSize) * 100).toFixed(1)}%`);

            // Upload images in batches of 3
            const imagePaths = await uploadImagesBatch(images, 3);

            console.log(`🎉 Todas las imágenes subidas. Agregando al carrito...`);

            // Add to cart with just the paths (not the base64 data)
            const response = await fetch('{{ route("personalizados.add-to-cart") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    image_paths: imagePaths
                })
            });

            if (!response.ok) {
                const text = await response.text();
                console.error('Status:', response.status);
                console.error('Body:', text);
                throw new Error('Error al agregar al carrito');
            }

            const data = await response.json();

            // Hide processing modal
            document.getElementById('processing-modal').classList.add('hidden');

            if (data.success) {
                // Redirect to cart
                window.location.href = data.redirect_url;
            } else {
                throw new Error(data.message || 'Error al agregar al carrito');
            }

        } catch (error) {
            console.error('Error:', error);
            alert('Hubo un error al agregar al carrito. Por favor intenta de nuevo.');
            document.getElementById('processing-modal').classList.add('hidden');
        }
    });

    // Close success modal
    document.getElementById('close-success-modal')?.addEventListener('click', function() {
        document.getElementById('success-modal').classList.add('hidden');
        // Reset the form
        uploadedImages = Array(9).fill(null);
        editedImages = Array(9).fill(null);
        editStates = Array(9).fill(null);
        renderGrid();
    });
</script>

@endsection