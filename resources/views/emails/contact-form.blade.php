@extends('emails.layouts.base')

@section('content')

<!-- Step Indicator -->
<table style="width: 100%; margin-bottom: 30px;" cellpadding="0" cellspacing="0">
    <tr>
        <td style="text-align: center;">
            <img src="{{ asset('images/emails/thank-you-for-your-message.png') }}" alt="Indicadores de proceso" style="max-width: 100%; height: auto; display: block; margin: 0 auto;">
        </td>
    </tr>
</table>

<!-- Message -->
<div style="background-color: white; padding: 30px; border-radius: 8px; margin-bottom: 20px;">
    <p style="margin: 0 0 15px 0; color: #333; line-height: 1.6;">Hola {{ $name }},</p>

    <p style="margin: 0 0 15px 0; color: #333; line-height: 1.6;">¡Gracias por escribirnos. Hemos recibido tu mensaje correctamente y pronto nos pondremos en contacto contigo para responder a tu consulta.</p>

    <p style="margin: 0 0 5px 0; color: #333; line-height: 1.6; font-weight: bold;">Tu consulta:</p>
    <div style="background-color: #f8f8f8; padding: 15px; border-radius: 6px; margin: 20px 0; font-style: italic; color: #555;">
        {{ $userMessage }}
    </div>

    <p style="margin: 0 0 15px 0; color: #333; line-height: 1.6;">Mientras tanto, puedes seguirnos en Instagram <strong>@ImaniMagnets</strong> para descubrir nuevas ideas y colecciones inspiradoras.</p>

    <div style="margin-top: 30px; color: #333;">
        <p style="margin: 0; color: #333; line-height: 1.6;">Un abrazo,<br><strong>Julia</strong></p>
    </div>
</div>
@endsection
