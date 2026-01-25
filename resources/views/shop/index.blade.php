<x-front-layout>

    <div class="max-w-7xl mx-auto py-12 px-6 grid grid-cols-1 md:grid-cols-4 gap-8">

        {{-- Sidebar de filtros --}}
        <aside class="bg-white p-6 rounded-lg shadow border h-fit">

            <h3 class="text-lg font-bold mb-4">Filtros</h3>

            <form method="GET" action="{{ route('shop.index') }}" class="space-y-6">

                {{-- Categorías --}}
                <div>
                    <h4 class="font-semibold mb-2">Categorías</h4>
                    <ul class="space-y-1">
                        @foreach($categories as $category)
                            <li>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="category" value="{{ $category->id }}"
                                           {{ request('category') == $category->id ? 'checked' : '' }}>
                                    <span>{{ $category->name }}</span>
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>

               {{-- Marcas --}}
                <div>
                    <h4 class="font-semibold mb-2">Marcas</h4>
                    <ul class="space-y-1">
                        @foreach($brands as $brand)
                            <li>
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="brand[]" value="{{ $brand->id }}"
                                        {{ collect(request('brand'))->contains($brand->id) ? 'checked' : '' }}>
                                    <span>{{ $brand->name }}</span>
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Precio --}}
                <div>
                    <h4 class="font-semibold mb-2">Precio</h4>
                    <div class="flex gap-2">
                        <input type="number" name="min_price" placeholder="Min"
                               value="{{ request('min_price') }}"
                               class="w-full border rounded p-2">
                        <input type="number" name="max_price" placeholder="Max"
                               value="{{ request('max_price') }}"
                               class="w-full border rounded p-2">
                    </div>
                </div>

                {{-- Ordenar --}}
                <div>
                    <h4 class="font-semibold mb-2">Ordenar por</h4>
                    <select name="sort" class="w-full border rounded p-2">
                        <option value="">Por defecto</option>
                        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Precio: Menor a Mayor</option>
                        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Precio: Mayor a Menor</option>
                    </select>
                </div>

                <button class="w-full bg-pink-600 text-white py-2 rounded hover:bg-pink-700">
                    Aplicar Filtros
                </button>

                <a href="{{ route('shop.index') }}"
                   class="block text-center bg-gray-200 py-2 rounded hover:bg-gray-300">
                    Limpiar
                </a>

            </form>

        </aside>

        {{-- Listado de productos --}}
        <section class="md:col-span-3">

            <h2 class="text-2xl font-bold mb-6">Productos</h2>

            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $products->appends(request()->query())->links() }}
                </div>


            @else
                <p class="text-gray-600">No se encontraron productos con los filtros seleccionados.</p>
            @endif

        </section>

    </div>

</x-front-layout>