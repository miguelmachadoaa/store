<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Moderación de Reseñas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3">Usuario</th>
                                    <th class="px-6 py-3">Producto</th>
                                    <th class="px-6 py-3">Valoración</th>
                                    <th class="px-6 py-3">Estado</th>
                                    <th class="px-6 py-3">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reviews as $review)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-gray-900">{{ $review->user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $review->user->email }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('product.detail', $review->product->slug) }}" target="_blank"
                                                class="text-indigo-600 hover:underline">
                                                {{ $review->product->name }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex text-yellow-400">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-300 fill-current' }}"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                @endfor
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($review->is_approved)
                                                <span
                                                    class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">Aprobada</span>
                                            @else
                                                <span
                                                    class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded">Pendiente</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('admin.reviews.show', $review->id) }}"
                                                    class="text-white bg-indigo-600 hover:bg-indigo-700 px-3 py-1 rounded text-xs transition">
                                                    Ver Detalle
                                                </a>

                                                @if(!$review->is_approved)
                                                    <form action="{{ route('admin.reviews.approve', $review->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit"
                                                            class="text-white bg-green-600 hover:bg-green-700 px-3 py-1 rounded text-xs transition">
                                                            Aprobar
                                                        </button>
                                                    </form>
                                                @endif

                                                <form action="{{ route('admin.reviews.destroy', $review->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('¿Estás seguro de eliminar esta reseña?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-xs transition">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $reviews->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>