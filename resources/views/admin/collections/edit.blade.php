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
            <label class="block text-sm font-medium text-gray-700 mb-2">Imagen Actual</label>
            <img src="{{ asset($collection->image) }}" alt="{{ $collection->name }}" class="h-32 w-32 object-cover rounded mb-2">

            <label for="image" class="block text-sm font-medium text-gray-700 mb-2 mt-4">Nueva Imagen (opcional)</label>
            <input type="file" name="image" id="image" accept="image/*"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent">
            <p class="text-sm text-gray-500 mt-1">Formatos permitidos: JPG, PNG, GIF, WEBP. Máximo 2MB. Deja vacío para mantener la imagen actual.</p>
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
@endsection
