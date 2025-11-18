@extends('layouts.app')

@section('title', $page->title . ' - Imani Magnets')

@section('content')
<section class="bg-white py-12 md:py-16">
    <div class="container mx-auto px-6 max-w-4xl text-gray-800 leading-relaxed">

        <!-- Título -->
        <h1 class="text-3xl md:text-4xl font-spartan font-bold text-dark-turquoise mb-4">
            {{ strtoupper($page->title) }}
        </h1>

        <p class="italic text-gray-600 mb-10">
            Última actualización: {{ $page->updated_at->format('F Y') }}
        </p>

        <!-- Contenido HTML editable -->
        <div class="space-y-8 text-[17px] policy-content">
            {!! $page->content !!}
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    /* Estilos para el contenido editable de políticas */
    .policy-content h2 {
        font-weight: 600;
        color: #12463c;
        margin-bottom: 0.5rem;
        font-size: 17px;
    }

    .policy-content h3 {
        font-weight: 600;
        color: #12463c;
        margin-bottom: 0.5rem;
        margin-top: 1.5rem;
    }

    .policy-content p {
        margin-bottom: 1rem;
        line-height: 1.75;
    }

    .policy-content ul {
        list-style-type: disc;
        list-style-position: inside;
        margin-bottom: 1rem;
    }

    .policy-content ul li {
        margin-bottom: 0.25rem;
    }

    .policy-content ol {
        list-style-type: decimal;
        list-style-position: inside;
        margin-bottom: 1rem;
    }

    .policy-content ol li {
        margin-bottom: 0.25rem;
    }

    .policy-content strong {
        font-weight: 600;
    }

    .policy-content a {
        color: #12463c;
        text-decoration: underline;
    }

    .policy-content a:hover {
        color: #003a2f;
    }
</style>
@endpush
