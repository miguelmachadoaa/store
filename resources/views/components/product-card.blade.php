<div class="border rounded-lg p-4 shadow hover:shadow-lg transition relative group">
    @auth
        <button onclick="toggleWishlist({{ $product->id }}, this)"
            class="absolute top-2 right-2 p-2 bg-white rounded-full shadow-sm {{ $product->isFavoritedBy(auth()->user()) ? 'text-pink-600' : 'text-gray-400' }} hover:scale-110 transition z-10 wishlist-btn"
            data-id="{{ $product->id }}">
            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                <path
                    d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
            </svg>
        </button>
    @else
        <a href="{{ route('login') }}"
            class="absolute top-2 right-2 p-2 bg-white rounded-full shadow-sm text-gray-400 hover:text-pink-600 hover:scale-110 transition z-10"
            title="Inicia sesión para agregar a favoritos">
            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                <path
                    d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
            </svg>
        </a>
    @endauth
    <a href="{{ route('product.detail', $product->slug) }}">
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
            class="w-full h-48 object-cover rounded mb-3">

        <h3 class="text-lg font-semibold">{{ $product->name }}</h3>

        <div class="mt-2 text-gray-800">
            @php
                $showUsd = $storeSettings->showUsd();
                $showBs = $storeSettings->showBs();
            @endphp

            @if($product->hasDiscount())
                <div class="flex flex-col">
                    {{-- Precio Descuento --}}
                    <div class="font-bold text-xl text-red-600">
                        @if($showUsd)
                            ${{ number_format($product->price, 2) }}
                        @endif
                        @if($showUsd && $showBs) / @endif
                        @if($showBs)
                            Bs. {{ number_format($product->price_bs, 2) }}
                        @endif
                    </div>

                    {{-- Precio Anterior --}}
                    <div class="text-sm line-through text-gray-500">
                        @if($showUsd)
                            ${{ number_format($product->compare_price, 2) }}
                        @endif
                        @if($showUsd && $showBs) / @endif
                        @if($showBs)
                            Bs. {{ number_format($product->compare_price_bs, 2) }}
                        @endif
                    </div>
                </div>
                <span class="text-green-600 font-bold text-sm">
                    -{{ $product->discount_percentage }}%
                </span>
            @else
                <div class="font-bold text-xl">
                    @if($showUsd)
                        ${{ number_format($product->price, 2) }}
                    @endif

                    @if($showUsd && $showBs)
                        <span class="text-sm block text-gray-600">Bs. {{ number_format($product->price_bs, 2) }}</span>
                    @elseif($showBs)
                        Bs. {{ number_format($product->price_bs, 2) }}
                    @endif
                </div>
            @endif
        </div>
    </a>

    <button type="button" class="bg-pink-600 text-white px-4 py-2 rounded hover:bg-pink-700 add-to-cart mt-3 w-full"
        data-id="{{ $product->id }}">
        Add to Cart
    </button>

</div>