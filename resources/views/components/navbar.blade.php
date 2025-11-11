<nav class="bg-gray-50 border-b border-gray-200">
    <div class="container mx-auto px-6">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('images/Imani.png') }}" alt="Imani Magnets" class="h-36 w-auto">
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
                <!-- Tracking Icon -->
                <a href="{{ route('tracking.index') }}" class="text-dark-turquoise hover:scale-110 transition-transform" title="Rastrear Pedido">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-box-seam" viewBox="0 0 16 16">
                        <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2zm3.564 1.426L5.596 5 8 5.961 14.154 3.5zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z"/>
                    </svg>
                </a>

                <!-- Cart Icon -->
                <a href="{{ url('pruebas/carrito') }}" class="relative text-dark-turquoise hover:scale-110 transition-transform" title="Carrito">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-cart3" viewBox="0 0 16 16">
                        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l.84 4.479 9.144-.459L13.89 4zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                    </svg>
                    @php
                        use App\Models\Cart;
                        $cart = null;
                        if (Auth::check()) {
                            $cart = Cart::where('user_id', Auth::id())->first();
                        } else {
                            $cart = Cart::where('session_id', session()->getId())->first();
                        }
                        $cartCount = $cart ? $cart->getTotalItems() : 0;
                    @endphp
                    <span data-cart-count class="absolute -top-2 -right-2 bg-gray-orange text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center {{ $cartCount > 0 ? '' : 'hidden' }}">
                        {{ $cartCount }}
                    </span>
                </a>
                @auth
                    <!-- Admin Dashboard Icon (only for admins) -->
                    @if(Auth::user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="text-dark-turquoise hover:scale-110 transition-transform" title="Panel de Administración">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-speedometer2" viewBox="0 0 16 16">
                                <path d="M8 4a.5.5 0 0 1 .5.5V6a.5.5 0 0 1-1 0V4.5A.5.5 0 0 1 8 4M3.732 5.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707M2 10a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 10m9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5m.754-4.246a.39.39 0 0 0-.527-.02L7.547 9.31a.91.91 0 1 0 1.302 1.258l3.434-4.297a.39.39 0 0 0-.029-.518z"/>
                                <path fill-rule="evenodd" d="M0 10a8 8 0 1 1 15.547 2.661c-.442 1.253-1.845 1.602-2.932 1.25C11.309 13.488 9.475 13 8 13c-1.474 0-3.31.488-4.615.911-1.087.352-2.49.003-2.932-1.25A8 8 0 0 1 0 10m8-7a7 7 0 0 0-6.603 9.329c.203.575.923.876 1.68.63C4.397 12.533 6.358 12 8 12s3.604.532 4.923.96c.757.245 1.477-.056 1.68-.631A7 7 0 0 0 8 3"/>
                            </svg>
                        </a>
                    @endif

                    <!-- User Profile Icon -->
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
                <li><a href="{{ route('tracking.index') }}" class="block text-gray-700 hover:text-dark-turquoise transition uppercase">Rastrear Pedido</a></li>
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