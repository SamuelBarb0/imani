@extends('emails.layouts.base')

@section('content')

<!-- Step Indicator -->
<table style="width: 100%; margin-bottom: 30px;" cellpadding="0" cellspacing="0">
    <tr>
        <td style="text-align: center;">
            <img src="{{ asset('images/emails/step-pending-transfer.png') }}" alt="Indicadores de proceso" style="max-width: 100%; height: auto; display: block; margin: 0 auto;">
        </td>
    </tr>
</table>

<!-- Message -->
<div style="background-color: white; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
    <p style="margin: 0 0 15px 0; color: #333; line-height: 1.6;">Hola {{ $order->customer_name }},</p>

    <p style="margin: 0 0 15px 0; color: #333; line-height: 1.6;">¡Gracias por tu pedido en Imani Magnets!</p>

    <p style="margin: 0 0 15px 0; color: #333; line-height: 1.6;">Nos alegra que hayas elegido nuestros imanes para dar vida a tus recuerdos.</p>

    <p style="margin: 0 0 5px 0; color: #333; line-height: 1.6; font-weight: bold;">Importante:</p>
    <p style="margin: 0 0 15px 0; color: #333; line-height: 1.6;">Tu pedido será procesado una vez que hayamos recibido el comprobante de la transferencia. Por favor envíalo a <strong>comprobantes@imanimagnets.com</strong> o vía WhatsApp al <strong>{{ config('site.whatsapp.number') }}</strong>.</p>

    <p style="margin: 0 0 15px 0; color: #0f3d35; line-height: 1.6; font-weight: bold;">Número del pedido: {{ $order->order_number }}</p>

    <!-- Datos Bancarios -->
    <div style="background-color: #f8f8f8; padding: 15px; border-radius: 8px; margin: 20px 0;">
        <p style="margin: 0 0 10px 0; color: #0f3d35; font-weight: bold; font-size: 16px;">Datos Bancarios:</p>
        <p style="margin: 0 0 5px 0; color: #333; line-height: 1.6;"><strong>Banco de Guayaquil S.A.</strong></p>
        <p style="margin: 0 0 5px 0; color: #333; line-height: 1.6;">Nombre: Julia Schulz</p>
        <p style="margin: 0 0 5px 0; color: #333; line-height: 1.6;">Cédula: 1761553880</p>
        <p style="margin: 0; color: #333; line-height: 1.6;">Cuenta de ahorros: 50599480</p>
    </div>

    <!-- Product Table -->
    <table style="width: 100%; border-collapse: collapse; margin: 20px 0;" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th colspan="2" style="background-color: #f8f8f8; padding: 12px; text-align: left; border-bottom: 2px solid #ddd; font-weight: 600; color: #333;">Producto</th>
                <th style="background-color: #f8f8f8; padding: 12px; text-align: left; border-bottom: 2px solid #ddd; font-weight: 600; color: #333;">Cantidad</th>
                <th style="background-color: #f8f8f8; padding: 12px; text-align: left; border-bottom: 2px solid #ddd; font-weight: 600; color: #333;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td style="width: 80px; padding: 12px; border-bottom: 1px solid #eee;">
                    @if($item->images && count($item->images) > 0)
                        <img src="{{ asset('storage/' . $item->images[0]) }}" alt="{{ $item->product_name }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                    @endif
                </td>
                <td style="padding: 12px; border-bottom: 1px solid #eee;">
                    {!! preg_replace('/<span[^>]*>.*?<\/span>/i', '', nl2br($item->product_name)) !!}
                </td>
                <td style="padding: 12px; border-bottom: 1px solid #eee;">{{ $item->quantity }}</td>
                <td style="padding: 12px; border-bottom: 1px solid #eee;">${{ number_format($item->subtotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totals -->
    <table style="width: 100%; margin-top: 20px;" cellpadding="0" cellspacing="0">
        <tr>
            <td style="text-align: right; padding: 8px 0;">
                <span style="margin-right: 20px; font-weight: 600;">Subtotal:</span>
                <span>${{ number_format($order->subtotal, 2) }}</span>
            </td>
        </tr>
        <tr>
            <td style="text-align: right; padding: 8px 0;">
                <span style="margin-right: 20px; font-weight: 600;">Envío:</span>
                <span>${{ number_format($order->shipping_cost, 2) }}</span>
            </td>
        </tr>
        <tr>
            <td style="text-align: right; padding: 8px 0;">
                <span style="margin-right: 20px; font-weight: 600;">IVA (15%):</span>
                <span>${{ number_format(($order->subtotal + $order->shipping_cost) * 0.15, 2) }}</span>
            </td>
        </tr>
        <tr>
            <td style="text-align: right; padding: 12px 0 8px 0; border-top: 2px solid #0f3d35; margin-top: 8px; font-weight: bold; font-size: 18px;">
                <span style="margin-right: 20px;">Total:</span>
                <span>${{ number_format($order->total, 2) }}</span>
            </td>
        </tr>
    </table>

    <div style="margin-top: 30px; color: #333;">
        <p style="margin: 0 0 15px 0; color: #333; line-height: 1.6;">En cuanto recibamos tu pago, te lo confirmaremos por correo y empezaremos la producción de tus imanes.</p>
        <p style="margin: 0; color: #333; line-height: 1.6;">Con cariño,<br><strong>Julia</strong></p>
    </div>
</div>
@endsection
