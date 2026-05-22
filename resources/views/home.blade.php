<x-front-layout :sliders="$sliders" :brands="[]">

<style>
   
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
    <div class="cat-section__inner">
        <p class="section-eyebrow">Explora nuestra colección</p>
        <h2 class="section-title">Pulseras por <em>piedra</em> y propósito</h2>

        <div class="cat-grid">
            @forelse($categories as $category)
                <a href="{{ route('shop.byCategory', $category->slug) }}" class="cat-card">
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
            @empty
                <p style="grid-column:1/-1;text-align:center;color:var(--ap-stone)">
                    Sin categorías disponibles aún.
                </p>
            @endforelse
        </div>
    </div>
</section>
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
        <p class="section-eyebrow">Recién llegadas</p>
        <h2 class="section-title">Nuevas <em>piezas</em> para ti</h2>

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

{{-- ╔══════════════════════╗
     ║  Newsletter          ║
     ╚══════════════════════╝ --}}
<section class="newsletter-section">
    <div class="newsletter-inner">
        <p class="newsletter-eyebrow">Comunidad holística</p>
        <h2 class="newsletter-title">Únete a nuestra <em>energía</em></h2>
        <p class="newsletter-sub">
            Recibe rituales de uso, guías de piedras y ofertas exclusivas directamente en tu correo.
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

{{-- ╔══════════════════════╗
     ║  Latest news         ║
     ╚══════════════════════╝ --}}
<x-latest-news />

{{-- ╔══════════════════════╗
     ║  Promo strip         ║
     ╚══════════════════════╝ --}}
<div class="promo-strip">
    <h2>Encuentra tu <em>piedra</em> perfecta</h2>
    <p>Cada pulsera lleva consigo siglos de energía natural y propósito</p>
    <a href="{{ route('shop.index') }}">Explorar colección</a>
</div>

</x-front-layout>