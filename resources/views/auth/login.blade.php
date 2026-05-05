<x-front-layout>
    <section class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-pink-100 flex items-center justify-center py-16 px-4">

        {{-- Decorative blobs --}}
        <div class="absolute top-0 left-0 w-72 h-72 bg-pink-200 rounded-full opacity-20 blur-3xl -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-pink-300 rounded-full opacity-10 blur-3xl translate-x-1/3 translate-y-1/3 pointer-events-none"></div>

        <div class="relative w-full max-w-md">

            {{-- Card --}}
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">

                {{-- Top accent bar --}}
                <div class="h-1.5 w-full bg-gradient-to-r from-pink-400 via-pink-600 to-rose-500"></div>

                <div class="px-8 pt-10 pb-10">

                    {{-- Logo / brand --}}
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center justify-center w-14 h-14 bg-pink-50 rounded-2xl mb-4 shadow-inner">
                            <span class="text-3xl">🛍️</span>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-800">Welcome Back</h1>
                        <p class="text-gray-500 text-sm mt-1">Sign in to continue shopping</p>
                    </div>

                    {{-- Session errors --}}
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-600 text-sm rounded-lg px-4 py-3">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('status'))
                        <div class="mb-6 bg-green-50 border border-green-200 text-green-600 text-sm rounded-lg px-4 py-3">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- Form --}}
                    <form action="{{ route('login') }}" method="POST" class="space-y-5">
                        @csrf

                        {{-- Email --}}
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Email Address
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 text-lg pointer-events-none">✉️</span>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="you@example.com"
                                    required
                                    autofocus
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition @error('email') border-red-400 bg-red-50 @enderror"
                                >
                            </div>
                        </div>

                        {{-- Password --}}
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label for="password" class="block text-sm font-semibold text-gray-700">
                                    Password
                                </label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-xs text-pink-600 hover:text-pink-700 font-medium">
                                        Forgot password?
                                    </a>
                                @endif
                            </div>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 text-lg pointer-events-none">🔒</span>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    placeholder="••••••••"
                                    required
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition @error('password') border-red-400 bg-red-50 @enderror"
                                >
                            </div>
                        </div>

                        {{-- Remember me --}}
                        <div class="flex items-center gap-2">
                            <input
                                type="checkbox"
                                id="remember"
                                name="remember"
                                class="w-4 h-4 text-pink-600 border-gray-300 rounded focus:ring-pink-400"
                            >
                            <label for="remember" class="text-sm text-gray-600">Remember me</label>
                        </div>

                        {{-- Submit --}}
                        <button
                            type="submit"
                            class="w-full bg-pink-600 hover:bg-pink-700 active:bg-pink-800 text-white font-semibold py-3 rounded-xl transition duration-200 shadow-md shadow-pink-200 hover:shadow-pink-300 text-sm tracking-wide"
                        >
                            Sign In
                        </button>
                    </form>

                    {{-- Divider --}}
                    <div class="flex items-center gap-3 my-6">
                        <div class="flex-1 h-px bg-gray-200"></div>
                        <span class="text-xs text-gray-400 font-medium">or</span>
                        <div class="flex-1 h-px bg-gray-200"></div>
                    </div>

                    {{-- Register link --}}
                    <p class="text-center text-sm text-gray-600">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="text-pink-600 font-semibold hover:text-pink-700 transition">
                            Create one free
                        </a>
                    </p>

                </div>
            </div>

            {{-- Trust badges --}}
            <div class="mt-6 flex items-center justify-center gap-6 text-xs text-gray-400">
                <span class="flex items-center gap-1">🔒 Secure Login</span>
                <span class="flex items-center gap-1">🛡️ Privacy Protected</span>
                <span class="flex items-center gap-1">💳 Safe Payments</span>
            </div>

        </div>
    </section>
</x-front-layout>