@extends('layouts.app')

@section('content')
<section class="bg-white py-12 md:py-16  leading-relaxed">
    <div class="container mx-auto px-6 max-w-6xl">
        <!-- Encabezado -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-start mb-12">
            <div>
                <h1 class="text-2xl md:text-3xl lg:text-4xl font-spartan font-bold text-dark-turquoise leading-none">
                    {!! $content->get('header.title') !!}
                </h1>
                <p class="text-xl md:text-xl font-spartan font-semibold text-dark-turquoise mb-4">
                    {{ $content->get('header.subtitle') }}
                </p>
                <p class="text-sm text-gray-brown mb-4">
                    {{ $content->get('header.intro_1') }}
                </p>
                <p class="text-sm text-gray-brown mb-4">
                    {{ $content->get('header.intro_2') }}
                </p>
                <p class="text-sm text-gray-brown">
                    {!! $content->get('header.size_info') !!}
                </p>
            </div>

            <div class="flex justify-center h-[380px] md:h-[380px] overflow-hidden rounded-lg shadow-lg">
                <img
                    src="{{ asset($content->get('header.main_image')) }}"
                    alt="Colecciones de imanes"
                    class="h-full w-auto object-cover"
                >
            </div>
        </div>

        <!-- Nuestras Colecciones -->
        <h2 class="font-spartan text-3xl md:text-4xl font-bold text-dark-turquoise mb-10 tracking-wide">
            {{ $content->get('collections.section_title') }}
        </h2>

        <div class="grid md:grid-cols-3 gap-6">
            @forelse($collections as $collection)
                <div class="group bg-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden flex flex-col border-2 border-transparent hover:border-dark-turquoise hover:scale-105">
                    <!-- Imagen del producto -->
                    <a href="{{ route('colecciones.show', $collection) }}" class="block w-full overflow-hidden max-h-[250px]">
                        <img src="{{ asset($collection->image) }}" alt="{{ $collection->name }}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                    </a>

                    <!-- Contenido de la tarjeta -->
                    <div class="px-6 py-7 flex flex-col flex-grow text-left min-h-[360px]">
                        <!-- Título de la colección -->
                        <a href="{{ route('colecciones.show', $collection) }}" class="block mb-2">
                            <h3 class="text-2xl font-spartan font-bold text-dark-turquoise uppercase group-hover:text-gray-orange transition">
                                {!! nl2br($collection->name) !!}
                            </h3>
                        </a>

                        <!-- Subtítulo con información del set -->
                        @if($collection->subtitle)
                            <p class="text-sm font-spartan font-semibold text-dark-turquoise mb-5">({{ $collection->subtitle }})</p>
                        @endif

                        <!-- Descripción -->
                        @if($collection->description)
                            <p class="text-gray-brown text-[15px] mb-7 leading-relaxed flex-grow">
                                {{ $collection->description }}
                            </p>
                        @endif

                        <!-- Precio -->
                        <div class="mb-5 text-right">
                            <p class="font-spartan font-bold text-dark-turquoise text-xl">
                                {{ number_format($collection->price, 2) }} USD
                            </p>
                        </div>

                        <!-- Botón de agregar al carrito -->
                        <button
                            type="button"
                            onclick="addToCart({{ $collection->id }}, {{ json_encode($collection->name) }}, {{ $collection->price }})"
                            class="w-full px-6 py-3.5 bg-[#c2b59b] group-hover:bg-[#b0a489] text-white rounded-full font-spartan font-semibold text-[15px] tracking-wide uppercase transition-all duration-300 shadow-sm hover:shadow-md"
                        >
                            {{ $content->get('collections.button_text') }}
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12">
                    <p class="text-gray-500 text-lg">No hay colecciones disponibles en este momento.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

@push('scripts')
<script>
function addToCart(collectionId, collectionName, price) {
    const button = event.target;
    const quantity = 1; // Cantidad fija de 1

    // Disable button and show loading
    button.disabled = true;
    const originalText = button.textContent;
    button.textContent = 'Agregando...';

    fetch('{{ route("carrito.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            product_id: 'collection-' + collectionId,
            quantity: quantity,
            price: price,
            custom_data: {
                type: 'collection',
                name: collectionName
            }
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            button.textContent = '¡Agregado!';
            button.classList.remove('bg-[#c2b59b]', 'hover:bg-[#b0a489]');
            button.classList.add('bg-green-600');

            // Update cart counter if exists
            const cartCounter = document.querySelector('[data-cart-count]');
            if (cartCounter) {
                cartCounter.textContent = data.cart_total;
                cartCounter.classList.remove('hidden');
            }

            // Reset button after 2 seconds
            setTimeout(() => {
                button.textContent = originalText;
                button.classList.remove('bg-green-600');
                button.classList.add('bg-[#c2b59b]', 'hover:bg-[#b0a489]');
                button.disabled = false;
            }, 2000);
        } else {
            throw new Error(data.message || 'Error al agregar al carrito');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        button.textContent = 'Error';
        button.classList.add('bg-red-600');

        setTimeout(() => {
            button.textContent = originalText;
            button.classList.remove('bg-red-600');
            button.disabled = false;
        }, 2000);
    });
}
</script>
@endpush

@endsection
