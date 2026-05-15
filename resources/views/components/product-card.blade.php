{{-- ╔══════════════════════════════════════════════════════════╗
     ║  PRODUCT CARD — Alma de Piedra                           ║
     ║  Mystic luxury aesthetic · Cormorant Garamond + DM Sans  ║
     ╚══════════════════════════════════════════════════════════╝ --}}

<style>
    .ap-card {
        position: relative;
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 16px rgba(74,44,110,0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
    }
    .ap-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(74,44,110,0.16);
    }

    /* Image wrapper */
    .ap-card__img-wrap {
        position: relative;
        overflow: hidden;
        background: #F3EDF9;
        aspect-ratio: 1 / 1;
    }
    .ap-card__img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.55s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    .ap-card:hover .ap-card__img-wrap img {
        transform: scale(1.07);
    }

    /* Discount badge */
    .ap-card__badge {
        position: absolute;
        top: 0.75rem;
        left: 0.75rem;
        background: #4A2C6E;
        color: #E8C97A;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.7rem;
        font-weight: 500;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        padding: 0.25rem 0.65rem;
        border-radius: 2rem;
        z-index: 2;
    }

    /* Wishlist btn */
    .ap-card__wishlist {
        position: absolute;
        top: 0.65rem;
        right: 0.65rem;
        z-index: 3;
        width: 36px;
        height: 36px;
        background: rgba(255,255,255,0.92);
        backdrop-filter: blur(4px);
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: transform 0.2s, background 0.2s;
        color: #C4B49A;
        text-decoration: none;
    }
    .ap-card__wishlist:hover,
    .ap-card__wishlist.is-wishlisted {
        color: #4A2C6E;
        background: #fff;
        transform: scale(1.12);
    }

    /* Content */
    .ap-card__body {
        padding: 1rem 1.25rem 1.25rem;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    /* Stone/category tag */
    .ap-card__tag {
        font-family: 'DM Sans', sans-serif;
        font-size: 0.65rem;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #7A6589;
        margin-bottom: 0.35rem;
    }

    /* Product name */
    .ap-card__name {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.2rem;
        font-weight: 400;
        color: #2D1F3D;
        line-height: 1.3;
        margin: 0 0 0.75rem;
        text-decoration: none;
        display: block;
        transition: color 0.2s;
    }
    .ap-card__name:hover { color: #4A2C6E; }

    /* Price block */
    .ap-card__price-block {
        display: flex;
        align-items: baseline;
        flex-wrap: wrap;
        gap: 0.4rem;
        margin-bottom: 1rem;
    }
    .ap-card__price-main {
        font-family: 'DM Sans', sans-serif;
        font-size: 1.25rem;
        font-weight: 500;
        color: #2D1F3D;
    }
    .ap-card__price-main.is-discounted {
        color: #4A2C6E;
    }
    .ap-card__price-bs {
        font-size: 0.85rem;
        color: #7A6589;
    }
    .ap-card__price-old {
        font-size: 0.85rem;
        color: #C4B49A;
        text-decoration: line-through;
    }
    .ap-card__price-pct {
        font-size: 0.72rem;
        font-weight: 500;
        letter-spacing: 0.06em;
        color: #6B3F9E;
        background: rgba(74,44,110,0.08);
        padding: 0.15rem 0.5rem;
        border-radius: 2rem;
    }

    /* Separator */
    .ap-card__sep {
        height: 1px;
        background: rgba(74,44,110,0.08);
        margin-bottom: 1rem;
    }

    /* CTA spacer */
    .ap-card__actions {
        margin-top: auto;
    }
</style>

<article class="ap-card">

    {{-- Imagen --}}
    <a href="{{ route('product.detail', $product->slug) }}" class="ap-card__img-wrap">
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">

        @if($product->hasDiscount())
            <span class="ap-card__badge">−{{ $product->discount_percentage }}%</span>
        @endif
    </a>

    {{-- Wishlist --}}
    @auth
        <button onclick="toggleWishlist({{ $product->id }}, this)"
            class="ap-card__wishlist {{ $product->isFavoritedBy(auth()->user()) ? 'is-wishlisted' : '' }}"
            data-id="{{ $product->id }}"
            aria-label="Agregar a favoritos">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
            </svg>
        </button>
    @else
        <a href="{{ route('login') }}" class="ap-card__wishlist" title="Inicia sesión para guardar" aria-label="Guardar en favoritos">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
            </svg>
        </a>
    @endauth

    {{-- Contenido --}}
    <div class="ap-card__body">

        @if(isset($product->category))
            <p class="ap-card__tag">{{ $product->category->name }}</p>
        @endif

        <a href="{{ route('product.detail', $product->slug) }}" class="ap-card__name">
            {{ $product->name }}
        </a>

        {{-- Precio --}}
        @php
            $showUsd = $storeSettings->showUsd();
            $showBs  = $storeSettings->showBs();
        @endphp

        <div class="ap-card__price-block">
            @if($product->hasDiscount())
                <span class="ap-card__price-main is-discounted">
                    @if($showUsd) ${{ number_format($product->price, 2) }} @endif
                    @if($showUsd && $showBs) · @endif
                    @if($showBs) <span class="ap-card__price-bs">Bs. {{ number_format($product->price_bs, 2) }}</span> @endif
                </span>
                <span class="ap-card__price-old">
                    @if($showUsd) ${{ number_format($product->compare_price, 2) }} @endif
                    @if($showUsd && $showBs) / @endif
                    @if($showBs) Bs. {{ number_format($product->compare_price_bs, 2) }} @endif
                </span>
                <span class="ap-card__price-pct">−{{ $product->discount_percentage }}%</span>
            @else
                <span class="ap-card__price-main">
                    @if($showUsd) ${{ number_format($product->price, 2) }} @endif
                </span>
                @if($showBs)
                    <span class="ap-card__price-bs">Bs. {{ number_format($product->price_bs, 2) }}</span>
                @endif
            @endif
        </div>

        <div class="ap-card__sep"></div>

        <div class="ap-card__actions">
            <x-add-to-cart-button :product="$product" />
        </div>

    </div>
</article>