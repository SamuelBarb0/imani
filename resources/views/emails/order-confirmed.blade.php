@extends('emails.layouts.base')

@section('content')
   <style>
    .title {
        font-family: 'Corinthia', cursive;
        font-size: 74px;
        color: #00352b;
        text-align: center;
        margin: 0 0 30px 0;
        font-weight: normal;
    }
    .step-indicator {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        gap: 110px;
    }
    .step {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 1;
    }
    .step-number {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 18px;
        flex-shrink: 0;
    }
    .step-number.active {
        background-color: #00352b;
        color: white;
    }
    .step-number.inactive {
        background-color: #c2b59b;
        color: white;
    }
    .step-text {
        font-size: 11px;
        color: #5c533b;
        line-height: 1.3;
        text-align: left;
    }
    .message-box {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    .message-box p {
        margin: 0 0 15px 0;
        color: #333;
        line-height: 1.6;
    }
    .order-number {
        font-weight: bold;
        color: #0f3d35;
    }
    .product-table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }
    .product-table th {
        background-color: #f8f8f8;
        padding: 12px;
        text-align: left;
        border-bottom: 2px solid #ddd;
        font-weight: 600;
        color: #333;
    }
    .product-table td {
        padding: 12px;
        border-bottom: 1px solid #eee;
    }
    .product-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 4px;
    }
    .totals {
        text-align: right;
        margin-top: 20px;
    }
    .totals .row {
        display: flex;
        justify-content: flex-end;
        padding: 8px 0;
    }
    .totals .label {
        margin-right: 20px;
        font-weight: 600;
    }
    .totals .total-row {
        border-top: 2px solid #0f3d35;
        padding-top: 12px;
        margin-top: 8px;
        font-weight: bold;
        font-size: 18px;
    }
    .signature {
        margin-top: 30px;
        color: #333;
    }
</style>

<h1 class="title">¡Gracias por tu compra!</h1>

<!-- Step Indicator -->
<div class="step-indicator">
    <div class="step">
        <div class="step-number inactive">1</div>
        <div class="step-text">Pedido<br/>realizado</div>
    </div>
    <div class="step">
        <div class="step-number active">2</div>
        <div class="step-text">Pago<br/>confirmado</div>
    </div>
    <div class="step">
        <div class="step-number inactive">3</div>
        <div class="step-text">Pedido<br/>enviado</div>
    </div>
</div>

<!-- Message -->
<div class="message-box">
    <p>Hola {{ $order->customer_name }},</p>

    <p>¡Gracias por tu pedido en Imani Magnets!</p>

    <p>Nos alegra que hayas elegido nuestros imanes para dar vida a tus recuerdos.</p>

    <p class="order-number">Número del pedido: [{{ $order->order_number }}]</p>

    <div style="display: flex; justify-content: space-between; margin: 20px 0;">
        <div>
            <p style="margin: 0 0 5px 0;"><strong>Dirección de entrega:</strong></p>
            <p style="margin: 0;">{{ $order->customer_name }}</p>
            <p style="margin: 0;">{{ $order->shipping_address }}</p>
            <p style="margin: 0;">{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}</p>
            <p style="margin: 0;">{{ $order->shipping_country }}</p>
        </div>
        <div>
            <p style="margin: 0 0 5px 0;"><strong>Medio de pago:</strong></p>
            <p style="margin: 0;">{{ ucfirst($order->payment_method) }}</p>
        </div>
    </div>

    <!-- Product Table -->
    <table class="product-table">
        <thead>
            <tr>
                <th colspan="2">Producto</th>
                <th>Cantidad</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td style="width: 80px;">
                    @if($item->images && count($item->images) > 0)
                        <img src="{{ asset('storage/' . $item->images[0]) }}" alt="{{ $item->product_name }}" class="product-image">
                    @endif
                </td>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ number_format($item->subtotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totals -->
    <div class="totals">
        <div class="row">
            <span class="label">Subtotal:</span>
            <span>${{ number_format($order->subtotal, 2) }}</span>
        </div>
        <div class="row">
            <span class="label">IVA:</span>
            <span>${{ number_format($order->subtotal * 0.15, 2) }}</span>
        </div>
        <div class="row">
            <span class="label">Envío:</span>
            <span>${{ number_format($order->shipping_cost, 2) }}</span>
        </div>
        <div class="row total-row">
            <span class="label">Total:</span>
            <span>${{ number_format($order->total, 2) }}</span>
        </div>
    </div>

    <div class="signature">
        <p>En cuanto tu pedido esté listo para envío, te lo notificaremos por correo con el número de seguimiento.</p>
        <p>Con cariño,<br><strong>Julia</strong></p>
    </div>
</div>
@endsection
