<x-front-layout>
    <section class="max-w-7xl mx-auto py-12 px-4 min-h-screen font-sans bg-[#0d0e12] text-gray-300 relative">
        
        {{-- Grid técnico de fondo --}}
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#1f242e_1px,transparent_1px),linear-gradient(to_bottom,#1f242e_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)] opacity-15 pointer-events-none"></div>

        {{-- Título de la Sección --}}
        <div class="mb-8 border-b border-[#262b36] pb-4">
            <h2 class="text-xl font-bold uppercase tracking-wider text-white [font-family:'Orbitron',sans-serif]">
                Finalizar pedido / Checkout
            </h2>
            <p class="text-xs text-gray-500 uppercase tracking-widest font-mono mt-1">
                Transaction_Gateway // Gateway Securisation
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            {{-- COLUMNA IZQUIERDA: Resumen del Pedido (4 Columnas de 12) --}}
            <div class="lg:col-span-5 bg-[#14161d] border border-[#262b36] rounded-sm p-6 shadow-2xl relative">
                
                <h3 class="text-[10px] font-mono font-bold text-gray-400 uppercase tracking-widest mb-4 pb-3 border-b border-[#262b36] flex items-center justify-between">
                    <span>Order_Summary / Resumen</span>
                    <span class="text-blue-500">[Review]</span>
                </h3>

                @php
                    $subtotal = 0;
                    $rate = \App\Models\Product::getDollarRate();
                    $showBs = $storeSettings->showBs();
                @endphp

                {{-- Lista de Productos --}}
                <ul class="divide-y divide-[#1f242e] font-mono text-xs">
                    @foreach ($cart as $id => $item)
                        @php $subtotal += $item['price'] * $item['quantity']; @endphp
                        <li class="flex justify-between items-start py-3.5">
                            <div class="pr-4">
                                <p class="text-sm font-bold text-white uppercase tracking-wide [font-family:'Orbitron',sans-serif]">{{ $item['name'] }}</p>
                                <p class="text-[10px] text-gray-500 mt-1">VOL_ALLOCATION: x{{ $item['quantity'] }}</p>
                            </div>
                            <div class="text-right whitespace-nowrap">
                                <p class="text-sm font-bold text-gray-200">${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                                @if ($showBs)
                                    <p class="text-[11px] text-gray-500 mt-0.5">
                                        Bs. {{ number_format($item['price'] * $item['quantity'] * $rate, 2) }}
                                    </p>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>

                @php
                    $discount = session('coupon.discount', 0);
                    $total = $subtotal - $discount;
                @endphp

                {{-- Desglose de Precios Subtotal/Descuento --}}
                <div class="mt-4 pt-4 border-t border-[#262b36] space-y-2 font-mono text-xs">
                    <div class="flex justify-between text-gray-500 uppercase tracking-wider">
                        <span>Subtotal_Net</span>
                        <span class="font-bold text-gray-300">${{ number_format($subtotal, 2) }}</span>
                    </div>

                    @if ($discount > 0)
                        <div class="flex justify-between text-emerald-400 uppercase tracking-wider bg-emerald-950/20 border border-emerald-900/40 p-2 rounded-sm">
                            <span class="flex items-center gap-1 font-bold">
                                Token_Disc ({{ session('coupon.code') }})
                                <form action="{{ route('cart.coupon.remove') }}" method="POST" class="inline">
                                    @php echo csrf_field(); @endphp
                                    <button class="text-red-400 text-[10px] uppercase hover:underline ml-1 font-bold">[Wipe]</button>
                                </form>
                            </span>
                            <span class="font-bold">-${{ number_format($discount, 2) }}</span>
                        </div>
                    @endif
                </div>

                {{-- Bloque de Total --}}
                <div class="flex justify-between items-end mt-4 pt-4 border-t-2 border-[#262b36] bg-[#1b1e26]/40 p-4 rounded-sm">
                    <span class="text-xs font-bold text-white uppercase tracking-widest [font-family:'Orbitron',sans-serif]">Total Payable:</span>
                    <div class="text-right font-mono">
                        <p class="text-xl font-bold text-blue-500 tracking-wider [font-family:'Orbitron',sans-serif]">${{ number_format($total, 2) }}</p>
                        @if ($showBs)
                            <p class="text-xs text-gray-400 font-bold mt-0.5">Bs. {{ number_format($total * $rate, 2) }}</p>
                            <p class="text-[9px] text-gray-500 uppercase tracking-widest mt-1">Rate: Bs. {{ number_format($rate, 2) }}</p>
                        @endif
                    </div>
                </div>

                {{-- Bloque de Cupones Integrado --}}
                <div class="mt-6 pt-5 border-t border-[#262b36] font-mono">
                    @if (session('success'))
                        <p class="text-[11px] text-emerald-400 bg-emerald-950/20 border border-emerald-900/30 px-3 py-1.5 rounded-sm mb-3">[OK] {{ session('success') }}</p>
                    @endif
                    @if (session('error'))
                        <p class="text-[11px] text-red-400 bg-red-950/20 border border-red-900/30 px-3 py-1.5 rounded-sm mb-3">[ERR] {{ session('error') }}</p>
                    @endif
                    <p class="text-[10px] text-gray-500 uppercase tracking-widest font-bold mb-2">Voucher_Token / Cupón</p>
                    <form action="{{ route('cart.coupon.apply') }}" method="POST" class="flex gap-2">
                        @csrf
                        <input type="text" name="code" placeholder="PROMO_CODE" uppercase required
                            class="flex-1 text-xs bg-[#1b1e26] border border-[#262b36] rounded-sm px-3 py-2.5 text-white placeholder-gray-600 focus:outline-none focus:border-blue-500 uppercase font-bold tracking-wider">
                        <button type="submit"
                            class="text-xs px-4 py-2.5 bg-[#1b1e26] border border-[#262b36] hover:bg-[#262b36] text-white rounded-sm font-bold uppercase tracking-wider transition">
                            Apply
                        </button>
                    </form>
                </div>
            </div>

            {{-- COLUMNA DERECHA: Formulario de Envío y Pago (7 Columnas de 12) --}}
            <div class="lg:col-span-7 bg-[#14161d] border border-[#262b36] rounded-sm p-6 shadow-2xl">
                
                <h3 class="text-[10px] font-mono font-bold text-gray-400 uppercase tracking-widest mb-6 pb-3 border-b border-[#262b36] flex items-center justify-between">
                    <span>Shipping & Settlement / Envío y Pago</span>
                    <span class="text-blue-500">[Required]</span>
                </h3>

                <form action="{{ route('checkout.process') }}" method="POST" class="font-mono text-xs">
                    @csrf

                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-4 flex items-center gap-1">
                        <span class="text-blue-500">■</span> Identity credentials
                    </p>

                    <div class="mb-4">
                        <label class="block text-gray-500 uppercase tracking-wider mb-1 text-[11px]">Client Name / Nombre</label>
                        <input type="text" value="{{ $user->name }}" readonly
                            class="w-full bg-[#1b1e26]/50 border border-[#262b36] rounded-sm p-2.5 text-xs text-gray-500 uppercase tracking-wide cursor-not-allowed outline-none">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-500 uppercase tracking-wider mb-1 text-[11px]">Gateway Mail / Correo</label>
                        <input type="email" value="{{ $user->email }}" readonly
                            class="w-full bg-[#1b1e26]/50 border border-[#262b36] rounded-sm p-2.5 text-xs text-gray-500 cursor-not-allowed outline-none">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-400 uppercase tracking-wider mb-1 text-[11px]">C.I. / RIF</label>
                            <input type="text" name="rif" value="{{ old('rif', $user->rif) }}" required
                                placeholder="V-12345678-0"
                                class="w-full bg-[#1b1e26] text-white border rounded-sm p-2.5 text-xs focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 uppercase font-bold tracking-wider @error('rif') border-red-500/80 @else border-[#262b36] @enderror">
                            @error('rif')
                                <p class="text-red-400 text-[10px] mt-1 font-bold uppercase">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-gray-400 uppercase tracking-wider mb-1 text-[11px]">Telecom / Teléfono</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required
                                placeholder="0414-0000000"
                                class="w-full bg-[#1b1e26] text-white border rounded-sm p-2.5 text-xs focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 font-bold tracking-wider @error('phone') border-red-500/80 @else border-[#262b36] @enderror">
                            @error('phone')
                                <p class="text-red-400 text-[10px] mt-1 font-bold uppercase">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-400 uppercase tracking-wider mb-1 text-[11px]">Physical Endpoint Address / Dirección de envío</label>
                        <textarea name="address" rows="3" required placeholder="CALLE, CIUDAD, ESTADO, CÓDIGO POSTAL..."
                            class="w-full bg-[#1b1e26] text-white border rounded-sm p-2.5 text-xs focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 uppercase tracking-wide resize-none h-20 @error('address') border-red-500/80 @else border-[#262b36] @enderror">{{ old('address', $user->address) }}</textarea>
                        @error('address')
                            <p class="text-red-400 text-[10px] mt-1 font-bold uppercase">{{ $message }}</p>
                        @enderror
                    </div>

                    <hr class="border-[#262b36] mb-5">

                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-4 flex items-center gap-1">
                        <span class="text-blue-500">■</span> Settlement_Method / Canal de pago
                    </p>

                    {{-- Selectores de Método de Pago Industriales --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-8">
                        @foreach (['card' => 'CREDIT_CARD', 'paypal' => 'PAYPAL_NODE', 'transfer' => 'BANK_XFER'] as $value => $label)
                            <label class="cursor-pointer">
                                <input type="radio" name="payment" value="{{ $value }}" class="sr-only peer"
                                    {{ old('payment', 'card') === $value ? 'checked' : '' }}>
                                <div class="text-center font-bold text-xs py-3 border border-[#262b36] rounded-sm bg-[#1b1e26]/40
                                    peer-checked:border-blue-500 peer-checked:text-white peer-checked:bg-blue-600/10
                                    text-gray-500 hover:border-gray-600 transition uppercase tracking-widest [font-family:'Orbitron',sans-serif]">
                                    {{ $label }}
                                </div>
                            </label>
                        @endforeach
                    </div>

                    {{-- Botón de Acción --}}
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-500 active:bg-blue-700 text-white font-bold py-4 px-4 rounded-sm transition duration-150 text-xs tracking-widest uppercase shadow-[0_4px_12px_rgba(37,99,235,0.15)] hover:shadow-[0_4px_20px_rgba(37,99,235,0.35)] [font-family:'Orbitron',sans-serif]">
                        Commit Transaction / Confirmar Pedido →
                    </button>

                    {{-- Pie de Seguridad --}}
                    <p class="text-center text-[10px] text-gray-600 mt-4 flex items-center justify-center gap-1.5 uppercase tracking-wider font-mono">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        SSL_Layer: Secured and Encrypted Pipeline
                    </p>
                </form>
            </div>

        </div>
    </section>
</x-front-layout>