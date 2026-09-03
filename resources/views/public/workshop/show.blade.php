@extends('public.layouts.app')

@section('title', $workshop->judul)

@section('content')

    <div class="max-w-4xl mx-auto px-6 py-12">

        {{-- Kembali --}}
        <div class="mb-6">

            <a href="{{ route('home') }}#workshop" class="text-blue-600 hover:text-blue-800">
                ← Kembali ke Workshop
            </a>

        </div>


        {{-- Detail --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

            {{-- Event --}}
            <p class="text-blue-600 font-semibold">
                {{ $workshop->event->nama_event }}
            </p>


            {{-- Judul --}}
            <h1 class="text-3xl font-bold text-gray-800 mt-2">
                {{ $workshop->judul }}
            </h1>


            {{-- Narasumber --}}
            <div class="mt-6">

                <p class="text-sm text-gray-500">
                    Narasumber
                </p>

                <p class="text-lg font-semibold text-gray-800">
                    {{ $workshop->narasumber }}
                </p>

            </div>


            {{-- Informasi --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">

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


            {{-- Deskripsi --}}
            <div class="mt-8">

                <h2 class="text-xl font-bold text-gray-800">
                    Deskripsi Workshop
                </h2>

                <p class="text-gray-600 leading-relaxed mt-3 whitespace-pre-line">
                    {{ $workshop->deskripsi }}
                </p>

            </div>


            {{-- Status / Button --}}
            <div class="mt-8">

                @auth

                    @if (!$pendaftaran)
                        <a href="{{ route('public.workshop.daftar', $workshop->id) }}"
                            class="inline-flex px-8 py-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold transition">
                            Daftar Workshop →
                        </a>
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
                                class="inline-block mt-4 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                                Lihat Pendaftaran Saya
                            </a>

                        </div>
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
                                class="inline-block mt-4 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                                Lihat Pendaftaran Saya
                            </a>

                        </div>
                    @elseif ($pendaftaran->status === 'Ditolak')
                        <div class="bg-red-50 border border-red-200 rounded-xl p-5">

                            <p class="text-sm text-gray-500">
                                Status Pendaftaran
                            </p>

                            <p class="text-red-600 font-bold text-lg mt-1">
                                🔴 Ditolak
                            </p>

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

                            <a href="{{ route('public.workshop.daftar', $workshop->id) }}"
                                class="inline-block mt-4 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                                Daftar Kembali
                            </a>

                        </div>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                        class="inline-flex px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition">
                        Login untuk Mendaftar
                    </a>

                @endauth

            </div>

        </div>

    </div>

@endsection
