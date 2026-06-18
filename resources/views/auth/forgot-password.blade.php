<x-front-layout>
    {{-- ============================================================
         ZOLUM SHOP — SOLICITUD DE RECUPERACIÓN DE CONTRASEÑA
         Sistema visual: Brandbook Zolum (Alineado a index.blade.php)
         ============================================================ --}}
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@400;600;700&family=DM+Sans:wght@400;500;700&family=Orbitron:wght@700;800;900&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Sincronización de variables del Brandbook Global de Zolum */
        :root {
            --bg-pure-white:       #FFFFFF;
            --midnight-blue:       #131921;
            --midnight-light:      #1A2536;
            --warm-orange:         #FFC933;
            --warm-orange-hover:   #F3A847;
            --carbon-black:        #0F1111;
            --border-gray:         #D5D9D9;
            --text-muted:          #555555;
            --text-link:           #007185;
            --success-green:       #007600;
            --error-red:           #B12704;
            --font-technical:      'Chakra Petch', sans-serif;
            --font-display:        'Orbitron', sans-serif;
            --font-sans:           'DM Sans', sans-serif;
            --radius:              4px;
        }

        .zl-font-display { font-family: var(--font-display); }
        .zl-font-technical { font-family: var(--font-technical); }
        .zl-font-sans { font-family: var(--font-sans); }
    </style>

    <section class="min-h-[80vh] bg-[#F4F6F6] flex items-center justify-center py-16 px-4 zl-font-sans">

        <div class="relative w-full max-w-md">

            {{-- Card de estilo Zolum (Limpio con Bordes e Identidad Corporativa) --}}
            <div class="bg-white border border-[#D5D9D9] rounded-[4px] shadow-[0_1px_4px_rgba(0,0,0,.08),0_2px_12px_rgba(0,0,0,.04)] overflow-hidden">

                {{-- Barra de acento corporativo superior (Midnight Blue) --}}
                <div class="h-1.5 w-full bg-[#131921]"></div>

                <div class="px-8 pt-8 pb-10">

                    {{-- Header / Logotipo --}}
                    <div class="text-center mb-6">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-[#131921] border border-[#D5D9D9] rounded-[4px] mb-3 tracking-wider text-lg font-bold text-[#FFC933] shadow-sm zl-font-display">
                            ZR
                        </div>
                        <h1 class="text-xl font-bold text-[#131921] tracking-wide uppercase zl-font-display">
                            Restablecer clave
                        </h1>
                        <p class="text-[#555555] text-[11px] mt-1 uppercase tracking-widest zl-font-technical font-semibold">
                            Solicitar enlace de recuperación
                        </p>
                    </div>

                    {{-- Estado de la Sesión / Éxito (Sincronizado con zc-alert--success) --}}
                    @if (session('status'))
                        <div class="mb-5 bg-[#EAF7EA] border border-[#B5D9B5] text-[#007600] text-[13px] rounded-[4px] p-4 zl-font-technical font-semibold">
                            <div class="flex items-center gap-2 font-bold mb-1 uppercase tracking-wider">
                                <span class="bg-[#007600] text-white text-[10px] px-1.5 py-0.5 rounded-[2px]">OK</span> 
                                Envío Exitoso:
                            </div>
                            <span class="opacity-95 font-normal font-sans text-xs block mt-1">{{ session('status') }}</span>
                        </div>
                    @endif

                    {{-- Alertas de Error del Sistema (Sincronizado con zc-alert--error) --}}
                    @if ($errors->any())
                        <div class="mb-5 bg-[#FEF0ED] border border-[#F5C6BB] text-[#B12704] text-[13px] rounded-[4px] p-4 zl-font-technical font-semibold">
                            <div class="flex items-center gap-2 font-bold mb-1 uppercase tracking-wider">
                                <span class="bg-[#B12704] text-white text-[10px] px-1.5 py-0.5 rounded-[2px]">Error</span> 
                                No se pudo procesar:
                            </div>
                            <ul class="list-disc list-inside space-y-0.5 opacity-95 mt-1 font-normal font-sans text-xs">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Formulario --}}
                    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                        @csrf

                        {{-- Input: Email --}}
                        <div>
                            <label for="email" class="block text-[11px] font-bold text-[#555555] uppercase tracking-wider mb-1.5 zl-font-technical">
                                Cuenta de Usuario (Correo)
                            </label>
                            <div class="relative">
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="ejemplo@zolum.com"
                                    required
                                    autofocus
                                    class="w-full px-3 py-2 bg-[#FAFAFA] border border-[#D5D9D9] rounded-[4px] text-sm text-[#0F1111] placeholder-[#B0B0B0] focus:outline-none focus:border-[#FFC933] focus:ring-1 focus:ring-[#FFC933] transition duration-150 @error('email') border-[#B12704] focus:ring-[#B12704] @enderror"
                                >
                            </div>
                        </div>

                        {{-- Botón de Acción Principal (Sincronizado con .zc-checkout-btn) --}}
                        <button
                            type="submit"
                            class="w-full bg-[#FFC933] hover:bg-[#F3A847] border border-[#A88734] text-[#0F1111] font-bold py-2.5 px-4 rounded-[4px] transition duration-150 text-xs tracking-wide uppercase zl-font-display"
                        >
                            Enviar Enlace de Recuperación
                        </button>
                    </form>

                    {{-- Divisor Técnico --}}
                    <div class="flex items-center gap-3 my-5">
                        <div class="flex-1 h-px bg-[#E5E7EB]"></div>
                        <span class="text-[10px] text-[#555555] font-semibold zl-font-technical uppercase tracking-widest">O</span>
                        <div class="flex-1 h-px bg-[#E5E7EB]"></div>
                    </div>

                    {{-- Retorno al Login --}}
                    <p class="text-center text-xs text-[#555555]">
                        ¿Recordaste tus credenciales?
                        <a href="{{ route('login') }}" class="text-[#007185] font-bold hover:text-[#005F70] transition hover:underline block mt-1 zl-font-technical uppercase tracking-wider text-[11px]">
                            Volver al Inicio de Sesión
                        </a>
                    </p>

                </div>
            </div>

            {{-- Estado del Proceso (Micro-información inferior) --}}
            <div class="mt-6 flex items-center justify-center gap-5 text-[10px] text-[#555555] font-semibold zl-font-technical uppercase tracking-wider">
                <span class="flex items-center gap-1"><span class="text-[#007600]">■</span> RECOVERY_MODE</span>
                <span class="flex items-center gap-1"><span class="text-[#007600]">■</span> MAIL_GATEWAY</span>
            </div>

        </div>
    </section>
</x-front-layout>