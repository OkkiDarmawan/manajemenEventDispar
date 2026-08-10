@extends('public.layouts.app')

@section('title', $lomba->nama_lomba)

@section('content')

<div class="max-w-5xl mx-auto px-6 py-12">

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

                @if($lomba->biaya > 0)

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

        <a
            href="{{ route('public.lomba.daftar', $lomba->id) }}"
            class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition">

            Daftar Sekarang →

        </a>

    </div>

</div>

@endsection