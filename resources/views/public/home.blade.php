@extends('public.layouts.app')

@section('title', $event ? $event->nama_event : 'Beranda')

@section('content')

    @if ($event)
        @include('public.components.hero')


        @include('public.components.lomba')

        <section id="lomba">

            {{-- Nanti card lomba di sini --}}

        </section>
    @else
        <section class="min-h-screen flex items-center justify-center">

            <div class="text-center">

                <h1 class="text-3xl font-bold">

                    Belum Ada Event Aktif

                </h1>

                <p class="text-gray-500 mt-3">

                    Silakan kembali lagi nanti.

                </p>

            </div>

        </section>
    @endif

    {{-- Workshop --}}
    <section class="py-16 bg-gray-50 border-2" id="workshop">

        <div class="max-w-7xl mx-auto px-6">

            {{-- Header --}}
            <div class="text-center mb-10">

                <p class="text-blue-600 font-semibold">
                    WORKSHOP
                </p>

                <h2 class="text-3xl font-bold text-gray-800 mt-2">
                    Workshop yang Tersedia
                </h2>

                <p class="text-gray-500 mt-3">
                    Ikuti berbagai workshop menarik dan bermanfaat.
                </p>

            </div>


            @if ($workshops->isEmpty())

                <div class="text-center py-8">

                    <p class="text-gray-500">
                        Belum ada workshop yang tersedia.
                    </p>

                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                    @foreach ($workshops as $workshop)
                        <div
                            class="bg-white rounded-2xl
                                border border-gray-100
                                shadow-sm
                                p-6
                                hover:shadow-lg
                                transition">

                            {{-- Event --}}
                            <p class="text-sm text-blue-600 font-semibold">
                                {{ $workshop->event->nama_event }}
                            </p>


                            {{-- Judul --}}
                            <h3 class="text-xl font-bold text-gray-800 mt-2">
                                {{ $workshop->judul }}
                            </h3>


                            {{-- Narasumber --}}
                            <p class="text-gray-600 mt-3">
                                🎤 {{ $workshop->narasumber }}
                            </p>


                            {{-- Tanggal --}}
                            <p class="text-gray-500 text-sm mt-2">
                                📅
                                {{ \Carbon\Carbon::parse($workshop->tanggal)->format('d-m-Y') }}
                            </p>


                            {{-- Lokasi --}}
                            <p class="text-gray-500 text-sm mt-1">
                                📍 {{ $workshop->lokasi }}
                            </p>


                            {{-- Kuota --}}
                            <p class="text-gray-500 text-sm mt-1">
                                👥 Kuota: {{ $workshop->kuota }} peserta
                            </p>


                            {{-- Button --}}
                            <div class="mt-6">

                                <a href="{{ route('public.workshop.show', $workshop->id) }}"
                                    class="block text-center
                                       px-5 py-3
                                       bg-blue-600
                                       hover:bg-blue-700
                                       text-white
                                       font-semibold
                                       rounded-xl
                                       transition">
                                    Lihat Detail
                                </a>

                            </div>

                        </div>
                    @endforeach

                </div>

            @endif

        </div>

    </section>

    {{-- FAQ --}}
    <section class="py-16 bg-gray-50" id="faq">

        <div class="max-w-4xl mx-auto px-6">

            <div class="text-center mb-10">

                <p class="text-blue-600 font-semibold">
                    FAQ
                </p>

                <h2 class="text-3xl font-bold text-gray-800 mt-2">
                    Pertanyaan yang Sering Ditanyakan
                </h2>

                <p class="text-gray-500 mt-3">
                    Temukan jawaban dari pertanyaan yang sering ditanyakan
                    mengenai pendaftaran dan kegiatan.
                </p>

            </div>


            @if ($faqs->isEmpty())

                <div class="bg-white rounded-xl shadow-sm p-6 text-center">

                    <p class="text-gray-500">
                        Belum ada FAQ yang tersedia.
                    </p>

                </div>
            @else
                <div class="space-y-4">

                    @foreach ($faqs as $faq)
                        <div x-data="{ open: false }"
                            class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">

                            <button type="button" @click="open = !open"
                                class="w-full flex items-center
                                   justify-between
                                   text-left
                                   px-6 py-5
                                   hover:bg-gray-50
                                   transition">

                                <span class="font-semibold text-gray-800">
                                    {{ $faq->pertanyaan }}
                                </span>

                                <span class="ml-4 text-gray-500 text-xl" x-text="open ? '−' : '+'"></span>

                            </button>


                            <div x-show="open" x-transition class="px-6 pb-5">

                                <p class="text-gray-600 leading-relaxed">
                                    {{ $faq->jawaban }}
                                </p>

                            </div>

                        </div>
                    @endforeach

                </div>

            @endif

        </div>

    </section>

@endsection
