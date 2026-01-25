<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Marcas') }}
            </h2>
            <a href="{{ route('brands.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                Nueva Marca
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Mensaje de éxito --}}
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Filtros --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('brands.index') }}" class="flex flex-wrap gap-4">

                        <div class="flex-1 min-w-[200px]">
                            <input type="text" name="search" value="{{ request('search') }}"
                                   placeholder="Buscar marcas..."
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Todos los estados</option>
                                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Activas</option>
                                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactivas</option>
                            </select>
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Buscar
                            </button>
                            <a href="{{ route('brands.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Limpiar
                            </a>
                        </div>

                    </form>
                </div>
            </div>

            {{-- Tabla --}}
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-200">
                <div class="p-6">

                    @if($brands->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Logo
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Marca
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Estado
                                        </th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($brands as $brand)
                                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">

                                            {{-- Logo --}}
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($brand->logo)
                                                    <img src="{{ asset('storage/' . $brand->logo) }}" class="h-12 w-12 object-contain rounded border shadow-sm">
                                                @else
                                                    <div class="h-12 w-12 bg-gray-100 rounded flex items-center justify-center border shadow-sm">
                                                        <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                  d="M4 16l4-4a2 2 0 012.828 0L16 16m-2-2l2-2a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </td>

                                            {{-- Nombre --}}
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $brand->name }}</div>
                                                <div class="text-xs text-gray-500">Slug: {{ $brand->slug }}</div>
                                            </td>

                                            {{-- Estado --}}
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($brand->is_active)
                                                    <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                        Activa
                                                    </span>
                                                @else
                                                    <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                        Inactiva
                                                    </span>
                                                @endif
                                            </td>

                                            {{-- Acciones --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex justify-end gap-3">

                                                <a href="{{ route('brands.edit', $brand) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">
                                                    Editar
                                                </a>

                                                <form action="{{ route('brands.destroy', $brand) }}" method="POST" onsubmit="return confirm('¿Eliminar marca?')">
                                                    @csrf @method('DELETE')
                                                    <button class="text-red-600 hover:text-red-900 font-semibold">
                                                        Eliminar
                                                    </button>
                                                </form>

                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $brands->links() }}
                        </div>

                    @else
                        <p class="text-gray-600">No hay marcas registradas.</p>
                    @endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>