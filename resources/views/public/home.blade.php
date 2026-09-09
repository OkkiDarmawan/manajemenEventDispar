@extends('public.layouts.app')

@section('content')

    @if ($events->isNotEmpty())

        @include('public.components.hero')

    @else

        <section class="min-h-screen flex items-center justify-center">

            <div class="text-center">

                <h1 class="text-3xl font-bold">
                    Belum Ada Event
                </h1>

                <p class="text-gray-500 mt-3">
                    Silakan kembali lagi nanti.
                </p>

            </div>

        </section>

    @endif

    {{-- ===================================================== --}}
{{-- DAFTAR EVENT --}}
{{-- ===================================================== --}}

<section
    id="event"
    class="py-20 bg-white"
>

    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        {{-- Heading --}}
        <div class="text-center max-w-2xl mx-auto">

            <span
                class="inline-block
                       px-4 py-2
                       rounded-full
                       bg-blue-50
                       text-blue-600
                       text-sm
                       font-semibold"
            >
                EVENT
            </span>

            <h2
                class="mt-4
                       text-3xl md:text-4xl
                       font-bold
                       text-gray-900"
            >
                Event yang Bisa Diikuti
            </h2>

            <p
                class="mt-4
                       text-gray-500
                       leading-relaxed"
            >
                Temukan berbagai event menarik dan ikuti kegiatan
                yang sesuai dengan minat kamu.
            </p>

        </div>


        {{-- Cards --}}
        @if ($events->isEmpty())

            <div
                class="mt-12
                       bg-gray-50
                       rounded-2xl
                       p-10
                       text-center"
            >

                <div class="text-5xl mb-4">
                    📅
                </div>

                <h3
                    class="text-xl
                           font-semibold
                           text-gray-800"
                >
                    Belum Ada Event
                </h3>

                <p
                    class="mt-2
                           text-gray-500"
                >
                    Belum ada event yang tersedia saat ini.
                </p>

            </div>

        @else

            <div
                class="mt-12
                       grid
                       grid-cols-1
                       md:grid-cols-2
                       lg:grid-cols-3
                       gap-7"
            >

                @foreach ($events as $event)

                    <a
                        href="{{ route('public.event.show', $event->id) }}"
                        class="group block"
                    >

                        <div
                            class="bg-white
                                   rounded-2xl
                                   overflow-hidden
                                   border border-gray-100
                                   shadow-sm
                                   hover:shadow-xl
                                   hover:-translate-y-1
                                   transition-all
                                   duration-500"
                        >

                            {{-- Poster --}}
                            <div
                                class="relative
                                       h-64
                                       overflow-hidden"
                            >

                                <img
                                    src="{{ asset('storage/' . $event->poster) }}"
                                    alt="{{ $event->nama_event }}"
                                    class="w-full h-full
                                           object-cover
                                           transition-transform
                                           duration-700
                                           group-hover:scale-105"
                                >


                                {{-- Overlay --}}
                                <div
                                    class="absolute inset-0
                                           bg-gradient-to-t
                                           from-black/70
                                           via-black/10
                                           to-transparent"
                                ></div>


                                {{-- Status --}}
                                <div class="absolute top-4 left-4">

                                    @if (
                                        \Carbon\Carbon::parse($event->tanggal_mulai)->isFuture()
                                    )

                                        <span
                                            class="inline-flex
                                                   items-center
                                                   px-3 py-1.5
                                                   rounded-full
                                                   bg-white/90
                                                   backdrop-blur-sm
                                                   text-blue-600
                                                   text-xs
                                                   font-bold"
                                        >
                                            Coming Soon
                                        </span>

                                    @else

                                        <span
                                            class="inline-flex
                                                   items-center
                                                   px-3 py-1.5
                                                   rounded-full
                                                   bg-green-500/90
                                                   backdrop-blur-sm
                                                   text-white
                                                   text-xs
                                                   font-bold"
                                        >
                                            Event Aktif
                                        </span>

                                    @endif

                                </div>


                                {{-- Judul di poster --}}
                                <div
                                    class="absolute
                                           bottom-0
                                           left-0
                                           right-0
                                           p-5
                                           text-white"
                                >

                                    <h3
                                        class="text-xl
                                               font-bold
                                               line-clamp-2"
                                    >
                                        {{ $event->nama_event }}
                                    </h3>

                                </div>

                            </div>


                            {{-- Content --}}
                            <div class="p-5">

                                <div
                                    class="flex
                                           items-center
                                           gap-2
                                           text-sm
                                           text-gray-500"
                                >

                                    <span>📅</span>

                                    <span>
                                        {{ \Carbon\Carbon::parse($event->tanggal_mulai)->translatedFormat('d F Y') }}
                                    </span>

                                </div>


                                <div
                                    class="flex
                                           items-center
                                           gap-2
                                           mt-2
                                           text-sm
                                           text-gray-500"
                                >

                                    <span>📍</span>

                                    <span>
                                        {{ $event->lokasi ?? 'Lokasi belum ditentukan' }}
                                    </span>

                                </div>


                                {{-- Deskripsi --}}
                                <p
                                    class="mt-4
                                           text-sm
                                           text-gray-600
                                           leading-relaxed
                                           line-clamp-3"
                                >
                                    {{ $event->deskripsi }}
                                </p>


                                {{-- Button --}}
                                <div
                                    class="mt-5
                                           flex
                                           items-center
                                           justify-between"
                                >

                                    <span
                                        class="text-blue-600
                                               font-semibold
                                               text-sm
                                               group-hover:text-blue-700"
                                    >
                                        Lihat Event
                                    </span>

                                    <span
                                        class="text-blue-600
                                               transition-transform
                                               duration-300
                                               group-hover:translate-x-1"
                                    >
                                        →
                                    </span>

                                </div>

                            </div>

                        </div>

                    </a>

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

                        <div
                            x-data="{ open: false }"
                            class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden"
                        >

                            <button
                                type="button"
                                @click="open = !open"
                                class="w-full flex items-center
                                       justify-between
                                       text-left
                                       px-6 py-5
                                       hover:bg-gray-50
                                       transition"
                            >

                                <span class="font-semibold text-gray-800">
                                    {{ $faq->pertanyaan }}
                                </span>

                                <span
                                    class="ml-4 text-gray-500 text-xl"
                                    x-text="open ? '−' : '+'"
                                ></span>

                            </button>


                            <div
                                x-show="open"
                                x-transition
                                class="px-6 pb-5"
                            >

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