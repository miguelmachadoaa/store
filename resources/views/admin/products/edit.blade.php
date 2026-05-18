<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Editar Producto') }}
            </h2>
            <a href="{{ route('products.index') }}"
                class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nombre -->
                            <div class="md:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700">Nombre del Producto
                                    *</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-500 @enderror">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- SKU -->
                            <div>
                                <label for="sku" class="block text-sm font-medium text-gray-700">SKU</label>
                                <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('sku') border-red-500 @enderror">
                                @error('sku')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Stock -->
                            <div>
                                <label for="stock" class="block text-sm font-medium text-gray-700">Stock *</label>
                                <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}"
                                    min="0" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('stock') border-red-500 @enderror">
                                @error('stock')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                               <div class="md:col-span-2">
                                    <label for="categories" class="block text-sm font-medium text-gray-700">Categorías</label>
                                    <select name="categories[]" id="categories" multiple 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                {{ (is_array(old('categories', $product->categories->pluck('id')->toArray())) && in_array($category->id, old('categories', $product->categories->pluck('id')->toArray()))) ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="font-semibold">Marca</label>
                                <select name="brand_id" class="w-full border rounded p-2">
                                    <option value="">Seleccione una marca</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="font-semibold">Impuesto</label>
                                <select name="tax_id" class="w-full border rounded p-2">
                                    @foreach($taxes as $tax)
                                        <option value="{{ $tax->id }}" {{ old('tax_id', $product->tax_id ?? 1) == $tax->id ? 'selected' : '' }}>
                                            {{ $tax->name }} ({{ number_format($tax->rate, 2) }}%)
                                        </option>
                                    @endforeach
                                </select>
                                @error('tax_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Precio -->
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700">Precio *</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" name="price" id="price"
                                        value="{{ old('price', $product->price) }}" step="0.01" min="0" required
                                        class="pl-7 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('price') border-red-500 @enderror">
                                </div>
                                @error('price')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Precio de comparación -->
                            <div>
                                <label for="compare_price" class="block text-sm font-medium text-gray-700">Precio
                                    Anterior</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" name="compare_price" id="compare_price"
                                        value="{{ old('compare_price', $product->compare_price) }}" step="0.01" min="0"
                                        class="pl-7 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('compare_price') border-red-500 @enderror">
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Para mostrar descuentos</p>
                                @error('compare_price')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Descripción -->
                            <div class="md:col-span-2">
                                <label for="description"
                                    class="block text-sm font-medium text-gray-700">Descripción</label>
                                <textarea name="description" id="description" rows="4"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('description') border-red-500 @enderror">{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Imagen actual -->
                            @if($product->image)
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Imagen Actual</label>
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                        class="h-32 w-32 object-cover rounded-lg border border-gray-200 shadow-sm">
                                </div>
                            @endif

                            <!-- Imagen Principal -->
                            <div class="md:col-span-2">
                                <label for="image" class="block text-sm font-medium text-gray-700">
                                    {{ $product->image ? 'Cambiar Imagen Principal' : 'Imagen Principal' }}
                                </label>
                                <input type="file" name="image" id="image" accept="image/*"
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('image') border-red-500 @enderror">
                                @error('image')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Galería -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Galería de Imágenes</label>
                                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-4">
                                    @foreach($product->images as $img)
                                        <div class="relative group" id="image-{{ $img->id }}">
                                            <img src="{{ asset('storage/' . $img->image) }}"
                                                class="h-24 w-full object-cover rounded-lg border border-gray-200">
                                            <button type="button" onclick="deleteProductImage({{ $img->id }})"
                                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 shadow-md hover:bg-red-600 transition opacity-0 group-hover:opacity-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                                <label for="images" class="block text-sm font-medium text-gray-700">Agregar más
                                    imágenes</label>
                                <input type="file" name="images[]" id="images" accept="image/*" multiple
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                <p class="mt-1 text-sm text-gray-500">Puedes seleccionar varias imágenes a la vez.</p>
                            </div>

                            <!-- Checkboxes -->
                            <div class="md:col-span-2 space-y-4">
                                <div class="flex items-center">
                                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                        Producto Activo
                                    </label>
                                </div>

                                <div class="flex items-center">
                                    <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="is_featured" class="ml-2 block text-sm text-gray-900">
                                        Producto Destacado
                                    </label>
                                </div>
                            </div>

                            <!-- SEO Settings -->
                            <div class="md:col-span-2 border-t pt-6 mt-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Configuración SEO</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="md:col-span-2">
                                        <label for="meta_title" class="block text-sm font-medium text-gray-700">Meta
                                            Title</label>
                                        <input type="text" name="meta_title" id="meta_title"
                                            value="{{ old('meta_title', $product->meta_title) }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('meta_title') border-red-500 @enderror"
                                            placeholder="Título para buscadores (opcional)">
                                        @error('meta_title')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="md:col-span-2">
                                        <label for="meta_description"
                                            class="block text-sm font-medium text-gray-700">Meta Description</label>
                                        <textarea name="meta_description" id="meta_description" rows="3"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('meta_description') border-red-500 @enderror"
                                            placeholder="Descripción para buscadores (opcional)">{{ old('meta_description', $product->meta_description) }}</textarea>
                                        @error('meta_description')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="mt-6 flex items-center justify-end gap-x-4">
                            <a href="{{ route('products.index') }}"
                                class="text-sm font-semibold leading-6 text-gray-900">
                                Cancelar
                            </a>
                            <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded">
                                Actualizar Producto
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteProductImage(imageId) {
            if (!confirm('¿Estás seguro de que deseas eliminar esta imagen?')) return;

            fetch(`/admin/products/images/${imageId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(`image-${imageId}`).remove();
                    }
                });
        }
    </script>
</x-app-layout>
<<<