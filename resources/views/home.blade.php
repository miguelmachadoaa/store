<x-front-layout :sliders="$sliders" :brands="[]">

<style>
    /* ─── Shared tokens ─── */
    :root {
        --ap-amethyst:     #4A2C6E;
        --ap-amethyst-mid: #6B3F9E;
        --ap-amethyst-lt:  #C9A8E8;
        --ap-amethyst-pale:#F3EDF9;
        --ap-gold:         #C8973A;
        --ap-gold-lt:      #E8C97A;
        --ap-gold-pale:    #FDF6E3;
        --ap-stone:        #8B7355;
        --ap-stone-lt:     #C4B49A;
        --ap-stone-pale:   #F7F3EE;
        --ap-dark:         #1A1020;
        --ap-dark-mid:     #2D1F3D;
    }

    /* ─── Section headings ─── */
    .section-eyebrow {
        font-family: 'DM Sans', sans-serif;
        font-size: 0.68rem;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: var(--ap-gold);
        margin: 0 0 0.4rem;
    }
    .section-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2rem;
        font-weight: 400;
        color: var(--ap-dark-mid);
        margin: 0 0 2rem;
        line-height: 1.2;
    }
    .section-title em {
        font-style: italic;
        color: var(--ap-amethyst-mid);
    }

    /* ─── Trust bar ─── */
    .trust-bar {
        background: var(--ap-dark);
        padding: 1.75rem 0;
    }
    .trust-bar__inner {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 2rem;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.25rem;
    }
    @media (min-width: 768px) {
        .trust-bar__inner { grid-template-columns: repeat(4, 1fr); }
    }
    .trust-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .trust-item__icon {
        width: 40px;
        height: 40px;
        background: rgba(200,151,58,0.15);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }
    .trust-item__text {
        font-family: 'DM Sans', sans-serif;
        font-size: 0.78rem;
        font-weight: 400;
        color: rgba(255,255,255,0.65);
        line-height: 1.4;
    }
    .trust-item__text strong {
        display: block;
        color: var(--ap-gold-lt);
        font-weight: 500;
        font-size: 0.82rem;
        margin-bottom: 0.1rem;
    }

    /* ─── Category grid ─── */
    .cat-section {
        padding: 4rem 0;
        background: var(--ap-stone-pale);
    }
    .cat-section__inner {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 2rem;
    }
    .cat-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.25rem;
    }
    @media (min-width: 640px) { .cat-grid { grid-template-columns: repeat(3, 1fr); } }
    @media (min-width: 1024px) { .cat-grid { grid-template-columns: repeat(4, 1fr); } }

    .cat-card {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        background: #fff;
        text-decoration: none;
        display: block;
        box-shadow: 0 2px 12px rgba(74,44,110,0.07);
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .cat-card:hover { transform: translateY(-4px); box-shadow: 0 10px 30px rgba(74,44,110,0.14); }

    .cat-card__img {
        aspect-ratio: 4/3;
        overflow: hidden;
        background: var(--ap-amethyst-pale);
    }
    .cat-card__img img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }
    .cat-card:hover .cat-card__img img { transform: scale(1.06); }
    .cat-card__placeholder {
        width: 100%; height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
    }

    .cat-card__label {
        padding: 0.75rem 1rem;
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.05rem;
        font-weight: 400;
        color: var(--ap-dark-mid);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .cat-card__label span {
        font-size: 0.9rem;
        color: var(--ap-amethyst-mid);
        opacity: 0;
        transform: translateX(-4px);
        transition: opacity 0.2s, transform 0.2s;
    }
    .cat-card:hover .cat-card__label span { opacity: 1; transform: translateX(0); }

    /* ─── Products grid ─── */
    .products-section {
        padding: 4.5rem 0;
        background: #FAF8F5;
    }
    .products-section--alt { background: #fff; }
    .products-section__inner {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 2rem;
    }
    .products-grid-4 {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 1.5rem;
    }
    @media (min-width: 640px) { .products-grid-4 { grid-template-columns: repeat(2, 1fr); } }
    @media (min-width: 1024px) { .products-grid-4 { grid-template-columns: repeat(4, 1fr); } }

    .products-grid-3 {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 1.5rem;
    }
    @media (min-width: 640px) { .products-grid-3 { grid-template-columns: repeat(2, 1fr); } }
    @media (min-width: 1024px) { .products-grid-3 { grid-template-columns: repeat(3, 1fr); } }

    /* ─── Deal of week ─── */
    .deal-banner {
        background: linear-gradient(135deg, var(--ap-dark) 0%, var(--ap-amethyst) 100%);
        border-radius: 16px;
        padding: 2.5rem 3rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1.5rem;
        margin-bottom: 2.5rem;
        position: relative;
        overflow: hidden;
    }
    .deal-banner::before {
        content: '✦';
        position: absolute;
        right: 12%;
        top: 50%;
        transform: translateY(-50%);
        font-size: 8rem;
        color: rgba(255,255,255,0.04);
        pointer-events: none;
    }
    .deal-banner__text .eyebrow {
        font-size: 0.7rem;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: var(--ap-gold-lt);
        font-family: 'DM Sans', sans-serif;
        margin-bottom: 0.4rem;
    }
    .deal-banner__text h2 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2.2rem;
        color: #fff;
        margin: 0;
        font-weight: 300;
    }
    .deal-banner__text h2 em {
        font-style: italic;
        color: var(--ap-gold-lt);
    }
    .deal-banner__cta {
        background: var(--ap-gold);
        color: var(--ap-dark);
        font-family: 'DM Sans', sans-serif;
        font-size: 0.82rem;
        font-weight: 500;
        letter-spacing: 0.07em;
        text-transform: uppercase;
        padding: 0.7rem 1.8rem;
        border-radius: 2rem;
        text-decoration: none;
        transition: background 0.2s, transform 0.15s;
        white-space: nowrap;
    }
    .deal-banner__cta:hover { background: var(--ap-gold-lt); transform: translateY(-1px); }

    /* ─── Section CTA ─── */
    .section-cta-wrap {
        text-align: center;
        margin-top: 2.5rem;
    }
    .section-cta {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: 1.5px solid var(--ap-amethyst);
        color: var(--ap-amethyst);
        font-family: 'DM Sans', sans-serif;
        font-size: 0.82rem;
        font-weight: 500;
        letter-spacing: 0.07em;
        text-transform: uppercase;
        padding: 0.7rem 2rem;
        border-radius: 2rem;
        text-decoration: none;
        transition: background 0.2s, color 0.2s;
    }
    .section-cta:hover { background: var(--ap-amethyst); color: #fff; }

    /* ─── Newsletter ─── */
    .newsletter-section {
        padding: 5rem 0;
        background: var(--ap-dark-mid);
        position: relative;
        overflow: hidden;
    }
    .newsletter-section::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse at 20% 50%, rgba(107,63,158,0.35) 0%, transparent 60%),
                    radial-gradient(ellipse at 80% 50%, rgba(200,151,58,0.15) 0%, transparent 60%);
        pointer-events: none;
    }
    .newsletter-inner {
        max-width: 580px;
        margin: 0 auto;
        padding: 0 2rem;
        text-align: center;
        position: relative;
        z-index: 1;
    }
    .newsletter-eyebrow {
        font-size: 0.68rem;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: var(--ap-gold);
        font-family: 'DM Sans', sans-serif;
        margin-bottom: 0.5rem;
    }
    .newsletter-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2.4rem;
        font-weight: 300;
        color: #fff;
        line-height: 1.2;
        margin: 0 0 0.75rem;
    }
    .newsletter-title em { font-style: italic; color: var(--ap-amethyst-lt); }
    .newsletter-sub {
        font-size: 0.9rem;
        color: rgba(255,255,255,0.5);
        line-height: 1.6;
        margin: 0 0 2rem;
    }
    .newsletter-form {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        justify-content: center;
    }
    .newsletter-input {
        flex: 1;
        min-width: 220px;
        padding: 0.85rem 1.25rem;
        border-radius: 2rem;
        border: 1px solid rgba(200,151,58,0.3);
        background: rgba(255,255,255,0.06);
        color: #fff;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.875rem;
        outline: none;
        transition: border-color 0.2s;
    }
    .newsletter-input::placeholder { color: rgba(255,255,255,0.3); }
    .newsletter-input:focus { border-color: var(--ap-gold); }
    .newsletter-btn {
        background: var(--ap-gold);
        color: var(--ap-dark);
        font-family: 'DM Sans', sans-serif;
        font-size: 0.82rem;
        font-weight: 500;
        letter-spacing: 0.07em;
        text-transform: uppercase;
        padding: 0.85rem 1.75rem;
        border-radius: 2rem;
        border: none;
        cursor: pointer;
        transition: background 0.2s, transform 0.15s;
        white-space: nowrap;
    }
    .newsletter-btn:hover { background: var(--ap-gold-lt); transform: translateY(-1px); }
    .newsletter-success {
        margin-top: 1rem;
        color: var(--ap-gold-lt);
        font-size: 0.875rem;
        letter-spacing: 0.04em;
    }

    /* ─── Promo footer strip ─── */
    .promo-strip {
        background: var(--ap-amethyst);
        padding: 3rem 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .promo-strip::before,
    .promo-strip::after {
        content: '✦';
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        font-size: 5rem;
        color: rgba(255,255,255,0.06);
        pointer-events: none;
    }
    .promo-strip::before { left: 3rem; }
    .promo-strip::after  { right: 3rem; }
    .promo-strip h2 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2rem;
        font-weight: 300;
        color: #fff;
        margin: 0 0 0.4rem;
    }
    .promo-strip h2 em { font-style: italic; color: var(--ap-gold-lt); }
    .promo-strip p {
        color: rgba(255,255,255,0.65);
        font-size: 0.95rem;
        margin: 0 0 1.5rem;
    }
    .promo-strip a {
        background: var(--ap-gold);
        color: var(--ap-dark);
        font-family: 'DM Sans', sans-serif;
        font-size: 0.82rem;
        font-weight: 500;
        letter-spacing: 0.07em;
        text-transform: uppercase;
        padding: 0.75rem 2rem;
        border-radius: 2rem;
        text-decoration: none;
        display: inline-block;
        transition: background 0.2s, transform 0.15s;
    }
    .promo-strip a:hover { background: var(--ap-gold-lt); transform: translateY(-1px); }
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