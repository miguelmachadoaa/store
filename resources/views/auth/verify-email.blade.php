<x-front-layout>
    <section class="min-h-screen bg-[#0d0e12] flex items-center justify-center py-16 px-4 relative overflow-hidden font-sans">

        {{-- Grid decorativo técnico de fondo --}}
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#1f242e_1px,transparent_1px),linear-gradient(to_bottom,#1f242e_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)] opacity-25 pointer-events-none"></div>
        
        {{-- Resplandor asimétrico de fondo --}}
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[500px] h-[500px] bg-blue-500/10 rounded-full opacity-30 blur-3xl pointer-events-none"></div>

        <div class="relative w-full max-w-md">

            {{-- Card de estilo Industrial / Terminal --}}
            <div class="bg-[#14161d] border border-[#262b36] rounded-sm shadow-2xl overflow-hidden">

                {{-- Barra de acento tecnológico superior (Racing Blue) --}}
                <div class="h-1 w-full bg-blue-600 shadow-[0_2px_10px_rgba(37,99,235,0.5)]"></div>

                <div class="px-8 pt-10 pb-10">

                    {{-- Header / Logotipo --}}
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-[#1b1e26] border border-[#262b36] rounded-sm mb-4 tracking-wider text-xl font-bold text-blue-500 shadow-inner [font-family:'Orbitron',sans-serif]">
                            ENV
                        </div>
                        <h1 class="text-xl font-bold text-white tracking-wider uppercase [font-family:'Orbitron',sans-serif]">
                            Verify Identity
                        </h1>
                        <p class="text-gray-400 text-xs mt-1.5 uppercase tracking-widest font-mono">
                            Awaiting validation token dispatch
                        </p>
                    </div>

                    {{-- Estado de Éxito (Reenvío de Token) --}}
                    @if (session('status') == 'verification-link-sent')
                        <div class="mb-6 bg-emerald-950/40 border border-emerald-800/60 text-emerald-400 text-xs rounded-sm p-4 font-mono">
                            <div class="flex items-center gap-2 font-bold mb-1 uppercase tracking-wider text-emerald-500">
                                <span>✓</span> Token_Dispatched:
                            </div>
                            <span class="opacity-90">A new verification link has been successfully transmitted to your registered gateway.</span>
                        </div>
                    @endif

                    {{-- Secuencia de Pasos en Consola --}}
                    <div class="bg-[#1b1e26] border border-[#262b36] rounded-sm p-4 mb-6 space-y-3 font-mono text-xs">
                        <div class="text-gray-500 uppercase tracking-widest font-bold text-[10px] pb-1 border-b border-[#262b36] flex items-center justify-between">
                            <span>Execution_Sequence</span>
                            <span class="text-blue-500 animate-pulse">● AWAITING</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-blue-500 font-bold">[01]</span>
                            <p class="text-gray-300 uppercase tracking-wide">Access target mail infrastructure</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-blue-500 font-bold">[02]</span>
                            <p class="text-gray-300 uppercase tracking-wide">Locate inbound security transmission</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-blue-500 font-bold">[03]</span>
                            <p class="text-gray-300 uppercase tracking-wide">Execute validation payload link</p>
                        </div>
                    </div>

                    {{-- Formulario de Reenvío --}}
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button
                            type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-500 active:bg-blue-700 text-white font-bold py-3 px-4 rounded-sm transition duration-150 text-xs tracking-widest uppercase shadow-[0_4px_12px_rgba(37,99,235,0.15)] hover:shadow-[0_4px_16px_rgba(37,99,235,0.3)] [font-family:'Orbitron',sans-serif]"
                        >
                            Retransmit Verification Token
                        </button>
                    </form>

                    {{-- Divisor Técnico --}}
                    <div class="flex items-center gap-3 my-5">
                        <div class="flex-1 h-px bg-[#262b36]"></div>
                        <span class="text-[10px] text-gray-500 font-mono uppercase tracking-widest">OR</span>
                        <div class="flex-1 h-px bg-[#262b36]"></div>
                    </div>

                    {{-- Formulario de Cierre de Sesión --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            type="submit"
                            class="w-full bg-transparent border border-[#262b36] text-gray-400 hover:text-red-400 hover:border-red-900/60 font-mono text-xs py-2.5 px-4 rounded-sm transition duration-150 uppercase tracking-wider"
                        >
                            Disconnect Terminal
                        </button>
                    </form>

                    {{-- Nota de Advertencia --}}
                    <p class="text-center text-[10px] text-gray-500 mt-5 font-mono uppercase tracking-wide leading-relaxed">
                        Transmission failure? Inspect junk/spam filters or trigger a structural retransmission above.
                    </p>

                </div>
            </div>

            {{-- Estado del Proceso --}}
            <div class="mt-6 flex items-center justify-center gap-5 text-[10px] text-gray-500 font-mono uppercase tracking-wider">
                <span class="flex items-center gap-1.5"><span class="text-blue-500">■</span> CHECK_SPAM_FILTER</span>
                <span class="flex items-center gap-1.5"><span class="text-blue-500">■</span> EXPIRY_T_MIN_60</span>
            </div>

        </div>
    </section>
</x-front-layout>