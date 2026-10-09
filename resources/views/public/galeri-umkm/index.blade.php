@extends('public.layouts.app')

@section('title', 'Galeri UMKM')

@section('content')

    <div class="max-w-7xl mx-auto px-6 pt-28 pb-12">

        {{-- ========================================================= --}}
        {{-- HEADER --}}
        {{-- ========================================================= --}}

        <div class="text-center mb-10">

            <p class="text-blue-600 font-semibold text-sm uppercase tracking-wider">
                UMKM Event
            </p>

            <h1 class="mt-2 text-3xl md:text-4xl font-black text-gray-800">
                Galeri UMKM
            </h1>

            <p class="mt-3 text-gray-500 max-w-2xl mx-auto">
                Temukan berbagai UMKM yang telah berpartisipasi
                dalam kegiatan dan event yang diselenggarakan.
            </p>

        </div>


        {{-- ========================================================= --}}
        {{-- JUMLAH UMKM --}}
        {{-- ========================================================= --}}

        <div class="mb-8 text-center">

            <span
                class="inline-flex items-center
                   px-4 py-2
                   rounded-full
                   bg-blue-50
                   text-blue-700
                   text-sm
                   font-semibold">

                {{ $pendaftarans->total() }} UMKM Terdaftar

            </span>

        </div>


        {{-- ========================================================= --}}
        {{-- GALERI --}}
        {{-- ========================================================= --}}

        @if ($pendaftarans->count() > 0)

            <div
                class="
                grid
                grid-cols-2
                sm:grid-cols-3
                md:grid-cols-4
                lg:grid-cols-6
                gap-4
                md:gap-5
            ">

                @foreach ($pendaftarans as $pendaftaran)
                    <a href="{{ route('public.galeri-umkm.show', $pendaftaran->id) }}" class="group block">

                        <div
                            class="
                            bg-white
                            rounded-2xl
                            overflow-hidden
                            border border-gray-100
                            shadow-sm
                            hover:shadow-xl
                            hover:-translate-y-1
                            transition-all
                            duration-300
                        ">

                            {{-- ================================================= --}}
                            {{-- FOTO UMKM --}}
                            {{-- ================================================= --}}

                            <div class="relative aspect-square bg-gray-100 overflow-hidden">

                                @if ($pendaftaran->foto_umkm)
                                    <img src="{{ asset('storage/' . $pendaftaran->foto_umkm) }}"
                                        alt="{{ $pendaftaran->nama_umkm }}"
                                        class="
                                        w-full
                                        h-full
                                        object-cover
                                        group-hover:scale-105
                                        transition-transform
                                        duration-500
                                    ">
                                @else
                                    <div
                                        class="
                                        w-full
                                        h-full
                                        flex
                                        flex-col
                                        items-center
                                        justify-center
                                        bg-gradient-to-br
                                        from-blue-50
                                        to-gray-100
                                    ">

                                        <div class="text-4xl">
                                            🏪
                                        </div>

                                        <p class="text-xs text-gray-400 mt-2">
                                            Tidak ada foto
                                        </p>

                                    </div>
                                @endif


                                {{-- BADGE --}}

                                <div class="absolute top-2 left-2">

                                    <span
                                        class="
                                        inline-flex
                                        px-2 py-1
                                        rounded-full
                                        bg-green-500/90
                                        text-white
                                        text-[10px]
                                        font-bold
                                        backdrop-blur-sm
                                    ">
                                        Terverifikasi
                                    </span>

                                </div>

                            </div>


                            {{-- ================================================= --}}
                            {{-- INFORMASI UMKM --}}
                            {{-- ================================================= --}}

                            <div class="p-3">

                                <h2
                                    class="
                                    text-sm
                                    font-bold
                                    text-gray-800
                                    line-clamp-2
                                    leading-tight
                                ">
                                    {{ $pendaftaran->nama_umkm }}
                                </h2>


                                {{-- Event --}}

                                @if ($pendaftaran->umkm?->event)
                                    <p
                                        class="
                                        mt-2
                                        text-[11px]
                                        text-blue-600
                                        font-semibold
                                        line-clamp-2
                                    ">
                                        {{ $pendaftaran->umkm->event->nama_event }}
                                    </p>
                                @endif


                                {{-- Penyelenggara kegiatan --}}

                                @if ($pendaftaran->umkm?->penyelenggara)
                                    <p
                                        class="
                                        mt-1
                                        text-[10px]
                                        text-gray-400
                                        line-clamp-1
                                    ">
                                        {{ $pendaftaran->umkm->penyelenggara }}
                                    </p>
                                @endif

                            </div>

                        </div>

                    </a>
                @endforeach

            </div>


            {{-- ========================================================= --}}
            {{-- PAGINATION --}}
            {{-- ========================================================= --}}

            <div class="mt-10">

                {{ $pendaftarans->links() }}

            </div>
        @else
            {{-- ========================================================= --}}
            {{-- BELUM ADA UMKM --}}
            {{-- ========================================================= --}}

            <div
                class="
                bg-white
                rounded-3xl
                border border-gray-100
                shadow-sm
                p-12
                text-center
            ">

                <div class="text-6xl mb-4">
                    🏪
                </div>

                <h2 class="text-2xl font-bold text-gray-800">
                    Belum Ada UMKM
                </h2>

                <p class="mt-2 text-gray-500">
                    Belum ada UMKM yang telah terdaftar dan diverifikasi.
                </p>

            </div>

        @endif

    </div>

@endsection
