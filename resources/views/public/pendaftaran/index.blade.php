@extends('public.layouts.app')

@section('title', 'Pendaftaran Saya')

@section('content')

    <div class="max-w-5xl mx-auto px-6 py-12">

        <a href="{{ route('home') }}#lomba"
            class="inline-flex items-center gap-2
           text-gray-600 hover:text-blue-600
           font-medium transition mb-6">

            <span>←</span>

            Kembali ke Lomba

        </a>

        <div class="mb-8">

            <h1 class="text-3xl font-bold text-gray-800">
                Pendaftaran Saya
            </h1>

            <p class="text-gray-500 mt-2">
                Daftar lomba yang pernah kamu ikuti.
            </p>

        </div>


        @if ($pendaftarans->isEmpty())

            <div class="bg-white rounded-xl shadow p-8 text-center">

                <p class="text-gray-500">
                    Kamu belum memiliki pendaftaran lomba.
                </p>

            </div>
        @else
            <div class="space-y-4">

                @foreach ($pendaftarans as $pendaftaran)
                    <div class="bg-white rounded-xl shadow p-6">

                        <div
                            class="flex flex-col md:flex-row
                                md:items-center
                                md:justify-between
                                gap-4">

                            <div>

                                <p class="text-sm text-blue-600 font-semibold">
                                    {{ $pendaftaran->lomba->event->nama_event }}
                                </p>

                                <h2 class="text-xl font-bold text-gray-800 mt-1">
                                    {{ $pendaftaran->lomba->nama_lomba }}
                                </h2>

                            </div>


                            <div class="flex items-center gap-3">

                                <a href="{{ route('public.pendaftaran.show', $pendaftaran->id) }}"
                                    class="px-4 py-2 rounded-lg border border-blue-600 text-blue-600  hover:bg-blue-50 font-medium transition">

                                    Lihat Detail

                                </a>


                                @if ($pendaftaran->status === 'Menunggu')
                                    <span class="px-4 py-2 rounded-full
                   bg-yellow-100 text-yellow-700">

                                        🟡 Menunggu

                                    </span>
                                @elseif ($pendaftaran->status === 'Diterima')
                                    <span class="px-4 py-2 rounded-full
                   bg-green-100 text-green-700">

                                        🟢 Diterima

                                    </span>
                                @elseif ($pendaftaran->status === 'Ditolak')
                                    <span class="px-4 py-2 rounded-full
                   bg-red-100 text-red-700">

                                        🔴 Ditolak

                                    </span>
                                @endif

                            </div>

                        </div>

                    </div>
                @endforeach

            </div>

        @endif

    </div>

@endsection
