@extends('public.layouts.app')

@section('title', $lomba->nama_lomba)

@section('content')

    <div class="max-w-5xl mx-auto px-6 py-12">

        {{-- Pesan Error --}}
        @if (session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <p class="text-red-600 font-medium">
                    {{ session('error') }}
                </p>
            </div>
        @endif


        {{-- Pesan Success --}}
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-green-600 font-medium">
                    {{ session('success') }}
                </p>
            </div>
        @endif


        {{-- Kembali --}}
        <a href="{{ route('home') }}#lomba"
            class="inline-flex items-center gap-2
                   text-gray-600 hover:text-blue-600
                   font-medium transition mb-6">

            <span>←</span>

            Kembali

        </a>


        {{-- Header --}}
        <div>

            <p class="text-blue-600 font-semibold">
                {{ $lomba->event->nama_event }}
            </p>

            <h1 class="mt-2 text-4xl font-bold text-gray-800">
                {{ $lomba->nama_lomba }}
            </h1>

            <p class="mt-4 text-gray-500">
                {{ $lomba->deskripsi }}
            </p>

        </div>


        {{-- Informasi --}}
        <div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Kuota --}}
            <div class="bg-white rounded-xl shadow p-6">

                <h2 class="font-semibold text-gray-800">
                    Kuota Peserta
                </h2>

                <p class="mt-2 text-gray-500">
                    {{ $lomba->kuota }} peserta
                </p>

            </div>


            {{-- Biaya --}}
            <div class="bg-white rounded-xl shadow p-6">

                <h2 class="font-semibold text-gray-800">
                    Biaya Pendaftaran
                </h2>

                <p class="mt-2 text-gray-500">

                    @if ($lomba->biaya > 0)
                        Rp {{ number_format($lomba->biaya, 0, ',', '.') }}
                    @else
                        Gratis
                    @endif

                </p>

            </div>


            {{-- Hadiah --}}
            <div class="bg-white rounded-xl shadow p-6">

                <h2 class="font-semibold text-gray-800">
                    Hadiah
                </h2>

                <p class="mt-2 text-gray-500">
                    {{ $lomba->hadiah ?? '-' }}
                </p>

            </div>


            {{-- Periode --}}
            <div class="bg-white rounded-xl shadow p-6">

                <h2 class="font-semibold text-gray-800">
                    Periode Pendaftaran
                </h2>

                <p class="mt-2 text-gray-500">

                    {{ \Carbon\Carbon::parse($lomba->pendaftaran_terbuka)->translatedFormat('d F Y') }}

                    -

                    {{ \Carbon\Carbon::parse($lomba->pendaftaran_tertutup)->translatedFormat('d F Y') }}

                </p>

            </div>

        </div>


        {{-- Informasi Kuota --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

            {{-- Sudah Diterima --}}
            <div class="bg-gray-100 rounded-xl p-4">

                <p class="text-sm text-gray-500">
                    Peserta Diterima
                </p>

                <p class="font-semibold text-gray-800 mt-1">
                    {{ $jumlahDiterima }} orang
                </p>

            </div>


           {{-- Sisa Kuota --}}
                <div
                    class="rounded-xl p-4
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

                </div>

        </div>


        {{-- Syarat --}}
        <div class="mt-8 bg-white rounded-xl shadow p-6">

            <h2 class="text-xl font-bold text-gray-800">
                Syarat dan Ketentuan
            </h2>

            <div class="mt-4 text-gray-600 whitespace-pre-line">
                {{ $lomba->syarat }}
            </div>

        </div>


        {{-- Status / Button --}}
        <div class="mt-8">

            @auth

                {{-- Belum Pernah Mendaftar --}}
                @if (!$pendaftaran)
                    @if ($kuotaPenuh)
                        {{-- Kuota Penuh --}}
                        <div class="bg-red-50 border border-red-200 rounded-xl p-5">

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
                            class="inline-flex px-8 py-4 rounded-xl
                                   bg-blue-600 hover:bg-blue-700
                                   text-white font-semibold transition">

                            Daftar Sekarang →

                        </a>
                    @endif


                    {{-- Menunggu --}}
                @elseif ($pendaftaran->status === 'Menunggu')
                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5">

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
                            class="inline-block mt-4 px-5 py-2
                                   bg-blue-600 hover:bg-blue-700
                                   text-white rounded-lg">

                            Lihat Pendaftaran Saya

                        </a>

                    </div>


                    {{-- Diterima --}}
                @elseif ($pendaftaran->status === 'Diterima')
                    <div class="bg-green-50 border border-green-200 rounded-xl p-5">

                        <p class="text-sm text-gray-500">
                            Status Pendaftaran
                        </p>

                        <p class="text-green-600 font-bold text-lg mt-1">
                            🟢 Diterima
                        </p>

                        <p class="text-sm text-gray-500 mt-1">
                            Selamat, pendaftaran kamu telah diterima.
                        </p>

                        <a href="{{ route('public.pendaftaran-saya.index') }}"
                            class="inline-block mt-4 px-5 py-2
                                   bg-blue-600 hover:bg-blue-700
                                   text-white rounded-lg">

                            Lihat Pendaftaran Saya

                        </a>

                    </div>


                    {{-- Ditolak --}}
                @elseif ($pendaftaran->status === 'Ditolak')
                    <div class="bg-red-50 border border-red-200 rounded-xl p-5">

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
                                class="inline-block mt-4 px-5 py-2
                                       bg-blue-600 hover:bg-blue-700
                                       text-white rounded-lg">

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
                    <div class="bg-red-50 border border-red-200 rounded-xl p-5">

                        <p class="text-red-600 font-bold text-lg">
                            🔴 Kuota Lomba Penuh
                        </p>

                        <p class="text-sm text-gray-500 mt-1">
                            Maaf, kuota lomba ini sudah terpenuhi.
                        </p>

                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="inline-flex px-8 py-4
                               bg-blue-600 hover:bg-blue-700
                               text-white font-semibold rounded-xl transition">

                        Login untuk Mendaftar

                    </a>
                @endif

            @endauth

        </div>

    </div>

@endsection
