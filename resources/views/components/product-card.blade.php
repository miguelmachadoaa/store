<div class="border rounded-lg p-4 shadow hover:shadow-lg transition">
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