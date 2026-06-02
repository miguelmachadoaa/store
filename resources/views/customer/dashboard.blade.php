<x-front-layout>
    {{-- ============================================================
         ZOLUM SHOP — CUSTOMER DASHBOARD INTEGRATED SYSTEM
         Arquitectura Flex Inline Independiente para Evitar Parálisis de Tailwind
         ============================================================ --}}
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@400;600;700&family=DM+Sans:wght@400;500;700&family=Orbitron:wght@700;800;900&display=swap" rel="stylesheet">

    <style>
        /* Sincronización de variables del Brandbook Global de Zolum */
        :root {
            --bg-pure-white:       #FFFFFF;
            --midnight-blue:       #131921;
            --midnight-light:      #1A2536;
            --warm-orange:         #FEBD69;
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
        }

        .zl-font-display { font-family: var(--font-display); }
        .zl-font-technical { font-family: var(--font-technical); }
        .zl-font-sans { font-family: var(--font-sans); }
    </style>

    <div style="max-width: 1240px; margin: 0 auto; padding: 2rem 1rem; font-family: var(--font-sans); color: var(--carbon-black);">
        
        {{-- Contenedor Estructural de Doble Columna --}}
        <div class="zolum-dashboard-layout-wrapper" style="display: flex; flex-wrap: wrap; gap: 1.5rem; align-items: flex-start;">
            
            {{-- ============================================================
                 1. SIDEBAR DE NAVEGACIÓN (Centro de Control)
                 ============================================================ --}}
            <aside style="flex: 1 1 240px; max-width: 260px; min-width: 240px;">
                <div style="background-color: var(--bg-pure-white); border: 1px solid var(--border-gray); border-radius: 4px; box-shadow: 0 1px 4px rgba(0,0,0,.08); overflow: hidden;">
                    
                    {{-- Encabezado del Menú --}}
                    <div style="background-color: var(--midnight-blue); padding: 0.85rem 1.25rem; border-bottom: 1px solid #232f3e;">
                        <h3 class="zl-font-technical" style="color: #FFFFFF; margin: 0; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; display: flex; align-items: center; gap: 0.5rem;">
                            <span style="width: 8px; height: 8px; background-color: var(--warm-orange); border-radius: 50%; display: inline-block;"></span> 
                            Centro de Control
                        </h3>
                    </div>

                    {{-- Listado de Enlaces Activos --}}
                    <nav style="display: flex; flex-direction: column;">
                        
                        {{-- Opción: Resumen (Activa en esta vista) --}}
                        @php $isActive = request()->routeIs('customer.dashboard'); @endphp
                        <a href="{{ route('customer.dashboard') }}" 
                           style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 1.25rem; font-size: 11px; font-weight: 700; text-transform: uppercase; text-decoration: none; border-bottom: 1px solid #E5E7EB; transition: all 0.2s;
                                  {{ $isActive ? 'background-color: #F7F9F9; color: var(--midnight-blue); border-left: 4px solid var(--warm-orange); padding-left: 1rem;' : 'color: var(--text-muted); background-color: var(--bg-pure-white);' }}"
                           class="zl-font-technical">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                <span>Resumen</span>
                            </div>
                            <span style="font-size: 10px; color: #B0B0B0;">&rarr;</span>
                        </a>

                        {{-- Opción: Mis Órdenes --}}
                        @php $isActive = request()->routeIs('customer.orders*'); @endphp
                        <a href="{{ route('customer.orders') }}" 
                           style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 1.25rem; font-size: 11px; font-weight: 700; text-transform: uppercase; text-decoration: none; border-bottom: 1px solid #E5E7EB; transition: all 0.2s; color: var(--text-muted); background-color: var(--bg-pure-white);"
                           class="zl-font-technical"
                           onmouseover="this.style.backgroundColor='#F7F9F9'; this.style.color='var(--midnight-blue)';" 
                           onmouseout="this.style.backgroundColor='var(--bg-pure-white)'; this.style.color='var(--text-muted)';">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                <span>Mis Órdenes</span>
                            </div>
                            <span style="font-size: 10px; color: #B0B0B0;">&rarr;</span>
                        </a>

                        {{-- Opción: Reportar Pago --}}
                        @php $isActive = request()->routeIs('customer.payments.report'); @endphp
                        <a href="{{ route('customer.payments.report') }}" 
                           style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 1.25rem; font-size: 11px; font-weight: 700; text-transform: uppercase; text-decoration: none; border-bottom: 1px solid #E5E7EB; transition: all 0.2s; color: var(--text-muted); background-color: var(--bg-pure-white);"
                           class="zl-font-technical"
                           onmouseover="this.style.backgroundColor='#F7F9F9'; this.style.color='var(--midnight-blue)';" 
                           onmouseout="this.style.backgroundColor='var(--bg-pure-white)'; this.style.color='var(--text-muted)';">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Reportar Pago</span>
                            </div>
                            <span style="font-size: 10px; color: #B0B0B0;">&rarr;</span>
                        </a>

                        {{-- Opción: Historial de Pagos --}}
                        @php $isActive = (request()->routeIs('customer.payments') && !request()->routeIs('customer.payments.report')); @endphp
                        <a href="{{ route('customer.payments') }}" 
                           style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 1.25rem; font-size: 11px; font-weight: 700; text-transform: uppercase; text-decoration: none; border-bottom: 1px solid #E5E7EB; transition: all 0.2s; color: var(--text-muted); background-color: var(--bg-pure-white);"
                           class="zl-font-technical"
                           onmouseover="this.style.backgroundColor='#F7F9F9'; this.style.color='var(--midnight-blue)';" 
                           onmouseout="this.style.backgroundColor='var(--bg-pure-white)'; this.style.color='var(--text-muted)';">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Mis Pagos</span>
                            </div>
                            <span style="font-size: 10px; color: #B0B0B0;">&rarr;</span>
                        </a>

                        {{-- Opción: Mi Perfil --}}
                        @php $isActive = request()->routeIs('customer.profile'); @endphp
                        <a href="{{ route('customer.profile') }}" 
                           style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 1.25rem; font-size: 11px; font-weight: 700; text-transform: uppercase; text-decoration: none; transition: all 0.2s; color: var(--text-muted); background-color: var(--bg-pure-white);"
                           class="zl-font-technical"
                           onmouseover="this.style.backgroundColor='#F7F9F9'; this.style.color='var(--midnight-blue)';" 
                           onmouseout="this.style.backgroundColor='var(--bg-pure-white)'; this.style.color='var(--text-muted)';">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>Mi Perfil</span>
                            </div>
                            <span style="font-size: 10px; color: #B0B0B0;">&rarr;</span>
                        </a>
                    </nav>
                </div>
                
                {{-- Bloque Informativo Corto --}}
                <div style="margin-top: 1rem; padding: 1rem; background-color: #FAFAFA; border: 1px solid var(--border-gray); border-radius: 4px; text-align: center;">
                    <p class="zl-font-technical" style="margin: 0 0 0.25rem 0; font-size: 10px; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">¿Soporte Inmediato?</p>
                    <a href="mailto:hola@zolumshop.com" style="font-size: 12px; font-weight: 700; color: var(--text-link); text-decoration: none; hover:underline;">
                        hola@zolumshop.com
                    </a>
                </div>
            </aside>

            {{-- ============================================================
                 2. CONTENIDO PRINCIPAL DEL PANEL (Blindado con Estilos Inline)
                 ============================================================ --}}
            <main style="flex: 1 1 500px; min-width: 0;">
                <div style="background-color: var(--bg-pure-white); border: 1px solid var(--border-gray); border-radius: 4px; box-shadow: 0 1px 4px rgba(0,0,0,.08); overflow: hidden; color: var(--carbon-black);">
                    
                    {{-- Barra de acento superior de la marca --}}
                    <div style="height: 6px; width: 100%; background-color: var(--midnight-blue);"></div>

                    <div style="padding: 2rem;">
                        
                        {{-- Sección de Bienvenida --}}
                        <div style="margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 1px solid #E5E7EB;">
                            <h1 class="zl-font-display" style="font-size: 24px; font-weight: 700; color: var(--midnight-blue); margin: 0 0 0.25rem 0; letter-spacing: 0.5px; text-transform: uppercase;">
                                Bienvenido, {{ $user->name }}
                            </h1>
                            <p class="zl-font-technical" style="color: var(--text-muted); font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                                <span style="display: inline-block; width: 8px; height: 8px; background-color: var(--success-green); border-radius: 50%;"></span> 
                                Panel de Cliente Activo — Gestión de cuenta corporativa
                            </p>
                            <p style="color: var(--text-muted); font-size: 14px; margin: 0.75rem 0 0 0; line-height: 1.6; max-width: 48rem;">
                                Desde tu panel de control puedes supervisar de forma centralizada tus compras recientes, gestionar y validar tus reportes de pago pendientes, y actualizar la información de tu perfil de usuario.
                            </p>
                        </div>

                        {{-- Grid de Estadísticas de la Cuenta (Flexbox Responsivo Nativo) --}}
                        <div style="display: flex; flex-wrap: wrap; gap: 1.25rem; margin-bottom: 2rem;">
                            
                            {{-- Stat: Total Órdenes --}}
                            <div style="flex: 1 1 220px; background-color: #FAFAFA; border: 1px solid var(--border-gray); border-radius: 4px; padding: 1.25rem; display: flex; align-items: center; gap: 1rem;">
                                <div style="padding: 0.75rem; background-color: var(--midnight-blue); color: var(--warm-orange); border-radius: 4px; border: 1px solid #232f3e; display: flex; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="zl-font-display" style="font-size: 24px; font-weight: 700; color: var(--midnight-blue); line-height: 1;">{{ $ordersCount }}</div>
                                    <div class="zl-font-technical" style="font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; tracking-wider; margin-top: 0.25rem;">Total de Órdenes</div>
                                </div>
                            </div>

                            {{-- Stat: Pagos Reportados --}}
                            <div style="flex: 1 1 220px; background-color: #FAFAFA; border: 1px solid var(--border-gray); border-radius: 4px; padding: 1.25rem; display: flex; align-items: center; gap: 1rem;">
                                <div style="padding: 0.75rem; background-color: var(--midnight-blue); color: var(--warm-orange); border-radius: 4px; border: 1px solid #232f3e; display: flex; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="zl-font-display" style="font-size: 24px; font-weight: 700; color: var(--midnight-blue); line-height: 1;">{{ $paymentsCount }}</div>
                                    <div class="zl-font-technical" style="font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; tracking-wider; margin-top: 0.25rem;">Pagos Reportados</div>
                                </div>
                            </div>

                            {{-- Stat: Estado de Cuenta --}}
                            <div style="flex: 1 1 220px; background-color: #E7F4E4; border: 1px solid #B4DCA1; border-radius: 4px; padding: 1.25rem; display: flex; align-items: center; gap: 1rem;">
                                <div style="padding: 0.75rem; background-color: var(--success-green); color: #FFFFFF; border-radius: 4px; display: flex; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="zl-font-display" style="font-size: 20px; font-weight: 700; color: var(--success-green); text-transform: uppercase; line-height: 1;">Activo</div>
                                    <div class="zl-font-technical" style="font-size: 11px; font-weight: 700; color: var(--success-green); text-transform: uppercase; tracking-wider; margin-top: 0.25rem;">Estado de Cuenta</div>
                                </div>
                            </div>
                            
                        </div>

                        {{-- Encabezado de la Tabla --}}
                        <div style="margin-bottom: 1rem; display: flex; flex-direction: column; gap: 0.5rem;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 0.5rem;">
                                <div>
                                    <h2 class="zl-font-display" style="font-size: 18px; font-weight: 700; color: var(--midnight-blue); margin: 0; text-transform: uppercase;">
                                        Órdenes Recientes
                                    </h2>
                                    <p class="zl-font-technical" style="font-size: 11px; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin: 0.15rem 0 0 0;">
                                        Últimas transacciones comerciales registradas
                                    </p>
                                </div>
                                <a href="{{ route('customer.orders') }}" style="color: var(--text-link); font-size: 12px; font-weight: 700; text-decoration: none; text-transform: uppercase;" class="zl-font-technical">
                                    Ver todas las órdenes &rarr;
                                </a>
                            </div>
                        </div>

                        {{-- Contenedor de la Tabla Estilo Zolum --}}
                        <div style="overflow-x: auto; border: 1px solid var(--border-gray); border-radius: 4px; box-shadow: 0 1px 2px rgba(0,0,0,0.02);">
                            <table style="width: 100%; border-collapse: collapse; text-align: left; min-width: 600px;">
                                <thead style="background-color: #FAFAFA;">
                                    <tr>
                                        <th scope="col" class="zl-font-technical" style="padding: 0.75rem 1.25rem; font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid var(--border-gray);">
                                            Identificador
                                        </th>
                                        <th scope="col" class="zl-font-technical" style="padding: 0.75rem 1.25rem; font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid var(--border-gray);">
                                            Fecha de Emisión
                                        </th>
                                        <th scope="col" class="zl-font-technical" style="padding: 0.75rem 1.25rem; font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid var(--border-gray);">
                                            Total General
                                        </th>
                                        <th scope="col" class="zl-font-technical" style="padding: 0.75rem 1.25rem; font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid var(--border-gray);">
                                            Estado del Flujo
                                        </th>
                                    </tr>
                                </thead>
                                <tbody style="background-color: #FFFFFF;">
                                    @forelse($recentOrders as $order)
                                        <tr style="border-bottom: 1px solid #E5E7EB;" onmouseover="this.style.backgroundColor='#F7F9F9'" onmouseout="this.style.backgroundColor='#FFFFFF'">
                                            <td class="zl-font-technical" style="padding: 1rem 1.25rem; font-size: 12px; font-weight: 700; color: var(--text-link);">
                                                #{{ $order->id }}
                                            </td>
                                            <td style="padding: 1rem 1.25rem; font-size: 14px; color: var(--text-muted);">
                                                {{ $order->created_at->format('d/m/Y') }}
                                            </td>
                                            <td style="padding: 1rem 1.25rem; font-size: 14px; color: var(--carbon-black); font-weight: 700;">
                                                Bs. {{ number_format($order->total_bs, 2) }}
                                            </td>
                                            <td style="padding: 1rem 1.25rem;">
                                                {{-- Rescate inline automático de estados comerciales si tu backend usa clases dinámicas --}}
                                                @php
                                                    $fallbackBadge = "padding: 0.25rem 0.6rem; display: inline-flex; font-size: 10px; font-weight: 700; border-radius: 3px; text-transform: uppercase; letter-spacing: 0.5px; border: 1px solid #F5D599; background-color: #FFF8E7; color: #A66900;";
                                                    
                                                    if(str_contains(strtolower($order->status), 'complet') || str_contains(strtolower($order->status), 'entregado')) {
                                                        $fallbackBadge = "padding: 0.25rem 0.6rem; display: inline-flex; font-size: 10px; font-weight: 700; border-radius: 3px; text-transform: uppercase; letter-spacing: 0.5px; border: 1px solid #B4DCA1; background-color: #E7F4E4; color: #007600;";
                                                    }
                                                    if(str_contains(strtolower($order->status), 'cancel') || str_contains(strtolower($order->status), 'anulado') || str_contains(strtolower($order->status), 'rechaz')) {
                                                        $fallbackBadge = "padding: 0.25rem 0.6rem; display: inline-flex; font-size: 10px; font-weight: 700; border-radius: 3px; text-transform: uppercase; letter-spacing: 0.5px; border: 1px solid #F5C2B8; background-color: #FDF0ED; color: #B12704;";
                                                    }
                                                @endphp
                                                <span class="zl-font-technical" style="{{ $fallbackBadge }}">
                                                    {{ $order->status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" style="padding: 2rem; text-align: center; font-size: 14px; color: var(--text-muted); background-color: #FAFAFA; font-style: italic;">
                                                No se registran actividades comerciales ni compras vinculadas a esta cuenta en la actualidad.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Nota al pie informativa --}}
                        <div style="margin-top: 1.5rem; text-align: right;">
                            <p class="zl-font-technical" style="margin: 0; font-size: 10px; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">
                                Zolum Commerce Enterprise Engine System v3.2.6
                            </p>
                        </div>

                    </div>
                </div>
            </main>

        </div>
    </div>
</x-front-layout>