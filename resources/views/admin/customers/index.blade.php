<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Clientes
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-lg sm:rounded-xl border border-gray-200 p-6">

                @if($customers->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Registrado</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($customers as $customer)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4">{{ $customer->id }}</td>
                                        <td class="px-6 py-4">{{ $customer->name }}</td>
                                        <td class="px-6 py-4">{{ $customer->email }}</td>
                                        <td class="px-6 py-4">{{ $customer->created_at->format('d/m/Y') }}</td>

                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('admin.customers.show', $customer) }}"
                                               class="text-indigo-600 hover:text-indigo-900 font-semibold">
                                                Ver Detalle
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $customers->links() }}
                    </div>

                @else
                    <p class="text-gray-600">No hay clientes registrados.</p>
                @endif

            </div>

        </div>
    </div>
</x-app-layout>