<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Imani Magnets - De Momentos a Imanes')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;500;600;700&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Custom Fonts - Above the Beyond -->
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">

    <!-- Vite + Tailwind CSS Compilado -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Button hover effects */
        .btn-primary {
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(0, 0, 0, 0.1);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-primary:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-primary:hover {
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 10px 25px -5px rgba(92, 83, 59, 0.4), 0 8px 10px -6px rgba(92, 83, 59, 0.3);
        }
    </style>

    @stack('styles')
</head>
<body class="font-sans bg-white text-gray-800">
    <!-- Test Mode Banner -->
    <div class="bg-gradient-to-r from-yellow-400 via-orange-500 to-red-500 text-white text-center py-3 shadow-lg relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-10 animate-pulse"></div>
        <div class="relative z-10 flex items-center justify-center gap-3">
            <svg class="w-5 h-5 animate-bounce" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <span class="font-spartan text-sm font-bold tracking-widest uppercase">
                ⚠️ MODO PRUEBAS - Sitio en Desarrollo ⚠️
            </span>
            <svg class="w-5 h-5 animate-bounce" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
        </div>
    </div>

    <!-- Top Banner -->
    <div class="bg-dark-turquoise text-white text-center py-2.5 text-xs font-medium tracking-widest uppercase">
        ENVIOS GRATIS A PARTIR DE $50
    </div>

    <!-- Navigation -->
    @include('components.navbar')

    <!-- Main Content -->
    <main class="min-h-screen pb-20">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('components.footer')

    @stack('scripts')
</body>
</html>
