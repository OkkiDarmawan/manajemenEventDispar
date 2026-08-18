@extends('public.layouts.app')

@section('title', $lomba->nama_lomba)
@if (session('error'))
    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
        <p class="text-red-600 font-medium">
            {{ session('error') }}
        </p>
    </div>
@endif

@if (session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
        <p class="text-green-600 font-medium">
            {{ session('success') }}
        </p>
    </div>
@endif

@section('content')

    <div class="max-w-5xl mx-auto px-6 py-12">


          <a href="{{ route('home') }}#lomba"
            class="inline-flex items-center gap-2
           text-gray-600 hover:text-blue-600
           font-medium transition mb-6">

            <span>←</span>

            Kembali

        </a>

        <!-- Header -->
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


        <!-- Informasi -->
        <div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="bg-white rounded-xl shadow p-6">

                <h2 class="font-semibold text-gray-800">
                    Kuota
                </h2>

                <p class="mt-2 text-gray-500">
                    {{ $lomba->kuota }} peserta
                </p>

            </div>


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


            <div class="bg-white rounded-xl shadow p-6">

                <h2 class="font-semibold text-gray-800">
                    Hadiah
                </h2>

                <p class="mt-2 text-gray-500">
                    {{ $lomba->hadiah ?? '-' }}
                </p>

            </div>


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


        <!-- Syarat -->
        <div class="mt-8 bg-white rounded-xl shadow p-6">

            <h2 class="text-xl font-bold text-gray-800">
                Syarat dan Ketentuan
            </h2>

            <div class="mt-4 text-gray-600 whitespace-pre-line">
                {{ $lomba->syarat }}
            </div>

        </div>


        <!-- Button -->
        <div class="mt-8 flex justify-end">

            @if (!$pendaftaran)

    <a
        href="{{ route('public.lomba.daftar', $lomba->id) }}"
        class="inline-flex px-8 py-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold">

        Daftar Sekarang →

    </a>

@elseif ($pendaftaran->status === 'Menunggu')

    <div class="inline-flex px-8 py-4 rounded-xl bg-yellow-100 text-yellow-700 font-semibold">

        🟡 Pendaftaran Sedang Diproses

    </div>

@elseif ($pendaftaran->status === 'Diterima')

    <div class="inline-flex px-8 py-4 rounded-xl bg-green-100 text-green-700 font-semibold">

        🟢 Anda Diterima

    </div>

@elseif ($pendaftaran->status === 'Ditolak')

    <div class="inline-flex px-8 py-4 rounded-xl bg-red-100 text-red-700 font-semibold">

        🔴 Pendaftaran Ditolak

    </div>

@endif

        </div>

    </div>

@endsection
