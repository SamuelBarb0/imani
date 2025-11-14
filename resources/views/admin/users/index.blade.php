@extends('layouts.app')

@section('title', 'Gestión de Usuarios - Admin')

@section('content')

<section class="bg-white py-6">
    <div class="container mx-auto px-6 max-w-7xl">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="font-spartan text-3xl font-bold text-dark-turquoise mb-2">
                    GESTIÓN DE USUARIOS
                </h1>
                <p class="text-gray-700">Total: {{ $users->total() }} usuarios</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-dark-turquoise text-white rounded-full font-semibold text-sm hover:bg-dark-turquoise-alt">
                ← Volver al Dashboard
            </a>
        </div>
    </div>
</section>

<section class="bg-gray-50 py-8">
    <div class="container mx-auto px-6 max-w-7xl">

        <!-- Messages -->
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

        <!-- Search -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <form method="GET" action="{{ route('admin.users.index') }}" class="flex gap-4">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nombre o email..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise">
                </div>
                <button type="submit" class="px-6 py-2 bg-dark-turquoise text-white rounded-lg font-semibold hover:bg-dark-turquoise-alt">
                    Buscar
                </button>
                <a href="{{ route('admin.users.index') }}" class="px-6 py-2 bg-gray-200 text-gray-brown rounded-lg font-semibold hover:bg-gray-300">
                    Limpiar
                </a>
            </form>
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            @if($users->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-brown uppercase">ID</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-brown uppercase">Nombre</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-brown uppercase">Email</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-brown uppercase">Teléfono</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-brown uppercase">Rol</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-brown uppercase">Registrado</th>
                                <th class="text-right py-3 px-4 text-xs font-semibold text-gray-brown uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-3 px-4 text-sm">{{ $user->id }}</td>
                                    <td class="py-3 px-4 text-sm font-semibold">{{ $user->name }}</td>
                                    <td class="py-3 px-4 text-sm">{{ $user->email }}</td>
                                    <td class="py-3 px-4 text-sm">{{ $user->phone ?? 'N/A' }}</td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                                            @if($user->role === 'admin') bg-purple-100 text-purple-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-sm">{{ $user->created_at->format('d/m/Y') }}</td>
                                    <td class="py-3 px-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('admin.users.edit', $user) }}"
                                               class="px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white text-xs rounded font-semibold">
                                                Editar
                                            </a>
                                            @if(auth()->id() !== $user->id)
                                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline"
                                                      onsubmit="return confirm('¿Estás seguro de eliminar este usuario? Esta acción no se puede deshacer.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-xs rounded font-semibold">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            @else
                                                <span class="px-3 py-1 bg-gray-300 text-gray-500 text-xs rounded font-semibold cursor-not-allowed"
                                                      title="No puedes eliminarte a ti mismo">
                                                    Eliminar
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-4">
                    {{ $users->links() }}
                </div>
            @else
                <p class="text-gray-500 text-center py-12">No se encontraron usuarios</p>
            @endif
        </div>

    </div>
</section>

@endsection
