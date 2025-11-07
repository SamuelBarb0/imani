<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Corinthia:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        .header {
            background-color: #0f3d35;
            padding: 20px;
            text-align: right;
        }
        .header img {
            max-width: 120px;
            height: auto;
        }
        .content {
            padding: 30px 20px;
            background-color: #e8e4dc;
        }
        .title {
            font-family: 'Corinthia', cursive;
            font-size: 48px;
            color: #5c533b;
            text-align: center;
            margin: 0 0 30px 0;
            font-weight: normal;
        }
        .step-indicator {
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin-bottom: 30px;
        }
        .step {
            text-align: center;
            flex: 1;
        }
        .step-number {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-weight: bold;
            font-size: 20px;
        }
        .step-number.active {
            background-color: #0f3d35;
            color: white;
        }
        .step-number.inactive {
            background-color: #b8a98a;
            color: white;
        }
        .step-text {
            font-size: 12px;
            color: #5c533b;
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
        .important {
            font-weight: bold;
            color: #0f3d35;
        }
        .order-number {
            font-weight: bold;
            color: #0f3d35;
        }
        .tracking-box {
            background-color: #f8f8f8;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
            border-left: 4px solid #0f3d35;
        }
        .tracking-box p {
            margin: 8px 0;
        }
        .tracking-number {
            font-family: monospace;
            font-size: 16px;
            font-weight: bold;
            color: #0f3d35;
            background-color: white;
            padding: 8px 12px;
            border-radius: 4px;
            display: inline-block;
        }
        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .product-table th {
            background-color: #f8f8f8;
            padding: 12px;
            text-align: left;
            border-bottom: 2px solid #ddd;
            font-weight: 600;
            color: #333;
        }
        .product-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        .totals {
            text-align: right;
            margin-top: 20px;
        }
        .totals .row {
            display: flex;
            justify-content: flex-end;
            padding: 8px 0;
        }
        .totals .label {
            margin-right: 20px;
            font-weight: 600;
        }
        .totals .total-row {
            border-top: 2px solid #0f3d35;
            padding-top: 12px;
            margin-top: 8px;
            font-weight: bold;
            font-size: 18px;
        }
        .signature {
            margin-top: 30px;
            color: #333;
        }
        .footer {
            background-color: #0f3d35;
            padding: 20px;
            text-align: center;
        }
        .social-icons {
            margin-bottom: 10px;
        }
        .social-icons a {
            display: inline-block;
            margin: 0 8px;
            color: white;
            text-decoration: none;
        }
        .copyright {
            color: #ccc;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <img src="{{ asset('images/IMG-20251016-WA0034.jpg') }}" alt="Imani Magnets" />
        </div>

        <!-- Content -->
        <div class="content">
            <h1 class="title">¡Tu pedido esta en camino!</h1>

            <!-- Step Indicator -->
            <div class="step-indicator">
                <div class="step">
                    <div class="step-number inactive">1</div>
                    <div class="step-text">Pedido<br>realizado</div>
                </div>
                <div class="step">
                    <div class="step-number inactive">2</div>
                    <div class="step-text">Pago<br>confirmado</div>
                </div>
                <div class="step">
                    <div class="step-number active">3</div>
                    <div class="step-text">Pedido<br>enviado</div>
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
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="social-icons">
                <a href="https://instagram.com/imanimagnets">📷</a>
                <a href="mailto:info@imanimagnets.com">✉️</a>
                <a href="https://wa.me/593985959303">💬</a>
                <a href="https://imanimagnets.com">🌐</a>
            </div>
            <p class="copyright">© {{ date('Y') }} Imani Magnets. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
