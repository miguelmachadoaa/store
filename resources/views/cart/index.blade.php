<x-front-layout>
    <section class="max-w-7xl mx-auto py-12 px-4 min-h-screen font-sans bg-[#0d0e12] text-gray-300 relative">
        
        {{-- Grid decorativo de fondo --}}
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#1f242e_1px,transparent_1px),linear-gradient(to_bottom,#1f242e_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)] opacity-15 pointer-events-none"></div>

        {{-- Encabezado de la Sección --}}
        <div class="mb-8 border-b border-[#262b36] pb-4 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold uppercase tracking-wider text-white [font-family:'Orbitron',sans-serif]">
                    Your Cart / Tu Carrito
                </h2>
                <p class="text-xs text-gray-500 uppercase tracking-widest font-mono mt-1">
                    System_Manifest // Allocation Allocation
                </p>
            </div>
            <div class="font-mono text-xs text-blue-500 uppercase tracking-wider hidden sm:block bg-[#14161d] border border-[#262b36] px-3 py-1.5 rounded-sm">
                Status: Operational
            </div>
        </div>

        @php
            $showUsd = $storeSettings->showUsd();
            $showBs = $storeSettings->showBs();
            $rate = \App\Models\Product::getDollarRate();
        @endphp

        {{-- Notificaciones del Sistema --}}
        @if(session('success'))
            <div class="mb-6 bg-emerald-950/40 border border-emerald-800/60 text-emerald-400 text-xs rounded-sm p-4 font-mono flex items-center gap-2">
                <span class="text-emerald-500 font-bold">[OK]</span> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-950/40 border border-red-800/60 text-red-400 text-xs rounded-sm p-4 font-mono flex items-center gap-2">
                <span class="text-red-500 font-bold">[ERR]</span> {{ session('error') }}
            </div>
        @endif

        @if(count($cart) > 0)
            {{-- Tabla / Contenedor Industrial --}}
            <div class="overflow-x-auto bg-[#14161d] border border-[#262b36] rounded-sm shadow-2xl">
                <table class="min-w-full divide-y divide-[#262b36]">
                    <thead class="bg-[#1b1e26]">
                        <tr class="font-mono text-[11px] text-gray-400 uppercase tracking-wider">
                            <th class="px-6 py-4 text-left font-bold [font-family:'Orbitron',sans-serif]">Product / Item</th>
                            <th class="px-6 py-4 text-left font-bold [font-family:'Orbitron',sans-serif]">Price / Unit</th>
                            <th class="px-6 py-4 text-left font-bold [font-family:'Orbitron',sans-serif]">Qty / Volume</th>
                            <th class="px-6 py-4 text-left font-bold [font-family:'Orbitron',sans-serif]">Total Summary</th>
                            <th class="px-6 py-4 text-right font-bold [font-family:'Orbitron',sans-serif]">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#1f242e] font-mono text-xs">
                        @php $subtotal = 0; @endphp
                        @foreach($cart as $id => $item)
                            @php $subtotal += $item['price'] * $item['quantity']; @endphp
                            <tr class="hover:bg-[#1b1e26]/40 transition duration-150">
                                {{-- Celda: Producto --}}
                                <td class="px-6 py-5">
                                    <div class="text-sm font-bold text-white uppercase tracking-wide [font-family:'Orbitron',sans-serif]">{{ $item['name'] }}</div>
                                    <span class="text-[10px] text-gray-500 font-mono block mt-0.5">REF_ID: #{{ hash('crc32', $id) }}</span>
                                </td>
                                
                                {{-- Celda: Precio Unitario --}}
                                <td class="px-6 py-5 whitespace-nowrap">
                                    @if($showUsd)
                                        <div class="text-gray-200 font-bold">${{ number_format($item['price'], 2) }}</div>
                                    @endif
                                    @if($showBs)
                                        <div class="text-[11px] text-gray-500 mt-0.5">Bs. {{ number_format($item['price'] * $rate, 2) }}</div>
                                    @endif
                                </td>
                                
                                {{-- Celda: Cantidad --}}
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        <input 
                                            type="number" 
                                            name="quantity" 
                                            value="{{ $item['quantity'] }}" 
                                            min="1"
                                            class="w-16 bg-[#1b1e26] border border-[#262b36] rounded-sm text-center py-1 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-xs font-bold"
                                        >
                                        <button class="text-blue-500 hover:text-blue-400 text-[11px] uppercase tracking-wider font-bold transition">
                                            [Sync]
                                        </button>
                                    </form>
                                </td>
                                
                                {{-- Celda: Total por Ítem --}}
                                <td class="px-6 py-5 whitespace-nowrap">
                                    @if($showUsd)
                                        <div class="text-white font-bold text-sm tracking-wide">${{ number_format($item['price'] * $item['quantity'], 2) }}</div>
                                    @endif
                                    @if($showBs)
                                        <div class="text-[11px] text-gray-400 mt-0.5">Bs. {{ number_format(($item['price'] * $item['quantity']) * $rate, 2) }}</div>
                                    @endif
                                </td>
                                
                                {{-- Celda: Remover --}}
                                <td class="px-6 py-5 text-right whitespace-nowrap">
                                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                                        @csrf
                                        <button class="text-red-500/80 hover:text-red-400 text-xs font-bold uppercase tracking-wider transition">
                                            // Wipe_Item
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        @php
                            $discount = session('coupon.discount', 0);
                            $total = $subtotal - $discount;
                        @endphp

                        {{-- Fila: Subtotal --}}
                        <tr class="bg-[#1b1e26]/30">
                            <td colspan="3" class="px-6 py-3 text-right text-gray-500 uppercase tracking-widest font-bold text-[10px]">Subtotal:</td>
                            <td class="px-6 py-3 font-bold text-gray-300 whitespace-nowrap">
                                ${{ number_format($subtotal, 2) }}
                            </td>
                            <td></td>
                        </tr>

                        {{-- Fila: Descuento --}}
                        @if($discount > 0)
                            <tr class="bg-[#1b1e26]/50 text-emerald-400">
                                <td colspan="3" class="px-6 py-3 text-right uppercase tracking-widest font-bold text-[10px]">
                                    Discount / Descuento ({{ session('coupon.code') }}):
                                    <form action="{{ route('cart.coupon.remove') }}" method="POST" class="inline ml-2">
                                        @csrf
                                        <button class="text-red-400 text-[10px] uppercase font-bold hover:underline transition">[Remove]</button>
                                    </form>
                                </td>
                                <td class="px-6 py-3 font-bold whitespace-nowrap">
                                    -${{ number_format($discount, 2) }}
                                </td>
                                <td></td>
                            </tr>
                        @endif

                        {{-- Fila: Bloque Total Final --}}
                        <tr class="bg-[#1b1e26] border-t-2 border-[#262b36]">
                            <td colspan="3" class="px-6 py-5 text-right text-white uppercase tracking-widest font-bold text-xs [font-family:'Orbitron',sans-serif]">Total Crypto_Value:</td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                @if($showUsd)
                                    <div class="text-lg font-bold text-blue-500 tracking-wider [font-family:'Orbitron',sans-serif]">${{ number_format($total, 2) }}</div>
                                @endif
                                @if($showBs)
                                    <div class="text-xs text-gray-300 font-bold mt-0.5">Bs. {{ number_format($total * $rate, 2) }}</div>
                                    <div class="text-[9px] text-gray-500 uppercase tracking-wider font-normal mt-1">
                                        Exchange_Rate: 1 USD = Bs. {{ number_format($rate, 2) }}
                                    </div>
                                @endif
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Bloque de Controles Inferiores --}}
            <div class="flex flex-col md:flex-row justify-between items-stretch md:items-start mt-8 gap-6">
                
                {{-- Formulario de Cupones --}}
                <form action="{{ route('cart.coupon.apply') }}" method="POST" class="flex items-center gap-2 w-full md:w-auto font-mono">
                    @csrf
                    <input 
                        type="text" 
                        name="code" 
                        placeholder="COUPON_CODE" 
                        required
                        class="bg-[#14161d] border border-[#262b36] rounded-sm px-4 py-2.5 w-full md:w-48 text-xs text-white placeholder-gray-600 focus:outline-none focus:border-blue-500 uppercase tracking-wider font-bold"
                    >
                    <button 
                        type="submit" 
                        class="bg-[#1b1e26] border border-[#262b36] hover:bg-[#262b36] text-white px-5 py-2.5 rounded-sm text-xs uppercase tracking-widest font-bold transition whitespace-nowrap"
                    >
                        Apply
                    </button>
                </form>

                {{-- Botón de Salida / Checkout --}}
                <div class="w-full md:w-auto text-right">
                    <a 
                        href="{{ route('checkout.index') }}"
                        class="inline-block w-full md:w-auto bg-blue-600 hover:bg-blue-500 active:bg-blue-700 text-white px-8 py-4 rounded-sm font-bold text-xs uppercase tracking-widest shadow-[0_4px_12px_rgba(37,99,235,0.15)] hover:shadow-[0_4px_20px_rgba(37,99,235,0.35)] transition duration-150 text-center [font-family:'Orbitron',sans-serif]"
                    >
                        Proceed to Checkout / Proceder al Pago →
                    </a>
                </div>
            </div>
        @else
            {{-- Estado del Terminal si está vacío --}}
            <div class="text-center py-20 bg-[#14161d] border border-[#262b36] rounded-sm font-mono">
                <span class="text-4xl block mb-4 opacity-40">∅</span>
                <p class="text-gray-400 text-xs uppercase tracking-widest font-bold">Your manifest is currently empty / Carrito Vacío</p>
                <div class="mt-6">
                    <a 
                        href="{{ route('shop.index') }}" 
                        class="inline-block border border-[#262b36] hover:border-blue-500 text-gray-500 hover:text-blue-500 px-6 py-2.5 rounded-sm text-xs uppercase tracking-wider font-bold transition [font-family:'Orbitron',sans-serif]"
                    >
                        ← Return to Shop index
                    </a>
                </div>
            </div>
        @endif
    </section>
</x-front-layout>