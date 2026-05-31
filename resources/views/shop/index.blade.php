<x-front-layout>

    {{-- Contenedor del Breadcrumb forzado --}}
    <div class="ap-breadcrumb-container">
        <x-breadcrumb :items="[['label' => 'Productos']]" />
    </div>

    {{-- Layout unificado: Filtros a la izquierda, Productos a la derecha --}}
    <div class="ap-catalog-layout">

        {{-- Sidebar de filtros fijo a la izquierda --}}
        <aside class="ap-sidebar">
            <h3 class="ap-sidebar__title">Filtros</h3>

            <form method="GET" action="{{ route('shop.index') }}">

                {{-- Categorías --}}
                <div class="ap-sidebar__section">
                    <h4 class="ap-sidebar__section-title">Categorías</h4>
                    <ul style="list-style: none; padding: 0; display: flex; flex-direction: column; gap: 6px;">
                        @foreach($categories as $category)
                            <li>
                                <label class="ap-sidebar__label">
                                    <input type="radio" name="category" value="{{ $category->id }}"
                                           class="ap-sidebar__radio"
                                           {{ request('category') == $category->id ? 'checked' : '' }}
                                           onchange="this.form.submit()">
                                    <span>{{ $category->name }}</span>
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Marcas --}}
                <div class="ap-sidebar__section">
                    <h4 class="ap-sidebar__section-title">Marcas</h4>
                    <ul style="list-style: none; padding: 0; display: flex; flex-direction: column; gap: 6px;">
                        @foreach($brands as $brand)
                            <li>
                                <label class="ap-sidebar__label">
                                    <input type="checkbox" name="brands[]" value="{{ $brand->id }}"
                                           class="ap-sidebar__checkbox"
                                           {{ in_array($brand->id, (array)request('brands')) ? 'checked' : '' }}
                                           onchange="this.form.submit()">
                                    <span>{{ $brand->name }}</span>
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Rango de Precios --}}
                <div class="ap-sidebar__section">
                    <h4 class="ap-sidebar__section-title">Precio</h4>
                    <div class="ap-sidebar__price-inputs">
                        <div class="ap-sidebar__price-field">
                            <span class="ap-sidebar__price-symbol">$</span>
                            <input type="number" name="min_price" placeholder="Mín" 
                                   value="{{ request('min_price') }}" class="ap-sidebar__input">
                        </div>
                        <span style="color: var(--text-muted); font-size: 13px;">–</span>
                        <div class="ap-sidebar__price-field">
                            <span class="ap-sidebar__price-symbol">$</span>
                            <input type="number" name="max_price" placeholder="Máx" 
                                   value="{{ request('max_price') }}" class="ap-sidebar__input">
                        </div>
                    </div>
                    <button type="submit" class="ap-sidebar__btn-submit">Filtrar precio</button>
                </div>

                {{-- Botón limpiar filtros si hay alguno activo --}}
                @if(request()->anyFilled(['category', 'brands', 'min_price', 'max_price']))
                    <a href="{{ route('shop.index') }}" class="ap-sidebar__btn-clear">
                        Limpiar filtros
                    </a>
                @endif

            </form>
        </aside>

        {{-- Sección principal de la vitrina comercial --}}
        <main class="ap-catalog-main">

            <div class="ap-catalog__header">
                <span class="ap-catalog__count">
                    Mostrando {{ $products->count() }} de {{ $products->total() }} repuestos encontrados
                </span>
            </div>

            {{-- Contenedor dinámico de productos --}}
            <div id="products-wrapper" class="ap-catalog-grid">
                @forelse($products as $product)
                    <x-product-card :product="$product" />
                @empty
                    <div class="ap-catalog__empty" style="grid-column: 1 / -1;">
                        <div class="ap-catalog__empty-icon">🔍</div>
                        <h4 class="ap-catalog__empty-title">No encontramos resultados</h4>
                        <p class="ap-catalog__empty-text">Prueba cambiando los filtros seleccionados o la palabra clave.</p>
                    </div>
                @endforelse
            </div>

            {{-- Trigger para el Scroll Infinito --}}
            @if($products->hasMorePages())
                <div id="infinite-scroll-trigger" class="ap-infinite-trigger" data-next-page="{{ $products->nextPageUrl() }}">
                    <div id="infinite-scroll-spinner" class="ap-spinner-wheel hidden"></div>
                </div>
            @endif

        </main>

    </div>

    {{-- Script JavaScript de Scroll Infinito Adaptado para mantener el Layout --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const trigger = document.getElementById('infinite-scroll-trigger');
            const spinner = document.getElementById('infinite-scroll-spinner');
            const wrapper = document.getElementById('products-wrapper');

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