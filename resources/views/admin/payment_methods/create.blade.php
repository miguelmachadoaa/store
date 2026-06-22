<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Crear Forma de Pago</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <form action="{{ route('payment-methods.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Nombre</label>
                        <input type="text" name="name" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Tipo de Pago</label>
                        <select name="type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="manual">Manual (Efectivo, Transferencia, etc.)</option>
                            <option value="stripe">Stripe Gateway</option>
                            <option value="paypal">PayPal Gateway</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Detalle / Instrucciones</label>
                        <textarea name="description" rows="4" placeholder="Ej: Depositar a la cuenta corriente del banco..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Logo / Icono</label>
                        <input type="file" name="logo" class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Estado</label>
                        <select name="is_active" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="1">Activa</option>
                            <option value="0">Inactiva</option>
                        </select>
                    </div>

                    <div class="flex justify-between items-center mt-6">
                        <a href="{{ route('payment-methods.index') }}" class="text-gray-600 hover:underline">Cancelar</a>
                        <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>