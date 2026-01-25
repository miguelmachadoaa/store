<x-front-layout>

<div class="max-w-7xl mx-auto py-10 px-6 grid grid-cols-1 lg:grid-cols-2 gap-10">

    {{-- Galería de imágenes --}}
    <div>
        <img src="{{ asset('storage/' . $product->image) }}"
             class="w-full h-[450px] object-cover rounded-lg shadow">

        {{-- Miniaturas (si tienes más imágenes en el futuro) --}}
        {{-- <div class="flex gap-3 mt-4">
            <img src="..." class="h-20 w-20 rounded border cursor-pointer">
        </div> --}}
    </div>

    {{-- Información del producto --}}
    <div>

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
            <p class="text-4xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</p>

            @if($product->compare_price)
                <p class="text-gray-500 line-through">
                    ${{ number_format($product->compare_price, 2) }}
                </p>
            @endif
        </div>

        {{-- Stock --}}
        <p class="mt-2 text-sm {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
            {{ $product->stock > 0 ? 'En stock' : 'Agotado' }}
        </p>

        {{-- Botón agregar al carrito --}}
        <button
            data-id="{{ $product->id }}"
            class="add-to-cart mt-6 bg-pink-600 hover:bg-pink-700 text-white px-6 py-3 rounded-lg shadow text-lg font-semibold">
            Agregar al carrito
        </button>

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

</x-front-layout>