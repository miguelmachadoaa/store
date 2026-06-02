<x-customer-layout>
    <div style="background-color: var(--bg-pure-white); border: 1px solid var(--border-gray); border-radius: 4px; box-shadow: 0 1px 4px rgba(0,0,0,.08); overflow: hidden; color: var(--carbon-black);">
        
        {{-- Barra de acento superior de la marca --}}
        <div style="height: 6px; width: 100%; background-color: var(--midnight-blue);"></div>

        <div style="padding: 2rem;">
            
            {{-- Encabezado del Módulo --}}
            <div style="margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 1px solid #E5E7EB;">
                <h2 class="zl-font-display" style="font-size: 22px; font-weight: 700; color: var(--midnight-blue); margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">
                    Mis Órdenes
                </h2>
                <p class="zl-font-technical" style="font-size: 11px; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin: 0.25rem 0 0 0;">
                    Historial completo de transacciones y estados de facturación comercial
                </p>
            </div>

            {{-- Contenedor de Tabla con Scroll Seguro --}}
            <div style="overflow-x: auto; border: 1px solid var(--border-gray); border-radius: 4px; box-shadow: 0 1px 2px rgba(0,0,0,0.02);">
                <table style="width: 100%; border-collapse: collapse; text-align: left; min-width: 800px;">
                    <thead style="background-color: #FAFAFA;">
                        <tr>
                            <th scope="col" class="zl-font-technical" style="padding: 0.85rem 1.25rem; font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid var(--border-gray);">Orden</th>
                            <th scope="col" class="zl-font-technical" style="padding: 0.85rem 1.25rem; font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid var(--border-gray);">Fecha</th>
                            <th scope="col" class="zl-font-technical" style="padding: 0.85rem 1.25rem; font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid var(--border-gray);">Total (USD)</th>
                            <th scope="col" class="zl-font-technical" style="padding: 0.85rem 1.25rem; font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid var(--border-gray);">Total (BS)</th>
                            <th scope="col" class="zl-font-technical" style="padding: 0.85rem 1.25rem; font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid var(--border-gray);">Estado</th>
                            <th scope="col" class="zl-font-technical" style="padding: 0.85rem 1.25rem; font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid var(--border-gray); text-align: right;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody style="background-color: #FFFFFF;">
                        @forelse($orders as $order)
                            <tr style="border-bottom: 1px solid #E5E7EB; transition: background-color 0.15s;" 
                                onmouseover="this.style.backgroundColor='#F7F9F9'" 
                                onmouseout="this.style.backgroundColor='#FFFFFF'">
                                
                                {{-- ID de Orden --}}
                                <td class="zl-font-technical" style="padding: 1rem 1.25rem; font-size: 13px; font-weight: 700; color: var(--text-link);">
                                    #{{ $order->id }}
                                </td>
                                
                                {{-- Fecha --}}
                                <td style="padding: 1rem 1.25rem; font-size: 13px; color: var(--text-muted);">
                                    {{ $order->created_at->format('d/m/Y H:i') }}
                                </td>
                                
                                {{-- Total USD --}}
                                <td style="padding: 1rem 1.25rem; font-size: 14px; font-weight: 700; color: var(--carbon-black);">
                                    ${{ number_format($order->total, 2) }}
                                </td>
                                
                                {{-- Total BS --}}
                                <td style="padding: 1rem 1.25rem; font-size: 14px; font-weight: 700; color: var(--midnight-blue);">
                                    Bs. {{ number_format($order->total_bs, 2) }}
                                </td>
                                
                                {{-- Badge de Estado Dinámico Termo-Estabilizado --}}
                                <td style="padding: 1rem 1.25rem; whitespace: nowrap;">
                                    @php
                                        $normalizedStatus = strtolower($order->status);
                                        $badgeStyle = "padding: 0.35rem 0.65rem; display: inline-flex; font-size: 10px; font-weight: 700; border-radius: 3px; text-transform: uppercase; letter-spacing: 0.5px; border: 1px solid #F5D599; background-color: #FFF8E7; color: #A66900;"; // Pendiente / Procesando por defecto
                                        
                                        if (str_contains($normalizedStatus, 'complet') || str_contains($normalizedStatus, 'entregado') || str_contains($normalizedStatus, 'pagado')) {
                                            $badgeStyle = "padding: 0.35rem 0.65rem; display: inline-flex; font-size: 10px; font-weight: 700; border-radius: 3px; text-transform: uppercase; letter-spacing: 0.5px; border: 1px solid #B4DCA1; background-color: #E7F4E4; color: var(--success-green);";
                                        } elseif (str_contains($normalizedStatus, 'cancel') || str_contains($normalizedStatus, 'anulado') || str_contains($normalizedStatus, 'rechaz')) {
                                            $badgeStyle = "padding: 0.35rem 0.65rem; display: inline-flex; font-size: 10px; font-weight: 700; border-radius: 3px; text-transform: uppercase; letter-spacing: 0.5px; border: 1px solid #F5C2B8; background-color: #FDF0ED; color: var(--error-red);";
                                        }
                                    @endphp
                                    <span class="zl-font-technical" style="{{ $badgeStyle }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                
                                {{-- Acciones Corporativas --}}
                                <td style="padding: 1rem 1.25rem; text-align: right; font-size: 13px;">
                                    <div style="display: flex; justify-content: flex-end; align-items: center; gap: 1rem;">
                                        
                                        {{-- Enlace Factura --}}
                                        <a href="{{ route('orders.invoice', $order->id) }}" 
                                           class="zl-font-technical"
                                           style="color: var(--text-link); font-weight: 700; text-decoration: none; text-transform: uppercase; font-size: 11px; display: inline-flex; align-items: center; gap: 0.25rem;"
                                           onmouseover="this.style.textDecoration='underline'"
                                           onmouseout="this.style.textDecoration='none'">
                                            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            Factura
                                        </a>
                                        
                                        {{-- Botón Pagar Inmediato --}}
                                        @if($order->status === 'pendiente')
                                            <a href="{{ route('customer.payments.report') }}" 
                                               class="zl-font-technical"
                                               style="background-color: var(--error-red); color: #FFFFFF; padding: 0.35rem 0.75rem; border-radius: 3px; font-weight: 700; text-transform: uppercase; font-size: 11px; text-decoration: none; transition: background-color 0.2s;"
                                               onmouseover="this.style.backgroundColor='#912003';"
                                               onmouseout="this.style.backgroundColor='var(--error-red)';">
                                                Pagar
                                            </a>
                                        @endif
                                        
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="padding: 3rem 1.25rem; text-align: center; color: var(--text-muted); font-style: italic; font-size: 14px; background-color: #FAFAFA;">
                                    No se registran actividades ni órdenes de compra vinculadas a este perfil.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Sección de Paginación --}}
            <div style="margin-top: 2rem; display: flex; justify-content: middle;">
                {{ $orders->links() }}
            </div>

        </div>
    </div>
</x-customer-layout>