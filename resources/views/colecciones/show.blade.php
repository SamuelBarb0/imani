@extends('layouts.app')

@section('content')
<section class="bg-white py-8 md:py-12">
    <div class="container mx-auto px-4 max-w-6xl">

        <!-- Breadcrumb -->
        <nav class="mb-6">
            <a href="{{ route('colecciones') }}" class="text-dark-turquoise hover:underline text-sm">← Volver a Colecciones</a>
        </nav>

        <!-- Contenido Principal -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">

            <!-- Galería de Imágenes -->
            <div class="space-y-4">
                <!-- Imagen Principal Grande -->
                <div class="w-full overflow-hidden rounded-lg shadow-lg" style="aspect-ratio: 1/1; max-width: 100%;">
                    <img
                        id="mainImage"
                        src="{{ asset($collection->image) }}"
                        alt="{{ $collection->name }}"
                        class="w-full h-full object-cover cursor-pointer"
                        onclick="openLightbox()"
                    >
                </div>

                <!-- Miniaturas de la Galería -->
                @if($collection->gallery && count($collection->gallery) > 0)
                    <div class="grid grid-cols-4 gap-2">
                        <!-- Imagen principal como miniatura -->
                        <div class="aspect-square overflow-hidden rounded-md border-2 border-dark-turquoise cursor-pointer hover:opacity-75 transition" onclick="changeMainImage({{ json_encode($collection->image) }})">
                            <img src="{{ asset($collection->image) }}" alt="Principal" class="w-full h-full object-cover">
                        </div>

                        <!-- Imágenes de la galería -->
                        @foreach($collection->gallery as $galleryImage)
                            <div class="aspect-square overflow-hidden rounded-md border-2 border-gray-300 cursor-pointer hover:border-dark-turquoise hover:opacity-75 transition" onclick="changeMainImage({{ json_encode($galleryImage) }})">
                                <img src="{{ asset($galleryImage) }}" alt="Galería {{ $loop->iteration }}" class="w-full h-full object-cover">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Información del Producto -->
            <div class="space-y-6">
                <div>
                    <h1 class="font-spartan text-3xl md:text-4xl font-bold text-dark-turquoise mb-3 uppercase">
                        {!! nl2br($collection->name) !!}
                    </h1>

                    @if($collection->description)
                        <p class="text-gray-brown text-lg leading-relaxed mb-4">
                            {{ $collection->description }}
                        </p>
                    @endif
                </div>

                <!-- Contenido de la Colección -->
                @if($collection->items && count($collection->items) > 0)
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="font-spartan text-xl font-bold text-dark-turquoise mb-4">Incluye:</h3>
                        <ul class="space-y-2">
                            @foreach($collection->items as $item)
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-dark-turquoise mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-gray-brown">{{ $item }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Precio y Compra -->
                <div class="border-t-2 border-dark-turquoise pt-6">
                    <div class="mb-6">
                        <p class="font-spartan text-4xl font-bold text-dark-turquoise">
                            {{ number_format($collection->price, 2) }} USD
                        </p>
                        <p class="text-sm text-gray-500 italic mt-2 whitespace-pre-line">{!! $content->get('collections.shipping_note') !!}</p>
                    </div>

                    <!-- Cantidad -->
                    <div class="mb-6">
                        <label for="cantidad" class="block text-sm font-medium text-gray-brown mb-3">
                            {{ $content->get('collections.quantity_label') }}
                        </label>
                        <div class="flex items-center space-x-4">
                            <div class="flex border-2 border-gray-300 rounded-lg overflow-hidden">
                                <button
                                    type="button"
                                    onclick="decreaseQuantity()"
                                    class="px-6 py-3 bg-gray-100 text-gray-brown hover:bg-gray-200 transition font-bold text-lg"
                                >
                                    -
                                </button>
                                <input
                                    type="number"
                                    id="cantidad"
                                    value="1"
                                    min="1"
                                    class="w-20 text-center border-0 focus:ring-0 text-lg font-semibold"
                                    readonly
                                >
                                <button
                                    type="button"
                                    onclick="increaseQuantity()"
                                    class="px-6 py-3 bg-gray-100 text-gray-brown hover:bg-gray-200 transition font-bold text-lg"
                                >
                                    +
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Botón Agregar al Carrito -->
                    <button
                        type="button"
                        onclick="addToCart()"
                        class="w-full btn-primary px-8 py-4 bg-gray-orange hover:bg-[#a89980] text-white rounded-lg font-spartan font-semibold text-base tracking-wider uppercase transition shadow-lg hover:shadow-xl"
                    >
                        {{ $content->get('collections.button_text') }}
                    </button>
                </div>

            </div>
        </div>

        <!-- Otras Colecciones -->
        <div class="border-t border-gray-200 pt-12">
            <h2 class="font-spartan text-2xl md:text-3xl font-bold text-dark-turquoise mb-8">
                OTRAS COLECCIONES 
            </h2>

            <div class="grid md:grid-cols-3 gap-6">
                @foreach(App\Models\Collection::active()->where('id', '!=', $collection->id)->take(3)->get() as $otherCollection)
                    <a href="{{ route('colecciones.show', $otherCollection) }}" class="group">
                        <div class="bg-white rounded-md p-4 shadow-sm hover:shadow-md transition">
                            <div class="w-full overflow-hidden rounded-md mb-3" style="aspect-ratio: 1/1;">
                                <img
                                    src="{{ asset($otherCollection->image) }}"
                                    alt="{{ $otherCollection->name }}"
                                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                                >
                            </div>
                            <h3 class="text-lg font-bold text-dark-turquoise mb-2 uppercase group-hover:text-gray-orange transition">
                                {!! nl2br($otherCollection->name) !!}
                            </h3>
                            <p class="font-bold text-dark-turquoise">
                                ${{ number_format($otherCollection->price, 2) }} USD
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
function increaseQuantity() {
    const input = document.getElementById('cantidad');
    input.value = parseInt(input.value) + 1;
}

function decreaseQuantity() {
    const input = document.getElementById('cantidad');
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

function addToCart() {
    const quantity = parseInt(document.getElementById('cantidad').value);
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
            product_id: 'collection-{{ $collection->id }}',
            quantity: quantity,
            price: {{ $collection->price }},
            custom_data: {
                type: 'collection',
                name: {!! json_encode(strip_tags($collection->name)) !!}
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
                document.getElementById('cantidad').value = 1;
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

// Gallery functions
function changeMainImage(imagePath) {
    const mainImage = document.getElementById('mainImage');
    mainImage.src = '{{ asset('') }}' + imagePath;

    // Update border on thumbnails
    document.querySelectorAll('[onclick^="changeMainImage"]').forEach(thumb => {
        thumb.classList.remove('border-dark-turquoise');
        thumb.classList.add('border-gray-300');
    });
    event.currentTarget.classList.remove('border-gray-300');
    event.currentTarget.classList.add('border-dark-turquoise');
}

function openLightbox() {
    // Get the current main image source
    const mainImage = document.getElementById('mainImage');
    const currentSrc = mainImage.src;

    // Create lightbox overlay
    const lightbox = document.createElement('div');
    lightbox.id = 'lightbox';
    lightbox.className = 'fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center p-4';
    lightbox.onclick = function() { document.body.removeChild(lightbox); };

    const img = document.createElement('img');
    img.src = currentSrc;
    img.className = 'max-w-full max-h-full object-contain';
    img.onclick = function(e) { e.stopPropagation(); };

    const closeBtn = document.createElement('button');
    closeBtn.innerHTML = '×';
    closeBtn.className = 'absolute top-4 right-4 text-white text-5xl font-bold hover:text-gray-300';
    closeBtn.onclick = function() { document.body.removeChild(lightbox); };

    lightbox.appendChild(img);
    lightbox.appendChild(closeBtn);
    document.body.appendChild(lightbox);
}
</script>
@endpush

@endsection
