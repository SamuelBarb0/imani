<nav class="bg-gray-50 border-b border-gray-200">
    <div class="container mx-auto px-6 py-3">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('images/IMG-20251016-WA0031.jpg') }}" alt="Imani Magnets" class="h-30 w-auto">
                </a>
            </div>

            <!-- Navigation Menu - Desktop -->
            <ul class="hidden lg:flex items-center space-x-8 text-xs font-normal tracking-wide uppercase">
                <li><a href="{{ url('personalizados') }}" class="text-gray-700 hover:text-dark-turquoise transition">Personalizados</a></li>
                <li><a href="{{ url('colecciones') }}" class="text-gray-700 hover:text-dark-turquoise transition">Colecciones</a></li>
                <li><a href="{{ url('mayoristas') }}" class="text-gray-700 hover:text-dark-turquoise transition">Mayoristas</a></li>
                <li><a href="{{ url('gift-card') }}" class="text-gray-700 hover:text-dark-turquoise transition">Gift Card</a></li>
                <li><a href="{{ url('contacto') }}" class="text-gray-700 hover:text-dark-turquoise transition">Contacto</a></li>
            </ul>

            <!-- Right Icons -->
            <div class="flex items-center space-x-5">
                <a href="{{ url('buscar') }}" class="text-dark-turquoise hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8" stroke-width="2"></circle>
                        <path d="m21 21-4.35-4.35" stroke-width="2"></path>
                    </svg>
                </a>
                <a href="{{ url('carrito') }}" class="text-dark-turquoise hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path d="M9 2L7 6H2l3 13h14l3-13h-5l-2-4H9Z"></path>
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="17" cy="21" r="1"></circle>
                    </svg>
                </a>
                <a href="{{ url('cuenta') }}" class="text-dark-turquoise hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </a>

                <!-- Mobile Menu Toggle -->
                <button class="lg:hidden text-dark-turquoise" onclick="toggleMobileMenu()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden lg:hidden mt-4 pb-4 border-t border-gray-200 pt-4">
            <ul class="space-y-3 text-sm">
                <li><a href="{{ url('personalizados') }}" class="block text-gray-700 hover:text-dark-turquoise transition uppercase">Personalizados</a></li>
                <li><a href="{{ url('colecciones') }}" class="block text-gray-700 hover:text-dark-turquoise transition uppercase">Colecciones</a></li>
                <li><a href="{{ url('mayoristas') }}" class="block text-gray-700 hover:text-dark-turquoise transition uppercase">Mayoristas</a></li>
                <li><a href="{{ url('gift-card') }}" class="block text-gray-700 hover:text-dark-turquoise transition uppercase">Gift Card</a></li>
                <li><a href="{{ url('contacto') }}" class="block text-gray-700 hover:text-dark-turquoise transition uppercase">Contacto</a></li>
            </ul>
        </div>
    </div>
</nav>

<script>
function toggleMobileMenu() {
    const menu = document.getElementById('mobileMenu');
    menu.classList.toggle('hidden');
}
</script>
