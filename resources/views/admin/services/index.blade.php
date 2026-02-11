<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Servicios
            </h2>
            <a href="{{ route('admin.services.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                Nuevo Servicio
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

            <div class="bg-white shadow-lg sm:rounded-xl border border-gray-200 p-6">
                @if($services->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Precio</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Secciones
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Testimonios
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($services as $service)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                @if($service->icon)
                                                    <span class="text-2xl">{{ $service->icon }}</span>
                                                @endif
                                                <div>
                                                    <div class="font-semibold">{{ $service->name }}</div>
                                                    @if($service->is_featured)
                                                        <span
                                                            class="text-xs bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded">Destacado</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($service->price)
                                                <span class="font-semibold">${{ number_format($service->price, 2) }}</span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center">{{ $service->sections_count }}</td>
                                        <td class="px-6 py-4 text-center">{{ $service->testimonials_count }}</td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="px-3 py-1 inline-flex text-xs font-semibold rounded-full {{ $service->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $service->is_active ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex justify-end gap-2">
                                                <a href="{{ route('services.show', $service->slug) }}" target="_blank"
                                                    class="text-indigo-600 hover:text-indigo-900 font-semibold">Ver</a>
                                                <a href="{{ route('admin.services.edit', $service) }}"
                                                    class="text-yellow-600 hover:text-yellow-900 font-semibold">Editar</a>
                                                <form action="{{ route('admin.services.destroy', $service) }}" method="POST"
                                                    class="inline-block"
                                                    onsubmit="return confirm('¿Estás seguro de eliminar este servicio?');">
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
                        {{ $services->links() }}
                    </div>
                @else
                    <p class="text-gray-600">No hay servicios registrados.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>