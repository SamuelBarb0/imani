<footer class="bg-dark-turquoise text-white py-10">
    <div class="container mx-auto px-6">
        <!-- Footer Navigation -->
        <div class="text-center text-xs mb-8">
            <div class="flex flex-wrap justify-center items-center gap-x-3 gap-y-2">
                <a href="{{ url('/') }}" class="hover:text-gray-orange transition">INICIO</a>
                <span class="text-white/50">|</span>
                <a href="{{ url('personalizados') }}" class="hover:text-gray-orange transition">PERSONALIZADOS</a>
                <span class="text-white/50">|</span>
                <a href="{{ url('colecciones') }}" class="hover:text-gray-orange transition">COLECCIONES</a>
                <span class="text-white/50">|</span>
                <a href="{{ url('mayoristas') }}" class="hover:text-gray-orange transition">MAYORISTAS</a>
                <span class="text-white/50">|</span>
                <a href="{{ url('gift-card') }}" class="hover:text-gray-orange transition">GIFT CARD</a>
                <span class="text-white/50">|</span>
                <a href="{{ url('contacto') }}" class="hover:text-gray-orange transition">CONTACTO</a>
                <span class="text-white/50">|</span>
                <a href="{{ url('faq') }}" class="hover:text-gray-orange transition">FAQ</a>
                <span class="text-white/50">|</span>
                <a href="{{ url('politica-devolucion') }}" class="hover:text-gray-orange transition">POLÍTICA DE DEVOLUCIÓN</a>
                <span class="text-white/50">|</span>
                <a href="{{ url('politica-privacidad') }}" class="hover:text-gray-orange transition">POLÍTICA DE PRIVACIDAD</a>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="flex flex-col md:flex-row justify-between items-center pt-6 border-t border-white/20 gap-6">
            <!-- Social Icons -->
            <div class="flex items-center space-x-6">
                <a href="mailto:info@imanimagnets.com" class="hover:-translate-y-1 transition" aria-label="Email">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                        <path d="m2 7 10 7 10-7"></path>
                    </svg>
                </a>
                <a href="https://instagram.com/imanimagnets" target="_blank" class="hover:-translate-y-1 transition" aria-label="Instagram">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                        <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                        <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                    </svg>
                </a>
                <a href="https://wa.me/593999999999" target="_blank" class="hover:-translate-y-1 transition" aria-label="WhatsApp">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                    </svg>
                </a>
            </div>

            <!-- Logo -->
            <div>
                <img src="{{ asset('images/IMG-20251016-WA0034.jpg') }}" alt="Imani Magnets" class="h-20 ">
            </div>
        </div>
    </div>
</footer>
