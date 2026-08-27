<x-front-layout>

{{-- ============================================================
     ZOLUM SHOP — CARRITO DE COMPRAS
     Sistema visual: Brandbook Zolum + AP-CARD system
     ============================================================ --}}

<style>
/* ---------------------------------------------------------------
   IMPORTS TIPOGRAFÍAS CORPORATIVAS ZOLUM
   --------------------------------------------------------------- */
@import url('https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@400;600;700&family=Orbitron:wght@700;800&family=DM+Sans:wght@400;500;700&display=swap');

/* ---------------------------------------------------------------
   VARIABLES (alineadas al brandbook global)
   --------------------------------------------------------------- */
:root {
    --bg-pure-white:       #FFFFFF;
    --midnight-blue:       #131921;
    --midnight-light:      #1A2536;
    --warm-orange:         #FFC933;
    --warm-orange-hover:   #F3A847;
    --carbon-black:        #0F1111;
    --border-gray:         #D5D9D9;
    --text-muted:          #555555;
    --text-link:           #007185;
    --success-green:       #007600;
    --error-red:           #B12704;
    --font-technical:      'Chakra Petch', sans-serif;
    --font-display:        'Orbitron', sans-serif;
    --font-sans:           'DM Sans', sans-serif;
    --radius:              4px;
    --shadow-card:         0 1px 4px rgba(0,0,0,.08), 0 2px 12px rgba(0,0,0,.04);
    --shadow-hover:        0 4px 16px rgba(0,0,0,.12);
}

/* ---------------------------------------------------------------
   PÁGINA WRAPPER
   --------------------------------------------------------------- */
.zc-page {
    background-color: #F4F6F6;
    min-height: 70vh;
    padding: 28px 0 60px;
    font-family: var(--font-sans);
}

.zc-container {
    width: 100%;
    max-width: 1240px;
    margin: 0 auto;
    padding: 0 16px;
}

/* ---------------------------------------------------------------
   BREADCRUMB
   --------------------------------------------------------------- */
.zc-breadcrumb {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: var(--text-muted);
    margin-bottom: 20px;
    font-family: var(--font-technical);
}
.zc-breadcrumb a {
    color: var(--text-link);
    text-decoration: none;
}
.zc-breadcrumb a:hover { text-decoration: underline; }
.zc-breadcrumb-sep { color: #B0B0B0; }
.zc-breadcrumb-current {
    color: var(--carbon-black);
    font-weight: 600;
}

/* ---------------------------------------------------------------
   TÍTULO DE SECCIÓN
   --------------------------------------------------------------- */
.zc-page-title {
    font-family: var(--font-display);
    font-size: 22px;
    font-weight: 800;
    color: var(--midnight-blue);
    text-transform: uppercase;
    letter-spacing: .5px;
    margin-bottom: 4px;
}
.zc-page-subtitle {
    font-family: var(--font-technical);
    font-size: 11px;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 1.5px;
    margin-bottom: 24px;
}

/* ---------------------------------------------------------------
   ALERTAS DEL SISTEMA
   --------------------------------------------------------------- */
.zc-alert {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    border-radius: var(--radius);
    font-family: var(--font-technical);
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 18px;
    border: 1px solid transparent;
}
.zc-alert--success {
    background: #EAF7EA;
    border-color: #B5D9B5;
    color: var(--success-green);
}
.zc-alert--error {
    background: #FEF0ED;
    border-color: #F5C6BB;
    color: var(--error-red);
}
.zc-alert__tag {
    background: currentColor;
    color: #fff;
    font-size: 10px;
    padding: 1px 6px;
    border-radius: 2px;
    opacity: .85;
}

/* ---------------------------------------------------------------
   LAYOUT PRINCIPAL: tabla + resumen
   --------------------------------------------------------------- */
.zc-layout {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 20px;
    align-items: start;
}
@media (max-width: 900px) {
    .zc-layout { grid-template-columns: 1fr; }
}

/* ---------------------------------------------------------------
   PANEL IZQUIERDO: TABLA DE ITEMS
   --------------------------------------------------------------- */
.zc-panel {
    background: var(--bg-pure-white);
    border: 1px solid var(--border-gray);
    border-radius: var(--radius);
    box-shadow: var(--shadow-card);
    overflow: hidden;
}

/* Panel Header */
.zc-panel__header {
    background: var(--midnight-blue);
    padding: 14px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.zc-panel__title {
    font-family: var(--font-display);
    font-size: 13px;
    font-weight: 700;
    color: var(--bg-pure-white);
    text-transform: uppercase;
    letter-spacing: .8px;
}
.zc-panel__count {
    font-family: var(--font-technical);
    font-size: 11px;
    color: rgba(255,255,255,.55);
}
.zc-panel__count strong {
    color: var(--warm-orange);
    font-weight: 700;
}

/* ----------- TABLA DESKTOP ------------------------------------ */
.zc-table-wrap { overflow-x: auto; }

.zc-table {
    width: 100%;
    border-collapse: collapse;
    font-family: var(--font-sans);
    font-size: 13px;
}
.zc-table thead tr {
    background: #F0F2F2;
    border-bottom: 2px solid var(--border-gray);
}
.zc-table thead th {
    padding: 10px 16px;
    text-align: left;
    font-family: var(--font-technical);
    font-size: 11px;
    font-weight: 700;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 1px;
    white-space: nowrap;
}
.zc-table thead th:last-child { text-align: right; }

.zc-table tbody tr {
    border-bottom: 1px solid #F3F3F3;
    transition: background .15s ease;
}
.zc-table tbody tr:last-child { border-bottom: none; }
.zc-table tbody tr:hover { background: #FAFAFA; }

.zc-table td {
    padding: 14px 16px;
    vertical-align: middle;
}
.zc-table td:last-child { text-align: right; }

/* Celda: Producto */
.zc-prod-cell {
    display: flex;
    align-items: center;
    gap: 14px;
}
.zc-prod-img {
    width: 60px;
    height: 60px;
    border: 1px solid var(--border-gray);
    border-radius: var(--radius);
    background: #F7F7F7;
    flex-shrink: 0;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}
.zc-prod-img img {
    max-width: 100%;
    max-height: 100%;
    object-fit: cover;
}
.zc-prod-img--placeholder {
    font-size: 10px;
    font-family: var(--font-technical);
    color: #C8CBCB;
    font-weight: 700;
    letter-spacing: 1px;
}
.zc-prod-name {
    font-size: 14px;
    font-weight: 500;
    color: var(--carbon-black);
    line-height: 1.35;
    margin-bottom: 3px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.zc-prod-ref {
    font-family: var(--font-technical);
    font-size: 10px;
    color: #A0A0A0;
}

/* Celda: Precio */
.zc-price-main {
    font-size: 15px;
    font-weight: 700;
    color: var(--carbon-black);
}
.zc-price-bs {
    font-size: 11px;
    color: var(--text-muted);
    margin-top: 2px;
}

/* Celda: Stepper de cantidad */
.zc-qty-form {
    display: flex;
    align-items: center;
    gap: 6px;
}
.zc-qty-wrap {
    display: flex;
    align-items: center;
    border: 1px solid var(--border-gray);
    border-radius: var(--radius);
    background: #F0F2F2;
    overflow: hidden;
}
.zc-qty-btn {
    background: transparent;
    border: none;
    width: 30px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 16px;
    color: var(--carbon-black);
    transition: background .15s;
}
.zc-qty-btn:hover { background: #D5D9D9; }
.zc-qty-input {
    width: 36px;
    text-align: center;
    border: none;
    background: transparent;
    font-family: var(--font-technical);
    font-size: 13px;
    font-weight: 700;
    color: var(--carbon-black);
    outline: none;
    -moz-appearance: textfield;
}
.zc-qty-input::-webkit-inner-spin-button,
.zc-qty-input::-webkit-outer-spin-button { -webkit-appearance: none; }

.zc-qty-sync {
    background: transparent;
    border: 1px solid var(--border-gray);
    color: var(--text-link);
    font-family: var(--font-technical);
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    padding: 5px 8px;
    border-radius: var(--radius);
    cursor: pointer;
    letter-spacing: .5px;
    transition: all .15s;
}
.zc-qty-sync:hover {
    border-color: var(--text-link);
    background: #EBF8FA;
}

/* Celda: Total */
.zc-total-main {
    font-size: 15px;
    font-weight: 700;
    color: var(--carbon-black);
}
.zc-total-bs {
    font-size: 11px;
    color: var(--text-muted);
    margin-top: 2px;
}

/* Celda: Eliminar */
.zc-remove-btn {
    background: transparent;
    border: 1px solid transparent;
    color: #C0C4C4;
    font-family: var(--font-technical);
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
    padding: 5px 10px;
    border-radius: var(--radius);
    cursor: pointer;
    transition: all .15s;
    white-space: nowrap;
}
.zc-remove-btn:hover {
    border-color: var(--error-red);
    color: var(--error-red);
    background: #FEF0ED;
}

/* ----------- CARDS MOBILE ------------------------------------ */
.zc-mobile-cards {
    display: none;
    flex-direction: column;
    gap: 0;
}
@media (max-width: 700px) {
    .zc-table-wrap { display: none; }
    .zc-mobile-cards { display: flex; }
}

.zc-mcard {
    padding: 16px;
    border-bottom: 1px solid #F3F3F3;
}
.zc-mcard:last-child { border-bottom: none; }

.zc-mcard__top {
    display: flex;
    gap: 12px;
    align-items: flex-start;
    margin-bottom: 12px;
}
.zc-mcard__info { flex: 1; min-width: 0; }
.zc-mcard__name {
    font-size: 13px;
    font-weight: 600;
    color: var(--carbon-black);
    margin-bottom: 4px;
    line-height: 1.4;
}
.zc-mcard__ref {
    font-family: var(--font-technical);
    font-size: 10px;
    color: #A0A0A0;
}

.zc-mcard__prices {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px;
    background: #F7F7F7;
    border: 1px solid var(--border-gray);
    border-radius: var(--radius);
    padding: 10px 12px;
    margin-bottom: 12px;
}
.zc-mcard__price-label {
    font-family: var(--font-technical);
    font-size: 9px;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--text-muted);
    display: block;
    margin-bottom: 3px;
}
.zc-mcard__price-val {
    font-size: 14px;
    font-weight: 700;
    color: var(--carbon-black);
}
.zc-mcard__price-bs {
    font-size: 10px;
    color: var(--text-muted);
    margin-top: 1px;
}
.zc-mcard__price-total .zc-mcard__price-val {
    color: var(--midnight-blue);
}

.zc-mcard__actions {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

/* ---------------------------------------------------------------
   PANEL DERECHO: RESUMEN DE ORDEN
   --------------------------------------------------------------- */
.zc-summary {
    background: var(--bg-pure-white);
    border: 1px solid var(--border-gray);
    border-radius: var(--radius);
    box-shadow: var(--shadow-card);
    overflow: hidden;
    position: sticky;
    top: 80px;
}
.zc-summary__header {
    background: var(--midnight-blue);
    padding: 14px 20px;
}
.zc-summary__title {
    font-family: var(--font-display);
    font-size: 12px;
    font-weight: 700;
    color: var(--bg-pure-white);
    text-transform: uppercase;
    letter-spacing: .8px;
}
.zc-summary__body { padding: 20px; }

/* Filas del resumen */
.zc-sum-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13px;
    padding: 8px 0;
    border-bottom: 1px solid #F3F3F3;
    color: var(--carbon-black);
}
.zc-sum-row:last-of-type { border-bottom: none; }
.zc-sum-row__label { color: var(--text-muted); }
.zc-sum-row__val { font-weight: 600; }

/* Fila de descuento */
.zc-sum-row--discount .zc-sum-row__label,
.zc-sum-row--discount .zc-sum-row__val { color: var(--success-green); }

/* Total final */
.zc-sum-total {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    padding: 14px 0 4px;
    border-top: 2px solid var(--midnight-blue);
    margin-top: 8px;
}
.zc-sum-total__label {
    font-family: var(--font-display);
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    color: var(--midnight-blue);
    letter-spacing: .5px;
}
.zc-sum-total__amount {
    text-align: right;
}
.zc-sum-total__usd {
    font-family: var(--font-display);
    font-size: 22px;
    font-weight: 800;
    color: var(--midnight-blue);
    line-height: 1;
}
.zc-sum-total__bs {
    font-family: var(--font-technical);
    font-size: 11px;
    color: var(--text-muted);
    margin-top: 3px;
    text-align: right;
}
.zc-sum-total__rate {
    font-size: 9px;
    color: #B0B0B0;
    letter-spacing: .5px;
    text-transform: uppercase;
    margin-top: 1px;
}

/* Descuento badge */
.zc-coupon-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #EAF7EA;
    border: 1px solid #B5D9B5;
    color: var(--success-green);
    font-family: var(--font-technical);
    font-size: 10px;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 2px;
    text-transform: uppercase;
    letter-spacing: .5px;
}
.zc-coupon-remove {
    background: none;
    border: none;
    color: var(--error-red);
    cursor: pointer;
    font-size: 10px;
    font-family: var(--font-technical);
    font-weight: 700;
    padding: 0;
    text-transform: uppercase;
    text-decoration: underline;
    letter-spacing: .3px;
}

/* Form de cupón */
.zc-coupon-wrap { padding: 16px 20px; border-top: 1px solid var(--border-gray); }
.zc-coupon-label {
    font-family: var(--font-technical);
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--text-muted);
    display: block;
    margin-bottom: 8px;
}
.zc-coupon-form {
    display: flex;
    gap: 0;
    border: 1px solid var(--border-gray);
    border-radius: var(--radius);
    overflow: hidden;
    transition: border-color .2s;
}
.zc-coupon-form:focus-within { border-color: var(--warm-orange); }
.zc-coupon-input {
    flex: 1;
    border: none;
    padding: 9px 12px;
    font-family: var(--font-technical);
    font-size: 12px;
    font-weight: 600;
    color: var(--carbon-black);
    background: #FAFAFA;
    outline: none;
    text-transform: uppercase;
    letter-spacing: .5px;
}
.zc-coupon-input::placeholder { color: #B0B0B0; font-weight: 400; text-transform: none; }
.zc-coupon-btn {
    background: var(--midnight-blue);
    border: none;
    color: var(--bg-pure-white);
    font-family: var(--font-technical);
    font-size: 11px;
    font-weight: 700;
    padding: 0 14px;
    cursor: pointer;
    text-transform: uppercase;
    letter-spacing: .5px;
    transition: background .15s;
}
.zc-coupon-btn:hover { background: var(--midnight-light); }

/* CTA Checkout */
.zc-checkout-wrap { padding: 16px 20px 20px; }
.zc-checkout-btn {
    display: block;
    width: 100%;
    background: var(--warm-orange);
    border: 1px solid #A88734;
    color: var(--carbon-black);
    font-family: var(--font-display);
    font-size: 13px;
    font-weight: 700;
    text-align: center;
    padding: 13px 0;
    border-radius: var(--radius);
    cursor: pointer;
    text-decoration: none;
    transition: background .15s;
    letter-spacing: .3px;
    text-transform: uppercase;
}
.zc-checkout-btn:hover { background: var(--warm-orange-hover); }

/* Trust signals debajo del CTA */
.zc-trust-mini {
    display: flex;
    flex-direction: column;
    gap: 6px;
    margin-top: 12px;
}
.zc-trust-mini-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 11px;
    color: var(--text-muted);
}
.zc-trust-mini-item span:first-child { font-size: 13px; }

/* ---------------------------------------------------------------
   ESTADO VACÍO
   --------------------------------------------------------------- */
.zc-empty {
    text-align: center;
    padding: 60px 20px 50px;
    background: var(--bg-pure-white);
    border: 1px solid var(--border-gray);
    border-radius: var(--radius);
    box-shadow: var(--shadow-card);
}
.zc-empty__icon {
    width: 72px;
    height: 72px;
    background: #F0F2F2;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    margin: 0 auto 18px;
    border: 1px solid var(--border-gray);
}
.zc-empty__title {
    font-family: var(--font-display);
    font-size: 18px;
    font-weight: 800;
    color: var(--midnight-blue);
    text-transform: uppercase;
    margin-bottom: 8px;
}
.zc-empty__text {
    font-size: 14px;
    color: var(--text-muted);
    margin-bottom: 24px;
    max-width: 320px;
    margin-left: auto;
    margin-right: auto;
}
.zc-empty__btn {
    display: inline-block;
    background: var(--midnight-blue);
    color: var(--bg-pure-white);
    font-family: var(--font-technical);
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .8px;
    padding: 11px 28px;
    border-radius: var(--radius);
    text-decoration: none;
    transition: background .15s;
}
.zc-empty__btn:hover { background: var(--midnight-light); }

.zc-whatsapp-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    background: #25D366;
    border: 1px solid #1EBE5D;
    color: #FFFFFF;
    font-family: var(--font-display);
    font-size: 13px;
    font-weight: 700;
    text-align: center;
    padding: 12px 0;
    border-radius: var(--radius);
    cursor: pointer;
    text-decoration: none;
    transition: background .15s;
    letter-spacing: .3px;
    text-transform: uppercase;
    margin-top: 10px;
}
.zc-whatsapp-btn:hover {
    background: #1EBE5D;
    color: #FFFFFF;
}


</style>

<div class="zc-page">
<div class="zc-container">

    {{-- ── BREADCRUMB ────────────────────────────────────────── --}}
    <div class="zc-breadcrumb">
        <a href="{{ route('shop.index') }}">Inicio</a>
        <span class="zc-breadcrumb-sep">›</span>
        <span class="zc-breadcrumb-current">Carrito de compras</span>
    </div>

    {{-- ── TÍTULO ──────────────────────────────────────────────── --}}
    <h1 class="zc-page-title">Carrito de Compras</h1>
    <p class="zc-page-subtitle">Revisa tus productos antes de confirmar</p>

    {{-- ── ALERTAS ──────────────────────────────────────────────── --}}
    @if(session('success'))
        <div class="zc-alert zc-alert--success">
            <span class="zc-alert__tag">OK</span>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="zc-alert zc-alert--error">
            <span class="zc-alert__tag">Error</span>
            {{ session('error') }}
        </div>
    @endif

    @php
        $showUsd = $storeSettings->showUsd();
        $showBs  = $storeSettings->showBs();
        $rate    = \App\Models\Product::getDollarRate();
    @endphp

    @if(count($cart) > 0)

    {{-- ── LAYOUT PRINCIPAL ──────────────────────────────────── --}}
    <div class="zc-layout">

        {{-- ════ PANEL IZQUIERDO: ITEMS ════════════════════════ --}}
        <div class="zc-panel">

            {{-- Header del panel --}}
            <div class="zc-panel__header">
                <span class="zc-panel__title">Productos seleccionados</span>
                <span class="zc-panel__count">
                    <strong>{{ count($cart) }}</strong> {{ count($cart) === 1 ? 'artículo' : 'artículos' }}
                </span>
            </div>

            {{-- ── TABLA DESKTOP ────────────────────────────── --}}
            <div class="zc-table-wrap">
                <table class="zc-table">
                    <thead>
                        <tr>
                            <th style="min-width:260px">Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $subtotal = 0; @endphp
                        @foreach($cart as $id => $item)
                            @php $subtotal += $item['price'] * $item['quantity']; @endphp
                            <tr>

                                {{-- Producto --}}
                                <td>
                                    <div class="zc-prod-cell">
                                        <div class="zc-prod-img">
                                            @if(isset($item['image']))
                                                <img src="{{ asset('storage/' . $item['image']) }}"
                                                     alt="{{ $item['name'] }}">
                                            @else
                                                <span class="zc-prod-img--placeholder">IMG</span>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="zc-prod-name">{{ $item['name'] }}</div>
                                            <div class="zc-prod-ref">REF #{{ hash('crc32', $id) }}</div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Precio unitario --}}
                                <td>
                                    @if($showUsd)
                                        <div class="zc-price-main">${{ number_format($item['price'], 2) }}</div>
                                    @endif
                                    @if($showBs)
                                        <div class="zc-price-bs">Bs. {{ number_format($item['price'] * $rate, 2) }}</div>
                                    @endif
                                </td>

                                {{-- Cantidad --}}
                                <td>
                                    <form action="{{ route('cart.update', $id) }}" method="POST"
                                          class="zc-qty-form">
                                        @csrf
                                        <div class="zc-qty-wrap">
                                            <button type="button" class="zc-qty-btn"
                                                    onclick="changeQty(this,-1)">−</button>
                                            <input class="zc-qty-input" type="number"
                                                   name="quantity"
                                                   value="{{ $item['quantity'] }}"
                                                   min="1" readonly>
                                            <button type="button" class="zc-qty-btn"
                                                    onclick="changeQty(this,1)">+</button>
                                        </div>
                                        <button type="submit" class="zc-qty-sync">Actualizar</button>
                                    </form>
                                </td>

                                {{-- Total del item --}}
                                <td>
                                    @if($showUsd)
                                        <div class="zc-total-main">
                                            ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                        </div>
                                    @endif
                                    @if($showBs)
                                        <div class="zc-total-bs">
                                            Bs. {{ number_format(($item['price'] * $item['quantity']) * $rate, 2) }}
                                        </div>
                                    @endif
                                </td>

                                {{-- Eliminar --}}
                                <td>
                                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="zc-remove-btn">✕ Quitar</button>
                                    </form>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- ── CARDS MOBILE ─────────────────────────────── --}}
            <div class="zc-mobile-cards">
                @foreach($cart as $id => $item)
                    <div class="zc-mcard">
                        <div class="zc-mcard__top">
                            <div class="zc-prod-img">
                                @if(isset($item['image']))
                                    <img src="{{ asset('storage/' . $item['image']) }}"
                                         alt="{{ $item['name'] }}">
                                @else
                                    <span class="zc-prod-img--placeholder">IMG</span>
                                @endif
                            </div>
                            <div class="zc-mcard__info">
                                <div class="zc-mcard__name">{{ $item['name'] }}</div>
                                <div class="zc-mcard__ref">REF #{{ hash('crc32', $id) }}</div>
                            </div>
                        </div>

                        <div class="zc-mcard__prices">
                            <div>
                                <span class="zc-mcard__price-label">Precio unit.</span>
                                @if($showUsd)
                                    <div class="zc-mcard__price-val">${{ number_format($item['price'], 2) }}</div>
                                @endif
                                @if($showBs)
                                    <div class="zc-mcard__price-bs">Bs. {{ number_format($item['price'] * $rate, 2) }}</div>
                                @endif
                            </div>
                            <div class="zc-mcard__price-total">
                                <span class="zc-mcard__price-label">Total</span>
                                @if($showUsd)
                                    <div class="zc-mcard__price-val">
                                        ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                    </div>
                                @endif
                                @if($showBs)
                                    <div class="zc-mcard__price-bs">
                                        Bs. {{ number_format(($item['price'] * $item['quantity']) * $rate, 2) }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="zc-mcard__actions">
                            <form action="{{ route('cart.update', $id) }}" method="POST"
                                  class="zc-qty-form">
                                @csrf
                                <div class="zc-qty-wrap">
                                    <button type="button" class="zc-qty-btn"
                                            onclick="changeQty(this,-1)">−</button>
                                    <input class="zc-qty-input" type="number"
                                           name="quantity"
                                           value="{{ $item['quantity'] }}"
                                           min="1" readonly>
                                    <button type="button" class="zc-qty-btn"
                                            onclick="changeQty(this,1)">+</button>
                                </div>
                                <button type="submit" class="zc-qty-sync">Actualizar</button>
                            </form>

                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                <button type="submit" class="zc-remove-btn">✕ Quitar</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>{{-- /zc-panel --}}

        {{-- ════ PANEL DERECHO: RESUMEN ═══════════════════════ --}}
       @php
        $discount = session('coupon.discount', 0);
        $total    = $subtotal - $discount;

        // Mensaje formateado para WhatsApp
        $waText = "Hola! Quisiera realizar el siguiente pedido:\n\n";
        foreach($cart as $item) {
            $waText .= "• *" . $item['name'] . "* x" . $item['quantity'] . " - $" . number_format($item['price'] * $item['quantity'], 2) . "\n";
        }

        if($discount > 0) {
            $waText .= "\nDescuento (" . session('coupon.code') . "): -$" . number_format($discount, 2);
        }

        $waText .= "\n\n*Total a pagar: $" . number_format($total, 2) . "*";
        if($showBs) {
            $waText .= " (Bs. " . number_format($total * $rate, 2) . ")";
        }

        $waUrl = "https://wa.me/" . $settings->clean_whatsapp . "?text=" . urlencode($waText);
    @endphp

        <div>
            <div class="zc-summary">
                <div class="zc-summary__header">
                    <span class="zc-summary__title">Resumen de Orden</span>
                </div>
                <div class="zc-summary__body">

                    {{-- Subtotal --}}
                    <div class="zc-sum-row">
                        <span class="zc-sum-row__label">Subtotal ({{ count($cart) }} artículos)</span>
                        <span class="zc-sum-row__val">
                            @if($showUsd) ${{ number_format($subtotal, 2) }} @endif
                        </span>
                    </div>

                    {{-- Envío --}}
                    <div class="zc-sum-row">
                        <span class="zc-sum-row__label">Envío estimado</span>
                        <span class="zc-sum-row__val" style="color:var(--success-green)">
                            Gratis
                        </span>
                    </div>

                    {{-- Descuento cupón --}}
                    @if($discount > 0)
                        <div class="zc-sum-row zc-sum-row--discount">
                            <span class="zc-sum-row__label" style="display:flex;align-items:center;gap:6px;flex-wrap:wrap">
                                Descuento
                                <span class="zc-coupon-badge">
                                    {{ session('coupon.code') }}
                                    <form action="{{ route('cart.coupon.remove') }}" method="POST"
                                          style="display:inline">
                                        @csrf
                                        <button type="submit" class="zc-coupon-remove">×</button>
                                    </form>
                                </span>
                            </span>
                            <span class="zc-sum-row__val">−${{ number_format($discount, 2) }}</span>
                        </div>
                    @endif

                    {{-- Total final --}}
                    <div class="zc-sum-total">
                        <span class="zc-sum-total__label">Total</span>
                        <div class="zc-sum-total__amount">
                            @if($showUsd)
                                <div class="zc-sum-total__usd">${{ number_format($total, 2) }}</div>
                            @endif
                            @if($showBs)
                                <div class="zc-sum-total__bs">
                                    Bs. {{ number_format($total * $rate, 2) }}
                                </div>
                                <div class="zc-sum-total__rate">
                                    1 USD = Bs. {{ number_format($rate, 2) }}
                                </div>
                            @endif
                        </div>
                    </div>

                </div>

                {{-- Cupón --}}
                <div class="zc-coupon-wrap">
                    <span class="zc-coupon-label">¿Tienes un cupón?</span>
                    <form action="{{ route('cart.coupon.apply') }}" method="POST"
                          class="zc-coupon-form">
                        @csrf
                        <input class="zc-coupon-input"
                               type="text"
                               name="code"
                               placeholder="Ingresa tu código"
                               required>
                        <button type="submit" class="zc-coupon-btn">Aplicar</button>
                    </form>
                </div>

                {{-- CTA principal --}}
                <div class="zc-checkout-wrap">
                    <a href="{{ route('checkout.index') }}" class="zc-checkout-btn">
                        Proceder al Pago →
                    </a>

                    @if($settings->clean_whatsapp)
                        <a href="{{ $waUrl }}" target="_blank" class="zc-whatsapp-btn">
                            💬 Pedir por WhatsApp
                        </a>
                    @endif

                    {{-- Micro-confianza --}}
                    <div class="zc-trust-mini">
                        <div class="zc-trust-mini-item">
                            <span>🔒</span>
                            <span>Pago 100% seguro con cifrado SSL</span>
                        </div>
                        <div class="zc-trust-mini-item">
                            <span>🔄</span>
                            <span>Devoluciones sin costo en 30 días</span>
                        </div>
                        <div class="zc-trust-mini-item">
                            <span>🚚</span>
                            <span>Envío gratis en pedidos mayores a $49.990</span>
                        </div>
                    </div>
                </div>

            </div>{{-- /zc-summary --}}

            {{-- Volver a la tienda --}}
            <div style="margin-top:12px;text-align:center">
                <a href="{{ route('shop.index') }}"
                   style="font-family:var(--font-technical);font-size:11px;font-weight:700;
                          color:var(--text-link);text-transform:uppercase;letter-spacing:.5px;
                          text-decoration:none">
                    ← Continuar comprando
                </a>
            </div>

        </div>{{-- /right column --}}

    </div>{{-- /zc-layout --}}

    @else

    {{-- ══ CARRITO VACÍO ══════════════════════════════════════ --}}
    <div class="zc-empty">
        <div class="zc-empty__icon">🛒</div>
        <div class="zc-empty__title">Tu carrito está vacío</div>
        <p class="zc-empty__text">
            Aún no has añadido ningún producto. Explora nuestro catálogo y encuentra lo que necesitas.
        </p>
        <a href="{{ route('shop.index') }}" class="zc-empty__btn">
            ← Ir a la tienda
        </a>
    </div>

    @endif

    <div data-cart="{{ json_encode($cart) }}">
    </div>

</div>{{-- /zc-container --}}
</div>{{-- /zc-page --}}

<script>
// ── Stepper de cantidad (sin form submit, solo actualiza el input)
function changeQty(btn, delta) {
    const form  = btn.closest('form');
    const input = form.querySelector('input[name="quantity"]');
    const curr  = parseInt(input.value, 10) || 1;
    const next  = Math.max(1, curr + delta);
    input.value = next;
}
</script>

</x-front-layout>