<x-front-layout>

{{-- ============================================================
     ZOLUM SHOP — REPORTE DE PAGO (GUEST VIEW)
     Sistema visual: Brandbook Zolum (#FFFFFF + #131921 + #FFC933)
     ============================================================ --}}

@php
    // Evaluamos si el método de pago seleccionado es en Divisas/USD
    $methodCurrency = strtoupper($order->paymentMethod->currency ?? 'BS');
    $isUsd = in_array($methodCurrency, ['USD', 'DOLLAR', '$']);
@endphp

<style>
@import url('https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@400;600;700&family=Orbitron:wght@700;800&family=DM+Sans:wght@400;500;600;700&display=swap');

:root {
    --bg:             #FFFFFF;
    --bg-soft:        #F4F6F6;
    --bg-field:       #FAFAFA;
    --navy:           #131921;
    --navy-light:     #1A2536;
    --orange:         #FFC933;
    --orange-hover:   #F3A847;
    --black:          #0F1111;
    --border:         #D5D9D9;
    --border-focus:   #E77600;
    --muted:          #555555;
    --link:           #007185;
    --red:            #B12704;
    --radius:         4px;
    --shadow:         0 1px 4px rgba(0,0,0,.07), 0 2px 14px rgba(0,0,0,.05);
    --font-display:   'Orbitron', sans-serif;
    --font-tech:      'Chakra Petch', sans-serif;
    --font-body:      'DM Sans', sans-serif;
}

.zrp-page {
    background: var(--bg-soft);
    min-height: 85vh;
    padding: 40px 0 70px;
    font-family: var(--font-body);
    color: var(--black);
}
.zrp-wrap {
    width: 100%;
    max-width: 680px;
    margin: 0 auto;
    padding: 0 16px;
}

/* ── ENCABEZADO DE PÁGINA ───────────────────────────────────── */
.zrp-header {
    text-align: center;
    margin-bottom: 28px;
}
.zrp-header__title {
    font-family: var(--font-display);
    font-size: 24px;
    font-weight: 800;
    color: var(--navy);
    text-transform: uppercase;
    letter-spacing: .5px;
    margin-bottom: 6px;
}
.zrp-header__subtitle {
    font-size: 13px;
    color: var(--muted);
}

/* ── CONTENEDOR Y COPETE DEL FORMULARIO ──────────────────────── */
.zrp-panel {
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    overflow: hidden;
}
.zrp-panel__billboard {
    background: var(--navy);
    padding: 20px 24px;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    border-bottom: 3px solid var(--orange);
}
.zrp-billboard__label {
    font-family: var(--font-tech);
    font-size: 10px;
    font-weight: 600;
    color: var(--orange);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 2px;
}
.zrp-billboard__title {
    font-family: var(--font-display);
    font-size: 18px;
    font-weight: 700;
    color: #FFFFFF;
    margin: 0;
}
.zrp-billboard__sub {
    font-family: var(--font-tech);
    font-size: 11px;
    color: #A2B2C8;
    margin-top: 3px;
}

.zrp-billboard__right { text-align: right; }
.zrp-billboard__amount {
    font-family: var(--font-tech);
    font-size: 24px;
    font-weight: 700;
    color: #FFFFFF;
    line-height: 1.1;
}
.zrp-billboard__ref {
    font-family: var(--font-tech);
    font-size: 11px;
    color: #A2B2C8;
    margin-top: 2px;
}

/* ── DATOS PARA TRANSFERIR & COPIA RÁPIDA ─────────────────── */
.zrp-bank-info {
    background: #F0F4F8;
    border-bottom: 1px solid var(--border);
    padding: 16px 24px;
}
.zrp-bank-info__header {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 8px;
}
.zrp-bank-info__title {
    font-family: var(--font-tech);
    font-size: 13px;
    font-weight: 700;
    color: var(--navy);
    text-transform: uppercase;
    margin: 0;
}
.zrp-bank-info__body {
    font-size: 13px;
    color: var(--black);
    line-height: 1.5;
    white-space: pre-line;
}

.zrp-details-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
    margin-top: 12px;
}
.zrp-qr-box {
    display: flex;
    flex-direction: column;
    align-items: center;
    background: #FFFFFF;
    padding: 10px;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    width: 130px;
    flex-shrink: 0;
}
.zrp-qr-img {
    width: 110px;
    height: 110px;
    object-fit: contain;
}
.zrp-qr-label {
    font-family: var(--font-tech);
    font-size: 10px;
    color: var(--muted);
    margin-top: 6px;
    text-transform: uppercase;
}

.zrp-copy-list {
    flex: 1;
    min-width: 240px;
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.zrp-copy-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #FFFFFF;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 8px 12px;
}
.zrp-copy-info {
    display: flex;
    flex-direction: column;
    overflow: hidden;
    padding-right: 8px;
}
.zrp-copy-label {
    font-size: 10px;
    font-weight: 700;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: .5px;
}
.zrp-copy-val {
    font-family: var(--font-tech);
    font-size: 13px;
    font-weight: 700;
    color: var(--navy);
    word-break: break-all;
}
.zrp-btn-copy {
    background: var(--navy);
    color: #FFFFFF;
    border: none;
    font-family: var(--font-tech);
    font-size: 11px;
    font-weight: 700;
    padding: 6px 12px;
    border-radius: var(--radius);
    cursor: pointer;
    text-transform: uppercase;
    transition: background .15s;
    flex-shrink: 0;
}
.zrp-btn-copy:hover {
    background: var(--orange);
    color: var(--black);
}

/* ── CUERPO DEL FORMULARIO Y CAMPOS ─────────────────────────── */
.zrp-form { padding: 28px 24px; }
.zrp-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }

.zrp-group { display: flex; flex-direction: column; }
.zrp-label {
    font-size: 12px;
    font-weight: 700;
    color: var(--black);
    margin-bottom: 6px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.zrp-req { color: var(--red); }
.zrp-opt { color: var(--muted); font-weight: 400; font-size: 11px; }

.zrp-input-wrapper { position: relative; display: flex; width: 100%; }
.zrp-input-prefix {
    position: absolute;
    left: 1px;
    top: 1px;
    bottom: 1px;
    background: #EDF2F2;
    border-right: 1px solid var(--border);
    display: flex;
    align-items: center;
    padding: 0 12px;
    font-family: var(--font-tech);
    font-size: 12px;
    font-weight: 600;
    color: var(--muted);
    border-top-left-radius: calc(var(--radius) - 1px);
    border-bottom-left-radius: calc(var(--radius) - 1px);
    pointer-events: none;
}
.zrp-control {
    width: 100%;
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 10px 12px;
    font-family: var(--font-body);
    font-size: 13px;
    color: var(--black);
    outline: none;
    transition: all .15s;
    box-shadow: inset 0 1px 2px rgba(0,0,0,0.05);
}
.zrp-control:focus {
    border-color: var(--border-focus);
    box-shadow: 0 0 3px rgba(228,121,17,0.5);
}
.zrp-control--prefixed { padding-left: 52px; }
.zrp-control--error { border-color: var(--red) !important; background: #FFF9F9; }

.zrp-error-msg {
    color: var(--red);
    font-size: 11px;
    font-weight: 600;
    margin-top: 4px;
}

/* ── COMPONENTE DROPZONE (FILE INPUT) ───────────────────────── */
.zrp-dropzone {
    border: 2px dashed var(--border);
    border-radius: var(--radius);
    padding: 24px 16px;
    text-align: center;
    background: var(--bg-field);
    cursor: pointer;
    transition: border-color .15s, background .15s;
}
.zrp-dropzone:hover { border-color: var(--border-focus); background: #FFFBF5; }
.zrp-dropzone__icon {
    font-size: 28px;
    color: var(--muted);
    margin-bottom: 8px;
    display: block;
}
.zrp-dropzone__text { font-size: 13px; color: var(--muted); }
.zrp-dropzone__link { color: var(--link); font-weight: 600; }
.zrp-dropzone__info { font-size: 11px; color: var(--muted); margin-top: 4px; }

/* ── BOTÓN ACCIÓN DE ENVÍO ──────────────────────────────────── */
.zrp-submit-box { margin-top: 28px; padding-top: 16px; border-top: 1px solid var(--border); }
.zrp-btn-submit {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    background: var(--orange);
    border: 1px solid #A88734;
    color: var(--black);
    font-family: var(--font-tech);
    font-size: 13px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
    padding: 13px 20px;
    border-radius: var(--radius);
    cursor: pointer;
    transition: background .15s;
}
.zrp-btn-submit:hover { background: var(--orange-hover); }

/* Footer de ayuda */
.zrp-footer { text-align: center; margin-top: 24px; font-size: 12px; color: var(--muted); line-height: 1.5; }
.zrp-footer strong { color: var(--black); }

@media (max-width: 560px) {
    .zrp-grid { grid-template-columns: 1fr; gap: 16px; }
    .zrp-panel__billboard { flex-direction: column; align-items: flex-start; text-align: left; }
    .zrp-billboard__right { text-align: left; }
    .zrp-details-grid { flex-direction: column; }
    .zrp-qr-box { width: 100%; }
}
</style>

<div class="zrp-page">
    <div class="zrp-wrap">

        {{-- ── TITULAR DE LA ACCIÓN ── --}}
        <div class="zrp-header">
            <h1 class="zrp-header__title">Reportar Pago</h1>
            <p class="zrp-header__subtitle">Registra los datos de tu transferencia o pago móvil para procesar tu pedido.</p>
        </div>

        {{-- ── PANEL PRINCIPAL ── --}}
        <div class="zrp-panel">
            @if ($errors->any())
                <div class="alert alert-danger" style="color: red; padding: 12px 24px;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                    
            {{-- Billboard de Datos de la Orden --}}
            <div class="zrp-panel__billboard">
                <div>
                    <div class="zrp-billboard__label">Documento de Referencia</div>
                    <h3 class="zrp-billboard__title">Orden #{{ $order->id }}</h3>
                    <div class="zrp-billboard__sub">Fecha: {{ $order->created_at->format('d/m/Y h:i A') }}</div>
                </div>
                <div class="zrp-billboard__right">
                    <div class="zrp-billboard__label">Monto Total a Pagar</div>
                    @if($order->paymentMethod)
                        <div class="zrp-billboard__sub">Método: {{ $order->paymentMethod->name }} ({{ $order->paymentMethod->currency }})</div>
                    @endif

                    @if($isUsd)
                        <div class="zrp-billboard__amount">${{ number_format($order->total_usd ?? $order->total, 2) }} USD</div>
                        <div class="zrp-billboard__ref">Ref: Bs. {{ number_format($order->total_bs, 2) }}</div>
                    @else
                        <div class="zrp-billboard__amount">Bs. {{ number_format($order->total_bs, 2) }}</div>
                        @if(isset($order->total_usd) || isset($order->total))
                            <div class="zrp-billboard__ref">Ref: ${{ number_format($order->total_usd ?? $order->total, 2) }} USD</div>
                        @endif
                    @endif
                </div>
            </div>

            {{-- Datos de Cuenta / Instrucciones y Copia Rápida --}}
            @if($order->paymentMethod)
                <div class="zrp-bank-info">
                    <div class="zrp-bank-info__header">
                        <span>💳</span>
                        <h4 class="zrp-bank-info__title">Datos para realizar el pago ({{ $order->paymentMethod->name }})</h4>
                    </div>

                    @if($order->paymentMethod->description)
                        <div class="zrp-bank-info__body mb-3">{{ $order->paymentMethod->description }}</div>
                    @endif

                    <div class="zrp-details-grid">
                        {{-- Imagen QR de Pago --}}
                        @if($order->paymentMethod->qr_code)
                            <div class="zrp-qr-box">
                                <img src="{{ asset('storage/' . $order->paymentMethod->qr_code) }}" alt="QR de Pago" class="zrp-qr-img">
                                <span class="zrp-qr-label">Escanea para pagar</span>
                            </div>
                        @endif

                        {{-- Lista de Datos para Copiar (Formato Label - Value) --}}
                        @if(!empty($order->paymentMethod->bank_details) && is_array($order->paymentMethod->bank_details))
                            <div class="zrp-copy-list">
                                @foreach($order->paymentMethod->bank_details as $index => $detail)
                                    @php
                                        $label = is_array($detail) ? ($detail['label'] ?? '') : '';
                                        $val = is_array($detail) ? ($detail['value'] ?? '') : $detail;
                                    @endphp
                                    
                                    @if(!empty($val))
                                        <div class="zrp-copy-item">
                                            <div class="zrp-copy-info">
                                                @if($label)
                                                    <span class="zrp-copy-label">{{ $label }}</span>
                                                @endif
                                                <span class="zrp-copy-val" id="copy-text-{{ $index }}">{{ $val }}</span>
                                            </div>
                                            <button type="button" 
                                                    onclick="copyToClipboard('copy-text-{{ $index }}', this)" 
                                                    class="zrp-btn-copy">
                                                Copiar
                                            </button>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Formulario de Reporte de Pago --}}
            <form action="{{ route('guest.payments.store', $order->id) }}" method="POST" enctype="multipart/form-data" class="zrp-form">
                @csrf

                <input type="hidden" name="payment_method_id" value="{{ $order->payment_method_id }}">

                {{-- FILA 1: Monto y Referencia --}}
                <div class="zrp-grid">
                    <div class="zrp-group">
                        <label for="amount_bs" class="zrp-label">
                            Monto Pagado ({{ $isUsd ? 'USD' : 'Bs.' }}) <span class="zrp-req">*</span>
                        </label>
                        <div class="zrp-input-wrapper">
                            <span class="zrp-input-prefix">{{ $isUsd ? '$' : 'Bs.' }}</span>
                            <input type="number" step="0.01" name="amount_bs" id="amount_bs" 
                                value="{{ old('amount_bs', $isUsd ? ($order->total_usd ?? $order->total) : $order->total_bs) }}"
                                class="zrp-control zrp-control--prefixed @error('amount_bs') zrp-control--error @enderror" 
                                required>
                        </div>
                        @error('amount_bs')
                            <span class="zrp-error-msg">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="zrp-group">
                        <label for="reference_number" class="zrp-label">
                            Número de Referencia <span class="zrp-req">*</span>
                        </label>
                        <input type="text" name="reference_number" id="reference_number" 
                            value="{{ old('reference_number') }}"
                            placeholder="Ej: 12345678"
                            class="zrp-control @error('reference_number') zrp-control--error @enderror" 
                            required>
                        @error('reference_number')
                            <span class="zrp-error-msg">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- FILA 2: Banco y Fecha --}}
                <div class="zrp-grid">
                    <div class="zrp-group">
                        <label for="bank_name" class="zrp-label">
                            Banco / Plataforma Emisora <span class="zrp-req">*</span>
                        </label>
                        <input type="text" name="bank_name" id="bank_name" 
                            value="{{ old('bank_name', $order->paymentMethod->name ?? '') }}"
                            placeholder="{{ $isUsd ? 'Ej: Zelle, Binance, Banesco Panamá...' : 'Ej: Banesco, Pago Móvil Mercantil...' }}"
                            class="zrp-control @error('bank_name') zrp-control--error @enderror" 
                            required>
                        @error('bank_name')
                            <span class="zrp-error-msg">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="zrp-group">
                        <label for="payment_date" class="zrp-label">
                            Fecha de la Transacción <span class="zrp-req">*</span>
                        </label>
                        <input type="date" name="payment_date" id="payment_date" 
                            value="{{ old('payment_date', date('Y-m-d')) }}"
                            max="{{ date('Y-m-d') }}"
                            class="zrp-control @error('payment_date') zrp-control--error @enderror" 
                            required>
                        @error('payment_date')
                            <span class="zrp-error-msg">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- FILA 3: Comprobante Dropzone Digital --}}
                <div class="zrp-group" style="margin-top: 8px;">
                    <label class="zrp-label">
                        Comprobante de Pago <span class="zrp-opt">(Opcional)</span>
                    </label>
                    <div class="zrp-dropzone" onclick="document.getElementById('proof_image').click()">
                        <span class="zrp-dropzone__icon">📂</span>
                        <div class="zrp-dropzone__text">
                            <span class="zrp-dropzone__link" id="zrp-text-trigger">Sube un archivo</span> o arrastra y suelta aquí
                        </div>
                        <div class="zrp-dropzone__info">Formatos aceptados: JPG, PNG (Máx. 2MB)</div>
                        <input id="proof_image" name="proof_image" type="file" accept="image/*" style="display: none;">
                    </div>
                    @error('proof_image')
                        <span class="zrp-error-msg">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Botón Envío de Formulario --}}
                <div class="zrp-submit-box">
                    <button type="submit" class="zrp-btn-submit">
                        Validar y Enviar Reporte
                    </button>
                </div>
            </form>

        </div>{{-- /zrp-panel --}}

        {{-- Notas aclaratorias al pie --}}
        <div class="zrp-footer">
            ¿Tienes problemas con tu reporte? Contáctanos de inmediato mencionando tu código de <strong>Orden #{{ $order->id }}</strong>.
        </div>

    </div>{{-- /zrp-wrap --}}
</div>{{-- /zrp-page --}}

<script>
    document.getElementById('proof_image').addEventListener('change', function(e) {
        let fileName = e.target.files[0] ? e.target.files[0].name : "Sube un archivo";
        document.getElementById('zrp-text-trigger').textContent = fileName;
    });

    function copyToClipboard(elementId, btnElement) {
        const textToCopy = document.getElementById(elementId).innerText;
        
        navigator.clipboard.writeText(textToCopy).then(() => {
            const originalText = btnElement.innerText;
            btnElement.innerText = '¡Copiado!';
            btnElement.style.background = '#2e7d32';
            btnElement.style.color = '#ffffff';

            setTimeout(() => {
                btnElement.innerText = originalText;
                btnElement.style.background = '';
                btnElement.style.color = '';
            }, 2000);
        }).catch(err => {
            console.error('Error al copiar: ', err);
        });
    }
</script>

</x-front-layout>