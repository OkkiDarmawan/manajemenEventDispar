@extends('public.layouts.app')

@section('title', $namaUmkm ?? 'Detail UMKM')

@section('content')

    <div class="max-w-6xl mx-auto px-6 py-12">

        {{-- ========================================================= --}}
        {{-- TOMBOL KEMBALI --}}
        {{-- ========================================================= --}}

        <div class="mb-6">

            <a href="{{ route('public.galeri-umkm') }}"
                class="
                inline-flex
                items-center
                gap-2
                text-sm
                font-semibold
                text-blue-600
                hover:text-blue-800
                transition
            ">
                ← Kembali ke Galeri UMKM
            </a>

        </div>


        {{-- ========================================================= --}}
        {{-- HEADER UMKM --}}
        {{-- ========================================================= --}}

        <div
            class="
            bg-white
            rounded-3xl
            border
            border-gray-100
            shadow-sm
            overflow-hidden
        ">

            <div class="grid lg:grid-cols-3">

                {{-- ================================================= --}}
                {{-- FOTO --}}
                {{-- ================================================= --}}

                <div class="lg:col-span-1">

                    <div
                        class="
                        h-full
                        min-h-[320px]
                        bg-gray-100
                        overflow-hidden
                    ">

                        @if ($fotoUmkm)
                            <img src="{{ asset('storage/' . $fotoUmkm) }}" alt="{{ $namaUmkm }}"
                                class="
                                w-full
                                h-full
                                object-cover
                            ">
                        @else
                            <div
                                class="
                                w-full
                                h-full
                                min-h-[320px]
                                flex
                                flex-col
                                items-center
                                justify-center
                                bg-gradient-to-br
                                from-blue-50
                                to-gray-100
                            ">

                                <div class="text-7xl">
                                    🏪
                                </div>

                                <p class="mt-3 text-gray-400">
                                    Foto UMKM belum tersedia
                                </p>

                            </div>
                        @endif

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- INFORMASI UTAMA --}}
                {{-- ================================================= --}}

                <div class="lg:col-span-2 p-8 md:p-10">

                    <div class="flex items-center gap-2 mb-4">

                        <span
                            class="
                            inline-flex
                            px-3
                            py-1.5
                            rounded-full
                            bg-green-100
                            text-green-700
                            text-xs
                            font-bold
                        ">
                            ✓ Terverifikasi
                        </span>

                    </div>


                    <h1
                        class="
                        text-3xl
                        md:text-4xl
                        font-black
                        text-gray-800
                    ">
                        {{ $namaUmkm ?? 'UMKM Peserta' }}
                    </h1>


                    {{-- Event --}}

                    @if ($pendaftaranUmkm->umkm?->event)
                        <div class="mt-5">

                            <p class="text-sm text-gray-400">
                                Berpartisipasi pada
                            </p>

                            <p class="mt-1 text-blue-600 font-semibold">
                                {{ $pendaftaranUmkm->umkm->event->nama_event }}
                            </p>

                        </div>
                    @endif


                    {{-- Penyelenggara --}}

                    @if ($pendaftaranUmkm->umkm?->penyelenggara)
                        <div class="mt-4">

                            <p class="text-sm text-gray-400">
                                Penyelenggara
                            </p>

                            <p class="mt-1 text-gray-700 font-medium">
                                {{ $pendaftaranUmkm->umkm->penyelenggara }}
                            </p>

                        </div>
                    @endif


                    {{-- Tanggal pendaftaran --}}

                    <div class="mt-4">

                        <p class="text-sm text-gray-400">
                            Terdaftar
                        </p>

                        <p class="mt-1 text-gray-700">
                            {{ $pendaftaranUmkm->created_at->format('d F Y') }}
                        </p>

                    </div>

                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- DATA UMKM --}}
        {{-- ========================================================= --}}

        <div class="mt-8">

            <div
                class="
                bg-white
                rounded-3xl
                border
                border-gray-100
                shadow-sm
                p-6
                md:p-8
            ">

                <div class="mb-6">

                    <h2 class="text-2xl font-bold text-gray-800">
                        Informasi UMKM
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Informasi yang diberikan oleh pemilik UMKM saat pendaftaran.
                    </p>

                </div>


                {{-- ================================================= --}}
                {{-- SEMUA JAWABAN DYNAMIC FIELD --}}
                {{-- ================================================= --}}

                <div
                    class="
                    grid
                    grid-cols-1
                    md:grid-cols-2
                    gap-5
                ">

                    @foreach ($pendaftaranUmkm->jawabanUmkms as $jawaban)
                        @if (($jawaban->masterField?->kategori ?? '') !== 'galeri')
                            @continue
                        @endif

                        @php

                            $field = $jawaban->masterField;

                            $label = $field?->label ?? 'Informasi';

                            $namaField = strtolower(trim($field?->nama_field ?? ''));

                            $tipe = strtolower(trim($field?->tipe ?? 'text'));

                        @endphp


                        {{-- FOTO TIDAK DITAMPILKAN LAGI --}}
                        @if ($namaField === 'foto_umkm')
                            @continue
                        @endif


                        <div
                            class="
                            rounded-2xl
                            border
                            border-gray-100
                            bg-gray-50
                            p-5
                        ">

                            <p
                                class="
                                text-sm
                                font-semibold
                                text-gray-500
                            ">
                                {{ $label }}
                            </p>


                            {{-- FILE --}}

                            @if ($tipe === 'file')
                                @if ($jawaban->value)
                                    <a href="{{ asset('storage/' . $jawaban->value) }}" target="_blank"
                                        class="
                                        inline-flex
                                        items-center
                                        gap-2
                                        mt-3
                                        px-4
                                        py-2
                                        rounded-xl
                                        bg-blue-600
                                        hover:bg-blue-700
                                        text-white
                                        text-sm
                                        font-semibold
                                        transition
                                    ">
                                        📎 Lihat File
                                    </a>
                                @else
                                    <p class="mt-2 text-gray-400">
                                        Tidak tersedia
                                    </p>
                                @endif


                                {{-- TEXTAREA / TEXT / NUMBER / DATE / SELECT --}}
                            @else
                                <p
                                    class="
                                    mt-2
                                    text-gray-800
                                    font-medium
                                    whitespace-pre-line
                                    break-words
                                ">
                                    {{ $jawaban->value ?: '-' }}
                                </p>
                            @endif

                        </div>
                    @endforeach

                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- FOOTER INFORMASI --}}
        {{-- ========================================================= --}}

        <div
            class="
            mt-6
            bg-blue-50
            border
            border-blue-100
            rounded-2xl
            p-5
        ">

            <p class="text-sm text-blue-700">

                Informasi UMKM pada halaman ini merupakan data yang
                disampaikan oleh pemilik UMKM pada saat pendaftaran
                dan telah diverifikasi oleh admin.

            </p>

        </div>

    </div>

@endsection
