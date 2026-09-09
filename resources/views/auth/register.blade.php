<x-guest-layout>

    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 via-white to-blue-100 px-6 py-12">

        <div class="w-full max-w-lg">

            {{-- Brand --}}
            <div class="text-center mb-8">

                <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-3">

                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-white text-xl font-bold">

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


            {{-- Register Card --}}
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 md:p-10">

                {{-- Heading --}}
                <div class="text-center mb-8">

                    <h2 class="text-2xl font-bold text-gray-800">
                        Buat Akun 👋
                    </h2>

                    <p class="text-gray-500 mt-2 text-sm">
                        Daftarkan diri untuk mengikuti berbagai event dan lomba.
                    </p>

                </div>


                <form method="POST" action="{{ route('register') }}" novalidate>

                    @csrf


                    {{-- Nama --}}
                    <div>

                        <x-input-label for="name" :value="__('Nama Lengkap')" class="text-gray-700 font-semibold" />

                        <x-text-input id="name"
                            class="block mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 py-3"
                            type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                            placeholder="Masukkan nama lengkap" />

                        <x-input-error :messages="$errors->get('name')" class="mt-2" />

                    </div>


                    {{-- NIK --}}
                    <div class="mt-5">

                        <x-input-label for="nik" :value="__('NIK')" class="text-gray-700 font-semibold" />

                        <x-text-input id="nik"
                            class="block mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 py-3"
                            type="text" name="nik" :value="old('nik')" required autocomplete="username"
                            inputmode="numeric" maxlength="16" minlength="16" pattern="[0-9]{16}"
                            placeholder="Masukkan 16 digit NIK" />
                        <x-input-error :messages="$errors->get('nik')" class="mt-2" />

                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        NIK harus terdiri dari tepat 16 angka.
                    </p>


                    {{-- No Handphone --}}
                    <div class="mt-5">

                        <x-input-label for="no_hp" :value="__('No. Handphone')" class="text-gray-700 font-semibold" />

                        <div class="flex mt-2">

                            {{-- Prefix +62 --}}
                            <span
                                class="inline-flex items-center px-4
                   rounded-l-xl
                   border border-r-0 border-gray-300
                   bg-gray-50
                   text-gray-600
                   font-medium">
                                +62
                            </span>


                            {{-- Nomor --}}
                            <x-text-input id="no_hp"
                                class="block w-full rounded-r-xl
                   border-gray-300
                   focus:border-blue-500
                   focus:ring-blue-500
                   py-3"
                                type="tel" name="no_hp" :value="old('no_hp')" required autocomplete="tel"
                                inputmode="numeric" maxlength="13" placeholder="81234567890" />

                        </div>

                        <p class="text-xs text-gray-500 mt-1">
                            Masukkan nomor tanpa angka 0 di depan.
                            Contoh: 81234567890
                        </p>

                        <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />

                    </div>


                    {{-- Tanggal Lahir --}}
                    <div class="mt-5">

                        <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" class="text-gray-700 font-semibold" />

                        <x-text-input id="tanggal_lahir"
                            class="block mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 py-3"
                            type="date" name="tanggal_lahir" :value="old('tanggal_lahir')" required />

                        <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />

                    </div>


                    {{-- Alamat --}}
                    <div class="mt-5">

                        <x-input-label for="alamat" :value="__('Alamat')" class="text-gray-700 font-semibold" />

                        <textarea id="alamat" name="alamat" rows="3" required
                            class="block mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 py-3 px-4"
                            placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>

                        <x-input-error :messages="$errors->get('alamat')" class="mt-2" />

                    </div>


                    {{-- Password --}}
                    <div class="mt-5">

                        <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-semibold" />

                        <div class="relative mt-2">

                            <x-text-input id="password"
                                class="block w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 py-3 pr-12"
                                type="password" name="password" required autocomplete="new-password" minlength="6"
                                placeholder="Minimal 6 karakter, huruf dan angka" />

                            <button type="button" onclick="togglePassword('password', 'eye-password')"
                                class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-400 hover:text-gray-600">

                                <svg id="eye-password" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5 c4.477 0 8.268 2.943 9.542 7 -1.274 4.057-5.065 7-9.542 7 -4.477 0-8.268-2.943-9.542-7z" />

                                </svg>

                            </button>

                        </div>

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />

                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        Password minimal 6 karakter dan harus mengandung huruf dan angka.
                    </p>


                    {{-- Konfirmasi Password --}}
                    <div class="relative mt-2">

                        <x-text-input id="password_confirmation"
                            class="block w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 py-3 pr-12"
                            type="password" name="password_confirmation" required autocomplete="new-password"
                            minlength="6" placeholder="Ulangi password" />

                        <button type="button"
                            onclick="togglePassword('password_confirmation', 'eye-password-confirmation')"
                            class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-400 hover:text-gray-600">

                            <svg id="eye-password-confirmation" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5 c4.477 0 8.268 2.943 9.542 7 -1.274 4.057-5.065 7-9.542 7 -4.477 0-8.268-2.943-9.542-7z" />

                            </svg>

                        </button>

                    </div>

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />

                    {{-- Register Button --}}
                    <button type="submit"
                        class="w-full mt-7 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3.5 rounded-xl transition duration-200 shadow-md hover:shadow-lg">

                        Daftar Sekarang

                    </button>
                    {{-- Login --}}
                    <div class="mt-7 pt-6 border-t border-gray-100 text-center">

                        <p class="text-sm text-gray-500">

                            Sudah memiliki akun?

                            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-semibold">

                                Masuk sekarang

                            </a>

                        </p>

                    </div>
            </div>



            </form>


            {{-- Back --}}
            <div class="text-center mt-6">

                <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-blue-600 transition">

                    ← Kembali ke halaman utama

                </a>

            </div>
        </div>




    </div>

    </div>
    

</x-guest-layout>
