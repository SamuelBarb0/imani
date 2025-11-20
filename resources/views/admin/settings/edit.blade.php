@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8 max-w-4xl">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-dark-turquoise mb-2">Configuración del Sitio</h1>
                <p class="text-gray-600">Edita la información de contacto y redes sociales</p>
            </div>
            <a href="{{ route('admin.content.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Form -->
    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- WhatsApp Section -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center mb-4">
                <svg class="w-8 h-8 text-green-500 mr-3" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                </svg>
                <h2 class="text-xl font-bold text-dark-turquoise">WhatsApp</h2>
            </div>

            <div class="space-y-4">
                <div>
                    <label for="whatsapp_number" class="block text-sm font-semibold text-gray-700 mb-2">
                        Número de WhatsApp
                        <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="whatsapp_number"
                        name="whatsapp_number"
                        value="{{ old('whatsapp_number', $config['whatsapp']['number']) }}"
                        placeholder="+593985959303"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('whatsapp_number') border-red-500 @enderror">
                    @error('whatsapp_number')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Incluye el código de país con + (ejemplo: +593985959303)</p>
                </div>

                <div>
                    <label for="whatsapp_message" class="block text-sm font-semibold text-gray-700 mb-2">
                        Mensaje Predeterminado
                        <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        id="whatsapp_message"
                        name="whatsapp_message"
                        rows="3"
                        required
                        placeholder="Hola Julia, te escribo desde la página web..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('whatsapp_message') border-red-500 @enderror">{{ old('whatsapp_message', $config['whatsapp']['message']) }}</textarea>
                    @error('whatsapp_message')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Este mensaje se enviará automáticamente cuando alguien haga clic en el botón de WhatsApp</p>
                </div>
            </div>
        </div>

        <!-- Email Section -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-indigo-500">
            <div class="flex items-center mb-4">
                <svg class="w-8 h-8 text-indigo-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <h2 class="text-xl font-bold text-dark-turquoise">Email de Contacto</h2>
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                    Email Principal
                    <span class="text-red-500">*</span>
                </label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', $config['email']) }}"
                    placeholder="hello@imanimagnets.com"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-1">Email principal de contacto para el sitio</p>
            </div>
        </div>

        <!-- Social Media Section -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-pink-500">
            <div class="flex items-center mb-4">
                <svg class="w-8 h-8 text-pink-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                </svg>
                <h2 class="text-xl font-bold text-dark-turquoise">Redes Sociales</h2>
            </div>

            <div>
                <label for="instagram" class="block text-sm font-semibold text-gray-700 mb-2">
                    Instagram URL
                    <span class="text-red-500">*</span>
                </label>
                <input
                    type="url"
                    id="instagram"
                    name="instagram"
                    value="{{ old('instagram', $config['social']['instagram']) }}"
                    placeholder="https://instagram.com/imanimagnets"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('instagram') border-red-500 @enderror">
                @error('instagram')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-1">URL completa del perfil de Instagram</p>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex items-center justify-between pt-6 border-t">
            <div class="text-sm text-gray-600">
                <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Los cambios se aplicarán inmediatamente en todo el sitio
            </div>
            <button
                type="submit"
                class="inline-flex items-center px-6 py-3 bg-dark-turquoise hover:bg-[#0f3d35] text-white font-semibold rounded-lg transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Guardar Cambios
            </button>
        </div>
    </form>

    <!-- Info Box -->
    <div class="mt-8 bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-blue-700">
                    <strong>Nota:</strong> Esta configuración se usa en el botón flotante de WhatsApp, footer, emails y todas las páginas del sitio.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
