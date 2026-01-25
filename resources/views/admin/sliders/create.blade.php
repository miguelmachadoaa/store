<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Crear Slider / Banner') }}
            </h2>
            <a href="{{ route('sliders.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('sliders.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Título -->
                            <div class="md:col-span-2">
                                <label for="title" class="block text-sm font-medium text-gray-700">Título *</label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('title') border-red-500 @enderror">
                                @error('title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Subtítulo -->
                            <div class="md:col-span-2">
                                <label for="subtitle" class="block text-sm font-medium text-gray-700">Subtítulo</label>
                                <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('subtitle') border-red-500 @enderror">
                                @error('subtitle')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Descripción -->
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                                <textarea name="description" id="description" rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Imagen -->
                            <div class="md:col-span-2">
                                <label for="image" class="block text-sm font-medium text-gray-700">Imagen del Slider *</label>
                                <input type="file" name="image" id="image" accept="image/*" required
                                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('image') border-red-500 @enderror">
                                <p class="mt-1 text-sm text-gray-500">Recomendado: 1920x600px. Máximo 5MB. Formatos: JPG, PNG, GIF, WebP</p>
                                @error('image')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Texto del botón -->
                            <div>
                                <label for="button_text" class="block text-sm font-medium text-gray-700">Texto del Botón</label>
                                <input type="text" name="button_text" id="button_text" value="{{ old('button_text') }}" placeholder="Ej: Ver más"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('button_text') border-red-500 @enderror">
                                @error('button_text')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Enlace del botón -->
                            <div>
                                <label for="button_link" class="block text-sm font-medium text-gray-700">Enlace del Botón</label>
                                <input type="url" name="button_link" id="button_link" value="{{ old('button_link') }}" placeholder="https://ejemplo.com"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('button_link') border-red-500 @enderror">
                                @error('button_link')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Orden -->
                            <div>
                                <label for="order" class="block text-sm font-medium text-gray-700">Orden de Visualización</label>
                                <input type="number" name="order" id="order" value="{{ old('order', 0) }}" min="0"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('order') border-red-500 @enderror">
                                <p class="mt-1 text-sm text-gray-500">Menor número = mayor prioridad</p>
                                @error('order')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Posición del texto -->
                            <div>
                                <label for="text_position" class="block text-sm font-medium text-gray-700">Posición del Texto *</label>
                                <select name="text_position" id="text_position" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('text_position') border-red-500 @enderror">
                                    <option value="left" {{ old('text_position') === 'left' ? 'selected' : '' }}>Izquierda</option>
                                    <option value="center" {{ old('text_position') === 'center' ? 'selected' : '' }}>Centro</option>
                                    <option value="right" {{ old('text_position') === 'right' ? 'selected' : '' }}>Derecha</option>
                                </select>
                                @error('text_position')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Color del texto -->
                            <div>
                                <label for="text_color" class="block text-sm font-medium text-gray-700">Color del Texto *</label>
                                <select name="text_color" id="text_color" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('text_color') border-red-500 @enderror">
                                    <option value="dark" {{ old('text_color') === 'dark' ? 'selected' : '' }}>Oscuro</option>
                                    <option value="light" {{ old('text_color') === 'light' ? 'selected' : '' }}>Claro</option>
                                </select>
                                <p class="mt-1 text-sm text-gray-500">Elige según el fondo de la imagen</p>
                                @error('text_color')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Checkbox Activo -->
                            <div class="md:col-span-2">
                                <div class="flex items-center">
                                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                        Slider Activo (visible en la página)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="mt-6 flex items-center justify-end gap-x-4">
                            <a href="{{ route('sliders.index') }}" class="text-sm font-semibold leading-6 text-gray-900">
                                Cancelar
                            </a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded">
                                Crear Slider
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>