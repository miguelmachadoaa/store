<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Carritos Abandonados') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- FICHAS ANALÍTICAS RÁPIDAS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100 flex items-center">
                    <div class="p-3 rounded-full bg-amber-50 text-amber-600 mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Carritos Abandonados</p>
                        <p class="text-3xl font-bold text-gray-950">{{ number_format($cards['total_abandoned']) }}</p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100 flex items-center">
                    <div class="p-3 rounded-full bg-emerald-50 text-emerald-600 mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Capital Recuperable Estimado</p>
                        <p class="text-3xl font-bold text-emerald-600">${{ number_format($cards['total_value'], 2) }}</p>
                    </div>
                </div>
            </div>

            {{-- BUSCADOR --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.carts.index') }}" class="flex flex-wrap items-end gap-4">
                        <div class="flex-1 min-w-[300px]">
                            <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Buscar por Cliente, Email o ID Sesión</label>
                            <input type="text" name="search" value="{{ request('search') }}"
                                   placeholder="Ej: Juan Pérez, info@correo.com, etc..."
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-sm h-[42px]">
                                Buscar
                            </button>
                            <a href="{{ route('admin.carts.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded text-sm h-[42px] flex items-center">
                                Limpiar
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- TABLA DE REGISTROS --}}
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-200">
                <div class="p-6">
                    @if($carts->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario / Sesión</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Artículos</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total Estimado</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Última Actividad</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($carts as $cart)
                                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                            {{-- Identidad --}}
                                            <td class="px-6 py-4">
                                                @if($cart->user)
                                                    <div class="text-sm font-semibold text-gray-900">{{ $cart->user->name }}</div>
                                                    <div class="text-xs text-indigo-600">{{ $cart->user->email }}</div>
                                                @else
                                                    <div class="text-sm font-medium text-gray-500 italic">Usuario Invitado</div>
                                                    <div class="text-xs font-mono text-gray-400 truncate w-40" title="{{ $cart->session_id }}">
                                                        Sess: {{ Str::limit($cart->session_id, 12) }}
                                                    </div>
                                                @endif
                                            </td>

                                            {{-- Cantidad de Items --}}
                                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                                <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-gray-100 text-gray-800">
                                                    {{ $cart->items->sum('quantity') }} prod.
                                                </span>
                                            </td>

                                            {{-- Monto Acumulado --}}
                                            <td class="px-6 py-4 text-right whitespace-nowrap text-sm font-bold text-gray-900">
                                                ${{ number_format($cart->total_amount, 2) }}
                                            </td>

                                            {{-- Fecha --}}
                                            <td class="px-6 py-4 text-right whitespace-nowrap text-sm text-gray-500">
                                                {{ $cart->updated_at->diffForHumans() }}
                                                <span class="block text-xs text-gray-400">({{ $cart->updated_at->format('d/m/Y H:i') }})</span>
                                            </td>

                                            {{-- Botón Detalle --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                <a href="{{ route('admin.carts.show', $cart->id) }}" 
                                                   class="inline-flex items-center text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition text-xs font-semibold">
                                                    Ver Detalle
                                                    <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $carts->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            No se encontraron carritos abandonados con productos en el sistema.
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>