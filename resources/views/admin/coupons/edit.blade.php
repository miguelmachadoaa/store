<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            {{ isset($coupon) ? 'Editar Cupón' : 'Nuevo Cupón' }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-lg p-6 border">
            <form method="POST"
                action="{{ isset($coupon) ? route('admin.coupons.update', $coupon) : route('admin.coupons.store') }}">
                @csrf
                @isset($coupon)
                    @method('PUT')
                @endisset

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block font-semibold">Código</label>
                        <input type="text" name="code" value="{{ old('code', $coupon->code ?? '') }}"
                            class="w-full border rounded p-2 @error('code') border-red-500 @enderror" required
                            placeholder="EJ: DESCUENTO10">
                        @error('code')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-semibold">Estado</label>
                        <select name="is_active" class="w-full border rounded p-2">
                            <option value="1" {{ old('is_active', $coupon->is_active ?? 1) == 1 ? 'selected' : '' }}>
                                Activa</option>
                            <option value="0" {{ old('is_active', $coupon->is_active ?? 1) == 0 ? 'selected' : '' }}>
                                Inactiva</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block font-semibold">Tipo</label>
                        <select name="type" class="w-full border rounded p-2">
                            <option value="porcentaje" {{ old('type', $coupon->type ?? '') == 'porcentaje' ? 'selected' : '' }}>Porcentaje (%)</option>
                            <option value="monto_fijo" {{ old('type', $coupon->type ?? '') == 'monto_fijo' ? 'selected' : '' }}>Monto Fijo ($)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold">Valor</label>
                        <input type="number" step="0.01" name="value" value="{{ old('value', $coupon->value ?? '') }}"
                            class="w-full border rounded p-2 @error('value') border-red-500 @enderror" required>
                        @error('value')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block font-semibold">Fecha Inicio</label>
                        <input type="datetime-local" name="start_date"
                            value="{{ old('start_date', isset($coupon->start_date) ? $coupon->start_date->format('Y-m-d\TH:i') : '') }}"
                            class="w-full border rounded p-2">
                    </div>

                    <div>
                        <label class="block font-semibold">Fecha Expiración</label>
                        <input type="datetime-local" name="expires_at"
                            value="{{ old('expires_at', isset($coupon->expires_at) ? $coupon->expires_at->format('Y-m-d\TH:i') : '') }}"
                            class="w-full border rounded p-2">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block font-semibold">Límite de Uso (Nacional)</label>
                        <input type="number" name="usage_limit"
                            value="{{ old('usage_limit', $coupon->usage_limit ?? '') }}"
                            class="w-full border rounded p-2" placeholder="Opcional">
                    </div>

                    <div>
                        <label class="block font-semibold">Monto Mínimo de Pedido ($)</label>
                        <input type="number" step="0.01" name="min_order_amount"
                            value="{{ old('min_order_amount', $coupon->min_order_amount ?? '') }}"
                            class="w-full border rounded p-2" placeholder="Opcional">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="hidden" name="first_purchase_only" value="0">
                        <input type="checkbox" name="first_purchase_only" value="1" {{ old('first_purchase_only', $coupon->first_purchase_only ?? 0) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-600">Solo para primera compra</span>
                    </label>
                </div>

                <div class="border-t pt-4 mt-4">
                    <h3 class="font-bold mb-2">Restricciones Específicas (Opcional)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-semibold text-sm">Categoría</label>
                            <select name="category_id" class="w-full border rounded p-2 text-sm">
                                <option value="">Todas las categorías</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $coupon->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block font-semibold text-sm">Marca</label>
                            <select name="brand_id" class="w-full border rounded p-2 text-sm">
                                <option value="">Todas las marcas</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ old('brand_id', $coupon->brand_id ?? '') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex gap-2 mt-6">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                        Actualizar
                    </button>
                    <a href="{{ route('admin.coupons.index') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>