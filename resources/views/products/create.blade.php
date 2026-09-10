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

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-md">
                    <div class="font-medium text-red-800">¡Ups! Algo salió mal.</div>
                    <ul class="mt-2 list-disc list-inside text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @else
                <div class="mb-6 text-sm text-gray-600">
                    Completa el formulario para crear un nuevo producto. Los campos marcados con * son obligatorios.
                </div>
            @endif

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
                                <p class="mt-1 text-xs text-gray-500">Para mostrar precio tachado/descuentos</p>
                                @error('compare_price')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Categoría principal / Múltiples Categorías -->
                            @if(isset($categories) && $categories->count() > 0)
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Categorías</label>
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 max-h-48 overflow-y-auto p-3 border border-gray-200 rounded-md bg-gray-50">
                                    @foreach($categories as $category)
                                        <label class="inline-flex items-center space-x-2 text-sm text-gray-700 cursor-pointer">
                                            <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                                {{ is_array(old('categories')) && in_array($category->id, old('categories')) ? 'checked' : '' }}
                                                class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                            <span>{{ $category->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <!-- SECCIÓN NUEVA: Piedras Holísticas / Naturales -->
                            @if(isset($stones) && $stones->count() > 0)
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Piedras / Cristales Incorporados
                                </label>
                                <p class="text-xs text-gray-500 mb-2">Selecciona las piedras naturales que componen o caracterizan a esta pieza.</p>
                                
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 max-h-56 overflow-y-auto p-3 border border-gray-200 rounded-md bg-gray-50">
                                    @foreach($stones as $stone)
                                        <label class="inline-flex items-center space-x-2 text-sm text-gray-700 cursor-pointer hover:bg-gray-100 p-1.5 rounded transition-colors">
                                            <input type="checkbox" name="stones[]" value="{{ $stone->id }}"
                                                {{ is_array(old('stones')) && in_array($stone->id, old('stones')) ? 'checked' : '' }}
                                                class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                            <span class="flex items-center gap-1.5">
                                                @if(!empty($stone->color_hex))
                                                    <span class="w-3 h-3 rounded-full border border-gray-300 inline-block" style="background-color: {{ $stone->color_hex }}"></span>
                                                @endif
                                                {{ $stone->name }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('stones')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            @endif

                            <!-- Descripción -->
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700">Descripción del Producto</label>
                                <textarea name="description" id="description" rows="4"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Imagen Principal -->
                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-700">Imagen Principal</label>
                                <input type="file" name="image" id="image" accept="image/*"
                                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('image') border-red-500 @enderror">
                                @error('image')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Galería Múltiple -->
                            <div>
                                <label for="images" class="block text-sm font-medium text-gray-700">Galería de Imágenes Adicionales</label>
                                <input type="file" name="images[]" id="images" accept="image/*" multiple
                                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                <p class="mt-1 text-xs text-gray-500">Puedes seleccionar múltiples archivos a la vez.</p>
                            </div>

                            <!-- Separador SEO -->
                            <div class="md:col-span-2 my-2">
                                <hr class="border-gray-200">
                                <p class="text-sm font-semibold text-gray-500 mt-2">Configuración SEO (Opcional)</p>
                            </div>

                            <!-- Meta Title -->
                            <div class="md:col-span-2">
                                <label for="meta_title" class="block text-sm font-medium text-gray-700">Meta Title</label>
                                <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('meta_title') border-red-500 @enderror">
                                @error('meta_title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Meta Description -->
                            <div class="md:col-span-2">
                                <label for="meta_description" class="block text-sm font-medium text-gray-700">Meta Description</label>
                                <textarea name="meta_description" id="meta_description" rows="2"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('meta_description') border-red-500 @enderror">{{ old('meta_description') }}</textarea>
                                @error('meta_description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Checkboxes de Estado -->
                            <div class="md:col-span-2 space-y-4 pt-2">
                                <div class="flex items-center">
                                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                        Producto Activo en Tienda
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

                            <!-- Configuración de Vista de Landing / Hotmart -->
                            <div class="md:col-span-2 bg-white p-6 rounded-lg shadow-sm border border-gray-200 my-4">
                                <h3 class="text-lg font-bold text-gray-900 mb-4">Configuración de Diseño y Presentación</h3>
                                <div>
                                    <label for="view_type" class="block text-sm font-medium text-gray-700">Tipo de Ficha de Producto</label>
                                    <select name="view_type" id="view_type" onchange="toggleHotmartFields()" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="default" {{ old('view_type', 'default') == 'default' ? 'selected' : '' }}>Tienda Clásica (Estándar)</option>
                                        <option value="hotmart" {{ old('view_type') == 'hotmart' ? 'selected' : '' }}>Landing Page de Conversión (Tipo Hotmart)</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Campos dinámicos Landing Page Hotmart -->
                            <div id="hotmart_fields_container" class="md:col-span-2 hidden space-y-6 bg-gray-50 p-6 rounded-lg border border-gray-200 mb-4">
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
                                            <input type="text" name="landing_benefits[]" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" placeholder="Ej. Equilibra la energía personal...">
                                            <button type="button" onclick="removeRow(this)" class="bg-rose-500 hover:bg-rose-600 text-white px-3 py-2 rounded-md text-sm">Eliminar</button>
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
                                                <input type="text" name="landing_target_public[si][]" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" placeholder="Ej. Quienes buscan protección energética...">
                                                <button type="button" onclick="removeRow(this)" class="bg-rose-500 hover:bg-rose-600 text-white px-3 py-2 rounded-md text-sm">X</button>
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
                                                <input type="text" name="landing_target_public[no][]" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" placeholder="Ej. Quienes buscan imitación sintética...">
                                                <button type="button" onclick="removeRow(this)" class="bg-rose-500 hover:bg-rose-600 text-white px-3 py-2 rounded-md text-sm">X</button>
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
                                            <button type="button" onclick="removeRow(this.parentElement)" class="absolute top-2 right-2 text-rose-600 hover:text-rose-800 text-sm font-bold">Eliminar</button>
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
                                                <input type="text" name="landing_bonuses[0][title]" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" placeholder="Título del Bonus (ej. Guía de Limpieza Energética)">
                                                <input type="text" name="landing_bonuses[0][description]" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" placeholder="Breve descripción del regalo">
                                            </div>
                                            <div>
                                                <input type="number" step="0.01" name="landing_bonuses[0][value]" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" placeholder="Valor comercial ($)">
                                            </div>
                                            <button type="button" onclick="removeRow(this.parentElement)" class="absolute top-2 right-2 text-rose-600 hover:text-rose-800 text-sm font-bold">Eliminar</button>
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

                        <!-- Botones de Acción -->
                        <div class="mt-8 flex items-center justify-end gap-x-4 border-t border-gray-200 pt-6">
                            <a href="{{ route('products.index') }}" class="text-sm font-semibold leading-6 text-gray-900 hover:text-gray-700">
                                Cancelar
                            </a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Crear Producto
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts de Interacción Dinámica -->
    <script>
        function toggleHotmartFields() {
            const viewType = document.getElementById('view_type').value;
            const container = document.getElementById('hotmart_fields_container');
            if (viewType === 'hotmart') {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }
        }

        function removeRow(element) {
            element.parentElement.remove();
        }

        function addBenefitRow() {
            const wrapper = document.getElementById('benefits-wrapper');
            const div = document.createElement('div');
            div.className = 'flex items-center space-x-2';
            div.innerHTML = `
                <input type="text" name="landing_benefits[]" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" placeholder="Otro beneficio...">
                <button type="button" onclick="removeRow(this)" class="bg-rose-500 hover:bg-rose-600 text-white px-3 py-2 rounded-md text-sm">Eliminar</button>
            `;
            wrapper.appendChild(div);
        }

        function addTargetSiRow() {
            const wrapper = document.getElementById('target-si-wrapper');
            const div = document.createElement('div');
            div.className = 'flex items-center space-x-2';
            div.innerHTML = `
                <input type="text" name="landing_target_public[si][]" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" placeholder="Nueva condición...">
                <button type="button" onclick="removeRow(this)" class="bg-rose-500 hover:bg-rose-600 text-white px-3 py-2 rounded-md text-sm">X</button>
            `;
            wrapper.appendChild(div);
        }

        function addTargetNoRow() {
            const wrapper = document.getElementById('target-no-wrapper');
            const div = document.createElement('div');
            div.className = 'flex items-center space-x-2';
            div.innerHTML = `
                <input type="text" name="landing_target_public[no][]" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" placeholder="Nueva condición...">
                <button type="button" onclick="removeRow(this)" class="bg-rose-500 hover:bg-rose-600 text-white px-3 py-2 rounded-md text-sm">X</button>
            `;
            wrapper.appendChild(div);
        }

        let testimonialCount = 1;
        function addTestimonialRow() {
            const wrapper = document.getElementById('testimonials-wrapper');
            const div = document.createElement('div');
            div.className = 'grid grid-cols-1 gap-2 p-4 bg-white rounded-md border border-gray-200 relative';
            div.innerHTML = `
                <input type="text" name="landing_testimonials[${testimonialCount}][name]" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" placeholder="Nombre del cliente">
                <textarea name="landing_testimonials[${testimonialCount}][text]" rows="2" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" placeholder="Opinión o testimonio..."></textarea>
                <button type="button" onclick="removeRow(this.parentElement)" class="absolute top-2 right-2 text-rose-600 hover:text-rose-800 text-sm font-bold">Eliminar</button>
            `;
            wrapper.appendChild(div);
            testimonialCount++;
        }

        let bonusCount = 1;
        function addBonusRow() {
            const wrapper = document.getElementById('bonuses-wrapper');
            const div = document.createElement('div');
            div.className = 'grid grid-cols-1 md:grid-cols-3 gap-2 p-4 bg-white rounded-md border border-gray-200 relative';
            div.innerHTML = `
                <div class="md:col-span-2 space-y-2">
                    <input type="text" name="landing_bonuses[${bonusCount}][title]" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" placeholder="Título del Bonus">
                    <input type="text" name="landing_bonuses[${bonusCount}][description]" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" placeholder="Breve descripción del regalo">
                </div>
                <div>
                    <input type="number" step="0.01" name="landing_bonuses[${bonusCount}][value]" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" placeholder="Valor comercial ($)">
                </div>
                <button type="button" onclick="removeRow(this.parentElement)" class="absolute top-2 right-2 text-rose-600 hover:text-rose-800 text-sm font-bold">Eliminar</button>
            `;
            wrapper.appendChild(div);
            bonusCount++;
        }

        // Ejecutar al cargar la página por si hay valores previos de validación
        document.addEventListener('DOMContentLoaded', function () {
            toggleHotmartFields();
        });
    </script>
</x-app-layout>