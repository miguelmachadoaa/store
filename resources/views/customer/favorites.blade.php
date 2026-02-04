<x-customer-layout>
    <div class="bg-white shadow rounded-lg p-6 border border-gray-100">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Mis Favoritos</h2>

        @if($products->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($products as $product)
                    <div class="border rounded-xl p-4 hover:shadow-md transition bg-gray-50 flex flex-col h-full relative group">
                        {{-- Remove button --}}
                        <button onclick="toggleWishlist({{ $product->id }}, this)" 
                                class="absolute top-2 right-2 p-2 bg-white rounded-full shadow-sm text-pink-600 hover:bg-pink-50 transition z-10">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                        </button>

                        <a href="{{ route('product.detail', $product->slug) }}" class="flex-grow">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/no-image.png') }}" 
                                 class="w-full h-48 object-cover rounded-lg mb-4">
                            <h3 class="font-bold text-gray-800 line-clamp-2 mb-2">{{ $product->name }}</h3>
                            <div class="text-indigo-600 font-bold text-lg">${{ number_format($product->price, 2) }}</div>
                            @if($product->total_bs)
                                <div class="text-gray-500 text-xs font-semibold">Bs. {{ number_format($product->total_bs, 2) }}</div>
                            @endif
                        </a>
                        
                        <div class="mt-4 flex gap-2">
                             <button class="add-to-cart bg-indigo-600 text-white flex-1 py-2 rounded-lg text-sm font-bold hover:bg-indigo-700 transition" 
                                    data-id="{{ $product->id }}">
                                Agregar al Carrito
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-20 h-20 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
                <p class="text-gray-500 italic text-lg">Aún no tienes productos en tu lista de deseos.</p>
                <a href="{{ route('shop.index') }}" class="inline-block mt-4 text-indigo-600 font-bold hover:underline">Ir a comprar →</a>
            </div>
        @endif
    </div>

    <script>
        function toggleWishlist(productId, btn) {
            fetch(`/wishlist/toggle/${productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success && data.status === 'removed') {
                    // Si estamos en la página de favoritos, eliminamos el card
                    btn.closest('.group').remove();
                    
                    // Si ya no quedan hijos, recargar para mostrar el "vacío"
                    if (document.querySelectorAll('.group').length === 0) {
                        location.reload();
                    }
                }
            });
        }
    </script>
</x-customer-layout>
