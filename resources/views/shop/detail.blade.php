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

    <div class="max-w-7xl mx-auto py-6 px-6 grid grid-cols-1 lg:grid-cols-2 gap-10">

        {{-- Galería de imágenes --}}
        <div>
            {{-- Imagen principal con Zoom --}}
            <div class="ap-gallery__main-wrapper"
                x-data="{ zoom: false, x: 0, y: 0 }"
                @mousemove="x = ($event.offsetX / $event.target.offsetWidth) * 100; y = ($event.offsetY / $event.target.offsetHeight) * 100"
                @mouseenter="zoom = true" @mouseleave="zoom = false">

                <img id="main-image" src="{{ asset('storage/' . $product->image) }}"
                    class="ap-gallery__main"
                    :style="zoom ? `transform: scale(2); transform-origin: ${x}% ${y}%` : ''"
                    alt="{{ $product->name }}">
            </div>

            {{-- Slider de Miniaturas (Swiper) --}}
            <div class="swiper thumbSwiper ap-gallery__carousel">
                <div class="swiper-wrapper">
                    {{-- Imagen principal --}}
                    <div class="swiper-slide">
                        <img src="{{ asset('storage/' . $product->image) }}"
                            class="ap-gallery__thumb thumb-item active"
                            onclick="changeMainImage('{{ asset('storage/' . $product->image) }}', this)"
                            alt="Miniatura {{ $product->name }}">
                    </div>

                    {{-- Imágenes adicionales --}}
                    @foreach($product->images as $img)
                        <div class="swiper-slide">
                            <img src="{{ asset('storage/' . $img->image) }}"
                                class="ap-gallery__thumb thumb-item"
                                onclick="changeMainImage('{{ asset('storage/' . $img->image) }}', this)"
                                alt="Miniatura adicional">
                        </div>
                    @endforeach
                </div>
                {{-- Navegación --}}
                <div class="swiper-button-next ap-gallery__nav-btn"></div>
                <div class="swiper-button-prev ap-gallery__nav-btn"></div>
            </div>
        </div>

        {{-- Información del producto --}}
        <div class="ap-product-info">
            @php
                $showUsd = $storeSettings->showUsd();
                $showBs = $storeSettings->showBs();
            @endphp

            {{-- Marca --}}
            @if($product->brand)
                <a href="{{ route('shop.byBrand', $product->brand->slug) }}" class="ap-product-info__brand">
                    {{ $product->brand->name }}
                </a>
            @endif

            {{-- Título --}}
            <h1 class="ap-product-info__title">{{ $product->name }}</h1>

            {{-- Valoración Promedio --}}
            <div class="ap-product-info__rating-row">
                <div class="ap-stars">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= floor($product->average_rating))
                            <svg class="ap-stars__icon active" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                        @elseif($i - $product->average_rating < 1)
                            <svg class="ap-stars__icon half" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                        @else
                            <svg class="ap-stars__icon" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                        @endif
                    @endfor
                </div>
                <span class="ap-product-info__reviews-count">({{ $product->approvedReviews->count() }} reseñas)</span>
            </div>

            {{-- Categoría --}}
            @if($product->category)
                <p class="ap-product-info__meta">
                    Categoría: <a href="{{ route('shop.index', ['category' => $product->category_id]) }}">{{ $product->category->name }}</a>
                </p>
            @endif

            {{-- Precios --}}
            <div class="ap-product-info__pricing-box">
                @if($showUsd)
                    <p class="ap-product-info__price-usd">${{ number_format($product->price, 2) }}</p>
                @endif

                @if($showBs)
                    <p class="ap-product-info__price-bs">Bs. {{ number_format($product->price_bs, 2) }}</p>
                @endif

                @if($product->compare_price)
                    <p class="ap-product-info__compare-price">
                        @if($showUsd) ${{ number_format($product->compare_price, 2) }} @endif
                        @if($showUsd && $showBs) / @endif
                        @if($showBs) Bs. {{ number_format($product->compare_price_bs, 2) }} @endif
                    </p>
                @endif
            </div>

            {{-- Stock Status --}}
            <p class="ap-product-info__stock {{ $product->stock > 0 ? 'in-stock' : 'out-of-stock' }}">
                {{ $product->stock > 0 ? '// EN STOCK' : '// AGOTADO' }}
            </p>

            {{-- Acciones de Compra --}}
            <div class="ap-product-info__actions">
                <div class="flex-1">
                    <x-add-to-cart-button :product="$product" />
                </div>

                @auth
                    <button onclick="toggleWishlist({{ $product->id }}, this)"
                        class="ap-btn-wishlist {{ $product->isFavoritedBy(auth()->user()) ? 'active' : '' }}"
                        title="Agregar a favoritos">
                        <svg viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" /></svg>
                    </button>
                @else
                    <a href="{{ route('login') }}" class="ap-btn-wishlist" title="Inicia sesión para agregar a favoritos">
                        <svg viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" /></svg>
                    </a>
                @endauth
            </div>

            {{-- Descripción Breve / Ficha --}}
            <div class="ap-product-info__description">
                <h3>Ficha Técnica / Descripción</h3>
                <p>{!! nl2br(e($product->description)) !!}</p>
            </div>
        </div>
    </div>

    {{-- Productos relacionados --}}
    <div class="max-w-7xl mx-auto px-6 mt-16">
        <h2 class="ap-detail-subtitle">Productos relacionados</h2>
        @if($related->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($related as $item)
                    <x-product-card :product="$item" />
                @endforeach
            </div>
        @else
            <div class="ap-catalog__empty"><p>No hay productos relacionados disponibles.</p></div>
        @endif
    </div>

    {{-- Sección de Reseñas --}}
    <div class="max-w-7xl mx-auto px-6 mt-20 ap-reviews-section">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            {{-- Panel Izquierdo: Resumen y Formulario --}}
            <div class="lg:col-span-1">
                <h2 class="ap-detail-subtitle !mb-4">Reseñas de Clientes</h2>
                
                <div class="ap-reviews-summary">
                    <span class="ap-reviews-summary__score">{{ number_format($product->average_rating, 1) }}</span>
                    <div>
                        <div class="ap-stars">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="ap-stars__icon {{ $i <= floor($product->average_rating) ? 'active' : '' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        <p class="ap-reviews-summary__count">Basado en {{ $product->approvedReviews->count() }} opiniones</p>
                    </div>
                </div>

                @auth
                    @php $userReview = $product->reviews()->where('user_id', auth()->id())->first(); @endphp
                    
                    @if(!$userReview)
                        <div class="ap-review-form-card">
                            <h3>Escribe una reseña</h3>
                            <form action="{{ route('products.reviews.store', $product->id) }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="ap-review-form-card__label">Tu Valoración</label>
                                    <div class="flex gap-2" x-data="{ rating: 5 }">
                                        @for($i = 1; $i <= 5; $i++)
                                            <button type="button" @click="rating = {{ $i }}" class="focus:outline-none">
                                                <svg class="ap-stars__icon clickable" :class="rating >= {{ $i }} ? 'active' : ''" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            </button>
                                        @endfor
                                        <input type="hidden" name="rating" :value="rating">
                                    </div>
                                </div>
                                <div>
                                    <label for="comment" class="ap-review-form-card__label">Tu Comentario</label>
                                    <textarea id="comment" name="comment" rows="3" required class="ap-review-form-card__input" placeholder="¿Qué te pareció el producto?"></textarea>
                                </div>
                                <button type="submit" class="ap-review-form-card__submit">
                                    Enviar Reseña
                                </button>
                                <p class="ap-review-form-card__foot-note">Su reseña será moderada antes de publicarse.</p>
                            </form>
                        </div>
                    @else
                        <div class="ap-alert-info">Ya has enviado una reseña para este producto. Gracias por tu opinión.</div>
                    @endif
                @else
                    <div class="ap-review-form-card text-center">
                        <p class="mb-4 text-sm text-gray-400">Debes iniciar sesión para dejar una reseña.</p>
                        <a href="{{ route('login') }}" class="ap-review-form-card__submit">Iniciar Sesión</a>
                    </div>
                @endauth
            </div>

            {{-- Panel Derecho: Listado de Reseñas --}}
            <div class="lg:col-span-2">
                <div class="space-y-6">
                    @forelse($product->approvedReviews()->latest()->get() as $review)
                        <div class="ap-review-row">
                            <div class="ap-review-row__header">
                                <div class="flex items-center gap-3">
                                    <span class="ap-review-row__author">{{ $review->user->name }}</span>
                                    @if($product->hasUserPurchased($review->user))
                                        <span class="ap-badge-verified">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                            Compra Verificada
                                        </span>
                                    @endif
                                </div>
                                <span class="ap-review-row__date">{{ $review->created_at->format('d M, Y') }}</span>
                            </div>
                            <div class="ap-stars mb-3">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="ap-stars__icon sm {{ $i <= $review->rating ? 'active' : '' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </div>
                            <p class="ap-review-row__text">{{ $review->comment }}</p>
                        </div>
                    @empty
                        <div class="ap-catalog__empty">
                            <p>No hay reseñas aprobadas todavía. ¡Sé el primero en opinar!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            if(typeof Swiper !== 'undefined') {
                new Swiper(".thumbSwiper", {
                    slidesPerView: 4,
                    spaceBetween: 10,
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    },
                    breakpoints: {
                        480: { slidesPerView: 4 },
                        1024: { slidesPerView: 5 },
                    }
                });
            }
        });

        function changeMainImage(src, el) {
            const mainImg = document.getElementById('main-image');
            if(mainImg) mainImg.src = src;

            document.querySelectorAll('.thumb-item').forEach(img => {
                img.classList.remove('active');
            });
            el.classList.add('active');
        }
    </script>
</x-front-layout>