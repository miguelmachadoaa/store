<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Reportes de Pago</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Buscador -->
            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-200 p-6 mb-6">
                <form action="{{ route('admin.payments.index') }}" method="GET" class="flex gap-4">
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="Buscar por referencia, banco o nombre de cliente..."
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md text-sm transition">
                        Buscar
                    </button>
                </form>
            </div>

            <!-- Tabla -->
            <div class="bg-white shadow-lg sm:rounded-xl border border-gray-200 p-6">
                @if($reports->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Orden</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Banco / Referencia</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Monto (Bs)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha Pago</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Comprobante</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 text-sm">
                                @foreach($reports as $report)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 font-semibold text-indigo-600">
                                            <a href="{{ route('admin.orders.show', $report->order_id) }}">#{{ $report->order_id }}</a>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-gray-900">{{ $report->order->customer_name }}</div>
                                            <div class="text-xs text-gray-500">{{ $report->user->email }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-gray-900 font-medium">{{ $report->bank_name }}</div>
                                            <div class="text-xs text-gray-500">Ref: {{ $report->reference_number }}</div>
                                        </td>
                                        <td class="px-6 py-4 font-semibold text-gray-900">Bs. {{ number_format($report->amount_bs, 2) }}</td>
                                        <td class="px-6 py-4 text-gray-600">{{ \Carbon\Carbon::parse($report->payment_date)->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4">
                                            @if($report->proof_image)
                                                <a href="{{ asset('storage/' . $report->proof_image) }}" target="_blank" class="text-xs text-indigo-600 hover:underline font-semibold flex items-center gap-1">
                                                    Ver captura ↗
                                                </a>
                                            @else
                                                <span class="text-gray-400 text-xs">Sin captura</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 inline-flex text-xs font-semibold rounded-full 
                                                {{ $report->status === 'approved' ? 'bg-green-100 text-green-800' : ($report->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                {{ $report->status === 'approved' ? 'Aprobado' : ($report->status === 'rejected' ? 'Rechazado' : 'Pendiente') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            @if($report->status === 'pending')
                                                <div class="flex justify-end gap-2">
                                                    <form action="{{ route('admin.payments.updateStatus', $report) }}" method="POST">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="status" value="approved">
                                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white text-xs px-2 py-1 rounded font-medium transition">Aprobar</button>
                                                    </form>
                                                    <form action="{{ route('admin.payments.updateStatus', $report) }}" method="POST">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="status" value="rejected">
                                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-xs px-2 py-1 rounded font-medium transition">Rechazar</button>
                                                    </form>
                                                </div>
                                            @else
                                                <span class="text-xs text-gray-400">Procesado</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $reports->links() }}</div>
                @else
                    <p class="text-gray-600 text-center py-4">No hay reportes de pago registrados.</p>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>