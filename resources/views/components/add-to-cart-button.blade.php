@props(['product'])

@php
    $cartItem = $cartItems[$product->id] ?? null;
    $initialQuantity = $cartItem ? $cartItem['quantity'] : 0;
@endphp

<div x-data="{
    quantity: {{ $initialQuantity }},
    loading: false,

    async updateQuantity(newQty) {
        if (this.loading) return;
        this.loading = true;
        try {
            const res = await fetch('/cart/update/{{ $product->id }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=&quot;csrf-token&quot;]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ quantity: newQty })
            });
            const data = await res.json();
            if (data.success) {
                this.quantity = data.quantity;
                ['cart-count','cart-count-fab'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) {
                        el.textContent = data.count;
                        el.classList.add('scale-125');
                        setTimeout(() => el.classList.remove('scale-125'), 200);
                    }
                });
            }
        } catch (e) {
            console.error('Cart update error:', e);
        } finally {
            this.loading = false;
        }
    },

    async addToCart() {
        if (this.loading) return;
        this.loading = true;
        try {
            const res = await fetch('/cart/ajax-add/{{ $product->id }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=&quot;csrf-token&quot;]').content,
                    'Accept': 'application/json'
                }
            });
            const data = await res.json();
            if (data.success) {
                this.quantity = 1;
                ['cart-count','cart-count-fab'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) {
                        el.textContent = data.count;
                        el.classList.add('scale-125');
                        setTimeout(() => el.classList.remove('scale-125'), 200);
                    }
                });
            }
        } catch (e) {
            console.error('Cart add error:', e);
        } finally {
            this.loading = false;
        }
    }
}">

    {{-- Estado: no está en carrito --}}
    <template x-if="quantity === 0">
        <button type="button"
                @click="addToCart()"
                :disabled="loading"
                class="ap-atc-btn">

            <template x-if="!loading">
                <span class="ap-atc-btn__inner">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
                        <line x1="3" y1="6" x2="21" y2="6"/>
                        <path d="M16 10a4 4 0 01-8 0"/>
                    </svg>
                    Añadir al carrito
                </span>
            </template>

            <template x-if="loading">
                <span class="ap-spinner"></span>
            </template>
        </button>
    </template>

    {{-- Estado: ya está en carrito → stepper --}}
    <template x-if="quantity > 0">
        <div class="ap-qty">

            {{-- Disminuir / eliminar --}}
            <button type="button"
                    @click="updateQuantity(quantity - 1)"
                    :disabled="loading"
                    class="ap-qty__btn"
                    aria-label="Reducir cantidad">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.5"
                     stroke-linecap="round">
                    <line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
            </button>

            {{-- Cantidad --}}
            <span class="ap-qty__num" x-text="quantity"></span>

            {{-- Aumentar --}}
            <button type="button"
                    @click="updateQuantity(quantity + 1)"
                    :disabled="loading"
                    class="ap-qty__btn"
                    aria-label="Aumentar cantidad">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.5"
                     stroke-linecap="round">
                    <line x1="12" y1="5" x2="12" y2="19"/>
                    <line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
            </button>

        </div>
    </template>

</div>