<x-customer-layout>
    <div class="bg-white shadow rounded-lg p-6 border border-gray-100">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Mis Órdenes</h2>

        <div class="overflow-x-auto border rounded-xl">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Orden</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Fecha</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Total (USD)</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Total (BS)</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Estado</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-indigo-600">#{{ $order->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">
                                ${{ number_format($order->total, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-indigo-700">Bs.
                                {{ number_format($order->total_bs, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-3 py-1 inline-flex text-xs font-bold rounded-full {{ $order->status_badge }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                <div class="flex justify-end gap-3">
                                    <a href="{{ route('orders.invoice', $order->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900 font-medium flex items-center gap-1">
                                        Factura
                                    </a>
                                    @if($order->status === 'pendiente')
                                        <a href="{{ route('customer.payments.report') }}"
                                            class="text-pink-600 hover:text-pink-900 font-medium">
                                            Pagar
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500 italic">No tienes órdenes
                                registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    </div>
</x-customer-layout>