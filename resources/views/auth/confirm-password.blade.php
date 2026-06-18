<x-front-layout>
    {{-- ============================================================
         ZOLUM SHOP — CONFIRMACIÓN DE CONTRASEÑA
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
                            ZC
                        </div>
                        <h1 class="text-xl font-bold text-[#131921] tracking-wide uppercase zl-font-display">
                            Confirmar Acceso
                        </h1>
                        <p class="text-[#555555] text-[11px] mt-1 uppercase tracking-widest zl-font-technical font-semibold">
                            Zona de Privilegios Elevados
                        </p>
                    </div>

                    {{-- Aviso de Seguridad Estilo Micro-confianza --}}
                    <div class="bg-[#FAFAFA] border-l-2 border-[#007185] rounded-[4px] px-4 py-3 flex items-start gap-3 mb-5">
                        <span class="text-[#007185] text-sm mt-0.5">🔒</span>
                        <p class="text-[11px] text-[#555555] leading-relaxed font-medium uppercase tracking-wide zl-font-technical">
                            Protocolo de seguridad activo: Por favor, re-autentica tus credenciales para proceder con la acción solicitada.
                        </p>
                    </div>

                    {{-- Alertas de Error del Sistema (Sincronizado con zc-alert--error) --}}
                    @if ($errors->any())
                        <div class="mb-5 bg-[#FEF0ED] border border-[#F5C6BB] text-[#B12704] text-[13px] rounded-[4px] p-4 zl-font-technical font-semibold">
                            <div class="flex items-center gap-2 font-bold mb-15 uppercase tracking-wider">
                                <span class="bg-[#B12704] text-white text-[10px] px-1.5 py-0.5 rounded-[2px]">Error</span> 
                                Verificación fallida:
                            </div>
                            <ul class="list-disc list-inside space-y-0.5 opacity-95 mt-1 font-normal font-sans text-xs">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Formulario --}}
                    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
                        @csrf

                        {{-- Input: Contraseña Actual --}}
                        <div>
                            <label for="password" class="block text-[11px] font-bold text-[#555555] uppercase tracking-wider mb-1.5 zl-font-technical">
                                Contraseña del Operador
                            </label>
                            <div class="relative">
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    placeholder="••••••••"
                                    required
                                    autocomplete="current-password"
                                    class="w-full px-3 py-2 bg-[#FAFAFA] border border-[#D5D9D9] rounded-[4px] text-sm text-[#0F1111] placeholder-[#B0B0B0] focus:outline-none focus:border-[#FFC933] focus:ring-1 focus:ring-[#FFC933] transition duration-150 @error('password') border-[#B12704] focus:ring-[#B12704] @enderror"
                                >
                            </div>
                        </div>

                        {{-- Botón de Acción Principal (Sincronizado con .zc-checkout-btn) --}}
                        <button
                            type="submit"
                            class="w-full bg-[#FFC933] hover:bg-[#F3A847] border border-[#A88734] text-[#0F1111] font-bold py-2.5 px-4 rounded-[4px] transition duration-150 text-xs tracking-wide uppercase zl-font-display"
                        >
                            Verificar y Ejecutar
                        </button>
                    </form>

                    {{-- Retorno / Cancelar --}}
                    <div class="mt-6 text-center">
                        <a href="{{ route('login') }}" class="text-xs text-[#007185] font-bold hover:text-[#005F70] transition uppercase tracking-wider zl-font-technical hover:underline">
                            ← Cancelar y Volver
                        </a>
                    </div>

                </div>
            </div>

            {{-- Estado del Terminal (Sección Inferior de micro-información) --}}
            <div class="mt-6 flex items-center justify-center gap-5 text-[10px] text-[#555555] font-semibold zl-font-technical uppercase tracking-wider">
                <span class="flex items-center gap-1"><span class="text-[#007600]">■</span> AUTH_REQUIRED</span>
                <span class="flex items-center gap-1"><span class="text-[#007600]">■</span> SECURITY_CHECK</span>
            </div>

        </div>
    </section>
</x-front-layout>