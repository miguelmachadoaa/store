<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Impuestos') }}
            </h2>
            <a href="{{ route('admin.taxes.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                Nuevo Impuesto
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

            {{-- Tabla --}}
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-200">
                <div class="p-6">

                    @if($taxes->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nombre
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tasa (%)
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
                                    @foreach($taxes as $tax)
                                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">

                                            {{-- Nombre --}}
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $tax->name }}</div>
                                            </td>

                                            {{-- Tasa --}}
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900">{{ $tax->rate }}%</div>
                                            </td>

                                            {{-- Estado --}}
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($tax->is_active)
                                                    <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                        Activo
                                                    </span>
                                                @else
                                                    <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                        Inactivo
                                                    </span>
                                                @endif
                                            </td>

                                            {{-- Acciones --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex justify-end gap-3">

                                                <a href="{{ route('admin.taxes.edit', $tax) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">
                                                    Editar
                                                </a>

                                                <form action="{{ route('admin.taxes.destroy', $tax) }}" method="POST" onsubmit="return confirm('¿Eliminar impuesto?')">
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
                            {{ $taxes->links() }}
                        </div>

                    @else
                        <p class="text-gray-600">No hay impuestos registrados.</p>
                    @endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
