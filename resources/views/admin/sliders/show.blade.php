<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Vista Previa del Slider') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('sliders.edit', $slider) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Editar
                </a>
                <a href="{{ route('sliders.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Vista previa del slider -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl mb-6">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                    <h3 class="text-lg font-semibold text-gray-900">Vista Previa</h3>
                    <p class="text-sm text-gray-600">Así se verá el slider en tu página web</p>
                </div>
                
                <!-- Simulación del slider -->
                <div class="relative h-96 overflow-hidden">
                    <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}" class="w-full h-full object-cover">
                    
                    <!-- Overlay con gradiente -->
                    <div class="absolute inset-0 bg-gradient-to-r from-black/50 to-transparent"></div>
                    
                    <!-- Contenido del slider -->
                    <div class="absolute inset-0 flex {{ $slider->getTextPositionClass() }} p-12">
                        <div class="max-w-2xl {{ $slider->getTextColorClass() }}">
                            <h1 class="text-5xl font-bold mb-4">{{ $slider->title }}</h1>
                            @if($slider->subtitle)
                                <h2 class="text-2xl mb-4 opacity-90">{{ $slider->subtitle }}</h2>
                            @endif
                            @if($slider->description)
                                <p class="text-lg mb-6 opacity-80">{{ $slider->description }}</p>
                            @endif
                            @if($slider->button_text && $slider->button_link)
                                <a href="{{ $slider->button_link }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-lg transition duration-150">
                                    {{ $slider->button_text }}
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Badges de estado -->
                    <div class="absolute top-4 right-4 flex gap-2">
                        @if($slider->is_active)
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                Activo
                            </span>
                        @else
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                                Inactivo
                            </span>
                        @endif
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                            Orden: {{ $slider->order }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Información detallada -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                    <h3 class="text-lg font-semibold text-gray-900">Información del Slider</h3>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Columna izquierda -->
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-sm font-semibold text-gray-700 mb-1">Título</h4>
                                <p class="text-gray-900">{{ $slider->title }}</p>
                            </div>

                            @if($slider->subtitle)
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-700 mb-1">Subtítulo</h4>
                                    <p class="text-gray-900">{{ $slider->subtitle }}</p>
                                </div>
                            @endif

                            @if($slider->description)
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-700 mb-1">Descripción</h4>
                                    <p class="text-gray-900">{{ $slider->description }}</p>
                                </div>
                            @endif

                            <div>
                                <h4 class="text-sm font-semibold text-gray-700 mb-1">Estado</h4>
                                @if($slider->is_active)
                                    <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                        Activo
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full bg-red-100 text-red-800">
                                        Inactivo
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Columna derecha -->
                        <div class="space-y-4">
                            @if($slider->button_text)
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-700 mb-1">Texto del Botón</h4>
                                    <p class="text-gray-900">{{ $slider->button_text }}</p>
                                </div>
                            @endif

                            @if($slider->button_link)
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-700 mb-1">Enlace del Botón</h4>
                                    <a href="{{ $slider->button_link }}" target="_blank" class="text-indigo-600 hover:text-indigo-800">
                                        {{ $slider->button_link }}
                                    </a>
                                </div>
                            @endif

                            <div>
                                <h4 class="text-sm font-semibold text-gray-700 mb-1">Orden de Visualización</h4>
                                <p class="text-gray-900">{{ $slider->order }}</p>
                            </div>

                            <div>
                                <h4 class="text-sm font-semibold text-gray-700 mb-1">Posición del Texto</h4>
                                <p class="text-gray-900">{{ ucfirst($slider->text_position) }}</p>
                            </div>

                            <div>
                                <h4 class="text-sm font-semibold text-gray-700 mb-1">Color del Texto</h4>
                                <p class="text-gray-900">{{ ucfirst($slider->text_color) }}</p>
                            </div>

                            <div>
                                <h4 class="text-sm font-semibold text-gray-700 mb-1">Creado</h4>
                                <p class="text-gray-900">{{ $slider->created_at->format('d/m/Y H:i') }}</p>
                            </div>

                            <div>
                                <h4 class="text-sm font-semibold text-gray-700 mb-1">Última Actualización</h4>
                                <p class="text-gray-900">{{ $slider->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Acciones -->
            <div class="mt-6 flex justify-between items-center">
                <form action="{{ route('sliders.destroy', $slider) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este slider? Esta acción no se puede deshacer.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded">
                        Eliminar Slider
                    </button>
                </form>

                <div class="flex gap-3">
                    <a href="{{ route('sliders.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
                        Volver al Listado
                    </a>
                    <a href="{{ route('sliders.edit', $slider) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded">
                        Editar Slider
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>