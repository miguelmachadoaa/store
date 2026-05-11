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


      {{-- ====== BOTONES FLOTANTES ====== --}}
<div class="fixed bottom-6 right-6 flex flex-col items-end gap-3 z-50">

    {{-- WhatsApp --}}
    
        <a href="https://wa.me/584243101775?text=Hola%2C%20quisiera%20m%C3%A1s%20informaci%C3%B3n"
        target="_blank"
        rel="noopener noreferrer"
        class="group flex items-center gap-2"
        aria-label="Contactar por WhatsApp"
    >
        <span class="hidden group-hover:flex items-center bg-white text-gray-700 text-sm font-medium px-3 py-1.5 rounded-lg shadow border border-gray-200 whitespace-nowrap transition">
            Contactar por WhatsApp
        </span>
        <div class="w-13 h-13 flex items-center justify-center rounded-full shadow-lg transition hover:scale-105 active:scale-95"
             style="width:52px;height:52px;background:#25D366;">
            <svg width="28" height="28" viewBox="0 0 32 32" fill="white">
                <path d="M16 3C9.373 3 4 8.373 4 15c0 2.385.663 4.61 1.807 6.508L4 29l7.747-1.78A12.9 12.9 0 0016 28c6.627 0 12-5.373 12-12S22.627 3 16 3zm0 2c5.523 0 10 4.477 10 10s-4.477 10-10 10a9.94 9.94 0 01-4.934-1.302L10.5 23.5l.854-.197-1.347-5.867-.146.084A9.96 9.96 0 016 15c0-5.523 4.477-10 10-10zm-3.5 5c-.3 0-.8.1-1.2.55-.4.45-1.3 1.3-1.3 3.15s1.35 3.65 1.55 3.9c.2.25 2.6 4.1 6.4 5.55 3.15 1.2 3.8.95 4.5.9.7-.1 2.25-.95 2.55-1.85.3-.9.3-1.7.2-1.85-.1-.15-.35-.25-.7-.4-.35-.2-2.25-1.1-2.6-1.25-.35-.15-.6-.2-.85.2-.25.4-.95 1.2-1.15 1.45-.2.25-.4.3-.75.1-.35-.2-1.5-.55-2.85-1.75a10.7 10.7 0 01-2-2.45c-.2-.35-.02-.55.15-.7.15-.15.35-.4.5-.6.15-.2.2-.35.3-.55.1-.2.05-.4-.03-.55-.1-.15-.85-2.1-1.2-2.85-.3-.7-.6-.6-.85-.6z"/>
            </svg>
        </div>
    </a>

    {{-- Carrito flotante --}}
    
        <a href="{{ route('cart.index') }}"
        class="group flex items-center gap-2"
        aria-label="Ver carrito"
    >
        <span class="hidden group-hover:flex items-center bg-white text-gray-700 text-sm font-medium px-3 py-1.5 rounded-lg shadow border border-gray-200 whitespace-nowrap transition">
            Ver carrito
        </span>
        <div class="relative flex items-center justify-center rounded-full shadow-lg bg-pink-600 hover:bg-pink-700 transition hover:scale-105 active:scale-95"
             style="width:52px;height:52px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 120 120" fill="none">
                <path d="M0 0 L8 0 L22 90 L98 90 L112 30 L18 30" stroke="white" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>
                <circle cx="38" cy="108" r="10" fill="white"/>
                <circle cx="82" cy="108" r="10" fill="white"/>
            </svg>
            <span id="cart-count-fab" class="absolute -top-1 -right-1 bg-white text-pink-600 text-xs font-bold rounded-full border border-pink-600 min-w-[18px] h-[18px] flex items-center justify-center px-1">
                {{ count($cartItems ?? []) }}
            </span>
        </div>
    </a>

</div>

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