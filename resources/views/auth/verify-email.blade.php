<x-front-layout>
    {{-- ============================================================
         ZOLUM SHOP — VERIFICACIÓN DE CORREO / VERIFY IDENTITY
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
            --warm-orange:         #FEBD69;
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
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-[#131921] border border-[#D5D9D9] rounded-[4px] mb-3 tracking-wider text-lg font-bold text-[#FEBD69] shadow-sm zl-font-display">
                            ZVE
                        </div>
                        <h1 class="text-xl font-bold text-[#131921] tracking-wide uppercase zl-font-display">
                            Verificar Identidad
                        </h1>
                        <p class="text-[#555555] text-[11px] mt-1 uppercase tracking-widest zl-font-technical font-semibold">
                            Esperando confirmación de enlace de seguridad
                        </p>
                    </div>

                    {{-- Estado de Éxito (Reenvío de Token - Sincronizado con zc-alert--success) --}}
                    @if (session('status') == 'verification-link-sent')
                        <div class="mb-5 bg-[#E7F4E4] border border-[#B4DCA1] text-[#007600] text-[13px] rounded-[4px] p-4 zl-font-technical font-semibold">
                            <div class="flex items-center gap-2 font-bold mb-1 uppercase tracking-wider">
                                <span class="bg-[#007600] text-white text-[10px] px-1.5 py-0.5 rounded-[2px]">✓ Enviado</span> 
                                Enlace despachado:
                            </div>
                            <span class="opacity-95 font-normal font-sans text-xs">Un nuevo enlace de verificación ha sido transmitido con éxito a tu bandeja de correo registrada.</span>
                        </div>
                    @endif

                    {{-- Secuencia de Pasos Informativos (Formateado como micro-guía e-commerce) --}}
                    <div class="bg-[#FAFAFA] border border-[#D5D9D9] rounded-[4px] p-4 mb-5 space-y-3 text-xs">
                        <div class="text-[#555555] uppercase tracking-widest font-bold text-[10px] pb-1.5 border-b border-[#E5E7EB] flex items-center justify-between zl-font-technical">
                            <span>Instrucciones de Validación</span>
                            <span class="text-[#007185] font-semibold flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 bg-[#007185] rounded-full animate-pulse"></span> PENDIENTE
                            </span>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-[#131921] font-bold zl-font-technical">[01]</span>
                            <p class="text-[#0F1111] font-medium">Revisa la bandeja de entrada de tu correo electrónico corporativo o personal.</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-[#131921] font-bold zl-font-technical">[02]</span>
                            <p class="text-[#0F1111] font-medium">Localiza la notificación de seguridad enviada por nuestro sistema.</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-[#131921] font-bold zl-font-technical">[03]</span>
                            <p class="text-[#0F1111] font-medium">Haz clic en el botón de confirmación para activar tus credenciales.</p>
                        </div>
                    </div>

                    {{-- Formulario de Reenvío (Estilo .zc-checkout-btn corporativo) --}}
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button
                            type="submit"
                            class="w-full bg-[#FEBD69] hover:bg-[#F3A847] border border-[#A88734] text-[#0F1111] font-bold py-2.5 px-4 rounded-[4px] transition duration-150 text-xs tracking-wide uppercase zl-font-display"
                        >
                            Reenviar Correo de Verificación
                        </button>
                    </form>

                    {{-- Divisor Técnico --}}
                    <div class="flex items-center gap-3 my-5">
                        <div class="flex-1 h-px bg-[#E5E7EB]"></div>
                        <span class="text-[10px] text-[#555555] font-semibold zl-font-technical uppercase tracking-widest">O</span>
                        <div class="flex-1 h-px bg-[#E5E7EB]"></div>
                    </div>

                    {{-- Formulario de Cierre de Sesión / Cancelación --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            type="submit"
                            class="w-full bg-transparent border border-[#D5D9D9] text-[#555555] hover:text-[#B12704] hover:border-[#F5C6BB] hover:bg-[#FEF0ED] font-semibold zl-font-technical text-[11px] py-2 px-4 rounded-[4px] transition duration-150 uppercase tracking-wider"
                        >
                            Desconectar Cuenta Actual
                        </button>
                    </form>

                    {{-- Nota de Advertencia al Consumidor --}}
                    <p class="text-center text-[10.5px] text-[#555555] mt-5 font-medium leading-relaxed">
                        ¿No has recibido el correo electrónico? Revisa tu carpeta de correo no deseado (Spam) o solicita una nueva clave de acceso en el botón superior.
                    </p>

                </div>
            </div>

            {{-- Badges de Validación e Información de Caducidad --}}
            <div class="mt-6 flex items-center justify-center gap-5 text-[10px] text-[#555555] font-semibold zl-font-technical uppercase tracking-wider">
                <span class="flex items-center gap-1"><span class="text-[#007600]">🛡️</span> FILTRO_SPAM_OK</span>
                <span class="flex items-center gap-1"><span class="text-[#B12704]">⏱️</span> EXPIRACION_60_MIN</span>
            </div>

        </div>
    </section>
</x-front-layout>