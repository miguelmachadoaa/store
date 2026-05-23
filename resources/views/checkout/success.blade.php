<x-front-layout>
    <section class="max-w-3xl mx-auto py-12 px-4 min-h-screen font-sans bg-[#0d0e12] text-gray-300 relative">
        
        {{-- Grid técnico de fondo --}}
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#1f242e_1px,transparent_1px),linear-gradient(to_bottom,#1f242e_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)] opacity-15 pointer-events-none"></div>

        {{-- Encabezado de Éxito / Terminal Status --}}
        <div class="text-center mb-10 relative z-10">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-sm bg-emerald-950/30 border border-emerald-500/30 text-emerald-400 mb-4 shadow-[0_0_20px_rgba(16,185,129,0.1)]">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold uppercase tracking-wider text-white [font-family:'Orbitron',sans-serif]">
                Order Completed / Confirmado
            </h2>
            <p class="text-xs text-gray-400 font-mono mt-2 uppercase tracking-wide">
                Thank you for your purchase, <span class="text-white font-bold">{{ $order->customer_name }}</span>.
            </p>
            <span class="text-[10px] text-gray-600 font-mono block mt-1 uppercase tracking-widest">Receipt_ID: #{{ hash('crc32', $order->id) }}</span>
        </div>

        {{-- Contenedor del Manifiesto / Recibo --}}
        <div class="bg-[#14161d] border border-[#262b36] rounded-sm p-6 shadow-2xl relative z-10">
            
            <h3 class="text-[10px] font-mono font-bold text-gray-400 uppercase tracking-widest mb-4 pb-3 border-b border-[#262b36] flex items-center justify-between">
                <span>Settlement Summary / Datos de Facturación</span>
                <span class="text-emerald-400">[COMMITTED]</span>
            </h3>

            {{-- Ítems del Pedido --}}
            <ul class="divide-y divide-[#1f242e] font-mono text-xs mb-6">
                @foreach($order->items as $item)
                    <li class="flex justify-between items-start py-4">
                        <div class="flex flex-col pr-4">
                            <span class="text-sm font-bold text-white uppercase tracking-wide [font-family:'Orbitron',sans-serif]">
                                {{ $item->name }}
                            </span>
                            <span class="text-[10px] text-gray-500 mt-1">ALLOC_QTY: x{{ $item->quantity }}</span>
                            @if($item->total_bs)
                                <span class="text-[11px] text-gray-400 mt-0.5">
                                    Bs. {{ number_format($item->total_bs, 2) }}
                                </span>
                            @endif
                        </div>
                        <div class="flex flex-col text-right whitespace-nowrap">
                            <span class="text-sm font-bold text-gray-200">${{ number_format($item->price * $item->quantity, 2) }}</span>
                        </div>
                    </li>
                @endforeach
            </ul>

            {{-- Bloque de Cálculos Impositivos y Totales --}}
            <div class="text-right mt-4 flex flex-col items-end font-mono text-xs space-y-1.5 border-t border-[#262b36] pt-4">
                @if($order->taxable_base)
                    <div class="text-gray-500 uppercase tracking-wider">
                        Taxable_Base / Base Imp: <span class="text-gray-300 font-bold">${{ number_format($order->taxable_base, 2) }}</span>
                    </div>
                    <div class="text-gray-500 uppercase tracking-wider pb-2">
                        Tax_Amount / IVA (16%): <span class="text-gray-300 font-bold">${{ number_format($order->tax_amount, 2) }}</span>
                    </div>
                @endif
                
                {{-- Fila Total USD --}}
                <div class="text-xs font-bold text-white uppercase tracking-widest pt-2 [font-family:'Orbitron',sans-serif]">
                    Total Ledger Base:
                </div>
                <div class="text-xl font-bold text-blue-500 tracking-wider [font-family:'Orbitron',sans-serif] pb-1">
                    ${{ number_format($order->total, 2) }}
                </div>
                
                {{-- Fila Total Bolívares --}}
                @if($order->total_bs)
                    <div class="text-[10px] text-gray-500 uppercase tracking-widest font-bold pt-1">
                        Sovereign_Exchange Total:
                    </div>
                    <div class="text-sm text-gray-300 font-bold tracking-wide">
                        Bs. {{ number_format($order->total_bs, 2) }}
                    </div>
                @endif
            </div>
        </div>

        {{-- Zona de Controles y Descargas --}}
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4 relative z-10">
            
            {{-- Botón Descargar Factura (PDF) --}}
            <a href="{{ route('orders.invoice', $order->id) }}"
                class="w-full sm:w-auto bg-[#1b1e26] border border-[#262b36] hover:bg-[#262b36] text-white px-6 py-3.5 rounded-sm font-bold text-xs uppercase tracking-widest flex items-center justify-center gap-2 transition duration-150 [font-family:'Orbitron',sans-serif]">
                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Download_Invoice / Factura PDF
            </a>

            {{-- Botón Regresar al Inicio --}}
            <a href="{{ route('home') }}"
                class="w-full sm:w-auto bg-blue-600 hover:bg-blue-500 text-white px-6 py-3.5 rounded-sm font-bold text-xs uppercase tracking-widest text-center shadow-[0_4px_12px_rgba(37,99,235,0.15)] transition duration-150 [font-family:'Orbitron',sans-serif]">
                Return_Home / Inicio
            </a>
        </div>

    </section>
</x-front-layout>