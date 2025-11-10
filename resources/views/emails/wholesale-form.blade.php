@extends('emails.layouts.base')

@section('content')

<h1 style="font-family: 'Corinthia', cursive; font-size: 48px; color: #00352b; text-align: center; margin: 0 0 30px 0; font-weight: normal;">¡Gracias por tu mensaje!</h1>

<!-- Message -->
<div style="background-color: white; padding: 30px; border-radius: 8px; margin-bottom: 20px;">
    <p style="margin: 0 0 15px 0; color: #333; line-height: 1.6;">Hola {{ $name }},</p>

    <p style="margin: 0 0 15px 0; color: #333; line-height: 1.6;">¡Gracias por tu interés en nuestros imanes personalizados!</p>

    <p style="margin: 0 0 15px 0; color: #333; line-height: 1.6;">Hemos recibido tu mensaje y en breve te contactaremos para ampliar la información.</p>

    <p style="margin: 0 0 5px 0; color: #333; line-height: 1.6; font-weight: bold;">Resumen de tu solicitud:</p>
    <div style="background-color: #f8f8f8; padding: 20px; border-radius: 6px; margin: 20px 0;">
        <table style="width: 100%;" cellpadding="0" cellspacing="0">
            <tr>
                <td style="padding: 8px 0; color: #333;"><strong>Nombre:</strong> {{ $name }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; color: #333;"><strong>Correo Electrónico:</strong> {{ $email }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; color: #333;"><strong>Teléfono:</strong> {{ $phone }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; color: #333;"><strong>Cantidad de Imanes:</strong> {{ $quantity }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; color: #333;"><strong>Fecha para cuando lo necesites:</strong> {{ $deadline }}</td>
            </tr>
            @if($comment)
            <tr>
                <td style="padding: 8px 0; color: #333;"><strong>Comentario:</strong> {{ $comment }}</td>
            </tr>
            @endif
        </table>
    </div>

    <p style="margin: 0 0 15px 0; color: #333; line-height: 1.6;">Nos entusiasma la posibilidad de colaborar contigo y llevar juntos recuerdos únicos a más personas.</p>

    <div style="margin-top: 30px; color: #333;">
        <p style="margin: 0; color: #333; line-height: 1.6;">Un abrazo,<br><strong>Julia</strong></p>
    </div>
</div>
@endsection
