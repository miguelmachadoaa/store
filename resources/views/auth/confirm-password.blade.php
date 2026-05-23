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
                    <div class="text-center mb-6">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-[#1b1e26] border border-[#262b36] rounded-sm mb-4 tracking-wider text-xl font-bold text-blue-500 shadow-inner [font-family:'Orbitron',sans-serif]">
                            SEC
                        </div>
                        <h1 class="text-xl font-bold text-white tracking-wider uppercase [font-family:'Orbitron',sans-serif]">
                            Confirm Access
                        </h1>
                        <p class="text-gray-400 text-xs mt-1.5 uppercase tracking-widest font-mono">
                            Elevated privilege zone
                        </p>
                    </div>

                    {{-- Aviso de Seguridad Industrial --}}
                    <div class="bg-[#1b1e26] border-l-2 border-blue-500 rounded-sm px-4 py-3 flex items-start gap-3 mb-6 font-mono">
                        <span class="text-blue-500 text-sm mt-0.5">⚙️</span>
                        <p class="text-[11px] text-gray-400 leading-relaxed uppercase tracking-wide">
                            Security protocol active: Re-authenticate credentials to proceed with the requested action.
                        </p>
                    </div>

                    {{-- Manejo de Errores del Sistema --}}
                    @if ($errors->any())
                        <div class="mb-6 bg-red-950/40 border border-red-800/60 text-red-400 text-xs rounded-sm p-4 font-mono">
                            <div class="flex items-center gap-2 font-bold mb-1 uppercase tracking-wider text-red-500">
                                <span>⚠️</span> Verification_Failed:
                            </div>
                            <ul class="list-disc list-inside space-y-1 opacity-90">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Formulario --}}
                    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5 font-mono">
                        @csrf

                        {{-- Input: Contraseña Actual --}}
                        <div>
                            <label for="password" class="block text-xs font-bold text-gray-300 uppercase tracking-wider mb-2 [font-family:'Orbitron',sans-serif]">
                                Operator Password
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-3 flex items-center text-gray-500 text-sm pointer-events-none">
                                    ***
                                </span>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    placeholder="••••••••"
                                    required
                                    autocomplete="current-password"
                                    class="w-full pl-12 pr-4 py-2.5 bg-[#1b1e26] border border-[#262b36] rounded-sm text-sm text-white placeholder-gray-600 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-150 @error('password') border-red-500 focus:ring-red-500 @enderror"
                                >
                            </div>
                        </div>

                        {{-- Botón de Confirmación --}}
                        <button
                            type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-500 active:bg-blue-700 text-white font-bold py-3 px-4 rounded-sm transition duration-150 text-xs tracking-widest uppercase shadow-[0_4px_12px_rgba(37,99,235,0.15)] hover:shadow-[0_4px_16px_rgba(37,99,235,0.3)] [font-family:'Orbitron',sans-serif]"
                        >
                            Verify & Execute
                        </button>
                    </form>

                    {{-- Retorno al Login --}}
                    <div class="mt-6 text-center font-mono">
                        <a href="{{ route('login') }}" class="text-xs text-gray-500 hover:text-blue-500 transition uppercase tracking-wider">
                            ← Abort & Return
                        </a>
                    </div>

                </div>
            </div>

            {{-- Estado del Terminal --}}
            <div class="mt-6 flex items-center justify-center gap-5 text-[10px] text-gray-500 font-mono uppercase tracking-wider">
                <span class="flex items-center gap-1.5"><span class="text-blue-500">■</span> AUTH_REQUIRED</span>
                <span class="flex items-center gap-1.5"><span class="text-blue-500">■</span> ID_CHECK</span>
            </div>

        </div>
    </section>
</x-front-layout>