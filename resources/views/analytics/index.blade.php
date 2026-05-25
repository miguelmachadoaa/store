<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Métricas de Visitas e Impacto') }}
            </h2>
            <div class="flex bg-gray-200 p-1 rounded-lg">
                <a href="{{ route('admin.analytics.index', ['type' => 'urls']) }}" 
                   class="px-4 py-2 rounded-md text-sm font-medium {{ $type === 'urls' ? 'bg-white shadow text-indigo-600' : 'text-gray-600 hover:text-gray-900' }}">
                    Páginas
                </a>
                <a href="{{ route('admin.analytics.index', ['type' => 'products']) }}" 
                   class="px-4 py-2 rounded-md text-sm font-medium {{ $type === 'products' ? 'bg-white shadow text-indigo-600' : 'text-gray-600 hover:text-gray-900' }}">
                    Productos
                </a>
                <a href="{{ route('admin.analytics.index', ['type' => 'categories']) }}" 
                   class="px-4 py-2 rounded-md text-sm font-medium {{ $type === 'categories' ? 'bg-white shadow text-indigo-600' : 'text-gray-600 hover:text-gray-900' }}">
                    Categorías
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Filtros --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.analytics.index') }}" class="flex flex-wrap gap-4">
                        <input type="hidden" name="type" value="{{ $type }}">

                        <div class="flex-1 min-w-[200px]">
                            <input type="text" name="search" value="{{ request('search') }}"
                                   placeholder="Buscar por URL o elemento..."
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Buscar
                            </button>
                            <a href="{{ route('admin.analytics.index', ['type' => $type]) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Limpiar
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Tabla --}}
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-200">
                <div class="p-6">

                    @if($analytics->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Identificador / Elemento
                                        </th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Total Visitas
                                        </th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Última Visita
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($analytics as $item)
                                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                            
                                            {{-- Identificador dinámico --}}
                                            <td class="px-6 py-4">
                                                @if($type === 'products' || $type === 'categories')
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $item->viewable->name ?? 'Elemento eliminado (ID: '.$item->viewable_id.')' }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        ID de Registro: {{ $item->viewable_id }}
                                                    </div>
                                                @else
                                                    <div class="text-sm font-mono text-indigo-600 break-all">{{ $item->url }}</div>
                                                @endif
                                            </td>

                                            {{-- Total de vistas con Badge --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <span class="px-3 py-1 inline-flex text-sm font-bold rounded-full bg-indigo-100 text-indigo-800">
                                                    {{ number_format($item->total_views) }}
                                                </span>
                                            </td>

                                            {{-- Última Fecha --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($item->last_view)->diffForHumans() }}
                                                <span class="block text-xs text-gray-400">({{ \Carbon\Carbon::parse($item->last_view)->format('d/m/Y H:i') }})</span>
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
                        <p class="text-gray-600 text-center py-4">No se han registrado visitas en este criterio todavía.</p>
                    @endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>