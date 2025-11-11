<footer class="bg-dark-turquoise text-white py-5">
  <div class="container mx-auto px-6 max-w-7xl">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12 items-end">

      <!-- Left Column: Policy Links -->
      <div class="text-left">
        <div class="flex flex-col gap-2.5 text-xs">
          <a href="{{ route('home') }}" class="hover:text-gray-orange transition uppercase">INICIO</a>
          <a href="{{ route('politica.envios') }}" class="hover:text-gray-orange transition uppercase">POLÍTICA DE ENVÍOS</a>
          <a href="{{ route('politica.privacidad') }}" class="hover:text-gray-orange transition uppercase">POLÍTICA DE PRIVACIDAD</a>
          <a href="{{ route('politica.cookies') }}" class="hover:text-gray-orange transition uppercase">POLÍTICA DE COOKIES</a>
          <a href="{{ route('politica.terminos') }}" class="hover:text-gray-orange transition uppercase">TÉRMINOS DEL SERVICIO</a>
        </div>
      </div>

      <!-- Center Column: Social + Copyright (alineada abajo en desktop) -->
      <div class="flex flex-col items-center justify-center gap-4 md:self-end">
        <div class="flex items-center justify-center space-x-8">
          <a href="https://instagram.com/imanimagnets" target="_blank" class="hover:text-gray-orange hover:scale-110 transition-all text-3xl" aria-label="Instagram">
            <i class="fa-brands fa-instagram"></i>
          </a>
          <a href="mailto:info@imanimagnets.com" class="hover:text-gray-orange hover:scale-110 transition-all text-3xl" aria-label="Email">
            <i class="fa-regular fa-envelope"></i>
          </a>
          <a href="https://wa.me/593999999999" target="_blank" class="hover:text-gray-orange hover:scale-110 transition-all text-3xl" aria-label="WhatsApp">
            <i class="fa-brands fa-whatsapp"></i>
          </a>
        </div>
        <div class="text-center text-sm opacity-90">
          © 2025 Imani Magnets, all rights reserved
        </div>
      </div>

      <!-- Right Column: Logo -->
      <div class="flex justify-center md:justify-end items-end">
        <img src="{{ asset('images/IMG-20251016-WA0034.jpg') }}" alt="Imani Magnets" class="h-40 w-auto">
      </div>

    </div>
  </div>
</footer>
