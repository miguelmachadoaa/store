<x-front-layout>
    <div class="flex flex-col md:flex-row gap-8">
        {{-- Sidebar --}}
        <aside class="w-full md:w-64 flex-shrink-0">
            <div class="bg-white shadow rounded-lg p-6 border border-gray-100">
                <nav class="space-y-4">
                    <a href="{{ route('customer.dashboard') }}"
                        class="flex items-center gap-3 text-gray-700 hover:text-pink-600 font-medium {{ request()->routeIs('customer.dashboard') ? 'text-pink-600' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        Resumen
                    </a>

                    <a href="{{ route('customer.orders') }}"
                        class="flex items-center gap-3 text-gray-700 hover:text-pink-600 font-medium {{ request()->routeIs('customer.orders*') ? 'text-pink-600' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Mis Órdenes
                    </a>

                    <a href="{{ route('customer.favorites') }}"
                        class="flex items-center gap-3 text-gray-700 hover:text-pink-600 font-medium {{ request()->routeIs('customer.favorites') ? 'text-pink-600' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                            </path>
                        </svg>
                        Mis Favoritos
                    </a>

                    <a href="{{ route('customer.payments.report') }}"
                        class="flex items-center gap-3 text-gray-700 hover:text-pink-600 font-medium {{ request()->routeIs('customer.payments.report') ? 'text-pink-600' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Reportar Pago
                    </a>

                    <a href="{{ route('customer.payments') }}"
                        class="flex items-center gap-3 text-gray-700 hover:text-pink-600 font-medium {{ request()->routeIs('customer.payments') && !request()->routeIs('customer.payments.report') ? 'text-pink-600' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                        Mis Pagos
                    </a>

                    <a href="{{ route('customer.profile') }}"
                        class="flex items-center gap-3 text-gray-700 hover:text-pink-600 font-medium {{ request()->routeIs('customer.profile') ? 'text-pink-600' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Mi Perfil
                    </a>
                </nav>
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="flex-grow">
            {{ $slot }}
        </div>
    </div>
</x-front-layout>