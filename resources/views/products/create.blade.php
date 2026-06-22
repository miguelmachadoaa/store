<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Crear Producto') }}
            </h2>
            <a href="{{ route('products.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Volver
            </a>
        </div>
    </x-slot>

    <p>
        @if ($errors->any())
            <div class="mb-4">
                <div class="font-medium text-red-600">¡Ups! Algo salió mal.</div>
                <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @else
            <div class="mb-4 text-sm text-gray-600">
                Completa el formulario para crear un nuevo producto. Los campos marcados con * son obligatorios.
            </div>
        @endif
    </p>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nombre -->
                            <div class="md:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700">Nombre del Producto *</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-500 @enderror">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- SKU -->
                            <div>
                                <label for="sku" class="block text-sm font-medium text-gray-700">SKU</label>
                                <input type="text" name="sku" id="sku" value="{{ old('sku') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('sku') border-red-500 @enderror">
                                @error('sku')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Stock -->
                            <div>
                                <label for="stock" class="block text-sm font-medium text-gray-700">Stock *</label>
                                <input type="number" name="stock" id="stock" value="{{ old('stock', 0) }}" min="0" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('stock') border-red-500 @enderror">
                                @error('stock')
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
                                    <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" min="0" required
                                           class="pl-7 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('price') border-red-500 @enderror">
                                </div>
                                @error('price')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Precio de comparación -->
                            <div>
                                <label for="compare_price" class="block text-sm font-medium text-gray-700">Precio Anterior</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" name="compare_price" id="compare_price" value="{{ old('compare_price') }}" step="0.01" min="0"
                                           class="pl-7 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 @error('compare_price') border-red-500 @enderror">
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Para mostrar descuentos</p>
                                @error('compare_price')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Descripción -->
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                                <textarea name="description" id="description" rows="4"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Imagen -->
                            <div class="md:col-span-2">
                                <label for="image" class="block text-sm font-medium text-gray-700">Imagen del Producto</label>
                                <input type="file" name="image" id="image" accept="image/*"
                                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('image') border-red-500 @enderror">
                                @error('image')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2 my-2">
                                <hr class="border-gray-200">
                                <p class="text-sm font-semibold text-gray-500 mt-2">Configuración SEO (Opcional)</p>
                            </div>

                            <!-- NUEVO: Meta Title -->
                            <div class="md:col-span-2">
                                <label for="meta_title" class="block text-sm font-medium text-gray-700">Meta Title</label>
                                <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('meta_title') border-red-500 @enderror">
                                @error('meta_title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- NUEVO: Meta Description -->
                            <div class="md:col-span-2">
                                <label for="meta_description" class="block text-sm font-medium text-gray-700">Meta Description</label>
                                <textarea name="meta_description" id="meta_description" rows="2"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('meta_description') border-red-500 @enderror">{{ old('meta_description') }}</textarea>
                                @error('meta_description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Checkboxes -->
                            <div class="md:col-span-2 space-y-4">
                                <div class="flex items-center">
                                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                        Producto Activo
                                    </label>
                                </div>

                                <div class="flex items-center">
                                    <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="is_featured" class="ml-2 block text-sm text-gray-900">
                                        Producto Destacado
                                    </label>
                                </div>
                            </div>

                            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 mb-6">
    <h3 class="text-lg font-bold text-gray-900 mb-4">Configuración de Diseño</h3>
    <div>
        <label for="view_type" class="block text-sm font-medium text-gray-700">Tipo de Ficha de Producto</label>
        <select name="view_type" id="view_type" onchange="toggleHotmartFields()" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            <option value="default" {{ old('view_type') == 'default' ? 'selected' : '' }}>Tienda Clásica (Estándar)</option>
            <option value="hotmart" {{ old('view_type') == 'hotmart' ? 'selected' : '' }}>Landing Page de Conversión (Tipo Hotmart)</option>
        </select>
    </div>
</div>

<div id="hotmart_fields_container" class="hidden space-y-6 bg-gray-50 p-6 rounded-lg border border-gray-200 mb-6">
    <h3 class="text-lg font-bold text-indigo-900 border-b pb-2">Secciones de la Landing Page (Hotmart)</h3>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <div>
            <label class="block text-sm font-medium text-gray-700">Título Impactante (Headline)</label>
            <input type="text" name="landing_headline" value="{{ old('landing_headline') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Subtítulo / Promesa (Subheadline)</label>
            <input type="text" name="landing_subheadline" value="{{ old('landing_subheadline') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">URL del Video de Presentación (YouTube / Vimeo)</label>
            <input type="url" name="landing_video_url" value="{{ old('landing_video_url') }}" placeholder="https://www.youtube.com/watch?v=..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Beneficios / ¿Qué va a lograr el cliente?</label>
        <div id="benefits-wrapper" class="space-y-2">
            <div class="flex items-center space-x-2">
                <input type="text" name="landing_benefits[]" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" placeholder="Ej. Aprenderás a programar desde cero...">
                <button type="button" onclick="removeRow(this)" class="bg-rose-500 text-white px-3 py-2 rounded-md text-sm">Eliminar</button>
            </div>
        </div>
        <button type="button" onclick="addBenefitRow()" class="mt-2 inline-flex items-center text-sm font-semibold text-indigo-600 hover:text-indigo-500">
            + Añadir Beneficio
        </button>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        <div>
            <label class="block text-sm font-medium text-emerald-700 mb-2">👍 ¿Para quién SÍ es este producto?</label>
            <div id="target-si-wrapper" class="space-y-2">
                <div class="flex items-center space-x-2">
                    <input type="text" name="landing_target_public[si][]" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" placeholder="Ej. Personas comprometidas...">
                    <button type="button" onclick="removeRow(this)" class="bg-rose-500 text-white px-3 py-2 rounded-md text-sm">X</button>
                </div>
            </div>
            <button type="button" onclick="addTargetSiRow()" class="mt-2 inline-flex items-center text-sm font-semibold text-emerald-600 hover:text-emerald-500">
                + Añadir Condición SÍ
            </button>
        </div>

        <div>
            <label class="block text-sm font-medium text-rose-700 mb-2">👎 ¿Para quién NO es este producto?</label>
            <div id="target-no-wrapper" class="space-y-2">
                <div class="flex items-center space-x-2">
                    <input type="text" name="landing_target_public[no][]" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" placeholder="Ej. Personas que buscan dinero fácil...">
                    <button type="button" onclick="removeRow(this)" class="bg-rose-500 text-white px-3 py-2 rounded-md text-sm">X</button>
                </div>
            </div>
            <button type="button" onclick="addTargetNoRow()" class="mt-2 inline-flex items-center text-sm font-semibold text-rose-600 hover:text-rose-500">
                + Añadir Condición NO
            </button>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Testimonios de Clientes</label>
        <div id="testimonials-wrapper" class="space-y-3">
            <div class="grid grid-cols-1 gap-2 p-4 bg-white rounded-md border border-gray-200 relative">
                <input type="text" name="landing_testimonials[0][name]" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" placeholder="Nombre del cliente">
                <textarea name="landing_testimonials[0][text]" rows="2" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" placeholder="Opinión o testimonio..."></textarea>
                <button type="button" onclick="removeTestimonialRow(this)" class="absolute top-2 right-2 text-rose-600 text-sm font-bold">Eliminar</button>
            </div>
        </div>
        <button type="button" onclick="addTestimonialRow()" class="mt-2 inline-flex items-center text-sm font-semibold text-indigo-600 hover:text-indigo-500">
            + Añadir Testimonio
        </button>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Bonus Incluidos de Regalo</label>
        <div id="bonuses-wrapper" class="space-y-3">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-2 p-4 bg-white rounded-md border border-gray-200 relative">
                <div class="md:col-span-2 space-y-2">
                    <input type="text" name="landing_bonuses[0][title]" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" placeholder="Título del Bonus">
                    <input type="text" name="landing_bonuses[0][description]" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" placeholder="Breve descripción del regalo">
                </div>
                <div>
                    <input type="number" step="0.01" name="landing_bonuses[0][value]" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" placeholder="Valor comercial ($)">
                </div>
                <button type="button" onclick="removeBonusRow(this)" class="absolute top-2 right-2 text-rose-600 text-sm font-bold">Eliminar</button>
            </div>
        </div>
        <button type="button" onclick="addBonusRow()" class="mt-2 inline-flex items-center text-sm font-semibold text-indigo-600 hover:text-indigo-500">
            + Añadir Bonus de Regalo
        </button>
    </div>

    <div class="w-full md:w-1/3">
        <label for="landing_warranty_days" class="block text-sm font-medium text-gray-700">Días de Garantía de Devolución</label>
        <input type="number" name="landing_warranty_days" id="landing_warranty_days" value="{{ old('landing_warranty_days', 7) }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
    </div>
</div>


                        </div>

                        <!-- Botones -->
                        <div class="mt-6 flex items-center justify-end gap-x-4">
                            <a href="{{ route('products.index') }}" class="text-sm font-semibold leading-6 text-gray-900">
                                Cancelar
                            </a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded">
                                Crear Producto
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

   
</x-app-layout>