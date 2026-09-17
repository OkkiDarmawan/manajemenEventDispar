@extends('public.layouts.app')

@section('title', 'Pendaftaran Saya')

@section('content')

    <div class="max-w-6xl mx-auto px-6 py-12">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">
                Pendaftaran Saya
            </h1>

            <p class="text-gray-500 mt-2">
                Lihat seluruh riwayat pendaftaran lomba dan workshop kamu.
            </p>
        </div>


        {{-- ========================= --}}
        {{-- PENDAFTARAN LOMBA --}}
        {{-- ========================= --}}

        <div class="mb-10">

            <h2 class="text-2xl font-bold text-gray-800 mb-5">
                🏆 Pendaftaran Lomba
            </h2>

            @forelse ($pendaftaranLomba as $pendaftaran)
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 mb-4">

                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                        <div>
                            <h3 class="text-lg font-bold text-gray-800">
                                {{ $pendaftaran->lomba->nama_lomba }}
                            </h3>

                            <p class="text-sm text-gray-500 mt-1">
                                Event:
                                {{ $pendaftaran->lomba->event->nama_event ?? '-' }}
                            </p>

                            <p class="text-sm text-gray-500 mt-1">
                                Tanggal daftar:
                                {{ $pendaftaran->created_at->format('d-m-Y H:i') }}
                            </p>
                        </div>


                        {{-- Status --}}
                        <div>

                            @if ($pendaftaran->status === 'Menunggu')
                                <span
                                    class="inline-flex px-4 py-2 rounded-full bg-yellow-100 text-yellow-700 text-sm font-semibold">
                                    Menunggu
                                </span>
                            @elseif ($pendaftaran->status === 'Diterima')
                                <span class="inline-flex px-4 py-2 rounded-full bg-green-100 text-green-700 text-sm font-semibold">
                                    Diterima
                                </span>

                                <div
                                    class="mt-3 text-sm text-green-700 font-semibold">
                                    Nomor Peserta:

                                    @if ($pendaftaran->nomor_peserta)
                                        <span class="text-lg">
                                            #{{ $pendaftaran->nomor_peserta }}
                                        </span>
                                    @else
                                        <span class="text-red-500">
                                            Belum tersedia
                                        </span>
                                    @endif

                                </div>
                            @elseif ($pendaftaran->status === 'Ditolak')
                                <span
                                    class="inline-flex px-4 py-2 rounded-full bg-red-100 text-red-700 text-sm font-semibold">
                                    Ditolak
                                </span>
                            @endif

                        </div>

                    </div>


                    {{-- Alasan Penolakan --}}
                    @if ($pendaftaran->status === 'Ditolak' && $pendaftaran->alasan_penolakan)
                        <div class="mt-5 bg-red-50 border border-red-100 rounded-xl p-4">

                            <p class="text-sm font-semibold text-red-700">
                                Alasan Penolakan
                            </p>

                            <p class="text-sm text-red-600 mt-1">
                                {{ $pendaftaran->alasan_penolakan }}
                            </p>

                        </div>
                    @endif

                    @if ($pendaftaran->status === 'Ditolak')
                        <div class="mt-6">

                            <a href="{{ route('public.lomba.daftar', $pendaftaran->lomba->id) }}"
                                class="inline-flex items-center justify-center px-5 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold transition">
                                Daftar Kembali
                            </a>

                        </div>
                    @endif
                </div>


            @empty

                <div class="bg-gray-50 rounded-2xl p-6 text-center text-gray-500">
                    Belum ada pendaftaran lomba.
                </div>
            @endforelse

        </div>



        {{-- ========================= --}}
        {{-- PENDAFTARAN WORKSHOP --}}
        {{-- ========================= --}}

        <div>

            <h2 class="text-2xl font-bold text-gray-800 mb-5">
                🎓 Pendaftaran Workshop
            </h2>

            @forelse ($pendaftaranWorkshop as $pendaftaran)
                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 mb-4">

                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                        <div>
                            <h3 class="text-lg font-bold text-gray-800">
                                {{ $pendaftaran->workshop->judul }}
                            </h3>

                            <p class="text-sm text-gray-500 mt-1">
                                Event:
                                {{ $pendaftaran->workshop->event->nama_event ?? '-' }}
                            </p>

                            <p class="text-sm text-gray-500 mt-1">
                                Tanggal daftar:
                                {{ $pendaftaran->created_at->format('d-m-Y H:i') }}
                            </p>
                        </div>


                        {{-- Status --}}
                        <div>

                            @if ($pendaftaran->status === 'Menunggu')
                                <span
                                    class="inline-flex px-4 py-2 rounded-full bg-yellow-100 text-yellow-700 text-sm font-semibold">
                                    Menunggu
                                </span>
                              @elseif ($pendaftaran->status === 'Diterima')
                                <span class="inline-flex px-4 py-2 rounded-full bg-green-100 text-green-700 text-sm font-semibold">
                                    Diterima
                                </span>

                                <div
                                    class="mt-3 text-sm text-green-700 font-semibold">
                                    Nomor Peserta:

                                    @if ($pendaftaran->nomor_peserta)
                                        <span class="text-lg">
                                            #{{ $pendaftaran->nomor_peserta }}
                                        </span>
                                    @else
                                        <span class="text-red-500">
                                            Belum tersedia
                                        </span>
                                    @endif

                                </div>
                            @elseif ($pendaftaran->status === 'Ditolak')
                                <span
                                    class="inline-flex px-4 py-2 rounded-full bg-red-100 text-red-700 text-sm font-semibold">
                                    Ditolak
                                </span>
                            @endif

                        </div>

                    </div>


                    {{-- Alasan Penolakan --}}
                    @if ($pendaftaran->status === 'Ditolak' && $pendaftaran->alasan_penolakan)
                        <div class="mt-5 bg-red-50 border border-red-100 rounded-xl p-4">

                            <p class="text-sm font-semibold text-red-700">
                                Alasan Penolakan
                            </p>

                            <p class="text-sm text-red-600 mt-1">
                                {{ $pendaftaran->alasan_penolakan }}
                            </p>

                        </div>
                    @endif

                    @if ($pendaftaran->status === 'Ditolak')
                        <div class="mt-6">

                            <a href="{{ route('public.workshop.daftar', $pendaftaran->workshop->id) }}"
                                class="inline-flex items-center justify-center px-5 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold transition">
                                Daftar Kembali
                            </a>

                        </div>
                    @endif

                </div>

            @empty

                <div class="bg-gray-50 rounded-2xl p-6 text-center text-gray-500">
                    Belum ada pendaftaran workshop.
                </div>
            @endforelse

        </div>

    </div>

@endsection
