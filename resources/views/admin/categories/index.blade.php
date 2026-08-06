<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Categorías</h2>
            <a href="{{ route('admin.categories.create') }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded">Nueva Categoría</a>
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($categories as $category)
                        <tr>
                            <td class="px-6 py-4">{{ $category->name }}</td>
                            <td class="px-6 py-4">
                                @if($category->is_active)
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs">Activa</span>
                                @else
                                    <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs">Inactiva</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right flex justify-end gap-3">
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                   class="text-indigo-600">Editar</a>

                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                      onsubmit="return confirm('¿Eliminar categoría?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $categories->links() }}
            </div>

        </div>

    </div>
</x-app-layout>