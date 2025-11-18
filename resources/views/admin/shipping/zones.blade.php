@extends('layouts.app')

@section('title', 'Zonas de Envío - Admin')

@section('content')

<section class="bg-white py-6">
    <div class="container mx-auto px-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="font-spartan text-3xl font-bold text-dark-turquoise mb-2">
                    ZONAS DE ENVÍO
                </h1>
                <p class="text-gray-700">Asigna códigos de precio a las parroquias de Ecuador</p>
            </div>
            <div class="flex gap-3">
                <button
                    onclick="openCreateZoneModal()"
                    class="px-4 py-2 bg-dark-turquoise text-white rounded-full font-semibold text-sm hover:bg-dark-turquoise-alt"
                >
                    + Nueva Zona
                </button>
                <a href="{{ route('admin.shipping.prices') }}" class="px-4 py-2 bg-gray-200 text-gray-brown rounded-full font-semibold text-sm hover:bg-gray-300">
                    Ver Códigos de Precio
                </a>
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-200 text-gray-brown rounded-full font-semibold text-sm hover:bg-gray-300">
                    ← Volver al Panel
                </a>
            </div>
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

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-brown mb-4">Filtros</h2>
            <form method="GET" action="{{ route('admin.shipping.zones') }}" id="filterForm">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="provincia" class="block text-sm font-semibold text-gray-brown mb-2">
                            Provincia
                        </label>
                        <select
                            name="provincia"
                            id="provincia"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                            onchange="loadCantones()"
                        >
                            <option value="">Todas las provincias</option>
                            @foreach($provincias as $prov)
                                <option value="{{ $prov }}" {{ request('provincia') === $prov ? 'selected' : '' }}>
                                    {{ $prov }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="canton" class="block text-sm font-semibold text-gray-brown mb-2">
                            Cantón
                        </label>
                        <select
                            name="canton"
                            id="canton"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                            {{ !request('provincia') ? 'disabled' : '' }}
                        >
                            <option value="">Todos los cantones</option>
                            @foreach($cantones as $cant)
                                <option value="{{ $cant }}" {{ request('canton') === $cant ? 'selected' : '' }}>
                                    {{ $cant }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="price_code" class="block text-sm font-semibold text-gray-brown mb-2">
                            Código de Precio
                        </label>
                        <select
                            name="price_code"
                            id="price_code"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                        >
                            <option value="">Todos</option>
                            <option value="null" {{ request('price_code') === 'null' ? 'selected' : '' }}>Sin asignar</option>
                            @foreach($prices as $price)
                                <option value="{{ $price->code_name }}" {{ request('price_code') === $price->code_name ? 'selected' : '' }}>
                                    {{ $price->code_name }} (${{ number_format($price->price, 2) }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end gap-2">
                        <button
                            type="submit"
                            class="flex-1 px-6 py-2 bg-dark-turquoise hover:bg-dark-turquoise-alt text-white rounded-lg font-semibold"
                        >
                            Filtrar
                        </button>
                        <a
                            href="{{ route('admin.shipping.zones') }}"
                            class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-brown rounded-lg font-semibold"
                        >
                            Limpiar
                        </a>
                    </div>
                </div>

                <div class="mt-4">
                    <label for="search" class="block text-sm font-semibold text-gray-brown mb-2">
                        Buscar parroquia
                    </label>
                    <input
                        type="text"
                        name="search"
                        id="search"
                        value="{{ request('search') }}"
                        placeholder="Buscar por provincia, cantón o parroquia..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                    >
                </div>
            </form>
        </div>

        <!-- Bulk Actions -->
        @if($zones->count() > 0)
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-brown mb-4">Asignación Masiva</h2>
                <form id="bulkForm" action="{{ route('admin.shipping.zones.bulk-update') }}" method="POST">
                    @csrf
                    <div class="flex gap-4 items-end">
                        <div class="flex-1">
                            <label class="block text-sm font-semibold text-gray-brown mb-2">
                                Código de precio para zonas seleccionadas
                            </label>
                            <select
                                name="price_code"
                                id="bulk_price_code"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                            >
                                <option value="">-- Quitar código --</option>
                                @foreach($prices as $price)
                                    <option value="{{ $price->code_name }}">
                                        {{ $price->code_name }} - ${{ number_format($price->price, 2) }} ({{ $price->courier_name ?? 'Sin courier' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button
                            type="submit"
                            class="px-6 py-2 bg-dark-turquoise hover:bg-dark-turquoise-alt text-white rounded-lg font-semibold"
                            onclick="return confirm('¿Estás seguro de actualizar las zonas seleccionadas?')"
                        >
                            Aplicar a Seleccionadas
                        </button>
                    </div>
                    <p class="text-sm text-gray-500 mt-2">
                        <span id="selectedCount">0</span> zonas seleccionadas
                    </p>
                </form>
            </div>
        @endif

        <!-- Zones Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6 border-b flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-brown">
                    Zonas de Envío ({{ $zones->total() }} total)
                </h2>
                @if($zones->count() > 0)
                    <div class="flex items-center gap-2">
                        <input
                            type="checkbox"
                            id="selectAll"
                            class="w-4 h-4 text-dark-turquoise border-gray-300 rounded focus:ring-dark-turquoise"
                            onchange="toggleSelectAll(this)"
                        >
                        <label for="selectAll" class="text-sm text-gray-600">Seleccionar todos en esta página</label>
                    </div>
                @endif
            </div>

            @if($zones->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12">
                                    <span class="sr-only">Seleccionar</span>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Provincia</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantón</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Parroquia</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código Asignado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($zones as $zone)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <input
                                            type="checkbox"
                                            name="zone_ids[]"
                                            value="{{ $zone->id }}"
                                            class="zone-checkbox w-4 h-4 text-dark-turquoise border-gray-300 rounded focus:ring-dark-turquoise"
                                            onchange="updateSelectedCount()"
                                        >
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $zone->provincia }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $zone->canton }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ $zone->parroquia }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($zone->price_code)
                                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded font-mono text-sm">
                                                {{ $zone->price_code }}
                                            </span>
                                        @else
                                            <span class="px-2 py-1 bg-gray-100 text-gray-500 rounded text-sm">
                                                Sin asignar
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($zone->shippingPrice)
                                            <span class="font-semibold text-green-600">${{ number_format($zone->shippingPrice->price, 2) }}</span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button
                                            onclick="editZone({{ $zone->id }}, '{{ $zone->price_code }}')"
                                            class="text-blue-600 hover:text-blue-800"
                                        >
                                            Editar
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t">
                    {{ $zones->appends(request()->query())->links() }}
                </div>
            @else
                <div class="p-6 text-center text-gray-500">
                    No se encontraron zonas con los filtros seleccionados.
                </div>
            @endif
        </div>

    </div>
</section>

<!-- Create Zone Modal -->
<div id="createZoneModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 p-6">
        <h3 class="text-xl font-semibold text-gray-brown mb-4">Nueva Zona de Envío</h3>
        <form action="{{ route('admin.shipping.zones.store') }}" method="POST">
            @csrf

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-4">
                <label for="create_provincia" class="block text-sm font-semibold text-gray-brown mb-2">
                    Provincia *
                </label>
                <input
                    type="text"
                    name="provincia"
                    id="create_provincia"
                    required
                    value="{{ old('provincia') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent @error('provincia') border-red-500 @enderror"
                    placeholder="Ej: Pichincha"
                >
                @error('provincia')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="create_canton" class="block text-sm font-semibold text-gray-brown mb-2">
                    Cantón *
                </label>
                <input
                    type="text"
                    name="canton"
                    id="create_canton"
                    required
                    value="{{ old('canton') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent @error('canton') border-red-500 @enderror"
                    placeholder="Ej: Quito"
                >
                @error('canton')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="create_parroquia" class="block text-sm font-semibold text-gray-brown mb-2">
                    Parroquia *
                </label>
                <input
                    type="text"
                    name="parroquia"
                    id="create_parroquia"
                    required
                    value="{{ old('parroquia') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent @error('parroquia') border-red-500 @enderror"
                    placeholder="Ej: Tumbaco"
                >
                @error('parroquia')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="create_price_code" class="block text-sm font-semibold text-gray-brown mb-2">
                    Código de Precio (opcional)
                </label>
                <select
                    name="price_code"
                    id="create_price_code"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent @error('price_code') border-red-500 @enderror"
                >
                    <option value="">-- Sin código --</option>
                    @foreach($prices as $price)
                        <option value="{{ $price->code_name }}" {{ old('price_code') == $price->code_name ? 'selected' : '' }}>
                            {{ $price->code_name }} - ${{ number_format($price->price, 2) }}
                            @if($price->courier_name)
                                ({{ $price->courier_name }})
                            @endif
                        </option>
                    @endforeach
                </select>
                @error('price_code')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex gap-4">
                <button
                    type="submit"
                    class="px-6 py-2 bg-dark-turquoise hover:bg-dark-turquoise-alt text-white rounded-lg font-semibold"
                >
                    Crear Zona
                </button>
                <button
                    type="button"
                    onclick="closeCreateZoneModal()"
                    class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-brown rounded-lg font-semibold"
                >
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Zone Modal -->
<div id="editZoneModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 p-6">
        <h3 class="text-xl font-semibold text-gray-brown mb-4">Asignar Código de Precio</h3>
        <form id="editZoneForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="edit_price_code" class="block text-sm font-semibold text-gray-brown mb-2">
                    Código de Precio
                </label>
                <select
                    name="price_code"
                    id="edit_price_code"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                >
                    <option value="">-- Sin código --</option>
                    @foreach($prices as $price)
                        <option value="{{ $price->code_name }}">
                            {{ $price->code_name }} - ${{ number_format($price->price, 2) }}
                            @if($price->courier_name)
                                ({{ $price->courier_name }})
                            @endif
                        </option>
                    @endforeach
                </select>
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
                    onclick="closeEditZoneModal()"
                    class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-brown rounded-lg font-semibold"
                >
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Load cantones when provincia changes
function loadCantones() {
    const provincia = document.getElementById('provincia').value;
    const cantonSelect = document.getElementById('canton');

    if (!provincia) {
        cantonSelect.disabled = true;
        cantonSelect.innerHTML = '<option value="">Todos los cantones</option>';
        return;
    }

    fetch(`/pruebas/admin/shipping/cantones?provincia=${encodeURIComponent(provincia)}`)
        .then(response => response.json())
        .then(cantones => {
            cantonSelect.disabled = false;
            cantonSelect.innerHTML = '<option value="">Todos los cantones</option>';
            cantones.forEach(canton => {
                const option = document.createElement('option');
                option.value = canton;
                option.textContent = canton;
                cantonSelect.appendChild(option);
            });
        });
}

// Create zone modal
function openCreateZoneModal() {
    document.getElementById('createZoneModal').classList.remove('hidden');
    document.getElementById('createZoneModal').classList.add('flex');
}

function closeCreateZoneModal() {
    document.getElementById('createZoneModal').classList.add('hidden');
    document.getElementById('createZoneModal').classList.remove('flex');
}

// Edit zone modal
function editZone(id, currentPriceCode) {
    document.getElementById('editZoneForm').action = `/pruebas/admin/shipping/zones/${id}`;
    document.getElementById('edit_price_code').value = currentPriceCode || '';
    document.getElementById('editZoneModal').classList.remove('hidden');
    document.getElementById('editZoneModal').classList.add('flex');
}

function closeEditZoneModal() {
    document.getElementById('editZoneModal').classList.add('hidden');
    document.getElementById('editZoneModal').classList.remove('flex');
}

// Close modals on background click
document.getElementById('createZoneModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCreateZoneModal();
    }
});

document.getElementById('editZoneModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditZoneModal();
    }
});

// Bulk selection
function toggleSelectAll(checkbox) {
    const checkboxes = document.querySelectorAll('.zone-checkbox');
    checkboxes.forEach(cb => cb.checked = checkbox.checked);
    updateSelectedCount();
}

function updateSelectedCount() {
    const checkboxes = document.querySelectorAll('.zone-checkbox:checked');
    document.getElementById('selectedCount').textContent = checkboxes.length;
}

// Bulk form submission
document.getElementById('bulkForm').addEventListener('submit', function(e) {
    const checkboxes = document.querySelectorAll('.zone-checkbox:checked');

    // Remove old hidden inputs
    const oldInputs = this.querySelectorAll('input[name="zone_ids[]"]');
    oldInputs.forEach(input => input.remove());

    // Add selected zone IDs as hidden inputs
    checkboxes.forEach(checkbox => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'zone_ids[]';
        input.value = checkbox.value;
        this.appendChild(input);
    });

    if (checkboxes.length === 0) {
        e.preventDefault();
        alert('Por favor selecciona al menos una zona');
    }
});
</script>

@endsection
