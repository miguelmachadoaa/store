<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear Servicio
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-xl border border-gray-200 p-6">
                <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Información Básica --}}
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4 border-b pb-2">Información Básica</h3>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Icono (emoji)</label>
                            <input type="text" name="icon" value="{{ old('icon') }}" placeholder="🚀"
                                class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Descripción Corta</label>
                            <textarea name="short_description" rows="2"
                                class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg">{{ old('short_description') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Descripción Completa</label>
                            <textarea name="description" rows="4"
                                class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    {{-- Hero Section --}}
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4 border-b pb-2">Hero Section</h3>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Título Hero</label>
                            <input type="text" name="hero_title" value="{{ old('hero_title') }}"
                                class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Subtítulo Hero</label>
                            <textarea name="hero_subtitle" rows="2"
                                class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg">{{ old('hero_subtitle') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Imagen Hero</label>
                            <input type="file" name="hero_image" accept="image/*"
                                class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Texto CTA</label>
                                <input type="text" name="hero_cta_text" value="{{ old('hero_cta_text') }}"
                                    placeholder="Comenzar Ahora"
                                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Link CTA</label>
                                <input type="text" name="hero_cta_link" value="{{ old('hero_cta_link') }}"
                                    placeholder="#contacto"
                                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg">
                            </div>
                        </div>
                    </div>

                    {{-- Características --}}
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4 border-b pb-2">Características/Beneficios</h3>
                        <div id="features-container">
                            @for($i = 0; $i < 6; $i++)
                                <div class="mb-2">
                                    <input type="text" name="features[]" value="{{ old('features.' . $i) }}"
                                        placeholder="Característica {{ $i + 1 }}"
                                        class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg">
                                </div>
                            @endfor
                        </div>
                    </div>

                    {{-- Pricing --}}
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4 border-b pb-2">Precio (Opcional)</h3>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Precio</label>
                                <input type="number" step="0.01" name="price" value="{{ old('price') }}"
                                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción del
                                    Precio</label>
                                <input type="text" name="price_description" value="{{ old('price_description') }}"
                                    placeholder="por mes"
                                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg">
                            </div>
                        </div>
                    </div>

                    {{-- Estado --}}
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4 border-b pb-2">Estado y Orden</h3>

                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <span class="ml-2 text-sm text-gray-700">Activo</span>
                                </label>
                            </div>
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <span class="ml-2 text-sm text-gray-700">Destacado</span>
                                </label>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Orden</label>
                                <input type="number" name="order" value="{{ old('order', 0) }}"
                                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg">
                            </div>
                        </div>
                    </div>

                    {{-- SEO --}}
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4 border-b pb-2">SEO</h3>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Meta Title</label>
                            <input type="text" name="meta_title" value="{{ old('meta_title') }}"
                                class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
                            <textarea name="meta_description" rows="2"
                                class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg">{{ old('meta_description') }}</textarea>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('admin.services.index') }}"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded">
                            Crear Servicio
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>