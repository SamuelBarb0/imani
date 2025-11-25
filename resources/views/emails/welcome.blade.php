@extends('emails.layouts.base')

@section('content')

<div style="text-align: center; margin: 0 0 30px 0;">
    <img src="{{ asset('images/emails/welcome-to-imani.png') }}" alt="¡Bienvenido a Imani!" style="max-width: 100%; height: auto;">
</div>

<!-- Message -->
<div style="background-color: white; padding: 30px; border-radius: 8px; margin-bottom: 20px;">
    <p style="margin: 0 0 15px 0; color: #333; line-height: 1.6;">Hola <strong>{{ $user->name }}</strong>,</p>

    <p style="margin: 0 0 15px 0; color: #333; line-height: 1.6;">¡Gracias por tu compra! Estamos emocionados de que formes parte de la familia Imani Magnets. 🎉</p>

    <p style="margin: 0 0 15px 0; color: #333; line-height: 1.6;">Hemos creado automáticamente una cuenta para que puedas hacer seguimiento de tus pedidos y disfrutar de todos los beneficios de ser parte de nuestra comunidad.</p>

    @if($orderNumber)
    <div style="background-color: #f8f8f8; padding: 20px; border-radius: 6px; margin: 20px 0; border-left: 4px solid #00352b;">
        <p style="margin: 8px 0; color: #333; font-weight: bold;">Tu Pedido</p>
        <p style="margin: 8px 0; color: #00352b; font-weight: bold; font-size: 16px;">Número de pedido: {{ $orderNumber }}</p>
        <p style="margin: 8px 0; color: #333;">Puedes ver el estado de tu pedido en cualquier momento ingresando a tu cuenta.</p>
    </div>
    @endif

    <p style="margin: 0 0 5px 0; color: #333; line-height: 1.6; font-weight: bold;">Tus Credenciales de Acceso:</p>
    <div style="background-color: #e8e4dc; padding: 15px; border-radius: 6px; margin: 20px 0; font-family: monospace;">
        <p style="margin: 8px 0; color: #333;"><strong>Email:</strong> {{ $user->email }}</p>
        <p style="margin: 8px 0; color: #333;"><strong>Contraseña temporal:</strong> {{ $password }}</p>
    </div>

    <p style="margin: 0 0 15px 0; color: #c2b59b; font-size: 14px; line-height: 1.6;"><strong>⚠️ Importante:</strong> Por seguridad, te recomendamos cambiar tu contraseña después de iniciar sesión por primera vez.</p>

    <table style="width: 100%; margin: 20px 0;" cellpadding="0" cellspacing="0">
        <tr>
            <td style="text-align: center;">
                <a href="{{ route('user.profile') }}" style="display: inline-block; background-color: #00352b; color: white; padding: 14px 40px; text-decoration: none; border-radius: 6px; font-weight: 600; text-align: center;">Acceder a Mi Cuenta</a>
            </td>
        </tr>
    </table>

    <p style="margin: 0 0 5px 0; color: #333; line-height: 1.6;">En tu cuenta podrás:</p>
    <p style="margin: 0 0 15px 0; margin-left: 20px; color: #333; line-height: 1.6;">
        ✨ Hacer seguimiento de tus pedidos<br>
        📦 Ver el historial de compras<br>
        👤 Actualizar tu información personal<br>
        🔐 Cambiar tu contraseña
    </p>

    <p style="margin: 0 0 15px 0; color: #333; line-height: 1.6;">Si tienes alguna pregunta sobre tu pedido o necesitas ayuda, no dudes en contactarnos por WhatsApp al <strong>{{ config('site.whatsapp.number') }}</strong> o por correo a <strong>{{ config('site.email') }}</strong>.</p>

    <p style="margin: 0 0 15px 0; color: #333; line-height: 1.6;">Síguenos en Instagram <strong>@ImaniMagnets</strong> para inspirarte con ideas creativas y ver cómo otros clientes disfrutan de sus imanes personalizados.</p>

    <div style="margin-top: 30px; color: #333;">
        <p style="margin: 0; color: #333; line-height: 1.6;">Con cariño,<br><strong>Julia.</strong></p>
    </div>
</div>
@endsection
