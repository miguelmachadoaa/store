<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-6">
        <h1 class="text-2xl font-bold mb-6">All Products</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </div>
</x-app-layout>