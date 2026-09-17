@extends('public.layouts.app')

@section('content')

<section
    class="py-16
           bg-gray-50
           min-h-screen"
>

    <div class="max-w-3xl mx-auto px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-8">

            <p class="text-blue-600 font-semibold">
                PROFIL
            </p>

            <h1
                class="mt-2
                       text-3xl
                       md:text-4xl
                       font-bold
                       text-gray-900"
            >
                Edit Profil
            </h1>

            <p class="mt-3 text-gray-500">
                Perbarui data pribadi kamu.
            </p>

        </div>


        {{-- Form --}}
        <div
            class="bg-white
                   rounded-2xl
                   border border-gray-100
                   shadow-sm
                   p-6"
        >

            <form
                method="POST"
                action="{{ route('public.profile.update') }}"
                novalidate
            >

                @csrf
                @method('PUT')


                {{-- Nama --}}
                <div class="mb-6">

                    <label
                        for="name"
                        class="block
                               font-semibold
                               text-gray-700
                               mb-2"
                    >
                        Nama Lengkap
                    </label>

                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        required
                        class="w-full
                               rounded-xl
                               border-gray-300
                               focus:border-blue-500
                               focus:ring-blue-500
                               py-3"
                    >

                    @error('name')

                        <p class="mt-2 text-sm text-red-500">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- NIK --}}
                <div class="mb-6">

                    <label
                        for="nik"
                        class="block
                               font-semibold
                               text-gray-700
                               mb-2"
                    >
                        NIK
                    </label>

                    <input
                        id="nik"
                        type="text"
                        name="nik"
                        value="{{ old('nik', $user->nik) }}"
                        required
                        inputmode="numeric"
                        maxlength="16"
                        class="w-full
                               rounded-xl
                               border-gray-300
                               focus:border-blue-500
                               focus:ring-blue-500
                               py-3"
                    >

                    <p class="mt-1 text-xs text-gray-500">
                        NIK harus terdiri dari tepat 16 angka.
                    </p>

                    @error('nik')

                        <p class="mt-2 text-sm text-red-500">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- No HP --}}
                <div class="mb-6">

                    <label
                        for="no_hp"
                        class="block
                               font-semibold
                               text-gray-700
                               mb-2"
                    >
                        No. Handphone
                    </label>

                    <div class="flex">

                        {{-- Prefix --}}
                        <span
                            class="inline-flex
                                   items-center
                                   px-4
                                   rounded-l-xl
                                   border
                                   border-r-0
                                   border-gray-300
                                   bg-gray-50
                                   text-gray-600
                                   font-medium"
                        >
                            +62
                        </span>


                        {{-- Input --}}
                        <input
                            id="no_hp"
                            type="tel"
                            name="no_hp"
                            value="{{ old(
                                'no_hp',
                                ltrim($user->no_hp ?? '', '0')
                            ) }}"
                            required
                            inputmode="numeric"
                            maxlength="12"
                            class="w-full
                                   rounded-r-xl
                                   border-gray-300
                                   focus:border-blue-500
                                   focus:ring-blue-500
                                   py-3"
                        >

                    </div>

                    <p class="mt-1 text-xs text-gray-500">
                        Masukkan nomor tanpa angka 0 di depan.
                    </p>

                    @error('no_hp')

                        <p class="mt-2 text-sm text-red-500">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- Tanggal Lahir --}}
                <div class="mb-6">

                    <label
                        for="tanggal_lahir"
                        class="block
                               font-semibold
                               text-gray-700
                               mb-2"
                    >
                        Tanggal Lahir
                    </label>

                    <input
                        id="tanggal_lahir"
                        type="date"
                        name="tanggal_lahir"
                        value="{{ old(
                            'tanggal_lahir',
                            $user->tanggal_lahir
                        ) }}"
                        required
                        class="w-full
                               rounded-xl
                               border-gray-300
                               focus:border-blue-500
                               focus:ring-blue-500
                               py-3"
                    >

                    @error('tanggal_lahir')

                        <p class="mt-2 text-sm text-red-500">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- Alamat --}}
                <div class="mb-6">

                    <label
                        for="alamat"
                        class="block
                               font-semibold
                               text-gray-700
                               mb-2"
                    >
                        Alamat
                    </label>

                    <textarea
                        id="alamat"
                        name="alamat"
                        rows="4"
                        required
                        class="w-full
                               rounded-xl
                               border-gray-300
                               focus:border-blue-500
                               focus:ring-blue-500
                               py-3"
                    >{{ old('alamat', $user->alamat) }}</textarea>

                    @error('alamat')

                        <p class="mt-2 text-sm text-red-500">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- Button --}}
                <div
                    class="flex
                           flex-col-reverse
                           sm:flex-row
                           sm:justify-end
                           gap-3"
                >

                    <a
                        href="{{ route('public.profile.show') }}"
                        class="px-6 py-3
                               rounded-xl
                               bg-gray-100
                               hover:bg-gray-200
                               text-gray-700
                               font-semibold
                               text-center
                               transition"
                    >
                        Batal
                    </a>


                    <button
                        type="submit"
                        class="px-6 py-3
                               rounded-xl
                               bg-blue-600
                               hover:bg-blue-700
                               text-white
                               font-semibold
                               transition"
                    >
                        Simpan Perubahan
                    </button>

                </div>

            </form>

        </div>

    </div>

</section>

@endsection