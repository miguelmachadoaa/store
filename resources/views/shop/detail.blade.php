<x-front-layout>
    @section('title', $product->meta_title ?: $product->name . ' - ' . config('app.name'))
    @section('meta_description', $product->meta_description ?: Str::limit(strip_tags($product->description), 160))

    <div class="ap-breadcrumb-container">
        <x-breadcrumb :items="[
            ['label' => 'Productos', 'url' => route('shop.index')],
            ['label' => $product->category->name ?? 'Sin Categoría', 'url' => $product->category ? route('shop.byCategory', $product->category->slug) : null],
            ['label' => $product->name]
        ]" />
    </div>

    {{-- Layout del Detalle --}}
    <div class="ap-detail-layout">

        {{-- Galería de imágenes (Izquierda) --}}
        <div>
            <div class="ap-gallery__main-wrapper"
                x-data="{ zoom: false, x: 0, y: 0 }"
                @mousemove="x = ($event.offsetX / $event.target.offsetWidth) * 100; y = ($event.offsetY / $event.target.offsetHeight) * 100"
                @mouseenter="zoom = true" @mouseleave="zoom = false">

                <img id="main-image" src="{{ asset('storage/' . $product->image) }}"
                    class="ap-gallery__main"
                    :style="zoom ? `transform: scale(2); transform-origin: ${x}% ${y}%;` : ''"
                    alt="{{ $product->name }}">
            </div>

            @if($product->images && count($product->images) > 0)
                <div class="thumb-slider-container">
                    <div class="swiper thumbSwiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="thumb-item active" onclick="changeMainImage('{{ asset('storage/' . $product->image) }}', this)">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="Principal">
                                </div>
                            </div>
                            @foreach($product->images as $additionalImage)
                                <div class="swiper-slide">
                                    <div class="thumb-item" onclick="changeMainImage('{{ asset('storage/' . $additionalImage) }}', this)">
                                        <img src="{{ asset('storage/' . $additionalImage) }}" alt="Adicional">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Panel de Información (Derecha) --}}
        <div class="ap-info-panel">
            <span class="section-eyebrow">{{ $product->brand->name ?? 'Genérico' }}</span>
            <h1>{{ $product->name }}</h1>
            
            <div class="ap-info-meta">
                Categoría: @if($product->category) <a href="{{ route('shop.byCategory', $product->category->slug) }}">{{ $product->category->name }}</a> @else Sin Categoría @endif
            </div>

            {{-- Bloque de Precios con Multimoneda Corregido --}}
            <div class="ap-info-price-card">
                @php
                    // Reemplazamos la función inexistente setting() por el sistema nativo config() de Laravel.
                    // Si no existen en tu config, por defecto se asumirá true para mostrar ambos.
                    $showUsd = config('shop.mostrar_precio_usd', true);
                    $showBs = config('shop.mostrar_precio_bs', true);
                @endphp

                @if($product->hasDiscount())
                    <div class="ap-info-price-primary has-discount">
                        @if($showUsd) ${{ number_format($product->price, 2) }} @endif
                        <span style="font-size: 14px; text-decoration: line-through; color: #888; margin-left: 10px;">
                            ${{ number_format($product->compare_price, 2) }}
                        </span>
                        <span style="font-size: 14px; color: #B12704; font-weight: bold; margin-left: 8px;">
                            −{{ $product->discount_percentage }}%
                        </span>
                    </div>
                    @if($showBs)
                        <div class="ap-info-price-secondary">
                            Bs. {{ number_format($product->price_bs, 2) }}
                            <span style="text-decoration: line-through; margin-left: 6px; font-size: 12px;">
                                Bs. {{ number_format($product->compare_price_bs, 2) }}
                            </span>
                        </div>
                    @endif
                @else
                    <div class="ap-info-price-primary">
                        @if($showUsd) ${{ number_format($product->price, 2) }} @endif
                    </div>
                    @if($showBs)
                        <div class="ap-info-price-secondary">
                            Bs. {{ number_format($product->price_bs, 2) }}
                        </div>
                    @endif
                @endif
            </div>

            <div class="ap-info-desc">
                <h3 class="ap-sidebar__section-title" style="margin-bottom: 8px;">Descripción del Repuesto</h3>
                {!! $product->description !!}
            </div>

            <div style="max-width: 300px; margin-top: 20px;">
                <x-add-to-cart-button :product="$product" />
            </div>
        </div>

    </div>

    {{-- Bloque Inferior Separado de Reseñas --}}
    <div class="ap-reviews-section">
        <div class="ap-reviews-layout">
            
            {{-- Crear Reseña --}}
            <div class="ap-review-form-card">
                <h3>Escribe una reseña</h3>
                @auth
                    <form action="{{ route('reviews.store', $product->id) }}" method="POST">
                        @csrf
                        <div class="ap-form-group">
                            <label for="rating">Calificación</label>
                            <select name="rating" id="rating" class="ap-form-control" required>
                                <option value="5">★★★★★ (5/5)</option>
                                <option value="4">★★★★☆ (4/5)</option>
                                <option value="3">★★★☆☆ (3/5)</option>
                                <option value="2">★★☆☆☆ (2/5)</option>
                                <option value="1">★☆☆☆☆ (1/5)</option>
                            </select>
                        </div>
                        <div class="ap-form-group">
                            <label for="comment">Tu Comentario</label>
                            <textarea name="comment" id="comment" rows="4" class="ap-form-control" placeholder="¿Qué te pareció la calidad de esta pieza?" required></textarea>
                        </div>
                        <button type="submit" class="ap-sidebar__btn-submit" style="padding: 11px 0;">Enviar Opinión</button>
                    </form>
                @else
                    <p style="font-size: 13px; color: var(--text-muted);">
                        Debes <a href="{{ route('login') }}" style="color:var(--text-link); font-weight:bold;">iniciar sesión</a> para calificar este producto.
                    </p>
                @endauth
            </div>

            {{-- Listado de Reseñas --}}
            <div class="ap-reviews-list">
                <h3>Opiniones de Compradores</h3>
                <div style="display: flex; flex-direction: column;">
                    @forelse($product->reviews()->where('is_approved', true)->latest()->get() as $review)
                        <div class="ap-review-row">
                            <div class="ap-review-row__meta">
                                {{ $review->user->name }}
                                <span class="ap-review-row__date">{{ $review->created_at->format('d/m/Y') }}</span>
                            </div>
                            <div class="ap-review-row__stars">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating) ★ @else ☆ @endif
                                @endfor
                            </div>
                            <p class="ap-review-row__text">{{ $review->comment }}</p>
                        </div>
                    @empty
                        <div class="ap-catalog__empty" style="padding: 30px 20px;">
                            <p class="ap-catalog__empty-text">Este repuesto aún no tiene reseñas. ¡Sé el primero en aportar!</p>
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