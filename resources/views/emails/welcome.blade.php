@extends('emails.layouts.base')

@section('content')
<style>
    .title {
        font-family: 'Corinthia', cursive;
        font-size: 74px;
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
    .highlight-box {
        background-color: #f8f8f8;
        padding: 20px;
        border-radius: 6px;
        margin: 20px 0;
        border-left: 4px solid #00352b;
    }
    .highlight-box p {
        margin: 8px 0;
        color: #333;
    }
    .credentials-box {
        background-color: #e8e4dc;
        padding: 15px;
        border-radius: 6px;
        margin: 20px 0;
        font-family: monospace;
    }
    .credentials-box p {
        margin: 8px 0;
        color: #333;
    }
    .cta-button {
        display: inline-block;
        background-color: #00352b;
        color: white !important;
        padding: 14px 40px;
        text-decoration: none;
        border-radius: 6px;
        font-weight: 600;
        margin: 20px 0;
        text-align: center;
    }
    .cta-button:hover {
        background-color: #004d3d;
    }
    .signature {
        margin-top: 30px;
        color: #333;
    }
    .order-number {
        font-weight: bold;
        color: #00352b;
        font-size: 16px;
    }
</style>

<h1 class="title">¡Bienvenido a Imani!</h1>

<!-- Message -->
<div class="message-box">
    <p>Hola <strong>{{ $user->name }}</strong>,</p>

    <p>¡Gracias por tu compra! Estamos emocionados de que formes parte de la familia Imani Magnets. 🎉</p>

    <p>Hemos creado automáticamente una cuenta para que puedas hacer seguimiento de tus pedidos y disfrutar de todos los beneficios de ser parte de nuestra comunidad.</p>

    @if($orderNumber)
    <div class="highlight-box">
        <p><strong>Tu Pedido</strong></p>
        <p class="order-number">Número de pedido: {{ $orderNumber }}</p>
        <p>Puedes ver el estado de tu pedido en cualquier momento ingresando a tu cuenta.</p>
    </div>
    @endif

    <p><strong>Tus Credenciales de Acceso:</strong></p>
    <div class="credentials-box">
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Contraseña temporal:</strong> {{ $password }}</p>
    </div>

    <p style="color: #c2b59b; font-size: 14px;"><strong>⚠️ Importante:</strong> Por seguridad, te recomendamos cambiar tu contraseña después de iniciar sesión por primera vez.</p>

    <center>
        <a href="{{ url('/pruebas/cuenta') }}" class="cta-button">Acceder a Mi Cuenta</a>
    </center>

    <p>En tu cuenta podrás:</p>
    <p style="margin-left: 20px;">
        ✨ Hacer seguimiento de tus pedidos<br>
        📦 Ver el historial de compras<br>
        👤 Actualizar tu información personal<br>
        🔐 Cambiar tu contraseña
    </p>

    <p>Si tienes alguna pregunta sobre tu pedido o necesitas ayuda, no dudes en contactarnos por WhatsApp al <strong>+593 98 595 9303</strong> o por correo a <strong>contacto@imanimagnets.com</strong>.</p>

    <p>Síguenos en Instagram <strong>@ImaniMagnets</strong> para inspirarte con ideas creativas y ver cómo otros clientes disfrutan de sus imanes personalizados.</p>

    <div class="signature">
        <p>Con cariño,<br><strong>Julia y el equipo de Imani Magnets</strong></p>
    </div>
</div>
@endsection
