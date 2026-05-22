<x-front-layout>

    <div class="max-w-7xl mx-auto py-12 px-6">

        <h1 class="text-3xl font-bold mb-6">
            Productos de {{ $category->name }}
        </h1>

        @if($products->count())
            <!-- Añadimos un ID al contenedor para poder insertar los productos nuevos ahí -->
            <div id="products-wrapper" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>

            <!-- Este elemento nos sirve de ancla. Cuando sea visible en pantalla, cargará más -->
            <div id="infinite-scroll-trigger" class="mt-12 text-center" data-next-page="{{ $products->nextPageUrl() }}">
                <div id="loading-spinner" class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-solid border-gray-600 border-r-transparent hidden" role="status"></div>
            </div>

        @else
            <p class="text-gray-600">No hay productos disponibles para esta categoria.</p>
        @endif

    </div>

    <!-- Script para controlar el scroll infinito -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const trigger = document.getElementById('infinite-scroll-trigger');
            const wrapper = document.getElementById('products-wrapper');
            const spinner = document.getElementById('loading-spinner');
            
            if (!trigger) return;

            let nextPageUrl = trigger.getAttribute('data-next-page');
            let isLoading = false;

            // El IntersectionObserver vigila cuándo aparece el trigger en la pantalla
            const observer = new IntersectionObserver((entries) => {
                if (entries[0].isIntersecting && nextPageUrl && !isLoading) {
                    loadMoreProducts();
                }
            }, {
                rootMargin: '100px' // Se activa 100px antes de llegar al fondo absoluto para mejorar la experiencia
            });

            observer.observe(trigger);

            function loadMoreProducts() {
                isLoading = true;
                spinner.classList.remove('hidden');

                fetch(nextPageUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest' // Esto le dice a Laravel que es una petición AJAX
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Insertamos las nuevas tarjetas al final del contenedor existente
                    wrapper.insertAdjacentHTML('beforeend', data.html);
                    
                    // Actualizamos la URL de la siguiente página
                    nextPageUrl = data.nextPageUrl;
                    
                    if (!nextPageUrl) {
                        // Si ya no hay más páginas, dejamos de observar el trigger
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