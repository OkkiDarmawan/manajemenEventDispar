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

    <section id="event" class="py-20 bg-white" x-data="{
        events: @js($events),
        search: '',
        status: 'all',
    
        filteredEvents() {
            return this.events.filter(event => {
    
                const keyword = this.search.toLowerCase().trim();
    
                const nama = (event.nama_event ?? '').toLowerCase();
                const lokasi = (event.lokasi ?? '').toLowerCase();
                const deskripsi = (event.deskripsi ?? '').toLowerCase();
    
                const cocokSearch =
                    nama.includes(keyword) ||
                    lokasi.includes(keyword) ||
                    deskripsi.includes(keyword);
    
                const mulai = new Date(event.tanggal_mulai);
                const sekarang = new Date();
    
                let cocokStatus = true;
    
                if (this.status === 'active') {
                    cocokStatus = mulai <= sekarang;
                }
    
                if (this.status === 'coming') {
                    cocokStatus = mulai > sekarang;
                }
    
                return cocokSearch && cocokStatus;
            });
        }
    }">

        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            {{-- ================================================= --}}
            {{-- HEADER --}}
            {{-- ================================================= --}}

            <div class="text-center max-w-2xl mx-auto">

                <span
                    class="inline-block
                       px-4 py-2
                       rounded-full
                       bg-blue-50
                       text-blue-600
                       text-sm
                       font-semibold">
                    EVENT
                </span>

                <h2
                    class="mt-4
                       text-3xl
                       md:text-4xl
                       font-bold
                       text-gray-900">
                    Event yang Bisa Diikuti
                </h2>

                <p class="mt-4
                       text-gray-500
                       leading-relaxed">
                    Temukan berbagai event menarik dan ikuti kegiatan
                    yang sesuai dengan minat kamu.
                </p>

            </div>


            {{-- ================================================= --}}
            {{-- FILTER --}}
            {{-- ================================================= --}}

            <div class="mt-10">

                <div
                    class="max-w-4xl
                       mx-auto
                       bg-gray-50
                       border border-gray-100
                       rounded-2xl
                       p-4">

                    <div
                        class="flex
                           flex-col
                           md:flex-row
                           gap-4">

                        {{-- Search --}}
                        <div class="relative flex-1">

                            <span
                                class="absolute
                                   left-4
                                   top-1/2
                                   -translate-y-1/2
                                   text-gray-400">
                                🔎
                            </span>

                            <input type="text" x-model="search" placeholder="Cari nama event, lokasi, atau deskripsi..."
                                class="w-full
                                   pl-11
                                   pr-4
                                   py-3
                                   rounded-xl
                                   border border-gray-200
                                   bg-white
                                   focus:border-blue-500
                                   focus:ring-blue-500">

                        </div>


                        {{-- Status --}}
                        <div class="md:w-56">

                            <select x-model="status"
                                class="w-full
                                   py-3
                                   px-4
                                   rounded-xl
                                   border border-gray-200
                                   bg-white
                                   text-gray-700
                                   focus:border-blue-500
                                   focus:ring-blue-500">

                                <option value="all">
                                    Semua Event
                                </option>

                                <option value="active">
                                    Event Aktif
                                </option>

                                <option value="coming">
                                    Coming Soon
                                </option>

                            </select>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- HASIL FILTER --}}
            {{-- ================================================= --}}

            <div class="mt-8
                   flex
                   items-center
                   justify-between">

                <p class="text-sm text-gray-500">

                    Menampilkan

                    <span class="font-semibold text-gray-800" x-text="filteredEvents().length"></span>

                    event

                </p>

            </div>


            {{-- ================================================= --}}
            {{-- TIDAK ADA EVENT SAMA SEKALI --}}
            {{-- ================================================= --}}

            <template x-if="events.length === 0">

                <div
                    class="mt-8
                       bg-gray-50
                       rounded-2xl
                       p-10
                       text-center">

                    <div class="text-5xl mb-4">
                        📅
                    </div>

                    <h3 class="text-xl
                           font-semibold
                           text-gray-800">
                        Belum Ada Event
                    </h3>

                    <p class="mt-2 text-gray-500">
                        Belum ada event yang tersedia saat ini.
                    </p>

                </div>

            </template>


            {{-- ================================================= --}}
            {{-- TIDAK ADA HASIL FILTER --}}
            {{-- ================================================= --}}

            <template
                x-if="
                events.length > 0 &&
                filteredEvents().length === 0
            ">

                <div
                    class="mt-8
                       bg-gray-50
                       rounded-2xl
                       p-10
                       text-center">

                    <div class="text-5xl mb-4">
                        🔎
                    </div>

                    <h3 class="text-xl
                           font-semibold
                           text-gray-800">
                        Event Tidak Ditemukan
                    </h3>

                    <p class="mt-2 text-gray-500">
                        Coba gunakan kata kunci atau filter lainnya.
                    </p>

                </div>

            </template>


            {{-- ================================================= --}}
            {{-- CARDS --}}
            {{-- ================================================= --}}

            <div x-show="filteredEvents().length > 0"
                class="mt-8
                   grid
                   grid-cols-1
                   md:grid-cols-2
                   lg:grid-cols-3
                   gap-7">

                <template x-for="event in filteredEvents()" :key="event.id">

                    <a :href="'{{ url('/event') }}/' + event.id" class="group block">

                        <div
                            class="bg-white
                               rounded-2xl
                               overflow-hidden
                               border border-gray-100
                               shadow-sm
                               hover:shadow-xl
                               hover:-translate-y-1
                               transition-all
                               duration-500">

                            {{-- Poster --}}
                            <div
                                class="relative
                                   h-64
                                   overflow-hidden">

                                <img :src="'{{ asset('storage') }}/' + event.poster" :alt="event.nama_event"
                                    class="w-full
                                       h-full
                                       object-cover
                                       transition-transform
                                       duration-700
                                       group-hover:scale-105">


                                {{-- Overlay --}}
                                <div
                                    class="absolute
                                       inset-0
                                       bg-gradient-to-t
                                       from-black/70
                                       via-black/10
                                       to-transparent">
                                </div>


                                {{-- Status --}}
                                <div
                                    class="absolute
                                       top-4
                                       left-4">

                                    <template
                                        x-if="
                                        new Date(event.tanggal_mulai)
                                        > new Date()
                                    ">

                                        <span
                                            class="inline-flex
                                               items-center
                                               px-3 py-1.5
                                               rounded-full
                                               bg-white/90
                                               backdrop-blur-sm
                                               text-blue-600
                                               text-xs
                                               font-bold">
                                            Coming Soon
                                        </span>

                                    </template>


                                    <template
                                        x-if="
                                        new Date(event.tanggal_mulai)
                                        <= new Date()
                                    ">

                                        <span
                                            class="inline-flex
                                               items-center
                                               px-3 py-1.5
                                               rounded-full
                                               bg-green-500/90
                                               backdrop-blur-sm
                                               text-white
                                               text-xs
                                               font-bold">
                                            Event Aktif
                                        </span>

                                    </template>

                                </div>


                                {{-- Judul --}}
                                <div
                                    class="absolute
                                       bottom-0
                                       left-0
                                       right-0
                                       p-5
                                       text-white">

                                    <h3 class="text-xl
                                           font-bold
                                           line-clamp-2"
                                        x-text="event.nama_event"></h3>

                                </div>

                            </div>


                            {{-- Content --}}
                            <div class="p-5">

                                {{-- Tanggal --}}
                                <div
                                    class="flex
                                       items-center
                                       gap-2
                                       text-sm
                                       text-gray-500">

                                    <span>📅</span>

                                    <span
                                        x-text="
                                        new Date(
                                            event.tanggal_mulai
                                        ).toLocaleDateString('id-ID', {
                                            day: 'numeric',
                                            month: 'long',
                                            year: 'numeric'
                                        })
                                    "></span>

                                </div>


                                {{-- Lokasi --}}
                                <div
                                    class="flex
                                       items-center
                                       gap-2
                                       mt-2
                                       text-sm
                                       text-gray-500">

                                    <span>📍</span>

                                    <span
                                        x-text="
                                        event.lokasi
                                        || 'Lokasi belum ditentukan'
                                    "></span>

                                </div>


                                {{-- Deskripsi --}}
                                <p class="mt-4
                                       text-sm
                                       text-gray-600
                                       leading-relaxed
                                       line-clamp-3"
                                    x-text="event.deskripsi"></p>


                                {{-- Button --}}
                                <div
                                    class="mt-5
                                       flex
                                       items-center
                                       justify-between">

                                    <span
                                        class="text-blue-600
                                           font-semibold
                                           text-sm">
                                        Lihat Event
                                    </span>

                                    <span
                                        class="text-blue-600
                                           transition-transform
                                           duration-300
                                           group-hover:translate-x-1">
                                        →
                                    </span>

                                </div>

                            </div>

                        </div>

                    </a>

                </template>

            </div>

        </div>

    </section>


    {{-- FAQ --}}

    <section class="py-16 bg-gray-50" id="faq">

        <div class="max-w-4xl mx-auto px-6">

            {{-- Header --}}
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

                {{-- Tidak ada FAQ --}}
                <div class="bg-white rounded-xl shadow-sm p-6 text-center">

                    <p class="text-gray-500">
                        Belum ada FAQ yang tersedia.
                    </p>

                </div>
            @else
                {{-- Search & Filter --}}
                <form method="GET" action="{{ route('home') }}#faq" class="mb-8">

                    <div class="flex flex-col md:flex-row gap-4">

                        {{-- Search --}}
                        <div class="relative flex-1">

                            <div
                                class="absolute inset-y-0 left-0 pl-4
                                   flex items-center
                                   pointer-events-none">

                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0z" />
                                </svg>

                            </div>

                            <input type="text" name="faq_search" value="{{ request('faq_search') }}"
                                placeholder="Cari pertanyaan..."
                                class="w-full
                                   pl-11 pr-4 py-3
                                   rounded-xl
                                   border border-gray-200
                                   bg-white
                                   focus:border-blue-500
                                   focus:ring-blue-500">

                        </div>


                        {{-- Kategori --}}
                        <div class="md:w-56">

                            <select name="faq_kategori"
                                class="w-full
                                   px-4 py-3
                                   rounded-xl
                                   border border-gray-200
                                   bg-white
                                   text-gray-700
                                   focus:border-blue-500
                                   focus:ring-blue-500">

                                <option value="">
                                    Semua Kategori
                                </option>

                                @php
                                    $kategoriFaq = $faqs->pluck('kategori')->filter()->unique()->sort();
                                @endphp

                                @foreach ($kategoriFaq as $kategori)
                                    <option value="{{ $kategori }}"
                                        {{ request('faq_kategori') == $kategori ? 'selected' : '' }}>
                                        {{ $kategori }}
                                    </option>
                                @endforeach

                            </select>

                        </div>


                        {{-- Tombol --}}
                        <button type="submit"
                            class="px-6 py-3
                               rounded-xl
                               bg-blue-600
                               hover:bg-blue-700
                               text-white
                               font-semibold
                               transition">
                            Cari
                        </button>


                        {{-- Reset --}}
                        @if (request('faq_search') || request('faq_kategori'))
                            <a href="{{ route('home') }}#faq"
                                class="px-6 py-3
                                   rounded-xl
                                   bg-gray-100
                                   hover:bg-gray-200
                                   text-gray-700
                                   font-semibold
                                   text-center
                                   transition">
                                Reset
                            </a>
                        @endif

                    </div>

                </form>


                {{-- Info hasil filter --}}
                @if (request('faq_search') || request('faq_kategori'))
                    <div class="mb-5 text-sm text-gray-500">

                        Menampilkan
                        <span class="font-semibold text-gray-700">
                            {{ $faqs->total() }}
                        </span>
                        FAQ

                        @if (request('faq_kategori'))
                            dalam kategori
                            <span class="font-semibold text-blue-600">
                                {{ request('faq_kategori') }}
                            </span>
                        @endif

                        @if (request('faq_search'))
                            untuk pencarian
                            <span class="font-semibold text-blue-600">
                                "{{ request('faq_search') }}"
                            </span>
                        @endif

                    </div>
                @endif


                {{-- Daftar FAQ --}}
                <div class="space-y-4">

                    @foreach ($faqs as $faq)
                        <div x-data="{ open: false }"
                            class="bg-white
                               rounded-xl
                               border border-gray-100
                               shadow-sm
                               overflow-hidden">

                            {{-- Pertanyaan --}}
                            <button type="button" @click="open = !open"
                                class="w-full
                                   flex items-center
                                   justify-between
                                   text-left
                                   px-6 py-5
                                   hover:bg-gray-50
                                   transition">

                                <div class="flex-1">

                                    <div class="flex flex-wrap items-center gap-3">

                                        {{-- Kategori --}}
                                        @if ($faq->kategori)
                                            <span
                                                class="px-2.5 py-1
                                                   rounded-full
                                                   bg-blue-100
                                                   text-blue-700
                                                   text-xs
                                                   font-semibold
                                                   flex-shrink-0">
                                                {{ $faq->kategori }}
                                            </span>
                                        @endif

                                        {{-- Pertanyaan --}}
                                        <span
                                            class="font-semibold
                                               text-gray-800">
                                            {{ $faq->pertanyaan }}
                                        </span>

                                    </div>

                                </div>


                                {{-- Icon --}}
                                <span
                                    class="ml-4
                                       text-gray-500
                                       text-xl
                                       flex-shrink-0"
                                    x-text="open ? '−' : '+'">
                                </span>

                            </button>


                            {{-- Jawaban --}}
                            <div x-show="open" x-transition class="px-6 pb-5">

                                <p class="text-gray-600 leading-relaxed">
                                    {{ $faq->jawaban }}
                                </p>

                            </div>

                        </div>
                    @endforeach

                </div>


                {{-- Pagination --}}
                @if ($faqs->hasPages())
                    <div class="px-6 py-5 border-t border-gray-100">

                        {{ $faqs->onEachSide(1)->links() }}

                    </div>
                @endif

            @endif

        </div>

    </section>


@endsection
