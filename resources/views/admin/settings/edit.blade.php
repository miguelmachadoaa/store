<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Configuración de la Tienda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- Nombre de la tienda --}}
                        <div>
                            <x-input-label for="name" :value="__('Nombre de la Tienda')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                :value="old('name', $setting->name)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        {{-- Logo --}}
                        <div>
                            <x-input-label for="logo" :value="__('Logo')" />

                            @if($setting->logo)
                                <div class="my-2">
                                    <img src="{{ asset('storage/' . $setting->logo) }}" alt="Logo Actual"
                                        class="h-20 w-auto rounded border p-1">
                                </div>
                            @endif

                            <input id="logo" name="logo" type="file" class="mt-1 block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100" />
                            <x-input-error class="mt-2" :messages="$errors->get('logo')" />
                        </div>

                        {{-- Dirección --}}
                        <div>
                            <x-input-label for="address" :value="__('Dirección Física')" />
                            <textarea id="address" name="address"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                rows="3">{{ old('address', $setting->address) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('address')" />
                        </div>

                        {{-- Teléfono --}}
                        <div>
                            <x-input-label for="phone" :value="__('Teléfono de Contacto')" />
                            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                                :value="old('phone', $setting->phone)" />
                            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                        </div>

                        {{-- RIF --}}
                        <div>
                            <x-input-label for="rif" :value="__('RIF')" />
                            <x-text-input id="rif" name="rif" type="text" class="mt-1 block w-full" :value="old('rif', $setting->rif)" />
                            <x-input-error class="mt-2" :messages="$errors->get('rif')" />
                        </div>

                        {{-- Email de Notificaciones --}}
                        <div>
                            <x-input-label for="email" :value="__('Email de Notificaciones')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                :value="old('email', $setting->email)" />
                            <p class="text-sm text-gray-500 mt-1">A este correo llegarán los avisos del sistema.</p>
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Guardar Configuración') }}</x-primary-button>

                            @if (session('status') === 'settings-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition
                                    x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">
                                    {{ __('Guardado.') }}</p>
                            @endif
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>