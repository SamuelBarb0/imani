@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-dark-turquoise">Editar Mensaje de Checkout</h1>
        <a href="{{ route('admin.checkout-messages.index') }}" class="px-4 py-2 bg-gray-200 text-gray-brown rounded-lg font-semibold text-sm hover:bg-gray-300">
            ← Volver a Mensajes
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.checkout-messages.update', $message->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Identificador (key)</label>
                <input type="text" value="{{ $message->key }}" disabled class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" placeholder="No se puede modificar">
                <p class="text-xs text-gray-500 mt-1">El identificador no se puede modificar después de crear el mensaje.</p>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tipo</label>
                <select name="type" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent">
                    <option value="info" {{ $message->type === 'info' ? 'selected' : '' }}>Info (azul)</option>
                    <option value="warning" {{ $message->type === 'warning' ? 'selected' : '' }}>Warning (amarillo)</option>
                    <option value="vacation" {{ $message->type === 'vacation' ? 'selected' : '' }}>Vacaciones (naranja)</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Contenido del Mensaje</label>
                <textarea name="content" rows="8" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent">{{ $message->content }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Puedes usar saltos de línea. El texto se mostrará tal cual lo escribas.</p>
                @error('content')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ $message->is_active ? 'checked' : '' }} class="rounded border-gray-300 text-dark-turquoise focus:ring-dark-turquoise">
                    <span class="ml-2 text-sm text-gray-700">Activar este mensaje (desactivará los demás automáticamente)</span>
                </label>
            </div>

            <!-- Preview -->
            <div class="mb-6 p-4 border-2 border-dashed border-gray-300 rounded-lg">
                <p class="text-sm font-semibold text-gray-700 mb-2">Vista Previa:</p>
                <div class="rounded-lg p-4
                    @if($message->type === 'info') bg-blue-50 border-l-4 border-blue-500
                    @elseif($message->type === 'warning') bg-yellow-50 border-l-4 border-yellow-500
                    @elseif($message->type === 'vacation') bg-orange-50 border-l-4 border-orange-500
                    @endif">
                    <p class="text-sm whitespace-pre-line">{{ $message->content }}</p>
                </div>
                <p class="text-xs text-gray-500 mt-2">Así se verá el mensaje en el checkout.</p>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-dark-turquoise hover:bg-dark-turquoise-alt text-white px-6 py-2 rounded-lg font-semibold">
                    Guardar Cambios
                </button>
                <a href="{{ route('admin.checkout-messages.index') }}" class="px-6 py-2 bg-gray-200 text-gray-brown rounded-lg font-semibold hover:bg-gray-300">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
