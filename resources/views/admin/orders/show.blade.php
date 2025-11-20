@php
use Illuminate\Support\Facades\Storage;
@endphp

@extends('layouts.app')

@section('title', 'Detalle del Pedido - Admin')

@section('content')

<section class="bg-gradient-to-r from-dark-turquoise to-dark-turquoise-alt py-6">
    <div class="container mx-auto px-6 max-w-6xl">
        <div class="flex justify-between items-center">
            <div>
<h1 class="font-spartan text-3xl font-bold text-gray-900 mb-2">
  PEDIDO #{{ $order->order_number }}
</h1>

                <p class="text-gray-900">{{ $order->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.orders.pdf', $order->id) }}" target="_blank" class="px-4 py-2 bg-white text-dark-turquoise rounded-full font-semibold text-sm hover:bg-gray-100">
                    📄 Descargar PDF
                </a>
                <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-white text-dark-turquoise rounded-full font-semibold text-sm hover:bg-gray-100">
                    ← Volver a Pedidos
                </a>
            </div>
        </div>
    </div>
</section>

<section class="bg-gray-50 py-8">
    <div class="container mx-auto px-6 max-w-6xl">

        <!-- Action Buttons -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

            <!-- Confirm Payment (for transfers without proof) -->
            @if($order->payment_method === 'transfer' && $order->payment_status === 'pending')
                <div class="bg-yellow-50 border-2 border-yellow-200 rounded-lg p-4">
                    <h3 class="font-semibold text-yellow-800 mb-2">⏳ Pendiente de Comprobante</h3>
                    <form action="{{ route('admin.orders.upload-proof', $order->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="payment_proof" accept="image/*" required class="w-full text-sm mb-2 p-2 border rounded">
                        <button type="submit" class="w-full px-4 py-2 bg-yellow-600 text-white rounded font-semibold hover:bg-yellow-700">
                            Cargar Comprobante
                        </button>
                    </form>
                </div>
            @endif

            <!-- Confirm Payment Button (manual confirmation) -->
            @if($order->payment_status === 'pending' && $order->payment_method !== 'transfer')
                <div class="bg-green-50 border-2 border-green-200 rounded-lg p-4">
                    <h3 class="font-semibold text-green-800 mb-2">💳 Confirmar Pago Recibido</h3>
                    <form action="{{ route('admin.orders.confirm-payment', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded font-semibold hover:bg-green-700">
                            Confirmar Pago
                        </button>
                    </form>
                </div>
            @endif

            <!-- Add Tracking Number -->
            @if($order->payment_status === 'completed' && !$order->tracking_number)
                <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-4">
                    <h3 class="font-semibold text-blue-800 mb-3">📦 Agregar Tracking</h3>
                    <form action="{{ route('admin.orders.add-tracking', $order->id) }}" method="POST" class="space-y-2">
                        @csrf
                        <select name="courier" required class="w-full text-sm p-2 border rounded">
                            <option value="">Seleccionar Courier</option>
                            @foreach(\App\Models\Courier::where('is_active', true)->orderBy('name')->get() as $courier)
                                <option value="{{ $courier->name }}">{{ $courier->name }}</option>
                            @endforeach
                        </select>
                        <input type="text" name="tracking_number" placeholder="# de Tracking" required class="w-full text-sm p-2 border rounded">
                        <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded font-semibold hover:bg-blue-700">
                            Enviar Tracking y Marcar como Enviado
                        </button>
                    </form>
                </div>
            @endif

        </div>

        <!-- Order Info -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="font-spartan text-lg font-bold text-dark-turquoise mb-4">Información del Cliente</h2>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs font-semibold text-gray-brown">Nombre:</p>
                        <p class="text-sm">{{ $order->customer_name }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-brown">Email:</p>
                        <p class="text-sm">{{ $order->customer_email }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-brown">Teléfono:</p>
                        <p class="text-sm">{{ $order->customer_phone ?? 'N/A' }}</p>
                    </div>
                    <div class="pt-3 border-t border-gray-200">
                        <p class="text-xs font-semibold text-gray-brown mb-1">Documento de Identificación:</p>
                        <p class="text-sm">
                            <span class="font-semibold uppercase">{{ $order->document_type ?? 'N/A' }}:</span>
                            {{ $order->document_number ?? 'N/A' }}
                        </p>
                    </div>
                    @if($order->newsletter_subscription || $order->social_media_consent)
                        <div class="pt-3 border-t border-gray-200">
                            <p class="text-xs font-semibold text-gray-brown mb-1">Preferencias:</p>
                            @if($order->newsletter_subscription)
                                <p class="text-xs text-green-600">✓ Suscrito al newsletter</p>
                            @endif
                            @if($order->social_media_consent)
                                <p class="text-xs text-green-600">✓ Consentimiento para redes sociales</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="font-spartan text-lg font-bold text-dark-turquoise mb-4">Dirección de Envío</h2>
                <div class="space-y-3">
                    @if($order->shipping_name && $order->shipping_name !== $order->customer_name)
                        <div>
                            <p class="text-xs font-semibold text-gray-brown">Nombre del Destinatario:</p>
                            <p class="text-sm">{{ $order->shipping_name }}</p>
                        </div>
                    @endif
                    <div>
                        <p class="text-xs font-semibold text-gray-brown">Dirección:</p>
                        <p class="text-sm">{{ $order->shipping_address ?? 'N/A' }}</p>
                    </div>
                    @if(($order->shipping_provincia && $order->shipping_provincia !== 'N/A') || ($order->shipping_state && $order->shipping_state !== 'N/A'))
                        <div>
                            <p class="text-xs font-semibold text-gray-brown">Provincia:</p>
                            <p class="text-sm">{{ $order->shipping_provincia ?? $order->shipping_state ?? 'N/A' }}</p>
                        </div>
                    @endif
                    @if($order->shipping_canton && $order->shipping_canton !== 'N/A')
                        <div>
                            <p class="text-xs font-semibold text-gray-brown">Cantón:</p>
                            <p class="text-sm">{{ $order->shipping_canton }}</p>
                        </div>
                    @endif
                    @if(($order->shipping_parroquia && $order->shipping_parroquia !== 'N/A') || ($order->shipping_city && $order->shipping_city !== 'N/A'))
                        <div>
                            <p class="text-xs font-semibold text-gray-brown">Parroquia:</p>
                            <p class="text-sm">{{ $order->shipping_parroquia ?? $order->shipping_city ?? 'N/A' }}</p>
                        </div>
                    @endif
                    @if($order->shipping_zip && $order->shipping_zip !== 'N/A')
                        <div>
                            <p class="text-xs font-semibold text-gray-brown">Código Postal:</p>
                            <p class="text-sm">{{ $order->shipping_zip }}</p>
                        </div>
                    @endif
                    <div>
                        <p class="text-xs font-semibold text-gray-brown">País:</p>
                        <p class="text-sm">{{ $order->shipping_country ?? 'Ecuador' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="font-spartan text-lg font-bold text-dark-turquoise mb-4">Estado del Pedido</h2>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs font-semibold text-gray-brown mb-1">Estado del Pedido:</p>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold
                            @if($order->status === 'completed') bg-green-100 text-green-800
                            @elseif($order->status === 'shipped') bg-blue-100 text-blue-800
                            @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                            @elseif($order->status === 'payment_received') bg-green-100 text-green-800
                            @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                            @endif">
                            {{ $order->status_name }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-brown mb-1">Estado del Pago:</p>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold
                            @if($order->payment_status === 'completed') bg-green-100 text-green-800
                            @elseif($order->payment_status === 'pending') bg-yellow-100 text-yellow-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-brown">Método de Pago:</p>
                        <p class="text-sm">{{ ucfirst($order->payment_method) }}</p>
                    </div>

                    @if($order->payment_proof)
                        <div>
                            <p class="text-xs font-semibold text-gray-brown mb-1">Comprobante de Pago:</p>
                            <a href="{{ Storage::url($order->payment_proof) }}" target="_blank" class="text-blue-600 hover:underline text-sm">
                                Ver comprobante →
                            </a>
                        </div>
                    @endif

                    @if($order->tracking_number)
                        <div class="pt-3 border-t border-gray-200">
                            <p class="text-xs font-semibold text-gray-brown">Courier:</p>
                            <p class="text-sm">{{ \App\Models\Order::getCouriers()[$order->courier] ?? $order->courier }}</p>
                            <p class="text-xs font-semibold text-gray-brown mt-2">Tracking #:</p>
                            <p class="text-sm font-mono">{{ $order->tracking_number }}</p>
                            @if($order->tracking_url)
                                <p class="text-xs font-semibold text-gray-brown mt-2">Link de Tracking:</p>
                                <a href="{{ $order->tracking_url }}" target="_blank" class="text-sm text-blue-600 hover:underline break-all">
                                    {{ $order->tracking_url }}
                                </a>
                            @endif
                            @if($order->shipped_at)
                                <p class="text-xs text-gray-500 mt-2">Enviado: {{ $order->shipped_at->format('d/m/Y H:i') }}</p>
                            @endif
                        </div>
                    @endif
                </div>
                <div class="mt-6">
                    <a href="{{ route('admin.orders.edit', $order->id) }}" class="w-full block text-center px-4 py-2 bg-dark-turquoise text-white rounded-lg font-semibold hover:bg-dark-turquoise-alt">
                        Editar Estado
                    </a>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="font-spartan text-lg font-bold text-dark-turquoise mb-4">Productos</h2>
            <div class="space-y-4">
                @foreach($order->items as $item)
                    <div class="border-b border-gray-200 pb-4">
                        <div class="flex justify-between items-center">
                            <div class="flex-1">
                                <p class="font-semibold">{{ $item->product_name }}</p>
                                <p class="text-sm text-gray-brown">Cantidad: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}</p>
                            </div>
                            <p class="font-bold text-dark-turquoise">${{ number_format($item->subtotal, 2) }}</p>
                        </div>

                        @if(!empty($item->custom_data) && isset($item->custom_data['images']))
                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <p class="text-xs font-semibold text-gray-brown mb-3">🖼️ Imágenes Personalizadas ({{ count($item->custom_data['images']) }})</p>
                                <div class="grid grid-cols-3 md:grid-cols-5 lg:grid-cols-9 gap-2">
                                    @foreach($item->custom_data['images'] as $imageData)
                                        @php
                                            $imagePath = is_array($imageData) ? $imageData['path'] : $imageData;
                                            $imageIndex = is_array($imageData) ? $imageData['index'] : $loop->index;
                                        @endphp
                                        <div class="relative group">
                                            <img
                                                src="{{ Storage::url($imagePath) }}"
                                                alt="Imagen {{ $imageIndex + 1 }}"
                                                class="w-full h-20 object-cover rounded border-2 border-gray-200 hover:border-dark-turquoise cursor-pointer transition-all"
                                                onclick="window.open('{{ Storage::url($imagePath) }}', '_blank')"
                                            >
                                            <div class="absolute bottom-0 left-0 right-0 bg-black/50 text-white text-xs text-center py-1 rounded-b opacity-0 group-hover:opacity-100 transition-opacity">
                                                #{{ $imageIndex + 1 }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @if($item->template_path)
                                    <div class="mt-3 flex items-center gap-3">
                                        <p class="text-xs text-green-600">✓ Template generado</p>
                                        <a href="{{ route('admin.orders.download-item-template', ['orderId' => $order->id, 'itemId' => $item->id]) }}"
                                           class="inline-flex items-center gap-2 px-3 py-1.5 bg-dark-turquoise text-white rounded-lg font-spartan font-semibold text-xs tracking-wider uppercase hover:bg-gray-brown transition-all">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                            </svg>
                                            Descargar Template
                                        </a>
                                    </div>
                                @else
                                    <p class="text-xs text-gray-500 mt-2">⏳ Template pendiente de generar</p>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Order Summary -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="font-spartan text-lg font-bold text-dark-turquoise mb-4">Resumen</h2>
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-brown">Subtotal:</span>
                    <span>${{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-brown">Envío:</span>
                    <span>${{ number_format($order->shipping_cost, 2) }}</span>
                </div>
                <div class="border-t border-gray-200 pt-3 flex justify-between">
                    <span class="font-spartan font-bold text-dark-turquoise text-lg">Total:</span>
                    <span class="font-spartan text-xl font-bold text-dark-turquoise">${{ number_format($order->total, 2) }}</span>
                </div>
            </div>

            @if($order->notes)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <p class="text-xs font-semibold text-gray-brown mb-2">Notas del Cliente:</p>
                    <p class="text-sm">{{ $order->notes }}</p>
                </div>
            @endif

            @if($order->admin_notes)
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <p class="text-xs font-semibold text-gray-brown mb-2">Notas Internas:</p>
                    <p class="text-sm text-red-600">{{ $order->admin_notes }}</p>
                </div>
            @endif
        </div>

    </div>
</section>

@endsection
