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
