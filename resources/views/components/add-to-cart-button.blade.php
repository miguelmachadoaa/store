@props(['product'])

@php
    $cartItem = $cartItems[$product->id] ?? null;
    $initialQuantity = $cartItem ? $cartItem['quantity'] : 0;
@endphp

<style>
    /* ── Add to Cart Button ── */
    .ap-atc-btn {
        width: 100%;
        background: var(--ap-amethyst, #4A2C6E);
        color: #fff;
        border: none;
        border-radius: 2rem;
        padding: 0.6rem 1rem;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.75rem;
        font-weight: 500;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: background 0.2s, transform 0.15s;
    }
    .ap-atc-btn:hover:not(:disabled) {
        background: var(--ap-amethyst-mid, #6B3F9E);
        transform: translateY(-1px);
    }
    .ap-atc-btn:active:not(:disabled) { transform: scale(0.97); }
    .ap-atc-btn:disabled { opacity: 0.65; cursor: not-allowed; }

    /* ── Quantity stepper ── */
    .ap-qty {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: var(--ap-amethyst-pale, #F3EDF9);
        border-radius: 2rem;
        padding: 0.25rem;
        gap: 0.25rem;
    }
    .ap-qty__btn {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        border: none;
        background: #fff;
        color: var(--ap-amethyst, #4A2C6E);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background 0.15s, transform 0.15s;
        flex-shrink: 0;
        box-shadow: 0 1px 4px rgba(74,44,110,0.12);
    }
    .ap-qty__btn:hover:not(:disabled) {
        background: var(--ap-amethyst, #4A2C6E);
        color: #fff;
        transform: scale(1.08);
    }
    .ap-qty__btn:disabled { opacity: 0.5; cursor: not-allowed; }
    .ap-qty__num {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.15rem;
        font-weight: 600;
        color: var(--ap-amethyst, #4A2C6E);
        min-width: 28px;
        text-align: center;
    }

    /* ── Spinner ── */
    .ap-spinner {
        width: 14px;
        height: 14px;
        border: 2px solid rgba(255,255,255,0.4);
        border-top-color: #fff;
        border-radius: 50%;
        animation: ap-spin 0.6s linear infinite;
        display: inline-block;
    }
    @keyframes ap-spin { to { transform: rotate(360deg); } }
</style>

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
                <span style="display:flex;align-items:center;gap:.45rem">
                    {{-- Ícono bolsa --}}
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
                        <line x1="3" y1="6" x2="21" y2="6"/>
                        <path d="M16 10a4 4 0 01-8 0"/>
                    </svg>
                    Agregar al carrito
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