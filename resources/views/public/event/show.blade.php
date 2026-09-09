@extends('public.layouts.app')

@section('content')

    {{-- ===================================================== --}}
    {{-- HERO EVENT --}}
    {{-- ===================================================== --}}

    <section class="relative">

        {{-- Poster --}}
        <div class="relative h-[500px] overflow-hidden">

            <img src="{{ asset('storage/' . $event->poster) }}" alt="{{ $event->nama_event }}"
                class="w-full h-full object-cover">

            {{-- Overlay --}}
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/20"></div>


            {{-- Content --}}
            <div class="absolute inset-0 flex items-center">

                <div class="max-w-7xl w-full mx-auto px-6 lg:px-8 pb-14 text-white">

                    {{-- Status --}}
                    @if (\Carbon\Carbon::parse($event->tanggal_mulai)->isFuture())
                        <span
                            class="inline-flex px-4 py-2 rounded-full bg-blue-600/90 backdrop-blur-sm text-sm font-semibold">
                            Coming Soon
                        </span>
                    @else
                        <span
                            class="inline-flex px-4 py-2 rounded-full bg-green-500/90 backdrop-blur-sm text-sm font-semibold">
                            Event Aktif
                        </span>
                    @endif


                    {{-- Nama Event --}}
                    <h1
                        class="mt-4
                               text-4xl
                               md:text-5xl
                               lg:text-6xl
                               font-black
                               leading-tight">
                        {{ $event->nama_event }}
                    </h1>


                    {{-- Tanggal --}}
                    <div
                        class="mt-5
                               flex flex-wrap
                               gap-4
                               text-gray-200">

                        <span>
                            📅
                            {{ \Carbon\Carbon::parse($event->tanggal_mulai)->translatedFormat('d F Y') }}
                        </span>

                        <span>
                            Sampai
                            {{ \Carbon\Carbon::parse($event->tanggal_selesai)->translatedFormat('d F Y') }}
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- ===================================================== --}}
    {{-- INFORMASI EVENT --}}
    {{-- ===================================================== --}}

    <section class="py-16 bg-white">

        <div class="max-w-7xl
                   mx-auto
                   px-6
                   lg:px-8">

            <div
                class="grid
                       grid-cols-1
                       lg:grid-cols-3
                       gap-10">

                {{-- Deskripsi --}}
                <div class="lg:col-span-2">

                    <p class="text-blue-600
                               font-semibold">
                        TENTANG EVENT
                    </p>

                    <h2
                        class="mt-2
                               text-3xl
                               font-bold
                               text-gray-900">
                        {{ $event->nama_event }}
                    </h2>

                    <p
                        class="mt-5
                               text-gray-600
                               leading-relaxed">
                        {{ $event->deskripsi }}
                    </p>

                </div>


                {{-- Informasi --}}
                <div>

                    <div
                        class="bg-gray-50
                               rounded-2xl
                               p-6
                               border
                               border-gray-100">

                        <h3
                            class="font-bold
                                   text-gray-900
                                   text-lg">
                            Informasi Event
                        </h3>


                        <div class="mt-5 space-y-4">

                            <div>

                                <p class="text-xs
                                           text-gray-500">
                                    Tanggal Mulai
                                </p>

                                <p
                                    class="mt-1
                                           font-semibold
                                           text-gray-800">
                                    {{ \Carbon\Carbon::parse($event->tanggal_mulai)->translatedFormat('d F Y') }}
                                </p>

                            </div>


                            <div>

                                <p class="text-xs
                                           text-gray-500">
                                    Tanggal Selesai
                                </p>

                                <p
                                    class="mt-1
                                           font-semibold
                                           text-gray-800">
                                    {{ \Carbon\Carbon::parse($event->tanggal_selesai)->translatedFormat('d F Y') }}
                                </p>

                            </div>


                            @if ($event->lokasi)
                                <div>

                                    <p class="text-xs
                                               text-gray-500">
                                        Lokasi
                                    </p>

                                    <p
                                        class="mt-1
                                               font-semibold
                                               text-gray-800">
                                        📍 {{ $event->lokasi }}
                                    </p>

                                </div>
                            @endif

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- ===================================================== --}}
    {{-- LOMBA --}}
    {{-- ===================================================== --}}

    <section class="py-16 bg-gray-50">

        <div class="max-w-7xl
                   mx-auto
                   px-6
                   lg:px-8">

            <div class="text-center">

                <p class="text-blue-600
                           font-semibold">
                    KOMPETISI
                </p>

                <h2
                    class="mt-2
                           text-3xl
                           font-bold
                           text-gray-900">
                    Lomba yang Tersedia
                </h2>

                <p class="mt-3
                           text-gray-500">
                    Pilih lomba yang ingin kamu ikuti.
                </p>

            </div>


            @if ($event->lombas->isEmpty())
                <div
                    class="mt-10
                           bg-white
                           rounded-2xl
                           p-10
                           text-center">

                    <p class="text-gray-500">
                        Belum ada lomba untuk event ini.
                    </p>

                </div>
            @else
                <div
                    class="mt-10
                           grid
                           grid-cols-1
                           md:grid-cols-2
                           lg:grid-cols-3
                           gap-6">

                    @foreach ($event->lombas as $lomba)
                        <a href="{{ route('public.lomba.show', $lomba->id) }}" class="group">

                            <div
                                class="bg-white
                                       rounded-2xl
                                       border
                                       border-gray-100
                                       p-6
                                       shadow-sm
                                       hover:shadow-xl
                                       hover:-translate-y-1
                                       transition-all
                                       duration-300">

                                <div
                                    class="w-12 h-12
                                           rounded-xl
                                           bg-blue-50
                                           flex
                                           items-center
                                           justify-center
                                           text-2xl">
                                    🏆
                                </div>


                                <h3
                                    class="mt-5
                                           text-xl
                                           font-bold
                                           text-gray-900
                                           group-hover:text-blue-600">
                                    {{ $lomba->nama_lomba }}
                                </h3>


                                <p
                                    class="mt-3
                                           text-sm
                                           text-gray-500
                                           line-clamp-3">
                                    {{ $lomba->deskripsi }}
                                </p>


                                <div
                                    class="mt-5
                                           flex
                                           items-center
                                           justify-between">

                                    <span class="text-sm
                                               text-gray-500">
                                        Kuota:
                                        {{ $lomba->kuota }}
                                    </span>

                                    <span
                                        class="text-blue-600
                                               font-semibold
                                               group-hover:translate-x-1
                                               transition">
                                        Lihat →
                                    </span>

                                </div>

                            </div>

                        </a>
                    @endforeach

                </div>
            @endif

        </div>

    </section>


    {{-- ===================================================== --}}
    {{-- WORKSHOP --}}
    {{-- ===================================================== --}}

    <section class="py-16 bg-white">

        <div class="max-w-7xl
                   mx-auto
                   px-6
                   lg:px-8">

            <div class="text-center">

                <p class="text-blue-600
                           font-semibold">
                    PEMBELAJARAN
                </p>

                <h2
                    class="mt-2
                           text-3xl
                           font-bold
                           text-gray-900">
                    Workshop yang Tersedia
                </h2>

                <p class="mt-3
                           text-gray-500">
                    Ikuti workshop yang tersedia dalam event ini.
                </p>

            </div>


            @if ($event->workshops->isEmpty())
                <div
                    class="mt-10
                           bg-gray-50
                           rounded-2xl
                           p-10
                           text-center">

                    <p class="text-gray-500">
                        Belum ada workshop untuk event ini.
                    </p>

                </div>
            @else
                <div
                    class="mt-10
                           grid
                           grid-cols-1
                           md:grid-cols-2
                           lg:grid-cols-3
                           gap-6">

                    @foreach ($event->workshops as $workshop)
                        <a href="{{ route('public.workshop.show', $workshop->id) }}" class="group">

                            <div
                                class="bg-white
                                       rounded-2xl
                                       border
                                       border-gray-100
                                       p-6
                                       shadow-sm
                                       hover:shadow-xl
                                       hover:-translate-y-1
                                       transition-all
                                       duration-300">

                                <div
                                    class="w-12 h-12
                                           rounded-xl
                                           bg-blue-50
                                           flex
                                           items-center
                                           justify-center
                                           text-2xl">
                                    🎓
                                </div>


                                <h3
                                    class="mt-5
                                           text-xl
                                           font-bold
                                           text-gray-900
                                           group-hover:text-blue-600">
                                    {{ $workshop->judul }}
                                </h3>


                                <p
                                    class="mt-3
                                           text-sm
                                           text-gray-500
                                           line-clamp-3">
                                    {{ $workshop->deskripsi }}
                                </p>


                                <div
                                    class="mt-5
                                           flex
                                           items-center
                                           justify-between">

                                    <span class="text-sm
                                               text-gray-500">
                                        Kuota:
                                        {{ $workshop->kuota }}
                                    </span>

                                    <span
                                        class="text-blue-600
                                               font-semibold
                                               group-hover:translate-x-1
                                               transition">
                                        Lihat →
                                    </span>

                                </div>

                            </div>

                        </a>
                    @endforeach

                </div>
            @endif

        </div>

    </section>

@endsection
