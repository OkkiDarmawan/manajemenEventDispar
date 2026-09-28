@extends('public.layouts.app')

@section('title', $workshop->judul)

@section('content')

    <div class="max-w-7xl mx-auto px-6 py-12">


        {{-- Poster Lomba --}}
        @if ($workshop->poster)
            <div class="mb-10">

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                    <img src="{{ asset('storage/' . $workshop->poster) }}" alt="Poster {{ $workshop->nama_lomba }}"
                        class="w-full max-h-[600px] object-contain mx-auto bg-gray-50">

                </div>

            </div>
        @endif

        {{-- Kembali --}}
        <a href="{{ route('public.event.show', $workshop->event_id) }}"
            class="inline-flex items-center gap-2
                   text-gray-600 hover:text-blue-600
                   font-medium transition mb-8">
            <span>←</span>
            Kembali ke Event
        </a>


        {{-- Header Workshop --}}
        <div class="mb-10">

            <p class="inline-block px-3 py-2 text-sm font-semibold text-blue-600 bg-blue-100 rounded-full">
                {{ $workshop->event->nama_event }}
            </p>

            <h1 class="mt-2 text-4xl md:text-5xl font-bold text-gray-800">
                {{ $workshop->judul }}
            </h1>



        </div>


        {{-- Konten Utama --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">


            {{-- ================================================= --}}
            {{-- KOLOM KIRI --}}
            {{-- ================================================= --}}
            <div class="lg:col-span-2 space-y-8">


                {{-- Deskripsi Workshop --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">

                    <div class="mb-5">

                        <p class="text-sm font-semibold text-blue-600 uppercase tracking-wide">
                            Tentang Workshop
                        </p>

                        <h2 class="mt-1 text-2xl font-bold text-gray-800">
                            Deskripsi Syarat dan Ketentuan
                        </h2>

                    </div>

                    <div class="text-gray-600 leading-relaxed prose prose-gray max-w-none">
                        {!! $workshop->deskripsi !!}
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
                        {!! $workshop->syarat !!}
                    </div>

                </div>


                {{-- Status Pendaftaran --}}
                <div>

                    @auth

                        {{-- Belum pernah mendaftar --}}
                        @if (!$pendaftaran)
                            @if ($kuotaPenuh)
                                {{-- Kuota penuh --}}
                                <div class="bg-red-50 border border-red-200 rounded-2xl p-6">

                                    <p class="text-red-600 font-bold text-lg">
                                        🔴 Kuota Workshop Penuh
                                    </p>

                                    <p class="text-sm text-gray-500 mt-1">
                                        Maaf, kuota workshop ini sudah terpenuhi.
                                    </p>

                                </div>
                            @else
                                {{-- Masih tersedia --}}
                                <a href="{{ route('public.workshop.daftar', $workshop->id) }}"
                                    class="inline-flex items-center
                                           px-8 py-4
                                           rounded-xl
                                           bg-blue-600
                                           hover:bg-blue-700
                                           text-white
                                           font-semibold
                                           transition">
                                    Daftar Workshop →
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
                                    class="inline-block mt-4 px-5 py-2
                                           bg-blue-600 hover:bg-blue-700
                                           text-white rounded-lg">
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

                                @if ($pendaftaran->nomor_peserta)
                                    <div class="mt-5 rounded-2xl border border-green-200 bg-green-50 p-5">

                                        <p class="text-sm text-green-700 font-semibold">
                                            Nomor Peserta
                                        </p>

                                        <p class="mt-1 text-3xl font-black text-green-700">
                                            #{{ $pendaftaran->nomor_peserta }}
                                        </p>

                                        <p class="mt-1 text-sm text-green-600">
                                            Selamat! Kamu telah diterima sebagai peserta workshop.
                                        </p>

                                    </div>
                                @endif

                                <a href="{{ route('public.pendaftaran-saya.index') }}"
                                    class="inline-block mt-4 px-5 py-2
                                           bg-blue-600 hover:bg-blue-700
                                           text-white rounded-lg">
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


                                {{-- Daftar kembali --}}
                                @if (!$kuotaPenuh)
                                    <a href="{{ route('public.workshop.daftar', $workshop->id) }}"
                                        class="inline-block mt-4 px-5 py-2
                                               bg-blue-600 hover:bg-blue-700
                                               text-white rounded-lg">
                                        Daftar Kembali
                                    </a>
                                @else
                                    <div class="mt-4 text-sm text-red-600 font-semibold">
                                        🔴 Kuota workshop sudah penuh.
                                    </div>
                                @endif

                            </div>
                        @endif
                    @else
                        {{-- Belum Login --}}
                        @if ($kuotaPenuh)
                            <div class="bg-red-50 border border-red-200 rounded-2xl p-6">

                                <p class="text-red-600 font-bold text-lg">
                                    🔴 Kuota Workshop Penuh
                                </p>

                                <p class="text-sm text-gray-500 mt-1">
                                    Maaf, kuota workshop ini sudah terpenuhi.
                                </p>

                            </div>
                        @else
                            <a href="{{ route('login') }}"
                                class="inline-flex items-center
                                       px-8 py-4
                                       bg-blue-600 hover:bg-blue-700
                                       text-white font-semibold
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


                    {{-- Informasi Workshop --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

                        <div class="mb-6">

                            <p class="text-sm font-semibold text-blue-600 uppercase tracking-wide">
                                Informasi
                            </p>

                            <h2 class="mt-1 text-2xl font-bold text-gray-800">
                                Informasi Workshop
                            </h2>

                        </div>


                        {{-- Narasumber --}}
                        <div class="pb-5 border-b border-gray-100">

                            <p class="text-sm text-gray-500">
                                Narasumber
                            </p>

                            <p class="mt-1 font-semibold text-gray-800">
                                {{ $workshop->narasumber }}
                            </p>

                        </div>


                        {{-- Tanggal --}}
                        <div class="py-5 border-b border-gray-100">

                            <p class="text-sm text-gray-500">
                                Tanggal
                            </p>

                            <p class="mt-1 font-semibold text-gray-800 leading-relaxed">

                                {{ \Carbon\Carbon::parse($workshop->tanggal_mulai)->translatedFormat('d F Y') }}

                                @if ($workshop->tanggal_selesai)
                                    -

                                    {{ \Carbon\Carbon::parse($workshop->tanggal_selesai)->translatedFormat('d F Y') }}
                                @endif

                            </p>

                        </div>


                        {{-- Lokasi --}}
                        <div class="py-5 border-b border-gray-100">

                            <p class="text-sm text-gray-500">
                                Lokasi
                            </p>

                            <p class="mt-1 font-semibold text-gray-800">
                                {{ $workshop->lokasi }}
                            </p>

                        </div>


                        {{-- Kuota --}}
                        <div class="py-5 border-b border-gray-100">

                            <p class="text-sm text-gray-500">
                                Kuota Peserta
                            </p>

                            <p class="mt-1 font-semibold text-gray-800">
                                {{ $workshop->kuota }} orang
                            </p>

                        </div>


                        {{-- Biaya --}}
                        <div class="pt-5">

                            <p class="text-sm text-gray-500">
                                Biaya Pendaftaran
                            </p>

                            <p class="mt-1 font-semibold text-gray-800">

                                @if ($workshop->biaya > 0)
                                    Rp {{ number_format($workshop->biaya, 0, ',', '.') }}
                                @else
                                    Gratis
                                @endif

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
