<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalle de la Reseña') }}
            </h2>
            <a href="{{ route('admin.reviews.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-bold transition">
                Volver al Listado
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        {{-- Información del Usuario --}}
                        <div class="bg-gray-50 p-4 rounded-lg border">
                            <h3 class="font-bold text-gray-700 mb-2 border-b pb-1">Usuario</h3>
                            <p class="text-lg font-semibold">{{ $review->user->name }}</p>
                            <p class="text-sm text-gray-600">{{ $review->user->email }}</p>
                            <div class="mt-2">
                                <span class="text-xs uppercase font-bold text-gray-500">Rol:</span>
                                <span
                                    class="text-xs px-2 py-0.5 bg-gray-200 rounded-full">{{ $review->user->role }}</span>
                            </div>
                        </div>

                        {{-- Información del Producto --}}
                        <div class="bg-gray-50 p-4 rounded-lg border">
                            <h3 class="font-bold text-gray-700 mb-2 border-b pb-1">Producto</h3>
                            <p class="text-lg font-semibold">{{ $review->product->name }}</p>
                            <p class="text-sm text-gray-600">Categoría: {{ $review->product->category->name ?? 'N/A' }}
                            </p>
                            <div class="mt-2">
                                <a href="{{ route('product.detail', $review->product->slug) }}" target="_blank"
                                    class="text-indigo-600 hover:underline text-sm font-medium">
                                    Ver en la tienda →
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Contenido de la Reseña --}}
                    <div class="mb-8 p-6 border rounded-lg">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex text-yellow-400">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-6 h-6 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-300 fill-current' }}"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                            </div>
                            <span class="text-sm text-gray-500">Publicada el
                                {{ $review->created_at->format('d/m/Y H:i') }}</span>
                        </div>

                        <div class="bg-gray-50 p-4 rounded border italic text-gray-700 leading-relaxed">
                            "{{ $review->comment }}"
                        </div>
                    </div>

                    {{-- Acciones --}}
                    <div class="flex items-center justify-end gap-4 border-t pt-6">
                        @if(!$review->is_approved)
                            <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit"
                                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-bold transition">
                                    Aprobar Reseña
                                </button>
                            </form>
                        @else
                            <div class="flex items-center gap-2 text-green-700 font-bold">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                Esta reseña ya está aprobada
                            </div>
                        @endif

                        <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST"
                            onsubmit="return confirm('¿Estás seguro de eliminar esta reseña?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-bold transition">
                                Eliminar Reseña
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>