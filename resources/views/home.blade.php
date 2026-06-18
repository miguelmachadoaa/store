<x-front-layout :sliders="$sliders" :brands="[]">

<style>
    .categories-swiper {
        width: 100%;
        padding: 10px 0;
    }

    /* Estilización y reubicación de las flechas de Swiper */
    .cat-swiper-btn-prev,
    .cat-swiper-btn-next {
        color: var(--warm-orange, #FFC933) !important; /* Tu color de acento */
        background-color: #FFFFFF;
        width: 40px !important;
        height: 40px !important;
        border-radius: 50%;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        top: 60% !important; /* Centrado vertical con respecto a las tarjetas */
        transition: all 0.2s ease;
    }

    /* Reducir el tamaño de la flecha interna de Swiper */
    .cat-swiper-btn-prev::after,
    .cat-swiper-btn-next::after {
        font-size: 16px !important;
        font-weight: bold;
    }

    .cat-swiper-btn-prev:hover,
    .cat-swiper-btn-next:hover {
        background-color: var(--warm-orange, #FFC933);
        color: #FFFFFF !important;
        transform: scale(1.05);
    }

    /* Posicionamiento exacto en los extremos del contenedor interior */
    .cat-swiper-btn-prev { left: 0px !important; }
    .cat-swiper-btn-next { right: 0px !important; }

    /* Ocultar flechas si están deshabilitadas (ej. pocos elementos) */
    .swiper-button-disabled {
        opacity: 0 !important;
        pointer-events: none;
    }
</style>

{{-- ╔══════════════════════╗
     ║  Trust bar           ║
     ╚══════════════════════╝ --}}
<div class="trust-bar">
    <div class="trust-bar__inner">
        @foreach([
            ['icon' => '💬', 'title' => 'Soporte 24/7',        'sub' => 'Siempre disponibles para ti'],
            ['icon' => '🚚', 'title' => 'Envío gratuito',       'sub' => 'En pedidos desde $30'],
            ['icon' => '🔒', 'title' => 'Pago seguro',          'sub' => 'Cifrado SSL garantizado'],
            ['icon' => '✨', 'title' => 'Garantía de energía',  'sub' => 'Piedras certificadas'],
        ] as $trust)
            <div class="trust-item">
                <div class="trust-item__icon">{{ $trust['icon'] }}</div>
                <div class="trust-item__text">
                    <strong>{{ $trust['title'] }}</strong>
                    {{ $trust['sub'] }}
                </div>
            </div>
        @endforeach
    </div>
</div>

{{-- ╔══════════════════════╗
     ║  Categorías          ║
     ╚══════════════════════╝ --}}
@if(isset($categories) && $categories->count() > 0)
<section class="cat-section">
    <div class="cat-section__inner" style="position: relative; padding: 0 40px;"> {{-- Padding extra para las flechas laterales --}}
        

        {{-- Contenedor Principal de Swiper --}}
        <div class="swiper categories-swiper">
            <div class="swiper-wrapper">
                @foreach($categories as $category)
                    <div class="swiper-slide">
                        <a href="{{ route('shop.byCategory', $category->slug) }}" class="cat-card" style="margin: 0; width: 100%;">
                            <div class="cat-card__img">
                                @if($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}">
                                @else
                                    <div class="cat-card__placeholder">🔮</div>
                                @endif
                            </div>
                            <div class="cat-card__label">
                                {{ $category->name }}
                                <span>→</span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Flechas de Navegación (Ubicadas fuera del Swiper para que no tapen las tarjetas) --}}
        <div class="swiper-button-prev cat-swiper-btn-prev"></div>
        <div class="swiper-button-next cat-swiper-btn-next"></div>

    </div>
</section>

{{-- Estilos personalizados para integrar y posicionar las flechas --}}



@endif
{{-- ╔══════════════════════╗
     ║  Deal of the Week    ║
     ╚══════════════════════╝ --}}
<section class="products-section">
    <div class="products-section__inner">
        <div class="deal-banner">
            <div class="deal-banner__text">
                <p class="eyebrow">Oferta especial · Esta semana</p>
                <h2>Descuentos de hasta <em>50% off</em></h2>
            </div>
            <a href="{{ route('shop.index') }}" class="deal-banner__cta">Ver todas las ofertas →</a>
        </div>

        <div class="products-grid-4">
            @foreach($weeklyDeals as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </div>
</section>

{{-- ╔══════════════════════╗
     ║  Nuevos productos    ║
     ╚══════════════════════╝ --}}
<section class="products-section products-section--alt">
    <div class="products-section__inner">
        <p class="section-eyebrow">Recién llegados</p>
        <h2 class="section-title">Repuestos  <em>originales</em> para tu moto</h2>

        <div class="products-grid-3">
            @foreach($recentProducts as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>

        <div class="section-cta-wrap">
            <a href="{{ route('shop.index') }}" class="section-cta">Ver toda la tienda →</a>
        </div>
    </div>
</section>

    @foreach($categoriesFeature as $category)
        <x-category-feature :category="$category" />
    @endforeach

{{-- ╔══════════════════════╗
     ║  Newsletter          ║
     ╚══════════════════════╝ --}}
<section class="newsletter-section">
    <div class="newsletter-inner">
        <p class="newsletter-eyebrow">Comunidad de entusiastas</p>
        <h2 class="newsletter-title">Únete a nuestra <em>comunidad </em></h2>
        <p class="newsletter-sub">
            Recibe actualizaciones sobre nuevos productos, ofertas especiales y contenido exclusivo.
        </p>

        <form action="{{ route('newsletter.store') }}" method="POST" class="newsletter-form">
            @csrf
            <input type="email" name="email" class="newsletter-input"
                   placeholder="tucorreo@ejemplo.com" required>
            <button type="submit" class="newsletter-btn">Suscribirme</button>
        </form>

        @if(session('success'))
            <p class="newsletter-success">✦ {{ session('success') }}</p>
        @endif
    </div>
</section>

<x-latest-news />

<div class="promo-strip">
    <h2>Encuentra tu <em>repuesto</em> perfecto</h2>
    <p>Cada pieza lleva consigo años de calidad y durabilidad</p>
    <a href="{{ route('shop.index') }}">Explorar colección</a>
</div>


{{-- Inicialización de Swiper para esta sección --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Swiper('.categories-swiper', {
            slidesPerView: 1,
            spaceBetween: 16,
            grabCursor: true,
            // Configuración de flechas
            navigation: {
                nextEl: '.cat-swiper-btn-next',
                prevEl: '.cat-swiper-btn-prev',
            },
            // Puntos de quiebre responsivos (Breakpoints)
            breakpoints: {
                480: {
                    slidesPerView: 2,
                    spaceBetween: 16
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 20
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 24
                },
                1280: {
                    slidesPerView: 6, 
                    spaceBetween: 24
                }
            }
        });
    });
</script>


</x-front-layout>