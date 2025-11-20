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

    @php
        // Get courier tracking URL if available
        $courierModel = null;
        $trackingLink = null;

        if ($order->courier) {
            $courierModel = \App\Models\Courier::where('name', $order->courier)->first();

            if ($courierModel && $courierModel->tracking_url) {
                // Replace {tracking_number} placeholder with actual tracking number
                $trackingLink = str_replace('{tracking_number}', $order->tracking_number, $courierModel->tracking_url);
            }
        }
    @endphp

    @if($trackingLink)
    <div style="margin: 15px 0; text-align: center;">
        <a href="{{ $trackingLink }}" style="display: inline-block; padding: 12px 24px; background-color: #12463c; color: white; text-decoration: none; border-radius: 5px; font-weight: bold;" target="_blank">
            Rastrear mi pedido
        </a>
    </div>
    <p style="margin: 5px 0 20px 0; color: #666; font-size: 13px; line-height: 1.6; text-align: center;">
        <em>Haz clic en el botón para ver el estado de tu envío</em>
    </p>
    @else
    <p style="margin: 5px 0 20px 0; color: #666; font-size: 13px; line-height: 1.6;">
        <em>Ingresa el número de seguimiento en la página del courier para rastrear tu pedido.</em>
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
