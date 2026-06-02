<x-customer-layout>
    <div style="background-color: var(--bg-pure-white); border: 1px solid var(--border-gray); border-radius: 4px; box-shadow: 0 1px 4px rgba(0,0,0,.08); overflow: hidden; color: var(--carbon-black); max-width: 720px; margin: 0 auto;">
        
        {{-- Barra de acento superior de la marca --}}
        <div style="height: 6px; width: 100%; background-color: var(--midnight-blue);"></div>

        <div style="padding: 2rem;">
            
            {{-- Encabezado del Módulo --}}
            <div style="margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 1px solid #E5E7EB;">
                <h2 class="zl-font-display" style="font-size: 22px; font-weight: 700; color: var(--midnight-blue); margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">
                    Reportar Pago
                </h2>
                <p class="zl-font-technical" style="font-size: 11px; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin: 0.25rem 0 0 0;">
                    Formulario oficial de notificación y registro de transferencias comerciales
                </p>
            </div>

            {{-- Formulario de Reporte --}}
            <form action="{{ route('customer.payments.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Campo: Seleccionar Orden --}}
                <div style="margin-bottom: 1.25rem;">
                    <label class="zl-font-technical" style="display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--carbon-black); margin-bottom: 0.5rem;">
                        Seleccionar Orden Pendiente
                    </label>
                    <select name="order_id" 
                            style="width: 100%; box-sizing: border-box; border: 1px solid {{ $errors->has('order_id') ? 'var(--error-red)' : 'var(--border-gray)' }}; border-radius: 4px; padding: 0.65rem 0.75rem; font-size: 14px; color: var(--carbon-black); background-color: #FFFFFF; cursor: pointer; transition: border-color 0.2s;"
                            onfocus="this.style.borderColor='var(--midnight-blue)';" 
                            onblur="this.style.borderColor='{{ $errors->has('order_id') ? 'var(--error-red)' : 'var(--border-gray)' }}';"
                            required>
                        <option value="">Seleccione una orden en espera de conciliación</option>
                        @foreach($orders as $order)
                            <option value="{{ $order->id }}" {{ old('order_id') == $order->id ? 'selected' : '' }}>
                                Orden #{{ $order->id }} — Bs. {{ number_format($order->total_bs, 2) }} ({{ $order->created_at->format('d/m/Y') }})
                            </option>
                        @endforeach
                    </select>
                    @error('order_id')
                        <p class="zl-font-technical" style="color: var(--error-red); font-size: 11px; font-weight: 600; margin: 0.35rem 0 0 0; text-transform: uppercase;">
                            ⚠ {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Bloque Fila 1: Monto y Referencia --}}
                <div style="display: flex; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.25rem;">
                    {{-- Monto Pagado --}}
                    <div style="flex: 1 1 calc(50% - 0.5rem); min-width: 250px;">
                        <label class="zl-font-technical" style="display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--carbon-black); margin-bottom: 0.5rem;">
                            Monto Pagado (BS)
                        </label>
                        <input type="number" step="0.01" name="amount_bs" value="{{ old('amount_bs') }}"
                               style="width: 100%; box-sizing: border-box; border: 1px solid {{ $errors->has('amount_bs') ? 'var(--error-red)' : 'var(--border-gray)' }}; border-radius: 4px; padding: 0.65rem 0.75rem; font-size: 14px; color: var(--carbon-black); background-color: #FFFFFF; transition: border-color 0.2s;" 
                               onfocus="this.style.borderColor='var(--midnight-blue)';" 
                               onblur="this.style.borderColor='{{ $errors->has('amount_bs') ? 'var(--error-red)' : 'var(--border-gray)' }}';"
                               required>
                        @error('amount_bs')
                            <p class="zl-font-technical" style="color: var(--error-red); font-size: 11px; font-weight: 600; margin: 0.35rem 0 0 0; text-transform: uppercase;">
                                ⚠ {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    {{-- Número de Referencia --}}
                    <div style="flex: 1 1 calc(50% - 0.5rem); min-width: 250px;">
                        <label class="zl-font-technical" style="display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--carbon-black); margin-bottom: 0.5rem;">
                            Número de Referencia
                        </label>
                        <input type="text" name="reference_number" value="{{ old('reference_number') }}"
                               style="width: 100%; box-sizing: border-box; border: 1px solid {{ $errors->has('reference_number') ? 'var(--error-red)' : 'var(--border-gray)' }}; border-radius: 4px; padding: 0.65rem 0.75rem; font-size: 14px; color: var(--carbon-black); background-color: #FFFFFF; transition: border-color 0.2s;" 
                               onfocus="this.style.borderColor='var(--midnight-blue)';" 
                               onblur="this.style.borderColor='{{ $errors->has('reference_number') ? 'var(--error-red)' : 'var(--border-gray)' }}';"
                               required>
                        @error('reference_number')
                            <p class="zl-font-technical" style="color: var(--error-red); font-size: 11px; font-weight: 600; margin: 0.35rem 0 0 0; text-transform: uppercase;">
                                ⚠ {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                {{-- Bloque Fila 2: Banco Emisor y Fecha del Pago --}}
                <div style="display: flex; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.25rem;">
                    {{-- Banco Emisor --}}
                    <div style="flex: 1 1 calc(50% - 0.5rem); min-width: 250px;">
                        <label class="zl-font-technical" style="display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--carbon-black); margin-bottom: 0.5rem;">
                            Banco Emisor
                        </label>
                        <input type="text" name="bank_name" value="{{ old('bank_name') }}"
                               style="width: 100%; box-sizing: border-box; border: 1px solid {{ $errors->has('bank_name') ? 'var(--error-red)' : 'var(--border-gray)' }}; border-radius: 4px; padding: 0.65rem 0.75rem; font-size: 14px; color: var(--carbon-black); background-color: #FFFFFF; transition: border-color 0.2s;" 
                               placeholder="Ej: Banesco, Mercantil, Provincial..."
                               onfocus="this.style.borderColor='var(--midnight-blue)';" 
                               onblur="this.style.borderColor='{{ $errors->has('bank_name') ? 'var(--error-red)' : 'var(--border-gray)' }}';"
                               required>
                        @error('bank_name')
                            <p class="zl-font-technical" style="color: var(--error-red); font-size: 11px; font-weight: 600; margin: 0.35rem 0 0 0; text-transform: uppercase;">
                                ⚠ {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    {{-- Fecha del Pago --}}
                    <div style="flex: 1 1 calc(50% - 0.5rem); min-width: 250px;">
                        <label class="zl-font-technical" style="display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--carbon-black); margin-bottom: 0.5rem;">
                            Fecha del Pago
                        </label>
                        <input type="date" name="payment_date" value="{{ old('payment_date', date('Y-m-d')) }}"
                               style="width: 100%; box-sizing: border-box; border: 1px solid {{ $errors->has('payment_date') ? 'var(--error-red)' : 'var(--border-gray)' }}; border-radius: 4px; padding: 0.65rem 0.75rem; font-size: 14px; color: var(--carbon-black); background-color: #FFFFFF; transition: border-color 0.2s;" 
                               onfocus="this.style.borderColor='var(--midnight-blue)';" 
                               onblur="this.style.borderColor='{{ $errors->has('payment_date') ? 'var(--error-red)' : 'var(--border-gray)' }}';"
                               required>
                        @error('payment_date')
                            <p class="zl-font-technical" style="color: var(--error-red); font-size: 11px; font-weight: 600; margin: 0.35rem 0 0 0; text-transform: uppercase;">
                                ⚠ {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                {{-- Campo: Comprobante de Pago Digital --}}
                <div style="margin-bottom: 2rem;">
                    <label class="zl-font-technical" style="display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--carbon-black); margin-bottom: 0.5rem;">
                        Comprobante (Imagen - Opcional)
                    </label>
                    <input type="file" name="proof_image" accept="image/*"
                           style="width: 100%; box-sizing: border-box; border: 1px solid {{ $errors->has('proof_image') ? 'var(--error-red)' : 'var(--border-gray)' }}; border-radius: 4px; padding: 0.5rem; font-size: 13px; color: var(--text-muted); background-color: #FAFAFA;" >
                    @error('proof_image')
                        <p class="zl-font-technical" style="color: var(--error-red); font-size: 11px; font-weight: 600; margin: 0.35rem 0 0 0; text-transform: uppercase;">
                            ⚠ {{ $message }}
                        </p>
                    @enderror
                    <p style="color: var(--text-muted); font-size: 12px; font-style: italic; margin: 0.35rem 0 0 0;">
                        Formatos institucionales admitidos: JPG, PNG. Peso límite por archivo: 2MB.
                    </p>
                </div>

                {{-- Envío del Formulario --}}
                <div style="text-align: right;">
                    <button type="submit"
                            class="zl-font-technical"
                            style="background-color: var(--warm-orange); border: 1px solid var(--warm-orange-hover); color: var(--carbon-black); padding: 0.75rem 2.25rem; border-radius: 4px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; cursor: pointer; transition: background-color 0.2s;"
                            onmouseover="this.style.backgroundColor='var(--warm-orange-hover)';"
                            onmouseout="this.style.backgroundColor='var(--warm-orange)';">
                        Enviar Reporte de Pago
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-customer-layout>