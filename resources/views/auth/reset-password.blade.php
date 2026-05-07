<x-front-layout>
    <section class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-pink-100 flex items-center justify-center py-16 px-4">

        <div class="absolute top-0 left-0 w-80 h-80 bg-pink-200 rounded-full opacity-20 blur-3xl -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
        <div class="absolute bottom-0 right-0 w-72 h-72 bg-rose-200 rounded-full opacity-10 blur-3xl translate-x-1/3 translate-y-1/3 pointer-events-none"></div>

        <div class="relative w-full max-w-sm">

            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="h-1.5 w-full bg-gradient-to-r from-pink-400 via-pink-600 to-rose-500"></div>

                <div class="px-8 pt-10 pb-10">

                    {{-- Header --}}
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center justify-center w-14 h-14 bg-pink-50 rounded-2xl mb-4 shadow-inner">
                            <span class="text-3xl">🛡️</span>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-800">Reset Password</h1>
                        <p class="text-gray-500 text-sm mt-2">
                            Choose a strong new password for your account.
                        </p>
                    </div>

                    {{-- Errors --}}
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-600 text-sm rounded-xl px-4 py-3">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
                        @csrf

                        {{-- Hidden token --}}
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

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
                                    value="{{ old('email', $request->email) }}"
                                    required
                                    autofocus
                                    autocomplete="username"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition @error('email') border-red-400 bg-red-50 @enderror"
                                >
                            </div>
                        </div>

                        {{-- New Password --}}
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                New Password
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 text-lg pointer-events-none">🔒</span>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    placeholder="••••••••"
                                    required
                                    autocomplete="new-password"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition @error('password') border-red-400 bg-red-50 @enderror"
                                >
                            </div>
                        </div>

                        {{-- Confirm Password --}}
                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Confirm New Password
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 text-lg pointer-events-none">🔑</span>
                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    placeholder="••••••••"
                                    required
                                    autocomplete="new-password"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition @error('password_confirmation') border-red-400 bg-red-50 @enderror"
                                >
                            </div>
                        </div>

                        {{-- Password hint --}}
                        <p class="text-xs text-gray-400 -mt-2">
                            Use at least 8 characters with a mix of letters and numbers.
                        </p>

                        <button
                            type="submit"
                            class="w-full bg-pink-600 hover:bg-pink-700 active:bg-pink-800 text-white font-semibold py-3 rounded-xl transition duration-200 shadow-md shadow-pink-200 hover:shadow-pink-300 text-sm tracking-wide"
                        >
                            Reset Password
                        </button>
                    </form>

                    <div class="mt-6 text-center">
                        <a href="{{ route('login') }}" class="text-sm text-pink-600 font-semibold hover:text-pink-700 transition">
                            ← Back to Sign In
                        </a>
                    </div>

                </div>
            </div>

            <div class="mt-6 flex items-center justify-center gap-6 text-xs text-gray-400">
                <span class="flex items-center gap-1">🔒 Encrypted & Secure</span>
                <span class="flex items-center gap-1">🛡️ Privacy Protected</span>
            </div>

        </div>
    </section>
</x-front-layout>