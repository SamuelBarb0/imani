@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-dark-turquoise mb-2">Gestión de Contenido</h1>
        <p class="text-gray-600">Edita el contenido de las páginas del sitio web</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Home Page -->
        <a href="{{ route('admin.content.edit', 'home') }}" class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow p-6 border-l-4 border-blue-500">
            <div class="flex items-center mb-3">
                <svg class="w-8 h-8 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <div>
                    <h3 class="font-spartan text-lg font-bold text-dark-turquoise">Página Principal</h3>
                    <p class="text-xs text-gray-500">Home</p>
                </div>
            </div>
            <p class="text-sm text-gray-600">Hero, secciones, llamados a la acción</p>
        </a>

        <!-- Personalizados Page -->
        <a href="{{ route('admin.content.edit', 'personalizados') }}" class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow p-6 border-l-4 border-purple-500">
            <div class="flex items-center mb-3">
                <svg class="w-8 h-8 text-purple-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                </svg>
                <div>
                    <h3 class="font-spartan text-lg font-bold text-dark-turquoise">Personalizados</h3>
                    <p class="text-xs text-gray-500">Personalizados</p>
                </div>
            </div>
            <p class="text-sm text-gray-600">Contenido de imanes personalizados</p>
        </a>

        <!-- Colecciones Page -->
        <a href="{{ route('admin.content.edit', 'colecciones') }}" class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow p-6 border-l-4 border-green-500">
            <div class="flex items-center mb-3">
                <svg class="w-8 h-8 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                <div>
                    <h3 class="font-spartan text-lg font-bold text-dark-turquoise">Colecciones</h3>
                    <p class="text-xs text-gray-500">Colecciones</p>
                </div>
            </div>
            <p class="text-sm text-gray-600">Contenido de colecciones de imanes</p>
        </a>

        <!-- Mayoristas Page -->
        <a href="{{ route('admin.content.edit', 'mayoristas') }}" class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow p-6 border-l-4 border-yellow-500">
            <div class="flex items-center mb-3">
                <svg class="w-8 h-8 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <div>
                    <h3 class="font-spartan text-lg font-bold text-dark-turquoise">Mayoristas</h3>
                    <p class="text-xs text-gray-500">Mayoristas</p>
                </div>
            </div>
            <p class="text-sm text-gray-600">Información para compras al por mayor</p>
        </a>

        <!-- Gift Card Page -->
        <a href="{{ route('admin.content.edit', 'gift-card') }}" class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow p-6 border-l-4 border-pink-500">
            <div class="flex items-center mb-3">
                <svg class="w-8 h-8 text-pink-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                </svg>
                <div>
                    <h3 class="font-spartan text-lg font-bold text-dark-turquoise">Gift Card</h3>
                    <p class="text-xs text-gray-500">Gift Card</p>
                </div>
            </div>
            <p class="text-sm text-gray-600">Contenido de tarjetas de regalo</p>
        </a>

        <!-- Contacto Page -->
        <a href="{{ route('admin.content.edit', 'contacto') }}" class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow p-6 border-l-4 border-indigo-500">
            <div class="flex items-center mb-3">
                <svg class="w-8 h-8 text-indigo-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <div>
                    <h3 class="font-spartan text-lg font-bold text-dark-turquoise">Contacto</h3>
                    <p class="text-xs text-gray-500">Contacto</p>
                </div>
            </div>
            <p class="text-sm text-gray-600">Información de contacto y formulario</p>
        </a>

        <!-- Configuración del Sitio -->
        <a href="{{ route('admin.settings.edit') }}" class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow p-6 border-l-4 border-red-500">
            <div class="flex items-center mb-3">
                <svg class="w-8 h-8 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <div>
                    <h3 class="font-spartan text-lg font-bold text-dark-turquoise">Configuración</h3>
                    <p class="text-xs text-gray-500">Settings</p>
                </div>
            </div>
            <p class="text-sm text-gray-600">WhatsApp, Email, Redes Sociales</p>
        </a>
    </div>

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
                    Haz clic en cualquier página para editar su contenido. Los cambios se guardarán automáticamente.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
