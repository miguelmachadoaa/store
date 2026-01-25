<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalle del Producto') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('products.edit', $product) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Editar
                </a>
                <a href="{{ route('products.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Imagen del producto -->
                        <div>
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-auto rounded-lg shadow-md border border-gray-200">
                            @else
                                <div class="w-full h-96 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center border border-gray-200">
                                    <svg class="h-32 w-32 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif

                            <!-- Badges -->
                            <div class="mt-4 flex gap-2">
                                @if($product->is_active)
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Activo
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Inactivo
                                    </span>
                                @endif

                                @if($product->is_featured)
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Destacado
                                    </span>
                                @endif

                                @if($product->stock <= 0)
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Sin Stock
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Información del producto -->
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>

                            <!-- Precio -->
                            <div class="mb-6">
                                <div class="flex items-baseline gap-3">
                                    <span class="text-4xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                                    @if($product->compare_price && $product->compare_price > $product->price)
                                        <span class="text-2xl text-gray-500 line-through">${{ number_format($product->compare_price, 2) }}</span>
                                        <span class="px-2 py-1 text-sm font-semibold text-white bg-red-500 rounded">
                                            -{{ $product->discount_percentage }}%
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Información adicional -->
                            <div class="space-y-4 mb-6">
                                @if($product->sku)
                                    <div class="flex items-center gap-2">
                                        <span class="font-semibold text-gray-700">SKU:</span>
                                        <span class="text-gray-600">{{ $product->sku }}</span>
                                    </div>
                                @endif

                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-gray-700">Stock:</span>
                                    <span class="text-gray-600 {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $product->stock }} unidades
                                    </span>
                                </div>

                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-gray-700">Slug:</span>
                                    <span class="text-gray-600">{{ $product->slug }}</span>
                                </div>

                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-gray-700">Creado:</span>
                                    <span class="text-gray-600">{{ $product->created_at->format('d/m/Y H:i') }}</span>
                                </div>

                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-gray-700">Actualizado:</span>
                                    <span class="text-gray-600">{{ $product->updated_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>

                            <!-- Descripción -->
                            @if($product->description)
                                <div class="border-t pt-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Descripción</h3>
                                    <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Acciones -->
                    <div class="mt-8 pt-6 border-t flex justify-between items-center">
                        <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este producto? Esta acción no se puede deshacer.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded">
                                Eliminar Producto
                            </button>
                        </form>

                        <div class="flex gap-3">
                            <a href="{{ route('products.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
                                Volver al Listado
                            </a>
                            <a href="{{ route('products.edit', $product) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded">
                                Editar Producto
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>