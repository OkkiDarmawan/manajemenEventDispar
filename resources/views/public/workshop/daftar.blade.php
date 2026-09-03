@extends('public.layouts.app')

@section('title', 'Daftar Workshop')

@section('content')

<div class="max-w-3xl mx-auto px-6 py-12">

    {{-- Header --}}
    <div class="mb-8">

        <a
            href="{{ route('public.workshop.show', $workshop->id) }}"
            class="text-blue-600 hover:text-blue-800"
        >
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

                <p class="text-sm text-gray-500">
                    Narasumber
                </p>

                <p class="font-semibold text-gray-800 mt-1">
                    {{ $workshop->narasumber }}
                </p>

            </div>


            <div class="bg-gray-50 rounded-xl p-4">

                <p class="text-sm text-gray-500">
                    Tanggal
                </p>

                <p class="font-semibold text-gray-800 mt-1">
                    {{ \Carbon\Carbon::parse($workshop->tanggal)->format('d-m-Y') }}
                </p>

            </div>


            <div class="bg-gray-50 rounded-xl p-4">

                <p class="text-sm text-gray-500">
                    Lokasi
                </p>

                <p class="font-semibold text-gray-800 mt-1">
                    {{ $workshop->lokasi }}
                </p>

            </div>


            <div class="bg-gray-50 rounded-xl p-4">

                <p class="text-sm text-gray-500">
                    Kuota
                </p>

                <p class="font-semibold text-gray-800 mt-1">
                    {{ $workshop->kuota }} peserta
                </p>

            </div>

        </div>


        {{-- Data Peserta --}}
        <div class="border-t mt-8 pt-8">

            <h2 class="text-xl font-bold text-gray-800">
                Data Peserta
            </h2>

            <div class="mt-5 space-y-4">

                <div>

                    <p class="text-sm text-gray-500">
                        Nama
                    </p>

                    <p class="font-semibold text-gray-800">
                        {{ auth()->user()->name }}
                    </p>

                </div>


                <div>

                    <p class="text-sm text-gray-500">
                        NIK
                    </p>

                    <p class="font-semibold text-gray-800">
                        {{ auth()->user()->nik }}
                    </p>

                </div>


                <div>

                    <p class="text-sm text-gray-500">
                        No. Handphone
                    </p>

                    <p class="font-semibold text-gray-800">
                        {{ auth()->user()->no_hp }}
                    </p>

                </div>


                <div>

                    <p class="text-sm text-gray-500">
                        Alamat
                    </p>

                    <p class="font-semibold text-gray-800">
                        {{ auth()->user()->alamat }}
                    </p>

                </div>

            </div>

        </div>


        {{-- Form --}}
        <div class="border-t mt-8 pt-8">

            <form
                action="{{ route('public.workshop.daftar.store', $workshop->id) }}"
                method="POST"
            >

                @csrf

                <div class="bg-blue-50 rounded-xl p-5 mb-6">

                    <p class="text-sm text-blue-800">
                        Pastikan data kamu sudah benar sebelum menekan
                        tombol <strong>Daftar Sekarang</strong>.
                    </p>

                </div>


                <div class="flex flex-col sm:flex-row gap-3">

                    <a
                        href="{{ route('public.workshop.show', $workshop->id) }}"
                        class="px-6 py-3
                               text-center
                               rounded-xl
                               border border-gray-300
                               text-gray-700
                               hover:bg-gray-50"
                    >
                        Kembali
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
                        Daftar Sekarang
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection