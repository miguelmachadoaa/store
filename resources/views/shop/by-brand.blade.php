<x-front-layout>

    <div class="max-w-7xl mx-auto py-12 px-6">

        <h1 class="text-3xl font-bold mb-6">
            Productos de {{ $brand->name }}
        </h1>

        @if($products->count())
            <!-- Añadimos el ID 'products-wrapper' para meter los nuevos productos aquí -->
            <div id="products-wrapper" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>

            <!-- Div oculto que detecta cuando el usuario llega al final de la página -->
            <div id="infinite-scroll-trigger" class="mt-12 text-center" data-next-page="{{ $products->nextPageUrl() }}">
                <div id="loading-spinner" class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-solid border-gray-600 border-r-transparent hidden" role="status"></div>
            </div>

        @else
            <p class="text-gray-600">No hay productos disponibles para esta marca.</p>
        @endif

    </div>

    <!-- Script de Scroll Infinito -->
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
                rootMargin: '100px' // Se activa un poco antes de tocar el fondo total
            });

            observer.observe(trigger);

            function loadMoreProducts() {
                isLoading = true;
                spinner.classList.remove('hidden');

                fetch(nextPageUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Inyectamos el HTML de las nuevas tarjetas de productos
                    wrapper.insertAdjacentHTML('beforeend', data.html);
                    
                    // Actualizamos el link de la siguiente página
                    nextPageUrl = data.nextPageUrl;
                    
                    // Si ya no hay más páginas que cargar, limpiamos el observador
                    if (!nextPageUrl) {
                        observer.disconnect();
                        trigger.remove();
                    }
                    
                    isLoading = false;
                    spinner.classList.add('hidden');
                })
                .catch(error => {
                    console.error('Error al cargar más productos de la marca:', error);
                    isLoading = false;
                    spinner.classList.add('hidden');
                });
            }
        });
    </script>

</x-front-layout>