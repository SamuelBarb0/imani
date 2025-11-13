<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Corinthia:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Open Sans', Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        .header {
            background-color: #00352b;
            padding: 2px 14px;
            text-align: right;
        }
        .header img {
            max-width: 80px;
            height: auto;
        }
        .content {
            background-color: #e8e4dc;
            padding: 40px 30px;
            min-height: 400px;
        }
        .footer {
            background-color: #00352b;
            padding: 25px 20px;
            text-align: center;
        }
        .social-icons {
            margin-bottom: 15px;
        }
        .social-icons a {
            display: inline-block;
            margin: 0 10px;
            text-decoration: none;
            color: #ffffff;
            font-size: 24px;
        }
        .social-icons a:hover {
            color: #c2b59b;
        }
        .footer-text {
            color: #ffffff;
            font-size: 12px;
            margin: 0;
            font-family: 'Open Sans', Arial, sans-serif;
        }
        h1, h2 {
            font-family: 'League Spartan', sans-serif;
        }
        .cursive {
            font-family: 'Corinthia', cursive;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <!-- Header -->
        <div class="header">
            <img src="{{ asset('images/IMG-20251016-WA0034.jpg') }}" alt="Imani Magnets Logo">
        </div>

        <!-- Content Area -->
        <div class="content">
            @yield('content')
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="social-icons">
                <a href="{{ config('site.social.instagram') }}" target="_blank" title="Instagram">
                    <img src="{{ asset('images/instagram2.png') }}" alt="Instagram" style="width: 24px; height: 24px; vertical-align: middle;">
                </a>
                <a href="mailto:{{ config('site.email') }}" title="Email">
                    <img src="{{ asset('images/email2.png') }}" alt="Email" style="width: 36px; height: 36px; vertical-align: middle;">
                </a>
                <a href="{{ \App\Helpers\ContentHelper::getWhatsAppLink() }}" target="_blank" title="WhatsApp">
                    <img src="{{ asset('images/whatsapp2.png') }}" alt="WhatsApp" style="width: 36px; height: 36px; vertical-align: middle;">
                </a>
                <a href="https://imanimagnets.com" target="_blank" title="Website">
                    <img src="{{ asset('images/globe2.png') }}" alt="Website" style="width: 24px; height: 24px; vertical-align: middle;">
                </a>
            </div>
            <p class="footer-text">© {{ date('Y') }} Imani Magnets. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
