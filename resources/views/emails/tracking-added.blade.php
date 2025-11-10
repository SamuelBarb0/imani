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
    .step-indicator {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        gap: 110px;
    }
    .step {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 1;
    }
    .step-number {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 18px;
        flex-shrink: 0;
    }
    .step-number.active {
        background-color: #00352b;
        color: white;
    }
    .step-number.inactive {
        background-color: #c2b59b;
        color: white;
    }
    .step-text {
        font-size: 11px;
        color: #5c533b;
        line-height: 1.3;
        text-align: left;
    }
    .message-box {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    .message-box p {
        margin: 0 0 15px 0;
        color: #333;
        line-height: 1.6;
    }
    .signature {
        margin-top: 30px;
        color: #333;
    }
</style>

<h1 class="title">¡Tu pedido esta en camino!</h1>

<!-- Step Indicator -->
<div class="step-indicator">
    <div class="step">
        <div class="step-number inactive">1</div>
        <div class="step-text">Pedido<br/>realizado</div>
    </div>
    <div class="step">
        <div class="step-number inactive">2</div>
        <div class="step-text">Pago<br/>confirmado</div>
    </div>
    <div class="step">
        <div class="step-number active">3</div>
        <div class="step-text">Pedido<br/>enviado</div>
    </div>
</div>

<!-- Message -->
<div class="message-box">
    <p>Hola {{ $order->customer_name }},</p>

    <p>¡Buenas noticias! Tu pedido ha sido enviado y pronto estará contigo.</p>

    <p style="margin: 20px 0;"><strong>Número de seguimiento:</strong> {{ $order->tracking_number }}</p>

    <p>Esperamos que disfrutes mucho tus imanes y que llenen de alegría tu espacio.</p>

    <p>Nos encantaría ver tus imanes en acción. Si los compartes en redes, etiquétanos con <strong>#ImaniMagnets</strong> o menciona nuestra cuenta <strong>@ImaniMagnets</strong>.</p>

    <p>Gracias por apoyar un proyecto hecho con dedicación y mucho cariño.</p>

    <div class="signature">
        <p>Con cariño,<br><strong>Julia</strong></p>
    </div>
</div>
@endsection
