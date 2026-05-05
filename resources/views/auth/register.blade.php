<x-front-layout>
    <section class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-pink-100 flex items-center justify-center py-16 px-4">

        {{-- Decorative blobs --}}
        <div class="absolute top-0 right-0 w-80 h-80 bg-pink-200 rounded-full opacity-20 blur-3xl translate-x-1/3 -translate-y-1/3 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-rose-200 rounded-full opacity-10 blur-3xl -translate-x-1/3 translate-y-1/3 pointer-events-none"></div>

        <div class="relative w-full max-w-lg">

            {{-- Card --}}
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">

                {{-- Top accent bar --}}
                <div class="h-1.5 w-full bg-gradient-to-r from-pink-400 via-pink-600 to-rose-500"></div>

                <div class="px-8 pt-10 pb-10">

                    {{-- Header --}}
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center justify-center w-14 h-14 bg-pink-50 rounded-2xl mb-4 shadow-inner">
                            <span class="text-3xl">🎉</span>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-800">Create Your Account</h1>
                        <p class="text-gray-500 text-sm mt-1">Join us and start shopping today</p>
                    </div>

                    {{-- Errors --}}
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-600 text-sm rounded-lg px-4 py-3">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Form --}}
                    <form action="{{ route('register') }}" method="POST" class="space-y-5">
                        @csrf

                        {{-- Name --}}
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Full Name
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 text-lg pointer-events-none">👤</span>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="John Doe"
                                    required
                                    autofocus
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition @error('name') border-red-400 bg-red-50 @enderror"
                                >
                            </div>
                        </div>

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
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition @error('email') border-red-400 bg-red-50 @enderror"
                                >
                            </div>
                        </div>

                        {{-- Password row --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                            {{-- Password --}}
                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                    Password
                                </label>
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

                            {{-- Confirm Password --}}
                            <div>
                                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                    Confirm
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 text-lg pointer-events-none">🔑</span>
                                    <input
                                        type="password"
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        placeholder="••••••••"
                                        required
                                        class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition"
                                    >
                                </div>
                            </div>
                        </div>

                        {{-- Password hint --}}
                        <p class="text-xs text-gray-400 -mt-2">
                            Use at least 8 characters with a mix of letters and numbers.
                        </p>

                        {{-- Terms --}}
                        <div class="flex items-start gap-2">
                            <input
                                type="checkbox"
                                id="terms"
                                name="terms"
                                required
                                class="mt-0.5 w-4 h-4 text-pink-600 border-gray-300 rounded focus:ring-pink-400"
                            >
                            <label for="terms" class="text-sm text-gray-600 leading-snug">
                                I agree to the
                                <a href="#" class="text-pink-600 font-medium hover:underline">Terms of Service</a>
                                and
                                <a href="#" class="text-pink-600 font-medium hover:underline">Privacy Policy</a>
                            </label>
                        </div>

                        {{-- Perks mini-banner --}}
                        <div class="bg-pink-50 border border-pink-100 rounded-xl px-4 py-3 flex items-center gap-3">
                            <span class="text-2xl">🎁</span>
                            <div>
                                <p class="text-xs font-semibold text-pink-700">Members-only benefits</p>
                                <p class="text-xs text-pink-500 mt-0.5">Exclusive deals · Order tracking · Wishlist · Early access</p>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <button
                            type="submit"
                            class="w-full bg-pink-600 hover:bg-pink-700 active:bg-pink-800 text-white font-semibold py-3 rounded-xl transition duration-200 shadow-md shadow-pink-200 hover:shadow-pink-300 text-sm tracking-wide"
                        >
                            Create Account
                        </button>
                    </form>

                    {{-- Divider --}}
                    <div class="flex items-center gap-3 my-6">
                        <div class="flex-1 h-px bg-gray-200"></div>
                        <span class="text-xs text-gray-400 font-medium">or</span>
                        <div class="flex-1 h-px bg-gray-200"></div>
                    </div>

                    {{-- Login link --}}
                    <p class="text-center text-sm text-gray-600">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-pink-600 font-semibold hover:text-pink-700 transition">
                            Sign in
                        </a>
                    </p>

                </div>
            </div>

            {{-- Trust badges --}}
            <div class="mt-6 flex items-center justify-center gap-6 text-xs text-gray-400">
                <span class="flex items-center gap-1">🔒 Secure Registration</span>
                <span class="flex items-center gap-1">🛡️ No Spam</span>
                <span class="flex items-center gap-1">💸 Free Forever</span>
            </div>

        </div>
    </section>
</x-front-layout>