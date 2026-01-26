<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold">Suscriptores del Newsletter</h2>
    </x-slot>

    <div class="py-10 max-w-5xl mx-auto">

        <div class="bg-white shadow rounded p-6">

            <table class="w-full">
                <thead>
                    <tr class="border-b">
                        <th class="p-3 text-left">Email</th>
                        <th class="p-3 text-left">Fecha</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($subscribers as $item)
                        <tr class="border-b">
                            <td class="p-3">{{ $item->email }}</td>
                            <td class="p-3">{{ $item->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

    </div>

</x-app-layout>