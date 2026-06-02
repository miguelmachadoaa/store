<x-customer-layout>
    <div style="background-color: var(--bg-pure-white); border: 1px solid var(--border-gray); border-radius: 4px; box-shadow: 0 1px 4px rgba(0,0,0,.08); overflow: hidden; color: var(--carbon-black);">
        
        {{-- Barra de acento superior de la marca --}}
        <div style="height: 6px; width: 100%; background-color: var(--midnight-blue);"></div>

        <div style="padding: 2rem;">
            
            {{-- Cabecera Flexible del Módulo --}}
            <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 1rem; margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 1px solid #E5E7EB;">
                <div>
                    <h2 class="zl-font-display" style="font-size: 22px; font-weight: 700; color: var(--midnight-blue); margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">
                        Mis Pagos Reportados
                    </h2>
                    <p class="zl-font-technical" style="font-size: 11px; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin: 0.25rem 0 0 0;">
                        Control y conciliación de transacciones bancarias enviadas
                    </p>
                </div>
                
                {{-- Botón de Acción Principal --}}
                <a href="{{ route('customer.payments.report') }}"
                   class="zl-font-technical"
                   style="background-color: var(--warm-orange); border: 1px solid var(--warm-orange-hover); color: var(--carbon-black); px: 1.5rem; padding: 0.65rem 1.5rem; border-radius: 4px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; text-decoration: none; display: inline-block; transition: background-color 0.2s;"
                   onmouseover="this.style.backgroundColor='var(--warm-orange-hover)';"
                   onmouseout="this.style.backgroundColor='var(--warm-orange)';">
                    Reportar Nuevo Pago
                </a>
            </div>

            {{-- Mensaje de Éxito de Sesión --}}
            @if(session('success'))
                <div class="zl-font-technical" style="background-color: #E7F4E4; border: 1px solid #B4DCA1; color: var(--success-green); padding: 1rem 1.25rem; border-radius: 4px; margin-bottom: 1.5rem; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                    ✓ {{ session('success') }}
                </div>
            @endif

            {{-- Contenedor de Tabla con Scroll Seguro --}}
            <div style="overflow-x: auto; border: 1px solid var(--border-gray); border-radius: 4px; box-shadow: 0 1px 2px rgba(0,0,0,0.02);">
                <table style="width: 100%; border-collapse: collapse; text-align: left; min-width: 800px;">
                    <thead style="background-color: #FAFAFA;">
                        <tr>
                            <th scope="col" class="zl-font-technical" style="padding: 0.85rem 1.25rem; font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid var(--border-gray);">Orden</th>
                            <th scope="col" class="zl-font-technical" style="padding: 0.85rem 1.25rem; font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid var(--border-gray);">Referencia</th>
                            <th scope="col" class="zl-font-technical" style="padding: 0.85rem 1.25rem; font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid var(--border-gray);">Monto (BS)</th>
                            <th scope="col" class="zl-font-technical" style="padding: 0.85rem 1.25rem; font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid var(--border-gray);">Banco</th>
                            <th scope="col" class="zl-font-technical" style="padding: 0.85rem 1.25rem; font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid var(--border-gray);">Fecha</th>
                            <th scope="col" class="zl-font-technical" style="padding: 0.85rem 1.25rem; font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid var(--border-gray);">Estado</th>
                        </tr>
                    </thead>
                    <tbody style="background-color: #FFFFFF;">
                        @forelse($payments as $payment)
                            <tr style="border-bottom: 1px solid #E5E7EB; transition: background-color 0.15s;" 
                                onmouseover="this.style.backgroundColor='#F7F9F9'" 
                                onmouseout="this.style.backgroundColor='#FFFFFF'">
                                
                                {{-- ID de Orden Vinculada --}}
                                <td class="zl-font-technical" style="padding: 1rem 1.25rem; font-size: 13px; font-weight: 700; color: var(--text-link);">
                                    #{{ $payment->order_id }}
                                </td>
                                
                                {{-- Número de Referencia --}}
                                <td class="zl-font-technical" style="padding: 1rem 1.25rem; font-size: 13px; color: var(--carbon-black); font-weight: 600;">
                                    {{ $payment->reference_number }}
                                </td>
                                
                                {{-- Monto en Bolívares --}}
                                <td style="padding: 1rem 1.25rem; font-size: 14px; font-weight: 700; color: var(--midnight-blue);">
                                    Bs. {{ number_format($payment->amount_bs, 2) }}
                                </td>
                                
                                {{-- Banco Emisor --}}
                                <td style="padding: 1rem 1.25rem; font-size: 13px; color: var(--text-muted);">
                                    {{ $payment->bank_name }}
                                </td>
                                
                                {{-- Fecha del Depósito / Transferencia --}}
                                <td style="padding: 1rem 1.25rem; font-size: 13px; color: var(--text-muted);">
                                    {{ $payment->payment_date }}
                                </td>
                                
                                {{-- Celda de Estado Mapeada de Forma Inline Limpia --}}
                                <td style="padding: 1rem 1.25rem; white-space: nowrap;">
                                    @php
                                        $badgeStyle = match ($payment->status) {
                                            'pending'  => 'padding: 0.35rem 0.65rem; display: inline-flex; font-size: 10px; font-weight: 700; border-radius: 3px; text-transform: uppercase; letter-spacing: 0.5px; border: 1px solid #F5D599; background-color: #FFF8E7; color: #A66900;',
                                            'approved' => 'padding: 0.35rem 0.65rem; display: inline-flex; font-size: 10px; font-weight: 700; border-radius: 3px; text-transform: uppercase; letter-spacing: 0.5px; border: 1px solid #B4DCA1; background-color: #E7F4E4; color: var(--success-green);',
                                            'rejected' => 'padding: 0.35rem 0.65rem; display: inline-flex; font-size: 10px; font-weight: 700; border-radius: 3px; text-transform: uppercase; letter-spacing: 0.5px; border: 1px solid #F5C2B8; background-color: #FDF0ED; color: var(--error-red);',
                                            default    => 'padding: 0.35rem 0.65rem; display: inline-flex; font-size: 10px; font-weight: 700; border-radius: 3px; text-transform: uppercase; letter-spacing: 0.5px; border: 1px solid var(--border-gray); background-color: #FAFAFA; color: var(--text-muted);',
                                        };
                                        $statusLabel = match ($payment->status) {
                                            'pending'  => 'Pendiente',
                                            'approved' => 'Aprobado',
                                            'rejected' => 'Rechazado',
                                            default    => $payment->status,
                                        };
                                    @endphp
                                    <span class="zl-font-technical" style="{{ $badgeStyle }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="padding: 3rem 1.25rem; text-align: center; color: var(--text-muted); font-style: italic; font-size: 14px; background-color: #FAFAFA;">
                                    No se registran transacciones de pago notificadas bajo este perfil de cliente.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Bloque de Paginación --}}
            <div style="margin-top: 2rem;">
                {{ $payments->links() }}
            </div>

        </div>
    </div>
</x-customer-layout>