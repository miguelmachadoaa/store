<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Métricas de Visitas e Impacto') }}
            </h2>
            <div class="flex bg-gray-200 p-1 rounded-lg">
                <a href="{{ route('admin.analytics.index', ['type' => 'urls', 'from_date' => request('from_date'), 'to_date' => request('to_date')]) }}" 
                   class="px-4 py-2 rounded-md text-sm font-medium {{ $type === 'urls' ? 'bg-white shadow text-indigo-600' : 'text-gray-600 hover:text-gray-900' }}">
                     Páginas
                </a>
                <a href="{{ route('admin.analytics.index', ['type' => 'products', 'from_date' => request('from_date'), 'to_date' => request('to_date')]) }}" 
                   class="px-4 py-2 rounded-md text-sm font-medium {{ $type === 'products' ? 'bg-white shadow text-indigo-600' : 'text-gray-600 hover:text-gray-900' }}">
                     Productos
                </a>
                <a href="{{ route('admin.analytics.index', ['type' => 'categories', 'from_date' => request('from_date'), 'to_date' => request('to_date')]) }}" 
                   class="px-4 py-2 rounded-md text-sm font-medium {{ $type === 'categories' ? 'bg-white shadow text-indigo-600' : 'text-gray-600 hover:text-gray-900' }}">
                     Categorías
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- FICHAS DE TOTALES --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100 flex items-center">
                    <div class="p-3 rounded-full bg-indigo-50 text-indigo-600 mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Visitas en Rango</p>
                        <p class="text-3xl font-bold text-gray-950">{{ number_format($cards['total_views']) }}</p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100 flex items-center">
                    <div class="p-3 rounded-full bg-emerald-50 text-emerald-600 mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Visitantes Únicos</p>
                        <p class="text-3xl font-bold text-gray-950">{{ number_format($cards['unique_visitors']) }}</p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100 flex items-center">
                    <div class="p-3 rounded-full bg-amber-50 text-amber-600 mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Top URL del Rango</p>
                        <p class="text-lg font-bold text-gray-950 truncate" title="{{ $cards['most_visited'] }}">{{ $cards['most_visited'] }}</p>
                    </div>
                </div>
            </div>

            {{-- Filtros Avanzados (Desde - Hasta) --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.analytics.index') }}" class="flex flex-wrap items-end gap-4">
                        <input type="hidden" name="type" value="{{ $type }}">

                        {{-- Fecha Desde --}}
                        <div class="w-full sm:w-auto">
                            <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Desde</label>
                            <input type="date" name="from_date" value="{{ $fromDate }}"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        </div>

                        {{-- Fecha Hasta --}}
                        <div class="w-full sm:w-auto">
                            <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Hasta</label>
                            <input type="date" name="to_date" value="{{ $toDate }}"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        </div>

                        {{-- Input de búsqueda --}}
                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Buscar por nombre o URL</label>
                            <input type="text" name="search" value="{{ request('search') }}"
                                   placeholder="Ej: Camiseta, /contacto, etc..."
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-sm h-[42px]">
                                Filtrar Rango
                            </button>
                            <a href="{{ route('admin.analytics.index', ['type' => $type]) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded text-sm h-[42px] flex items-center">
                                Limpiar
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Tabla de Visitas Completa (Sin agrupar) --}}
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-200">
                <div class="p-6">
                    <div class="mb-4 text-sm text-gray-600 font-medium">
                        Rango de análisis: <span class="text-indigo-600 font-bold">{{ \Carbon\Carbon::parse($fromDate)->format('d/m/Y') }}</span> al <span class="text-indigo-600 font-bold">{{ \Carbon\Carbon::parse($toDate)->format('d/m/Y') }}</span>
                    </div>

                    @if($analytics->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/3">
                                            Elemento / URL
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Campaña / Origen (UTM)
                                        </th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ID Sesión
                                        </th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Fecha y Hora
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($analytics as $item)
                                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                            {{-- Elemento --}}
                                            <td class="px-6 py-4">
                                                @if($type === 'products' || $type === 'categories')
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $item->viewable->name ?? 'Elemento eliminado (ID: '.$item->viewable_id.')' }}
                                                    </div>
                                                    <div class="text-xs text-gray-400">ID Registro: {{ $item->id }}</div>
                                                @else
                                                    <div class="text-sm font-mono text-indigo-600 break-all">{{ $item->url }}</div>
                                                    <div class="text-xs text-gray-400">ID Registro: {{ $item->id }}</div>
                                                @endif
                                            </td>

                                            {{-- UTM Datos --}}
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($item->utm_source || $item->utm_medium || $item->utm_campaign)
                                                    <div class="flex flex-wrap gap-1">
                                                        @if($item->utm_source)
                                                            <span class="px-2 py-0.5 text-xs font-semibold rounded bg-blue-50 text-blue-700 border border-blue-200" title="Source">
                                                                src: {{ $item->utm_source }}
                                                            </span>
                                                        @endif
                                                        @if($item->utm_medium)
                                                            <span class="px-2 py-0.5 text-xs font-semibold rounded bg-purple-50 text-purple-700 border border-purple-200" title="Medium">
                                                                med: {{ $item->utm_medium }}
                                                            </span>
                                                        @endif
                                                        @if($item->utm_campaign)
                                                            <span class="px-2 py-0.5 text-xs font-semibold rounded bg-orange-50 text-orange-700 border border-orange-200" title="Campaign">
                                                                cpm: {{ $item->utm_campaign }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="text-xs text-gray-400 italic">Tráfico orgánico / directo</span>
                                                @endif
                                            </td>

                                            {{-- ID de Sesión --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-xs font-mono text-gray-500">
                                                <span class="bg-gray-100 px-2 py-1 rounded" title="{{ $item->session_id }}">
                                                    {{ Str::limit($item->session_id, 10, '...') }}
                                                </span>
                                            </td>

                                            {{-- Fecha Exacta del Evento --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                                                <span class="block text-xs text-gray-400">({{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i:s') }})</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $analytics->appends(request()->query())->links() }}
                        </div>
                    @else
                        <p class="text-gray-600 text-center py-4">No hay visitas registradas en este rango de fechas.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>