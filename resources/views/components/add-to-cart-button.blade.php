@props(['product'])

@php
    $cartItem = $cartItems[$product->id] ?? null;
    $initialQuantity = $cartItem ? $cartItem['quantity'] : 0;
@endphp

<div x-data="{ 
    quantity: {{ $initialQuantity }},
    loading: false,
    async updateQuantity(newQuantity) {
        if (this.loading) return;
        this.loading = true;
        
        try {
            const response = await fetch('/cart/update/{{ $product->id }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=&quot;csrf-token&quot;]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ quantity: newQuantity })
            });
            
            const data = await response.json();
            
            if (data.success) {
                this.quantity = data.quantity;
                const cartCount = document.getElementById('cart-count');
                if (cartCount) {
                    cartCount.textContent = data.count;
                    cartCount.classList.add('scale-125');
                    setTimeout(() => cartCount.classList.remove('scale-125'), 200);
                }
            }
        } catch (error) {
            console.error('Error updating cart:', error);
        } finally {
            this.loading = false;
        }
    },
    async addToCart() {
        if (this.loading) return;
        this.loading = true;
        
        try {
            const response = await fetch('/cart/ajax-add/{{ $product->id }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=&quot;csrf-token&quot;]').content,
                    'Accept': 'application/json'
                }
            });
            const data = await response.json();
            if (data.success) {
                this.quantity = 1;
                const cartCount = document.getElementById('cart-count');
                if (cartCount) {
                    cartCount.textContent = data.count;
                    cartCount.classList.add('scale-125');
                    setTimeout(() => cartCount.classList.remove('scale-125'), 200);
                }
            }
        } catch (error) {
            console.error('Error adding to cart:', error);
        } finally {
            this.loading = false;
        }
    }
}" class="mt-3">
    <template x-if="quantity === 0">
        <button type="button" @click="addToCart()" :disabled="loading"
            class="bg-pink-600 text-white px-4 py-2 rounded hover:bg-pink-700 w-full transition flex items-center justify-center gap-2">
            <span x-show="!loading">Agregar al carrito</span>
            <span x-show="loading"
                class="animate-spin inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full"></span>
        </button>
    </template>

    <template x-if="quantity > 0">
        <div class="flex items-center justify-between bg-gray-100 rounded-lg p-1">
            <button type="button" @click="updateQuantity(quantity - 1)" :disabled="loading"
                class="bg-white text-pink-600 w-10 h-10 rounded shadow hover:bg-pink-50 flex items-center justify-center transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                </svg>
            </button>

            <span class="font-bold text-lg text-gray-800" x-text="quantity"></span>

            <button type="button" @click="updateQuantity(quantity + 1)" :disabled="loading"
                class="bg-white text-pink-600 w-10 h-10 rounded shadow hover:bg-pink-50 flex items-center justify-center transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </button>
        </div>
    </template>
</div>