<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Cupones</h2>
            <a href="{{ route('admin.coupons.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">Nuevo
                Cupón</a>
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Valor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Restricciones</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Uso</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($coupons as $coupon)
                        <tr>
                            <td class="px-6 py-4 font-bold">{{ $coupon->code }}</td>
                            <td class="px-6 py-4">{{ ucfirst($coupon->type) }}</td>
                            <td class="px-6 py-4">
                                {{ $coupon->type === 'porcentaje' ? $coupon->value . '%' : '$' . number_format($coupon->value, 2) }}
                            </td>
                            <td class="px-6 py-4 text-xs">
                                @if($coupon->category_id)
                                    <div>Cat: {{ $coupon->category->name }}</div>
                                @endif
                                @if($coupon->brand_id)
                                    <div>Marca: {{ $coupon->brand->name }}</div>
                                @endif
                                @if($coupon->first_purchase_only)
                                    <div class="text-blue-600">Primera compra</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                {{ $coupon->used_count }} / {{ $coupon->usage_limit ?? '∞' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($coupon->is_active && (!$coupon->expires_at || $coupon->expires_at->isFuture()))
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs">Activo</span>
                                @else
                                    <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs">Inactivo</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right flex justify-end gap-3">
                                <a href="{{ route('admin.coupons.edit', $coupon) }}" class="text-indigo-600">Editar</a>
                                <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST"
                                    onsubmit="return confirm('¿Eliminar cupón?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $coupons->links() }}
            </div>
        </div>
    </div>
</x-app-layout>