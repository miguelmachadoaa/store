<x-customer-layout>
    <div style="background-color: var(--bg-pure-white); border: 1px solid var(--border-gray); border-radius: 4px; box-shadow: 0 1px 4px rgba(0,0,0,.08); overflow: hidden; color: var(--carbon-black); max-width: 720px; margin: 0 auto;">
        
        {{-- Barra de acento superior de la marca --}}
        <div style="height: 6px; width: 100%; background-color: var(--midnight-blue);"></div>

        <div style="padding: 2rem;">
            
            {{-- Encabezado del Módulo --}}
            <div style="margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 1px solid #E5E7EB;">
                <h2 class="zl-font-display" style="font-size: 22px; font-weight: 700; color: var(--midnight-blue); margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">
                    Mi Perfil
                </h2>
                <p class="zl-font-technical" style="font-size: 11px; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin: 0.25rem 0 0 0;">
                    Administración de datos del perfil comercial y credenciales de entrega
                </p>
            </div>

            {{-- Mensaje de Éxito de Sesión --}}
            @if(session('success'))
                <div class="zl-font-technical" style="background-color: #E7F4E4; border: 1px solid #B4DCA1; color: var(--success-green); padding: 1rem 1.25rem; border-radius: 4px; margin-bottom: 1.5rem; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                    ✓ {{ session('success') }}
                </div>
            @endif

            {{-- Formulario de Actualización de Perfil --}}
            <form action="{{ route('customer.profile.update') }}" method="POST">
                @csrf
                @method('PATCH')

                {{-- Campo: Nombre Completo --}}
                <div style="margin-bottom: 1.25rem;">
                    <label class="zl-font-technical" style="display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--carbon-black); margin-bottom: 0.5rem;">
                        Nombre Completo
                    </label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                           style="width: 100%; box-sizing: border-box; border: 1px solid {{ $errors->has('name') ? 'var(--error-red)' : 'var(--border-gray)' }}; border-radius: 4px; padding: 0.65rem 0.75rem; font-size: 14px; color: var(--carbon-black); background-color: #FFFFFF; transition: border-color 0.2s;" 
                           onfocus="this.style.borderColor='var(--midnight-blue)';" 
                           onblur="this.style.borderColor='{{ $errors->has('name') ? 'var(--error-red)' : 'var(--border-gray)' }}';" 
                           required>
                    @error('name')
                        <p class="zl-font-technical" style="color: var(--error-red); font-size: 11px; font-weight: 600; margin: 0.35rem 0 0 0; text-transform: uppercase;">
                            ⚠ {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Campo: Correo Electrónico (Solo Lectura) --}}
                <div style="margin-bottom: 1.25rem;">
                    <label class="zl-font-technical" style="display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-muted); margin-bottom: 0.5rem;">
                        Correo Electrónico
                    </label>
                    <input type="email" value="{{ $user->email }}"
                           style="width: 100%; box-sizing: border-box; border: 1px solid var(--border-gray); border-radius: 4px; padding: 0.65rem 0.75rem; font-size: 14px; color: #7F8C8D; background-color: #F5F7F8; cursor: not-allowed;" 
                           readonly>
                    <p style="color: var(--text-muted); font-size: 12px; font-style: italic; margin: 0.35rem 0 0 0;">
                        El correo electrónico institucional no puede ser modificado por políticas de auditoría.
                    </p>
                </div>

                {{-- Bloque de Dos Columnas: Teléfono e Identificación --}}
                <div style="display: flex; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.25rem;">
                    {{-- Campo: Teléfono --}}
                    <div style="flex: 1 1 calc(50% - 0.5rem); min-width: 250px;">
                        <label class="zl-font-technical" style="display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--carbon-black); margin-bottom: 0.5rem;">
                            Teléfono
                        </label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                               style="width: 100%; box-sizing: border-box; border: 1px solid {{ $errors->has('phone') ? 'var(--error-red)' : 'var(--border-gray)' }}; border-radius: 4px; padding: 0.65rem 0.75rem; font-size: 14px; color: var(--carbon-black); background-color: #FFFFFF; transition: border-color 0.2s;" 
                               onfocus="this.style.borderColor='var(--midnight-blue)';" 
                               onblur="this.style.borderColor='{{ $errors->has('phone') ? 'var(--error-red)' : 'var(--border-gray)' }}';">
                        @error('phone')
                            <p class="zl-font-technical" style="color: var(--error-red); font-size: 11px; font-weight: 600; margin: 0.35rem 0 0 0; text-transform: uppercase;">
                                ⚠ {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    {{-- Campo: C.I. / RIF --}}
                    <div style="flex: 1 1 calc(50% - 0.5rem); min-width: 250px;">
                        <label class="zl-font-technical" style="display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--carbon-black); margin-bottom: 0.5rem;">
                            C.I. / RIF
                        </label>
                        <input type="text" name="rif" value="{{ old('rif', $user->rif) }}"
                               style="width: 100%; box-sizing: border-box; border: 1px solid {{ $errors->has('rif') ? 'var(--error-red)' : 'var(--border-gray)' }}; border-radius: 4px; padding: 0.65rem 0.75rem; font-size: 14px; color: var(--carbon-black); background-color: #FFFFFF; transition: border-color 0.2s;" 
                               onfocus="this.style.borderColor='var(--midnight-blue)';" 
                               onblur="this.style.borderColor='{{ $errors->has('rif') ? 'var(--error-red)' : 'var(--border-gray)' }}';">
                        @error('rif')
                            <p class="zl-font-technical" style="color: var(--error-red); font-size: 11px; font-weight: 600; margin: 0.35rem 0 0 0; text-transform: uppercase;">
                                ⚠ {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                {{-- Campo: Dirección de Envío --}}
                <div style="margin-bottom: 1.5rem;">
                    <label class="zl-font-technical" style="display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--carbon-black); margin-bottom: 0.5rem;">
                        Dirección de Envío
                    </label>
                    <textarea name="address" rows="3"
                              style="width: 100%; box-sizing: border-box; border: 1px solid {{ $errors->has('address') ? 'var(--error-red)' : 'var(--border-gray)' }}; border-radius: 4px; padding: 0.65rem 0.75rem; font-size: 14px; color: var(--carbon-black); background-color: #FFFFFF; font-family: inherit; resize: vertical; transition: border-color 0.2s;" 
                              onfocus="this.style.borderColor='var(--midnight-blue)';" 
                              onblur="this.style.borderColor='{{ $errors->has('address') ? 'var(--error-red)' : 'var(--border-gray)' }}';">{{ old('address', $user->address) }}</textarea>
                    @error('address')
                        <p class="zl-font-technical" style="color: var(--error-red); font-size: 11px; font-weight: 600; margin: 0.35rem 0 0 0; text-transform: uppercase;">
                            ⚠ {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Botón Enviar Formulario --}}
                <div style="text-align: right; margin-bottom: 2rem;">
                    <button type="submit"
                            class="zl-font-technical"
                            style="background-color: var(--warm-orange); border: 1px solid var(--warm-orange-hover); color: var(--carbon-black); padding: 0.75rem 2rem; border-radius: 4px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; cursor: pointer; transition: background-color 0.2s;"
                            onmouseover="this.style.backgroundColor='var(--warm-orange-hover)';"
                            onmouseout="this.style.backgroundColor='var(--warm-orange)';">
                        Guardar Cambios
                    </button>
                </div>
            </form>

            <hr style="border: 0; border-top: 1px solid #E5E7EB; margin: 2rem 0;">

            {{-- Panel de Acceso a Configuración de Seguridad --}}
            <div style="background-color: #FAFAFA; border: 1px solid var(--border-gray); border-radius: 4px; padding: 1.25rem;">
                <h3 class="zl-font-display" style="font-size: 14px; font-weight: 700; color: var(--midnight-blue); margin: 0 0 0.5rem 0; text-transform: uppercase; letter-spacing: 0.5px;">
                    Cambiar Contraseña
                </h3>
                <p style="color: var(--text-muted); font-size: 13px; margin: 0 0 1rem 0; line-height: 1.5;">
                    Si requieres renovar tus credenciales o actualizar tus parámetros de autenticación, por favor dirígete al panel unificado de control de accesos.
                </p>
                <a href="{{ route('profile.edit') }}" 
                   class="zl-font-technical"
                   style="color: var(--text-link); font-size: 12px; font-weight: 700; text-decoration: none; text-transform: uppercase; letter-spacing: 0.5px; display: inline-flex; align-items: center;"
                   onmouseover="this.style.textDecoration='underline'"
                   onmouseout="this.style.textDecoration='none'">
                    Ir a configuración avanzada de seguridad &rarr;
                </a>
            </div>
        </div>
    </div>
</x-customer-layout>