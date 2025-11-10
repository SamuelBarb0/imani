@extends('emails.layouts.base')

@section('content')

<h1 style="font-family: 'Corinthia', cursive; font-size: 74px; color: #00352b; text-align: center; margin: 0 0 30px 0; font-weight: normal;">¡Gracias por tu mensaje!</h1>

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
