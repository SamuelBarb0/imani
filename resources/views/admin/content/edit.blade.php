@extends('layouts.app')

@section('title', 'Editor de Contenido - ' . ucfirst($page))

@push('styles')
<style>
    /* Fix para zoom del navegador - contenedor de imagen con posición relativa fija */
    [data-preview-container] {
        width: 12rem; /* w-48 = 192px = 12rem */
        height: 12rem;
        position: relative;
        display: block;
    }

    [data-preview-container] img {
        width: 100%;
        height: 100%;
        display: block;
    }

    [data-edit-overlay] {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
    }

    /* Mejora visual de los botones */
    [data-edit-overlay] button {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    /* Efecto de pulso cuando se hace clic en el botón de rotar */
    @keyframes buttonPulse {
        0% {
            box-shadow: 0 0 0 0 rgba(52, 211, 153, 0.7);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(52, 211, 153, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(52, 211, 153, 0);
        }
    }

    .button-pulse {
        animation: buttonPulse 0.5s ease-out;
    }

    /* Estado activo mejorado para los botones */
    [data-edit-overlay] button:active {
        transform: scale(0.95) !important;
    }

    /* En mobile, mostrar botones semi-transparentes siempre */
    @media (max-width: 1024px) {
        [data-edit-overlay] {
            background-color: rgba(0, 0, 0, 0.3) !important;
        }
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="container mx-auto px-6 max-w-7xl">

        <!-- Header -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="font-spartan text-3xl font-bold text-dark-turquoise mb-2">
                        Editor de Contenido
                    </h1>
                    <p class="text-gray-brown">
                        Editando página: <strong class="text-dark-turquoise">{{ ucfirst($page) }}</strong>
                    </p>
                </div>
                <a href="{{ route('home') }}" class="px-6 py-3 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg font-semibold transition">
                    Ver Página
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded">
                <div class="flex">
                    <svg class="w-6 h-6 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <p class="text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if($page === 'colecciones')
            <div class="bg-blue-50 border-l-4 border-blue-400 p-6 mb-6 rounded-lg shadow">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-blue-400 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="flex-grow">
                        <h3 class="font-spartan font-bold text-blue-800 mb-2">Gestión de Colecciones Dinámicas</h3>
                        <p class="text-blue-700 mb-3">
                            Aquí puedes editar los textos del header y elementos comunes de la página de Colecciones.
                            <strong>Las colecciones individuales (Ecuador I, Ecuador II, etc.)</strong> se gestionan en el panel de Colecciones.
                        </p>
                        <a href="{{ route('admin.collections.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Gestionar Colecciones (Crear/Editar/Eliminar)
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Content Editor Form -->
        <form action="{{ route('admin.content.update', $page) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @foreach($contents as $section => $items)
                <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                    <h2 class="font-spartan text-xl font-bold text-dark-turquoise mb-4 pb-3 border-b border-gray-200">
                        Sección: {{ ucfirst(str_replace('_', ' ', $section)) }}
                    </h2>

                    <div class="space-y-4">
                        @foreach($items as $index => $item)
                            <div class="border-l-4 border-gray-orange pl-4 py-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ ucfirst(str_replace('_', ' ', $item->key)) }}
                                    <span class="text-xs text-gray-500 font-normal">({{ $item->type }})</span>
                                </label>

                                <!-- Hidden fields -->
                                <input type="hidden" name="contents[{{ $section }}_{{ $item->key }}][section]" value="{{ $item->section }}">
                                <input type="hidden" name="contents[{{ $section }}_{{ $item->key }}][key]" value="{{ $item->key }}">
                                <input type="hidden" name="contents[{{ $section }}_{{ $item->key }}][type]" value="{{ $item->type }}">

                                @if($item->type === 'text')
                                    <!-- Simple text input -->
                                    <input
                                        type="text"
                                        name="contents[{{ $section }}_{{ $item->key }}][value]"
                                        value="{{ $item->value }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                                    >

                                @elseif($item->type === 'textarea')
                                    <!-- Textarea -->
                                    <textarea
                                        name="contents[{{ $section }}_{{ $item->key }}][value]"
                                        rows="3"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                                    >{{ $item->value }}</textarea>

                                @elseif($item->type === 'html')
                                    <!-- HTML editor (textarea with code formatting) -->
                                    <textarea
                                        name="contents[{{ $section }}_{{ $item->key }}][value]"
                                        rows="4"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent font-mono text-sm"
                                    >{{ $item->value }}</textarea>
                                    <p class="text-xs text-gray-500 mt-1">Puedes usar HTML básico: &lt;br&gt;, &lt;strong&gt;, &lt;em&gt;</p>

                                @elseif($item->type === 'image')
                                    <!-- Image upload -->
                                    <div class="space-y-3" data-image-container>
                                        @if($item->value)
                                            <div class="flex flex-col lg:flex-row items-start lg:items-center space-y-4 lg:space-y-0 lg:space-x-4">
                                                <!-- Image Preview Container with Overlay -->
                                                <div class="relative group" data-preview-container>
                                                    <img
                                                        src="{{ asset($item->value) }}"
                                                        alt="{{ $item->key }}"
                                                        class="w-48 h-48 object-cover rounded-lg border-2 border-gray-300 transition-transform"
                                                        data-preview-image
                                                        data-rotation="0"
                                                        style="transform: rotate(0deg);"
                                                    >

                                                    <!-- Overlay with Edit Options - Always Visible on Mobile, Hover on Desktop -->
                                                    <div class="absolute inset-0 bg-black bg-opacity-0 lg:group-hover:bg-opacity-60 transition-all duration-300 rounded-lg flex items-center justify-center" data-edit-overlay>
                                                        <div class="opacity-100 lg:opacity-0 lg:group-hover:opacity-100 transition-opacity duration-300 flex gap-2">
                                                            <!-- Rotate Button -->
                                                            <button
                                                                type="button"
                                                                class="p-3 bg-emerald-400 hover:bg-emerald-500 active:bg-emerald-600 text-white rounded-lg shadow-lg transform hover:scale-110 active:scale-95 transition-all duration-150 ring-2 ring-transparent hover:ring-emerald-300"
                                                                onclick="rotateImage(this)"
                                                                title="Rotar 90°"
                                                            >
                                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                                </svg>
                                                            </button>

                                                            <!-- Delete Button -->
                                                            <button
                                                                type="button"
                                                                class="p-3 bg-red-500 hover:bg-red-600 active:bg-red-700 text-white rounded-lg shadow-lg transform hover:scale-110 active:scale-95 transition-all duration-150 ring-2 ring-transparent hover:ring-red-300"
                                                                onclick="deleteImage(this)"
                                                                title="Eliminar imagen"
                                                            >
                                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Image Info -->
                                                <div>
                                                    <p class="text-sm text-gray-700 mb-2"><strong>Imagen actual:</strong> {{ basename($item->value) }}</p>
                                                    <p class="text-xs text-gray-500">Pasa el cursor sobre la imagen para ver las opciones de edición</p>
                                                </div>
                                            </div>
                                        @else
                                            <div class="flex items-center justify-center w-48 h-48 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300" data-empty-placeholder>
                                                <p class="text-gray-400 text-sm text-center">Sin imagen</p>
                                            </div>
                                        @endif

                                        <!-- File Upload Input -->
                                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 bg-gray-50 hover:bg-gray-100 transition">
                                            <label class="block cursor-pointer">
                                                <div class="flex items-center space-x-3">
                                                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                                    </svg>
                                                    <div>
                                                        <p class="text-sm font-semibold text-gray-700">Subir nueva imagen</p>
                                                        <p class="text-xs text-gray-500">Click para seleccionar archivo (JPG, PNG, WEBP - Max 25MB)</p>
                                                    </div>
                                                </div>
                                                <input
                                                    type="file"
                                                    accept="image/jpeg,image/png,image/jpg,image/webp"
                                                    class="hidden"
                                                    data-upload-input
                                                    onchange="handleImageUpload(this, '{{ $page }}', '{{ $section }}', '{{ $item->key }}')"
                                                >
                                            </label>
                                        </div>

                                        <!-- Hidden field for image path -->
                                        <input
                                            type="text"
                                            name="contents[{{ $section }}_{{ $item->key }}][value]"
                                            value="{{ $item->value }}"
                                            placeholder="Ruta de la imagen (ej: images/foto.jpg)"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent text-sm"
                                            data-path-input
                                        >
                                        <p class="text-xs text-gray-500">
                                            💡 Puedes subir una imagen usando el botón de arriba o escribir la ruta manualmente si ya está en <code class="bg-gray-100 px-2 py-1 rounded">public/images/</code>
                                        </p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <!-- Save Button -->
            <div class="bg-white rounded-lg shadow-lg p-6 sticky bottom-6">
                <div class="flex justify-between items-center">
                    <p class="text-gray-700">
                        <svg class="w-5 h-5 inline text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Los cambios se guardarán y serán visibles inmediatamente en la página
                    </p>
                    <button
                        type="submit"
                        class="px-8 py-3 bg-dark-turquoise hover:bg-dark-turquoise-alt text-white rounded-lg font-spartan font-semibold text-base tracking-wider uppercase transition shadow-lg"
                    >
                        💾 Guardar Cambios
                    </button>
                </div>
            </div>
        </form>

        <!-- Quick Links -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
            <a href="{{ route('admin.content.edit', 'home') }}" class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition text-center {{ $page === 'home' ? 'ring-2 ring-dark-turquoise' : '' }}">
                <p class="font-semibold text-gray-800">Editar Home</p>
            </a>
            <a href="{{ route('admin.content.edit', 'personalizados') }}" class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition text-center {{ $page === 'personalizados' ? 'ring-2 ring-dark-turquoise' : '' }}">
                <p class="font-semibold text-gray-800">Editar Personalizados</p>
            </a>
            <a href="{{ route('admin.content.edit', 'colecciones') }}" class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition text-center {{ $page === 'colecciones' ? 'ring-2 ring-dark-turquoise' : '' }}">
                <p class="font-semibold text-gray-800">Editar Colecciones</p>
            </a>
            <a href="{{ route('admin.content.edit', 'contacto') }}" class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition text-center {{ $page === 'contacto' ? 'ring-2 ring-dark-turquoise' : '' }}">
                <p class="font-semibold text-gray-800">Editar Contacto</p>
            </a>
            <a href="{{ route('admin.content.edit', 'mayoristas') }}" class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition text-center {{ $page === 'mayoristas' ? 'ring-2 ring-dark-turquoise' : '' }}">
                <p class="font-semibold text-gray-800">Editar Mayoristas</p>
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Rotate image by 90 degrees
    function rotateImage(button) {
        const container = button.closest('[data-preview-container]');
        const img = container.querySelector('[data-preview-image]');
        let currentRotation = parseInt(img.getAttribute('data-rotation') || '0');

        // Increment rotation by 90 degrees
        currentRotation = (currentRotation + 90) % 360;

        // Apply rotation
        img.style.transform = `rotate(${currentRotation}deg)`;
        img.setAttribute('data-rotation', currentRotation);

        // Add pulse effect to button
        button.classList.add('button-pulse');
        setTimeout(() => {
            button.classList.remove('button-pulse');
        }, 500);

        showNotification(`Imagen rotada ${currentRotation}°`, 'success');
    }

    // Delete image
    function deleteImage(button) {
        if (!confirm('¿Estás seguro de eliminar esta imagen?')) return;

        const container = button.closest('[data-image-container]');
        const preview = container.querySelector('[data-preview-image]');
        const pathInput = container.querySelector('[data-path-input]');
        const fileInput = container.querySelector('[data-upload-input]');
        const previewContainer = container.querySelector('[data-preview-container]');

        // Clear values
        if (preview) preview.src = '';
        if (pathInput) pathInput.value = '';
        if (fileInput) fileInput.value = '';

        // Replace with empty placeholder
        if (previewContainer) {
            const placeholder = document.createElement('div');
            placeholder.className = 'flex items-center justify-center w-48 h-48 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300';
            placeholder.setAttribute('data-empty-placeholder', '');
            placeholder.innerHTML = '<p class="text-gray-400 text-sm text-center">Sin imagen</p>';
            previewContainer.parentElement.replaceWith(placeholder);
        }

        showNotification('Imagen eliminada', 'success');
    }

    // Handle image upload
    async function handleImageUpload(input, page, section, key) {
        const file = input.files[0];
        if (!file) return;

        // Validate file size (25MB max)
        if (file.size > 25 * 1024 * 1024) {
            alert('El archivo es demasiado grande. El tamaño máximo es 25MB.');
            input.value = '';
            return;
        }

        // Validate file type
        if (!file.type.match(/^image\/(jpeg|jpg|png|webp)$/)) {
            alert('Tipo de archivo no válido. Solo se permiten JPG, PNG y WEBP.');
            input.value = '';
            return;
        }

        const container = input.closest('[data-image-container]');
        const preview = container.querySelector('[data-preview-image]');
        const pathInput = container.querySelector('[data-path-input]');

        // Show loading state
        const loadingDiv = document.createElement('div');
        loadingDiv.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
        loadingDiv.innerHTML = `
            <div class="bg-white rounded-lg p-6 flex items-center space-x-4">
                <svg class="animate-spin h-8 w-8 text-dark-turquoise" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-lg font-semibold">Subiendo imagen...</span>
            </div>
        `;
        document.body.appendChild(loadingDiv);

        try {
            // Create FormData
            const formData = new FormData();
            formData.append('image', file);
            formData.append('page', page);
            formData.append('section', section);
            formData.append('key', key);

            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content
                           || document.querySelector('input[name="_token"]')?.value;

            // Upload image
            const response = await fetch('{{ route("admin.content.upload-image") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                // Get base URL for assets
                const baseUrl = '{{ config('app.url') }}';
                const imagePath = data.path.startsWith('/') ? data.path : '/' + data.path;

                // Update preview or create new preview structure
                if (preview) {
                    preview.src = baseUrl + imagePath;
                    preview.setAttribute('data-rotation', '0');
                    preview.style.transform = 'rotate(0deg)';
                } else {
                    // Create complete preview structure
                    const emptyPlaceholder = container.querySelector('[data-empty-placeholder]');
                    if (emptyPlaceholder) {
                        const newStructure = document.createElement('div');
                        newStructure.className = 'flex flex-col lg:flex-row items-start lg:items-center space-y-4 lg:space-y-0 lg:space-x-4';
                        newStructure.innerHTML = `
                            <div class="relative group" data-preview-container>
                                <img
                                    src="${baseUrl}${imagePath}"
                                    alt="Preview"
                                    class="w-48 h-48 object-cover rounded-lg border-2 border-gray-300 transition-transform"
                                    data-preview-image
                                    data-rotation="0"
                                    style="transform: rotate(0deg);"
                                >
                                <div class="absolute inset-0 bg-black bg-opacity-0 lg:group-hover:bg-opacity-60 transition-all duration-300 rounded-lg flex items-center justify-center" data-edit-overlay>
                                    <div class="opacity-100 lg:opacity-0 lg:group-hover:opacity-100 transition-opacity duration-300 flex gap-2">
                                        <button
                                            type="button"
                                            class="p-3 bg-emerald-400 hover:bg-emerald-500 active:bg-emerald-600 text-white rounded-lg shadow-lg transform hover:scale-110 active:scale-95 transition-all duration-150 ring-2 ring-transparent hover:ring-emerald-300"
                                            onclick="rotateImage(this)"
                                            title="Rotar 90°"
                                        >
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                        </button>
                                        <button
                                            type="button"
                                            class="p-3 bg-red-500 hover:bg-red-600 active:bg-red-700 text-white rounded-lg shadow-lg transform hover:scale-110 active:scale-95 transition-all duration-150 ring-2 ring-transparent hover:ring-red-300"
                                            onclick="deleteImage(this)"
                                            title="Eliminar imagen"
                                        >
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm text-gray-700 mb-2"><strong>Imagen actual:</strong> ${data.path.split('/').pop()}</p>
                                <p class="text-xs text-gray-500">Pasa el cursor sobre la imagen para ver las opciones de edición</p>
                            </div>
                        `;
                        emptyPlaceholder.replaceWith(newStructure);
                    }
                }

                // Update path input
                pathInput.value = data.path;

                // Show success message
                showNotification('Imagen subida exitosamente', 'success');
            } else {
                throw new Error(data.message || 'Error al subir la imagen');
            }
        } catch (error) {
            console.error('Error uploading image:', error);
            alert('Error al subir la imagen: ' + error.message);
            input.value = '';
        } finally {
            document.body.removeChild(loadingDiv);
        }
    }

    // Show notification
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 ${
            type === 'success' ? 'bg-green-500' : 'bg-red-500'
        } text-white font-semibold`;
        notification.textContent = message;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    // Auto-save draft to localStorage (optional enhancement)
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input, textarea');

    inputs.forEach(input => {
        input.addEventListener('input', () => {
            const draftKey = `draft_${window.location.pathname}`;
            const formData = new FormData(form);
            const draftData = {};

            for (let [key, value] of formData.entries()) {
                draftData[key] = value;
            }

            localStorage.setItem(draftKey, JSON.stringify(draftData));
        });
    });

    // Show confirmation when leaving with unsaved changes
    let formChanged = false;
    inputs.forEach(input => {
        input.addEventListener('change', () => {
            formChanged = true;
        });
    });

    form.addEventListener('submit', () => {
        formChanged = false;
    });

    window.addEventListener('beforeunload', (e) => {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = '¿Seguro que quieres salir sin guardar?';
        }
    });
</script>
@endpush
@endsection
