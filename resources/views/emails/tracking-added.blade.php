@extends('emails.layouts.base')

@section('content')

<!-- Step Indicator -->
<table style="width: 100%; margin-bottom: 30px;" cellpadding="0" cellspacing="0">
    <tr>
        <td style="text-align: center;">
            <img src="{{ asset('images/emails/your-order-is-on-your-way.png') }}" alt="Indicadores de proceso" style="max-width: 100%; height: auto; display: block; margin: 0 auto;">
        </td>
    </tr>
</table>

<!-- Message -->
<div style="background-color: white; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
    <p style="margin: 0 0 15px 0; color: #333; line-height: 1.6;">Hola {{ $order->customer_name }},</p>

    <p style="margin: 0 0 15px 0; color: #333; line-height: 1.6;">¡Buenas noticias! Tu pedido ha sido enviado y pronto estará contigo.</p>

    @if($order->courier)
    <p style="margin: 20px 0 5px 0; color: #333; line-height: 1.6;"><strong>Courier:</strong> {{ \App\Models\Order::getCouriers()[$order->courier] ?? $order->courier }}</p>
    @endif

    <p style="margin: 5px 0 5px 0; color: #333; line-height: 1.6;"><strong>Número de seguimiento:</strong> {{ $order->tracking_number }}</p>

    @if($order->tracking_url)
    <p style="margin: 5px 0 20px 0; color: #333; line-height: 1.6;">
        <strong>Rastrea tu pedido:</strong>
        <a href="{{ $order->tracking_url }}" style="color: #12463c; text-decoration: underline;" target="_blank">
            Ver seguimiento detallado
        </a>
    </p>
    @endif

    <p style="margin: 0 0 15px 0; color: #333; line-height: 1.6;">Esperamos que disfrutes mucho tus imanes y que llenen de alegría tu espacio.</p>

    <p style="margin: 0 0 15px 0; color: #333; line-height: 1.6;">Nos encantaría ver tus imanes en acción. Si los compartes en redes, etiquétanos con <strong>#ImaniMagnets</strong> o menciona nuestra cuenta <strong>@ImaniMagnets</strong>.</p>

    <p style="margin: 0 0 15px 0; color: #333; line-height: 1.6;">Gracias por apoyar un proyecto hecho con dedicación y mucho cariño.</p>

    <div style="margin-top: 30px; color: #333;">
        <p style="margin: 0; color: #333; line-height: 1.6;">Con cariño,<br><strong>Julia</strong></p>
    </div>
</div>
@endsection
