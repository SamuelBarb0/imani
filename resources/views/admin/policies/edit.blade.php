@extends('layouts.app')

@section('title', 'Editar ' . $page->title)

@push('styles')
<!-- Quill CSS -->
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<style>
    #editor-container {
        height: 400px;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        background: white;
    }
    .ql-editor {
        min-height: 350px;
        font-size: 16px;
    }
</style>
@endpush

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Editar: {{ $page->title }}</h1>
            <a href="{{ route('admin.policies.index') }}" class="text-gray-600 hover:text-gray-900">
                ← Volver al listado
            </a>
        </div>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.policies.update', $page) }}" method="POST" class="bg-white rounded-lg shadow p-6">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Título de la página
                </label>
                <input
                    type="text"
                    name="title"
                    id="title"
                    value="{{ old('title', $page->title) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required
                >
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Slug (URL)
                </label>
                <div class="flex items-center">
                    <span class="text-gray-500 text-sm">{{ url('/') }}/</span>
                    <span class="text-gray-700 text-sm font-medium ml-1">{{ $page->slug }}</span>
                </div>
                <p class="text-xs text-gray-500 mt-1">El slug no se puede cambiar una vez creado</p>
            </div>

            <div class="mb-6">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                    Contenido
                </label>
                <!-- Quill Editor -->
                <div id="editor-container"></div>
                <!-- Hidden textarea to submit content -->
                <textarea
                    name="content"
                    id="content"
                    style="display: none;"
                    required
                >{{ old('content', $page->content) }}</textarea>
            </div>

            <div class="mb-6">
                <label class="flex items-center">
                    <input
                        type="checkbox"
                        name="is_published"
                        value="1"
                        {{ old('is_published', $page->is_published) ? 'checked' : '' }}
                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                    >
                    <span class="ml-2 text-sm text-gray-700">Publicar esta página (visible para el público)</span>
                </label>
            </div>

            <div class="flex justify-between items-center">
                <a href="/{{ $page->slug }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm">
                    Vista previa →
                </a>
                <div class="flex gap-3">
                    <a href="{{ route('admin.policies.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Guardar cambios
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<!-- Quill JS -->
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
    // Initialize Quill editor
    var quill = new Quill('#editor-container', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                [{ 'align': [] }],
                ['link'],
                ['clean']
            ]
        },
        placeholder: 'Escribe el contenido de la política aquí...'
    });

    // Load existing content
    var existingContent = document.getElementById('content').value;
    if (existingContent) {
        quill.root.innerHTML = existingContent;
    }

    // Sync Quill content with hidden textarea on form submit
    var form = document.querySelector('form');
    form.addEventListener('submit', function() {
        document.getElementById('content').value = quill.root.innerHTML;
    });
</script>
@endpush
