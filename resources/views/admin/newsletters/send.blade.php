<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold">Enviar Newsletter</h2>
    </x-slot>

    <div class="py-10 max-w-4xl mx-auto">

        <div class="bg-white shadow rounded p-6">

            @if(session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.newsletter.send') }}" method="POST">
                @csrf

                <label class="font-semibold">Contenido del Newsletter</label>
                <textarea name="content" rows="20" class="w-full border rounded p-3" required></textarea>

                <button type="submit" class="mt-4 bg-pink-600 text-white px-4 py-2 rounded hover:bg-pink-700">
                    Enviar a todos los suscriptores
                </button>
            </form>

        </div>

    </div>

</x-app-layout>