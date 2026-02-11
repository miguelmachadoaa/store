<aside class="w-64 bg-white shadow-md border-r border-gray-200 min-h-screen hidden md:block">
    <div class="p-6 border-b">
        <h2 class="text-xl font-bold text-gray-800">Admin Panel</h2>
    </div>

    <nav class="mt-4 px-2">
        <ul class="space-y-1">

            {{-- Dashboard --}}
            <li>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 hover:bg-gray-100 rounded-lg text-gray-700 font-medium transition
                   {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 text-indigo-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                    Dashboard
                </a>
            </li>

            {{-- Catálogo --}}
            <li
                x-data="{ open: {{ request()->routeIs('products.*', 'admin.categories.*', 'brands.*', 'admin.dollar-values.*', 'admin.taxes.*') ? 'true' : 'false' }} }">
                <button @click="open = !open"
                    class="flex items-center justify-between w-full px-4 py-3 hover:bg-gray-100 rounded-lg text-gray-700 font-medium transition">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Catálogo
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'transform rotate-180': open }"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open" x-transition class="pl-11 pr-2 space-y-1 mt-1">
                    <a href="{{ route('products.index') }}"
                        class="block px-3 py-2 rounded text-sm hover:bg-gray-100 {{ request()->routeIs('products.*') ? 'text-indigo-600 font-semibold' : 'text-gray-600' }}">Productos</a>
                    <a href="{{ route('admin.categories.index') }}"
                        class="block px-3 py-2 rounded text-sm hover:bg-gray-100 {{ request()->routeIs('admin.categories.*') ? 'text-indigo-600 font-semibold' : 'text-gray-600' }}">Categorías</a>
                    <a href="{{ route('brands.index') }}"
                        class="block px-3 py-2 rounded text-sm hover:bg-gray-100 {{ request()->routeIs('brands.*') ? 'text-indigo-600 font-semibold' : 'text-gray-600' }}">Marcas</a>
                    <a href="{{ route('admin.dollar-values.index') }}"
                        class="block px-3 py-2 rounded text-sm hover:bg-gray-100 {{ request()->routeIs('admin.dollar-values.*') ? 'text-indigo-600 font-semibold' : 'text-gray-600' }}">Valor
                        Dólar</a>
                    <a href="{{ route('admin.taxes.index') }}"
                        class="block px-3 py-2 rounded text-sm hover:bg-gray-100 {{ request()->routeIs('admin.taxes.*') ? 'text-indigo-600 font-semibold' : 'text-gray-600' }}">Impuestos</a>
                </div>
            </li>

            {{-- Ventas --}}
            <li
                x-data="{ open: {{ request()->routeIs('admin.orders.*', 'admin.customers.*', 'admin.pos.*') ? 'true' : 'false' }} }">
                <button @click="open = !open"
                    class="flex items-center justify-between w-full px-4 py-3 hover:bg-gray-100 rounded-lg text-gray-700 font-medium transition">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                        Ventas
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'transform rotate-180': open }"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open" x-transition class="pl-11 pr-2 space-y-1 mt-1">
                    <a href="{{ route('admin.pos.index') }}"
                        class="block px-3 py-2 rounded text-sm hover:bg-gray-100 {{ request()->routeIs('admin.pos.*') ? 'text-indigo-600 font-semibold' : 'text-gray-600' }}">🛒
                        Punto de Venta</a>
                    <a href="{{ route('admin.orders.index') }}"
                        class="block px-3 py-2 rounded text-sm hover:bg-gray-100 {{ request()->routeIs('admin.orders.*') ? 'text-indigo-600 font-semibold' : 'text-gray-600' }}">Órdenes</a>
                    <a href="{{ route('admin.customers.index') }}"
                        class="block px-3 py-2 rounded text-sm hover:bg-gray-100 {{ request()->routeIs('admin.customers.*') ? 'text-indigo-600 font-semibold' : 'text-gray-600' }}">Clientes</a>
                    <a href="{{ route('admin.reviews.index') }}"
                        class="block px-3 py-2 rounded text-sm hover:bg-gray-100 {{ request()->routeIs('admin.reviews.*') ? 'text-indigo-600 font-semibold' : 'text-gray-600' }}">Reseñas</a>
                </div>
            </li>

            {{-- Contenido --}}
            <li
                x-data="{ open: {{ request()->routeIs('sliders.*', 'admin.posts.*', 'admin.services.*') ? 'true' : 'false' }} }">
                <button @click="open = !open"
                    class="flex items-center justify-between w-full px-4 py-3 hover:bg-gray-100 rounded-lg text-gray-700 font-medium transition">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                        Contenido
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'transform rotate-180': open }"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open" x-transition class="pl-11 pr-2 space-y-1 mt-1">
                    <a href="{{ route('admin.services.index') }}"
                        class="block px-3 py-2 rounded text-sm hover:bg-gray-100 {{ request()->routeIs('admin.services.*') ? 'text-indigo-600 font-semibold' : 'text-gray-600' }}">Servicios</a>
                    <a href="{{ route('sliders.index') }}"
                        class="block px-3 py-2 rounded text-sm hover:bg-gray-100 {{ request()->routeIs('sliders.*') ? 'text-indigo-600 font-semibold' : 'text-gray-600' }}">Sliders</a>
                    <a href="{{ route('admin.posts.index') }}"
                        class="block px-3 py-2 rounded text-sm hover:bg-gray-100 {{ request()->routeIs('admin.posts.*') ? 'text-indigo-600 font-semibold' : 'text-gray-600' }}">Entradas
                        de Blog</a>
                </div>
            </li>

            {{-- Marketing --}}
            <li
                x-data="{ open: {{ request()->routeIs('admin.newsletters.*', 'admin.newsletter.*') ? 'true' : 'false' }} }">
                <button @click="open = !open"
                    class="flex items-center justify-between w-full px-4 py-3 hover:bg-gray-100 rounded-lg text-gray-700 font-medium transition">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        Marketing
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'transform rotate-180': open }"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open" x-transition class="pl-11 pr-2 space-y-1 mt-1">
                    <a href="{{ route('admin.newsletters.index') }}"
                        class="block px-3 py-2 rounded text-sm hover:bg-gray-100 {{ request()->routeIs('admin.newsletters.*') ? 'text-indigo-600 font-semibold' : 'text-gray-600' }}">Suscriptores</a>
                    <a href="{{ route('admin.newsletter.form') }}"
                        class="block px-3 py-2 rounded text-sm hover:bg-gray-100 {{ request()->routeIs('admin.newsletter.form') ? 'text-indigo-600 font-semibold' : 'text-gray-600' }}">Enviar
                        Email</a>
                </div>
            </li>

            {{-- Configuración --}}
            <li>
                <a href="{{ route('admin.settings.edit') }}" class="flex items-center px-4 py-3 hover:bg-gray-100 rounded-lg text-gray-700 font-medium transition
                   {{ request()->routeIs('admin.settings.*') ? 'bg-indigo-50 text-indigo-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Configuración
                </a>
            </li>

        </ul>
    </nav>
</aside>