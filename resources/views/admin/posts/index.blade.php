<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Artículos del Blog</h2>

            <a href="{{ route('admin.posts.create') }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Nuevo Artículo
            </a>
        </div>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white shadow rounded-lg p-6 border">

            @if(session('success'))
                <div class="mb-4 bg-green-100 text-green-700 px-4 py-2 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Título</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($posts as $post)
                        <tr>
                            <td class="px-6 py-4">{{ $post->title }}</td>

                            <td class="px-6 py-4">
                                @if($post->is_published)
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs">Publicado</span>
                                @else
                                    <span class="px-3 py-1 bg-gray-200 text-gray-700 rounded-full text-xs">Borrador</span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                {{ $post->created_at->format('d/m/Y') }}
                            </td>

                            <td class="px-6 py-4 text-right flex justify-end gap-3">

                                <a href="{{ route('admin.posts.edit', $post) }}"
                                   class="text-indigo-600 hover:underline">
                                    Editar
                                </a>

                                <form action="{{ route('admin.posts.destroy', $post) }}"
                                      method="POST"
                                      onsubmit="return confirm('¿Eliminar artículo?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">Eliminar</button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-6">
                {{ $posts->links() }}
            </div>

        </div>

    </div>

</x-app-layout>