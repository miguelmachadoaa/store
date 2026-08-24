<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Piedras y Minerales</h2>
            <a href="{{ route('admin.stones.create') }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Nueva Piedra</a>
        </div>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white shadow-lg rounded-lg p-6 border">

            @if(session('success'))
                <div class="mb-4 bg-green-100 text-green-700 px-4 py-2 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Imagen</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtítulo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Orden</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($stones as $stone)
                        <tr>
                            <td class="px-6 py-4">
                                @if($stone->image)
                                    <img src="{{ Storage::disk('r2')->url($stone->image) }}" alt="{{ $stone->name }}" class="h-12 w-12 object-cover rounded-full border">
                                @else
                                    <div class="h-12 w-12 rounded-full bg-gray-100 border flex items-center justify-center text-xs text-gray-400">Sin img</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-800">{{ $stone->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $stone->subtitle ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $stone->sort_order }}</td>
                            <td class="px-6 py-4">
                                @if($stone->is_active)
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs">Activa</span>
                                @else
                                    <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs">Inactiva</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right flex justify-end items-center gap-3">
                                <a href="{{ route('admin.stones.edit', $stone) }}"
                                   class="text-indigo-600 hover:text-indigo-900">Editar</a>

                                <form action="{{ route('admin.stones.destroy', $stone) }}" method="POST"
                                      onsubmit="return confirm('¿Eliminar piedra?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:text-red-900">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">No hay piedras registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $stones->links() }}
            </div>

        </div>

    </div>
</x-app-layout>