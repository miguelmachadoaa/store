<x-front-layout>

    <div class="max-w-7xl mx-auto py-12 px-6">

        <h1 class="text-3xl font-bold mb-6">
            Productos de {{ $brand->name }}
        </h1>

        @if($products->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>

            <div class="mt-6">
                {{ $products->links() }}
            </div>

        @else
            <p class="text-gray-600">No hay productos disponibles para esta marca.</p>
        @endif

    </div>

</x-front-layout>