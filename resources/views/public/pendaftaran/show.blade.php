@extends('public.layouts.app')

@section('title', 'Detail Pendaftaran')

@section('content')

<div class="max-w-4xl mx-auto px-6 py-12">

    {{-- Kembali --}}
    <a
        href="{{ route('public.pendaftaran.index') }}"
        class="inline-flex items-center gap-2
               text-gray-600 hover:text-blue-600
               font-medium transition mb-6">

        <span>←</span>

        Kembali ke Pendaftaran Saya

    </a>


    {{-- Header --}}
    <div class="mb-8">

        <p class="text-blue-600 font-semibold">
            {{ $pendaftaranLomba->lomba->event->nama_event }}
        </p>

        <h1 class="text-3xl font-bold text-gray-800 mt-2">
            Detail Pendaftaran
        </h1>

        <p class="text-gray-500 mt-2">
            {{ $pendaftaranLomba->lomba->nama_lomba }}
        </p>

    </div>


    {{-- Status --}}
    <div class="bg-white rounded-2xl shadow p-6 mb-6">

        <h2 class="text-lg font-bold text-gray-800 mb-4">
            Status Pendaftaran
        </h2>


        @if ($pendaftaranLomba->status === 'Menunggu')

            <span
                class="inline-flex px-4 py-2
                       rounded-full
                       bg-yellow-100
                       text-yellow-700
                       font-semibold">

                🟡 Menunggu

            </span>

        @elseif ($pendaftaranLomba->status === 'Diterima')

            <span
                class="inline-flex px-4 py-2
                       rounded-full
                       bg-green-100
                       text-green-700
                       font-semibold">

                🟢 Diterima

            </span>

        @elseif ($pendaftaranLomba->status === 'Ditolak')

            <span
                class="inline-flex px-4 py-2
                       rounded-full
                       bg-red-100
                       text-red-700
                       font-semibold">

                🔴 Ditolak

            </span>

        @endif

    </div>


    {{-- Informasi Lomba --}}
    <div class="bg-white rounded-2xl shadow p-6 mb-6">

        <h2 class="text-lg font-bold text-gray-800 mb-5">
            Informasi Lomba
        </h2>

        <div class="space-y-4">

            <div>
                <p class="text-sm text-gray-500">
                    Event
                </p>

                <p class="font-semibold text-gray-800">
                    {{ $pendaftaranLomba->lomba->event->nama_event }}
                </p>
            </div>


            <div>
                <p class="text-sm text-gray-500">
                    Lomba
                </p>

                <p class="font-semibold text-gray-800">
                    {{ $pendaftaranLomba->lomba->nama_lomba }}
                </p>
            </div>


            <div>
                <p class="text-sm text-gray-500">
                    Tanggal Pendaftaran
                </p>

                <p class="font-semibold text-gray-800">
                    {{ $pendaftaranLomba->created_at->translatedFormat('d F Y, H:i') }}
                </p>
            </div>

        </div>

    </div>


    {{-- Data Pendaftaran --}}
    <div class="bg-white rounded-2xl shadow p-6">

        <h2 class="text-lg font-bold text-gray-800 mb-6">
            Data Pendaftaran
        </h2>


        <div class="space-y-5">

            @foreach ($pendaftaranLomba->jawabanLombas as $jawaban)

                <div class="border-b border-gray-100 pb-4 last:border-0">

                    <p class="text-sm text-gray-500 mb-1">

                        {{ $jawaban->masterField->label }}

                    </p>

                    <p class="font-medium text-gray-800">

                        {{ $jawaban->value ?: '-' }}

                    </p>

                </div>

            @endforeach

        </div>
        @if ($pendaftaranLomba->status === 'Ditolak')

    <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-xl">

        <p class="font-semibold text-red-700">
            Alasan Penolakan
        </p>

        <p class="text-red-600 mt-2">
            {{ $pendaftaranLomba->alasan_penolakan }}
        </p>

    </div>

@endif

@if ($pendaftaranLomba->status === 'Ditolak')

    <div class="mt-6">

        <a
            href="{{ route(
                'public.lomba.daftar',
                $pendaftaranLomba->lomba->id
            ) }}"
            class="inline-flex items-center
                   justify-center
                   px-5 py-3
                   rounded-xl
                   bg-blue-600
                   hover:bg-blue-700
                   text-white
                   font-semibold
                   transition"
        >
            Daftar Kembali
        </a>

    </div>

@endif

    </div>

</div>

@endsection