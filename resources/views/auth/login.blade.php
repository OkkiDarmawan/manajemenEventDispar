<x-guest-layout>

    <div
        class="min-h-screen flex items-center justify-center
                bg-gradient-to-br from-blue-50 via-white to-blue-100
                px-6 py-12">

        <div class="w-full max-w-md">

            {{-- Brand --}}
            <div class="text-center mb-8">

                <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-3">

                    <div
                        class="w-16 h-16 rounded-2xl
                               flex items-center justify-center
                               text-white text-xl font-bold ">

                        <img src="{{ asset('images/my_logo.png') }}" alt="">

                    </div>

                    <div class="text-left">

                        <h1 class="text-2xl font-bold text-gray-800">
                            EventKite
                        </h1>

                        <p class="text-sm text-gray-500">
                            Manajemen Event
                        </p>

                    </div>

                </a>

            </div>


            {{-- Login Card --}}
            <div
                class="bg-white rounded-3xl shadow-xl
                        border border-gray-100
                        p-8 md:p-10">

                {{-- Heading --}}
                <div class="text-center mb-8">

                    <h2 class="text-2xl font-bold text-gray-800">
                        Selamat Datang 👋
                    </h2>

                    <p class="text-gray-500 mt-2 text-sm">
                        Silakan masuk untuk melanjutkan.
                    </p>

                </div>


                {{-- Session Status --}}
                <x-auth-session-status class="mb-5" :status="session('status')" />


                {{-- Login Form --}}
                <form method="POST" action="{{ route('login') }}">

                    @csrf


                    {{-- NIK --}}
                    <div>

                        <x-input-label for="nik" :value="__('NIK')" class="text-gray-700 font-semibold" />

                        <x-text-input id="nik"
                            class="block mt-2 w-full rounded-xl
                                   border-gray-300
                                   focus:border-blue-500
                                   focus:ring-blue-500
                                   py-3"
                            type="text" name="nik" :value="old('nik')" required autofocus autocomplete="username"
                            placeholder="Masukkan NIK Anda" />

                        <x-input-error :messages="$errors->get('nik')" class="mt-2" />

                    </div>


                    {{-- Password --}}
                    <div class="mt-5">

                        <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-semibold" />

                        <div class="relative mt-2">

                            <x-text-input id="password"
                                class="block w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 py-3 pr-12"
                                type="password" name="password" required autocomplete="current-password"
                                placeholder="Masukkan password" />

                            <button type="button" onclick="togglePassword('password', 'eye-password')"
                                class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-400 hover:text-gray-600">

                                <svg id="eye-password" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5
                   c4.477 0 8.268 2.943 9.542 7
                   -1.274 4.057-5.065 7-9.542 7
                   -4.477 0-8.268-2.943-9.542-7z" />

                                </svg>

                            </button>

                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />

                    </div>


                    {{-- Remember + Forgot Password --}}
                    {{-- <div class="flex items-center justify-between mt-5">

                        <label for="remember_me" class="inline-flex items-center cursor-pointer">

                            <input id="remember_me" type="checkbox"
                                class="rounded border-gray-300
                                       text-blue-600
                                       shadow-sm
                                       focus:ring-blue-500"
                                name="remember">

                            <span class="ms-2 text-sm text-gray-600">
                                Ingat saya
                            </span>

                        </label>


                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-sm text-blue-600
                                       hover:text-blue-700
                                       font-medium">

                                Lupa password?

                            </a>
                        @endif

                    </div> --}}


                    {{-- Login Button --}}
                    <button type="submit"
                        class="w-full mt-7
                               bg-blue-600
                               hover:bg-blue-700
                               text-white
                               font-semibold
                               py-3.5
                               rounded-xl
                               transition
                               duration-200
                               shadow-md
                               hover:shadow-lg">

                        Masuk

                    </button>

                </form>


                {{-- Register --}}
                @if (Route::has('register'))
                    <div class="mt-7 pt-6 border-t border-gray-100 text-center">

                        <p class="text-sm text-gray-500">

                            Belum memiliki akun?

                            <a href="{{ route('register') }}"
                                class="text-blue-600
                                       hover:text-blue-700
                                       font-semibold">

                                Daftar sekarang

                            </a>

                        </p>

                    </div>
                @endif

            </div>


            {{-- Back --}}
            <div class="text-center mt-6">

                <a href="{{ route('home') }}"
                    class="text-sm text-gray-500
                           hover:text-blue-600 transition">

                    ← Kembali ke halaman utama

                </a>

            </div>

        </div>

    </div>

</x-guest-layout>
