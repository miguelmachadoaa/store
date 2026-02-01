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

                <div class="mb-4">
                    <label class="font-semibold">Nombre</label>
                    <input type="text" name="name"
                           value="{{ old('name', $category->name ?? '') }}"
                           class="w-full border rounded p-2 @error('name') border-red-500 @enderror"
                           required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="font-semibold">Imagen</label>
                    <input type="file" name="image" accept="image/*"
                           class="w-full border rounded p-2 @error('image') border-red-500 @enderror"
                           onchange="previewImage(event)">
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    
                    <!-- Preview de la imagen -->
                    <div class="mt-3">
                        @if(isset($category) && $category->image)
                            <div class="relative inline-block">
                                <img id="image-preview" 
                                     src="{{ asset('storage/' . $category->image) }}" 
                                     alt="Category image"
                                     class="h-32 w-32 object-cover rounded-lg border-2 border-gray-200">
                                <label class="absolute top-0 right-0 bg-red-500 text-white rounded-full p-1 cursor-pointer hover:bg-red-600">
                                    <input type="checkbox" name="remove_image" value="1" class="hidden">
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

                <div class="mb-4">
                    <label class="font-semibold">Estado</label>
                    <select name="is_active" class="w-full border rounded p-2">
                        <option value="1" {{ old('is_active', $category->is_active ?? 1) == 1 ? 'selected' : '' }}>Activa</option>
                        <option value="0" {{ old('is_active', $category->is_active ?? 1) == 0 ? 'selected' : '' }}>Inactiva</option>
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                        Guardar
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
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
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
    @endpush
</x-app-layout>