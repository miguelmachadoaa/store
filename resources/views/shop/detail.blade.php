<x-front-layout>
    @section('title', $product->meta_title ?: $product->name . ' - ' . config('app.name'))
    @section('meta_description', $product->meta_description ?: Str::limit(strip_tags($product->description), 160))

   

    <div class="max-w-7xl mx-auto pt-6 px-6">
        <x-breadcrumb :items="[
        ['label' => 'Productos', 'url' => route('shop.index')],
        ['label' => $product->category->name ?? 'Sin Categoría', 'url' => $product->category ? route('shop.byCategory', $product->category->slug) : null],
        ['label' => $product->name]
    ]" />
    </div>

    <div class="max-w-7xl mx-auto py-4 px-6 grid grid-cols-1 lg:grid-cols-2 gap-10">

        {{-- Galería de imágenes --}}
        <div>
            {{-- Imagen principal con Zoom --}}
            <div class="relative overflow-hidden rounded-lg shadow cursor-zoom-in group mb-4"
                x-data="{ zoom: false, x: 0, y: 0 }"
                @mousemove="x = ($event.offsetX / $event.target.offsetWidth) * 100; y = ($event.offsetY / $event.target.offsetHeight) * 100"
                @mouseenter="zoom = true" @mouseleave="zoom = false">

                <img id="main-image" src="{{ asset('storage/' . $product->image) }}"
                    class="w-full h-[500px] object-contain bg-white transition-transform duration-300"
                    :style="zoom ? `transform: scale(2); transform-origin: ${x}% ${y}%` : ''">
            </div>

            {{-- Slider de Miniaturas (Swiper) --}}
            <div class="swiper thumbSwiper">
                <div class="swiper-wrapper">
                    {{-- Imagen principal --}}
                    <div class="swiper-slide cursor-pointer">
                        <img src="{{ asset('storage/' . $product->image) }}"
                            class="h-24 w-full object-cover rounded border thumb-item active"
                            onclick="changeMainImage('{{ asset('storage/' . $product->image) }}', this)">
                    </div>

                    {{-- Imágenes adicionales --}}
                    @foreach($product->images as $img)
                        <div class="swiper-slide cursor-pointer">
                            <img src="{{ asset('storage/' . $img->image) }}"
                                class="h-24 w-full object-cover rounded border thumb-item"
                                onclick="changeMainImage('{{ asset('storage/' . $img->image) }}', this)">
                        </div>
                    @endforeach
                </div>
                {{-- Navegación --}}
                <div class="swiper-button-next !text-pink-600 !w-6 !h-6 after:text-sm"></div>
                <div class="swiper-button-prev !text-pink-600 !w-6 !h-6 after:text-sm"></div>
            </div>
        </div>


        {{-- Información del producto --}}
        <div>

            @php
                $showUsd = $storeSettings->showUsd();
                $showBs = $storeSettings->showBs();
            @endphp

            {{-- Marca --}}
            @if($product->brand)
                <a href="{{ route('shop.byBrand', $product->brand->slug) }}"
                    class="text-sm text-pink-600 font-semibold hover:underline">
                    {{ $product->brand->name }}
                </a>
            @endif

            {{-- Título --}}
            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>

            {{-- Valoración Promedio --}}
            <div class="flex items-center gap-2 mb-4">
                <div class="flex text-yellow-400">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= floor($product->average_rating))
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @elseif($i - $product->average_rating < 1)
                            <svg class="w-5 h-5 fill-current opacity-50" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @else
                            <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endif
                    @endfor
                </div>
                <span class="text-sm font-medium text-gray-500">({{ $product->approvedReviews->count() }}
                    reseñas)</span>
            </div>

            {{-- Categoría --}}
            @if($product->category)
                <p class="text-gray-500 text-sm mt-1">
                    Categoría:
                    <a href="{{ route('shop.index', ['category' => $product->category_id]) }}"
                        class="text-pink-600 hover:underline">
                        {{ $product->category->name }}
                    </a>
                </p>
            @endif

            {{-- Precio --}}
            <div class="mt-4">
                <div class="flex flex-col items-start gap-1">
                    @if($showUsd)
                        <p class="text-4xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</p>
                    @endif

                    @if($showBs)
                        <p class="text-2xl font-semibold text-gray-600">Bs. {{ number_format($product->price_bs, 2) }}</p>
                    @endif
                </div>

                @if($product->compare_price)
                    <p class="text-gray-500 line-through mt-2">
                        @if($showUsd)
                            ${{ number_format($product->compare_price, 2) }}
                        @endif
                        @if($showUsd && $showBs) / @endif
                        @if($showBs)
                            Bs. {{ number_format($product->compare_price_bs, 2) }}
                        @endif
                    </p>
                @endif
            </div>

            {{-- Stock --}}
            <p class="mt-2 text-sm {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                {{ $product->stock > 0 ? 'En stock' : 'Agotado' }}
            </p>

            {{-- Contenedor Principal: Alinea Carrito, Comprar Ya y Favoritos uno al lado del otro --}}
<div class="mt-6 flex flex-row items-center gap-3 w-full">
    
    {{-- 1. Botón Agregar al Carrito (Componente Original intacto) --}}
        <div class="flex-1 min-w-0">
            <x-add-to-cart-button :product="$product" />
        </div>

        {{-- 2. Botón Comprar Ya (Maquetado aquí para no alterar otras vistas) --}}
        @if($product->stock > 0)
            <div class="flex-1 min-w-0">
                <form action="{{ route('cart.buy-now', $product->id) }}" method="POST" class="m-0 p-0">
                    @csrf
                    <button type="submit" 
                        class="w-full bg-[#db2777] hover:bg-[#be185d] text-white border-none font-medium text-[0.75rem] uppercase tracking-[0.08em] cursor-pointer flex items-center justify-center gap-2 transition-all duration-200 active:scale-95 shadow-sm"
                        style="border-radius: 2rem; padding: 0.6rem 1rem; font-family: 'DM Sans', sans-serif; height: 42px;">
                        
                        {{-- Ícono de la bolsa de compras --}}
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" 
                            stroke="currentColor" stroke-width="2" 
                            stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0">
                            <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span class="truncate">Comprar ya</span>
                    </button>
                </form>
            </div>
        @endif

                @auth
                    <button onclick="toggleWishlist({{ $product->id }}, this)"
                        class="p-3 bg-white border border-gray-200 rounded-lg shadow-sm {{ $product->isFavoritedBy(auth()->user()) ? 'text-pink-600' : 'text-gray-400' }} hover:scale-110 transition z-10"
                        title="Agregar a favoritos">
                        <svg class="w-8 h-8 fill-current" viewBox="0 0 24 24">
                            <path
                                d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                        </svg>
                    </button>
                @else
                    <a href="{{ route('login') }}"
                        class="p-3 bg-white border border-gray-200 rounded-lg shadow-sm text-gray-400 hover:text-pink-600 hover:scale-110 transition z-10"
                        title="Inicia sesión para agregar a favoritos">
                        <svg class="w-8 h-8 fill-current" viewBox="0 0 24 24">
                            <path
                                d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                        </svg>
                    </a>
                @endauth
            </div>

            {{-- Descripción --}}
            <div class="mt-8">
                <h3 class="text-xl font-semibold mb-2">Descripción</h3>
                <p class="text-gray-700 leading-relaxed">
                    {!! nl2br(e($product->description)) !!}
                </p>
            </div>

        </div>

    </div>

    {{-- Productos relacionados --}}
    <div class="max-w-7xl mx-auto px-6 mt-12">
        <h2 class="text-2xl font-bold mb-6">Productos relacionados</h2>

        @if($related->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($related as $item)
                    <x-product-card :product="$item" />
                @endforeach
            </div>
        @else
            <p class="text-gray-500">No hay productos relacionados.</p>
        @endif
    </div>


        {{-- Sección de Reseñas --}}
        <div class="mt-16 border-t pt-10">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                {{-- Resumen y Formulario --}}
                <div class="lg:col-span-1">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Reseñas de Clientes</h2>
                    
                    <div class="flex items-center gap-4 mb-6">
                        <span class="text-5xl font-bold text-gray-900">{{ $product->average_rating }}</span>
                        <div>
                            <div class="flex text-yellow-400">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= floor($product->average_rating) ? 'fill-current' : 'text-gray-300 fill-current' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </div>
                            <p class="text-sm text-gray-500 mt-1">Basado en {{ $product->approvedReviews->count() }} opiniones</p>
                        </div>
                    </div>

                    @auth
                        @php $userReview = $product->reviews()->where('user_id', auth()->id())->first(); @endphp
                        
                        @if(!$userReview)
                            <div class="bg-gray-50 p-6 rounded-lg border">
                                <h3 class="font-bold text-gray-900 mb-4">Escribe una reseña</h3>
                                <form action="{{ route('products.reviews.store', $product->id) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tu Valoración</label>
                                        <div class="flex gap-2" x-data="{ rating: 5 }">
                                            @for($i = 1; $i <= 5; $i++)
                                                <button type="button" @click="rating = {{ $i }}" class="focus:outline-none">
                                                    <svg class="w-8 h-8 transition-colors" :class="rating >= {{ $i }} ? 'text-yellow-400 fill-current' : 'text-gray-300 fill-current'" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                </button>
                                            @endfor
                                            <input type="hidden" name="rating" :value="rating">
                                        </div>
                                    </div>
                                    <div>
                                        <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">Tu Comentario</label>
                                        <textarea id="comment" name="comment" rows="3" required
                                            class="w-full border-gray-300 focus:border-pink-500 focus:ring-pink-500 rounded-lg shadow-sm"
                                            placeholder="¿Qué te pareció el producto?"></textarea>
                                    </div>
                                    <button type="submit" class="w-full bg-pink-600 text-white py-2 rounded-lg font-bold hover:bg-pink-700 transition">
                                        Enviar Reseña
                                    </button>
                                    <p class="text-xs text-gray-500 text-center italic">Su reseña será moderada antes de publicarse.</p>
                                </form>
                            </div>
                        @else
                            <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 text-blue-800 text-sm">
                                Ya has enviado una reseña para este producto. Gracias por tu opinión.
                            </div>
                        @endif
                    @else
                        <div class="bg-gray-50 p-6 rounded-lg border text-center">
                            <p class="text-gray-600 mb-4">Debes iniciar sesión para dejar una reseña.</p>
                            <a href="{{ route('login') }}" class="inline-block bg-gray-900 text-white px-6 py-2 rounded-lg font-bold hover:bg-gray-800 transition">
                                Iniciar Sesión
                            </a>
                        </div>
                    @endauth
                </div>

                {{-- Listado de Reseñas --}}
                <div class="lg:col-span-2">
                    <div class="space-y-8">
                        @forelse($product->approvedReviews()->latest()->get() as $review)
                            <div class="border-b pb-8">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-3">
                                        <span class="font-bold text-gray-900">{{ $review->user->name }}</span>
                                        @if($product->hasUserPurchased($review->user))
                                            <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-xs font-bold px-2 py-0.5 rounded-full">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                                Compra Verificada
                                            </span>
                                        @endif
                                    </div>
                                    <span class="text-sm text-gray-500">{{ $review->created_at->format('d M, Y') }}</span>
                                </div>
                                <div class="flex text-yellow-400 mb-3">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-300 fill-current' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @endfor
                                </div>
                                <p class="text-gray-600 leading-relaxed">{{ $review->comment }}</p>
                            </div>
                        @empty
                            <div class="text-center py-10 bg-gray-50 rounded-lg">
                                <p class="text-gray-500">No hay reseñas aprobadas todavía. ¡Sé el primero en opinar!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .thumb-item.active {
            border-color: #db2777;
            /* pink-600 */
            border-width: 2px;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Inicializar Swiper para miniaturas
            new Swiper(".thumbSwiper", {
                slidesPerView: 4,
                spaceBetween: 10,
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                breakpoints: {
                    640: { slidesPerView: 4 },
                    1024: { slidesPerView: 5 },
                }
            });
        });

        function changeMainImage(src, el) {
            // Cambiar imagen principal
            document.getElementById('main-image').src = src;

            // Actualizar clase activa
            document.querySelectorAll('.thumb-item').forEach(img => {
                img.classList.remove('active');
            });
            el.classList.add('active');
        }
    </script>

</x-front-layout>