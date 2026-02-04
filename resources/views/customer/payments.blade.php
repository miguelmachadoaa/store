<x-customer-layout>
    <div class="bg-white shadow rounded-lg p-6 border border-gray-100">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <h2 class="text-2xl font-bold text-gray-800">Mis Pagos Reportados</h2>
            <a href="{{ route('customer.payments.report') }}"
                class="bg-pink-600 text-white px-6 py-2 rounded-lg hover:bg-pink-700 font-bold transition">
                Reportar Nuevo Pago
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto border rounded-xl">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Orden</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Referencia</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Monto (BS)</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Banco</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Fecha</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Estado</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($payments as $payment)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-indigo-600">
                                #{{ $payment->order_id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $payment->reference_number }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-700">Bs.
                                {{ number_format($payment->amount_bs, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $payment->bank_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $payment->payment_date }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusClasses = match ($payment->status) {
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'approved' => 'bg-green-100 text-green-800',
                                        'rejected' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800',
                                    };
                                    $statusLabel = match ($payment->status) {
                                        'pending' => 'Pendiente',
                                        'approved' => 'Aprobado',
                                        'rejected' => 'Rechazado',
                                        default => $payment->status,
                                    };
                                @endphp
                                <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full {{ $statusClasses }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500 italic">No tienes reportes de pago
                                registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $payments->links() }}
        </div>
    </div>
</x-customer-layout>