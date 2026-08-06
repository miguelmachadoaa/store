<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Reseña') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.reviews.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <!-- Usuario -->
                        <div>
                            <label for="user_id" class="block text-sm font-medium text-gray-700">Usuario</label>
                            <select name="user_id" id="user_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="">Seleccione un usuario</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Producto -->
                        <div>
                            <label for="product_id" class="block text-sm font-medium text-gray-700">Producto</label>
                            <select name="product_id" id="product_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="">Seleccione un producto</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Valoración -->
                    <div class="mb-4">
                        <label for="rating" class="block text-sm font-medium text-gray-700">Valoración (1 al 5)</label>
                        <select name="rating" id="rating" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            @for($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}" {{ old('rating', 5) == $i ? 'selected' : '' }}>
                                    {{ $i }} ★
                                </option>
                            @endfor
                        </select>
                    </div>

                    <!-- Comentario -->
                    <div class="mb-4">
                        <label for="comment" class="block text-sm font-medium text-gray-700">Comentario</label>
                        <textarea name="comment" id="comment" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>{{ old('comment') }}</textarea>
                    </div>

                    <!-- Imágenes -->
                    <div class="mb-4">
                        <label for="images" class="block text-sm font-medium text-gray-700">Imágenes (opcional)</label>
                        <input type="file" name="images[]" id="images" multiple accept="image/*" class="mt-1 block w-full text-sm text-gray-500">
                    </div>

                    <!-- Estado Aprobado -->
                    <div class="mb-6 flex items-center">
                        <input type="checkbox" name="is_approved" id="is_approved" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm" {{ old('is_approved', 1) ? 'checked' : '' }}>
                        <label for="is_approved" class="ml-2 block text-sm text-gray-900">Aprobar inmediatamente</label>
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('admin.reviews.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Cancelar</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Guardar Reseña</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>