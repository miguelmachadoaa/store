<article class="ap-card">

    {{-- Imagen --}}
    <a href="{{ route('product.detail', $product->slug) }}" class="ap-card__img-wrap">
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" loading="lazy">

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
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
            </svg>
        </button>
    @else
        <a href="{{ route('login') }}" class="ap-card__wishlist" title="Inicia sesión para guardar" aria-label="Guardar en favoritos">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
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

        {{-- Precio Multi-moneda --}}
        @php
            $showUsd = $storeSettings->showUsd();
            $showBs  = $storeSettings->showBs();
        @endphp

        <div class="ap-card__price-block">
            @if($product->hasDiscount())
                <div class="ap-card__price-row-primary">
                    <span class="ap-card__price-main is-discounted">
                        @if($showUsd) ${{ number_format($product->price, 2) }} @endif
                    </span>
                    <span class="ap-card__price-old">
                        @if($showUsd) ${{ number_format($product->compare_price, 2) }} @endif
                    </span>
                    <span class="ap-card__price-pct">−{{ $product->discount_percentage }}%</span>
                </div>
                
                @if($showBs)
                    <div class="ap-card__price-row-secondary">
                        <span class="ap-card__price-bs">Bs. {{ number_format($product->price_bs, 2) }}</span>
                        <span class="ap-card__price-bs-old">Bs. {{ number_format($product->compare_price_bs, 2) }}</span>
                    </div>
                @endif
            @else
                <div class="ap-card__price-row-primary">
                    <span class="ap-card__price-main">
                        @if($showUsd) ${{ number_format($product->price, 2) }} @endif
                    </span>
                </div>
                @if($showBs)
                    <div class="ap-card__price-row-secondary">
                        <span class="ap-card__price-bs">Bs. {{ number_format($product->price_bs, 2) }}</span>
                    </div>
                @endif
            @endif
        </div>

        <div class="ap-card__sep"></div>

        <div class="ap-card__actions">
            <x-add-to-cart-button :product="$product" />
        </div>

    </div>
</article>