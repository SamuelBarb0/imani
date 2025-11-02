@extends('layouts.app')

@section('content')
<section class="bg-white py-12 md:py-16 text-[17px] md:text-[18px] leading-relaxed">
    <div class="container mx-auto px-6 max-w-6xl">
        <!-- Encabezado -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-start mb-12">
            <div>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-spartan font-bold text-dark-turquoise mb-4 leading-snug">
                    {{ $content->get('header.title') }} <br> <span class="text-xl md:text-xl font-semibold">{{ $content->get('header.subtitle') }}</span>
                </h1>
                <p class="text-gray-700 mb-4">
                    {{ $content->get('header.intro_1') }}
                </p>
                <p class="text-gray-700 mb-4">
                    {{ $content->get('header.intro_2') }}
                </p>
                <p class="text-gray-700">
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

        <div class="grid md:grid-cols-3 gap-8">
            @forelse($collections as $collection)
                <div class="bg-[#F7F6F2] rounded-md p-6 shadow-sm hover:shadow-lg transition text-center flex flex-col group">
                    <!-- Imagen clicable para ver detalle -->
                    <a href="{{ route('colecciones.show', $collection) }}" class="block w-full h-[230px] overflow-hidden rounded-md mb-4">
                        <img src="{{ asset($collection->image) }}" alt="{{ $collection->name }}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                    </a>

                    <!-- Título clicable -->
                    <a href="{{ route('colecciones.show', $collection) }}" class="block">
                        <h3 class="text-xl font-bold text-dark-turquoise mb-3 uppercase group-hover:text-gray-orange transition">{{ $collection->name }}</h3>
                    </a>

                    @if($collection->description)
                        <p class="text-gray-700 text-base mb-3">{{ $collection->description }}</p>
                    @endif

                    @if($collection->items && count($collection->items) > 0)
                        <ul class="text-gray-700 text-base list-disc list-inside mb-4 text-left inline-block">
                            @foreach($collection->items as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    @endif

                    <div class="mt-auto">
                        <p class="font-bold text-dark-turquoise text-lg">{{ number_format($collection->price, 2) }} USD</p>
                        <p class="text-sm text-gray-500 italic mb-5">{{ $content->get('collections.shipping_note') }}</p>

                        <div class="flex items-center justify-center space-x-3 mb-6">
                            <label for="cantidad{{ $collection->id }}" class="text-gray-700 text-sm font-medium">{{ $content->get('collections.quantity_label') }}</label>
                            <div class="flex border border-gray-300 rounded-md overflow-hidden">
                                <button type="button" onclick="decreaseQuantity({{ $collection->id }})" class="px-3 py-1 bg-gray-100 text-gray-700 hover:bg-gray-200 transition">-</button>
                                <input type="number" id="cantidad{{ $collection->id }}" value="1" min="1" class="w-12 text-center border-0 focus:ring-0" readonly>
                                <button type="button" onclick="increaseQuantity({{ $collection->id }})" class="px-3 py-1 bg-gray-100 text-gray-700 hover:bg-gray-200 transition">+</button>
                            </div>
                        </div>

                        <button type="button" onclick="addToCart({{ $collection->id }}, {{ json_encode($collection->name) }}, {{ $collection->price }})" class="btn-primary inline-block px-8 md:px-10 py-3 md:py-4 bg-gray-orange hover:bg-[#a89980] text-white rounded-lg font-spartan font-semibold text-sm md:text-base tracking-wider uppercase transition">
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
function increaseQuantity(collectionId) {
    const input = document.getElementById('cantidad' + collectionId);
    input.value = parseInt(input.value) + 1;
}

function decreaseQuantity(collectionId) {
    const input = document.getElementById('cantidad' + collectionId);
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

function addToCart(collectionId, collectionName, price) {
    const quantity = parseInt(document.getElementById('cantidad' + collectionId).value);
    const button = event.target;

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
            button.classList.remove('bg-gray-orange', 'hover:bg-[#a89980]');
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
                button.classList.add('bg-gray-orange', 'hover:bg-[#a89980]');
                button.disabled = false;

                // Reset quantity to 1
                document.getElementById('cantidad' + collectionId).value = 1;
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
