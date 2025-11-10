@extends('emails.layouts.base')

@section('content')
<style>
    .title {
        font-family: 'Corinthia', cursive;
        font-size: 48px;
        color: #00352b;
        text-align: center;
        margin: 0 0 30px 0;
        font-weight: normal;
    }
    .message-box {
        background-color: white;
        padding: 30px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    .message-box p {
        margin: 0 0 15px 0;
        color: #333;
        line-height: 1.6;
    }
    .user-message {
        background-color: #f8f8f8;
        padding: 15px;
        border-radius: 6px;
        margin: 20px 0;
        font-style: italic;
        color: #555;
    }
    .signature {
        margin-top: 30px;
        color: #333;
    }
</style>

<h1 class="title">¡Gracias por tu mensaje!</h1>

<!-- Message -->
<div class="message-box">
    <p>Hola {{ $name }},</p>

    <p>¡Gracias por escribirnos. Hemos recibido tu mensaje correctamente y pronto nos pondremos en contacto contigo para responder a tu consulta.</p>

    <p><strong>Tu consulta:</strong></p>
    <div class="user-message">
        {{ $userMessage }}
    </div>

    <p>Mientras tanto, puedes seguirnos en Instagram <strong>@ImaniMagnets</strong> para descubrir nuevas ideas y colecciones inspiradoras.</p>

    <div class="signature">
        <p>Un abrazo,<br><strong>Julia</strong></p>
    </div>
</div>
@endsection
