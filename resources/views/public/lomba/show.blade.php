@extends('public.layouts.app')

@section('title', $lomba->nama_lomba)

@section('content')

    <div class="max-w-7xl mx-auto px-6 py-12">

        {{-- Pesan Error --}}
        @if (session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                <p class="text-red-600 font-medium">
                    {{ session('error') }}
                </p>
            </div>
        @endif


        {{-- Pesan Success --}}
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                <p class="text-green-600 font-medium">
                    {{ session('success') }}
                </p>
            </div>
        @endif

       
        {{-- Poster Lomba --}}
        @if ($lomba->poster)
            <div class="mb-10">

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                    <img src="{{ asset('storage/' . $lomba->poster) }}" alt="Poster {{ $lomba->nama_lomba }}"
                        class="w-full max-h-[600px] object-contain mx-auto bg-gray-50">

                </div>

            </div>
        @endif
        



        {{-- Kembali --}}
        <a href="{{ route('public.event.show', $lomba->event_id) }}"
            class="inline-flex items-center gap-2
                   text-gray-600 hover:text-blue-600
                   font-medium transition mb-8">
            <span>←</span>
            Kembali ke Event
        </a>


        {{-- Header Lomba --}}
        <div class="mb-10">

            <p class="inline-block px-3 py-2 text-sm font-semibold text-blue-600 bg-blue-100 rounded-full">
                {{ $lomba->event->nama_event }}
            </p>

            <h1 class="mt-2 text-4xl md:text-5xl font-bold text-gray-800">
                {{ $lomba->nama_lomba }}
            </h1>



        </div>


        {{-- Konten Utama --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">


            {{-- ================================================= --}}
            {{-- KOLOM KIRI --}}
            {{-- ================================================= --}}
            <div class="lg:col-span-2 space-y-8">


                {{-- Deskripsi --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">

                    <div class="mb-5">

                        <p class="text-sm font-semibold text-blue-600 uppercase tracking-wide">
                            Tentang Lomba
                        </p>

                        <h2 class="mt-1 text-2xl font-bold text-gray-800">
                            Deskripsi
                        </h2>

                    </div>

                    <div class="text-gray-600 leading-relaxed prose prose-gray max-w-none">
                        {!! $lomba->deskripsi !!}
                    </div>

                </div>


                {{-- Syarat dan Ketentuan --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">

                    <div class="mb-5">

                        <p class="text-sm font-semibold text-blue-600 uppercase tracking-wide">
                            Ketentuan
                        </p>

                        <h2 class="mt-1 text-2xl font-bold text-gray-800">
                            Syarat dan Ketentuan
                        </h2>

                    </div>

                    <div class="text-gray-600 leading-relaxed prose prose-gray max-w-none">
                        {!! $lomba->syarat !!}
                    </div>

                </div>


                {{-- Status Pendaftaran / Tombol --}}
                <div>

                    @auth

                        {{-- Belum Pernah Mendaftar --}}
                        @if (!$pendaftaran)
                            @if ($kuotaPenuh)
                                {{-- Kuota Penuh --}}
                                <div class="bg-red-50 border border-red-200 rounded-2xl p-6">

                                    <p class="text-red-600 font-bold text-lg">
                                        🔴 Kuota Lomba Penuh
                                    </p>

                                    <p class="text-sm text-gray-500 mt-1">
                                        Maaf, kuota lomba ini sudah terpenuhi.
                                    </p>

                                </div>
                            @else
                                {{-- Masih Tersedia --}}
                                <a href="{{ route('public.lomba.daftar', $lomba->id) }}"
                                    class="inline-flex items-center
                                           px-8 py-4
                                           rounded-xl
                                           bg-blue-600
                                           hover:bg-blue-700
                                           text-white
                                           font-semibold
                                           transition">
                                    Daftar Sekarang →
                                </a>
                            @endif


                            {{-- Menunggu --}}
                        @elseif ($pendaftaran->status === 'Menunggu')
                            <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6">

                                <p class="text-sm text-gray-500">
                                    Status Pendaftaran
                                </p>

                                <p class="text-yellow-600 font-bold text-lg mt-1">
                                    🟡 Menunggu
                                </p>

                                <p class="text-sm text-gray-500 mt-1">
                                    Pendaftaran kamu sedang menunggu verifikasi admin.
                                </p>

                                <a href="{{ route('public.pendaftaran-saya.index') }}"
                                    class="inline-block mt-4
                                           px-5 py-2
                                           bg-blue-600
                                           hover:bg-blue-700
                                           text-white
                                           rounded-lg">
                                    Lihat Pendaftaran Saya
                                </a>

                            </div>


                            {{-- Diterima --}}
                        @elseif ($pendaftaran->status === 'Diterima')
                            <div class="bg-green-50 border border-green-200 rounded-2xl p-6">

                                <p class="text-sm text-gray-500">
                                    Status Pendaftaran
                                </p>

                                <p class="text-green-600 font-bold text-lg mt-1">
                                    🟢 Diterima
                                </p>

                                {{-- Nomor Peserta --}}
                                <div class="mt-5 rounded-2xl border border-green-200 bg-green-50 p-5">

                                    <p class="text-sm text-green-700 font-semibold">
                                        Nomor Peserta
                                    </p>

                                    <p class="mt-1 text-3xl font-black text-green-700">
                                        #{{ $pendaftaran->nomor_peserta }}
                                    </p>

                                    <p class="mt-1 text-sm text-green-600">
                                        Selamat! Kamu telah diterima sebagai peserta lomba.
                                    </p>

                                </div>

                                <a href="{{ route('public.pendaftaran-saya.index') }}"
                                    class="inline-block mt-4
                                           px-5 py-2
                                           bg-blue-600
                                           hover:bg-blue-700
                                           text-white
                                           rounded-lg">
                                    Lihat Pendaftaran Saya
                                </a>

                            </div>


                            {{-- Ditolak --}}
                        @elseif ($pendaftaran->status === 'Ditolak')
                            <div class="bg-red-50 border border-red-200 rounded-2xl p-6">

                                <p class="text-sm text-gray-500">
                                    Status Pendaftaran
                                </p>

                                <p class="text-red-600 font-bold text-lg mt-1">
                                    🔴 Ditolak
                                </p>


                                {{-- Alasan Penolakan --}}
                                @if ($pendaftaran->alasan_penolakan)
                                    <div class="mt-4 pt-4 border-t border-red-200">

                                        <p class="text-sm text-gray-500">
                                            Alasan Penolakan
                                        </p>

                                        <p class="text-gray-700 mt-1">
                                            {{ $pendaftaran->alasan_penolakan }}
                                        </p>

                                    </div>
                                @endif


                                {{-- Daftar Kembali --}}
                                @if (!$kuotaPenuh)
                                    <a href="{{ route('public.lomba.daftar', $lomba->id) }}"
                                        class="inline-block mt-4
                                               px-5 py-2
                                               bg-blue-600
                                               hover:bg-blue-700
                                               text-white
                                               rounded-lg">
                                        Daftar Kembali
                                    </a>
                                @else
                                    <div class="mt-4 text-sm text-red-600 font-semibold">
                                        🔴 Kuota lomba sudah penuh.
                                    </div>
                                @endif

                            </div>
                        @endif
                    @else
                        {{-- Belum Login --}}
                        @if ($kuotaPenuh)
                            <div class="bg-red-50 border border-red-200 rounded-2xl p-6">

                                <p class="text-red-600 font-bold text-lg">
                                    🔴 Kuota Lomba Penuh
                                </p>

                                <p class="text-sm text-gray-500 mt-1">
                                    Maaf, kuota lomba ini sudah terpenuhi.
                                </p>

                            </div>
                        @else
                            <a href="{{ route('login') }}"
                                class="inline-flex items-center
                                       px-8 py-4
                                       bg-blue-600
                                       hover:bg-blue-700
                                       text-white
                                       font-semibold
                                       rounded-xl
                                       transition">
                                Login untuk Mendaftar
                            </a>
                        @endif

                    @endauth

                </div>

            </div>



            {{-- ================================================= --}}
            {{-- KOLOM KANAN --}}
            {{-- ================================================= --}}
            <div class="lg:col-span-1">

                <div class="lg:sticky lg:top-24 space-y-6">


                    {{-- Informasi Lomba --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

                        <div class="mb-6">

                            <p class="text-sm font-semibold text-blue-600 uppercase tracking-wide">
                                Informasi
                            </p>

                            <h2 class="mt-1 text-2xl font-bold text-gray-800">
                                Informasi Lomba
                            </h2>

                        </div>


                        {{-- Penyelenggara --}}
                        <div class="pb-5 border-b border-gray-100">

                            <p class="text-sm text-gray-500">
                                Penyelenggara
                            </p>

                            <p class="mt-1 font-semibold text-gray-800">
                                {{ $lomba->penyelenggara ?? 'Belum ditentukan' }}
                            </p>

                        </div>


                        {{-- Kuota --}}
                        <div class="py-5 border-b border-gray-100">

                            <p class="text-sm text-gray-500">
                                Kuota Peserta
                            </p>

                            <p class="mt-1 font-semibold text-gray-800">
                                {{ $lomba->kuota }} peserta
                            </p>

                        </div>


                        {{-- Biaya --}}
                        <div class="py-5 border-b border-gray-100">

                            <p class="text-sm text-gray-500">
                                Biaya Pendaftaran
                            </p>

                            <p class="mt-1 font-semibold text-gray-800">

                                @if ($lomba->biaya > 0)
                                    Rp {{ number_format($lomba->biaya, 0, ',', '.') }}
                                @else
                                    Gratis
                                @endif

                            </p>

                        </div>


                        {{-- Hadiah --}}
                        <div class="py-5 border-b border-gray-100">

                            <p class="text-sm text-gray-500">
                                Hadiah
                            </p>

                            <p class="mt-1 font-semibold text-gray-800">
                                {{ $lomba->hadiah ?? '-' }}
                            </p>

                        </div>


                        {{-- Periode --}}
                        <div class="pt-5">

                            <p class="text-sm text-gray-500">
                                Periode Pendaftaran
                            </p>

                            <p class="mt-1 font-semibold text-gray-800 leading-relaxed">

                                {{ \Carbon\Carbon::parse($lomba->pendaftaran_terbuka)->translatedFormat('d F Y') }}

                                -

                                {{ \Carbon\Carbon::parse($lomba->pendaftaran_tertutup)->translatedFormat('d F Y') }}

                            </p>

                        </div>

                    </div>


                    {{-- Ketersediaan Kuota --}}
                    <div
                        class="rounded-2xl p-6
                            {{ $kuotaPenuh ? 'bg-red-50 border border-red-200' : 'bg-green-50 border border-green-200' }}">

                        <p class="text-sm text-gray-500">
                            Ketersediaan
                        </p>

                        @if ($kuotaPenuh)
                            <p class="font-bold text-red-600 mt-1">
                                🔴 Kuota Penuh
                            </p>
                        @else
                            <p class="font-bold text-green-600 mt-1">
                                {{ $sisaKuota }} slot tersedia
                            </p>
                        @endif

                        <div class="mt-4 pt-4 border-t border-current/10">

                            <p class="text-sm text-gray-500">
                                Peserta Diterima
                            </p>

                            <p class="font-semibold text-gray-800 mt-1">
                                {{ $jumlahDiterima }} orang
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
