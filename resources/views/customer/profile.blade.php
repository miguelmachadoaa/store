<x-customer-layout>
    <div class="bg-white shadow rounded-lg p-6 border border-gray-100 max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Mi Perfil</h2>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('customer.profile.update') }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label class="block font-semibold mb-1">Nombre Completo</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="w-full border rounded-lg p-2 @error('name') border-red-500 @enderror" required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Correo Electrónico</label>
                <input type="email" value="{{ $user->email }}"
                    class="w-full border rounded-lg p-2 bg-gray-50 text-gray-500" readonly>
                <p class="text-gray-400 text-xs mt-1 italic">El correo no puede ser modificado.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block font-semibold mb-1">Teléfono</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                        class="w-full border rounded-lg p-2 @error('phone') border-red-500 @enderror">
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block font-semibold mb-1">C.I. / RIF</label>
                    <input type="text" name="rif" value="{{ old('rif', $user->rif) }}"
                        class="w-full border rounded-lg p-2 @error('rif') border-red-500 @enderror">
                    @error('rif')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label class="block font-semibold mb-1">Dirección de Envío</label>
                <textarea name="address" rows="3"
                    class="w-full border rounded-lg p-2 @error('address') border-red-500 @enderror">{{ old('address', $user->address) }}</textarea>
                @error('address')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="text-right">
                <button type="submit"
                    class="bg-pink-600 text-white px-8 py-3 rounded-xl hover:bg-pink-700 font-bold transition shadow-lg">
                    Guardar Cambios
                </button>
            </div>
        </form>

        <hr class="my-8 border-gray-100">

        <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="font-bold text-gray-800 mb-2">Cambiar Contraseña</h3>
            <p class="text-sm text-gray-600 mb-4">Si deseas cambiar tu contraseña, puedes hacerlo desde la configuración
                de seguridad de tu cuenta.</p>
            <a href="{{ route('profile.edit') }}" class="text-indigo-600 hover:underline font-medium text-sm">
                Ir a configuración avanzada de seguridad →
            </a>
        </div>
    </div>
</x-customer-layout>