@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-dark-turquoise mb-2">Editar SEO: {{ $seo->page }}</h1>
        <p class="text-gray-600">Actualiza los meta tags para esta página</p>
    </div>

    <form action="{{ route('admin.seo.update', $seo) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-lg p-6">
        @csrf
        @method('PUT')

        <!-- Meta Tags Section -->
        <div class="mb-8">
            <h2 class="text-xl font-bold text-dark-turquoise mb-4">Meta Tags Básicos</h2>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Meta Title</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title', $seo->meta_title) }}" maxlength="255"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                        placeholder="Título que aparecerá en los resultados de búsqueda">
                    <p class="text-xs text-gray-500 mt-1">Recomendado: 50-60 caracteres</p>
                    @error('meta_title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Meta Description</label>
                    <textarea name="meta_description" rows="3" maxlength="500"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                        placeholder="Descripción que aparecerá en los resultados de búsqueda">{{ old('meta_description', $seo->meta_description) }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Recomendado: 150-160 caracteres</p>
                    @error('meta_description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Meta Keywords</label>
                    <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $seo->meta_keywords) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                        placeholder="palabra1, palabra2, palabra3">
                    <p class="text-xs text-gray-500 mt-1">Separadas por comas</p>
                    @error('meta_keywords')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Open Graph Section -->
        <div class="mb-8">
            <h2 class="text-xl font-bold text-dark-turquoise mb-4">Open Graph (Facebook, LinkedIn, WhatsApp)</h2>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">OG Title</label>
                    <input type="text" name="og_title" value="{{ old('og_title', $seo->og_title) }}" maxlength="255"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                        placeholder="Deja vacío para usar Meta Title">
                    @error('og_title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">OG Description</label>
                    <textarea name="og_description" rows="3" maxlength="500"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                        placeholder="Deja vacío para usar Meta Description">{{ old('og_description', $seo->og_description) }}</textarea>
                    @error('og_description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">OG Image</label>
                    @if($seo->og_image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $seo->og_image) }}" alt="OG Image" class="h-32 rounded border">
                            <p class="text-xs text-gray-500 mt-1">Imagen actual</p>
                        </div>
                    @endif
                    <input type="file" name="og_image" accept="image/*"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Recomendado: 1200x630px (Max 2MB). Deja vacío para mantener la imagen actual.</p>
                    @error('og_image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">OG Type</label>
                    <select name="og_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent">
                        <option value="website" {{ old('og_type', $seo->og_type) == 'website' ? 'selected' : '' }}>Website</option>
                        <option value="article" {{ old('og_type', $seo->og_type) == 'article' ? 'selected' : '' }}>Article</option>
                        <option value="product" {{ old('og_type', $seo->og_type) == 'product' ? 'selected' : '' }}>Product</option>
                    </select>
                    @error('og_type')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Twitter Card Section -->
        <div class="mb-8">
            <h2 class="text-xl font-bold text-dark-turquoise mb-4">Twitter Card</h2>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Twitter Card Type</label>
                    <select name="twitter_card" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent">
                        <option value="summary_large_image" {{ old('twitter_card', $seo->twitter_card) == 'summary_large_image' ? 'selected' : '' }}>Summary Large Image</option>
                        <option value="summary" {{ old('twitter_card', $seo->twitter_card) == 'summary' ? 'selected' : '' }}>Summary</option>
                    </select>
                    @error('twitter_card')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Twitter Title</label>
                    <input type="text" name="twitter_title" value="{{ old('twitter_title', $seo->twitter_title) }}" maxlength="255"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                        placeholder="Deja vacío para usar Meta Title">
                    @error('twitter_title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Twitter Description</label>
                    <textarea name="twitter_description" rows="3" maxlength="500"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                        placeholder="Deja vacío para usar Meta Description">{{ old('twitter_description', $seo->twitter_description) }}</textarea>
                    @error('twitter_description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Twitter Image</label>
                    @if($seo->twitter_image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $seo->twitter_image) }}" alt="Twitter Image" class="h-32 rounded border">
                            <p class="text-xs text-gray-500 mt-1">Imagen actual</p>
                        </div>
                    @endif
                    <input type="file" name="twitter_image" accept="image/*"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Recomendado: 1200x675px (Max 2MB). Deja vacío para mantener la imagen actual.</p>
                    @error('twitter_image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Advanced Settings -->
        <div class="mb-8">
            <h2 class="text-xl font-bold text-dark-turquoise mb-4">Configuración Avanzada</h2>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Canonical URL</label>
                    <input type="url" name="canonical_url" value="{{ old('canonical_url', $seo->canonical_url) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                        placeholder="https://imanimagnets.com/pagina">
                    <p class="text-xs text-gray-500 mt-1">Deja vacío para usar la URL actual</p>
                    @error('canonical_url')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center space-x-6">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="index" value="1" {{ old('index', $seo->index) ? 'checked' : '' }}
                            class="w-4 h-4 text-dark-turquoise border-gray-300 rounded focus:ring-dark-turquoise">
                        <span class="ml-2 text-sm font-semibold text-gray-700">Indexar (Permitir en Google)</span>
                    </label>

                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="follow" value="1" {{ old('follow', $seo->follow) ? 'checked' : '' }}
                            class="w-4 h-4 text-dark-turquoise border-gray-300 rounded focus:ring-dark-turquoise">
                        <span class="ml-2 text-sm font-semibold text-gray-700">Seguir Enlaces</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-4">
            <a href="{{ route('admin.seo.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-50">
                Cancelar
            </a>
            <button type="submit" class="bg-dark-turquoise hover:bg-dark-turquoise-alt text-white px-6 py-3 rounded-lg font-semibold">
                Actualizar Configuración SEO
            </button>
        </div>
    </form>
</div>
@endsection
