<x-app-layout>
    <div class="max-w-lg mx-auto py-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Editar Botón</h2>

        <form action="{{ route('admin.links.update', $link->id) }}" method="POST" class="bg-white border rounded-xl p-6 shadow-sm space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Título del Botón</label>
                <input type="text" name="title" required value="{{ old('title', $link->title) }}"
                    class="w-full border border-gray-200 rounded-lg p-2.5 text-sm outline-none focus:ring-1 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">URL Enlace</label>
                <input type="url" name="url" required value="{{ old('url', $link->url) }}"
                    class="w-full border border-gray-200 rounded-lg p-2.5 text-sm outline-none focus:ring-1 focus:ring-indigo-500">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ícono del Botón</label>
                    <select name="icon" class="w-full border border-gray-200 rounded-lg p-2.5 text-sm outline-none focus:ring-1 focus:ring-indigo-500">
                        <option value="">Sin ícono (Cadena estándar)</option>
                        @foreach(\App\Models\Link::commonIcons() as $class => $name)
                            <option value="{{ $class }}" {{ old('icon', $link->icon ?? '') === $class ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Posición / Orden</label>
                    <input type="number" name="sort_order" required value="{{ old('sort_order', $link->sort_order) }}"
                        class="w-full border border-gray-200 rounded-lg p-2.5 text-sm outline-none focus:ring-1 focus:ring-indigo-500">
                </div>
            </div>

            <div class="flex items-center gap-2 pt-2">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ $link->is_active ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <label for="is_active" class="text-sm font-medium text-gray-700">Mantener botón visible</label>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t">
                <a href="{{ route('admin.links.index') }}" class="px-4 py-2 border rounded-lg text-sm text-gray-600 hover:bg-gray-50 transition">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition">Actualizar</button>
            </div>
        </form>
    </div>
</x-app-layout>