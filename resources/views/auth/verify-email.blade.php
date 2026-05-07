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
                            <span class="text-3xl">📬</span>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-800">Check Your Email</h1>
                        <p class="text-gray-500 text-sm mt-2 leading-relaxed">
                            We sent a verification link to your email address. Click the link to activate your account.
                        </p>
                    </div>

                    {{-- Success status --}}
                    @if (session('status') == 'verification-link-sent')
                        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl px-4 py-3 flex items-start gap-2">
                            <span class="mt-0.5">✅</span>
                            <span>A new verification link has been sent to your email address.</span>
                        </div>
                    @endif

                    {{-- Steps visual --}}
                    <div class="bg-gray-50 rounded-xl p-4 mb-6 space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="w-7 h-7 rounded-full bg-pink-600 text-white flex items-center justify-center text-xs font-bold flex-shrink-0">1</div>
                            <p class="text-sm text-gray-700">Open your email inbox</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-7 h-7 rounded-full bg-pink-600 text-white flex items-center justify-center text-xs font-bold flex-shrink-0">2</div>
                            <p class="text-sm text-gray-700">Find the email from us</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-7 h-7 rounded-full bg-pink-600 text-white flex items-center justify-center text-xs font-bold flex-shrink-0">3</div>
                            <p class="text-sm text-gray-700">Click the verification link</p>
                        </div>
                    </div>

                    {{-- Resend form --}}
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button
                            type="submit"
                            class="w-full bg-pink-600 hover:bg-pink-700 active:bg-pink-800 text-white font-semibold py-3 rounded-xl transition duration-200 shadow-md shadow-pink-200 hover:shadow-pink-300 text-sm tracking-wide"
                        >
                            Resend Verification Email
                        </button>
                    </form>

                    <div class="flex items-center gap-3 my-5">
                        <div class="flex-1 h-px bg-gray-200"></div>
                        <span class="text-xs text-gray-400 font-medium">or</span>
                        <div class="flex-1 h-px bg-gray-200"></div>
                    </div>

                    {{-- Logout form --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            type="submit"
                            class="w-full border border-gray-200 text-gray-600 hover:text-pink-600 hover:border-pink-300 font-medium py-3 rounded-xl transition duration-200 text-sm"
                        >
                            Sign Out
                        </button>
                    </form>

                    <p class="text-center text-xs text-gray-400 mt-5 leading-relaxed">
                        Didn't receive the email? Check your spam folder or resend using the button above.
                    </p>

                </div>
            </div>

            <div class="mt-6 flex items-center justify-center gap-6 text-xs text-gray-400">
                <span class="flex items-center gap-1">📧 Check spam folder</span>
                <span class="flex items-center gap-1">⏱️ Link expires in 60 min</span>
            </div>

        </div>
    </section>
</x-front-layout>