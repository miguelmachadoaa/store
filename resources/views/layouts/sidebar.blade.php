<aside class="w-64 bg-white shadow-md border-r border-gray-200 min-h-screen hidden md:block">
    <div class="p-6">
        <h2 class="text-xl font-bold text-gray-700">Admin Panel</h2>
    </div>

    <nav class="mt-4">
        <ul class="space-y-1">

            {{-- Dashboard --}}
            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="block px-6 py-3 hover:bg-gray-100 text-gray-700 font-medium">
                    Dashboard
                </a>
            </li>

            {{-- Productos --}}
            <li>
                <a href="{{ route('products.index') }}"
                   class="block px-6 py-3 hover:bg-gray-100 text-gray-700 font-medium">
                    Productos
                </a>
            </li>

            {{-- Categorías --}}

            <li>
                <a href="{{ route('admin.categories.index') }}"
                   class="block px-6 py-3 hover:bg-gray-100 text-gray-700 font-medium">
                    Categorías
                </a>
            </li>


            {{-- Sliders --}}
            <li>
                <a href="{{ route('sliders.index') }}"
                   class="block px-6 py-3 hover:bg-gray-100 text-gray-700 font-medium">
                    Sliders
                </a>
            </li>

            {{-- Marcas --}}
            <li>
                <a href="{{ route('brands.index') }}"
                   class="block px-6 py-3 hover:bg-gray-100 text-gray-700 font-medium">
                    Marcas
                </a>
            </li>

            {{-- Órdenes --}}
            <li>
                <a href="{{ route('admin.orders.index') }}"
                   class="block px-6 py-3 hover:bg-gray-100 text-gray-700 font-medium">
                    Órdenes
                </a>
            </li>

            {{-- Clientes --}}
            <li>
                <a href="{{ route('admin.customers.index') }}"
                   class="block px-6 py-3 hover:bg-gray-100 text-gray-700 font-medium">
                    Clientes
                </a>
            </li>

        </ul>
    </nav>
</aside>