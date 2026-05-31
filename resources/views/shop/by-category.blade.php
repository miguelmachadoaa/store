<x-front-layout>

    <div class="ap-breadcrumb-container">
        <x-breadcrumb :items="[
            ['label' => 'Productos', 'url' => route('shop.index')],
            ['label' => $category->name]
        ]" />
    </div>

    <div class="container-custom" style="padding-top: 20px; padding-bottom: 40px;">
        
        <div class="ap-catalog__header">
            <h1 class="section-title" style="margin-bottom: 0;">Repuestos de <em>{{ $category->name }}</em></h1>
            <span class="ap-catalog__count">
                Mostrando {{ $products->count() }} de {{ $products->total() }} artículos
            </span>
        </div>

        @if($products->count())
            <div id="products-wrapper" class="ap-catalog-grid">
                @foreach($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>

            @if($products->hasMorePages())
                <div id="infinite-scroll-trigger" class="ap-infinite-trigger" data-next-page="{{ $products->nextPageUrl() }}">
                    <div id="loading-spinner" class="ap-spinner-wheel hidden"></div>
                </div>
            @endif
        @else
            <div class="ap-catalog__empty">
                <div class="ap-catalog__empty-icon">📂</div>
                <h4 class="ap-catalog__empty-title">Sin productos</h4>
                <p class="ap-catalog__empty-text">No hay repuestos disponibles actualmente para esta categoría.</p>
            </div>
        @endif

    </div>

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
                    console.error('Error cargando más productos:', error);
                    isLoading = false;
                    spinner.classList.add('hidden');
                });
            }
        });
    </script>

</x-front-layout>