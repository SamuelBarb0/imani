@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8 max-w-4xl">
    <div class="mb-6">
        <a href="{{ route('admin.collections.index') }}" class="text-dark-turquoise hover:underline">&larr; Volver a Colecciones</a>
    </div>

    <h1 class="text-3xl font-bold text-dark-turquoise mb-6">Editar Colección: {{ $collection->name }}</h1>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.collections.update', $collection) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nombre de la Colección *</label>
            <input type="text" name="name" id="name" value="{{ old('name', $collection->name) }}" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                   placeholder="Ej: ECUADOR I">
        </div>

        <div class="mb-6">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
            <textarea name="description" id="description" rows="3"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                      placeholder="Ej: Primera colección con imanes de:">{{ old('description', $collection->description) }}</textarea>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Imagen Principal Actual</label>
            <img src="{{ asset($collection->image) }}" alt="{{ $collection->name }}" class="h-32 w-32 object-cover rounded mb-2">

            <label for="image" class="block text-sm font-medium text-gray-700 mb-2 mt-4">Nueva Imagen Principal (opcional)</label>
            <input type="file" name="image" id="image" accept="image/*"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent">
            <p class="text-sm text-gray-500 mt-1">Formatos permitidos: JPG, PNG, GIF, WEBP. Máximo 2MB. Deja vacío para mantener la imagen actual.</p>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Galería Actual</label>
            @if($collection->gallery && count($collection->gallery) > 0)
                <div id="existing-gallery" class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-4">
                    @foreach($collection->gallery as $index => $imagePath)
                        <div class="relative group" data-index="{{ $index }}" data-path="{{ $imagePath }}" id="existing-image-{{ $index }}">
                            <img src="{{ asset($imagePath) }}" class="w-full h-32 object-cover rounded border border-gray-300" alt="Galería {{ $index + 1 }}">
                            <button type="button" onclick="deleteExistingGalleryImage(this)"
                                    class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500 mb-4">No hay imágenes en la galería.</p>
            @endif

            <label for="gallery" class="block text-sm font-medium text-gray-700 mb-2 mt-4">Agregar Nuevas Imágenes a la Galería</label>
            <input type="file" name="gallery[]" id="gallery" accept="image/*" multiple
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent">
            <p class="text-sm text-gray-500 mt-1">Selecciona hasta 6 imágenes adicionales. JPG, PNG, GIF, WEBP. Máximo 2MB cada una.</p>

            <!-- New Gallery Preview -->
            <div id="gallery-preview" class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-4 hidden"></div>

            <!-- Hidden inputs for deleted images -->
            <div id="deleted-images-container"></div>
        </div>

        <div class="mb-6">
            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Precio (USD) *</label>
            <input type="number" name="price" id="price" value="{{ old('price', $collection->price) }}" step="0.01" min="0" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                   placeholder="19.99">
        </div>

        <div class="mb-6">
            <label for="items" class="block text-sm font-medium text-gray-700 mb-2">Items de la Colección</label>
            <textarea name="items" id="items" rows="6"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                      placeholder="Ingresa cada item en una línea nueva:&#10;Cuenca&#10;Mindo&#10;Galápagos&#10;Quito&#10;Mitad del Mundo&#10;Quilotoa">{{ old('items', $collection->items ? implode("\n", $collection->items) : '') }}</textarea>
            <p class="text-sm text-gray-500 mt-1">Escribe cada item en una línea nueva. Deja vacío si no aplica.</p>
        </div>

        <div class="mb-6">
            <label for="order" class="block text-sm font-medium text-gray-700 mb-2">Orden de Visualización *</label>
            <input type="number" name="order" id="order" value="{{ old('order', $collection->order) }}" min="0" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                   placeholder="0">
            <p class="text-sm text-gray-500 mt-1">Las colecciones se ordenan de menor a mayor número.</p>
        </div>

        <div class="mb-6">
            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $collection->is_active) ? 'checked' : '' }}
                       class="w-4 h-4 text-dark-turquoise border-gray-300 rounded focus:ring-dark-turquoise">
                <span class="ml-2 text-sm text-gray-700">Colección activa (visible en el sitio)</span>
            </label>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-dark-turquoise hover:bg-dark-turquoise-alt text-white px-6 py-3 rounded-lg font-semibold">
                Actualizar Colección
            </button>
            <a href="{{ route('admin.collections.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-lg font-semibold">
                Cancelar
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const galleryInput = document.getElementById('gallery');
    const galleryPreview = document.getElementById('gallery-preview');
    const deletedImagesContainer = document.getElementById('deleted-images-container');
    let selectedFiles = [];

    galleryInput.addEventListener('change', function(e) {
        const files = Array.from(e.target.files);

        // Limit to 7 images
        if (files.length > 7) {
            alert('Puedes seleccionar hasta 7 imágenes para la galería.');
            return;
        }

        selectedFiles = files;
        updateGalleryPreview();
    });

    function updateGalleryPreview() {
        galleryPreview.innerHTML = '';

        if (selectedFiles.length === 0) {
            galleryPreview.classList.add('hidden');
            return;
        }

        galleryPreview.classList.remove('hidden');

        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();

            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative group';
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-32 object-cover rounded border border-gray-300" alt="Preview ${index + 1}">
                    <button type="button" onclick="removeGalleryImage(${index})"
                            class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                `;
                galleryPreview.appendChild(div);
            };

            reader.readAsDataURL(file);
        });
    }

    // Remove image from new selection
    window.removeGalleryImage = function(index) {
        selectedFiles.splice(index, 1);

        // Update the file input
        const dt = new DataTransfer();
        selectedFiles.forEach(file => dt.items.add(file));
        galleryInput.files = dt.files;

        updateGalleryPreview();
    };

    // Delete existing gallery image
    window.deleteExistingGalleryImage = function(button) {
        if (!confirm('¿Estás seguro de que quieres eliminar esta imagen de la galería?')) {
            return;
        }

        const container = button.closest('.relative');
        const index = container.dataset.index;
        const path = container.dataset.path;

        // Add hidden input to track deleted images
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'deleted_gallery[]';
        input.value = path;
        deletedImagesContainer.appendChild(input);

        // Remove the image from display
        container.remove();
    };
});
</script>
@endpush
@endsection
