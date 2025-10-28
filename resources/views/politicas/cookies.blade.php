@extends('layouts.app')

@section('content')
<section class="bg-white py-12 md:py-16">
    <div class="container mx-auto px-6 max-w-4xl text-gray-800 leading-relaxed">

        <!-- Encabezado -->
        <h1 class="text-3xl md:text-4xl font-spartan font-bold text-dark-turquoise mb-4">
            POLÍTICA DE COOKIES
        </h1>

        <p class="italic text-gray-600 mb-10">
            Última actualización: Octubre 2025
        </p>

        <!-- Contenido -->
        <div class="space-y-8 text-[17px]">

            <!-- 1. Introducción -->
            <div>
                <h2 class="font-semibold text-dark-turquoise mb-2">1. Introducción</h2>
                <p>
                    En <strong>Imani Magnets</strong> utilizamos cookies y tecnologías similares para mejorar la experiencia 
                    de nuestros usuarios, garantizar el correcto funcionamiento del sitio web y ofrecer contenidos y 
                    servicios personalizados.
                </p>
                <p>
                    Esta política explica qué son las cookies, qué tipo utilizamos, con qué finalidad y cómo 
                    podés gestionarlas.
                </p>
            </div>

            <!-- 2. Qué son las cookies -->
            <div>
                <h2 class="font-semibold text-dark-turquoise mb-2">2. ¿Qué son las cookies?</h2>
                <p>
                    Las cookies son pequeños archivos que se almacenan en tu dispositivo (computadora, teléfono o tableta) 
                    cuando visitas un sitio web.  
                    Permiten que el sitio recuerde tus preferencias de navegación, sesiones iniciadas, idioma seleccionado, 
                    productos añadidos al carrito y otros datos útiles para mejorar tu experiencia.
                </p>
            </div>

            <!-- 3. Tipos de cookies -->
            <div>
                <h2 class="font-semibold text-dark-turquoise mb-4">3. Tipos de cookies que utilizamos</h2>

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-300 rounded-lg text-sm">
                        <thead class="bg-[#F7F6F2] text-dark-turquoise">
                            <tr>
                                <th class="border border-gray-300 px-4 py-2 text-left">Tipo de cookie</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Finalidad</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Ejemplo / Proveedor</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Conservación</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">Estrictamente necesarias</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    Permiten el funcionamiento básico del sitio (carrito, inicio de sesión, seguridad).
                                </td>
                                <td class="border border-gray-300 px-4 py-2">Cookies de sesión (WooCommerce, WordPress)</td>
                                <td class="border border-gray-300 px-4 py-2">Se eliminan al cerrar el navegador</td>
                            </tr>
                            <tr class="bg-[#FAFAF9]">
                                <td class="border border-gray-300 px-4 py-2">De preferencia o personalización</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    Guardan tus preferencias de idioma, país o productos vistos recientemente.
                                </td>
                                <td class="border border-gray-300 px-4 py-2">Plugin de idioma, WordPress</td>
                                <td class="border border-gray-300 px-4 py-2">Hasta 6 meses</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">Analíticas o de rendimiento</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    Nos ayudan a entender cómo los usuarios usan el sitio (páginas más visitadas, tiempo, errores, etc.).
                                </td>
                                <td class="border border-gray-300 px-4 py-2">Google Analytics, Meta Pixel</td>
                                <td class="border border-gray-300 px-4 py-2">Hasta 12 meses</td>
                            </tr>
                            <tr class="bg-[#FAFAF9]">
                                <td class="border border-gray-300 px-4 py-2">Publicitarias o de marketing</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    Permiten mostrarte anuncios relevantes según tus intereses o interacción.
                                </td>
                                <td class="border border-gray-300 px-4 py-2">Meta (Facebook/Instagram), Google Ads</td>
                                <td class="border border-gray-300 px-4 py-2">Hasta 12 meses</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">De terceros</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    Instaladas por servicios externos integrados (pasarelas de pago, mailing, redes sociales).
                                </td>
                                <td class="border border-gray-300 px-4 py-2">PayPhone, Mailchimp</td>
                                <td class="border border-gray-300 px-4 py-2">Según sus políticas</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <p class="mt-4">
                    Las cookies esenciales se instalan automáticamente porque son necesarias para el correcto funcionamiento del sitio.  
                    Las cookies no esenciales (analíticas, publicitarias o de personalización) solo se usan con el 
                    <strong>consentimiento expreso del usuario</strong>, otorgado al aceptar el banner o configurador de cookies al ingresar.
                </p>
            </div>

            <!-- 4. Base legal -->
            <div>
                <h2 class="font-semibold text-dark-turquoise mb-2">4. Base legal para el uso de cookies</h2>
                <p>
                    La instalación de cookies no esenciales se basa en el consentimiento previo y explícito del usuario.  
                    Este consentimiento puede ser retirado en cualquier momento mediante el panel de configuración o desde las 
                    opciones del navegador.
                </p>
            </div>

            <!-- 5. Gestión y configuración -->
            <div>
                <h2 class="font-semibold text-dark-turquoise mb-2">5. Gestión y configuración de cookies</h2>
                <p>
                    Podés administrar tus preferencias en cualquier momento desde nuestro panel de configuración de cookies, 
                    disponible en el banner inicial o en el pie de página del sitio.
                </p>
                <p class="mt-2">También podés configurar tu navegador para bloquear, eliminar o limitar las cookies:</p>
                <ul class="list-disc list-inside mt-2 space-y-1">
                    <li><a href="https://support.google.com/chrome/answer/95647" target="_blank" class="text-dark-turquoise hover:underline">Google Chrome</a></li>
                    <li><a href="https://support.mozilla.org/es/kb/habilitar-y-deshabilitar-cookies-sitios-web" target="_blank" class="text-dark-turquoise hover:underline">Mozilla Firefox</a></li>
                    <li><a href="https://support.apple.com/es-es/guide/safari/sfri11471/mac" target="_blank" class="text-dark-turquoise hover:underline">Safari</a></li>
                    <li><a href="https://support.microsoft.com/es-es/help/4027947" target="_blank" class="text-dark-turquoise hover:underline">Microsoft Edge</a></li>
                </ul>
                <p class="mt-2">
                    Tené en cuenta que desactivar algunas cookies puede afectar el funcionamiento o la experiencia del sitio.
                </p>
            </div>

            <!-- 6. Cookies de terceros -->
            <div>
                <h2 class="font-semibold text-dark-turquoise mb-2">6. Cookies de terceros</h2>
                <p>
                    Nuestro sitio puede incluir contenidos o servicios de terceros, como botones de redes sociales, formularios o pasarelas de pago.  
                    Estos terceros pueden instalar sus propias cookies bajo sus políticas de privacidad. Te recomendamos revisarlas:
                </p>
                <ul class="list-disc list-inside mt-2 space-y-1">
                    <li><a href="https://policies.google.com/privacy" target="_blank" class="text-dark-turquoise hover:underline">Google: Política de Privacidad</a></li>
                    <li><a href="https://www.facebook.com/privacy/policy" target="_blank" class="text-dark-turquoise hover:underline">Meta (Facebook e Instagram): Política de Datos</a></li>
                    <li><a href="https://mailchimp.com/legal/privacy/" target="_blank" class="text-dark-turquoise hover:underline">Mailchimp: Política de Privacidad</a></li>
                    <li><a href="https://www.payphone.app/politicas" target="_blank" class="text-dark-turquoise hover:underline">PayPhone: Política de Privacidad</a></li>
                </ul>
            </div>

            <!-- 7. Cambios -->
            <div>
                <h2 class="font-semibold text-dark-turquoise mb-2">7. Cambios en la Política de Cookies</h2>
                <p>
                    Nos reservamos el derecho de modificar esta Política de Cookies en cualquier momento para adaptarla a 
                    cambios normativos o tecnológicos.  
                    Cualquier actualización será publicada en esta misma página con su fecha de entrada en vigor actualizada.
                </p>
            </div>

        </div>
    </div>
</section>
@endsection
