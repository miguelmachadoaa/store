<x-front-layout>

{{-- ============================================================
     ZOLUM SHOP — ESTADO DEL PEDIDO (GUEST VIEW)
     Sistema visual: Brandbook Zolum (#FFFFFF + #131921 + #FEBD69)
     ============================================================ --}}

<style>
@import url('https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@400;600;700&family=Orbitron:wght@700;800&family=DM+Sans:wght@400;500;600;700&display=swap');

/* ── Variables Reutilizadas del Brandbook Global ──────────────── */
:root {
    --bg:            #FFFFFF;
    --bg-soft:       #F4F6F6;
    --navy:          #131921;
    --navy-light:    #1A2536;
    --orange:        #FEBD69;
    --orange-hover:  #F3A847;
    --black:         #0F1111;
    --border:        #D5D9D9;
    --muted:         #555555;
    --link:          #007185;
    --green:         #007600;
    --green-bg:      #EAF7EA;
    --green-border:  #B5D9B5;
    --yellow:        #B12704; /* Manteniendo coherencia con precios y alertas cálidas */
    --yellow-bg:     #FFF8EC;
    --yellow-border: #F5DDA0;
    --radius:        4px;
    --shadow:        0 1px 4px rgba(0,0,0,.07), 0 2px 14px rgba(0,0,0,.05);
    --font-display:  'Orbitron', sans-serif;
    --font-tech:     'Chakra Petch', sans-serif;
    --font-body:     'DM Sans', sans-serif;
}

/* ── Estructura de la Página ────────────────────────────────── */
.zst-page {
    background: var(--bg-soft);
    min-height: 80vh;
    padding: 40px 0 70px;
    font-family: var(--font-body);
    color: var(--black);
}
.zst-wrap {
    width: 100%;
    max-width: 680px;
    margin: 0 auto;
    padding: 0 16px;
}

/* ── Contenedor Panel Principal ──────────────────────────────── */
.zst-panel {
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    overflow: hidden;
}

/* Encabezado del Panel */
.zst-panel__hd {
    background: var(--navy);
    padding: 14px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
}
.zst-panel__hd-title {
    font-family: var(--font-display);
    font-size: 11px;
    font-weight: 700;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: .8px;
    margin: 0;
}

/* ── Badges Dinámicos de Estado (Estilo Técnico) ─────────────── */
.zst-badge {
    font-family: var(--font-tech);
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .8px;
    padding: 3px 10px;
    border-radius: 2px;
}
.zst-badge--pending {
    background: var(--orange);
    color: var(--black);
    border: 1px solid #A88734;
}
.zst-badge--success {
    background: var(--green-bg);
    color: var(--green);
    border: 1px solid var(--green-border);
}

/* Cuerpo del Panel */
.zst-panel__bd { padding: 24px 20px; }

/* Meta Datos del Cliente */
.zst-meta-group { margin-bottom: 20px; }
.zst-meta-row {
    font-size: 13px;
    line-height: 1.5;
    margin-bottom: 6px;
    color: var(--muted);
}
.zst-meta-row strong { color: var(--black); font-weight: 600; }

/* ── Subtítulos de Secciones Internas ─────────────────────────── */
.zst-subhd {
    font-family: var(--font-display);
    font-size: 10px;
    font-weight: 700;
    color: var(--navy);
    text-transform: uppercase;
    letter-spacing: .5px;
    border-b: 1px solid var(--border);
    padding-bottom: 6px;
    margin: 24px 0 10px;
}

/* ── Lista de Productos ───────────────────────────────────────── */
.zst-items { list-style: none; margin: 0; padding: 0; }
.zst-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #F3F3F3;
    font-size: 13px;
}
.zst-item:last-child { border-bottom: none; }
.zst-item__name { color: var(--black); font-weight: 500; }
.zst-item__price { font-weight: 600; color: var(--black); }

/* ── Sección de Totales Finales ───────────────────────────────── */
.zst-summary {
    margin-top: 20px;
    padding-top: 16px;
    border-top: 2px solid var(--navy);
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
}
.zst-summary__label {
    font-family: var(--font-display);
    font-size: 11px;
    font-weight: 700;
    color: var(--navy);
    text-transform: uppercase;
    letter-spacing: .5px;
}
.zst-summary__amounts { text-align: right; }
.zst-summary__usd {
    font-family: var(--font-display);
    font-size: 22px;
    font-weight: 800;
    color: var(--navy);
    line-height: 1;
}
.zst-summary__bs {
    font-family: var(--font-tech);
    font-size: 12px;
    color: var(--link);
    font-weight: 700;
    margin-top: 4px;
}

/* ── Alertas de Sistema (Flash Sessions) ─────────────────────── */
.zst-alert {
    display: flex;
    align-items: center;
    background: var(--green-bg);
    border: 1px solid var(--green-border);
    border-radius: var(--radius);
    padding: 12px 16px;
    margin-bottom: 16px;
    font-size: 13px;
    color: var(--green);
}

/* ── Acciones de Botón ────────────────────────────────────────── */
.zst-action-box {
    margin-top: 24px;
    padding-top: 20px;
    border-top: 1px solid var(--border);
}
.zst-btn-action {
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
    padding: 12px 16px;
    border-radius: var(--radius);
    text-decoration: none;
    transition: background .15s;
    cursor: pointer;
    width: 100%;
    text-align: center;
    box-shadow: 0 1px 2px rgba(0,0,0,0.05);
}
.zst-btn-action:hover { background: var(--orange-hover); }
</style>

<div class="zst-page">
    <div class="zst-wrap">

        <div class="zst-panel">
            {{-- ── ENCABEZADO DEL PANEL DE CONTROL ── --}}
            <div class="zst-panel__hd">
                <h2 class="zst-panel__hd-title">Estado del Pedido</h2>
                
                {{-- Badge de Estado con Lógica Dinámica según Marca --}}
                @if($order->status === 'pendiente' || $order->status === 'pending')
                    <span class="zst-badge zst-badge--pending">Pendiente</span>
                @else
                    <span class="zst-badge zst-badge--success">{{ $order->status }}</span>
                @endif
            </div>

            <div class="zst-panel__bd">
                {{-- Notificaciones de Éxito de Sesión --}}
                @if(session('success'))
                    <div class="zst-alert">
                        <span>✓ {{ session('success') }}</span>
                    </div>
                @endif

                {{-- Datos de Entrega / Cliente --}}
                <div class="zst-meta-group">
                    <div class="zst-meta-row"><strong>Cliente:</strong> {{ $order->customer_name }}</div>
                    <div class="zst-meta-row"><strong>Dirección de Entrega:</strong> {{ $order->address }}</div>
                </div>

                {{-- Tabla Limpia de Ítems Comprados --}}
                <div class="zst-subhd">Artículos Solicitados</div>
                <ul class="zst-items">
                    @foreach($order->items as $item)
                        <li class="zst-item">
                            <span class="zst-item__name">{{ $item->name }} (x{{ $item->quantity }})</span>
                            <span class="zst-item__price">${{ number_format($item->price * $item->quantity, 2) }}</span>
                        </li>
                    @endforeach
                </ul>

                {{-- Desglose Multimoneda en Pie de Tarjeta --}}
                <div class="zst-summary">
                    <span class="zst-summary__label">Total del Pedido</span>
                    <div class="zst-summary__amounts">
                        <div class="zst-summary__usd">${{ number_format($order->total, 2) }}</div>
                        <div class="zst-summary__bs">Ref. Bs: Bs. {{ number_format($order->total_bs, 2) }}</div>
                    </div>
                </div>

                {{-- Bloque de Interacción de Pago Seguro (Bypass de Auth) --}}
                @if($order->status === 'pendiente' || $order->status === 'pending')
                    <div class="zst-action-box">
                        <a href="{{ URL::signedRoute('guest.payments.report', ['orderId' => $order->id]) }}" class="zst-btn-action">
                            <span>💳 Reportar Pago para este Pedido</span>
                        </a>
                    </div>
                @endif
            </div>
        </div>{{-- /zst-panel --}}

    </div>{{-- /zst-wrap --}}
</div>{{-- /zst-page --}}

</x-front-layout>