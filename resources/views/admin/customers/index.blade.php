<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Clientes
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-lg sm:rounded-xl border border-gray-200 p-6">

                {{-- Formulario de Búsqueda --}}
                <div class="mb-6">
                    <form action="{{ route('admin.customers.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                        <div class="relative flex-1">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                🔍
                            </span>
                            <input type="text" name="search" value="{{ $search ?? '' }}" 
                                   placeholder="Buscar por nombre, email, teléfono o RIF..." 
                                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-5 py-2 rounded-lg transition shadow-sm">
                                Buscar
                            </button>
                            @if(request()->filled('search'))
                                <a href="{{ route('admin.customers.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold px-4 py-2 rounded-lg transition border border-gray-300 flex items-center justify-center">
                                    Limpiar
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                @if($customers->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Teléfono</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Registrado</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($customers as $customer)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 text-gray-900 font-medium">#{{ $customer->id }}</td>
                                        <td class="px-6 py-4 text-gray-900 font-semibold">{{ $customer->name }}</td>
                                        
                                        <td class="px-6 py-4">
                                            @if($customer->phone)
                                                @php
                                                    $cleanPhone = preg_replace('/[^0-9]/', '', $customer->phone);

                                                    if (!str_starts_with($cleanPhone, '58')) {
                                                        if (str_starts_with($cleanPhone, '0')) {
                                                            $cleanPhone = substr($cleanPhone, 1);
                                                        }
                                                        $cleanPhone = '58' . $cleanPhone;
                                                    }
                                                @endphp

                                                <div class="flex items-center gap-2">
                                                    <span class="text-gray-700 font-medium">{{ $customer->phone }}</span>
                                                    <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" rel="noopener noreferrer" 
                                                       class="inline-flex items-center gap-1 bg-green-100 hover:bg-green-200 text-green-700 font-bold px-2 py-0.5 rounded text-xs transition border border-green-200"
                                                       title="Escribir a WhatsApp">
                                                       💬 WhatsApp
                                                    </a>
                                                </div>
                                            @else
                                                <span class="text-gray-400 italic">No registrado</span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 text-gray-600">{{ $customer->created_at->format('d/m/Y') }}</td>

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
                    <div class="bg-gray-50 rounded-xl p-8 text-center text-gray-500 text-sm border border-dashed border-gray-200">
                        @if($search)
                            No se encontraron clientes que coincidan con la búsqueda: <strong class="text-gray-800">"{{ $search }}"</strong>.
                        @else
                            No hay clientes registrados en la plataforma.
                        @endif
                    </div>
                @endif

            </div>

        </div>
    </div>
</x-app-layout>