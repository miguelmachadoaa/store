<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Zolum Shop | Tu estilo de vida, evolucionado')</title>
    <meta name="description" content="@yield('meta_description', 'Zolum Shop conecta lo último en tendencias con las necesidades de tu hogar, salud y bienestar.')">
    @yield('meta')

    {{-- Tipografía de Retail Limpia e Internacional --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    @vite(['resources/css/front.css', 'resources/js/app.js'])

    <style>
        /* Correcciones de distribución del Footer Estilo Marketplace */
        .zolum-marketplace-footer {
            background-color: #111622; /* Ajustable a tu paleta oscura de footer corporativo */
            color: #FFFFFF;
            padding: 4rem 1.5rem 2rem 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }
        .zolum-footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 2.5rem;
        }
        .zolum-footer-brand {
            flex: 1 1 300px;
            max-width: 360px;
        }
        .zolum-footer-logo {
            display: block;
            margin-bottom: 1rem;
            height: auto;
        }
        .zolum-footer-tagline {
            font-size: 14px;
            color: #A0AAB5;
            line-height: 1.6;
            margin: 0;
        }
        .zolum-footer-grid-links {
            flex: 2 1 500px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
        }
        .zolum-footer-heading {
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #FFFFFF;
            margin: 0 0 1.25rem 0;
        }
        .zolum-footer-links-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .zolum-footer-links-list li {
            margin-bottom: 0.75rem;
        }
        .zolum-footer-links-list a {
            color: #A0AAB5;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s ease;
        }
        .zolum-footer-links-list a:hover {
            color: var(--warm-orange, #F26722);
        }
        .zolum-footer-info {
            font-size: 14px;
            color: #A0AAB5;
            margin: 0 0 0.75rem 0;
            line-height: 1.5;
        }
        .zolum-footer-info a {
            color: inherit;
            text-decoration: none;
            transition: color 0.2s ease;
        }
        .zolum-footer-info a:hover {
            color: var(--warm-orange, #F26722);
        }
        .zolum-footer-bottom {
            max-width: 1200px;
            margin: 3rem auto 0 auto;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            font-size: 12px;
            color: #616F80;
            text-align: center;
        }

        @media (max-width: 768px) {
            .zolum-footer-container {
                flex-direction: column;
                gap: 3rem;
            }
            .zolum-footer-brand, .zolum-footer-grid-links {
                flex: 1 1 100%;
                max-width: 100%;
            }
            .zolum-footer-grid-links {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
        }
    </style>
</head>

<body>

    {{-- Barra superior informativa (Alta conversión) --}}
    <div class="zolum-top-banner">
        <span>Delivery GRATIS en compras mayores a $20 en Maracay</span>
    </div>

    {{-- HEADER PRINCIPAL (Estilo Madison/Amazon) --}}
    <header class="zolum-marketplace-header">
        <div class="zolum-header-container">
            
            {{-- Bloque Izquierdo: Botón de Categorías + Logo --}}
            <div class="zolum-header-left">
                <button id="menu-toggle" class="zolum-menu-trigger" aria-label="Abrir menú" aria-expanded="false">
                    <svg class="zolum-icon-svg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <span class="zolum-menu-text">Menú</span>
                </button>

                <a href="{{ route('home') }}" class="zolum-brand-logo">
                    <img src="{{ asset('storage/zolum_blanco.png') }}" alt="Zolum Shop" class="zolum-logo-img">
                </a>
            </div>

            {{-- Bloque Central: Barra de búsqueda masiva --}}
            <div class="zolum-header-center">
                <form action="{{ route('shop.index') }}" method="GET" class="zolum-search-form">
                    <input type="text" name="search" placeholder="¿Qué desearías buscar hoy?" class="zolum-search-input" value="{{ request('search') }}">
                    <button type="submit" class="zolum-search-submit" aria-label="Buscar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </form>
            </div>

            {{-- Bloque Derecho: Gestión de Cuenta, Rutas y Carrito --}}
            <div class="zolum-header-right">
                
                {{-- Bloque de Autenticación --}}
                <div class="zolum-account-block">
                    @auth
                        <span class="zolum-account-greet">Hola, {{ auth()->user()->name }}</span>
                        <div class="zolum-account-links">
                            @if(auth()->user()->role === 'customer')
                                <a href="{{ route('customer.dashboard') }}" class="zolum-account-action">Mi Cuenta</a>
                            @elseif(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="zolum-account-action-admin">Panel Admin</a>
                            @endif
                            <span class="zolum-divider">|</span>
                            <form method="POST" action="{{ route('logout') }}" class="zolum-inline-form">
                                @csrf
                                <button type="submit" class="zolum-logout-link">Salir</button>
                            </form>
                        </div>
                    @else
                        <span class="zolum-account-greet">Inicia sesión / Regístrate</span>
                        <div class="zolum-account-links">
                            <a href="{{ route('login') }}" class="zolum-account-action">Mi cuenta</a>
                            <span class="zolum-divider">|</span>
                            <a href="{{ route('register') }}" class="zolum-account-action">Crear cuenta</a>
                        </div>
                    @endauth
                </div>

                {{-- Enlace Directo al Blog --}}
                <a href="{{ route('blog.index') }}" class="zolum-header-blog-link">
                    <span>Blog</span>
                </a>

                {{-- Carrito de Compras Dinámico --}}
                <a href="{{ route('cart.index') }}" class="zolum-header-cart">
                    <div class="zolum-cart-icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 100 4 2 2 0 000-4z" />
                        </svg>
                        <span id="header-cart-count" class="zolum-cart-badge">{{ count($cartItems ?? []) }}</span>
                    </div>
                    <span class="zolum-cart-text">Carrito</span>
                </a>

            </div>
        </div>

        {{-- Menú Drawer Lateral Desplegable (Categorías Globales) --}}
        <div id="mobile-menu" class="zolum-drawer hidden">
            <div class="zolum-drawer-overlay"></div>
            <div class="zolum-drawer-content">
                <div class="zolum-drawer-header">
                    <h3>Categorías Zolum Shop</h3>
                </div>
                <nav class="zolum-drawer-nav">
                    <a href="{{ route('home') }}" class="zolum-drawer-link">Inicio</a>
                    <a href="{{ route('shop.index') }}" class="zolum-drawer-link font-bold">Ver Toda la Tienda</a>
                    
                    <hr class="zolum-drawer-hr">
                    
                    {{-- Iteración dinámica de categorías desde el ViewServiceProvider --}}
                    @if(isset($globalCategories) && $globalCategories->count() > 0)
                        @foreach($globalCategories as $category)
                            <a href="{{ route('shop.byCategory', $category->slug) }}" class="zolum-drawer-link">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    @else
                        <span class="zolum-drawer-link text-gray-400 italic">No hay categorías disponibles</span>
                    @endif

                    <hr class="zolum-drawer-hr">
                    
                    <a href="{{ route('blog.index') }}" class="zolum-drawer-link">Blog & Novedades</a>
                    
                    <hr class="zolum-drawer-hr">
                    @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="zolum-drawer-link zolum-text-danger">Cerrar sesión</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="zolum-drawer-link">Ingresar</a>
                        <a href="{{ route('register') }}" class="zolum-drawer-link font-bold">Registrarse gratis</a>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    {{-- CONTENIDO PRINCIPAL --}}
    <main class="zolum-main-viewport">
        {{ $slot }}
    </main>

    {{-- FOOTER UNIFICADO CORREGIDO --}}
    <footer class="zolum-marketplace-footer">
        <div class="zolum-footer-container">
            
            {{-- LADO IZQUIERDO: Marca, Logo y Eslogan --}}
            <div class="zolum-footer-brand">
                <img src="{{ asset('storage/zolum_blanco.png') }}" alt="Zolum Shop" class="zolum-footer-logo" width="180">
                <p class="zolum-footer-tagline">Tu estilo de vida, evolucionado.</p>
            </div>
            
            {{-- LADO DERECHO: Grid balanceado de columnas informativas --}}
            <div class="zolum-footer-grid-links">
                <div>
                    <p class="zolum-footer-heading">Navegar</p>
                    <ul class="zolum-footer-links-list">
                        <li><a href="{{ route('home') }}">Inicio</a></li>
                        <li><a href="{{ route('shop.index') }}">Tienda</a></li>
                        <li><a href="{{ route('blog.index') }}">Blog</a></li>
                        <li><a href="{{ route('cart.index') }}">Mi carrito</a></li>
                    </ul>
                </div>
                <div>
                    <p class="zolum-footer-heading">Contacto & Soporte</p>
                    <p class="zolum-footer-info">✉ <a href="mailto:hola@zolumshop.com">hola@zolumshop.com</a></p>
                    <p class="zolum-footer-info">Lun–Vie · 9:00am – 6:00pm</p>
                </div>
            </div>

        </div>
        
        {{-- Copyright inferior --}}
        <div class="zolum-footer-bottom">
            &copy; {{ date('Y') }} Zolum Shop · Todos los derechos reservados
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');

        menuToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            const isOpen = !mobileMenu.classList.contains('hidden');
            mobileMenu.classList.toggle('hidden');
            menuToggle.setAttribute('aria-expanded', String(!isOpen));
        });

        document.addEventListener('click', (e) => {
            if (!mobileMenu.classList.contains('hidden') && !mobileMenu.contains(e.target) && !menuToggle.contains(e.target)) {
                mobileMenu.classList.add('hidden');
                menuToggle.setAttribute('aria-expanded', 'false');
            }
        });
    </script>

</body>
</html>