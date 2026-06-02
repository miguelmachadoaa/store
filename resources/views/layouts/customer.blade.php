<x-front-layout>
    {{-- ============================================================
         ZOLUM SHOP — NAVIGATION SIDEBAR LAYOUT (INLINE OPTIMIZED)
         Sistema visual independiente: Evita conflictos de compilación CSS
         ============================================================ --}}
    
    <div style="max-width: 1200px; margin: 0 auto; padding: 2rem 1rem; font-family: 'DM Sans', sans-serif; color: #0F1111;">
        
        <!-- Contenedor Flex Adaptable mediante CSS nativo para asegurar renderizado -->
        <div class="zolum-dashboard-wrapper" style="display: flex; flex-wrap: wrap; gap: 1.5rem;">
            
            {{-- SIDEBAR DE NAVEGACIÓN --}}
            <aside style="flex: 1 1 240px; max-width: 260px; min-width: 240px;">
                <div style="background-color: #FFFFFF; border: 1px solid #D5D9D9; border-radius: 4px; box-shadow: 0 1px 4px rgba(0,0,0,.08); overflow: hidden;">
                    
                    {{-- Encabezado del Menú --}}
                    <div style="background-color: #131921; padding: 0.85rem 1.25rem; border-bottom: 1px solid #232f3e;">
                        <h3 style="color: #FFFFFF; margin: 0; font-size: 11px; font-weight: 700; text-transform: uppercase; tracking: 0.1em; letter-spacing: 1px; display: flex; align-items: center; gap: 0.5rem;">
                            <span style="width: 8px; height: 8px; background-color: #FEBD69; border-radius: 50%; display: inline-block;"></span> 
                            Centro de Control
                        </h3>
                    </div>

                    {{-- Listado de Enlaces con estados condicionales Blade --}}
                    <nav style="display: flex; flex-direction: column;">
                        
                        {{-- Opción: Resumen --}}
                        @php $isActive = request()->routeIs('customer.dashboard'); @endphp
                        <a href="{{ route('customer.dashboard') }}" 
                           style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 1.25rem; font-size: 12px; font-weight: 700; text-transform: uppercase; text-decoration: none; border-bottom: 1px solid #E5E7EB; transition: background-color 0.2s;
                                  {{ $isActive ? 'background-color: #F7F9F9; color: #131921; border-left: 4px solid #FEBD69; padding-left: 1rem;' : 'color: #555555; background-color: #FFFFFF;' }}"
                           onmouseover="if(!{{ $isActive ? 'true' : 'false' }}) this.style.backgroundColor='#FAFAFA'" 
                           onmouseout="if(!{{ $isActive ? 'true' : 'false' }}) this.style.backgroundColor='#FFFFFF'">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <svg style="width: 16px; height: 16px; color: {{ $isActive ? '#131921' : '#555555' }};" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                <span>Resumen</span>
                            </div>
                            <span style="font-size: 10px; color: #B0B0B0;">&rarr;</span>
                        </a>

                        {{-- Opción: Mis Órdenes --}}
                        @php $isActive = request()->routeIs('customer.orders*'); @endphp
                        <a href="{{ route('customer.orders') }}" 
                           style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 1.25rem; font-size: 12px; font-weight: 700; text-transform: uppercase; text-decoration: none; border-bottom: 1px solid #E5E7EB; transition: background-color 0.2s;
                                  {{ $isActive ? 'background-color: #F7F9F9; color: #131921; border-left: 4px solid #FEBD69; padding-left: 1rem;' : 'color: #555555; background-color: #FFFFFF;' }}"
                           onmouseover="if(!{{ $isActive ? 'true' : 'false' }}) this.style.backgroundColor='#FAFAFA'" 
                           onmouseout="if(!{{ $isActive ? 'true' : 'false' }}) this.style.backgroundColor='#FFFFFF'">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <svg style="width: 16px; height: 16px; color: {{ $isActive ? '#131921' : '#555555' }};" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                <span>Mis Órdenes</span>
                            </div>
                            <span style="font-size: 10px; color: #B0B0B0;">&rarr;</span>
                        </a>

                        {{-- Opción: Mis Favoritos --}}
                        @php $isActive = request()->routeIs('customer.favorites'); @endphp
                        <a href="{{ route('customer.favorites') }}" 
                           style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 1.25rem; font-size: 12px; font-weight: 700; text-transform: uppercase; text-decoration: none; border-bottom: 1px solid #E5E7EB; transition: background-color 0.2s;
                                  {{ $isActive ? 'background-color: #F7F9F9; color: #131921; border-left: 4px solid #FEBD69; padding-left: 1rem;' : 'color: #555555; background-color: #FFFFFF;' }}"
                           onmouseover="if(!{{ $isActive ? 'true' : 'false' }}) this.style.backgroundColor='#FAFAFA'" 
                           onmouseout="if(!{{ $isActive ? 'true' : 'false' }}) this.style.backgroundColor='#FFFFFF'">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <svg style="width: 16px; height: 16px; color: {{ $isActive ? '#131921' : '#555555' }};" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                <span>Mis Favoritos</span>
                            </div>
                            <span style="font-size: 10px; color: #B0B0B0;">&rarr;</span>
                        </a>

                        {{-- Opción: Reportar Pago --}}
                        @php $isActive = request()->routeIs('customer.payments.report'); @endphp
                        <a href="{{ route('customer.payments.report') }}" 
                           style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 1.25rem; font-size: 12px; font-weight: 700; text-transform: uppercase; text-decoration: none; border-bottom: 1px solid #E5E7EB; transition: background-color 0.2s;
                                  {{ $isActive ? 'background-color: #F7F9F9; color: #131921; border-left: 4px solid #FEBD69; padding-left: 1rem;' : 'color: #555555; background-color: #FFFFFF;' }}"
                           onmouseover="if(!{{ $isActive ? 'true' : 'false' }}) this.style.backgroundColor='#FAFAFA'" 
                           onmouseout="if(!{{ $isActive ? 'true' : 'false' }}) this.style.backgroundColor='#FFFFFF'">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <svg style="width: 16px; height: 16px; color: {{ $isActive ? '#131921' : '#555555' }};" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Reportar Pago</span>
                            </div>
                            <span style="font-size: 10px; color: #B0B0B0;">&rarr;</span>
                        </a>

                        {{-- Opción: Mis Pagos --}}
                        @php $isActive = (request()->routeIs('customer.payments') && !request()->routeIs('customer.payments.report')); @endphp
                        <a href="{{ route('customer.payments') }}" 
                           style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 1.25rem; font-size: 12px; font-weight: 700; text-transform: uppercase; text-decoration: none; border-bottom: 1px solid #E5E7EB; transition: background-color 0.2s;
                                  {{ $isActive ? 'background-color: #F7F9F9; color: #131921; border-left: 4px solid #FEBD69; padding-left: 1rem;' : 'color: #555555; background-color: #FFFFFF;' }}"
                           onmouseover="if(!{{ $isActive ? 'true' : 'false' }}) this.style.backgroundColor='#FAFAFA'" 
                           onmouseout="if(!{{ $isActive ? 'true' : 'false' }}) this.style.backgroundColor='#FFFFFF'">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <svg style="width: 16px; height: 16px; color: {{ $isActive ? '#131921' : '#555555' }};" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Mis Pagos</span>
                            </div>
                            <span style="font-size: 10px; color: #B0B0B0;">&rarr;</span>
                        </a>

                        {{-- Opción: Mi Perfil --}}
                        @php $isActive = request()->routeIs('customer.profile'); @endphp
                        <a href="{{ route('customer.profile') }}" 
                           style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 1.25rem; font-size: 12px; font-weight: 700; text-transform: uppercase; text-decoration: none; transition: background-color 0.2s;
                                  {{ $isActive ? 'background-color: #F7F9F9; color: #131921; border-left: 4px solid #FEBD69; padding-left: 1rem;' : 'color: #555555; background-color: #FFFFFF;' }}"
                           onmouseover="if(!{{ $isActive ? 'true' : 'false' }}) this.style.backgroundColor='#FAFAFA'" 
                           onmouseout="if(!{{ $isActive ? 'true' : 'false' }}) this.style.backgroundColor='#FFFFFF'">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <svg style="width: 16px; height: 16px; color: {{ $isActive ? '#131921' : '#555555' }};" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>Mi Perfil</span>
                            </div>
                            <span style="font-size: 10px; color: #B0B0B0;">&rarr;</span>
                        </a>

                    </nav>
                </div>
                
                {{-- Bloque de soporte --}}
                <div style="margin-top: 1rem; padding: 1rem; background-color: #FAFAFA; border: 1px solid #D5D9D9; border-radius: 4px; text-align: center;">
                    <p style="margin: 0 0 0.25rem 0; font-size: 10px; font-weight: 700; color: #555555; text-transform: uppercase; letter-spacing: 0.5px;">¿Necesitas ayuda?</p>
                    <a href="mailto:hola@zolumshop.com" style="font-size: 12px; font-weight: 700; color: #007185; text-decoration: none;">
                        Soporte Zolum Shop
                    </a>
                </div>
            </aside>

            {{-- CONTENIDO DINÁMICO DEL SLOT --}}
            <main style="flex: 1 1 500px; min-width: 0;">
                {{ $slot }}
            </main>

        </div>
    </div>
</x-front-layout>