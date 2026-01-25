<div class="border rounded-lg p-4 shadow hover:shadow-lg transition">
    <a href="{{ route('products.show', $product->slug) }}">
        <img src="{{ asset('storage/' . $product->image) }}"
             alt="{{ $product->name }}"
             class="w-full h-48 object-cover rounded mb-3">

        <h3 class="text-lg font-semibold">{{ $product->name }}</h3>

        <div class="mt-2">
            @if($product->hasDiscount())
                <span class="text-red-600 font-bold text-xl">
                    ${{ number_format($product->price, 2) }}
                </span>

                <span class="line-through text-gray-500 ml-2">
                    ${{ number_format($product->compare_price, 2) }}
                </span>

                <span class="text-green-600 ml-2">
                    -{{ $product->discount_percentage }}%
                </span>
            @else
                <span class="text-gray-800 font-bold text-xl">
                    ${{ number_format($product->price, 2) }}
                </span>
            @endif
        </div>
    </a>

    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-4">
        @csrf
        <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
            Add to Cart
        </button>
    </form>
</div>