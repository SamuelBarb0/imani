<nav class="bg-gray-50 border-b border-gray-200">
    <div class="container mx-auto px-6">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('images/instagram/ig-7.jpg') }}" alt="Imani Magnets" class="h-36 w-auto">
                </a>
            </div>

            <!-- Navigation Menu - Desktop -->
            <ul class="hidden lg:flex items-center space-x-10 text-base font-normal tracking-wide uppercase">
                <li>
                    <a href="{{ route('personalizados.index') }}"
                        class="text-gray-700 hover:text-dark-turquoise transition">
                        Personalizados
                    </a>
                </li>
                <li>
                    <a href="{{ route('colecciones') }}"
                        class="text-gray-700 hover:text-dark-turquoise transition">
                        Colecciones
                    </a>
                </li>
                <li>
                    <a href="{{ route('mayoristas') }}"
                        class="text-gray-700 hover:text-dark-turquoise transition">
                        Mayoristas
                    </a>
                </li>
                <li>
                    <a href="{{ route('contacto') }}"
                        class="text-gray-700 hover:text-dark-turquoise transition">
                        Contacto
                    </a>
                </li>
            </ul>


            <!-- Right Icons -->
            <div class="flex items-center space-x-6">
                <a href="{{ url('pruebas/carrito') }}" class="text-dark-turquoise hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-cart3" viewBox="0 0 16 16">
                        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l.84 4.479 9.144-.459L13.89 4zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                    </svg>
                </a>
                @auth
                <a href="{{ route('user.profile') }}" class="text-dark-turquoise hover:scale-110 transition-transform" title="Mi Perfil">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </a>
                @else
                <a href="{{ route('login') }}" class="text-dark-turquoise hover:scale-110 transition-transform" title="Iniciar Sesión">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </a>
                @endauth

                <!-- Mobile Menu Toggle -->
                <button class="lg:hidden text-dark-turquoise" onclick="toggleMobileMenu()">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden lg:hidden mt-4 pb-4 border-t border-gray-200 pt-4">
            <ul class="space-y-3 text-base">
                <li><a href="{{ url('pruebas/personalizados') }}" class="block text-gray-700 hover:text-dark-turquoise transition uppercase">Personalizados</a></li>
                <li><a href="{{ url('pruebas/colecciones') }}" class="block text-gray-700 hover:text-dark-turquoise transition uppercase">Colecciones</a></li>
                <li><a href="{{ url('pruebas/mayoristas') }}" class="block text-gray-700 hover:text-dark-turquoise transition uppercase">Mayoristas</a></li>
                <li><a href="{{ url('pruebas/contacto') }}" class="block text-gray-700 hover:text-dark-turquoise transition uppercase">Contacto</a></li>
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