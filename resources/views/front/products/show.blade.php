<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 px-6">
        <div class="grid md:grid-cols-2 gap-6">
            <img src="{{ Storage::disk('r2')->url($product->image) }}" alt="{{ $product->name }}" class="w-full rounded">

            <div>
                <h1 class="text-3xl font-bold mb-2">{{ $product->name }}</h1>
                <p class="text-gray-600 mb-4">{{ $product->description }}</p>

                <div class="text-xl font-semibold mb-4">
                    @if($product->hasDiscount())
                        <span class="text-red-600">${{ number_format($product->price, 2) }}</span>
                        <span class="line-through text-gray-500">${{ number_format($product->compare_price, 2) }}</span>
                        <span class="text-green-600 ml-2">-{{ $product->discount_percentage }}%</span>
                    @else
                        ${{ number_format($product->price, 2) }}
                    @endif
                </div>

                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                        Add to Cart
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>