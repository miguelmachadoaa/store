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
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto flex items-center justify-between py-4 px-6">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">MiTienda</a>

            <nav class="flex gap-6">
                <a href="{{ route('home') }}" class="hover:text-blue-600">Inicio</a>
                <a href="{{ route('shop.index') }}" class="hover:text-blue-600">Productos</a>
                <a href="{{ route('blog.index') }}" class="hover:text-blue-600">Noticias</a>
                {{-- Cart Icon --}}
                <a href="{{ route('cart.index') }}" class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-gray-700 hover:text-pink-600 transition"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m5-9v9m4-9v9m4-9l2 9" />
                    </svg>

                    {{-- Cart Count --}}
                    <span id="cart-count"
                        class="absolute -top-2 -right-2 bg-pink-600 text-white text-xs font-bold rounded-full px-2 py-0.5">
                        {{ count($cartItems ?? []) }}
                    </span>
                </a>

                @auth
                    {{-- Si es cliente --}}
                    @if(auth()->user()->role === 'customer')
                        <a href="{{ route('customer.dashboard') }}" class="text-gray-700 hover:text-pink-600 font-medium">
                            Mi Área
                        </a>
                    @endif

                    {{-- Si es admin --}}
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-pink-600 font-medium">
                            Admin
                        </a>
                    @endif

                    {{-- Logout --}}
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button class="text-gray-700 hover:text-pink-600 font-medium">
                            Cerrar sesión
                        </button>
                    </form>

                @else
                    {{-- Invitado --}}
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-pink-600 font-medium">
                        Iniciar sesión
                    </a>

                    <a href="{{ route('register') }}" class="text-gray-700 hover:text-pink-600 font-medium">
                        Registrarse
                    </a>
                @endauth


            </nav>
        </div>
    </header>

    {{-- SLIDER --}}
    @isset($sliders)
        <section class="w-full overflow-hidden bg-gray-900 text-white">
            <div class="max-w-7xl mx-auto py-10 px-6">
                <div class="grid md:grid-cols-2 gap-6 items-center">
                    <div>
                        <h2 class="text-4xl font-bold mb-4">{{ $sliders->first()->title ?? 'Bienvenido' }}</h2>
                        <p class="text-lg text-gray-300 mb-6">{{ $sliders->first()->description ?? '' }}</p>
                        <a href="{{ route('shop.index') }}" class="bg-blue-600 px-6 py-2 rounded hover:bg-blue-700">
                            Ver productos
                        </a>
                    </div>

                    <div>
                        @if(isset($sliders->first()->image))
                            <img src="{{ asset('storage/' . $sliders->first()->image) }}" class="rounded shadow-lg">
                        @endif
                    </div>
                </div>
            </div>
        </section>
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
                <h3 class="text-lg font-semibold mb-3">MiTienda</h3>
                <p class="text-sm">Tu tienda de confianza para productos tecnológicos.</p>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-3">Enlaces</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-white">Inicio</a></li>
                    <li><a href="{{ route('shop.index') }}" class="hover:text-white">Productos</a></li>
                    <li><a href="#" class="hover:text-white">Marcas</a></li>
                    <li><a href="{{ route('cart.index') }}" class="hover:text-white">Carrito</a></li>
                    <li><a href="/sitemap.xml" class="hover:text-white">Sitemap</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-3">Contacto</h3>
                <p class="text-sm">Email: soporte@mitienda.com</p>
                <p class="text-sm">Teléfono: +58 000 0000000</p>
            </div>

        </div>

        <div class="text-center text-gray-500 text-sm mt-6">
            © {{ date('Y') }} MiTienda. Todos los derechos reservados.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        new Swiper(".mySwiper", {
            loop: true,
            autoplay: {
                delay: 4000,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });

        document.addEventListener("DOMContentLoaded", () => {


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