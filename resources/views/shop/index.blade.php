<x-front-layout>

    <div class="max-w-7xl mx-auto pt-6 px-6">
        <x-breadcrumb :items="[['label' => 'Productos']]" />
    </div>

    <div class="max-w-7xl mx-auto py-8 px-6 grid grid-cols-1 md:grid-cols-4 gap-8">

        {{-- Sidebar de filtros --}}
        <aside class="ap-sidebar">

            <h3 class="ap-sidebar__title">Filtros</h3>

            <form method="GET" action="{{ route('shop.index') }}" class="space-y-6">

                {{-- Categorías --}}
                <div class="ap-sidebar__section">
                    <h4 class="ap-sidebar__section-title">Categorías</h4>
                    <ul class="space-y-2">
                        @foreach($categories as $category)
                            <li>
                                <label class="ap-sidebar__label">
                                    <input type="radio" name="category" value="{{ $category->id }}"
                                           class="ap-sidebar__radio"
                                           {{ request('category') == $category->id ? 'checked' : '' }}>
                                    <span>{{ $category->name }}</span>
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Marcas --}}
                <div class="ap-sidebar__section">
                    <h4 class="ap-sidebar__section-title">Marcas</h4>
                    <ul class="space-y-2">
                        @foreach($brands as $brand)
                            <li>
                                <label class="ap-sidebar__label">
                                    <input type="checkbox" name="brand[]" value="{{ $brand->id }}"
                                           class="ap-sidebar__checkbox"
                                           {{ collect(request('brand'))->contains($brand->id) ? 'checked' : '' }}>
                                    <span>{{ $brand->name }}</span>
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Precio --}}
                <div class="ap-sidebar__section">
                    <h4 class="ap-sidebar__section-title">Precio</h4>
                    <div class="flex gap-2">
                        <input type="number" name="min_price" placeholder="Mín"
                               value="{{ request('min_price') }}"
                               class="ap-sidebar__input">
                        <input type="number" name="max_price" placeholder="Máx"
                               value="{{ request('max_price') }}"
                               class="ap-sidebar__input">
                    </div>
                </div>

                {{-- Ordenar --}}
                <div class="ap-sidebar__section">
                    <h4 class="ap-sidebar__section-title">Ordenar por</h4>
                    <select name="sort" class="ap-sidebar__select">
                        <option value="">Por defecto</option>
                        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Precio: Menor a Mayor</option>
                        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Precio: Mayor a Menor</option>
                    </select>
                </div>

                <div class="pt-2 space-y-2">
                    <button type="submit" class="ap-sidebar__btn-submit">
                        Aplicar Filtros
                    </button>

                    <a href="{{ route('shop.index') }}" class="ap-sidebar__btn-clear">
                        Limpiar Filtros
                    </a>
                </div>

            </form>

        </aside>

        {{-- Listado de productos --}}
        <section class="md:col-span-3">

            <h2 class="ap-catalog__title">Productos disponibles</h2>

            @if($products->count() > 0)
                <div id="products-wrapper" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>

                {{-- Gatillo de scroll infinito --}}
                <div id="infinite-scroll-trigger" class="mt-12 text-center" data-next-page="{{ $products->nextPageUrl() }}">
                    <div id="loading-spinner" class="ap-catalog__spinner hidden" role="status"></div>
                </div>

            @else
                <div class="ap-catalog__empty">
                    <p>No se encontraron productos con los filtros seleccionados.</p>
                </div>
            @endif

        </section>

    </div>

    {{-- Script de Scroll Infinito --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const trigger = document.getElementById('infinite-scroll-trigger');
            const wrapper = document.getElementById('products-wrapper');
            const spinner = document.getElementById('loading-spinner');
            
            if (!trigger) return;

            let nextPageUrl = trigger.getAttribute('data-next-page');
            let isLoading = false;

            const observer = new IntersectionObserver((entries) => {
                if (entries[0].isIntersecting && nextPageUrl && !isLoading) {
                    loadMoreProducts();
                }
            }, {
                rootMargin: '150px'
            });

            observer.observe(trigger);

            function loadMoreProducts() {
                isLoading = true;
                spinner.classList.remove('hidden');

                fetch(nextPageUrl, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => response.json())
                .then(data => {
                    wrapper.insertAdjacentHTML('beforeend', data.html);
                    nextPageUrl = data.nextPageUrl;
                    
                    if (!nextPageUrl) {
                        observer.disconnect();
                        trigger.remove();
                    }
                    
                    isLoading = false;
                    spinner.classList.add('hidden');
                })
                .catch(error => {
                    console.error('Error al cargar más productos:', error);
                    isLoading = false;
                    spinner.classList.add('hidden');
                });
            }
        });
    </script>

</x-front-layout>