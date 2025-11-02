@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8 max-w-4xl">
    <div class="mb-6">
        <a href="{{ route('admin.provinces.index') }}" class="text-dark-turquoise hover:underline">&larr; Volver a Provincias</a>
    </div>

    <h1 class="text-3xl font-bold text-dark-turquoise mb-6">Editar Provincia</h1>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.provinces.update', $province) }}" method="POST" class="bg-white rounded-lg shadow p-6">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nombre de la Provincia *</label>
            <input type="text" name="name" id="name" value="{{ old('name', $province->name) }}" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                   placeholder="Ej: Pichincha">
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $province->is_active) ? 'checked' : '' }}
                       class="w-4 h-4 text-dark-turquoise border-gray-300 rounded focus:ring-dark-turquoise">
                <span class="ml-2 text-sm text-gray-700">Provincia activa</span>
            </label>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-dark-turquoise hover:bg-dark-turquoise-alt text-white px-6 py-3 rounded-lg font-semibold">
                Actualizar
            </button>
            <a href="{{ route('admin.provinces.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-lg font-semibold">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
