@extends('layouts.app')

@section('title', 'Checkout - Imani Magnets')

@push('styles')
@endpush

@section('content')

<!-- Hero Section -->
<section class="bg-white py-4">
    <div class="container mx-auto px-6 max-w-6xl text-center">
        <h1 class="font-spartan text-2xl lg:text-3xl font-bold text-dark-turquoise mb-2">
            FINALIZAR COMPRA
        </h1>
        <p class="text-sm text-gray-brown">
            Completa tus datos para procesar el pedido
        </p>
    </div>
</section>

<!-- Checkout Section -->
<section class="bg-gray-50 py-8">
    <div class="container mx-auto px-6 max-w-6xl">

        <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Checkout Form -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Billing and Shipping Information -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="font-spartan text-xl font-bold text-dark-turquoise mb-4">
                            INFORMACIÓN DE FACTURACIÓN Y ENVÍO
                        </h2>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-brown mb-2">Nombre Completo *</label>
                                <input type="text" name="customer_name" id="billing_name" value="{{ old('customer_name') }}" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent">
                                @error('customer_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-brown mb-2">Tipo de Documento *</label>
                                    <select name="document_type" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent">
                                        <option value="">Seleccionar...</option>
                                        <option value="cedula" {{ old('document_type') == 'cedula' ? 'selected' : '' }}>Cédula</option>
                                        <option value="pasaporte" {{ old('document_type') == 'pasaporte' ? 'selected' : '' }}>Pasaporte</option>
                                        <option value="ruc" {{ old('document_type') == 'ruc' ? 'selected' : '' }}>RUC</option>
                                    </select>
                                    @error('document_type')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-brown mb-2">Número de Documento *</label>
                                    <input type="text" name="document_number" value="{{ old('document_number') }}" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent">
                                    @error('document_number')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-brown mb-2">Email *</label>
                                    <input type="email" name="customer_email" value="{{ old('customer_email') }}" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent">
                                    @error('customer_email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-brown mb-2">Teléfono *</label>
                                    <input type="tel" name="customer_phone" value="{{ old('customer_phone') }}" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                                        placeholder="0987654321">
                                    @error('customer_phone')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-brown mb-2">Dirección *</label>
                                <textarea name="billing_address" id="billing_address" rows="2" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                                    placeholder="Calle principal, número, sector">{{ old('billing_address') }}</textarea>
                                @error('billing_address')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-brown mb-2">Provincia *</label>
                                    <select name="billing_provincia" id="billing_provincia" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent">
                                        <option value="">Seleccionar provincia...</option>
                                        @foreach($provincias as $prov)
                                            <option value="{{ $prov }}" {{ old('billing_provincia') === $prov ? 'selected' : '' }}>
                                                {{ $prov }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('billing_provincia')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-brown mb-2">Cantón *</label>
                                    <select name="billing_canton" id="billing_canton" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                                        {{ !old('billing_provincia') ? 'disabled' : '' }}>
                                        <option value="">Seleccionar cantón...</option>
                                    </select>
                                    @error('billing_canton')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-brown mb-2">Parroquia *</label>
                                    <select name="billing_parroquia" id="billing_parroquia" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                                        {{ !old('billing_canton') ? 'disabled' : '' }}>
                                        <option value="">Seleccionar parroquia...</option>
                                    </select>
                                    @error('billing_parroquia')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-brown mb-2">Código Postal <span class="text-red-500">*</span></label>
                                    <input type="text" name="billing_zip" id="billing_zip" value="{{ old('billing_zip') }}" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                                        placeholder="170150">
                                    @error('billing_zip')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-brown mb-2">País *</label>
                                <input type="text" name="billing_country" id="billing_country" value="{{ old('billing_country', 'Ecuador') }}" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                                    readonly>
                                @error('billing_country')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Same as Billing Checkbox -->
                            <div class="pt-4 border-t border-gray-200">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" id="same_as_billing" name="same_as_billing" value="1" checked
                                        class="w-5 h-5 text-dark-turquoise border-gray-300 rounded focus:ring-dark-turquoise">
                                    <span class="ml-3 text-sm font-semibold text-gray-800">
                                        ENVIAR PEDIDO A LA MISMA DIRECCIÓN DE FACTURACIÓN
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Separate Shipping Address (Hidden by default) -->
                    <div id="shipping_section" class="bg-white rounded-lg shadow-md p-6 hidden">
                        <h2 class="font-spartan text-xl font-bold text-dark-turquoise mb-4">
                            DIRECCIÓN DE ENVÍO
                        </h2>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-brown mb-2">Nombre Completo *</label>
                                <input type="text" name="shipping_name" id="shipping_name" value="{{ old('shipping_name') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent">
                                @error('shipping_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-brown mb-2">Dirección *</label>
                                <textarea name="shipping_address" id="shipping_address" rows="2"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                                    placeholder="Calle principal, número, sector" required>{{ old('shipping_address') }}</textarea>
                                @error('shipping_address')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-brown mb-2">Provincia *</label>
                                    <select name="shipping_provincia" id="shipping_provincia"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent" required>
                                        <option value="">Seleccionar provincia...</option>
                                        @foreach($provincias as $prov)
                                            <option value="{{ $prov }}" {{ old('shipping_provincia') === $prov ? 'selected' : '' }}>
                                                {{ $prov }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('shipping_provincia')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-brown mb-2">Cantón *</label>
                                    <select name="shipping_canton" id="shipping_canton"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                                        disabled required>
                                        <option value="">Seleccionar cantón...</option>
                                    </select>
                                    @error('shipping_canton')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-brown mb-2">Parroquia *</label>
                                    <select name="shipping_parroquia" id="shipping_parroquia"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                                        disabled required>
                                        <option value="">Seleccionar parroquia...</option>
                                    </select>
                                    @error('shipping_parroquia')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-brown mb-2">Código Postal <span class="text-red-500">*</span></label>
                                    <input type="text" name="shipping_zip" id="shipping_zip" value="{{ old('shipping_zip') }}" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                                        placeholder="170150">
                                    @error('shipping_zip')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-brown mb-2">País *</label>
                                <input type="text" name="shipping_country" id="shipping_country" value="{{ old('shipping_country', 'Ecuador') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent"
                                    readonly>
                                @error('shipping_country')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="font-spartan text-xl font-bold text-dark-turquoise mb-4">
                            MÉTODO DE PAGO
                        </h2>

                        <div class="space-y-3">
                            <!-- PayPhone Payment Box -->
                            <label class="flex items-start p-4 border-2 border-dark-turquoise rounded-lg cursor-pointer hover:border-dark-turquoise transition-colors bg-green-50">
                                <input type="radio" name="payment_method" value="payphone" checked class="w-5 h-5 text-dark-turquoise mt-1">
                                <div class="ml-3 flex-grow">
                                    <div class="flex items-center mb-2">
                                        <svg class="w-6 h-6 text-dark-turquoise mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                        </svg>
                                        <span class="font-semibold text-gray-800">Pago con Tarjeta o PayPhone</span>
                                    </div>
                                    <p class="text-xs text-gray-brown">Acepta Visa, MasterCard, Diners, Discover y saldo PayPhone</p>
                                </div>
                            </label>

                            <!-- Transferencia Bancaria -->
                            <label class="flex items-start p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-dark-turquoise transition-colors" id="transfer-label">
                                <input type="radio" name="payment_method" value="transfer" class="w-5 h-5 text-dark-turquoise mt-1" id="transfer-radio">
                                <div class="ml-3 flex-grow">
                                    <span class="font-semibold text-gray-800">Transferencia Bancaria</span>
                                    <p class="text-xs text-gray-brown mt-1">Realiza tu pago mediante transferencia bancaria</p>
                                </div>
                                <svg class="w-8 h-8 text-gray-orange flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                </svg>
                            </label>

                            <!-- Transfer Details Panel (Hidden by default) -->
                            <div id="transfer-details" class="hidden p-4 bg-blue-50 border-2 border-blue-200 rounded-lg">
                                <p class="font-semibold text-dark-turquoise mb-3">📋 Datos bancarios para transferencia:</p>
                                <div class="space-y-2 text-sm text-gray-800">
                                    <div class="flex">
                                        <span class="font-semibold w-32">Banco:</span>
                                        <span>Banco de Guayaquil S.A.</span>
                                    </div>
                                    <div class="flex">
                                        <span class="font-semibold w-32">Titular:</span>
                                        <span>Schulz Julia</span>
                                    </div>
                                    <div class="flex">
                                        <span class="font-semibold w-32">CI:</span>
                                        <span>1761553880</span>
                                    </div>
                                    <div class="flex">
                                        <span class="font-semibold w-32">Tipo de cuenta:</span>
                                        <span>Cuenta de ahorros</span>
                                    </div>
                                    <div class="flex">
                                        <span class="font-semibold w-32">Número:</span>
                                        <span class="font-mono">50599480</span>
                                    </div>
                                </div>

                                <div class="mt-4 p-3 bg-white rounded border border-blue-300">
                                    <p class="font-semibold text-sm text-gray-800 mb-2">🏦 Instrucciones importantes:</p>
                                    <ul class="text-xs text-gray-brown space-y-1 list-disc list-inside">
                                        <li>Realiza tu transferencia por el monto total del pedido</li>
                                        <li>Envía el comprobante a: <strong class="text-dark-turquoise">comprobantes@imanimagnets.com</strong> o vía WhatsApp al <strong class="text-dark-turquoise">+593985959303</strong></li>
                                        <li>Incluye tu número de orden o email en el asunto</li>
                                        <li>Tu pedido quedará como <strong>"Pendiente"</strong> hasta que verifiquemos el pago</li>
                                        <li>Procesaremos tu pedido una vez confirmada la transferencia</li>
                                    </ul>
                                </div>
                            </div>
                        </div>


                        @error('payment_method')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Preferences -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="font-spartan text-xl font-bold text-dark-turquoise mb-4">
                            PREFERENCIAS
                        </h2>

                        <div class="space-y-3">
                            <label class="flex items-start cursor-pointer">
                                <input type="checkbox" name="newsletter_subscription" value="1" {{ old('newsletter_subscription') ? 'checked' : '' }}
                                    class="w-4 h-4 text-dark-turquoise border-gray-300 rounded focus:ring-dark-turquoise mt-1">
                                <span class="ml-3 text-sm text-gray-brown">
                                    Quiero recibir novedades, promociones y ofertas exclusivas por correo electrónico
                                </span>
                            </label>

                            <label class="flex items-start cursor-pointer">
                                <input type="checkbox" name="social_media_consent" value="1" {{ old('social_media_consent') ? 'checked' : '' }}
                                    class="w-4 h-4 text-dark-turquoise border-gray-300 rounded focus:ring-dark-turquoise mt-1">
                                <span class="ml-3 text-sm text-gray-brown">
                                    Autorizo a Imani Magnets a usar fotos de mi pedido en redes sociales y material promocional
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="font-spartan text-xl font-bold text-dark-turquoise mb-4">
                            NOTAS ADICIONALES
                        </h2>

                        <textarea name="notes" rows="3" placeholder="¿Alguna instrucción especial para tu pedido?"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-dark-turquoise focus:border-transparent">{{ old('notes') }}</textarea>
                    </div>

                </div>

                <!-- Order Summary Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Checkout Message (if active) -->
                    @php
                        $checkoutMessage = \App\Models\CheckoutMessage::getActiveMessage();
                    @endphp

                    @if($checkoutMessage)
                        <div class="mb-4 rounded-lg p-4 border-l-4
                            @if($checkoutMessage->type === 'info') bg-blue-50 border-blue-500
                            @elseif($checkoutMessage->type === 'warning') bg-yellow-50 border-yellow-500
                            @elseif($checkoutMessage->type === 'vacation') bg-orange-50 border-orange-500
                            @endif">
                            <div class="text-sm whitespace-pre-line
                                @if($checkoutMessage->type === 'info') text-blue-900
                                @elseif($checkoutMessage->type === 'warning') text-yellow-900
                                @elseif($checkoutMessage->type === 'vacation') text-orange-900
                                @endif">{{ $checkoutMessage->content }}</div>
                        </div>
                    @endif

                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                        <h2 class="font-spartan text-xl font-bold text-dark-turquoise mb-4">
                            RESUMEN DEL PEDIDO
                        </h2>

                        <!-- Items -->
                        <div class="space-y-3 mb-4 pb-4 border-b border-gray-200">
                            @foreach($items as $item)
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-brown">
                                        {{ strip_tags($item->getProductName()) }} (x{{ $item->quantity }})
                                    </span>
                                    <span class="font-semibold">${{ number_format($item->getSubtotal(), 2) }}</span>
                                </div>
                            @endforeach
                        </div>

                        <!-- Totals -->
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-brown">Subtotal:</span>
                                <span class="font-semibold" id="summary-subtotal">${{ number_format($subtotal / 1.15, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-brown">Envío:</span>
                                <span class="font-semibold" id="summary-shipping">${{ number_format($shippingCost / 1.15, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-brown">IVA (15%):</span>
                                <span class="font-semibold" id="summary-tax">${{ number_format((($subtotal / 1.15) + ($shippingCost / 1.15)) * 0.15, 2) }}</span>
                            </div>
                            <div class="border-t border-gray-200 pt-3 flex justify-between">
                                <span class="font-spartan font-bold text-dark-turquoise">Total:</span>
                                <span class="font-spartan text-xl font-bold text-dark-turquoise" id="summary-total">${{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <!-- Terms and Conditions Checkbox -->
                        <div class="mb-4">
                            <label class="flex items-start">
                                <input type="checkbox" name="accept_terms" id="accept_terms" required
                                       class="w-4 h-4 text-dark-turquoise border-gray-300 rounded focus:ring-dark-turquoise mt-1">
                                <span class="ml-2 text-xs text-gray-700">
                                    He leído y acepto la
                                    <a href="{{ route('policy.show', 'politica-privacidad') }}" target="_blank" class="text-dark-turquoise hover:underline">Política de Privacidad</a>
                                    y los
                                    <a href="{{ route('policy.show', 'terminos-condiciones') }}" target="_blank" class="text-dark-turquoise hover:underline">Términos del Servicio</a>
                                    *
                                </span>
                            </label>
                            @error('accept_terms')
                                <p class="text-red-500 text-xs mt-1 ml-6">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="btn-primary inline-block w-full px-6 py-3 bg-gray-orange hover:bg-gray-brown text-white rounded-full font-spartan font-semibold text-sm tracking-wider uppercase mb-3">
                            CONFIRMAR PEDIDO
                        </button>

                        <a href="{{ route('carrito.index') }}" class="block text-center text-sm text-gray-brown hover:text-dark-turquoise transition-colors">
                            ← Volver al carrito
                        </a>
                    </div>
                </div>

            </div>
        </form>

    </div>
</section>

@endsection

@push('scripts')
<script>
    // Generate unique transaction ID for this order
    const clientTransactionId = 'IM-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);

    window.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('checkout-form');
        const transferRadio = document.getElementById('transfer-radio');
        const transferDetails = document.getElementById('transfer-details');
        const paymentRadios = document.querySelectorAll('input[name="payment_method"]');

        const sameAsBillingCheckbox = document.getElementById('same_as_billing');
        const shippingSection = document.getElementById('shipping_section');

        const billingProvinciaSelect = document.getElementById('billing_provincia');
        const billingCantonSelect = document.getElementById('billing_canton');
        const billingParroquiaSelect = document.getElementById('billing_parroquia');

        const shippingProvinciaSelect = document.getElementById('shipping_provincia');
        const shippingCantonSelect = document.getElementById('shipping_canton');
        const shippingParroquiaSelect = document.getElementById('shipping_parroquia');

        // Function to update shipping cost
        async function updateShippingCost(provincia, canton, parroquia) {
            if (!provincia || !canton || !parroquia) {
                return;
            }

            try {
                const response = await fetch(`{{ route('checkout.shipping-cost-zone') }}?provincia=${encodeURIComponent(provincia)}&canton=${encodeURIComponent(canton)}&parroquia=${encodeURIComponent(parroquia)}`);
                const data = await response.json();

                if (data.success) {
                    // Update the summary totals
                    document.getElementById('summary-subtotal').textContent = '$' + data.subtotal.toFixed(2);
                    document.getElementById('summary-shipping').textContent = '$' + data.cost.toFixed(2);
                    document.getElementById('summary-tax').textContent = '$' + data.tax.toFixed(2);
                    document.getElementById('summary-total').textContent = '$' + data.total.toFixed(2);
                }
            } catch (error) {
                console.error('Error fetching shipping cost:', error);
            }
        }

        // Toggle shipping section when checkbox changes
        sameAsBillingCheckbox.addEventListener('change', function() {
            if (this.checked) {
                shippingSection.classList.add('hidden');
                // Clear shipping form required attributes when hidden
                toggleShippingRequired(false);
            } else {
                shippingSection.classList.remove('hidden');
                // Add required attributes when visible
                toggleShippingRequired(true);
            }
        });

        // Toggle required attribute for shipping fields
        function toggleShippingRequired(required) {
            const shippingFields = [
                document.getElementById('shipping_name'),
                document.getElementById('shipping_address'),
                shippingProvinciaSelect,
                shippingCantonSelect,
                shippingParroquiaSelect,
                document.getElementById('shipping_zip'),
                document.getElementById('shipping_country')
            ];

            shippingFields.forEach(field => {
                if (field) {
                    if (required) {
                        field.setAttribute('required', 'required');
                    } else {
                        field.removeAttribute('required');
                    }
                }
            });
        }

        // Initialize shipping fields as not required since checkbox is checked by default
        toggleShippingRequired(false);

        // Cascading dropdowns for BILLING: Provincia -> Canton
        billingProvinciaSelect.addEventListener('change', async function() {
            const provincia = this.value;

            // Reset canton and parroquia
            billingCantonSelect.innerHTML = '<option value="">Seleccionar cantón...</option>';
            billingCantonSelect.disabled = !provincia;
            billingParroquiaSelect.innerHTML = '<option value="">Seleccionar parroquia...</option>';
            billingParroquiaSelect.disabled = true;

            if (!provincia) {
                return;
            }

            try {
                const response = await fetch(`{{ route('checkout.cantones') }}?provincia=${encodeURIComponent(provincia)}`);
                const cantones = await response.json();

                cantones.forEach(canton => {
                    const option = document.createElement('option');
                    option.value = canton;
                    option.textContent = canton;
                    billingCantonSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Error cargando cantones:', error);
            }
        });

        // Cascading dropdowns for BILLING: Canton -> Parroquia
        billingCantonSelect.addEventListener('change', async function() {
            const provincia = billingProvinciaSelect.value;
            const canton = this.value;

            // Reset parroquia
            billingParroquiaSelect.innerHTML = '<option value="">Seleccionar parroquia...</option>';
            billingParroquiaSelect.disabled = !canton;

            if (!provincia || !canton) {
                return;
            }

            try {
                const response = await fetch(`{{ route('checkout.parroquias') }}?provincia=${encodeURIComponent(provincia)}&canton=${encodeURIComponent(canton)}`);
                const parroquias = await response.json();

                parroquias.forEach(parroquia => {
                    const option = document.createElement('option');
                    option.value = parroquia;
                    option.textContent = parroquia;
                    billingParroquiaSelect.appendChild(option);
                });

                // Update shipping cost based on billing address if same as billing is checked
                if (sameAsBillingCheckbox.checked && parroquias.length > 0) {
                    updateShippingCost(provincia, canton, parroquias[0]);
                }
            } catch (error) {
                console.error('Error cargando parroquias:', error);
            }
        });

        // Update shipping cost when billing parroquia changes (if same as billing)
        billingParroquiaSelect.addEventListener('change', function() {
            if (sameAsBillingCheckbox.checked) {
                const provincia = billingProvinciaSelect.value;
                const canton = billingCantonSelect.value;
                const parroquia = this.value;

                updateShippingCost(provincia, canton, parroquia);
            }
        });

        // Cascading dropdowns for SHIPPING: Provincia -> Canton
        shippingProvinciaSelect.addEventListener('change', async function() {
            const provincia = this.value;

            // Reset canton and parroquia
            shippingCantonSelect.innerHTML = '<option value="">Seleccionar cantón...</option>';
            shippingCantonSelect.disabled = !provincia;
            shippingParroquiaSelect.innerHTML = '<option value="">Seleccionar parroquia...</option>';
            shippingParroquiaSelect.disabled = true;

            if (!provincia) {
                return;
            }

            try {
                const response = await fetch(`{{ route('checkout.cantones') }}?provincia=${encodeURIComponent(provincia)}`);
                const cantones = await response.json();

                cantones.forEach(canton => {
                    const option = document.createElement('option');
                    option.value = canton;
                    option.textContent = canton;
                    shippingCantonSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Error cargando cantones:', error);
            }
        });

        // Cascading dropdowns for SHIPPING: Canton -> Parroquia
        shippingCantonSelect.addEventListener('change', async function() {
            const provincia = shippingProvinciaSelect.value;
            const canton = this.value;

            // Reset parroquia
            shippingParroquiaSelect.innerHTML = '<option value="">Seleccionar parroquia...</option>';
            shippingParroquiaSelect.disabled = !canton;

            if (!provincia || !canton) {
                return;
            }

            try {
                const response = await fetch(`{{ route('checkout.parroquias') }}?provincia=${encodeURIComponent(provincia)}&canton=${encodeURIComponent(canton)}`);
                const parroquias = await response.json();

                parroquias.forEach(parroquia => {
                    const option = document.createElement('option');
                    option.value = parroquia;
                    option.textContent = parroquia;
                    shippingParroquiaSelect.appendChild(option);
                });

                // Update shipping cost based on separate shipping address
                if (!sameAsBillingCheckbox.checked && parroquias.length > 0) {
                    updateShippingCost(provincia, canton, parroquias[0]);
                }
            } catch (error) {
                console.error('Error cargando parroquias:', error);
            }
        });

        // Update shipping cost when shipping parroquia changes
        shippingParroquiaSelect.addEventListener('change', function() {
            if (!sameAsBillingCheckbox.checked) {
                const provincia = shippingProvinciaSelect.value;
                const canton = shippingCantonSelect.value;
                const parroquia = this.value;

                updateShippingCost(provincia, canton, parroquia);
            }
        });

        // Toggle transfer details visibility
        paymentRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'transfer' && this.checked) {
                    transferDetails.classList.remove('hidden');
                } else {
                    transferDetails.classList.add('hidden');
                }
            });
        });

        // Function to save form data to session
        async function saveCheckoutData() {
            const formData = new FormData(form);

            // Check if using billing address for shipping
            const useBillingForShipping = sameAsBillingCheckbox.checked;

            // Get all calculated values from summary (without IVA)
            const subtotalBase = parseFloat(document.getElementById('summary-subtotal').textContent.replace('$', ''));
            const shippingBase = parseFloat(document.getElementById('summary-shipping').textContent.replace('$', ''));
            const tax = parseFloat(document.getElementById('summary-tax').textContent.replace('$', ''));
            const total = parseFloat(document.getElementById('summary-total').textContent.replace('$', ''));

            try {
                const response = await fetch('{{ route("checkout.save-data") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        name: formData.get('customer_name'),
                        email: formData.get('customer_email'),
                        phone: formData.get('customer_phone'),
                        document_type: formData.get('document_type'),
                        document_number: formData.get('document_number'),
                        // Use billing address if checkbox is checked, otherwise use shipping fields
                        address: useBillingForShipping ? formData.get('billing_address') : formData.get('shipping_address'),
                        provincia: useBillingForShipping ? formData.get('billing_provincia') : formData.get('shipping_provincia'),
                        canton: useBillingForShipping ? formData.get('billing_canton') : formData.get('shipping_canton'),
                        parroquia: useBillingForShipping ? formData.get('billing_parroquia') : formData.get('shipping_parroquia'),
                        city: useBillingForShipping ? formData.get('billing_parroquia') : formData.get('shipping_parroquia'),
                        state: useBillingForShipping ? formData.get('billing_provincia') : formData.get('shipping_provincia'),
                        zip: useBillingForShipping ? (formData.get('billing_zip') || 'N/A') : (formData.get('shipping_zip') || 'N/A'),
                        country: useBillingForShipping ? (formData.get('billing_country') || 'Ecuador') : (formData.get('shipping_country') || 'Ecuador'),
                        notes: formData.get('notes'),
                        newsletter_subscription: formData.get('newsletter_subscription') ? true : false,
                        social_media_consent: formData.get('social_media_consent') ? true : false,
                        client_transaction_id: clientTransactionId,
                        // Send calculated values from summary
                        subtotal_base: subtotalBase,
                        shipping_base: shippingBase,
                        tax: tax,
                        total: total
                    })
                });
                return await response.json();
            } catch (error) {
                console.error('Error saving checkout data:', error);
                return { success: false };
            }
        }

        // Intercept form submission
        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            // Validate form
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            const paymentMethod = form.querySelector('input[name="payment_method"]:checked').value;

            if (paymentMethod === 'payphone') {
                // Save data to session
                const result = await saveCheckoutData();

                if (result.success) {
                    // Redirect to payment page
                    window.location.href = '{{ route("checkout.payment") }}';
                } else {
                    alert('Error al guardar los datos. Por favor intenta nuevamente.');
                }
            } else if (paymentMethod === 'transfer') {
                // Submit form normally for bank transfer
                form.submit();
            }
        });

        // Store client transaction ID in hidden field
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'client_transaction_id';
        hiddenInput.value = clientTransactionId;
        form.appendChild(hiddenInput);

        // Trigger change events on page load if values are pre-selected (for old() values)
        if (provinciaSelect.value) {
            provinciaSelect.dispatchEvent(new Event('change'));
        }
    });
</script>
@endpush
