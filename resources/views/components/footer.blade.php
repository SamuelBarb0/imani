<footer class="bg-dark-turquoise text-white py-4">
  <div class="container mx-auto px-6 max-w-7xl">
    <div class="flex flex-col md:flex-row items-center justify-between gap-8">

      <!-- Left Column: Policy Links -->
      <div class="text-center md:text-left order-2 md:order-1">
        <div class="flex flex-col gap-2.5 text-xs">
          <a href="{{ route('home') }}" class="hover:text-gray-orange transition uppercase">INICIO</a>
          <a href="{{ route('policy.show', 'politica-envios') }}" class="hover:text-gray-orange transition uppercase">POLÍTICA DE ENVÍOS</a>
          <a href="{{ route('policy.show', 'politica-privacidad') }}" class="hover:text-gray-orange transition uppercase">POLÍTICA DE PRIVACIDAD</a>
          <a href="{{ route('policy.show', 'politica-cookies') }}" class="hover:text-gray-orange transition uppercase">POLÍTICA DE COOKIES</a>
          <a href="{{ route('policy.show', 'terminos-condiciones') }}" class="hover:text-gray-orange transition uppercase">TÉRMINOS DEL SERVICIO</a>
        </div>
      </div>

      <!-- Center Column: Social + Copyright -->
      <div class="flex flex-col items-center justify-center gap-4 order-1 md:order-2">
        <div class="flex items-center justify-center space-x-8">
          <a href="{{ config('site.social.instagram') }}" target="_blank" class="hover:text-gray-orange hover:scale-110 transition-all text-3xl" aria-label="Instagram">
            <i class="fa-brands fa-instagram"></i>
          </a>
          <a href="mailto:{{ config('site.email') }}" class="hover:text-gray-orange hover:scale-110 transition-all text-3xl" aria-label="Email">
            <i class="fa-regular fa-envelope"></i>
          </a>
          <a href="{{ \App\Helpers\ContentHelper::getWhatsAppLink() }}" target="_blank" class="hover:text-gray-orange hover:scale-110 transition-all text-3xl" aria-label="WhatsApp">
            <i class="fa-brands fa-whatsapp"></i>
          </a>
        </div>
        <div class="text-center text-sm opacity-90">
          © 2025 Imani Magnets, all rights reserved
        </div>
      </div>

      <!-- Right Column: Logo -->
      <div class="flex justify-center items-center order-3">
        <a href="{{ route('home') }}">
          <img src="{{ asset('images/IMG-20251016-WA0034.png') }}" alt="Imani Magnets" class="h-32 md:h-40 w-auto hover:opacity-80 transition-opacity cursor-pointer">
        </a>
      </div>

    </div>
  </div>
</footer>
