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
    .summary-box {
        background-color: #f8f8f8;
        padding: 20px;
        border-radius: 6px;
        margin: 20px 0;
    }
    .summary-box ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .summary-box li {
        padding: 8px 0;
        color: #333;
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

    <p>¡Gracias por tu interés en nuestros imanes personalizados!</p>

    <p>Hemos recibido tu mensaje y en breve te contactaremos para ampliar la información.</p>

    <p><strong>Resumen de tu solicitud:</strong></p>
    <div class="summary-box">
        <ul>
            <li><strong>Nombre:</strong> {{ $name }}</li>
            <li><strong>Correo Electrónico:</strong> {{ $email }}</li>
            <li><strong>Teléfono:</strong> {{ $phone }}</li>
            <li><strong>Cantidad de Imanes:</strong> {{ $quantity }}</li>
            <li><strong>Fecha para cuando lo necesites:</strong> {{ $deadline }}</li>
            @if($comment)
            <li><strong>Comentario:</strong> {{ $comment }}</li>
            @endif
        </ul>
    </div>

    <p>Nos entusiasma la posibilidad de colaborar contigo y llevar juntos recuerdos únicos a más personas.</p>

    <div class="signature">
        <p>Un abrazo,<br><strong>Julia</strong></p>
    </div>
</div>
@endsection
