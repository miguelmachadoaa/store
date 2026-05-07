<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $title ?? config('app.name', 'Tienda Online'))</title>
    <meta name="description" content="@yield('meta_description', 'Tu tienda online de confianza')">
    @yield('meta')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800">

    {{-- HEADER / MENU --}}
    <header class="bg-white shadow relative z-50">
        <div class="max-w-7xl mx-auto flex items-center justify-between py-4 px-6">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="text-2xl font-bold text-pink-600">MiTienda</a>

            {{-- Desktop nav --}}
            <nav class="hidden md:flex items-center gap-6">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-pink-600 font-medium transition">Inicio</a>
                <a href="{{ route('shop.index') }}" class="text-gray-700 hover:text-pink-600 font-medium transition">Productos</a>
                <a href="{{ route('blog.index') }}" class="text-gray-700 hover:text-pink-600 font-medium transition">Noticias</a>

                {{-- Cart --}}
                <a href="{{ route('cart.index') }}" class="relative text-gray-700 hover:text-pink-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 120 120" fill="none">
                        <path d="M0 0 L8 0 L22 90 L98 90 L112 30 L18 30" stroke="currentColor" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="38" cy="108" r="10" fill="currentColor"/>
                        <circle cx="82" cy="108" r="10" fill="currentColor"/>
                    </svg>
                    <span id="cart-count" class="absolute -top-2 -right-2 bg-pink-600 text-white text-xs font-bold rounded-full px-2 py-0.5">
                        {{ count($cartItems ?? []) }}
                    </span>
                </a>

                @auth
                    @if(auth()->user()->role === 'customer')
                        <a href="{{ route('customer.dashboard') }}" class="text-gray-700 hover:text-pink-600 font-medium transition">Mi Área</a>
                    @endif
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-pink-600 font-medium transition">Admin</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button class="text-gray-700 hover:text-pink-600 font-medium transition">Cerrar sesión</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-pink-600 font-medium transition">Iniciar sesión</a>
                    <a href="{{ route('register') }}" class="bg-pink-600 hover:bg-pink-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">Registrarse</a>
                @endauth
            </nav>

            {{-- Mobile right side: cart + hamburger --}}
            <div class="flex items-center gap-4 md:hidden">

                {{-- Cart (always visible on mobile) --}}
                <a href="{{ route('cart.index') }}" class="relative text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 120 120" fill="none">
                        <path d="M0 0 L8 0 L22 90 L98 90 L112 30 L18 30" stroke="currentColor" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="38" cy="108" r="10" fill="currentColor"/>
                        <circle cx="82" cy="108" r="10" fill="currentColor"/>
                    </svg>
                    <span class="absolute -top-2 -right-2 bg-pink-600 text-white text-xs font-bold rounded-full px-2 py-0.5">
                        {{ count($cartItems ?? []) }}
                    </span>
                </a>

                {{-- Hamburger button --}}
                <button
                    id="menu-toggle"
                    aria-label="Abrir menú"
                    aria-expanded="false"
                    class="text-gray-700 hover:text-pink-600 transition focus:outline-none"
                >
                    {{-- Hamburger icon --}}
                    <svg id="icon-open" xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    {{-- Close icon --}}
                    <svg id="icon-close" xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile menu drawer --}}
        <div
            id="mobile-menu"
            class="hidden md:hidden bg-white border-t border-gray-100 px-6 pb-6 pt-4 space-y-1"
        >
            <a href="{{ route('home') }}" class="flex items-center gap-2 py-3 text-gray-700 hover:text-pink-600 font-medium border-b border-gray-100 transition">
                <span>🏠</span> Inicio
            </a>
            <a href="{{ route('shop.index') }}" class="flex items-center gap-2 py-3 text-gray-700 hover:text-pink-600 font-medium border-b border-gray-100 transition">
                <span>🛍️</span> Productos
            </a>
            <a href="{{ route('blog.index') }}" class="flex items-center gap-2 py-3 text-gray-700 hover:text-pink-600 font-medium border-b border-gray-100 transition">
                <span>📰</span> Noticias
            </a>

            @auth
                @if(auth()->user()->role === 'customer')
                    <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-2 py-3 text-gray-700 hover:text-pink-600 font-medium border-b border-gray-100 transition">
                        <span>👤</span> Mi Área
                    </a>
                @endif
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 py-3 text-gray-700 hover:text-pink-600 font-medium border-b border-gray-100 transition">
                        <span>⚙️</span> Admin
                    </a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="pt-2">
                    @csrf
                    <button class="w-full text-left flex items-center gap-2 py-3 text-gray-700 hover:text-pink-600 font-medium transition">
                        <span>🚪</span> Cerrar sesión
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="flex items-center gap-2 py-3 text-gray-700 hover:text-pink-600 font-medium border-b border-gray-100 transition">
                    <span>🔑</span> Iniciar sesión
                </a>
                <div class="pt-3">
                    <a href="{{ route('register') }}" class="block text-center bg-pink-600 hover:bg-pink-700 text-white font-semibold px-4 py-3 rounded-xl transition">
                        Registrarse gratis
                    </a>
                </div>
            @endauth
        </div>
    </header>

    {{-- SLIDER --}}
    @isset($sliders)
        <x-slider :sliders="$sliders" />
    @endisset

    {{-- MARCAS --}}
    @isset($brands)
        <section class="py-10 bg-white">
            <div class="max-w-7xl mx-auto px-6">
                <h2 class="text-xl font-semibold mb-4">Marcas destacadas</h2>
                <div class="flex gap-6 overflow-x-auto">
                    @foreach($brands as $brand)
                        <div class="min-w-[120px] bg-gray-100 p-4 rounded shadow text-center">
                            <img src="{{ asset('storage/' . $brand->logo) }}" class="h-12 mx-auto mb-2">
                            <p class="text-sm font-semibold">{{ $brand->name }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endisset

    {{-- CONTENIDO PRINCIPAL --}}
    <main class="max-w-7xl mx-auto py-10 px-6">
        {{ $slot }}
    </main>

    {{-- FOOTER --}}
    <footer class="bg-gray-900 text-gray-300 py-10 mt-10">
        <div class="max-w-7xl mx-auto grid md:grid-cols-3 gap-6 px-6">

            <div>
                <h3 class="text-lg font-semibold mb-3 text-white">MiTienda</h3>
                <p class="text-sm">Tu tienda de confianza para productos tecnológicos.</p>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-3 text-white">Enlaces</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition">Inicio</a></li>
                    <li><a href="{{ route('shop.index') }}" class="hover:text-white transition">Productos</a></li>
                    <li><a href="#" class="hover:text-white transition">Marcas</a></li>
                    <li><a href="{{ route('cart.index') }}" class="hover:text-white transition">Carrito</a></li>
                    <li><a href="/sitemap.xml" class="hover:text-white transition">Sitemap</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-3 text-white">Contacto</h3>
                <p class="text-sm">Email: soporte@mitienda.com</p>
                <p class="text-sm mt-1">Teléfono: +58 000 0000000</p>
            </div>

        </div>

        <div class="text-center text-gray-500 text-sm mt-8 border-t border-gray-800 pt-6">
            © {{ date('Y') }} MiTienda. Todos los derechos reservados.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        // Swiper
        new Swiper(".mySwiper", {
            loop: true,
            autoplay: { delay: 4000 },
            pagination: { el: ".swiper-pagination", clickable: true },
            navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
        });

        // Mobile menu toggle
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        const iconOpen   = document.getElementById('icon-open');
        const iconClose  = document.getElementById('icon-close');

        menuToggle.addEventListener('click', () => {
            const isOpen = !mobileMenu.classList.contains('hidden');

            mobileMenu.classList.toggle('hidden');
            iconOpen.classList.toggle('hidden', !isOpen ? true : false);
            iconClose.classList.toggle('hidden', !isOpen ? false : true);
            menuToggle.setAttribute('aria-expanded', String(!isOpen));
        });

        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!menuToggle.contains(e.target) && !mobileMenu.contains(e.target)) {
                mobileMenu.classList.add('hidden');
                iconOpen.classList.remove('hidden');
                iconClose.classList.add('hidden');
                menuToggle.setAttribute('aria-expanded', 'false');
            }
        });

        // Wishlist toggle
        function toggleWishlist(productId, btn) {
            fetch(`/wishlist/toggle/${productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    if (data.status === 'added') {
                        btn.classList.add('text-pink-600');
                        btn.classList.remove('text-gray-400');
                    } else {
                        btn.classList.remove('text-pink-600');
                        btn.classList.add('text-gray-400');
                    }
                }
            });
        }
    </script>

</body>

</html>