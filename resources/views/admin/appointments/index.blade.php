<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Citas
            </h2>
            <a href="{{ route('admin.appointments.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                Nueva Cita
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

            {{-- Filters --}}
            <div class="bg-white shadow-sm rounded-lg p-4 mb-4">
                <form method="GET" action="{{ route('admin.appointments.index') }}" class="flex flex-wrap gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Buscar por nombre, email o teléfono..."
                            class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg">
                    </div>
                    <div>
                        <select name="status"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg">
                            <option value="">Todos los estados</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pendiente
                            </option>
                            <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmada
                            </option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completada
                            </option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelada
                            </option>
                        </select>
                    </div>
                    <div>
                        <input type="date" name="date" value="{{ request('date') }}"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg">
                    </div>
                    <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Filtrar
                    </button>
                    <a href="{{ route('admin.appointments.index') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Limpiar
                    </a>
                </form>
            </div>

            <div class="bg-white shadow-lg sm:rounded-xl border border-gray-200 p-6">
                @if($appointments->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Servicio
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hora</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($appointments as $appointment)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div>
                                                <div class="font-semibold">{{ $appointment->customer_name }}</div>
                                                <div class="text-sm text-gray-500">{{ $appointment->customer_email }}</div>
                                                <div class="text-sm text-gray-500">{{ $appointment->customer_phone }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $appointment->service?->name ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $appointment->formatted_date }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $appointment->formatted_time }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {!! $appointment->status_badge !!}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex justify-end gap-2">
                                                <a href="{{ route('admin.appointments.show', $appointment) }}"
                                                    class="text-indigo-600 hover:text-indigo-900 font-semibold">Ver</a>
                                                <a href="{{ route('admin.appointments.edit', $appointment) }}"
                                                    class="text-yellow-600 hover:text-yellow-900 font-semibold">Editar</a>
                                                <form action="{{ route('admin.appointments.destroy', $appointment) }}"
                                                    method="POST" class="inline-block"
                                                    onsubmit="return confirm('¿Estás seguro de eliminar esta cita?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-900 font-semibold">Eliminar</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $appointments->links() }}
                    </div>
                @else
                    <p class="text-gray-600">No hay citas registradas.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>