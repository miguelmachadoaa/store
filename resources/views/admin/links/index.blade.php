{{-- Usa tu layout base del panel administrativo aquí --}}
<x-app-layout>
    <div class="max-w-4xl mx-auto py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Configuración de Linktree</h2>
            <a href="{{ route('admin.links.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                + Nuevo Enlace
            </a>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg mb-6 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white border rounded-xl shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b text-xs font-semibold text-gray-500 uppercase">
                        <th class="p-4 w-16 text-center">Orden</th>
                        <th class="p-4">Título del Botón</th>
                        <th class="p-4">URL de Destino</th>
                        <th class="p-4 w-24 text-center">Estado</th>
                        <th class="p-4 w-32 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y text-sm text-gray-700">
                    @foreach($links as $link)
                        <tr class="hover:bg-gray-50">
                            <td class="p-4 text-center font-bold text-gray-400">{{ $link->sort_order }}</td>
                            <td class="p-4 font-medium text-gray-900">
                                <i class="{{ $link->icon ?? 'fas fa-link' }} text-indigo-500 mr-2"></i>
                                {{ $link->title }}
                            </td>
                            <td class="p-4 text-xs text-gray-400 truncate max-w-xs">{{ $link->url }}</td>
                            <td class="p-4 text-center">
                                <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $link->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $link->is_active ? 'Activo' : 'Oculto' }}
                                </span>
                            </td>
                            <td class="p-4 text-center space-x-2">
                                <a href="{{ route('admin.links.edit', $link->id) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Editar</a>
                                <form action="{{ route('admin.links.destroy', $link->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar este enlace?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:text-red-800 font-medium">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>