<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Sliders / Banners') }}
            </h2>
            <a href="{{ route('sliders.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-md transition duration-150 ease-in-out">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Nuevo Slider
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Mensajes de éxito -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Filtros y búsqueda -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl mb-6 border border-gray-200">
                <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Buscar y Filtrar Sliders
                    </h3>
                </div>
                <div class="p-6">
                    <form method="GET" action="{{ route('sliders.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                            <!-- Campo de búsqueda -->
                            <div class="md:col-span-6">
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                                    Buscar slider
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                    </div>
                                    <input type="text" 
                                           name="search" 
                                           id="search"
                                           value="{{ request('search') }}" 
                                           placeholder="Título, subtítulo o descripción..." 
                                           class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out">
                                </div>
                            </div>

                            <!-- Filtro de estado -->
                            <div class="md:col-span-3">
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                    Estado
                                </label>
                                <select name="status" 
                                        id="status"
                                        class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white transition duration-150 ease-in-out">
                                    <option value="">Todos los estados</option>
                                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Activos</option>
                                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactivos</option>
                                </select>
                            </div>

                            <!-- Botones de acción -->
                            <div class="md:col-span-3 flex items-end gap-2">
                                <button type="submit" 
                                        class="flex-1 inline-flex justify-center items-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-md transition duration-150 ease-in-out">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    Buscar
                                </button>
                                <a href="{{ route('sliders.index') }}" 
                                   class="inline-flex justify-center items-center px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg border border-gray-300 transition duration-150 ease-in-out">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Lista de sliders -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Lista de Sliders</h3>
                        <p class="text-sm text-gray-600 mt-1">
                            @if($sliders->total() > 0)
                                Mostrando {{ $sliders->firstItem() }} - {{ $sliders->lastItem() }} de {{ $sliders->total() }} sliders
                            @else
                                No hay sliders registrados
                            @endif
                        </p>
                    </div>
                    <a href="{{ route('sliders.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-md transition duration-150 ease-in-out">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Crear Slider
                    </a>
                </div>

                <div class="p-6">
                    @if($sliders->count() > 0)
                        <div class="space-y-4">
                            @foreach($sliders as $slider)
                                <div class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition duration-150 overflow-hidden">
                                    <div class="flex flex-col md:flex-row">
                                        <!-- Imagen del slider -->
                                        <div class="md:w-1/3 relative">
                                            <img src="{{ Storage::disk('r2')->url($slider->image) }}" 
                                                 alt="{{ $slider->title }}" 
                                                 class="w-full h-48 md:h-full object-cover">
                                            <div class="absolute top-2 left-2 flex gap-2">
                                                @if($slider->is_active)
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                        Activo
                                                    </span>
                                                @else
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                        Inactivo
                                                    </span>
                                                @endif
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    Orden: {{ $slider->order }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Información del slider -->
                                        <div class="md:w-2/3 p-6">
                                            <div class="flex justify-between items-start mb-4">
                                                <div>
                                                    <h4 class="text-xl font-bold text-gray-900">{{ $slider->title }}</h4>
                                                    @if($slider->subtitle)
                                                        <p class="text-sm text-gray-600 mt-1">{{ $slider->subtitle }}</p>
                                                    @endif
                                                </div>
                                                <div class="flex gap-2">
                                                    <a href="{{ route('sliders.show', $slider) }}" 
                                                       class="inline-flex items-center px-3 py-1.5 bg-indigo-100 text-indigo-700 hover:bg-indigo-200 rounded-lg transition text-sm">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                        </svg>
                                                        Ver
                                                    </a>
                                                    <a href="{{ route('sliders.edit', $slider) }}" 
                                                       class="inline-flex items-center px-3 py-1.5 bg-yellow-100 text-yellow-700 hover:bg-yellow-200 rounded-lg transition text-sm">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                        </svg>
                                                        Editar
                                                    </a>
                                                    <form action="{{ route('sliders.destroy', $slider) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este slider?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg transition text-sm">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                            </svg>
                                                            Eliminar
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>

                                            @if($slider->description)
                                                <p class="text-gray-600 mb-4">{{ Str::limit($slider->description, 150) }}</p>
                                            @endif

                                            <div class="flex flex-wrap gap-2 text-sm text-gray-600">
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                                    </svg>
                                                    Posición: <strong class="ml-1">{{ ucfirst($slider->text_position) }}</strong>
                                                </span>
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                                                    </svg>
                                                    Color texto: <strong class="ml-1">{{ ucfirst($slider->text_color) }}</strong>
                                                </span>
                                                @if($slider->button_text)
                                                    <span class="flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                                        </svg>
                                                        Botón: <strong class="ml-1">{{ $slider->button_text }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Paginación -->
                        <div class="mt-6">
                            {{ $sliders->links() }}
                        </div>
                    @else
                        <div class="text-center py-16">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <h3 class="mt-4 text-lg font-semibold text-gray-900">No hay sliders</h3>
                            <p class="mt-2 text-sm text-gray-500">Comienza creando tu primer slider para la página principal.</p>
                            <div class="mt-6">
                                <a href="{{ route('sliders.create') }}" class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-base font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 transition duration-150 ease-in-out">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Crear Primer Slider
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>