<x-front-layout>
    <section class="max-w-7xl mx-auto py-12 px-6 grid md:grid-cols-2 gap-10">
        <div>
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                 class="w-full rounded-lg shadow-lg object-cover">
        </div>

        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $product->name }}</h1>
            <p class="text-gray-600 mb-4">{{ $product->description }}</p>

            <div class="text-2xl font-semibold text-pink-600 mb-4">
                ${{ number_format($product->price, 2) }}
                @if($product->hasDiscount())
                    <span class="line-through text-gray-400 ml-2">
                        ${{ number_format($product->compare_price, 2) }}
                    </span>
                    <span class="ml-2 text-green-600 text-sm font-medium">
                        -{{ $product->discount_percentage }}%
                    </span>
                @endif
            </div>

            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-6">
                @csrf
                <button class="bg-pink-600 text-white px-6 py-2 rounded hover:bg-pink-700">
                    Add to Cart
                </button>
            </form>
        </div>
    </section>
</x-front-layout>