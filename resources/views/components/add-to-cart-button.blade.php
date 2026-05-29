@props(['product'])

@php
    // Asegúrate de que $cartItems venga de tu vista global compartida o controlador
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
            // CORREGIDO: Cambiado 'response.json()' por 'res.json()' para que coincida con la constante
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
            
        } catch (error) {
            console.error('Error adding to cart:', error);
        } finally {
            this.loading = false;
        }
    }
}" class="mt-3">

    {{-- Estado: 0 unidades en carrito → Botón Principal Eléctrico/Neón --}}
    <template x-if="quantity === 0">
        <button type="button" @click="addToCart()" :disabled="loading" class="ap-atc-btn">
            <span x-show="!loading" class="ap-atc-btn__inner">
                {{-- Opcional: Un icono técnico que va genial con la temática racing --}}
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
                Agregar al carrito
            </span>
            <span x-show="loading" style="display: none;" class="ap-spinner"></span>
        </button>
    </template>

    {{-- Estado: ya está en carrito → Stepper Industrial --}}
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