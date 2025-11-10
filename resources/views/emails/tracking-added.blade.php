@extends('emails.layouts.base')

@section('content')

<h1 style="font-family: 'Corinthia', cursive; font-size: 74px; color: #00352b; text-align: center; margin: 0 0 30px 0; font-weight: normal;">¡Tu pedido esta en camino!</h1>

<!-- Step Indicator -->
<table style="width: 100%; margin-bottom: 30px;" cellpadding="0" cellspacing="0">
    <tr>
        <td style="width: 33%; padding: 0 10px;">
            <table cellpadding="0" cellspacing="0" style="width: 100%;">
                <tr>
                    <td style="width: 45px; vertical-align: middle;">
                        <div style="width: 45px; height: 45px; border-radius: 50%; background-color: #c2b59b; color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 18px;">1</div>
                    </td>
                    <td style="padding-left: 10px; vertical-align: middle;">
                        <span style="font-size: 13px; color: #5c533b; line-height: 1.3; font-weight: 600;">Pedido<br/>realizado</span>
                    </td>
                </tr>
            </table>
        </td>
        <td style="width: 33%; padding: 0 10px;">
            <table cellpadding="0" cellspacing="0" style="width: 100%;">
                <tr>
                    <td style="width: 45px; vertical-align: middle;">
                        <div style="width: 45px; height: 45px; border-radius: 50%; background-color: #c2b59b; color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 18px;">2</div>
                    </td>
                    <td style="padding-left: 10px; vertical-align: middle;">
                        <span style="font-size: 13px; color: #5c533b; line-height: 1.3; font-weight: 600;">Pago<br/>confirmado</span>
                    </td>
                </tr>
            </table>
        </td>
        <td style="width: 33%; padding: 0 10px;">
            <table cellpadding="0" cellspacing="0" style="width: 100%;">
                <tr>
                    <td style="width: 45px; vertical-align: middle;">
                        <div style="width: 45px; height: 45px; border-radius: 50%; background-color: #00352b; color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 18px;">3</div>
                    </td>
                    <td style="padding-left: 10px; vertical-align: middle;">
                        <span style="font-size: 13px; color: #5c533b; line-height: 1.3; font-weight: 600;">Pedido<br/>enviado</span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<!-- Message -->
<div style="background-color: white; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
    <p style="margin: 0 0 15px 0; color: #333; line-height: 1.6;">Hola {{ $order->customer_name }},</p>

    <p style="margin: 0 0 15px 0; color: #333; line-height: 1.6;">¡Buenas noticias! Tu pedido ha sido enviado y pronto estará contigo.</p>

    <p style="margin: 20px 0; color: #333; line-height: 1.6;"><strong>Número de seguimiento:</strong> {{ $order->tracking_number }}</p>

    <p style="margin: 0 0 15px 0; color: #333; line-height: 1.6;">Esperamos que disfrutes mucho tus imanes y que llenen de alegría tu espacio.</p>

    <p style="margin: 0 0 15px 0; color: #333; line-height: 1.6;">Nos encantaría ver tus imanes en acción. Si los compartes en redes, etiquétanos con <strong>#ImaniMagnets</strong> o menciona nuestra cuenta <strong>@ImaniMagnets</strong>.</p>

    <p style="margin: 0 0 15px 0; color: #333; line-height: 1.6;">Gracias por apoyar un proyecto hecho con dedicación y mucho cariño.</p>

    <div style="margin-top: 30px; color: #333;">
        <p style="margin: 0; color: #333; line-height: 1.6;">Con cariño,<br><strong>Julia</strong></p>
    </div>
</div>
@endsection
