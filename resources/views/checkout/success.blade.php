<x-front-layout>

{{-- ============================================================
     ZOLUM SHOP — CONFIRMACIÓN DE PEDIDO
     Sistema visual: Brandbook Zolum (#FFFFFF + #131921 + #FFC933)
     ============================================================ --}}

<style>
@import url('https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@400;600;700&family=Orbitron:wght@700;800&family=DM+Sans:wght@400;500;600;700&display=swap');

/* ── Variables ─────────────────────────────────────────────── */
:root {
    --bg:            #FFFFFF;
    --bg-soft:       #F4F6F6;
    --bg-field:      #FAFAFA;
    --navy:          #131921;
    --navy-light:    #1A2536;
    --orange:        #FFC933;
    --orange-hover:  #F3A847;
    --black:         #0F1111;
    --border:        #D5D9D9;
    --muted:         #555555;
    --link:          #007185;
    --green:         #007600;
    --green-bg:      #EAF7EA;
    --green-border:  #B5D9B5;
    --red:           #B12704;
    --radius:        4px;
    --shadow:        0 1px 4px rgba(0,0,0,.07), 0 2px 14px rgba(0,0,0,.05);
    --font-display:  'Orbitron', sans-serif;
    --font-tech:     'Chakra Petch', sans-serif;
    --font-body:     'DM Sans', sans-serif;
}

/* ── Página ─────────────────────────────────────────────────── */
.zok-page {
    background: var(--bg-soft);
    min-height: 80vh;
    padding: 40px 0 70px;
    font-family: var(--font-body);
    color: var(--black);
}
.zok-wrap {
    width: 100%;
    max-width: 760px;
    margin: 0 auto;
    padding: 0 16px;
}

/* ── Bloque de éxito hero ───────────────────────────────────── */
.zok-hero {
    text-align: center;
    padding: 36px 20px 32px;
    background: var(--bg);
    border: 1px solid var(--border);
    border-top: 4px solid var(--green);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    margin-bottom: 20px;
}

.zok-check-ring {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    background: var(--green-bg);
    border: 2px solid var(--green-border);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}
.zok-check-ring svg {
    width: 36px;
    height: 36px;
    color: var(--green);
}

.zok-order-label {
    font-family: var(--font-tech);
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: var(--green);
    margin-bottom: 8px;
}
.zok-title {
    font-family: var(--font-display);
    font-size: 20px;
    font-weight: 800;
    color: var(--navy);
    text-transform: uppercase;
    letter-spacing: .3px;
    margin-bottom: 10px;
    line-height: 1.25;
}
.zok-greeting {
    font-size: 14px;
    color: var(--muted);
    margin-bottom: 6px;
}
.zok-greeting strong { color: var(--black); font-weight: 600; }

.zok-order-num {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--bg-soft);
    border: 1px solid var(--border);
    border-radius: 3px;
    padding: 5px 14px;
    font-family: var(--font-tech);
    font-size: 12px;
    font-weight: 700;
    color: var(--navy);
    text-transform: uppercase;
    letter-spacing: .8px;
    margin-top: 12px;
}
.zok-order-num-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: var(--orange);
    flex-shrink: 0;
}

/* ── Panel genérico ─────────────────────────────────────────── */
.zok-panel {
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    overflow: hidden;
    margin-bottom: 16px;
}
.zok-panel__hd {
    background: var(--navy);
    padding: 12px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.zok-panel__hd-title {
    font-family: var(--font-display);
    font-size: 10px;
    font-weight: 700;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: .8px;
}
.zok-panel__hd-tag {
    font-family: var(--font-tech);
    font-size: 10px;
    font-weight: 700;
    color: var(--orange);
    text-transform: uppercase;
    letter-spacing: .5px;
    border: 1px solid rgba(254,189,105,.3);
    padding: 2px 8px;
    border-radius: 2px;
}

/* ── Bloque de acciones rápidas (links de gestión) ─────────── */
.zok-actions-body { padding: 20px; }
.zok-actions-desc {
    font-size: 13px;
    color: var(--muted);
    margin-bottom: 16px;
    line-height: 1.55;
}
.zok-actions-desc strong { color: var(--black); }

.zok-actions-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}
@media (max-width: 480px) {
    .zok-actions-grid { grid-template-columns: 1fr; }
}

/* Botón naranja (acción primaria) */
.zok-btn-primary {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    background: var(--orange);
    border: 1px solid #A88734;
    color: var(--black);
    font-family: var(--font-tech);
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
    padding: 11px 16px;
    border-radius: var(--radius);
    text-decoration: none;
    transition: background .15s;
    cursor: pointer;
}
.zok-btn-primary:hover { background: var(--orange-hover); }

/* Botón secundario (outline navy) */
.zok-btn-secondary {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    background: var(--bg);
    border: 1px solid var(--border);
    color: var(--black);
    font-family: var(--font-tech);
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
    padding: 11px 16px;
    border-radius: var(--radius);
    text-decoration: none;
    transition: all .15s;
    cursor: pointer;
}
.zok-btn-secondary:hover {
    border-color: var(--navy);
    background: var(--bg-soft);
}

/* Botón navy sólido (descarga) */
.zok-btn-navy {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    background: var(--navy);
    border: 1px solid var(--navy-light);
    color: #fff;
    font-family: var(--font-tech);
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
    padding: 11px 16px;
    border-radius: var(--radius);
    text-decoration: none;
    transition: background .15s;
    cursor: pointer;
}
.zok-btn-navy:hover { background: var(--navy-light); }

/* ── Lista de ítems ─────────────────────────────────────────── */
.zok-items {
    list-style: none;
    margin: 0;
    padding: 0;
}
.zok-item {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 12px;
    padding: 13px 20px;
    border-bottom: 1px solid #F3F3F3;
    transition: background .15s;
}
.zok-item:last-child { border-bottom: none; }
.zok-item:hover { background: #FAFAFA; }

.zok-item__name {
    font-size: 13px;
    font-weight: 600;
    color: var(--black);
    margin-bottom: 3px;
    line-height: 1.35;
}
.zok-item__qty {
    font-family: var(--font-tech);
    font-size: 10px;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: .7px;
}
.zok-item__bs {
    font-family: var(--font-tech);
    font-size: 10px;
    color: var(--link);
    font-weight: 700;
    margin-top: 2px;
}

.zok-item__price {
    text-align: right;
    flex-shrink: 0;
}
.zok-item__usd {
    font-size: 14px;
    font-weight: 700;
    color: var(--black);
    white-space: nowrap;
}

/* ── Desglose de totales ────────────────────────────────────── */
.zok-totals {
    padding: 14px 20px 0;
    border-top: 1px solid var(--border);
}
.zok-total-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 12px;
    padding: 6px 0;
    border-bottom: 1px solid #F3F3F3;
    color: var(--muted);
}
.zok-total-row:last-of-type { border-bottom: none; }
.zok-total-row__val { font-weight: 600; color: var(--black); }

/* Bloque total final */
.zok-grand {
    margin: 0 20px;
    padding: 14px 0 18px;
    border-top: 2px solid var(--navy);
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
}
.zok-grand__label {
    font-family: var(--font-display);
    font-size: 11px;
    font-weight: 700;
    color: var(--navy);
    text-transform: uppercase;
    letter-spacing: .5px;
}
.zok-grand__amounts { text-align: right; }
.zok-grand__usd {
    font-family: var(--font-display);
    font-size: 24px;
    font-weight: 800;
    color: var(--navy);
    line-height: 1;
}
.zok-grand__bs {
    font-family: var(--font-tech);
    font-size: 12px;
    color: var(--link);
    font-weight: 700;
    margin-top: 4px;
}

/* ── Botones finales ─────────────────────────────────────────── */
.zok-footer-actions {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    margin-top: 20px;
}
@media (max-width: 480px) {
    .zok-footer-actions { grid-template-columns: 1fr; }
}

/* ── Nota de confirmación por email ─────────────────────────── */
.zok-email-note {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    background: #FFF8EC;
    border: 1px solid #F5DDA0;
    border-radius: var(--radius);
    padding: 13px 16px;
    margin-bottom: 16px;
    font-size: 12px;
    color: #6B4F0A;
    line-height: 1.55;
}
.zok-email-note-icon { font-size: 18px; flex-shrink: 0; margin-top: 1px; }
</style>

<div class="zok-page">
<div class="zok-wrap">

    {{-- ── HERO DE ÉXITO ──────────────────────────────────── --}}
    <div class="zok-hero">
        <div class="zok-check-ring">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"
                 stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <div class="zok-order-label">✓ Pedido procesado correctamente</div>
        <div class="zok-title">¡Gracias por tu compra!</div>
        <p class="zok-greeting">
            Hola, <strong>{{ $order->customer_name }}</strong>.
            Tu pedido ha sido recibido y está siendo procesado.
        </p>
        <div class="zok-order-num">
            <span class="zok-order-num-dot"></span>
            Pedido #{{ $order->id }}
        </div>
    </div>

    {{-- ── NOTA EMAIL ──────────────────────────────────────── --}}
    <div class="zok-email-note">
        <span class="zok-email-note-icon">📧</span>
        <span>
            Recibirás una confirmación en tu correo electrónico con los detalles del pedido
            y las instrucciones para completar el pago.
        </span>
    </div>

    {{-- ── PANEL: GESTIÓN DE ORDEN ────────────────────────── --}}
    <div class="zok-panel">
        <div class="zok-panel__hd">
            <span class="zok-panel__hd-title">Gestión del Pedido</span>
            <span class="zok-panel__hd-tag">Acceso directo</span>
        </div>
        <div class="zok-actions-body">
            <p class="zok-actions-desc">
                Usa los siguientes <strong>enlaces seguros</strong> para gestionar tu pedido
                sin necesidad de iniciar sesión:
            </p>
            <div class="zok-actions-grid">
                <a href="{{ $reportPaymentUrl }}" class="zok-btn-primary">
                    💳 Reportar Pago / Transferencia
                </a>
                <a href="{{ $viewOrderUrl }}" class="zok-btn-secondary">
                    📦 Ver Estado del Pedido
                </a>
            </div>
        </div>
    </div>

    {{-- ── PANEL: RESUMEN DEL PEDIDO ─────────────────────── --}}
    <div class="zok-panel">
        <div class="zok-panel__hd">
            <span class="zok-panel__hd-title">Resumen del Pedido</span>
            <span class="zok-panel__hd-tag">#{{ $order->id }}</span>
        </div>

        {{-- Lista de ítems --}}
        <ul class="zok-items">
            @foreach($order->items as $item)
                <li class="zok-item">
                    <div style="flex:1;min-width:0">
                        <div class="zok-item__name">{{ $item->name }}</div>
                        <div class="zok-item__qty">Cantidad: {{ $item->quantity }}</div>
                        @if($item->total_bs)
                            <div class="zok-item__bs">
                                Bs. {{ number_format($item->total_bs, 2) }}
                            </div>
                        @endif
                    </div>
                    <div class="zok-item__price">
                        <div class="zok-item__usd">
                            ${{ number_format($item->price * $item->quantity, 2) }}
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>

        {{-- Desglose fiscal --}}
        @if($order->taxable_base)
            <div class="zok-totals">
                <div class="zok-total-row">
                    <span>Base Imponible</span>
                    <span class="zok-total-row__val">
                        ${{ number_format($order->taxable_base, 2) }}
                    </span>
                </div>
                <div class="zok-total-row">
                    <span>IVA</span>
                    <span class="zok-total-row__val">
                        ${{ number_format($order->tax_amount, 2) }}
                    </span>
                </div>
            </div>
        @endif

        {{-- Total final --}}
        <div class="zok-grand">
            <span class="zok-grand__label">Total pagado</span>
            <div class="zok-grand__amounts">
                <div class="zok-grand__usd">
                    ${{ number_format($order->total, 2) }}
                </div>
                @if($order->total_bs)
                    <div class="zok-grand__bs">
                        Bs. {{ number_format($order->total_bs, 2) }}
                    </div>
                @endif
            </div>
        </div>

    </div>{{-- /resumen --}}

    {{-- ── ACCIONES FINALES ───────────────────────────────── --}}
    <div class="zok-footer-actions">
        <a href="{{ URL::temporarySignedRoute('orders.invoice', now()->addHours(24), ['orderId' => $order->id]) }}"
           class="zok-btn-navy">
            <svg style="width:14px;height:14px;flex-shrink:0" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <path d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            Descargar Factura (PDF)
        </a>
        <a href="{{ route('home') }}" class="zok-btn-secondary">
            ← Volver al Inicio
        </a>
    </div>

</div>{{-- /zok-wrap --}}
</div>{{-- /zok-page --}}

</x-front-layout>