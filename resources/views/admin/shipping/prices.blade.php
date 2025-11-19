@extends('layouts.app')

@section('title', 'Códigos de Precio - Admin')

@section('content')

<section class="bg-white py-6">
    <div class="container mx-auto px-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="font-spartan text-3xl font-bold text-dark-turquoise mb-2">
                    CÓDIGOS DE PRECIO
                </h1>
                <p class="text-gray-700">Gestiona los códigos y precios de envío</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-200 text-gray-brown rounded-full font-semibold text-sm hover:bg-gray-300">
                ← Volver al Panel
            </a>
        </div>
    </div>
</section>

<section class="bg-gray-50 py-8">
    <div class="container mx-auto px-6">

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Create New Price Code -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-brown mb-4">Crear Nuevo Código de Precio</h2>
            <form action="{{ route('admin.shipping.prices.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="code_name" class="block text-sm font-semibold text-gray-brown mb-2">
                            Código *
                        </label>
                        <input
                            type="text"
                            name="code_name"
                            id="code_name"
                            placeholder="ej: ZONA_A"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                        >
                    </div>
                    <div>
                        <label for="price" class="block text-sm font-semibold text-gray-brown mb-2">
                            Precio (USD) *
                        </label>
                        <input
                            type="number"
                            step="0.01"
                            name="price"
                            id="price"
                            placeholder="ej: 3.50"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                        >
                    </div>
                    <div>
                        <label for="courier_name" class="block text-sm font-semibold text-gray-brown mb-2">
                            Courier (opcional)
                        </label>
                        <input
                            type="text"
                            name="courier_name"
                            id="courier_name"
                            placeholder="ej: Servientrega"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                        >
                    </div>
                    <div class="flex items-end">
                        <button
                            type="submit"
                            class="w-full px-6 py-2 bg-dark-turquoise hover:bg-dark-turquoise-alt text-white rounded-lg font-semibold"
                        >
                            Crear Código
                        </button>
                    </div>
                </div>
                <div class="mt-4">
                    <label for="description" class="block text-sm font-semibold text-gray-brown mb-2">
                        Descripción (opcional)
                    </label>
                    <textarea
                        name="description"
                        id="description"
                        rows="2"
                        placeholder="Descripción del código..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                    ></textarea>
                </div>
            </form>
        </div>

        <!-- Price Codes List -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold text-gray-brown">Códigos de Precio Existentes</h2>
            </div>

            @if($prices->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Courier</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Zonas Asignadas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($prices as $price)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded font-mono text-sm">
                                            {{ $price->code_name }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="font-semibold text-green-600">${{ number_format($price->price, 2) }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $price->courier_name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-sm">
                                            {{ $price->shipping_zones_count }} zonas
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm text-gray-600">{{ $price->description ?? '-' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button
                                            onclick="editPrice(this)"
                                            data-id="{{ $price->id }}"
                                            data-code-name="{{ $price->code_name }}"
                                            data-price="{{ $price->price }}"
                                            data-courier-name="{{ $price->courier_name ?? '' }}"
                                            data-description="{{ $price->description ?? '' }}"
                                            class="text-blue-600 hover:text-blue-800 mr-3"
                                        >
                                            Editar
                                        </button>
                                        <form action="{{ route('admin.shipping.prices.destroy', $price) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este código de precio?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-6 text-center text-gray-500">
                    No hay códigos de precio creados aún.
                </div>
            @endif
        </div>

        <!-- Quick Link to Zones -->
        <div class="mt-6 text-center">
            <a href="{{ route('admin.shipping.zones') }}" class="inline-block px-6 py-3 bg-dark-turquoise hover:bg-dark-turquoise-alt text-white rounded-lg font-semibold">
                Ir a Gestión de Zonas →
            </a>
        </div>

    </div>
</section>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 p-6">
        <h3 class="text-xl font-semibold text-gray-brown mb-4">Editar Código de Precio</h3>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="edit_code_name" class="block text-sm font-semibold text-gray-brown mb-2">
                        Código *
                    </label>
                    <input
                        type="text"
                        name="code_name"
                        id="edit_code_name"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                    >
                </div>
                <div>
                    <label for="edit_price" class="block text-sm font-semibold text-gray-brown mb-2">
                        Precio (USD) *
                    </label>
                    <input
                        type="number"
                        step="0.01"
                        name="price"
                        id="edit_price"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                    >
                </div>
            </div>
            <div class="mb-4">
                <label for="edit_courier_name" class="block text-sm font-semibold text-gray-brown mb-2">
                    Courier (opcional)
                </label>
                <input
                    type="text"
                    name="courier_name"
                    id="edit_courier_name"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                >
            </div>
            <div class="mb-4">
                <label for="edit_description" class="block text-sm font-semibold text-gray-brown mb-2">
                    Descripción (opcional)
                </label>
                <textarea
                    name="description"
                    id="edit_description"
                    rows="2"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                ></textarea>
            </div>
            <div class="flex gap-4">
                <button
                    type="submit"
                    class="px-6 py-2 bg-dark-turquoise hover:bg-dark-turquoise-alt text-white rounded-lg font-semibold"
                >
                    Actualizar
                </button>
                <button
                    type="button"
                    onclick="closeEditModal()"
                    class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-brown rounded-lg font-semibold"
                >
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function editPrice(button) {
    const id = button.getAttribute('data-id');
    const code_name = button.getAttribute('data-code-name');
    const price = button.getAttribute('data-price');
    const courier_name = button.getAttribute('data-courier-name');
    const description = button.getAttribute('data-description');

    document.getElementById('editForm').action = `{{ url('/admin/shipping/prices') }}/${id}`;
    document.getElementById('edit_code_name').value = code_name;
    document.getElementById('edit_price').value = price;
    document.getElementById('edit_courier_name').value = courier_name || '';
    document.getElementById('edit_description').value = description || '';
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editModal').classList.add('flex');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
    document.getElementById('editModal').classList.remove('flex');
}

// Close modal on background click
document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditModal();
    }
});
</script>

@endsection
