<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            {{ isset($category) ? 'Editar Categoría' : 'Nueva Categoría' }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-3xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white shadow-lg rounded-lg p-6 border">

            <form method="POST"
                  action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}">
                @csrf
                @isset($category)
                    @method('PUT')
                @endisset

                <div class="mb-4">
                    <label class="font-semibold">Nombre</label>
                    <input type="text" name="name"
                           value="{{ $category->name ?? '' }}"
                           class="w-full border rounded p-2">
                </div>

                <div class="mb-4">
                    <label class="font-semibold">Estado</label>
                    <select name="is_active" class="w-full border rounded p-2">
                        <option value="1" {{ isset($category) && $category->is_active ? 'selected' : '' }}>Activa</option>
                        <option value="0" {{ isset($category) && !$category->is_active ? 'selected' : '' }}>Inactiva</option>
                    </select>
                </div>

                <button class="bg-indigo-600 text-white px-4 py-2 rounded">
                    Guardar
                </button>

            </form>

        </div>

    </div>
</x-app-layout>