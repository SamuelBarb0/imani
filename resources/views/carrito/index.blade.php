@extends('layouts.app')

@section('title', 'Carrito de Compras - Imani Magnets')

@section('content')

<!-- Hero Section -->
<section class="bg-white py-4">
    <div class="container mx-auto px-6 max-w-6xl text-center">
        <h1 class="font-spartan text-2xl lg:text-3xl font-bold text-dark-turquoise mb-2">
            CARRITO DE COMPRAS
        </h1>
        <p class="text-sm text-gray-brown">
            Revisa tus productos antes de continuar
        </p>
    </div>
</section>

<!-- Cart Section -->
<section class="bg-gray-50 py-8">
    <div class="container mx-auto px-6 max-w-6xl">

        @if($items->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Cart Items -->
                <div class="lg:col-span-2 space-y-4">
                    @foreach($items as $item)
                        <div class="bg-white rounded-lg shadow-md p-4" data-item-id="{{ $item->id }}">
                            <div class="flex gap-4">

                                <!-- Product Image Preview -->
                                <div class="w-24 h-24 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0 overflow-hidden">
                                    @if($item->product_id === 'custom-magnets-9' && isset($item->custom_data['images'][0]['path']))
                                        <img src="{{ asset('storage/' . $item->custom_data['images'][0]['path']) }}" alt="Vista previa" class="w-full h-full object-cover rounded-lg">
                                    @elseif($item->getProductImage())
                                        <img src="{{ asset($item->getProductImage()) }}" alt="{{ $item->getProductName() }}" class="w-full h-full object-cover rounded-lg">
                                    @else
                                        <svg class="w-12 h-12 text-gray-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    @endif
                                </div>

                                <!-- Product Info -->
                                <div class="flex-grow">
                                    <h3 class="font-spartan text-base font-semibold text-dark-turquoise mb-1">
                                        {!! preg_replace('/<span[^>]*>.*?<\/span>/i', '', nl2br($item->getProductName())) !!}
                                    </h3>

                                    @if($item->product_id === 'custom-magnets-9')
                                        <p class="text-xs text-gray-brown mb-2">
                                            9 imanes personalizados 2x2"
                                        </p>
                                    @elseif(str_starts_with($item->product_id, 'collection-'))
                                        <p class="text-xs text-gray-brown mb-2">
                                            Set de 6 imanes
                                        </p>
                                    @endif

                                    <!-- Quantity and Price -->
                                    <div class="flex items-center gap-4 mt-3">
                                        <!-- Quantity Controls -->
                                        <div class="flex items-center gap-2">
                                            <button onclick="updateQuantity({{ $item->id }}, -1)" class="w-8 h-8 rounded-full bg-gray-200 hover:bg-gray-orange hover:text-white transition-colors flex items-center justify-center">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                </svg>
                                            </button>
                                            <span class="text-sm font-semibold w-8 text-center quantity-display">{{ $item->quantity }}</span>
                                            <button onclick="updateQuantity({{ $item->id }}, 1)" class="w-8 h-8 rounded-full bg-gray-200 hover:bg-gray-orange hover:text-white transition-colors flex items-center justify-center">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                </svg>
                                            </button>
                                        </div>

                                        <!-- Price -->
                                        <div class="flex-grow text-right">
                                            <p class="text-sm text-gray-brown">Subtotal:</p>
                                            <p class="font-spartan text-lg font-bold text-dark-turquoise subtotal-display">
                                                ${{ number_format($item->getSubtotal(), 2) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Remove Button -->
                                <button onclick="removeItem({{ $item->id }})" class="text-gray-400 hover:text-red-500 transition-colors self-start">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                        <h2 class="font-spartan text-xl font-bold text-dark-turquoise mb-4">
                            RESUMEN DEL PEDIDO
                        </h2>

                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-brown">Subtotal:</span>
                                <span class="font-semibold" id="cart-subtotal">${{ number_format($total, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-brown">Envío:</span>
                                <span class="font-semibold">A calcular</span>
                            </div>
                            <div class="border-t border-gray-200 pt-3 flex justify-between">
                                <span class="font-spartan font-bold text-dark-turquoise">Total:</span>
                                <span class="font-spartan text-xl font-bold text-dark-turquoise" id="cart-total">${{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <a href="{{ route('checkout.index') }}" class="btn-primary inline-block w-full px-6 py-3 bg-gray-orange hover:bg-gray-brown text-white text-center rounded-full font-spartan font-semibold text-sm tracking-wider uppercase mb-3">
                            PROCEDER AL PAGO
                        </a>

                        <a href="{{ route('home') }}" class="block text-center text-sm text-gray-brown hover:text-dark-turquoise transition-colors">
                            ← Seguir comprando
                        </a>
                    </div>
                </div>

            </div>
        @else
            <!-- Empty Cart -->
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <h2 class="font-spartan text-2xl font-bold text-dark-turquoise mb-2">
                    TU CARRITO ESTÁ VACÍO
                </h2>
                <p class="text-gray-brown mb-6">
                    Agrega productos para comenzar tu pedido
                </p>
                <a href="{{ route('personalizados.index') }}" class="inline-block px-8 py-3 bg-gray-orange text-white rounded-full font-spartan font-semibold text-sm tracking-wider uppercase hover:bg-gray-brown transition-all duration-300">
                    CREAR IMANES PERSONALIZADOS
                </a>
            </div>
        @endif

    </div>
</section>

@endsection

@push('scripts')
<script>
    // Update item quantity
    async function updateQuantity(itemId, change) {
        const itemElement = document.querySelector(`[data-item-id="${itemId}"]`);
        const quantityDisplay = itemElement.querySelector('.quantity-display');
        let currentQuantity = parseInt(quantityDisplay.textContent);
        let newQuantity = currentQuantity + change;

        // Don't allow quantity below 1
        if (newQuantity < 1) {
            if (confirm('¿Deseas eliminar este producto del carrito?')) {
                removeItem(itemId);
            }
            return;
        }

        try {
            const response = await fetch(`{{ url('/carrito/items') }}/${itemId}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ quantity: newQuantity })
            });

            const data = await response.json();

            if (data.success) {
                quantityDisplay.textContent = newQuantity;
                itemElement.querySelector('.subtotal-display').textContent = `$${parseFloat(data.subtotal).toFixed(2)}`;
                document.getElementById('cart-subtotal').textContent = `$${parseFloat(data.total).toFixed(2)}`;
                document.getElementById('cart-total').textContent = `$${parseFloat(data.total).toFixed(2)}`;
            }
        } catch (error) {
            console.error('Error updating quantity:', error);
            alert('Error al actualizar la cantidad. Por favor intenta de nuevo.');
        }
    }

    // Remove item from cart
    async function removeItem(itemId) {
        if (!confirm('¿Estás seguro de eliminar este producto?')) {
            return;
        }

        try {
            const response = await fetch(`{{ url('/carrito/items') }}/${itemId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            const data = await response.json();

            if (data.success) {
                const itemElement = document.querySelector(`[data-item-id="${itemId}"]`);
                itemElement.remove();

                // Update totals
                document.getElementById('cart-subtotal').textContent = `$${parseFloat(data.total).toFixed(2)}`;
                document.getElementById('cart-total').textContent = `$${parseFloat(data.total).toFixed(2)}`;

                // Reload if cart is empty
                if (data.totalItems === 0) {
                    location.reload();
                }
            }
        } catch (error) {
            console.error('Error removing item:', error);
            alert('Error al eliminar el producto. Por favor intenta de nuevo.');
        }
    }

</script>
@endpush
