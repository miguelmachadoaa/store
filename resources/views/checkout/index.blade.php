<x-front-layout>

{{-- ============================================================
     ZOLUM SHOP — CHECKOUT / FINALIZAR PEDIDO
     Sistema visual: Brandbook Zolum (blanco + #131921 + #FFC933)
     ============================================================ --}}

<style>
@import url('https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@400;600;700&family=Orbitron:wght@700;800&family=DM+Sans:wght@400;500;600;700&display=swap');

/* ── Variables ─────────────────────────────────────────────── */
:root {
    --bg:              #FFFFFF;
    --bg-soft:         #F4F6F6;
    --bg-field:        #FAFAFA;
    --navy:            #131921;
    --navy-light:      #1A2536;
    --orange:          #FFC933;
    --orange-hover:    #F3A847;
    --black:           #0F1111;
    --border:          #D5D9D9;
    --muted:           #555555;
    --link:            #007185;
    --green:           #007600;
    --red:             #B12704;
    --radius:          4px;
    --shadow:          0 1px 4px rgba(0,0,0,.07), 0 2px 14px rgba(0,0,0,.05);
    --font-display:    'Orbitron', sans-serif;
    --font-technical:  'Chakra Petch', sans-serif;
    --font-body:       'DM Sans', sans-serif;
}

/* ── Page wrapper ───────────────────────────────────────────── */
.zco-page {
    background: var(--bg-soft);
    min-height: 80vh;
    padding: 28px 0 60px;
    font-family: var(--font-body);
    color: var(--black);
}
.zco-wrap {
    width: 100%;
    max-width: 1160px;
    margin: 0 auto;
    padding: 0 16px;
}

/* ── Breadcrumb ─────────────────────────────────────────────── */
.zco-bc {
    display: flex;
    align-items: center;
    gap: 6px;
    font-family: var(--font-technical);
    font-size: 11px;
    color: var(--muted);
    margin-bottom: 20px;
}
.zco-bc a { color: var(--link); text-decoration: none; }
.zco-bc a:hover { text-decoration: underline; }
.zco-bc-sep { color: #B8BBBB; }
.zco-bc-cur { color: var(--black); font-weight: 600; }

/* ── Título de sección ─────────────────────────────────────── */
.zco-heading {
    font-family: var(--font-display);
    font-size: 20px;
    font-weight: 800;
    color: var(--navy);
    text-transform: uppercase;
    letter-spacing: .4px;
    margin-bottom: 4px;
}
.zco-subheading {
    font-family: var(--font-technical);
    font-size: 11px;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 1.5px;
    margin-bottom: 26px;
}

/* ── Alertas ────────────────────────────────────────────────── */
.zco-alert {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 11px 15px;
    border-radius: var(--radius);
    font-family: var(--font-technical);
    font-size: 12px;
    font-weight: 600;
    margin-bottom: 16px;
    border: 1px solid transparent;
}
.zco-alert--ok  { background:#EAF7EA; border-color:#B5D9B5; color:var(--green); }
.zco-alert--err { background:#FEF0ED; border-color:#F5C6BB; color:var(--red);   }
.zco-alert__tag {
    background: currentColor;
    color: #fff;
    font-size: 9px;
    padding: 1px 6px;
    border-radius: 2px;
    opacity: .8;
}

/* ── Layout principal: 2 columnas ──────────────────────────── */
.zco-layout {
    display: grid;
    grid-template-columns: 380px 1fr;
    gap: 20px;
    align-items: start;
}
@media (max-width: 900px) {
    .zco-layout { grid-template-columns: 1fr; }
}

/* ════════════════════════════════════════════════════════════
   PANEL GENÉRICO (compartido por resumen y formulario)
   ════════════════════════════════════════════════════════════ */
.zco-panel {
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    overflow: hidden;
}

/* Cabecera de panel */
.zco-panel__hd {
    background: var(--navy);
    padding: 13px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.zco-panel__hd-title {
    font-family: var(--font-display);
    font-size: 11px;
    font-weight: 700;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: .8px;
}
.zco-panel__hd-tag {
    font-family: var(--font-technical);
    font-size: 10px;
    font-weight: 700;
    color: var(--orange);
    text-transform: uppercase;
    letter-spacing: .5px;
    border: 1px solid rgba(254,189,105,.3);
    padding: 2px 8px;
    border-radius: 2px;
}

/* ════════════════════════════════════════════════════════════
   COLUMNA IZQUIERDA — RESUMEN DEL PEDIDO
   ════════════════════════════════════════════════════════════ */
.zco-summary-body { padding: 0; }

/* Lista de ítems */
.zco-items {
    list-style: none;
    margin: 0;
    padding: 0;
    border-bottom: 1px solid var(--border);
}
.zco-item {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 12px;
    padding: 14px 20px;
    border-bottom: 1px solid #F3F3F3;
    transition: background .15s;
}
.zco-item:last-child { border-bottom: none; }
.zco-item:hover { background: #FAFAFA; }

.zco-item__name {
    font-size: 13px;
    font-weight: 600;
    color: var(--black);
    line-height: 1.35;
    margin-bottom: 4px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.zco-item__qty {
    font-family: var(--font-technical);
    font-size: 10px;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: .8px;
}
.zco-item__price {
    text-align: right;
    flex-shrink: 0;
}
.zco-item__price-usd {
    font-size: 14px;
    font-weight: 700;
    color: var(--black);
    white-space: nowrap;
}
.zco-item__price-bs {
    font-size: 10px;
    color: var(--muted);
    margin-top: 2px;
    white-space: nowrap;
}

/* Desglose de totales */
.zco-totals { padding: 16px 20px 0; }

.zco-total-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13px;
    padding: 7px 0;
    border-bottom: 1px solid #F3F3F3;
}
.zco-total-row:last-of-type { border-bottom: none; }
.zco-total-row__label { color: var(--muted); font-size: 12px; }
.zco-total-row__val   { font-weight: 600; }
.zco-total-row--disc .zco-total-row__label,
.zco-total-row--disc .zco-total-row__val { color: var(--green); }

/* Fila descuento con badge y botón quitar */
.zco-disc-label {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
}
.zco-coupon-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #EAF7EA;
    border: 1px solid #B5D9B5;
    color: var(--green);
    font-family: var(--font-technical);
    font-size: 9px;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 2px;
    text-transform: uppercase;
}
.zco-coupon-remove {
    background: none;
    border: none;
    color: var(--red);
    font-family: var(--font-technical);
    font-size: 9px;
    font-weight: 700;
    cursor: pointer;
    padding: 0;
    text-transform: uppercase;
    text-decoration: underline;
}

/* Bloque total final */
.zco-grand-total {
    margin: 0 20px 0;
    padding: 14px 0;
    border-top: 2px solid var(--navy);
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
}
.zco-grand-total__label {
    font-family: var(--font-display);
    font-size: 11px;
    font-weight: 700;
    color: var(--navy);
    text-transform: uppercase;
    letter-spacing: .5px;
}
.zco-grand-total__amount { text-align: right; }
.zco-grand-total__usd {
    font-family: var(--font-display);
    font-size: 22px;
    font-weight: 800;
    color: var(--navy);
    line-height: 1;
}
.zco-grand-total__bs {
    font-family: var(--font-technical);
    font-size: 11px;
    color: var(--muted);
    margin-top: 3px;
}
.zco-grand-total__rate {
    font-family: var(--font-technical);
    font-size: 9px;
    color: #A0A4A4;
    text-transform: uppercase;
    letter-spacing: .5px;
    margin-top: 2px;
}

/* Form de cupón dentro del resumen */
.zco-coupon-zone {
    padding: 16px 20px 20px;
    border-top: 1px solid var(--border);
    margin-top: 14px;
}
.zco-coupon-lbl {
    font-family: var(--font-technical);
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--muted);
    display: block;
    margin-bottom: 8px;
}
.zco-coupon-form {
    display: flex;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
    transition: border-color .2s;
}
.zco-coupon-form:focus-within { border-color: var(--orange); }
.zco-coupon-inp {
    flex: 1;
    border: none;
    background: var(--bg-field);
    padding: 9px 12px;
    font-family: var(--font-technical);
    font-size: 12px;
    font-weight: 600;
    color: var(--black);
    text-transform: uppercase;
    letter-spacing: .5px;
    outline: none;
}
.zco-coupon-inp::placeholder { color: #C0C4C4; font-weight: 400; text-transform: none; }
.zco-coupon-submit {
    background: var(--navy);
    border: none;
    color: #fff;
    font-family: var(--font-technical);
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
    padding: 0 16px;
    cursor: pointer;
    transition: background .15s;
}
.zco-coupon-submit:hover { background: var(--navy-light); }

/* ════════════════════════════════════════════════════════════
   COLUMNA DERECHA — FORMULARIO DE ENVÍO Y PAGO
   ════════════════════════════════════════════════════════════ */
.zco-form-body { padding: 24px 24px 28px; }

/* Separador de sección interna */
.zco-section-sep {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 20px 0 18px;
}
.zco-section-sep__line {
    flex: 1;
    height: 1px;
    background: var(--border);
}
.zco-section-sep__label {
    font-family: var(--font-technical);
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    color: var(--muted);
    white-space: nowrap;
    display: flex;
    align-items: center;
    gap: 6px;
}
.zco-section-sep__dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--orange);
    flex-shrink: 0;
}

/* Campo de formulario */
.zco-field { margin-bottom: 16px; }
.zco-field-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
    margin-bottom: 16px;
}
@media (max-width: 540px) {
    .zco-field-grid { grid-template-columns: 1fr; }
}

.zco-label {
    display: block;
    font-family: var(--font-technical);
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .9px;
    color: var(--muted);
    margin-bottom: 6px;
}
.zco-label--required::after {
    content: ' *';
    color: var(--red);
}

/* Input base */
.zco-input,
.zco-textarea {
    width: 100%;
    background: var(--bg-field);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 9px 12px;
    font-family: var(--font-body);
    font-size: 13px;
    color: var(--black);
    outline: none;
    transition: border-color .2s, box-shadow .2s;
    -webkit-appearance: none;
}
.zco-input:focus,
.zco-textarea:focus {
    border-color: var(--orange);
    box-shadow: 0 0 0 3px rgba(254,189,105,.18);
}
.zco-input--readonly {
    background: #F0F2F2;
    color: var(--muted);
    cursor: default;
}
.zco-input--error,
.zco-textarea--error {
    border-color: var(--red);
    background: #FEF8F7;
}
.zco-textarea {
    resize: none;
    height: 82px;
    line-height: 1.5;
}
.zco-field-err {
    font-family: var(--font-technical);
    font-size: 10px;
    font-weight: 700;
    color: var(--red);
    text-transform: uppercase;
    letter-spacing: .4px;
    margin-top: 5px;
    display: flex;
    align-items: center;
    gap: 4px;
}
.zco-field-err::before { content: '⚠'; font-size: 10px; }

/* ── Métodos de pago ────────────────────────────────────────── */
.zco-payment-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
    margin-bottom: 24px;
}
@media (max-width: 480px) {
    .zco-payment-grid { grid-template-columns: 1fr; }
}

.zco-pay-label { cursor: pointer; display: block; }
.zco-pay-label input[type="radio"] { display: none; }

.zco-pay-card {
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 12px 10px;
    text-align: center;
    background: var(--bg-field);
    transition: all .18s;
    user-select: none;
}
.zco-pay-label input[type="radio"]:checked + .zco-pay-card {
    border-color: var(--navy);
    background: var(--navy);
    box-shadow: 0 2px 10px rgba(19,25,33,.15);
}
.zco-pay-label:hover .zco-pay-card {
    border-color: #B0B4B4;
}

.zco-pay-icon { font-size: 22px; margin-bottom: 6px; display: block; }

.zco-pay-name {
    font-family: var(--font-display);
    font-size: 9px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .6px;
    color: var(--muted);
    display: block;
    margin-bottom: 2px;
    transition: color .18s;
}
.zco-pay-label input[type="radio"]:checked + .zco-pay-card .zco-pay-name {
    color: var(--orange);
}

.zco-pay-desc {
    font-family: var(--font-technical);
    font-size: 9px;
    color: #A0A4A4;
    display: block;
    transition: color .18s;
}
.zco-pay-label input[type="radio"]:checked + .zco-pay-card .zco-pay-desc {
    color: rgba(255,255,255,.55);
}

/* ── Botón principal ────────────────────────────────────────── */
.zco-submit-btn {
    display: block;
    width: 100%;
    background: var(--orange);
    border: 1px solid #A88734;
    color: var(--black);
    font-family: var(--font-display);
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
    padding: 14px 0;
    border-radius: var(--radius);
    cursor: pointer;
    transition: background .15s, transform .1s;
    text-align: center;
    margin-bottom: 14px;
}
.zco-submit-btn:hover { background: var(--orange-hover); }
.zco-submit-btn:active { transform: scale(.99); }

/* ── Nota de seguridad ─────────────────────────────────────── */
.zco-security-note {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-family: var(--font-technical);
    font-size: 10px;
    color: #A0A4A4;
    text-transform: uppercase;
    letter-spacing: .6px;
    margin-top: 4px;
}
.zco-security-note svg {
    width: 12px;
    height: 12px;
    color: var(--green);
    flex-shrink: 0;
}

/* ── Trust badges debajo del form ────────────────────────────── */
.zco-trust-row {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
    padding: 14px 24px 20px;
    border-top: 1px solid var(--border);
}
.zco-trust-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    color: var(--muted);
}
.zco-trust-item span:first-child { font-size: 14px; }
</style>

<div class="zco-page">
<div class="zco-wrap">

    {{-- ── BREADCRUMB ─────────────────────────────────────── --}}
    <div class="zco-bc">
        <a href="{{ route('shop.index') }}">Inicio</a>
        <span class="zco-bc-sep">›</span>
        <a href="{{ route('cart.index') }}">Carrito</a>
        <span class="zco-bc-sep">›</span>
        <span class="zco-bc-cur">Finalizar Pedido</span>
    </div>

    {{-- ── TÍTULO ─────────────────────────────────────────── --}}
    <h1 class="zco-heading">Finalizar Pedido</h1>
    <p class="zco-subheading">Confirma tus datos y elige el método de pago</p>

    {{-- ── ALERTAS ──────────────────────────────────────────── --}}
    @if(session('success'))
        <div class="zco-alert zco-alert--ok">
            <span class="zco-alert__tag">OK</span>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="zco-alert zco-alert--err">
            <span class="zco-alert__tag">Error</span>
            {{ session('error') }}
        </div>
    @endif

    @php
        $showBs = $storeSettings->showBs();
        $rate   = \App\Models\Product::getDollarRate();
    @endphp

    <div class="zco-layout">

        {{-- ════ COLUMNA IZQUIERDA — RESUMEN ══════════════════ --}}
        <div class="zco-panel">

            <div class="zco-panel__hd">
                <span class="zco-panel__hd-title">Resumen del Pedido</span>
                <span class="zco-panel__hd-tag">{{ count($cart) }} artículo(s)</span>
            </div>

            <div class="zco-summary-body">

                {{-- Lista de productos --}}
                @php $subtotal = 0; @endphp
                <ul class="zco-items">
                    @foreach($cart as $id => $item)
                        @php $subtotal += $item['price'] * $item['quantity']; @endphp
                        <li class="zco-item">
                            <div style="flex:1;min-width:0">
                                <div class="zco-item__name">{{ $item['name'] }}</div>
                                <div class="zco-item__qty">Cant.: {{ $item['quantity'] }}</div>
                            </div>
                            <div class="zco-item__price">
                                <div class="zco-item__price-usd">
                                    ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                </div>
                                @if($showBs)
                                    <div class="zco-item__price-bs">
                                        Bs. {{ number_format($item['price'] * $item['quantity'] * $rate, 2) }}
                                    </div>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>

                {{-- Filas de desglose --}}
                @php
                    $discount = session('coupon.discount', 0);
                    $total    = $subtotal - $discount;
                @endphp

                <div class="zco-totals">
                    <div class="zco-total-row">
                        <span class="zco-total-row__label">Subtotal</span>
                        <span class="zco-total-row__val">${{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="zco-total-row">
                        <span class="zco-total-row__label">Envío</span>
                        <span class="zco-total-row__val" style="color:var(--green)">Gratis</span>
                    </div>

                    @if($discount > 0)
                        <div class="zco-total-row zco-total-row--disc">
                            <span class="zco-disc-label zco-total-row__label">
                                Descuento
                                <span class="zco-coupon-badge">
                                    {{ session('coupon.code') }}
                                    <form action="{{ route('cart.coupon.remove') }}" method="POST" style="display:inline">
                                        @csrf
                                        <button type="submit" class="zco-coupon-remove">×</button>
                                    </form>
                                </span>
                            </span>
                            <span class="zco-total-row__val">−${{ number_format($discount, 2) }}</span>
                        </div>
                    @endif
                </div>

                {{-- Total final --}}
                <div class="zco-grand-total">
                    <span class="zco-grand-total__label">Total</span>
                    <div class="zco-grand-total__amount">
                        <div class="zco-grand-total__usd">${{ number_format($total, 2) }}</div>
                        @if($showBs)
                            <div class="zco-grand-total__bs">
                                Bs. {{ number_format($total * $rate, 2) }}
                            </div>
                            <div class="zco-grand-total__rate">
                                1 USD = Bs. {{ number_format($rate, 2) }}
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Form de cupón --}}
                <div class="zco-coupon-zone">
                    @if(session('success'))
                        <div class="zco-alert zco-alert--ok" style="margin-bottom:10px;font-size:11px;padding:8px 12px">
                            <span class="zco-alert__tag">OK</span>{{ session('success') }}
                        </div>
                    @endif
                    @if(session('error') && !isset($errors) )
                        <div class="zco-alert zco-alert--err" style="margin-bottom:10px;font-size:11px;padding:8px 12px">
                            <span class="zco-alert__tag">Error</span>{{ session('error') }}
                        </div>
                    @endif

                    <span class="zco-coupon-lbl">¿Tienes un cupón?</span>
                    <form action="{{ route('cart.coupon.apply') }}" method="POST" class="zco-coupon-form">
                        @csrf
                        <input class="zco-coupon-inp"
                               type="text"
                               name="code"
                               placeholder="Ingresa tu código"
                               required>
                        <button type="submit" class="zco-coupon-submit">Aplicar</button>
                    </form>
                </div>

            </div>{{-- /summary-body --}}
        </div>{{-- /left panel --}}

        {{-- ════ COLUMNA DERECHA — FORMULARIO ════════════════ --}}
        <div class="zco-panel">

            <div class="zco-panel__hd">
                <span class="zco-panel__hd-title">Datos de Envío y Pago</span>
                <span class="zco-panel__hd-tag">Requerido</span>
            </div>

            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf

                <div class="zco-form-body">

                    {{-- ── DATOS PERSONALES ───────────────────── --}}
                    <div class="zco-section-sep">
                        <div class="zco-section-sep__line"></div>
                        <span class="zco-section-sep__label">
                            <span class="zco-section-sep__dot"></span>
                            Datos de contacto
                        </span>
                        <div class="zco-section-sep__line"></div>
                    </div>

                    {{-- Nombre --}}
                    <div class="zco-field">
                        <label class="zco-label zco-label--required">Nombre completo</label>
                        @if(auth()->check())
                            <input type="text"
                                   value="{{ $user->name }}"
                                   readonly
                                   class="zco-input zco-input--readonly">
                        @else
                            <input type="text"
                                   name="name"
                                   value="{{ old('name') }}"
                                   placeholder="Ej: Juan Pérez"
                                   required
                                   class="zco-input {{ $errors->has('name') ? 'zco-input--error' : '' }}">
                            @error('name')
                                <div class="zco-field-err">{{ $message }}</div>
                            @enderror
                        @endif
                    </div>

                    {{-- Email --}}
                    <div class="zco-field">
                        <label class="zco-label zco-label--required">Correo electrónico</label>
                        @if(auth()->check())
                            <input type="email"
                                   value="{{ $user->email }}"
                                   readonly
                                   class="zco-input zco-input--readonly">
                        @else
                            <input type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   placeholder="Ej: juan@correo.com"
                                   required
                                   class="zco-input {{ $errors->has('email') ? 'zco-input--error' : '' }}">
                            @error('email')
                                <div class="zco-field-err">{{ $message }}</div>
                            @enderror
                        @endif
                    </div>

                    {{-- CI/RIF y Teléfono --}}
                    <div class="zco-field-grid">
                        <div>
                            <label class="zco-label zco-label--required">C.I. / RIF</label>
                            <input type="text"
                                   name="rif"
                                   value="{{ old('rif', $user->rif ?? '') }}"
                                   placeholder="V-12345678"
                                   required
                                   class="zco-input {{ $errors->has('rif') ? 'zco-input--error' : '' }}">
                            @error('rif')
                                <div class="zco-field-err">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label class="zco-label zco-label--required">Teléfono</label>
                            <input type="text"
                                   name="phone"
                                   value="{{ old('phone', $user->phone ?? '') }}"
                                   placeholder="0414-0000000"
                                   required
                                   class="zco-input {{ $errors->has('phone') ? 'zco-input--error' : '' }}">
                            @error('phone')
                                <div class="zco-field-err">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- ── DIRECCIÓN ──────────────────────────── --}}
                    <div class="zco-section-sep">
                        <div class="zco-section-sep__line"></div>
                        <span class="zco-section-sep__label">
                            <span class="zco-section-sep__dot"></span>
                            Dirección de entrega
                        </span>
                        <div class="zco-section-sep__line"></div>
                    </div>

                    <div class="zco-field">
                        <label class="zco-label zco-label--required">Dirección completa</label>
                        <textarea name="address"
                                  placeholder="Calle, Urbanización, Ciudad, Estado, Código Postal..."
                                  required
                                  class="zco-textarea {{ $errors->has('address') ? 'zco-textarea--error' : '' }}">{{ old('address', $user->address ?? '') }}</textarea>
                        @error('address')
                            <div class="zco-field-err">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- ── MÉTODO DE PAGO ─────────────────────── --}}
                    <div class="zco-section-sep">
                        <div class="zco-section-sep__line"></div>
                        <span class="zco-section-sep__label">
                            <span class="zco-section-sep__dot"></span>
                            Método de pago
                        </span>
                        <div class="zco-section-sep__line"></div>
                    </div>

                    <div class="zco-payment-grid">

                        <label class="zco-pay-label">
                            <input type="radio" name="payment" value="card"
                                   {{ old('payment', 'card') === 'card' ? 'checked' : '' }}>
                            <div class="zco-pay-card">
                                <span class="zco-pay-icon">💳</span>
                                <span class="zco-pay-name">Tarjeta</span>
                                <span class="zco-pay-desc">Débito / Crédito</span>
                            </div>
                        </label>

                        <label class="zco-pay-label">
                            <input type="radio" name="payment" value="transfer"
                                   {{ old('payment') === 'transfer' ? 'checked' : '' }}>
                            <div class="zco-pay-card">
                                <span class="zco-pay-icon">🏦</span>
                                <span class="zco-pay-name">Transferencia</span>
                                <span class="zco-pay-desc">Banco / Zelle</span>
                            </div>
                        </label>

                        <label class="zco-pay-label">
                            <input type="radio" name="payment" value="paypal"
                                   {{ old('payment') === 'paypal' ? 'checked' : '' }}>
                            <div class="zco-pay-card">
                                <span class="zco-pay-icon">🅿️</span>
                                <span class="zco-pay-name">PayPal</span>
                                <span class="zco-pay-desc">Pago digital</span>
                            </div>
                        </label>

                    </div>

                    {{-- ── BOTÓN CONFIRMAR ────────────────────── --}}
                    <button type="submit" class="zco-submit-btn">
                        🔒 Confirmar y Pagar →
                    </button>

                    {{-- Nota SSL --}}
                    <div class="zco-security-note">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                            <path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        Conexión cifrada SSL — Tus datos están protegidos
                    </div>

                </div>{{-- /form-body --}}

                {{-- Trust badges --}}
                <div class="zco-trust-row">
                    <div class="zco-trust-item">
                        <span>🔄</span><span>Devoluciones en 30 días</span>
                    </div>
                    <div class="zco-trust-item">
                        <span>🚚</span><span>Envío gratis en pedidos +$49.990</span>
                    </div>
                    <div class="zco-trust-item">
                        <span>⭐</span><span>Compra garantizada</span>
                    </div>
                </div>

            </form>
        </div>{{-- /right panel --}}

    </div>{{-- /zco-layout --}}

</div>{{-- /zco-wrap --}}
</div>{{-- /zco-page --}}

</x-front-layout>