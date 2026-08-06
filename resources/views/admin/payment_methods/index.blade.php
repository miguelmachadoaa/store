<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Formas de Pago') }}
            </h2>
            <a href="{{ route('admin.payment-methods.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                Nueva Forma de Pago
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Filtros --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.payment-methods.index') }}" class="flex flex-wrap gap-4">
                        <div class="flex-1 min-w-[200px]">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Todos los estados</option>
                                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Activas</option>
                                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactivas</option>
                            </select>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Buscar</button>
                            <a href="{{ route('admin.payment-methods.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Limpiar</a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Tabla --}}
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-200">
                <div class="p-6">
                    @if($paymentMethods->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Logo</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Método / Tipo</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detalles</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($paymentMethods as $method)
                                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($method->logo)
                                                    <img src="{{ asset('storage/' . $method->logo) }}" class="h-12 w-12 object-contain rounded border shadow-sm">
                                                @else
                                                    <div class="h-12 w-12 bg-gray-100 rounded flex items-center justify-center border shadow-sm text-gray-400">💵</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $method->name }}</div>
                                                <div class="text-xs text-gray-500 uppercase">Tipo: {{ $method->type }}</div>
                                            </td>
                                            <td class="px-6 py-4 max-w-xs truncate text-sm text-gray-600">
                                                {{ $method->description ?? 'Sin instrucciones adicionales' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full {{ $method->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $method->is_active ? 'Activa' : 'Inactiva' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex justify-end gap-3">
                                                <a href="{{ route('admin.payment-methods.edit', $method) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">Editar</a>
                                                <form action="{{ route('admin.payment-methods.destroy', $method) }}" method="POST" onsubmit="return confirm('¿Eliminar esta forma de pago?')">
                                                    @csrf @method('DELETE')
                                                    <button class="text-red-600 hover:text-red-900 font-semibold">Eliminar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">{{ $paymentMethods->links() }}</div>
                    @else
                        <p class="text-gray-600">No hay formas de pago registradas.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>