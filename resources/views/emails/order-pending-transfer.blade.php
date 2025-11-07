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
        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
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
            <h1 class="title">¡Esperamos tu pago!</h1>

            <!-- Step Indicator -->
            <div class="step-indicator">
                <div class="step">
                    <div class="step-number active">1</div>
                    <div class="step-text">Pedido<br>realizado</div>
                </div>
                <div class="step">
                    <div class="step-number inactive">2</div>
                    <div class="step-text">Pago<br>confirmado</div>
                </div>
                <div class="step">
                    <div class="step-number inactive">3</div>
                    <div class="step-text">Pedido<br>enviado</div>
                </div>
            </div>

            <!-- Message -->
            <div class="message-box">
                <p>Hola {{ $order->customer_name }},</p>

                <p>¡Gracias por tu pedido en Imani Magnets!</p>

                <p>Nos alegra que hayas elegido nuestros imanes para dar vida a tus recuerdos.</p>

                <p class="important">Importante:</p>
                <p>Tu pedido será procesado una vez que hayamos recibido el comprobante de la transferencia. Por favor envíalo a <strong>comprobantes@imanimagnets.com</strong> o vía WhatsApp al <strong>+593 98 595 9303</strong>.</p>

                <p class="order-number">Número del pedido: [{{ $order->order_number }}]</p>

                <!-- Product Table -->
                <table class="product-table">
                    <thead>
                        <tr>
                            <th colspan="2">Producto</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td style="width: 80px;">
                                @if($item->images && count($item->images) > 0)
                                    <img src="{{ asset('storage/' . $item->images[0]) }}" alt="{{ $item->product_name }}" class="product-image">
                                @endif
                            </td>
                            <td>{{ $item->product_name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Totals -->
                <div class="totals">
                    <div class="row">
                        <span class="label">Subtotal:</span>
                        <span>${{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="row">
                        <span class="label">IVA:</span>
                        <span>${{ number_format($order->subtotal * 0.15, 2) }}</span>
                    </div>
                    <div class="row">
                        <span class="label">Envío:</span>
                        <span>${{ number_format($order->shipping_cost, 2) }}</span>
                    </div>
                    <div class="row total-row">
                        <span class="label">Total:</span>
                        <span>${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>

                <div class="signature">
                    <p>En cuanto recibamos tu pago, te lo confirmaremos por correo y empezaremos la producción de tus imanes.</p>
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
