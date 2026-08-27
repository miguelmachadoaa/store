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
                                    <img src="{{ Storage::disk('r2')->url($setting->logo) }}" alt="Logo Actual"
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

                        {{-- WhatsApp --}}
                        <div>
                            <x-input-label for="whatsapp" :value="__('Número de WhatsApp')" />
                            <x-text-input id="whatsapp" name="whatsapp" type="text" class="mt-1 block w-full"
                                :value="old('whatsapp', $setting->whatsapp)" placeholder="Ej: 04141234567 o 584141234567" />
                            <p class="text-sm text-gray-500 mt-1">Número donde recibirás los pedidos directos del carrito.</p>
                            <x-input-error class="mt-2" :messages="$errors->get('whatsapp')" />
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

                        {{-- Preferencia de Moneda --}}
                        <div>
                            <x-input-label for="currency_preference" :value="__('Mostrar Precios En')" />
                            <select id="currency_preference" name="currency_preference"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="both" {{ old('currency_preference', $setting->currency_preference) == 'both' ? 'selected' : '' }}>Ambas Monedas (USD y Bs)
                                </option>
                                <option value="usd" {{ old('currency_preference', $setting->currency_preference) == 'usd' ? 'selected' : '' }}>Solo Dólares (USD)</option>
                                <option value="bs" {{ old('currency_preference', $setting->currency_preference) == 'bs' ? 'selected' : '' }}>Solo Bolívares (Bs)</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('currency_preference')" />
                        </div>

                        {{-- Integración con Brevo (Sendinblue) --}}
                        <div>
                            <x-input-label for="use_brevo" :value="__('Integración con Brevo (Sendinblue)')" />
                            <select id="use_brevo" name="use_brevo"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="0" {{ old('use_brevo', $setting->use_brevo) == '0' ? 'selected' : '' }}>
                                    Desactivado</option>
                                <option value="1" {{ old('use_brevo', $setting->use_brevo) == '1' ? 'selected' : '' }}>
                                    Activado</option>
                            </select>
                            <p class="text-sm text-gray-500 mt-1">Si se activa, los usuarios se sincronizarán con Brevo al registrarse.</p>
                            <x-input-error class="mt-2" :messages="$errors->get('use_brevo')" />
                        </div>

                        {{-- Sección Linktree Personalización (Corregida a $setting) --}}
                        <div class="bg-white border rounded-xl p-6 shadow-sm space-y-6 mt-6">
                            <h3 class="text-lg font-bold text-gray-800 border-b pb-2">Personalización Visual del Linktree</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Logo exclusivo para Linktree --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Logo del Linktree</label>
                                    @if($setting->linktree_logo)
                                        <div class="my-2">
                                            <img src="{{ Storage::disk('r2')->url($setting->linktree_logo) }}" class="w-16 h-16 object-cover rounded-full border shadow-sm">
                                        </div>
                                    @endif
                                    <input type="file" name="linktree_logo" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                    <p class="text-xs text-gray-400 mt-1">Si se deja vacío, se usará el imagotipo general de la tienda.</p>
                                </div>

                                {{-- Tipo de Fondo --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Fondo</label>
                                    <select name="linktree_bg_type" id="bg_type_select" onchange="toggleBgInputs()" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                        <option value="gradient" {{ old('linktree_bg_type', $setting->linktree_bg_type) == 'gradient' ? 'selected' : '' }}>Gradiente Continuo</option>
                                        <option value="solid" {{ old('linktree_bg_type', $setting->linktree_bg_type) == 'solid' ? 'selected' : '' }}>Color Sólido</option>
                                        <option value="image" {{ old('linktree_bg_type', $setting->linktree_bg_type) == 'image' ? 'selected' : '' }}>Imagen de Fondo</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Variables de colores Dinámicos --}}
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div id="div_bg_color">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Color Principal / Fondo</label>
                                    <input type="color" name="linktree_bg_color" value="{{ old('linktree_bg_color', $setting->linktree_bg_color ?? '#111827') }}" class="w-full h-10 p-1 rounded-lg border border-gray-200 cursor-pointer">
                                </div>

                                <div id="div_bg_gradient_to">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Gradiente (Hacia)</label>
                                    <input type="color" name="linktree_bg_gradient_to" value="{{ old('linktree_bg_gradient_to', $setting->linktree_bg_gradient_to ?? '#312e81') }}" class="w-full h-10 p-1 rounded-lg border border-gray-200 cursor-pointer">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Fondo de los Botones</label>
                                    <input type="text" name="linktree_button_bg" value="{{ old('linktree_button_bg', $setting->linktree_button_bg ?? 'rgba(255,255,255,0.1)') }}" placeholder="Ej: #ffffff o rgba(255,255,255,0.1)" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm p-2 text-sm">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Texto del Botón</label>
                                    <input type="color" name="linktree_button_text" value="{{ old('linktree_button_text', $setting->linktree_button_text ?? '#ffffff') }}" class="w-full h-10 p-1 rounded-lg border border-gray-200 cursor-pointer">
                                </div>
                            </div>

                            <div id="div_bg_image" class="hidden">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Imagen de Fondo Personalizada</label>
                                @if($setting->linktree_bg_image)
                                    <div class="w-32 h-20 bg-cover bg-center rounded mb-2 border shadow-sm" style="background-image: url('{{ Storage::disk('r2')->url($setting->linktree_bg_image) }}')"></div>
                                @endif
                                <input type="file" name="linktree_bg_image" accept="image/*" class="w-full text-sm text-gray-500 file:bg-indigo-50 file:text-indigo-700 file:rounded-full file:border-0 file:px-4 file:py-2">
                            </div>
                        </div>

                        {{-- Botón Guardar --}}
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Guardar Configuración') }}</x-primary-button>

                            @if (session('status') === 'settings-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition
                                    x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">
                                    {{ __('Guardado.') }}
                                </p>
                            @endif
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleBgInputs() {
            const selectElement = document.getElementById('bg_type_select');
            if (!selectElement) return;
            
            const type = selectElement.value;
            
            const divGradientTo = document.getElementById('div_bg_gradient_to');
            const divBgImage = document.getElementById('div_bg_image');

            if (divGradientTo) {
                divGradientTo.style.display = (type === 'gradient') ? 'block' : 'none';
            }
            if (divBgImage) {
                divBgImage.classList.toggle('hidden', type !== 'image');
            }
        }
        document.addEventListener("DOMContentLoaded", toggleBgInputs);
    </script>
</x-app-layout>