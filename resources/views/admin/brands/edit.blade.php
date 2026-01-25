<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Marca
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow sm:rounded-lg p-6">

                <form action="{{ route('brands.update', $brand) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    {{-- Nombre --}}
                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Nombre</label>
                        <input type="text" name="name" value="{{ $brand->name }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    {{-- Logo --}}
                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Logo</label>
                        <input type="file" name="logo" class="w-full border-gray-300 rounded-md shadow-sm">

                        @if($brand->logo)
                            <img src="{{ asset('storage/' . $brand->logo) }}" class="h-16 mt-2 rounded border shadow">
                        @endif
                    </div>

                    {{-- Estado --}}
                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Estado</label>
                        <select name="is_active" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="1" {{ $brand->is_active ? 'selected' : '' }}>Activa</option>
                            <option value="0" {{ !$brand->is_active ? 'selected' : '' }}>Inactiva</option>
                        </select>
                    </div>

                    <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                        Actualizar
                    </button>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>