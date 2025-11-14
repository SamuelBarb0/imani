@extends('layouts.app')

@section('title', 'Editar Usuario - Admin')

@section('content')

<section class="bg-gradient-to-r from-dark-turquoise to-dark-turquoise-alt py-6">
    <div class="container mx-auto px-6 max-w-4xl">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="font-spartan text-3xl font-bold text-white mb-2">
                    EDITAR USUARIO
                </h1>
                <p class="text-gray-200">ID: {{ $user->id }} | {{ $user->email }}</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-white text-dark-turquoise rounded-full font-semibold text-sm hover:bg-gray-100">
                ← Volver a Usuarios
            </a>
        </div>
    </div>
</section>

<section class="bg-gray-50 py-8">
    <div class="container mx-auto px-6 max-w-4xl">

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-semibold text-gray-brown mb-2">
                        Nombre Completo *
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name', $user->name) }}"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                    >
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-semibold text-gray-brown mb-2">
                        Email *
                    </label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email', $user->email) }}"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                    >
                </div>

                <!-- Phone -->
                <div class="mb-6">
                    <label for="phone" class="block text-sm font-semibold text-gray-brown mb-2">
                        Teléfono
                    </label>
                    <input
                        type="text"
                        name="phone"
                        id="phone"
                        value="{{ old('phone', $user->phone) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                    >
                </div>

                <!-- Role -->
                <div class="mb-6">
                    <label for="role" class="block text-sm font-semibold text-gray-brown mb-2">
                        Rol *
                    </label>
                    <select
                        name="role"
                        id="role"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                    >
                        <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>Usuario</option>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrador</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Los administradores tienen acceso completo al panel de administración.</p>
                </div>

                <!-- Password (Optional) -->
                <div class="mb-6 border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-brown mb-4">Cambiar Contraseña (Opcional)</h3>
                    <p class="text-sm text-gray-600 mb-4">Deja estos campos vacíos si no quieres cambiar la contraseña.</p>

                    <div class="mb-4">
                        <label for="password" class="block text-sm font-semibold text-gray-brown mb-2">
                            Nueva Contraseña
                        </label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                        >
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-brown mb-2">
                            Confirmar Nueva Contraseña
                        </label>
                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                        >
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex gap-4">
                    <button
                        type="submit"
                        class="px-6 py-3 bg-dark-turquoise hover:bg-dark-turquoise-alt text-white rounded-lg font-semibold"
                    >
                        Actualizar Usuario
                    </button>
                    <a
                        href="{{ route('admin.users.index') }}"
                        class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-brown rounded-lg font-semibold"
                    >
                        Cancelar
                    </a>
                </div>
            </form>
        </div>

        <!-- User Info Card -->
        <div class="bg-white rounded-lg shadow-md p-6 mt-6">
            <h3 class="text-lg font-semibold text-gray-brown mb-4">Información Adicional</h3>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="font-semibold text-gray-700">Fecha de Registro:</span>
                    <span class="text-gray-600">{{ $user->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div>
                    <span class="font-semibold text-gray-700">Última Actualización:</span>
                    <span class="text-gray-600">{{ $user->updated_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection
