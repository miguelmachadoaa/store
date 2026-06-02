<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            {{ isset($category) ? 'Editar Categoría' : 'Nueva Categoría' }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-3xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white shadow-lg rounded-lg p-6 border">

            <form method="POST" enctype="multipart/form-data"
                  action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}">
                @csrf
                @isset($category)
                    @method('PUT')
                @endisset

                {{-- Campo Nombre --}}
                <div class="mb-4">
                    <label class="font-semibold block mb-1">Nombre de la Categoría</label>
                    <input type="text" name="name"
                           value="{{ old('name', $category->name ?? '') }}"
                           class="w-full border rounded p-2 @error('name') border-red-500 @enderror"
                           required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- NUEVO: Relación Jerárquica (Categoría Padre) --}}
                <div class="mb-4">
                    <label class="font-semibold block mb-1">Categoría Padre (Jerarquía)</label>
                    <select name="parent_id" class="w-full border rounded p-2 @error('parent_id') border-red-500 @enderror">
                        <option value="">Ninguna (Definir como Categoría Principal / Raíz)</option>
                        @foreach($parentCategories as $parent)
                            <option value="{{ $parent->id }}" 
                                {{ old('parent_id', $category->parent_id ?? '') == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-gray-400 text-xs mt-1">Selecciona una opción solo si este elemento debe comportarse como una subcategoría (hija).</p>
                    @error('parent_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Campo Imagen con contenedor reactivo --}}
                <div class="mb-4">
                    <label class="font-semibold block mb-1">Imagen representativa</label>
                    <input type="file" name="image" accept="image/*"
                           class="w-full border rounded p-2 @error('image') border-red-500 @enderror"
                           onchange="previewImage(event)">
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    
                    <div class="mt-3">
                        @if(isset($category) && $category->image)
                            <div class="relative inline-block" id="preview-wrapper">
                                <img id="image-preview" 
                                     src="{{ asset('storage/' . $category->image) }}" 
                                     alt="Category image"
                                     class="h-32 w-32 object-cover rounded-lg border-2 border-gray-200 transition-all duration-200">
                                <label class="absolute top-0 right-0 bg-red-500 text-white rounded-full p-1 cursor-pointer hover:bg-red-600 shadow-md" title="Marcar para remover imagen actual">
                                    <input type="checkbox" name="remove_image" value="1" class="hidden" onchange="toggleImageState(this)">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </label>
                            </div>
                        @else
                            <img id="image-preview" 
                                 src="" 
                                 alt="Preview"
                                 class="h-32 w-32 object-cover rounded-lg border-2 border-gray-200 hidden">
                        @endif
                    </div>
                </div>

                {{-- Grid de Características de Visibilidad y Filtros --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    {{-- Campo Estado original --}}
                    <div>
                        <label class="font-semibold block mb-1">Estado de Disponibilidad</label>
                        <select name="is_active" class="w-full border rounded p-2">
                            <option value="1" {{ old('is_active', $category->is_active ?? 1) == 1 ? 'selected' : '' }}>Activa</option>
                            <option value="0" {{ old('is_active', $category->is_active ?? 1) == 0 ? 'selected' : '' }}>Inactiva</option>
                        </select>
                    </div>

                    {{-- NUEVO: Campo Destacada (is_featured) --}}
                    <div>
                        <label class="font-semibold block mb-1">¿Destacar en Portada?</label>
                        <select name="is_featured" class="w-full border rounded p-2">
                            <option value="0" {{ old('is_featured', $category->is_featured ?? 0) == 0 ? 'selected' : '' }}>No destacar</option>
                            <option value="1" {{ old('is_featured', $category->is_featured ?? 0) == 1 ? 'selected' : '' }}>Destacar en Home (Módulos principales)</option>
                        </select>
                    </div>
                </div>

                {{-- Botones de Control --}}
                <div class="flex gap-2 border-t pt-4">
                    <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded font-medium hover:bg-indigo-700 transition-colors">
                        Guardar cambios
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="bg-gray-500 text-white px-5 py-2 rounded font-medium hover:bg-gray-600 transition-colors">
                        Cancelar
                    </a>
                </div>

            </form>

        </div>

    </div>

    @push('scripts')
    <script>
        function previewImage(event) {
            const preview = document.getElementById('image-preview');
            const file = event.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    // Forzar restauración si anteriormente se atenuó con la X
                    preview.style.opacity = '1';
                    preview.style.borderColor = '#e5e7eb';
                }
                reader.readAsDataURL(file);
            }
        }

        function toggleImageState(checkbox) {
            const preview = document.getElementById('image-preview');
            if (checkbox.checked) {
                preview.style.opacity = '0.25';
                preview.style.borderColor = '#ef4444';
            } else {
                preview.style.opacity = '1';
                preview.style.borderColor = '#e5e7eb';
            }
        }
    </script>
    @endpush
</x-app-layout>