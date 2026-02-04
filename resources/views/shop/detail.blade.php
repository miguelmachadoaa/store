<x-front-layout>

    <div class="max-w-7xl mx-auto py-10 px-6 grid grid-cols-1 lg:grid-cols-2 gap-10">

        {{-- Galería de imágenes --}}
        <div>
            {{-- Imagen principal --}}
            <img id="main-image" src="{{ asset('storage/' . ($product->images->first()->image ?? $product->image)) }}"
                class="w-full h-[450px] object-cover rounded-lg shadow">

            {{-- Miniaturas --}}
            <div class="flex gap-3 mt-4">
                {{-- Imagen principal --}}
                <img src="{{ asset('storage/' . $product->image) }}"
                    class="h-20 w-20 rounded border cursor-pointer thumb">

                {{-- Imágenes adicionales --}}
                @foreach($product->images as $img)
                    <img src="{{ asset('storage/' . $img->image) }}" class="h-20 w-20 rounded border cursor-pointer thumb">
                @endforeach
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
            <h1 class="text-3xl font-bold mt-1">{{ $product->name }}</h1>

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

            {{-- Botón agregar al carrito --}}
            <div class="flex items-center gap-4 mt-6">
                <button data-id="{{ $product->id }}"
                    class="add-to-cart bg-pink-600 hover:bg-pink-700 text-white px-8 py-3 rounded-lg shadow text-lg font-semibold flex-grow transition">
                    Agregar al carrito
                </button>

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

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll('.thumb').forEach(img => {
                img.addEventListener('click', function () {
                    document.getElementById('main-image').src = this.src;
                });
            });
        });
    </script>

</x-front-layout>