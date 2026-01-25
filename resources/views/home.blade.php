<x-front-layout>
    {{-- Banner principal --}}
    <section class="bg-pink-50 py-12">
        <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-6 items-center px-6">
            <div>
                <h1 class="text-4xl font-bold text-gray-800 mb-4">Iphone Max Mini Pro</h1>
                <p class="text-lg text-gray-600 mb-6">New arrival with best features and performance</p>
                <a href="{{ route('products.index') }}" class="bg-pink-600 text-white px-6 py-2 rounded hover:bg-pink-700">
                    Shop Now
                </a>
            </div>
            <div>
                <img src="{{ asset('images/banner-iphone.png') }}" alt="Iphone Max" class="rounded shadow-lg">
            </div>
        </div>
    </section>

    {{-- Servicios --}}
    <section class="py-10 bg-white">
        <div class="max-w-7xl mx-auto grid md:grid-cols-4 gap-6 text-center px-6">
            @foreach([
                ['icon' => '💬', 'text' => '24/7 Hours Support'],
                ['icon' => '🚚', 'text' => 'Free Shipping Service'],
                ['icon' => '🔒', 'text' => 'Secure Payment Method'],
                ['icon' => '💸', 'text' => 'Money-Return Policy'],
            ] as $service)
                <div class="bg-gray-50 p-6 rounded shadow">
                    <div class="text-3xl mb-2">{{ $service['icon'] }}</div>
                    <p class="font-semibold text-gray-700">{{ $service['text'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Categorías destacadas --}}
    <section class="py-10 bg-pink-50">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Explore Top Categories</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach(['Headphones', 'Mobile & iPod', 'Xbox', 'Soundbox', 'Washing Machines', 'Coffee Machine', 'Refrigerator', 'Iron Machine'] as $category)
                    <div class="bg-white p-4 rounded shadow text-center hover:shadow-md transition">
                        <div class="text-pink-600 text-2xl mb-2">🎧</div>
                        <p class="font-semibold text-gray-700">{{ $category }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Ofertas de la semana --}}
    <section class="py-10 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Deal of the Week</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($weeklyDeals as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- Productos recientes --}}
    <section class="py-10 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Recently Added Products</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach($recentProducts as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- Footer promocional --}}
    <section class="bg-pink-600 text-white py-10">
        <div class="max-w-7xl mx-auto text-center px-6">
            <h2 class="text-2xl font-bold mb-2">Get Ready & Shopping With Us</h2>
            <p class="text-lg">Enjoy Weekly 50% Discount Offer</p>
        </div>
    </section>
</x-front-layout>