<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detalle del Carrito #{{ $cart->id }}
            </h2>
            <a href="{{ route('admin.carts.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded text-sm transition">
                &larr; Volver al Listado
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                {{-- Bloque Izquierdo: Desglose de Productos --}}
                <div class="md:col-span-2 space-y-6">
                    <div class="bg-white shadow-xl sm:rounded-xl border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                            <h3 class="font-bold text-gray-800 text-sm uppercase tracking-wider">Artículos en el Carrito</h3>
                        </div>
                        <div class="divide-y divide-gray-200">
                            @foreach($cart->items as $item)
                                <div class="p-6 flex items-center justify-between hover:bg-gray-50 transition">
                                    <div class="flex items-center space-x-4">
                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold text-indigo-600 truncate">
                                                {{ $item->product->name ?? 'Producto Eliminado' }}
                                            </p>
                                            <p class="text-xs text-gray-500">ID Producto: {{ $item->product_id }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $item->quantity }} x ${{ number_format($item->product->price ?? 0, 2) }}
                                        </p>
                                        <p class="text-sm font-bold text-gray-950">
                                            Subtotal: ${{ number_format(($item->product->price ?? 0) * $item->quantity, 2) }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        {{-- Pie de totalizador --}}
                        <div class="p-6 bg-gray-50 border-t border-gray-200 flex justify-between items-center font-bold text-lg text-gray-900">
                            <span>Monto Total Abandonado:</span>
                            <span class="text-xl text-emerald-600">${{ number_format($cart->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                {{-- Bloque Derecho: Información de Cliente / Metadata --}}
                <div class="space-y-6">
                    <div class="bg-white shadow-xl sm:rounded-xl border border-gray-200 p-6">
                        <h3 class="font-bold text-gray-800 text-sm uppercase tracking-wider mb-4 border-b pb-2">Información de Vinculación</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <span class="block text-xs font-semibold text-gray-400 uppercase">Propietario</span>
                                @if($cart->user)
                                    <p class="text-sm font-bold text-gray-900 mt-0.5">{{ $cart->user->name }}</p>
                                    <p class="text-xs text-indigo-600 break-all">{{ $cart->user->email }}</p>
                                @else
                                    <p class="text-sm text-gray-500 italic mt-0.5">Usuario Anónimo</p>
                                @endif
                            </div>

                            <div>
                                <span class="block text-xs font-semibold text-gray-400 uppercase">ID de Sesión PHP/Laravel</span>
                                <p class="text-xs font-mono text-gray-600 bg-gray-50 p-2 rounded border border-gray-100 mt-1 break-all select-all">
                                    {{ $cart->session_id }}
                                </p>
                            </div>

                            <div>
                                <span class="block text-xs font-semibold text-gray-400 uppercase">Creado el</span>
                                <p class="text-sm text-gray-800 mt-0.5">{{ $cart->created_at->format('d/m/Y à las H:i:s') }}</p>
                            </div>

                            <div>
                                <span class="block text-xs font-semibold text-gray-400 uppercase">Última Modificación</span>
                                <p class="text-sm text-gray-800 mt-0.5">{{ $cart->updated_at->format('d/m/Y à las H:i:s') }}</p>
                                <p class="text-xs text-amber-600 font-medium mt-0.5">({{ $cart->updated_at->diffForHumans() }})</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>