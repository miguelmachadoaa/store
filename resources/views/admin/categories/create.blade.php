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
                    <label class="font-semibold block mb-1">Nombre</label>
                    <input type="text" name="name"
                           value="{{ old('name', $category->name ?? '') }}"
                           class="w-full border rounded p-2 @error('name') border-red-500 @enderror"
                           required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- NUEVO: Jerarquía de Categorías (Categoría Padre) --}}
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
                    <p class="text-gray-400 text-xs mt-1">Si deseas que sea una subcategoría (hija), selecciona su contenedor principal.</p>
                    @error('parent_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Campo Imagen --}}
                <div class="mb-4">
                    <label class="font-semibold block mb-1">Imagen</label>
                    <input type="file" name="image" accept="image/*"
                           class="w-full border rounded p-2 @error('image') border-red-500 @enderror"
                           onchange="previewImage(event)">
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    
                    <div class="mt-3">
                        @if(isset($category) && $category->image)
                            <div class="relative inline-block" id="preview-container">
                                <img id="image-preview" 
                                     src="{{ asset('storage/' . $category->image) }}" 
                                     alt="Category image"
                                     class="h-32 w-32 object-cover rounded-lg border-2 border-gray-200">
                                <label class="absolute top-0 right-0 bg-red-500 text-white rounded-full p-1 cursor-pointer hover:bg-red-600" title="Eliminar imagen actual">
                                    <input type="checkbox" name="remove_image" value="1" class="hidden" onchange="toggleRemoveImage(this)">
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

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    {{-- Campo Estado (Activa/Inactiva) --}}
                    <div>
                        <label class="font-semibold block mb-1">Estado en Tienda</label>
                        <select name="is_active" class="w-full border rounded p-2">
                            <option value="1" {{ old('is_active', $category->is_active ?? 1) == 1 ? 'selected' : '' }}>Activa</option>
                            <option value="0" {{ old('is_active', $category->is_active ?? 1) == 0 ? 'selected' : '' }}>Inactiva</option>
                        </select>
                    </div>

                    {{-- NUEVO: Campo Destacada (is_featured) --}}
                    <div>
                        <label class="font-semibold block mb-1">¿Destacar Categoría?</label>
                        <select name="is_featured" class="w-full border rounded p-2">
                            <option value="0" {{ old('is_featured', $category->is_featured ?? 0) == 0 ? 'selected' : '' }}>No destacar</option>
                            <option value="1" {{ old('is_featured', $category->is_featured ?? 0) == 1 ? 'selected' : '' }}>Destacar en Portada (Home)</option>
                        </select>
                    </div>
                </div>

                {{-- Botones de acción --}}
                <div class="flex gap-2 border-t pt-4">
                    <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded font-medium hover:bg-indigo-700 transition-colors">
                        Guardar Registro
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
                    // Resetear opacidad si previamente se marcó para eliminar
                    preview.style.opacity = '1';
                }
                reader.readAsDataURL(file);
            }
        }

        function toggleRemoveImage(checkbox) {
            const preview = document.getElementById('image-preview');
            if (checkbox.checked) {
                preview.style.opacity = '0.3';
                preview.style.border = '2px dashed #ef4444';
            } else {
                preview.style.opacity = '1';
                preview.style.border = '2px solid #e5e7eb';
            }
        }
    </script>
    @endpush
</x-app-layout>