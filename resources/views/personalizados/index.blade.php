@extends('layouts.app')

@section('title', 'Imanes Personalizados - Imani Magnets')

@section('content')

<!-- Hero Section -->
<section class="bg-white py-4">
    <div class="container mx-auto px-6 max-w-6xl text-center">
        <h1 class="font-spartan text-2xl lg:text-3xl font-bold text-dark-turquoise mb-2">
            IMANES PERSONALIZADOS
        </h1>
        <p class="text-sm text-gray-brown">
            Sube 9 fotos para crear tu set de imanes 2x2"
        </p>
    </div>
</section>

<!-- Editor Section -->
<section class="bg-gray-50 py-4">
    <div class="container mx-auto px-6 max-w-6xl">

        <!-- Contenedor único que cambia de contenido -->
        <div class="bg-white rounded-lg shadow-lg p-4">

            <!-- PASO 1: Upload Area (visible al inicio) -->
            <div id="upload-area">
                <div class="text-center mb-3">
                    <h2 class="font-spartan text-xl font-bold text-dark-turquoise mb-2">
                        PASO 1: SUBE TUS FOTOS
                    </h2>
                </div>

                <!-- Drop Zone -->
                <div id="dropzone" class="border-3 border-dashed border-gray-orange rounded-lg p-6 text-center cursor-pointer hover:border-dark-turquoise transition-all duration-300">
                    <div class="mb-2">
                        <svg class="w-12 h-12 mx-auto text-gray-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                    </div>
                    <p class="font-spartan text-base font-semibold text-dark-turquoise mb-2">
                        Haz clic o arrastra tus fotos aquí
                    </p>
                    <p class="text-xs text-gray-brown mb-3">
                        PNG, JPG o JPEG (máximo 10MB)
                    </p>
                    <input type="file" id="file-input" accept="image/png,image/jpeg,image/jpg" multiple class="hidden">
                    <button onclick="document.getElementById('file-input').click()" class="px-4 py-2 bg-gray-orange text-white rounded-full font-spartan font-semibold text-xs tracking-wider uppercase hover:bg-gray-brown transition-all duration-300">
                        SELECCIONAR FOTOS
                    </button>
                </div>

                <!-- Progress Bar -->
                <div id="progress-container" class="mt-3 hidden">
                    <div class="flex justify-between text-xs text-gray-brown mb-1">
                        <span>Cargando imágenes...</span>
                        <span id="progress-text">0%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                        <div id="progress-bar" class="bg-dark-turquoise h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                    </div>
                </div>
            </div>

            <!-- PASO 2: Image Grid (oculto al inicio, reemplaza al Paso 1) -->
            <div id="image-grid-container" class="hidden">
                <div class="flex justify-between items-center mb-3">
                    <h2 class="font-spartan text-xl font-bold text-dark-turquoise">
                        PASO 2: EDITA TUS FOTOS
                    </h2>
                    <div class="flex items-center gap-4">
                        <div class="inline-flex items-center gap-2 text-sm">
                            <span class="text-gray-brown">Imágenes listas:</span>
                            <span id="images-ready" class="font-bold text-dark-turquoise">0/9</span>
                        </div>
                        <button onclick="resetUploadArea()" class="text-xs text-gray-brown hover:text-dark-turquoise underline">
                            ← Volver a subir
                        </button>
                    </div>
                </div>

                <!-- 3x3 Grid -->
                <div class="grid grid-cols-3 gap-2 mb-4">
                <!-- Grid items will be generated dynamically -->
                <div class="grid-item aspect-square bg-gray-100 rounded-lg border-4 border-dashed border-gray-300 flex items-center justify-center cursor-pointer hover:border-dark-turquoise transition-all duration-300" data-index="0">
                    <div class="text-center">
                        <div class="text-6xl text-gray-300 mb-2">+</div>
                        <p class="text-sm text-gray-400">Foto 1</p>
                    </div>
                </div>
                <div class="grid-item aspect-square bg-gray-100 rounded-lg border-4 border-dashed border-gray-300 flex items-center justify-center cursor-pointer hover:border-dark-turquoise transition-all duration-300" data-index="1">
                    <div class="text-center">
                        <div class="text-6xl text-gray-300 mb-2">+</div>
                        <p class="text-sm text-gray-400">Foto 2</p>
                    </div>
                </div>
                <div class="grid-item aspect-square bg-gray-100 rounded-lg border-4 border-dashed border-gray-300 flex items-center justify-center cursor-pointer hover:border-dark-turquoise transition-all duration-300" data-index="2">
                    <div class="text-center">
                        <div class="text-6xl text-gray-300 mb-2">+</div>
                        <p class="text-sm text-gray-400">Foto 3</p>
                    </div>
                </div>
            <div class="grid-item aspect-square bg-gray-100 rounded-lg border-4 border-dashed border-gray-300 flex items-center justify-center cursor-pointer hover:border-dark-turquoise transition-all duration-300" data-index="3">
                <div class="text-center">
                    <div class="text-6xl text-gray-300 mb-2">+</div>
                    <p class="text-sm text-gray-400">Foto 4</p>
                </div>
            </div>
            <div class="grid-item aspect-square bg-gray-100 rounded-lg border-4 border-dashed border-gray-300 flex items-center justify-center cursor-pointer hover:border-dark-turquoise transition-all duration-300" data-index="4">
                <div class="text-center">
                    <div class="text-6xl text-gray-300 mb-2">+</div>
                    <p class="text-sm text-gray-400">Foto 5</p>
                </div>
            </div>
            <div class="grid-item aspect-square bg-gray-100 rounded-lg border-4 border-dashed border-gray-300 flex items-center justify-center cursor-pointer hover:border-dark-turquoise transition-all duration-300" data-index="5">
                <div class="text-center">
                    <div class="text-6xl text-gray-300 mb-2">+</div>
                    <p class="text-sm text-gray-400">Foto 6</p>
                </div>
            </div>
            <div class="grid-item aspect-square bg-gray-100 rounded-lg border-4 border-dashed border-gray-300 flex items-center justify-center cursor-pointer hover:border-dark-turquoise transition-all duration-300" data-index="6">
                <div class="text-center">
                    <div class="text-6xl text-gray-300 mb-2">+</div>
                    <p class="text-sm text-gray-400">Foto 7</p>
                </div>
            </div>
            <div class="grid-item aspect-square bg-gray-100 rounded-lg border-4 border-dashed border-gray-300 flex items-center justify-center cursor-pointer hover:border-dark-turquoise transition-all duration-300" data-index="7">
                <div class="text-center">
                    <div class="text-6xl text-gray-300 mb-2">+</div>
                    <p class="text-sm text-gray-400">Foto 8</p>
                </div>
            </div>
            <div class="grid-item aspect-square bg-gray-100 rounded-lg border-4 border-dashed border-gray-300 flex items-center justify-center cursor-pointer hover:border-dark-turquoise transition-all duration-300" data-index="8">
                <div class="text-center">
                    <div class="text-6xl text-gray-300 mb-2">+</div>
                    <p class="text-sm text-gray-400">Foto 9</p>
                </div>
            </div>
            </div>

                <!-- Action Button (fuera del grid, centrado) -->
                <div class="text-center mt-6">
                    <button id="generate-template-btn" disabled class="px-8 py-3 bg-gray-300 text-gray-500 rounded-full font-spartan font-semibold text-sm tracking-wider uppercase cursor-not-allowed transition-all duration-300">
                        GENERAR TEMPLATE
                    </button>
                    <p class="text-xs text-gray-brown mt-2">
                        Completa y edita las 9 fotos para continuar
                    </p>
                </div>
            </div>
        </div>

        <!-- Processing Modal -->
        <div id="processing-modal" class="hidden fixed inset-0 bg-black/80 z-50 flex items-center justify-center">
            <div class="bg-white rounded-lg p-8 max-w-md w-full text-center">
                <div class="mb-4">
                    <svg class="animate-spin h-16 w-16 mx-auto text-dark-turquoise" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
                <h3 class="font-spartan text-xl font-bold text-dark-turquoise mb-2">Generando Template...</h3>
                <p class="text-sm text-gray-brown">Por favor espera mientras procesamos tus imágenes</p>
            </div>
        </div>

        <!-- Success Modal -->
        <div id="success-modal" class="hidden fixed inset-0 bg-black/80 z-50 flex items-center justify-center">
            <div class="bg-white rounded-lg p-8 max-w-md w-full text-center">
                <div class="mb-4">
                    <svg class="h-16 w-16 mx-auto text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="font-spartan text-xl font-bold text-dark-turquoise mb-2">¡Template Generado!</h3>
                <p class="text-sm text-gray-brown mb-4">Tu número de orden es: <strong id="order-number-display"></strong></p>
                <a id="download-link" href="#" class="inline-block px-8 py-3 bg-dark-turquoise text-white rounded-full font-spartan font-semibold text-sm tracking-wider uppercase hover:bg-gray-brown transition-all duration-300">
                    DESCARGAR TEMPLATE
                </a>
                <button id="close-success-modal" class="block w-full mt-4 px-8 py-3 bg-gray-300 text-gray-700 rounded-full font-spartan font-semibold text-sm tracking-wider uppercase hover:bg-gray-400 transition-all duration-300">
                    CERRAR
                </button>
            </div>
        </div>
    </div>

    </div>
</section>

<!-- Image Editor Modal - Estilo limpio y profesional -->
<div id="editor-modal" class="fixed inset-0 bg-gray-100 z-50 hidden flex items-center justify-center">
    <div class="w-full h-full flex flex-col">

        <!-- Área de la imagen (pantalla completa) -->
        <div class="flex-1 flex items-center justify-center bg-gradient-to-br from-gray-200 to-gray-300 p-8">
            <div id="editor-container" class="relative inline-block">
                <!-- Imagen principal -->
                <img id="editor-image" src="" alt="Editar" class="max-w-full max-h-[70vh] shadow-2xl block">

                <!-- Recuadro de recorte (solo visible en modo recorte) -->
                <div id="crop-overlay" class="absolute top-0 left-0 hidden" style="pointer-events: none;">
                    <!-- Fondo oscuro fuera del área de recorte -->
                    <div class="absolute inset-0" style="box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.5); pointer-events: none; z-index: 1;"></div>

                    <!-- Recuadro exterior 644x644px -->
                    <div id="crop-box" class="absolute border-2 border-white" style="width: 644px; height: 644px; pointer-events: auto; cursor: move; position: relative; z-index: 2;">

                        <!-- Etiquetas de medida 600x600 en los bordes -->


                        <!-- Recuadro interior 600x600px (margen de 22px) -->
                        <div class="absolute border-2 border-dark-turquoise" style="top: 22px; left: 22px; right: 22px; bottom: 22px;">

                            <!-- Grid de tercios (dentro del área interior) -->
                            <div class="absolute inset-0 pointer-events-none">
                                <div class="absolute" style="top: 33.33%; left: 0; right: 0; height: 1px; background: rgba(255,255,255,0.7);"></div>
                                <div class="absolute" style="top: 66.66%; left: 0; right: 0; height: 1px; background: rgba(255,255,255,0.7);"></div>
                                <div class="absolute" style="left: 33.33%; top: 0; bottom: 0; width: 1px; background: rgba(255,255,255,0.7);"></div>
                                <div class="absolute" style="left: 66.66%; top: 0; bottom: 0; width: 1px; background: rgba(255,255,255,0.7);"></div>
                            </div>
                        </div>

                        <!-- Handles de esquina para redimensionar -->
                        <div class="resize-handle absolute -top-2 -left-2 w-5 h-5 bg-dark-turquoise border-2 border-white rounded-full cursor-nw-resize" data-direction="nw"></div>
                        <div class="resize-handle absolute -top-2 -right-2 w-5 h-5 bg-dark-turquoise border-2 border-white rounded-full cursor-ne-resize" data-direction="ne"></div>
                        <div class="resize-handle absolute -bottom-2 -left-2 w-5 h-5 bg-dark-turquoise border-2 border-white rounded-full cursor-sw-resize" data-direction="sw"></div>
                        <div class="resize-handle absolute -bottom-2 -right-2 w-5 h-5 bg-dark-turquoise border-2 border-white rounded-full cursor-se-resize" data-direction="se"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Barra de herramientas superior (modo AJUSTES) -->
        <div id="adjustments-toolbar" class="hidden bg-white border-t border-gray-300 py-6">
            <div class="max-w-6xl mx-auto px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <!-- Brightness -->
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-semibold text-gray-700 flex items-center justify-between">
                            <span>BRIGHTNESS</span>
                            <span id="brightness-value" class="text-dark-turquoise">0</span>
                        </label>
                        <input type="range" id="brightness-slider" min="-100" max="100" value="0" class="slider w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                    </div>

                    <!-- Contrast -->
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-semibold text-gray-700 flex items-center justify-between">
                            <span>CONTRAST</span>
                            <span id="contrast-value" class="text-dark-turquoise">0</span>
                        </label>
                        <input type="range" id="contrast-slider" min="-100" max="100" value="0" class="slider w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                    </div>

                    <!-- Saturation -->
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-semibold text-gray-700 flex items-center justify-between">
                            <span>SATURATION</span>
                            <span id="saturation-value" class="text-dark-turquoise">0</span>
                        </label>
                        <input type="range" id="saturation-slider" min="-100" max="100" value="0" class="slider w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                    </div>

                    <!-- Exposure -->
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-semibold text-gray-700 flex items-center justify-between">
                            <span>EXPOSURE</span>
                            <span id="exposure-value" class="text-dark-turquoise">0</span>
                        </label>
                        <input type="range" id="exposure-slider" min="-100" max="100" value="0" class="slider w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                    </div>

                    <!-- Hue Rotate (Warmth) -->
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-semibold text-gray-700 flex items-center justify-between">
                            <span>WARMTH</span>
                            <span id="warmth-value" class="text-dark-turquoise">0°</span>
                        </label>
                        <input type="range" id="warmth-slider" min="-180" max="180" value="0" class="slider w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                    </div>

                    <!-- Blur -->
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-semibold text-gray-700 flex items-center justify-between">
                            <span>BLUR</span>
                            <span id="blur-value" class="text-dark-turquoise">0</span>
                        </label>
                        <input type="range" id="blur-slider" min="0" max="10" value="0" step="0.5" class="slider w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                    </div>

                    <!-- Sepia -->
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-semibold text-gray-700 flex items-center justify-between">
                            <span>SEPIA</span>
                            <span id="sepia-value" class="text-dark-turquoise">0%</span>
                        </label>
                        <input type="range" id="sepia-slider" min="0" max="100" value="0" class="slider w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                    </div>

                    <!-- Grayscale -->
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-semibold text-gray-700 flex items-center justify-between">
                            <span>GRAYSCALE</span>
                            <span id="grayscale-value" class="text-dark-turquoise">0%</span>
                        </label>
                        <input type="range" id="grayscale-slider" min="0" max="100" value="0" class="slider w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                    </div>
                </div>

                <!-- Botón de reset -->
                <div class="mt-4 flex justify-center">
                    <button id="reset-adjustments" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg text-sm font-semibold transition">
                        Resetear Ajustes
                    </button>
                </div>
            </div>
        </div>

        <!-- Barra de filtros (modo FILTROS) -->
        <div id="filters-toolbar" class="hidden bg-white border-t border-gray-300 py-4">
            <div class="max-w-6xl mx-auto px-8">
                <div class="flex items-center gap-4 overflow-x-auto pb-2">
                    <!-- Original -->
                    <button class="filter-btn" data-filter="original">
                        <div class="w-20 h-20 rounded-lg border-2 border-dark-turquoise bg-white flex items-center justify-center">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <span class="text-xs mt-1 block text-center font-medium">ORIGINAL</span>
                    </button>

                    <!-- B&W -->
                    <button class="filter-btn" data-filter="bw">
                        <div class="w-20 h-20 rounded-lg border-2 border-transparent hover:border-dark-turquoise transition bg-gray-400">
                        </div>
                        <span class="text-xs mt-1 block text-center font-medium">B&W</span>
                    </button>

                    <!-- Sepia -->
                    <button class="filter-btn" data-filter="sepia">
                        <div class="w-20 h-20 rounded-lg border-2 border-transparent hover:border-dark-turquoise transition" style="background: linear-gradient(135deg, #704214 0%, #9f7928 100%);">
                        </div>
                        <span class="text-xs mt-1 block text-center font-medium">SEPIA</span>
                    </button>

                    <!-- Vibrant -->
                    <button class="filter-btn" data-filter="vibrant">
                        <div class="w-20 h-20 rounded-lg border-2 border-transparent hover:border-dark-turquoise transition" style="background: linear-gradient(135deg, #ff0080 0%, #ff8c00 50%, #40e0d0 100%);">
                        </div>
                        <span class="text-xs mt-1 block text-center font-medium">VIBRANT</span>
                    </button>

                    <!-- Cool -->
                    <button class="filter-btn" data-filter="cool">
                        <div class="w-20 h-20 rounded-lg border-2 border-transparent hover:border-dark-turquoise transition" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        </div>
                        <span class="text-xs mt-1 block text-center font-medium">COOL</span>
                    </button>

                    <!-- Warm -->
                    <button class="filter-btn" data-filter="warm">
                        <div class="w-20 h-20 rounded-lg border-2 border-transparent hover:border-dark-turquoise transition" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                        </div>
                        <span class="text-xs mt-1 block text-center font-medium">WARM</span>
                    </button>

                    <!-- Vintage -->
                    <button class="filter-btn" data-filter="vintage">
                        <div class="w-20 h-20 rounded-lg border-2 border-transparent hover:border-dark-turquoise transition" style="background: linear-gradient(135deg, #c79081 0%, #dfa579 100%);">
                        </div>
                        <span class="text-xs mt-1 block text-center font-medium">VINTAGE</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Barra inferior con controles principales -->
        <div class="bg-white border-t border-gray-300 px-8 py-4">
            <div class="flex items-center justify-between max-w-7xl mx-auto">
                <!-- Botón izquierda: Cerrar -->
                <div class="flex items-center gap-2">
                    <!-- Botón cerrar (X) -->
                    <button id="close-editor" class="w-10 h-10 flex items-center justify-center hover:bg-gray-100 rounded-full transition" title="Cerrar">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modos del editor (centro) -->
                <div class="flex items-center gap-6">
                    <button id="crop-mode" class="editor-mode-btn flex flex-col items-center gap-1 px-4 py-2 rounded-lg transition border-b-2 border-transparent">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 10-4.243 4.243 3 3 0 004.243-4.243zm0-5.758a3 3 0 10-4.243-4.243 3 3 0 004.243 4.243z"></path>
                        </svg>
                    </button>

                    <button id="adjust-mode" class="editor-mode-btn flex flex-col items-center gap-1 px-4 py-2 rounded-lg transition border-b-2 border-transparent">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>
                    </button>

                    <button id="filters-mode" class="editor-mode-btn flex flex-col items-center gap-1 px-4 py-2 rounded-lg transition border-b-2 border-transparent">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                        </svg>
                    </button>
                </div>

                <!-- Botón guardar (✓) -->
                <button id="save-edit" class="w-10 h-10 flex items-center justify-center bg-dark-turquoise hover:bg-dark-turquoise-alt text-white rounded-full transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </button>
            </div>
        </div>

    </div>
</div>

@endsection

@push('styles')
<style>
    /* Estilos para los sliders */
    input[type="range"].slider {
        -webkit-appearance: none;
        appearance: none;
    }

    input[type="range"].slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 20px;
        height: 20px;
        background: #12463c;
        cursor: pointer;
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }

    input[type="range"].slider::-webkit-slider-thumb:hover {
        background: #003a2f;
        transform: scale(1.1);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }

    input[type="range"].slider::-moz-range-thumb {
        width: 20px;
        height: 20px;
        background: #12463c;
        cursor: pointer;
        border-radius: 50%;
        border: none;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }

    input[type="range"].slider::-moz-range-thumb:hover {
        background: #003a2f;
        transform: scale(1.1);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }

    /* Botones de filtro */
    .filter-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 0.5rem;
        background: white;
        border-radius: 0.75rem;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .filter-btn:hover {
        border-color: #c2b59b;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .filter-btn.ring-2 {
        border-color: #12463c;
        box-shadow: 0 0 0 2px #12463c;
    }

    /* Animación del canvas */
    #editor-canvas {
        transition: all 0.3s ease;
    }

    /* Scrollbar personalizada para el sidebar */
    .overflow-y-auto::-webkit-scrollbar {
        width: 8px;
    }

    .overflow-y-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .overflow-y-auto::-webkit-scrollbar-thumb {
        background: #12463c;
        border-radius: 4px;
    }

    .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        background: #003a2f;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.0/fabric.min.js"></script>
<script>
    // Estado global
    const appState = {
        images: new Array(9).fill(null), // Imágenes originales (nunca se modifican)
        editedImages: new Array(9).fill(null), // Imágenes editadas 644x644px (para composición final)
        editorState: new Array(9).fill(null), // Estado del editor (filtros, crop, etc.)
        currentEditIndex: null,
        currentImageElement: null,
        imageScale: 1,
        cropBox: {
            element: null,
            size: 644, // Tamaño exterior fijo
            margin: 22, // Margen para área de impresión 600x600px
            left: 128,
            top: 28
        },
        imageRotation: 0,
        imageFlip: {
            horizontal: false,
            vertical: false
        },
        imageFilters: {
            brightness: 0,
            contrast: 0,
            saturation: 0,
            exposure: 0,
            warmth: 0,
            blur: 0,
            sepia: 0,
            grayscale: 0
        }
    };

    // Inicializar
    document.addEventListener('DOMContentLoaded', function() {
        initializeDropzone();
        initializeFileInput();
        initializeGridItems();
        initializeEditor();
    });

    // Dropzone drag & drop
    function initializeDropzone() {
        const dropzone = document.getElementById('dropzone');

        dropzone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropzone.classList.add('border-dark-turquoise', 'bg-blue-50');
        });

        dropzone.addEventListener('dragleave', () => {
            dropzone.classList.remove('border-dark-turquoise', 'bg-blue-50');
        });

        dropzone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropzone.classList.remove('border-dark-turquoise', 'bg-blue-50');
            const files = Array.from(e.dataTransfer.files).filter(f => f.type.startsWith('image/'));
            handleFiles(files);
        });

        dropzone.addEventListener('click', () => {
            document.getElementById('file-input').click();
        });
    }

    // File input
    function initializeFileInput() {
        document.getElementById('file-input').addEventListener('change', (e) => {
            const files = Array.from(e.target.files);
            handleFiles(files);
        });
    }

    // Manejar archivos
    function handleFiles(files) {
        if (files.length === 0) return;

        const maxFiles = 9 - appState.images.filter(img => img !== null).length;
        const filesToProcess = files.slice(0, maxFiles);

        showProgressBar();

        let loaded = 0;
        const total = filesToProcess.length;

        filesToProcess.forEach((file, index) => {
            const reader = new FileReader();

            reader.onload = (e) => {
                const emptyIndex = appState.images.findIndex(img => img === null);
                if (emptyIndex !== -1) {
                    appState.images[emptyIndex] = e.target.result;
                    updateGridItem(emptyIndex, e.target.result);
                }

                loaded++;
                updateProgress((loaded / total) * 100);

                if (loaded === total) {
                    setTimeout(() => {
                        hideProgressBar();
                        showImageGrid();
                        updateImagesReady();
                    }, 500);
                }
            };

            reader.readAsDataURL(file);
        });
    }

    // Actualizar item de la rejilla
    function updateGridItem(index, imageSrc) {
        const gridItems = document.querySelectorAll('.grid-item');
        const item = gridItems[index];

        item.innerHTML = `
            <div class="relative w-full h-full group">
                <img src="${imageSrc}" class="w-full h-full object-cover rounded-lg">

                <!-- Overlay de márgenes (visible siempre) -->
                <div class="absolute inset-0 pointer-events-none rounded-lg overflow-hidden">
                    <!-- Fondo oscuro fuera del área de impresión (box-shadow trick) -->
                    <div class="absolute border-2 border-dashed border-dark-turquoise"
                         style="top: 3.42%; left: 3.42%; right: 3.42%; bottom: 3.42%; box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.4);">
                    </div>

                    <!-- Borde exterior 644x644 (opcional, línea punteada gris claro) -->
                    <div class="absolute inset-0 border-2 border-dashed border-gray-300 rounded-lg"></div>
                </div>

                <!-- Overlay de hover con botones de acción -->
                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-all duration-300 flex flex-col items-center justify-center gap-2 rounded-lg pointer-events-none group-hover:pointer-events-auto">
                    <button class="grid-edit-btn px-4 py-2 bg-white text-dark-turquoise rounded-full text-sm font-semibold hover:bg-gray-100 transition flex items-center gap-2" data-index="${index}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Editar
                    </button>
                    <button class="grid-duplicate-btn px-4 py-2 bg-gray-100 text-gray-700 rounded-full text-sm font-semibold hover:bg-gray-200 transition flex items-center gap-2" data-index="${index}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        Duplicar
                    </button>
                    <button class="grid-delete-btn px-4 py-2 bg-red-100 text-red-600 rounded-full text-sm font-semibold hover:bg-red-200 transition flex items-center gap-2" data-index="${index}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Borrar
                    </button>
                </div>

                <!-- Indicador de imagen editada -->
                ${appState.editedImages[index] ? '<div class="absolute top-2 right-2 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center z-10"><svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></div>' : ''}
            </div>
        `;

        item.classList.remove('border-dashed', 'border-gray-300');
        item.classList.add('border-solid', 'border-dark-turquoise');
    }

    // Inicializar items de la rejilla
    function initializeGridItems() {
        const gridItems = document.querySelectorAll('.grid-item');
        gridItems.forEach((item, index) => {
            item.addEventListener('click', (e) => {
                // Si se hace clic en un botón, no hacer nada (los botones tienen su propio handler)
                if (e.target.closest('button')) {
                    return;
                }

                // Si tiene imagen, abrir editor
                if (appState.images[index]) {
                    openEditor(index);
                } else {
                    // Si está vacía, abrir selector de archivo para esa celda específica
                    openFileSelectorForCell(index);
                }
            });
        });

        // Event delegation para los botones del grid (usando document para capturar eventos dinámicos)
        document.addEventListener('click', (e) => {
            // Botón Editar en el grid
            if (e.target.closest('.grid-edit-btn')) {
                const btn = e.target.closest('.grid-edit-btn');
                const index = parseInt(btn.dataset.index);
                e.stopPropagation();
                openEditor(index);
            }

            // Botón Duplicar en el grid
            if (e.target.closest('.grid-duplicate-btn')) {
                const btn = e.target.closest('.grid-duplicate-btn');
                const index = parseInt(btn.dataset.index);
                e.stopPropagation();
                duplicateImageFromGrid(index);
            }

            // Botón Borrar en el grid
            if (e.target.closest('.grid-delete-btn')) {
                const btn = e.target.closest('.grid-delete-btn');
                const index = parseInt(btn.dataset.index);
                e.stopPropagation();
                deleteImageFromGrid(index);
            }
        });
    }

    // Duplicar imagen desde el grid
    function duplicateImageFromGrid(sourceIndex) {
        // Buscar primer espacio vacío
        const emptyIndex = appState.images.findIndex(img => img === null);

        if (emptyIndex !== -1) {
            // Copiar datos
            appState.images[emptyIndex] = appState.images[sourceIndex];
            appState.editedImages[emptyIndex] = appState.editedImages[sourceIndex];

            // Copiar estado del editor si existe
            if (appState.editorState[sourceIndex]) {
                appState.editorState[emptyIndex] = JSON.parse(JSON.stringify(appState.editorState[sourceIndex]));
            }

            // Actualizar grilla con la imagen apropiada (editada o original)
            const displayImage = appState.editedImages[emptyIndex] || appState.images[emptyIndex];
            updateGridItem(emptyIndex, displayImage);
            updateImagesReady();

            // Mostrar mensaje de éxito
            alert('Imagen duplicada exitosamente en la posición ' + (emptyIndex + 1));
        } else {
            alert('No hay espacios disponibles para duplicar la imagen');
        }
    }

    // Eliminar imagen desde el grid
    function deleteImageFromGrid(index) {
        if (confirm('¿Estás seguro de que quieres eliminar esta imagen?')) {
            // Limpiar todos los datos
            appState.images[index] = null;
            appState.editedImages[index] = null;
            appState.editorState[index] = null;

            // Resetear grilla
            resetGridItem(index);
            updateImagesReady();
        }
    }

    // Abrir selector de archivo para una celda específica
    function openFileSelectorForCell(targetIndex) {
        // Crear input temporal
        const tempInput = document.createElement('input');
        tempInput.type = 'file';
        tempInput.accept = 'image/*';
        tempInput.style.display = 'none';

        tempInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file && file.type.startsWith('image/')) {
                // Leer y procesar la imagen
                const reader = new FileReader();
                reader.onload = (event) => {
                    // Guardar imagen en la posición específica
                    appState.images[targetIndex] = event.target.result;

                    // Usar la misma función que usa handleFiles para mantener consistencia
                    updateGridItem(targetIndex, event.target.result);

                    // Actualizar contador
                    updateImagesReady();
                };
                reader.readAsDataURL(file);
            }

            // Remover el input temporal
            document.body.removeChild(tempInput);
        });

        // Agregar al DOM y disparar clic
        document.body.appendChild(tempInput);
        tempInput.click();
    }

    // Abrir editor
    function openEditor(index) {
        appState.currentEditIndex = index;
        const modal = document.getElementById('editor-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // Verificar si existe un estado guardado del editor para esta imagen
        const savedState = appState.editorState[index];

        if (savedState) {
            // Restaurar estado guardado
            appState.imageRotation = savedState.rotation || 0;
            appState.imageScale = savedState.scale || 1;
            appState.imageFlip = savedState.flip || {
                horizontal: false,
                vertical: false
            };
            appState.imageFilters = savedState.filters || {
                brightness: 0,
                contrast: 0,
                saturation: 0,
                exposure: 0,
                warmth: 0,
                blur: 0,
                sepia: 0,
                grayscale: 0
            };

            // Restaurar sliders visualmente
            document.getElementById('brightness-slider').value = savedState.filters.brightness || 0;
            document.getElementById('brightness-value').textContent = savedState.filters.brightness || 0;
            document.getElementById('contrast-slider').value = savedState.filters.contrast || 0;
            document.getElementById('contrast-value').textContent = savedState.filters.contrast || 0;
            document.getElementById('saturation-slider').value = savedState.filters.saturation || 0;
            document.getElementById('saturation-value').textContent = savedState.filters.saturation || 0;
            document.getElementById('exposure-slider').value = savedState.filters.exposure || 0;
            document.getElementById('exposure-value').textContent = savedState.filters.exposure || 0;
            document.getElementById('warmth-slider').value = savedState.filters.warmth || 0;
            document.getElementById('warmth-value').textContent = (savedState.filters.warmth || 0) + '°';
            document.getElementById('blur-slider').value = savedState.filters.blur || 0;
            document.getElementById('blur-value').textContent = savedState.filters.blur || 0;
            document.getElementById('sepia-slider').value = savedState.filters.sepia || 0;
            document.getElementById('sepia-value').textContent = (savedState.filters.sepia || 0) + '%';
            document.getElementById('grayscale-slider').value = savedState.filters.grayscale || 0;
            document.getElementById('grayscale-value').textContent = (savedState.filters.grayscale || 0) + '%';
        } else {
            // Resetear estado (primera vez editando)
            appState.imageRotation = 0;
            appState.imageScale = 1;
            appState.imageFlip = {
                horizontal: false,
                vertical: false
            };
            appState.imageFilters = {
                brightness: 0,
                contrast: 0,
                saturation: 0,
                exposure: 0,
                warmth: 0,
                blur: 0,
                sepia: 0,
                grayscale: 0
            };

            // Resetear todos los sliders visualmente
            document.getElementById('brightness-slider').value = 0;
            document.getElementById('brightness-value').textContent = '0';
            document.getElementById('contrast-slider').value = 0;
            document.getElementById('contrast-value').textContent = '0';
            document.getElementById('saturation-slider').value = 0;
            document.getElementById('saturation-value').textContent = '0';
            document.getElementById('exposure-slider').value = 0;
            document.getElementById('exposure-value').textContent = '0';
            document.getElementById('warmth-slider').value = 0;
            document.getElementById('warmth-value').textContent = '0°';
            document.getElementById('blur-slider').value = 0;
            document.getElementById('blur-value').textContent = '0';
            document.getElementById('sepia-slider').value = 0;
            document.getElementById('sepia-value').textContent = '0%';
            document.getElementById('grayscale-slider').value = 0;
            document.getElementById('grayscale-value').textContent = '0%';
        }

        // Ocultar todas las barras de herramientas
        document.getElementById('adjustments-toolbar').classList.add('hidden');
        document.getElementById('filters-toolbar').classList.add('hidden');
        document.getElementById('crop-overlay').classList.add('hidden');

        // Activar modo recorte por defecto
        setEditorMode('crop');

        // Cargar imagen ORIGINAL (no la editada)
        const editorImage = document.getElementById('editor-image');
        editorImage.src = appState.images[index]; // Siempre cargar la original
        appState.currentImageElement = editorImage;

        // Aplicar filtros y centrar crop box
        editorImage.onload = function() {
            // Pequeño delay para asegurar que la imagen se renderice completamente
            setTimeout(() => {
                applyImageFilters();

                // Si existe estado guardado, restaurar posición del crop box
                if (savedState && savedState.cropBox) {
                    const cropBox = document.getElementById('crop-box');
                    const cropOverlay = document.getElementById('crop-overlay');

                    // Primero centrar para establecer el overlay
                    centerCropBox();

                    // Luego restaurar posición guardada
                    cropBox.style.left = savedState.cropBox.left + 'px';
                    cropBox.style.top = savedState.cropBox.top + 'px';
                    cropBox.style.width = savedState.cropBox.size + 'px';
                    cropBox.style.height = savedState.cropBox.size + 'px';

                    // Actualizar margen interno
                    const innerBorder = cropBox.querySelector('.border-dark-turquoise');
                    if (innerBorder) {
                        const margin = (savedState.cropBox.size * 22) / 644;
                        innerBorder.style.top = margin + 'px';
                        innerBorder.style.left = margin + 'px';
                        innerBorder.style.right = margin + 'px';
                        innerBorder.style.bottom = margin + 'px';
                    }
                } else {
                    // Centrar normalmente si no hay estado guardado
                    centerCropBox();
                }

                initializeCropBoxDrag();
            }, 50);
        };
    }

    // Centrar el crop box sobre la imagen
    function centerCropBox() {
        const img = document.getElementById('editor-image');
        const cropOverlay = document.getElementById('crop-overlay');
        const cropBox = document.getElementById('crop-box');

        if (!img || !cropOverlay || !cropBox) return;

        // Obtener dimensiones reales de la imagen renderizada
        const imgWidth = img.clientWidth;
        const imgHeight = img.clientHeight;

        // El overlay ya está posicionado en top:0 left:0 del contenedor, solo ajustar tamaño
        cropOverlay.style.width = imgWidth + 'px';
        cropOverlay.style.height = imgHeight + 'px';

        // Calcular tamaño inicial del crop box (el más pequeño entre ancho y alto de la imagen, o 644px)
        const maxCropSize = Math.min(imgWidth, imgHeight);
        const cropBoxSize = Math.min(644, maxCropSize);

        // Centrar el crop box dentro del overlay
        cropBox.style.left = ((imgWidth - cropBoxSize) / 2) + 'px';
        cropBox.style.top = ((imgHeight - cropBoxSize) / 2) + 'px';
        cropBox.style.width = cropBoxSize + 'px';
        cropBox.style.height = cropBoxSize + 'px';

        // Actualizar margen interno proporcional
        const innerBorder = cropBox.querySelector('.border-dark-turquoise');
        if (innerBorder) {
            const margin = (cropBoxSize * 22) / 644;
            innerBorder.style.top = margin + 'px';
            innerBorder.style.left = margin + 'px';
            innerBorder.style.right = margin + 'px';
            innerBorder.style.bottom = margin + 'px';
        }
    }

    // Inicializar arrastre y redimensionamiento del crop box
    function initializeCropBoxDrag() {
        const cropBox = document.getElementById('crop-box');
        const cropOverlay = document.getElementById('crop-overlay');
        const handles = document.querySelectorAll('.resize-handle');

        let isDragging = false;
        let isResizing = false;
        let resizeDirection = '';
        let startX = 0;
        let startY = 0;
        let startLeft = 0;
        let startTop = 0;
        let startWidth = 0;
        let startHeight = 0;

        // Arrastre del crop box
        cropBox.addEventListener('mousedown', function(e) {
            // Solo si no es un handle
            if (e.target.classList.contains('resize-handle')) return;

            isDragging = true;
            startX = e.clientX;
            startY = e.clientY;
            startLeft = parseInt(cropBox.style.left) || 0;
            startTop = parseInt(cropBox.style.top) || 0;
            cropBox.style.cursor = 'grabbing';
            e.preventDefault();
        });

        // Redimensionamiento con handles
        handles.forEach(handle => {
            handle.addEventListener('mousedown', function(e) {
                isResizing = true;
                resizeDirection = this.dataset.direction;
                startX = e.clientX;
                startY = e.clientY;
                startLeft = parseInt(cropBox.style.left) || 0;
                startTop = parseInt(cropBox.style.top) || 0;
                startWidth = cropBox.offsetWidth;
                startHeight = cropBox.offsetHeight;
                e.preventDefault();
                e.stopPropagation();
            });
        });

        document.addEventListener('mousemove', function(e) {
            if (isDragging) {
                const deltaX = e.clientX - startX;
                const deltaY = e.clientY - startY;

                let newLeft = startLeft + deltaX;
                let newTop = startTop + deltaY;

                // Limitar dentro del overlay
                const maxLeft = cropOverlay.offsetWidth - cropBox.offsetWidth;
                const maxTop = cropOverlay.offsetHeight - cropBox.offsetHeight;

                newLeft = Math.max(0, Math.min(newLeft, maxLeft));
                newTop = Math.max(0, Math.min(newTop, maxTop));

                cropBox.style.left = newLeft + 'px';
                cropBox.style.top = newTop + 'px';
            }

            if (isResizing) {
                const deltaX = e.clientX - startX;
                const deltaY = e.clientY - startY;

                let newWidth = startWidth;
                let newHeight = startHeight;
                let newLeft = startLeft;
                let newTop = startTop;

                // Tamaño máximo = el más pequeño entre el ancho y alto del overlay (imagen)
                const maxSize = Math.min(cropOverlay.offsetWidth, cropOverlay.offsetHeight);
                const minSize = 200; // Tamaño mínimo

                // Calcular nuevo tamaño según la dirección (mantener cuadrado)
                switch (resizeDirection) {
                    case 'se': // sureste
                        newWidth = Math.max(minSize, Math.min(maxSize, startWidth + Math.max(deltaX, deltaY)));
                        newHeight = newWidth; // Mantener cuadrado
                        break;
                    case 'sw': // suroeste
                        newWidth = Math.max(minSize, Math.min(maxSize, startWidth - deltaX));
                        newHeight = newWidth;
                        newLeft = startLeft + (startWidth - newWidth);
                        break;
                    case 'ne': // noreste
                        newWidth = Math.max(minSize, Math.min(maxSize, startWidth + deltaX));
                        newHeight = newWidth;
                        newTop = startTop + (startHeight - newHeight);
                        break;
                    case 'nw': // noroeste
                        newWidth = Math.max(minSize, Math.min(maxSize, startWidth - Math.max(deltaX, deltaY)));
                        newHeight = newWidth;
                        newLeft = startLeft + (startWidth - newWidth);
                        newTop = startTop + (startHeight - newHeight);
                        break;
                }

                // Limitar dentro del overlay (no exceder los bordes de la imagen)
                const maxLeft = cropOverlay.offsetWidth - newWidth;
                const maxTop = cropOverlay.offsetHeight - newHeight;

                newLeft = Math.max(0, Math.min(newLeft, maxLeft));
                newTop = Math.max(0, Math.min(newTop, maxTop));

                // Verificar que el recuadro no se salga por la derecha o abajo
                if (newLeft + newWidth > cropOverlay.offsetWidth) {
                    newWidth = cropOverlay.offsetWidth - newLeft;
                    newHeight = newWidth; // Mantener cuadrado
                }
                if (newTop + newHeight > cropOverlay.offsetHeight) {
                    newHeight = cropOverlay.offsetHeight - newTop;
                    newWidth = newHeight; // Mantener cuadrado
                }

                cropBox.style.width = newWidth + 'px';
                cropBox.style.height = newHeight + 'px';
                cropBox.style.left = newLeft + 'px';
                cropBox.style.top = newTop + 'px';

                // Actualizar margen interno proporcional (mantener relación 644:600)
                const innerBorder = cropBox.querySelector('.border-dark-turquoise');
                const margin = (newWidth * 22) / 644;
                innerBorder.style.top = margin + 'px';
                innerBorder.style.left = margin + 'px';
                innerBorder.style.right = margin + 'px';
                innerBorder.style.bottom = margin + 'px';
            }
        });

        document.addEventListener('mouseup', function() {
            if (isDragging) {
                isDragging = false;
                cropBox.style.cursor = 'move';
            }
            if (isResizing) {
                isResizing = false;
                resizeDirection = '';
            }
        });
    }

    // Cambiar modo del editor
    function setEditorMode(mode) {
        // Remover estado activo de todos los botones
        document.querySelectorAll('.editor-mode-btn').forEach(btn => {
            btn.classList.remove('border-dark-turquoise', 'text-dark-turquoise');
        });

        // Ocultar todas las barras de herramientas
        document.getElementById('adjustments-toolbar').classList.add('hidden');
        document.getElementById('filters-toolbar').classList.add('hidden');
        document.getElementById('crop-overlay').classList.add('hidden');

        // Activar el modo seleccionado
        if (mode === 'crop') {
            document.getElementById('crop-mode').classList.add('border-dark-turquoise', 'text-dark-turquoise');
            document.getElementById('crop-overlay').classList.remove('hidden');
        } else if (mode === 'adjust') {
            document.getElementById('adjust-mode').classList.add('border-dark-turquoise', 'text-dark-turquoise');
            document.getElementById('adjustments-toolbar').classList.remove('hidden');
        } else if (mode === 'filters') {
            document.getElementById('filters-mode').classList.add('border-dark-turquoise', 'text-dark-turquoise');
            document.getElementById('filters-toolbar').classList.remove('hidden');
        }
    }

    // Aplicar filtros y transformaciones a la imagen
    function applyImageFilters() {
        const img = appState.currentImageElement;
        if (!img) return;

        // Filtros CSS
        let filterString = '';

        // Brightness
        if (appState.imageFilters.brightness !== 0) {
            filterString += `brightness(${1 + appState.imageFilters.brightness / 100}) `;
        }

        // Contrast
        if (appState.imageFilters.contrast !== 0) {
            filterString += `contrast(${1 + appState.imageFilters.contrast / 100}) `;
        }

        // Saturation
        if (appState.imageFilters.saturation !== 0) {
            filterString += `saturate(${1 + appState.imageFilters.saturation / 100}) `;
        }

        // Exposure (simulado con brightness adicional)
        if (appState.imageFilters.exposure !== 0) {
            const exposureValue = 1 + (appState.imageFilters.exposure / 100);
            filterString += `brightness(${exposureValue}) `;
        }

        // Warmth (hue-rotate)
        if (appState.imageFilters.warmth !== 0) {
            filterString += `hue-rotate(${appState.imageFilters.warmth}deg) `;
        }

        // Blur
        if (appState.imageFilters.blur > 0) {
            filterString += `blur(${appState.imageFilters.blur}px) `;
        }

        // Sepia
        if (appState.imageFilters.sepia > 0) {
            filterString += `sepia(${appState.imageFilters.sepia}%) `;
        }

        // Grayscale
        if (appState.imageFilters.grayscale > 0) {
            filterString += `grayscale(${appState.imageFilters.grayscale}%) `;
        }

        img.style.filter = filterString.trim() || 'none';

        // Transformaciones (rotación, escala y flip)
        const flipX = appState.imageFlip.horizontal ? -1 : 1;
        const flipY = appState.imageFlip.vertical ? -1 : 1;
        img.style.transform = `rotate(${appState.imageRotation}deg) scale(${appState.imageScale * flipX}, ${appState.imageScale * flipY})`;
    }

    // Cerrar editor
    function closeEditor() {
        document.getElementById('editor-modal').classList.add('hidden');
        document.getElementById('editor-modal').classList.remove('flex');
    }

    // Inicializar controles del editor
    function initializeEditor() {
        // Botón cerrar
        document.getElementById('close-editor').addEventListener('click', closeEditor);

        // Botones de cambio de modo
        document.getElementById('crop-mode').addEventListener('click', () => setEditorMode('crop'));
        document.getElementById('adjust-mode').addEventListener('click', () => setEditorMode('adjust'));
        document.getElementById('filters-mode').addEventListener('click', () => setEditorMode('filters'));

        // === SLIDERS DE AJUSTES ===

        // Brightness
        const brightnessSlider = document.getElementById('brightness-slider');
        const brightnessValue = document.getElementById('brightness-value');
        brightnessSlider.addEventListener('input', (e) => {
            const value = parseInt(e.target.value);
            brightnessValue.textContent = value;
            appState.imageFilters.brightness = value;
            applyImageFilters();
        });

        // Contrast
        const contrastSlider = document.getElementById('contrast-slider');
        const contrastValue = document.getElementById('contrast-value');
        contrastSlider.addEventListener('input', (e) => {
            const value = parseInt(e.target.value);
            contrastValue.textContent = value;
            appState.imageFilters.contrast = value;
            applyImageFilters();
        });

        // Saturation
        const saturationSlider = document.getElementById('saturation-slider');
        const saturationValue = document.getElementById('saturation-value');
        saturationSlider.addEventListener('input', (e) => {
            const value = parseInt(e.target.value);
            saturationValue.textContent = value;
            appState.imageFilters.saturation = value;
            applyImageFilters();
        });

        // Exposure
        const exposureSlider = document.getElementById('exposure-slider');
        const exposureValue = document.getElementById('exposure-value');
        exposureSlider.addEventListener('input', (e) => {
            const value = parseInt(e.target.value);
            exposureValue.textContent = value;
            appState.imageFilters.exposure = value;
            applyImageFilters();
        });

        // Warmth
        const warmthSlider = document.getElementById('warmth-slider');
        const warmthValue = document.getElementById('warmth-value');
        warmthSlider.addEventListener('input', (e) => {
            const value = parseInt(e.target.value);
            warmthValue.textContent = value + '°';
            appState.imageFilters.warmth = value;
            applyImageFilters();
        });

        // Blur
        const blurSlider = document.getElementById('blur-slider');
        const blurValue = document.getElementById('blur-value');
        blurSlider.addEventListener('input', (e) => {
            const value = parseFloat(e.target.value);
            blurValue.textContent = value;
            appState.imageFilters.blur = value;
            applyImageFilters();
        });

        // Sepia
        const sepiaSlider = document.getElementById('sepia-slider');
        const sepiaValue = document.getElementById('sepia-value');
        sepiaSlider.addEventListener('input', (e) => {
            const value = parseInt(e.target.value);
            sepiaValue.textContent = value + '%';
            appState.imageFilters.sepia = value;
            applyImageFilters();
        });

        // Grayscale
        const grayscaleSlider = document.getElementById('grayscale-slider');
        const grayscaleValue = document.getElementById('grayscale-value');
        grayscaleSlider.addEventListener('input', (e) => {
            const value = parseInt(e.target.value);
            grayscaleValue.textContent = value + '%';
            appState.imageFilters.grayscale = value;
            applyImageFilters();
        });

        // Botón resetear ajustes
        document.getElementById('reset-adjustments').addEventListener('click', () => {
            // Resetear todos los sliders
            brightnessSlider.value = 0;
            brightnessValue.textContent = '0';
            contrastSlider.value = 0;
            contrastValue.textContent = '0';
            saturationSlider.value = 0;
            saturationValue.textContent = '0';
            exposureSlider.value = 0;
            exposureValue.textContent = '0';
            warmthSlider.value = 0;
            warmthValue.textContent = '0°';
            blurSlider.value = 0;
            blurValue.textContent = '0';
            sepiaSlider.value = 0;
            sepiaValue.textContent = '0%';
            grayscaleSlider.value = 0;
            grayscaleValue.textContent = '0%';

            // Resetear estado
            appState.imageFilters = {
                brightness: 0,
                contrast: 0,
                saturation: 0,
                exposure: 0,
                warmth: 0,
                blur: 0,
                sepia: 0,
                grayscale: 0
            };

            applyImageFilters();
        });

        // === FILTROS PREDEFINIDOS ===
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const filter = this.dataset.filter;

                // Marcar filtro activo
                document.querySelectorAll('.filter-btn > div').forEach(div => {
                    div.classList.remove('border-dark-turquoise');
                    div.classList.add('border-transparent');
                });
                this.querySelector('div').classList.remove('border-transparent');
                this.querySelector('div').classList.add('border-dark-turquoise');

                // Aplicar filtro predefinido
                switch (filter) {
                    case 'original':
                        // Resetear todos los filtros
                        appState.imageFilters = {
                            brightness: 0,
                            contrast: 0,
                            saturation: 0,
                            exposure: 0,
                            warmth: 0,
                            blur: 0,
                            sepia: 0,
                            grayscale: 0
                        };
                        break;

                    case 'bw':
                        // Blanco y negro
                        appState.imageFilters.grayscale = 100;
                        appState.imageFilters.contrast = 10;
                        break;

                    case 'sepia':
                        // Sepia vintage
                        appState.imageFilters.sepia = 80;
                        appState.imageFilters.contrast = -10;
                        break;

                    case 'vibrant':
                        // Colores vibrantes
                        appState.imageFilters.saturation = 50;
                        appState.imageFilters.contrast = 20;
                        appState.imageFilters.brightness = 10;
                        break;

                    case 'cool':
                        // Tonos fríos
                        appState.imageFilters.warmth = -30;
                        appState.imageFilters.saturation = 20;
                        break;

                    case 'warm':
                        // Tonos cálidos
                        appState.imageFilters.warmth = 30;
                        appState.imageFilters.saturation = 10;
                        appState.imageFilters.brightness = 5;
                        break;

                    case 'vintage':
                        // Vintage
                        appState.imageFilters.sepia = 40;
                        appState.imageFilters.contrast = -15;
                        appState.imageFilters.brightness = -10;
                        break;
                }

                applyImageFilters();
            });
        });

        // Botón guardar
        document.getElementById('save-edit').addEventListener('click', saveEditedImage);
    }

    // Guardar imagen editada con todas las transformaciones
    function saveEditedImage() {
        const img = appState.currentImageElement;
        const cropBox = document.getElementById('crop-box');
        const cropOverlay = document.getElementById('crop-overlay');

        if (!img) return;

        // Crear un canvas temporal para renderizar la imagen con filtros y rotación
        const tempCanvas = document.createElement('canvas');
        const tempCtx = tempCanvas.getContext('2d');

        // === PASO 0: Aplicar rotación si es necesaria ===
        const rotation = appState.imageRotation % 360;
        const isRotated90or270 = (rotation === 90 || rotation === 270);

        // Ajustar dimensiones del canvas según la rotación
        if (isRotated90or270) {
            tempCanvas.width = img.naturalHeight;
            tempCanvas.height = img.naturalWidth;
        } else {
            tempCanvas.width = img.naturalWidth;
            tempCanvas.height = img.naturalHeight;
        }

        // === PASO 1: Aplicar filtros CSS al contexto del canvas ===
        // Construir string de filtros
        let filterString = '';

        if (appState.imageFilters.brightness !== 0) {
            filterString += `brightness(${1 + appState.imageFilters.brightness / 100}) `;
        }
        if (appState.imageFilters.contrast !== 0) {
            filterString += `contrast(${1 + appState.imageFilters.contrast / 100}) `;
        }
        if (appState.imageFilters.saturation !== 0) {
            filterString += `saturate(${1 + appState.imageFilters.saturation / 100}) `;
        }
        if (appState.imageFilters.exposure !== 0) {
            const exposureValue = 1 + (appState.imageFilters.exposure / 100);
            filterString += `brightness(${exposureValue}) `;
        }
        if (appState.imageFilters.warmth !== 0) {
            filterString += `hue-rotate(${appState.imageFilters.warmth}deg) `;
        }
        if (appState.imageFilters.blur > 0) {
            filterString += `blur(${appState.imageFilters.blur}px) `;
        }
        if (appState.imageFilters.sepia > 0) {
            filterString += `sepia(${appState.imageFilters.sepia}%) `;
        }
        if (appState.imageFilters.grayscale > 0) {
            filterString += `grayscale(${appState.imageFilters.grayscale}%) `;
        }

        // Aplicar filtros al canvas
        tempCtx.filter = filterString.trim() || 'none';

        // Aplicar rotación y dibujar imagen
        tempCtx.save();
        tempCtx.translate(tempCanvas.width / 2, tempCanvas.height / 2);
        tempCtx.rotate((rotation * Math.PI) / 180);
        tempCtx.drawImage(img, -img.naturalWidth / 2, -img.naturalHeight / 2, img.naturalWidth, img.naturalHeight);
        tempCtx.restore();

        // === PASO 2: Calcular área de recorte ===
        // Obtener posición y tamaño del crop box en pantalla
        const imgDisplayWidth = img.clientWidth;
        const imgDisplayHeight = img.clientHeight;
        const cropBoxLeft = parseFloat(cropBox.style.left) || 0;
        const cropBoxTop = parseFloat(cropBox.style.top) || 0;
        const cropBoxSize = parseFloat(cropBox.style.width) || 644;

        // Calcular margen interior (22px proporcional)
        const margin = (cropBoxSize * 22) / 644;

        // Área interior (600x600 en la proporción del crop box)
        const innerLeft = cropBoxLeft + margin;
        const innerTop = cropBoxTop + margin;
        const innerSize = cropBoxSize - (margin * 2);

        // Factor de escala entre imagen mostrada y original
        const scaleX = img.naturalWidth / imgDisplayWidth;
        const scaleY = img.naturalHeight / imgDisplayHeight;

        // Convertir coordenadas del área interior a coordenadas de la imagen original
        const cropX = innerLeft * scaleX;
        const cropY = innerTop * scaleY;
        const cropWidth = innerSize * scaleX;
        const cropHeight = innerSize * scaleY;

        // === PASO 3: Crear canvas final de 644x644px (especificación del Python) ===
        const finalCanvas = document.createElement('canvas');
        finalCanvas.width = 644;
        finalCanvas.height = 644;
        const finalCtx = finalCanvas.getContext('2d');

        // Extraer área de recorte y escalar a 644x644px
        finalCtx.drawImage(
            tempCanvas,
            cropX, cropY, cropWidth, cropHeight, // Área de origen
            0, 0, 644, 644 // Área de destino (644x644)
        );

        // === PASO 4: Convertir a imagen y guardar ===
        const dataURL = finalCanvas.toDataURL('image/jpeg', 0.95); // JPEG con 95% de calidad

        // Guardar imagen editada (600x600px)
        appState.editedImages[appState.currentEditIndex] = dataURL;
        // NO modificar appState.images - mantener la original

        // === PASO 5: Guardar estado del editor ===
        appState.editorState[appState.currentEditIndex] = {
            filters: {
                ...appState.imageFilters
            },
            rotation: appState.imageRotation,
            scale: appState.imageScale,
            flip: {
                ...appState.imageFlip
            },
            cropBox: {
                left: parseFloat(cropBox.style.left) || 0,
                top: parseFloat(cropBox.style.top) || 0,
                size: parseFloat(cropBox.style.width) || 644
            }
        };

        // Actualizar la grilla con la imagen editada (pero mantener original en appState.images)
        updateGridItem(appState.currentEditIndex, dataURL);
        updateImagesReady();

        // Cerrar el editor
        closeEditor();
    }


    // Resetear item de la rejilla
    function resetGridItem(index) {
        const gridItems = document.querySelectorAll('.grid-item');
        const item = gridItems[index];

        item.innerHTML = `
            <div class="text-center">
                <div class="text-6xl text-gray-300 mb-2">+</div>
                <p class="text-sm text-gray-400">Foto ${index + 1}</p>
            </div>
        `;

        item.classList.add('border-dashed', 'border-gray-300');
        item.classList.remove('border-solid', 'border-dark-turquoise');

        // Limpiar estado del editor guardado
        appState.editorState[index] = null;
    }

    // Actualizar contador de imágenes listas
    function updateImagesReady() {
        const ready = appState.editedImages.filter(img => img !== null).length;
        document.getElementById('images-ready').textContent = `${ready}/9`;

        const generateBtn = document.getElementById('generate-template-btn');
        if (ready === 9) {
            generateBtn.disabled = false;
            generateBtn.classList.remove('bg-gray-300', 'text-gray-500', 'cursor-not-allowed');
            generateBtn.classList.add('bg-gray-orange', 'text-white', 'cursor-pointer', 'hover:bg-gray-brown');

            // Agregar event listener para generar template
            generateBtn.onclick = generateTemplate;
        } else {
            generateBtn.disabled = true;
            generateBtn.classList.add('bg-gray-300', 'text-gray-500', 'cursor-not-allowed');
            generateBtn.classList.remove('bg-gray-orange', 'text-white', 'cursor-pointer', 'hover:bg-gray-brown');
            generateBtn.onclick = null;
        }
    }

    // Generar template con fabric.js (Canvas de composición final)
    async function generateTemplate() {
        // Mostrar modal de procesamiento
        document.getElementById('processing-modal').classList.remove('hidden');

        try {
            console.log('=== INICIANDO GENERACIÓN DE TEMPLATE ===');
            console.log('Imágenes editadas:', appState.editedImages.filter(img => img !== null).length);

            // ============================================================================
            // ESPECIFICACIONES - TEMPLATE DE 9 IMANES EN HOJA A4
            // ============================================================================
            // Canvas Final: 2480 x 3508 px (A4 a 300 DPI)
            // Cada imagen: 644 x 644 px (2x2 pulgadas a 300 DPI)
            // Layout: 3 columnas × 3 filas con textos y dimensiones
            // ============================================================================

            // Dimensiones del canvas final
            const CANVAS_WIDTH = 2480;   // Ancho A4 a 300 DPI
            const CANVAS_HEIGHT = 3508;  // Alto A4 a 300 DPI
            const IMAGE_SIZE = 644;      // Tamaño de cada imagen (2" a 300 DPI)

            // Posiciones exactas de las 9 imágenes (según especificación)
            const POSITIONS = [
                // Fila 1
                { x: 113, y: 263 },
                { x: 915, y: 263 },
                { x: 1718, y: 263 },
                // Fila 2
                { x: 113, y: 1418 },
                { x: 915, y: 1418 },
                { x: 1718, y: 1418 },
                // Fila 3
                { x: 113, y: 2573 },
                { x: 915, y: 2573 },
                { x: 1718, y: 2573 }
            ];

            // Posiciones de los cuadros de texto de número de orden (XXXXX)
            const ORDER_TEXT_POSITIONS = [
                // Fila 1
                { x: 90, y: 638 },
                { x: 892, y: 638 },
                { x: 1695, y: 638 },
                // Fila 2
                { x: 90, y: 1791 },
                { x: 892, y: 1791 },
                { x: 1695, y: 1791 },
                // Fila 3
                { x: 90, y: 2945 },
                { x: 892, y: 2945 },
                { x: 1695, y: 2945 }
            ];

            console.log('Creando canvas de', CANVAS_WIDTH, 'x', CANVAS_HEIGHT, 'px');

            // Crear un canvas offscreen para la composición
            const fabricCanvas = new fabric.Canvas(null, {
                width: CANVAS_WIDTH,
                height: CANVAS_HEIGHT,
                backgroundColor: '#ffffff'
            });

            console.log('Canvas creado exitosamente');

            // Función helper para cargar imagen como objeto fabric
            function loadFabricImage(dataURL) {
                return new Promise((resolve, reject) => {
                    fabric.Image.fromURL(dataURL, (img) => {
                        if (img) {
                            resolve(img);
                        } else {
                            reject(new Error('No se pudo cargar la imagen'));
                        }
                    });
                });
            }

            // Cargar y posicionar las 9 imágenes editadas (644x644px cada una)
            const imagePromises = appState.editedImages.map(async (imageDataURL, index) => {
                if (!imageDataURL) {
                    throw new Error(`Falta la imagen ${index + 1}`);
                }

                // Cargar imagen como objeto fabric
                const fabricImg = await loadFabricImage(imageDataURL);

                // Las imágenes editadas ya son 644x644px, no necesitan escalado adicional
                // Solo posicionarlas en las coordenadas exactas
                fabricImg.set({
                    left: POSITIONS[index].x,
                    top: POSITIONS[index].y,
                    scaleX: 1,
                    scaleY: 1,
                    selectable: false,
                    evented: false
                });

                return fabricImg;
            });

            console.log('Cargando imágenes...');

            // Esperar a que todas las imágenes se carguen
            const fabricImages = await Promise.all(imagePromises);

            console.log('Imágenes cargadas:', fabricImages.length);

            // Generar número de orden temporal
            const tempOrderNumber = 'IM-' + Math.random().toString(36).substr(2, 8).toUpperCase();

            // Agregar todas las imágenes al canvas con textos y dimensiones
            fabricImages.forEach((img, index) => {
                const pos = POSITIONS[index];
                const orderPos = ORDER_TEXT_POSITIONS[index];
                console.log(`Agregando imán ${index + 1} en posición (${pos.x}, ${pos.y})`);

                // Calcular margen y tamaño de imagen
                const innerMargin = 50;
                const imageDisplaySize = 644 - (innerMargin * 2); // 544px

                // === 1. TEXTO SUPERIOR: "Imani Magnets" (pegado arriba del borde interior) ===
                const topText = new fabric.Text('Imani Magnets', {
                    left: pos.x + IMAGE_SIZE / 2,
                    top: pos.y + innerMargin - 28,  // 28px arriba del borde interior (pegado)
                    fontSize: 20,
                    fontFamily: 'League Spartan, Arial, sans-serif',
                    fontWeight: '600',
                    fill: '#12463c',
                    textAlign: 'center',
                    originX: 'center',
                    selectable: false,
                    evented: false
                });
                fabricCanvas.add(topText);

                // === 2. NÚMERO DE ORDEN LATERAL (pegado al borde interior izquierdo, rotado) ===
                const leftOrderNumber = new fabric.Text(tempOrderNumber, {
                    left: pos.x + innerMargin - 15,  // 15px a la izquierda del borde interior (pegado)
                    top: pos.y + IMAGE_SIZE / 2,
                    fontSize: 12,
                    fontFamily: 'Arial',
                    fontWeight: 'bold',
                    fill: '#000000',
                    angle: -90,
                    textAlign: 'center',
                    originX: 'center',
                    originY: 'center',
                    selectable: false,
                    evented: false
                });
                fabricCanvas.add(leftOrderNumber);

                // === 4. BORDE NEGRO EXTERIOR 644x644px ===
                const outerRect = new fabric.Rect({
                    left: pos.x,
                    top: pos.y,
                    width: IMAGE_SIZE,
                    height: IMAGE_SIZE,
                    fill: 'transparent',
                    stroke: '#000000',
                    strokeWidth: 2,
                    selectable: false,
                    evented: false
                });
                fabricCanvas.add(outerRect);

                // === 5. IMAGEN (con margen de 50px por cada lado) ===
                img.set({
                    left: pos.x + innerMargin,
                    top: pos.y + innerMargin,
                    scaleX: imageDisplaySize / 644,  // Escalar a 544px
                    scaleY: imageDisplaySize / 644
                });
                fabricCanvas.add(img);

                // === 6. BORDE INTERIOR 544x544px (área de imagen con margen de 50px) ===
                const innerRect = new fabric.Rect({
                    left: pos.x + innerMargin,
                    top: pos.y + innerMargin,
                    width: imageDisplaySize,
                    height: imageDisplaySize,
                    fill: 'transparent',
                    stroke: '#999999',
                    strokeWidth: 1,
                    selectable: false,
                    evented: false
                });
                fabricCanvas.add(innerRect);

                // === 7. LOGO DE INSTAGRAM + HANDLE "@imanimagnets" (pegado debajo del borde interior) ===
                // Crear logo de Instagram (círculo con cuadrado redondeado y punto)
                const instaLogoSize = 18;
                const instaLogoX = pos.x + IMAGE_SIZE / 2 - 60;
                const instaLogoY = pos.y + innerMargin + imageDisplaySize + 5;  // 5px debajo del borde interior (pegado)

                // Círculo exterior del logo de Instagram
                const instaCircle = new fabric.Circle({
                    left: instaLogoX,
                    top: instaLogoY,
                    radius: instaLogoSize / 2,
                    fill: 'transparent',
                    stroke: '#5c533b',
                    strokeWidth: 1.5,
                    selectable: false,
                    evented: false
                });
                fabricCanvas.add(instaCircle);

                // Cuadrado redondeado interior
                const instaSquare = new fabric.Rect({
                    left: instaLogoX + 4,
                    top: instaLogoY + 4,
                    width: instaLogoSize - 8,
                    height: instaLogoSize - 8,
                    fill: 'transparent',
                    stroke: '#5c533b',
                    strokeWidth: 1.5,
                    rx: 2,
                    ry: 2,
                    selectable: false,
                    evented: false
                });
                fabricCanvas.add(instaSquare);

                // Punto pequeño (esquina superior derecha)
                const instaDot = new fabric.Circle({
                    left: instaLogoX + instaLogoSize - 5,
                    top: instaLogoY + 3,
                    radius: 1.5,
                    fill: '#5c533b',
                    selectable: false,
                    evented: false
                });
                fabricCanvas.add(instaDot);

                // Texto del handle
                const instagramText = new fabric.Text('@imanimagnets', {
                    left: instaLogoX + instaLogoSize + 8,
                    top: instaLogoY + 3,
                    fontSize: 16,
                    fontFamily: 'Arial, sans-serif',
                    fontWeight: '400',
                    fill: '#5c533b',
                    selectable: false,
                    evented: false
                });
                fabricCanvas.add(instagramText);
            });

            console.log('Número de orden generado:', tempOrderNumber);

            // === AGREGAR LÍNEAS DIVISORIAS HORIZONTALES ENTRE FILAS ===
            // Calcular posiciones entre filas (a la mitad entre cada par de filas)
            // Fila 1: y=263, Fila 2: y=1418, Fila 3: y=2573

            // Línea entre fila 1 y 2
            const dividerLine1Y = (263 + 644 + 1418) / 2; // Punto medio entre fin de fila1 y inicio de fila2
            const dividerLine1 = new fabric.Line([
                50,  // Desde la izquierda
                dividerLine1Y,
                CANVAS_WIDTH - 50,  // Hasta la derecha
                dividerLine1Y
            ], {
                stroke: '#000000',
                strokeWidth: 1,
                strokeDashArray: [10, 5],  // Línea punteada
                selectable: false,
                evented: false
            });
            fabricCanvas.add(dividerLine1);

            // Línea entre fila 2 y 3
            const dividerLine2Y = (1418 + 644 + 2573) / 2; // Punto medio entre fin de fila2 y inicio de fila3
            const dividerLine2 = new fabric.Line([
                50,  // Desde la izquierda
                dividerLine2Y,
                CANVAS_WIDTH - 50,  // Hasta la derecha
                dividerLine2Y
            ], {
                stroke: '#000000',
                strokeWidth: 1,
                strokeDashArray: [10, 5],  // Línea punteada
                selectable: false,
                evented: false
            });
            fabricCanvas.add(dividerLine2);

            console.log('Líneas divisorias horizontales agregadas');

            // === AGREGAR NÚMERO DE ORDEN PRINCIPAL EN LA PARTE SUPERIOR ===
            const mainOrderNumber = new fabric.Text(tempOrderNumber, {
                left: CANVAS_WIDTH / 2,
                top: 50,
                fontSize: 20,
                fontFamily: 'Arial',
                fontWeight: 'bold',
                fill: '#000000',
                textAlign: 'center',
                originX: 'center',
                selectable: false,
                evented: false
            });
            fabricCanvas.add(mainOrderNumber);
            console.log('Número de orden principal agregado en la parte superior');

            // Renderizar el canvas
            fabricCanvas.renderAll();
            console.log('Canvas renderizado');

            // Convertir el canvas a PNG de alta calidad
            console.log('Convirtiendo canvas a PNG...');
            const finalPNG = fabricCanvas.toDataURL({
                format: 'png',
                quality: 1,
                multiplier: 1 // 1x = tamaño original (2362x3217px)
            });

            console.log('PNG generado, tamaño:', (finalPNG.length / 1024 / 1024).toFixed(2), 'MB');

            // === ENVIAR AL BACKEND PARA GUARDAR ===
            console.log('Enviando al servidor...');
            const response = await fetch('{{ route("personalizados.process") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    final_image: finalPNG,
                    customer_email: null, // Puedes agregar un campo para email
                    customer_name: null // Puedes agregar un campo para nombre
                })
            });

            console.log('Respuesta del servidor:', response.status, response.statusText);

            if (!response.ok) {
                const errorText = await response.text();
                console.error('Error del servidor:', errorText);
                throw new Error(`Error del servidor: ${response.status} - ${errorText.substring(0, 200)}`);
            }

            const data = await response.json();
            console.log('Datos recibidos:', data);

            // Ocultar modal de procesamiento
            document.getElementById('processing-modal').classList.add('hidden');

            if (data.success) {
                console.log('Template generado exitosamente:', data.order_number);
                // Mostrar modal de éxito
                document.getElementById('order-number-display').textContent = data.order_number;
                document.getElementById('download-link').href = data.download_url;
                document.getElementById('success-modal').classList.remove('hidden');
            } else {
                console.error('Error en respuesta:', data);
                alert('Error: ' + (data.message || 'No se pudo generar el template'));
            }

            // Limpiar el canvas
            fabricCanvas.dispose();

        } catch (error) {
            document.getElementById('processing-modal').classList.add('hidden');
            console.error('Error detallado:', error);
            console.error('Stack trace:', error.stack);

            // Mostrar error más detallado
            let errorMessage = 'Error desconocido';
            if (error.message) {
                errorMessage = error.message;
            } else if (typeof error === 'string') {
                errorMessage = error;
            }

            alert('Error al generar el template:\n\n' + errorMessage + '\n\nRevisa la consola del navegador (F12) para más detalles.');
        }
    }

    // Cerrar modal de éxito
    document.getElementById('close-success-modal').addEventListener('click', () => {
        document.getElementById('success-modal').classList.add('hidden');
        // Opcional: resetear el formulario o redirigir
    });

    // Mostrar/ocultar barra de progreso
    function showProgressBar() {
        document.getElementById('progress-container').classList.remove('hidden');
    }

    function hideProgressBar() {
        document.getElementById('progress-container').classList.add('hidden');
    }

    function updateProgress(percent) {
        document.getElementById('progress-bar').style.width = `${percent}%`;
        document.getElementById('progress-text').textContent = `${Math.round(percent)}%`;
    }

    // Mostrar rejilla de imágenes
    function showImageGrid() {
        // Ocultar Paso 1
        document.getElementById('upload-area').classList.add('hidden');
        // Mostrar Paso 2 en el mismo espacio
        document.getElementById('image-grid-container').classList.remove('hidden');
    }

    // Resetear todo y volver al paso de subida
    function resetUploadArea() {
        console.log('Reseteando área de subida...');

        // Resetear TODAS las propiedades del estado de la aplicación
        appState.images = new Array(9).fill(null);
        appState.editedImages = new Array(9).fill(null);
        appState.editorState = new Array(9).fill(null);
        appState.currentEditIndex = null;
        appState.currentImageElement = null;
        appState.imageScale = 1;
        appState.imageRotation = 0;
        appState.imageFlip = { horizontal: false, vertical: false };
        appState.imageFilters = {
            brightness: 100,
            contrast: 100,
            saturate: 100,
            blur: 0,
            grayscale: 0,
            sepia: 0
        };

        // Limpiar el input de archivos
        const fileInput = document.getElementById('file-input');
        fileInput.value = '';

        // Resetear todas las celdas del grid
        document.querySelectorAll('.grid-item').forEach((item, index) => {
            item.innerHTML = `
                <div class="text-center">
                    <div class="text-6xl text-gray-300 mb-2">+</div>
                    <p class="text-sm text-gray-400">Foto ${index + 1}</p>
                </div>
            `;
            item.style.backgroundImage = '';
            item.style.backgroundSize = '';
            item.style.backgroundPosition = '';
        });

        // Actualizar contador
        document.getElementById('images-ready').textContent = '0/9';

        // Deshabilitar botón de generar
        const generateBtn = document.getElementById('generate-template-btn');
        generateBtn.disabled = true;
        generateBtn.classList.remove('bg-dark-turquoise', 'hover:bg-dark-turquoise-alt', 'text-white');
        generateBtn.classList.add('bg-gray-300', 'text-gray-500', 'cursor-not-allowed');

        // Ocultar barra de progreso
        document.getElementById('progress-container').classList.add('hidden');
        document.getElementById('progress-bar').style.width = '0%';
        document.getElementById('progress-text').textContent = '0%';

        // Cambiar de vista
        document.getElementById('image-grid-container').classList.add('hidden');
        document.getElementById('upload-area').classList.remove('hidden');

        console.log('Reset completado. Estado:', appState);
    }
</script>
@endpush