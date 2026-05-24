<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mary Mystic Stones | Pulseras con piedras naturales')</title>
    <meta name="description" content="@yield('meta_description', 'Pulseras con piedras naturales y energía holística')">
    @yield('meta')

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>

    {{-- HEADER --}}
    <header class="site-header">
        <div class="header-inner">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="site-logo">
                <span class="logo-symbol">✦</span>
                Mary Mystic Stones
            </a>

            {{-- Desktop nav --}}
            <nav class="desktop-nav">
                <a href="{{ route('home') }}" class="nav-link">Inicio</a>
                <a href="{{ route('shop.index') }}" class="nav-link">Tienda</a>
                <a href="{{ route('blog.index') }}" class="nav-link">Blog</a>

                @auth
                    @if(auth()->user()->role === 'customer')
                        <a href="{{ route('customer.dashboard') }}" class="nav-link">Mi Cuenta</a>
                    @endif
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="nav-link">Admin</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" style="display:inline">
                        @csrf
                        <button type="submit" class="nav-logout-btn">Salir</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-link">Ingresar</a>
                    <a href="{{ route('register') }}" class="nav-btn-primary">Crear cuenta</a>
                @endauth
            </nav>

            {{-- Mobile --}}
            <div class="mobile-actions">
                <button id="menu-toggle" aria-label="Abrir menú" aria-expanded="false">
                    <svg id="icon-open" xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg id="icon-close" xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" style="display:none">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile drawer --}}
        <div id="mobile-menu" class="hidden">
            <a href="{{ route('home') }}" class="mobile-nav-link"><span class="mnav-icon">✦</span>Inicio</a>
            <a href="{{ route('shop.index') }}" class="mobile-nav-link"><span class="mnav-icon">◈</span>Tienda</a>
            <a href="{{ route('blog.index') }}" class="mobile-nav-link"><span class="mnav-icon">◉</span>Blog</a>
            @auth
                @if(auth()->user()->role === 'customer')
                    <a href="{{ route('customer.dashboard') }}" class="mobile-nav-link"><span class="mnav-icon">◎</span>Mi Cuenta</a>
                @endif
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="mobile-nav-link"><span class="mnav-icon">⚙</span>Admin</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="padding-top:0.75rem">
                    @csrf
                    <button type="submit" class="mobile-nav-link" style="background:transparent;border:none;cursor:pointer;width:100%;text-align:left">
                        <span class="mnav-icon">→</span>Cerrar sesión
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="mobile-nav-link"><span class="mnav-icon">◐</span>Ingresar</a>
                <div style="padding-top:1rem">
                    <a href="{{ route('register') }}" class="nav-btn-primary" style="display:block;text-align:center">Crear cuenta gratis</a>
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
        @if(count($brands) > 0)
        <div class="brands-section">
            <div class="brands-scroll">
                @foreach($brands as $brand)
                    <div class="brand-item">
                        <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}">
                        <p>{{ $brand->name }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    @endisset

    {{-- CONTENIDO PRINCIPAL --}}
    <main>
        {{ $slot }}
    </main>

    {{-- FOOTER --}}
    <footer class="site-footer">
        <div class="footer-inner">
            <div>
                <p class="footer-logo">Alma de Piedra</p>
                <p class="footer-tagline">Pulseras con piedras naturales cargadas de energía. Cada pieza es única, como tú.</p>
            </div>
            <div>
                <p class="footer-heading">Navegar</p>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}">Inicio</a></li>
                    <li><a href="{{ route('shop.index') }}">Tienda</a></li>
                    <li><a href="{{ route('blog.index') }}">Blog</a></li>
                    <li><a href="{{ route('cart.index') }}">Mi carrito</a></li>
                    <li><a href="/sitemap.xml">Sitemap</a></li>
                </ul>
            </div>
            <div>
                <p class="footer-heading">Contacto</p>
                <p class="footer-contact-line">✉ <a href="mailto:hola@almadepiedra.com">hola@almadepiedra.com</a></p>
                <p class="footer-contact-line">📞 +58 000 000 0000</p>
                <p style="margin-top:1rem;font-size:0.78rem;color:rgba(255,255,255,0.3);line-height:1.6">
                    Lun–Vie · 9:00am – 6:00pm
                </p>
            </div>
        </div>
        <div class="footer-bottom">
            © {{ date('Y') }} Alma de Piedra · Todos los derechos reservados
        </div>
    </footer>

    {{-- FLOTANTES --}}
    <div class="floating-actions">
        {{-- WhatsApp --}}
        <a href="https://wa.me/584243101775?text=Hola%2C%20quisiera%20m%C3%A1s%20informaci%C3%B3n"
           target="_blank" rel="noopener noreferrer"
           class="float-btn" aria-label="Contactar por WhatsApp">
            <span class="float-btn-label">Escríbenos por WhatsApp</span>
            <span class="float-btn-circle" style="background:#25D366">
                <svg width="26" height="26" viewBox="0 0 32 32" fill="white">
                    <path d="M16 3C9.373 3 4 8.373 4 15c0 2.385.663 4.61 1.807 6.508L4 29l7.747-1.78A12.9 12.9 0 0016 28c6.627 0 12-5.373 12-12S22.627 3 16 3zm0 2c5.523 0 10 4.477 10 10s-4.477 10-10 10a9.94 9.94 0 01-4.934-1.302L10.5 23.5l.854-.197-1.347-5.867-.146.084A9.96 9.96 0 016 15c0-5.523 4.477-10 10-10zm-3.5 5c-.3 0-.8.1-1.2.55-.4.45-1.3 1.3-1.3 3.15s1.35 3.65 1.55 3.9c.2.25 2.6 4.1 6.4 5.55 3.15 1.2 3.8.95 4.5.9.7-.1 2.25-.95 2.55-1.85.3-.9.3-1.7.2-1.85-.1-.15-.35-.25-.7-.4-.35-.2-2.25-1.1-2.6-1.25-.35-.15-.6-.2-.85.2-.25.4-.95 1.2-1.15 1.45-.2.25-.4.3-.75.1-.35-.2-1.5-.55-2.85-1.75a10.7 10.7 0 01-2-2.45c-.2-.35-.02-.55.15-.7.15-.15.35-.4.5-.6.15-.2.2-.35.3-.55.1-.2.05-.4-.03-.55-.1-.15-.85-2.1-1.2-2.85-.3-.7-.6-.6-.85-.6z"/>
                </svg>
            </span>
        </a>

        {{-- Carrito --}}
        <a href="{{ route('cart.index') }}" class="float-btn" aria-label="Ver carrito">
            <span class="float-btn-label">Ver carrito</span>
            <span class="float-btn-circle" style="background:var(--amethyst)">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 120 120" fill="none">
                    <path d="M0 0 L8 0 L22 90 L98 90 L112 30 L18 30" stroke="white" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="38" cy="108" r="10" fill="white"/>
                    <circle cx="82" cy="108" r="10" fill="white"/>
                </svg>
                <span id="cart-count-fab">{{ count($cartItems ?? []) }}</span>
            </span>
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        new Swiper(".mySwiper", {
            loop: true,
            autoplay: { delay: 5000, disableOnInteraction: false },
            pagination: { el: ".swiper-pagination", clickable: true },
            navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
            effect: 'fade',
            fadeEffect: { crossFade: true },
        });

        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        const iconOpen   = document.getElementById('icon-open');
        const iconClose  = document.getElementById('icon-close');

        menuToggle.addEventListener('click', () => {
            const isOpen = !mobileMenu.classList.contains('hidden');
            mobileMenu.classList.toggle('hidden');
            iconOpen.style.display  = isOpen ? '' : 'none';
            iconClose.style.display = isOpen ? 'none' : '';
            menuToggle.setAttribute('aria-expanded', String(!isOpen));
        });

        document.addEventListener('click', (e) => {
            if (!menuToggle.contains(e.target) && !mobileMenu.contains(e.target)) {
                mobileMenu.classList.add('hidden');
                iconOpen.style.display = '';
                iconClose.style.display = 'none';
                menuToggle.setAttribute('aria-expanded', 'false');
            }
        });

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
                    btn.classList.toggle('is-wishlisted', data.status === 'added');
                }
            });
        }
    </script>

</body>
</html>