@extends('public.layouts.app')

@section('title', 'Daftar Workshop')

@section('content')

    {{-- Wrapper Alpine.js untuk mengontrol Modal --}}
    <div x-data="{ openEditModal: {{ $errors->any() ? 'true' : 'false' }} }" class="max-w-3xl mx-auto px-6 py-12">

        {{-- Header --}}
        <div class="mb-8">
            <a href="{{ route('public.workshop.show', $workshop->id) }}" class="text-blue-600 hover:text-blue-800">
                ← Kembali ke Detail Workshop
            </a>

            <h1 class="text-3xl font-bold text-gray-800 mt-5">
                Pendaftaran Workshop
            </h1>

            <p class="text-gray-500 mt-2">
                Periksa data kamu sebelum melakukan pendaftaran.
            </p>
        </div>

        {{-- Informasi Workshop --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

            <h2 class="text-xl font-bold text-gray-800">
                {{ $workshop->judul }}
            </h2>

            <p class="text-blue-600 font-semibold mt-1">
                {{ $workshop->event->nama_event }}
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">

                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-sm text-gray-500">Narasumber</p>
                    <p class="font-semibold text-gray-800 mt-1">{{ $workshop->narasumber }}</p>
                </div>

                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-sm text-gray-500">Tanggal</p>
                    <p class="font-semibold text-gray-800 mt-1">
                        {{ \Carbon\Carbon::parse($workshop->tanggal)->format('d-m-Y') }}
                    </p>
                </div>

                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-sm text-gray-500">Lokasi</p>
                    <p class="font-semibold text-gray-800 mt-1">{{ $workshop->lokasi }}</p>
                </div>

                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-sm text-gray-500">Kuota</p>
                    <p class="font-semibold text-gray-800 mt-1">{{ $workshop->kuota }} peserta</p>
                </div>

            </div>

            {{-- Data Peserta --}}
            <div class="border-t mt-8 pt-8">

                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-800">Data Peserta</h2>
                    {{-- Tombol untuk buka modal --}}
                    <button type="button" @click="openEditModal = true"
                        class="text-sm text-blue-600 hover:underline font-semibold">
                        Ubah Data Profile
                    </button>
                </div>

                <div class="mt-5 space-y-4">

                    <div>
                        <p class="text-sm text-gray-500">Nama</p>
                        <p class="font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">NIK</p>
                        <p class="font-semibold text-gray-800">{{ auth()->user()->nik }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">No. Handphone</p>
                        <p class="font-semibold text-gray-800">{{ auth()->user()->no_hp }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Alamat</p>
                        <p class="font-semibold text-gray-800">{{ auth()->user()->alamat }}</p>
                    </div>

                </div>

            </div>

            {{-- Form Pendaftaran --}}
            <div class="border-t mt-8 pt-8">

                <form action="{{ route('public.workshop.daftar.store', $workshop->id) }}" method="POST"
                    enctype="multipart/form-data">

                    @csrf

                    <div class="bg-blue-50 rounded-xl p-5 mb-6">
                        <p class="text-sm text-blue-800">
                            Pastikan data kamu sudah benar sebelum menekan tombol <strong>Daftar Sekarang</strong>. <br>
                            {{-- Link Ubah Data dialihkan membuka modal --}}
                            <button type="button" @click="openEditModal = true"
                                class="font-bold underline hover:text-blue-900 focus:outline-none">
                                Ubah Data
                            </button>
                        </p>
                    </div>

                    {{-- Bukti Pembayaran --}}
                    @if ($workshop->biaya > 0)
                        <div class="mb-6">

                            <label for="bukti_pembayaran" class="block font-semibold text-gray-700 mb-2">
                                Bukti Pembayaran
                            </label>

                            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5 mb-4">
                                <p class="text-sm text-yellow-800">
                                    Workshop ini berbayar sebesar
                                    <span class="font-bold">
                                        Rp {{ number_format($workshop->biaya, 0, ',', '.') }}
                                    </span>.
                                </p>

                                <p class="text-sm text-yellow-700 mt-1">
                                    Silakan lakukan pembayaran terlebih dahulu, kemudian upload bukti pembayaran pada kolom
                                    di bawah.
                                </p>
                            </div>

                            <input type="file" id="bukti_pembayaran" name="bukti_pembayaran"
                                accept=".jpg,.jpeg,.png,.pdf"
                                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-600 focus:border-blue-500 focus:ring-blue-500">

                            <p class="text-xs text-gray-500 mt-2">
                                Format yang diperbolehkan: JPG, JPEG, PNG, atau PDF. Maksimal 2 MB.
                            </p>

                            @error('bukti_pembayaran')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror

                        </div>
                    @endif

                    <div class="flex flex-col sm:flex-row gap-3">

                        <a href="{{ route('public.workshop.show', $workshop->id) }}"
                            class="px-6 py-3 text-center rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50">
                            Kembali
                        </a>

                        <button type="submit"
                            class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold transition">
                            Daftar Sekarang
                        </button>

                    </div>

                </form>

            </div>

        </div>

        {{-- POPUP / MODAL EDIT PROFILE --}}
        <div x-show="openEditModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <div @click.away="openEditModal = false"
                class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl relative max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between border-b pb-3 mb-4">
                    <h3 class="text-lg font-bold text-gray-800">Ubah Data Profile</h3>
                    <button type="button" @click="openEditModal = false"
                        class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
                </div>

                {{-- Form untuk update profile --}}

                <form action="{{ route('public.profile.update') }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="space-y-4">

                        {{-- Nama --}}
                        <div>

                            <label for="modal_name" class="block text-sm font-medium text-gray-700">
                                Nama
                            </label>

                            <input type="text" id="modal_name" name="name"
                                value="{{ old('name', auth()->user()->name) }}"
                                class="mt-1 w-full rounded-xl border border-gray-300
                       px-3 py-2 text-sm
                       focus:ring-blue-500 focus:border-blue-500">

                            @error('name')
                                <p class="mt-1 text-sm text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- NIK --}}
                        <div>

                            <label for="modal_nik" class="block text-sm font-medium text-gray-700">
                                NIK
                            </label>

                            <input type="text" id="modal_nik" name="nik"
                                value="{{ old('nik', auth()->user()->nik) }}"
                                class="mt-1 w-full rounded-xl border border-gray-300
                       px-3 py-2 text-sm
                       focus:ring-blue-500 focus:border-blue-500">

                            @error('nik')
                                <p class="mt-1 text-sm text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>



                        {{-- No HP --}}
                        <div class="mb-6">

                            <label for="no_hp" class="block font-semibold text-gray-700 mb-2">
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
                   font-medium">
                                    +62
                                </span>

                                {{-- Input --}}
                                <input id="no_hp" type="tel" name="no_hp"
                                    value="{{ old('no_hp', preg_replace('/^0/', '', auth()->user()->no_hp ?? '')) }}"
                                    required inputmode="numeric" maxlength="12"
                                    class="w-full
                   rounded-r-xl
                   border-gray-300
                   focus:border-blue-500
                   focus:ring-blue-500
                   py-3">

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
                        <div>

                            <label for="modal_tanggal_lahir" class="block text-sm font-medium text-gray-700">
                                Tanggal Lahir
                            </label>

                            <input type="date" id="modal_tanggal_lahir" name="tanggal_lahir"
                                value="{{ old('tanggal_lahir', auth()->user()->tanggal_lahir) }}"
                                class="mt-1 w-full rounded-xl border border-gray-300
                       px-3 py-2 text-sm
                       focus:ring-blue-500 focus:border-blue-500">

                            @error('tanggal_lahir')
                                <p class="mt-1 text-sm text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Alamat --}}
                        <div>

                            <label for="modal_alamat" class="block text-sm font-medium text-gray-700">
                                Alamat
                            </label>

                            <textarea id="modal_alamat" name="alamat" rows="3"
                                class="mt-1 w-full rounded-xl border border-gray-300
                       px-3 py-2 text-sm
                       focus:ring-blue-500 focus:border-blue-500">{{ old('alamat', auth()->user()->alamat) }}</textarea>

                            @error('alamat')
                                <p class="mt-1 text-sm text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>


                    {{-- Tombol --}}
                    <div class="mt-6 flex justify-end gap-3">

                        <button type="button" @click="openEditModal = false"
                            class="px-4 py-2 rounded-xl border
                   text-gray-600 hover:bg-gray-50 text-sm">
                            Batal
                        </button>

                        <button type="submit"
                            class="px-4 py-2 rounded-xl
                   bg-blue-600
                   text-white
                   font-medium
                   hover:bg-blue-700
                   text-sm">
                            Simpan Perubahan
                        </button>

                    </div>

                </form>

            </div>
        </div>

    </div>

@endsection
