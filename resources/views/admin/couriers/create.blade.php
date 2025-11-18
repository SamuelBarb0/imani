@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8 max-w-4xl">
    <div class="mb-6">
        <a href="{{ route('admin.couriers.index') }}" class="text-dark-turquoise hover:underline">&larr; Volver a Couriers</a>
    </div>

    <h1 class="text-3xl font-bold text-dark-turquoise mb-6">Crear Nuevo Courier</h1>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.couriers.store') }}" method="POST" class="bg-white rounded-lg shadow p-6">
        @csrf

        <div class="mb-6">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nombre del Courier *</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                   placeholder="Ej: Servientrega">
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="tracking_url" class="block text-sm font-medium text-gray-700 mb-2">Link de Tracking (opcional)</label>
            <input type="url" name="tracking_url" id="tracking_url" value="{{ old('tracking_url') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                   placeholder="Ej: https://servientrega.com/rastreo">
            <p class="text-xs text-gray-500 mt-1">URL que se enviará a los clientes para rastrear su pedido</p>
            @error('tracking_url')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                       class="w-4 h-4 text-dark-turquoise border-gray-300 rounded focus:ring-dark-turquoise">
                <span class="ml-2 text-sm text-gray-700">Courier activo</span>
            </label>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-dark-turquoise hover:bg-dark-turquoise-alt text-white px-6 py-3 rounded-lg font-semibold">
                Guardar
            </button>
            <a href="{{ route('admin.couriers.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-lg font-semibold">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
