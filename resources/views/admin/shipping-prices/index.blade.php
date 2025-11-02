@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-dark-turquoise mb-2">Matriz de Precios de Envío</h1>
        <p class="text-gray-600">Configura los precios de envío por ciudad y courier. Los campos vacíos significan que ese courier no está disponible para esa ciudad.</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($couriers->count() === 0)
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
            No hay couriers activos. <a href="{{ route('admin.couriers.create') }}" class="underline font-semibold">Crear un courier</a> primero.
        </div>
    @endif

    @if($cities->count() === 0)
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
            No hay ciudades activas. Las ciudades se crean automáticamente con las provincias.
        </div>
    @endif

    @if($couriers->count() > 0 && $cities->count() > 0)
    <form action="{{ route('admin.shipping-prices.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 sticky top-0">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10">Ciudad</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">Provincia</th>
                        @foreach($couriers as $courier)
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">
                                {{ $courier->name }}
                                <div class="text-xs font-normal text-gray-400 normal-case">(USD)</div>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($cities as $city)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 whitespace-nowrap sticky left-0 bg-white">
                                <div class="text-sm font-medium text-gray-900">{{ $city->name }}</div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-sm text-gray-600">{{ $city->province->name }}</div>
                            </td>
                            @foreach($couriers as $courier)
                                @php
                                    $existingPrice = $city->courierPrices->firstWhere('courier_id', $courier->id);
                                @endphp
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <input
                                        type="number"
                                        name="prices[{{ $city->id }}][{{ $courier->id }}]"
                                        value="{{ $existingPrice ? $existingPrice->price : '' }}"
                                        step="0.01"
                                        min="0"
                                        max="9999.99"
                                        placeholder="0.00"
                                        class="w-24 px-2 py-1 text-sm border border-gray-300 rounded focus:ring-2 focus:ring-dark-turquoise focus:border-transparent text-center"
                                    >
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex justify-end gap-4">
            <a href="{{ route('admin.dashboard') }}" class="px-6 py-3 border border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-50">
                Cancelar
            </a>
            <button type="submit" class="bg-dark-turquoise hover:bg-dark-turquoise-alt text-white px-6 py-3 rounded-lg font-semibold">
                Guardar Precios
            </button>
        </div>
    </form>
    @endif

    <!-- Quick actions -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('admin.couriers.index') }}" class="block p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
            <h3 class="font-semibold text-blue-900 mb-1">Gestionar Couriers</h3>
            <p class="text-sm text-blue-700">Agregar o editar empresas de envío</p>
        </a>
        <a href="{{ route('admin.cities.index') }}" class="block p-4 bg-green-50 rounded-lg hover:bg-green-100 transition">
            <h3 class="font-semibold text-green-900 mb-1">Gestionar Ciudades</h3>
            <p class="text-sm text-green-700">Agregar o editar ciudades disponibles</p>
        </a>
        <a href="{{ route('admin.provinces.index') }}" class="block p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition">
            <h3 class="font-semibold text-purple-900 mb-1">Gestionar Provincias</h3>
            <p class="text-sm text-purple-700">Agregar o editar provincias</p>
        </a>
    </div>
</div>
@endsection
