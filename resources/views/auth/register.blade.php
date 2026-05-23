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
                            REG
                        </div>
                        <h1 class="text-xl font-bold text-white tracking-wider uppercase [font-family:'Orbitron',sans-serif]">
                            Initialize Profile
                        </h1>
                        <p class="text-gray-400 text-xs mt-1.5 uppercase tracking-widest font-mono">
                            Register new terminal identity
                        </p>
                    </div>

                    {{-- Manejo de Errores del Sistema --}}
                    @if ($errors->any())
                        <div class="mb-6 bg-red-950/40 border border-red-800/60 text-red-400 text-xs rounded-sm p-4 font-mono">
                            <div class="flex items-center gap-2 font-bold mb-1 uppercase tracking-wider text-red-500">
                                <span>⚠️</span> Registration_Error:
                            </div>
                            <ul class="list-disc list-inside space-y-1 opacity-90">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Formulario --}}
                    <form action="{{ route('register') }}" method="POST" class="space-y-5 font-mono">
                        @csrf

                        {{-- Input: Nombre Completo --}}
                        <div>
                            <label for="name" class="block text-xs font-bold text-gray-300 uppercase tracking-wider mb-2 [font-family:'Orbitron',sans-serif]">
                                Operator Full Name
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-3 flex items-center text-gray-500 text-sm pointer-events-none">
                                    [FN]
                                </span>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="John Doe"
                                    required
                                    autofocus
                                    class="w-full pl-12 pr-4 py-2.5 bg-[#1b1e26] border border-[#262b36] rounded-sm text-sm text-white placeholder-gray-600 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-150 @error('name') border-red-500 focus:ring-red-500 @enderror"
                                >
                            </div>
                        </div>

                        {{-- Input: Email --}}
                        <div>
                            <label for="email" class="block text-xs font-bold text-gray-300 uppercase tracking-wider mb-2 [font-family:'Orbitron',sans-serif]">
                                Assigned Email Address
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-3 flex items-center text-gray-500 text-sm pointer-events-none">
                                    [ID]
                                </span>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="operator@company.com"
                                    required
                                    class="w-full pl-12 pr-4 py-2.5 bg-[#1b1e26] border border-[#262b36] rounded-sm text-sm text-white placeholder-gray-600 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-150 @error('email') border-red-500 focus:ring-red-500 @enderror"
                                >
                            </div>
                        </div>

                        {{-- Contenedor de Contraseñas --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                            {{-- Password --}}
                            <div>
                                <label for="password" class="block text-xs font-bold text-gray-300 uppercase tracking-wider mb-2 [font-family:'Orbitron',sans-serif]">
                                    Access Key
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
                                        class="w-full pl-12 pr-4 py-2.5 bg-[#1b1e26] border border-[#262b36] rounded-sm text-sm text-white placeholder-gray-600 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-150 @error('password') border-red-500 focus:ring-red-500 @enderror"
                                    >
                                </div>
                            </div>

                            {{-- Confirm Password --}}
                            <div>
                                <label for="password_confirmation" class="block text-xs font-bold text-gray-300 uppercase tracking-wider mb-2 [font-family:'Orbitron',sans-serif]">
                                    Confirm Key
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-500 text-sm pointer-events-none">
                                        ✓✓
                                    </span>
                                    <input
                                        type="password"
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        placeholder="••••••••"
                                        required
                                        class="w-full pl-12 pr-4 py-2.5 bg-[#1b1e26] border border-[#262b36] rounded-sm text-sm text-white placeholder-gray-600 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-150"
                                    >
                                </div>
                            </div>
                        </div>

                        {{-- Sugerencia de Requisitos --}}
                        <p class="text-[11px] text-gray-500 -mt-2 uppercase tracking-wide">
                            Requirement: Min 8 alphanumeric characters.
                        </p>

                        {{-- Checkbox: Términos y Condiciones --}}
                        <div class="flex items-start gap-2.5 pt-1">
                            <input
                                type="checkbox"
                                id="terms"
                                name="terms"
                                required
                                class="mt-0.5 w-3.5 h-3.5 bg-[#1b1e26] border-[#262b36] text-blue-600 rounded-sm focus:ring-blue-500 focus:ring-offset-0 focus:bg-[#1b1e26]"
                            >
                            <label for="terms" class="text-xs text-gray-400 leading-snug uppercase tracking-wide select-none">
                                I authorize the
                                <a href="#" class="text-blue-500 font-bold hover:underline">Terms of Protocol</a>
                                &
                                <a href="#" class="text-blue-500 font-bold hover:underline">Data Protection</a>
                            </label>
                        </div>

                        {{-- Banner de Beneficios del Sistema --}}
                        <div class="bg-[#1b1e26] border border-[#262b36] rounded-sm px-4 py-3 flex items-center gap-3">
                            <span class="text-blue-500 text-lg">✦</span>
                            <div>
                                <p class="text-[11px] font-bold text-gray-300 uppercase tracking-wider [font-family:'Orbitron',sans-serif]">System Perks Enabled</p>
                                <p class="text-[10px] text-gray-500 mt-0.5 uppercase tracking-wide leading-relaxed">Secure data link · Live environment monitoring · Full log tracking</p>
                            </div>
                        </div>

                        {{-- Botón de Registro --}}
                        <button
                            type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-500 active:bg-blue-700 text-white font-bold py-3 px-4 rounded-sm transition duration-150 text-xs tracking-widest uppercase shadow-[0_4px_12px_rgba(37,99,235,0.15)] hover:shadow-[0_4px_16px_rgba(37,99,235,0.3)] [font-family:'Orbitron',sans-serif]"
                        >
                            Execute Registration
                        </button>
                    </form>

                    {{-- Divisor Técnico --}}
                    <div class="flex items-center gap-3 my-6">
                        <div class="flex-1 h-px bg-[#262b36]"></div>
                        <span class="text-[10px] text-gray-500 font-mono uppercase tracking-widest">OR</span>
                        <div class="flex-1 h-px bg-[#262b36]"></div>
                    </div>

                    {{-- Enlace de Login --}}
                    <p class="text-center text-xs text-gray-400 font-mono">
                        Profile already active?
                        <a href="{{ route('login') }}" class="text-blue-500 font-bold hover:text-blue-400 transition hover:underline block mt-1.5 [font-family:'Orbitron',sans-serif] uppercase tracking-wider">
                            Return to Authentication
                        </a>
                    </p>

                </div>
            </div>

            {{-- Badges de Validación Técnicos --}}
            <div class="mt-6 flex items-center justify-center gap-5 text-[10px] text-gray-500 font-mono uppercase tracking-wider">
                <span class="flex items-center gap-1.5"><span class="text-blue-500">■</span> REG_SECURE</span>
                <span class="flex items-center gap-1.5"><span class="text-blue-500">■</span> ZERO_SPAM_FILTER</span>
                <span class="flex items-center gap-1.5"><span class="text-blue-500">■</span> PUBLIC_NODE</span>
            </div>

        </div>
    </section>
</x-front-layout>