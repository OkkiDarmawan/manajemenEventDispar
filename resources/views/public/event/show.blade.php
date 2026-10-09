@extends('public.layouts.app')

@section('content')
    {{-- ===================================================== --}}
    {{-- HERO EVENT --}}
    {{-- ===================================================== --}}

    @php
        $umkm = $event->umkms->first();

        $today = \Carbon\Carbon::today();

        $umkmTersedia = $umkm !== null;

        $umkmDibuka = false;

        if ($umkm) {
            $mulai = $umkm->pendaftaran_terbuka ? \Carbon\Carbon::parse($umkm->pendaftaran_terbuka) : null;

            $selesai = $umkm->pendaftaran_tertutup ? \Carbon\Carbon::parse($umkm->pendaftaran_tertutup) : null;

            $umkmDibuka =
                (!$mulai || $today->greaterThanOrEqualTo($mulai)) && (!$selesai || $today->lessThanOrEqualTo($selesai));
        }
    @endphp

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

                    <div class="flex flex-wrap items-center gap-2">

                        {{-- Status Event --}}
                        @if (\Carbon\Carbon::parse($event->tanggal_mulai)->isFuture())
                            <span
                                class="
                inline-flex
                px-4 py-2
                rounded-full
                bg-blue-600/90
                backdrop-blur-sm
                text-sm
                font-semibold
            ">
                                Coming Soon
                            </span>
                        @else
                            <span
                                class="
                inline-flex
                px-4 py-2
                rounded-full
                bg-green-500/90
                backdrop-blur-sm
                text-sm
                font-semibold
            ">
                                Event Aktif
                            </span>
                        @endif


                        {{-- Status UMKM --}}
                        @if ($umkmTersedia)
                            @if ($umkmDibuka)
                                <a href="#umkm-section"
                                    class="
                    inline-flex
                    items-center
                    gap-2
                    px-4 py-2
                    rounded-full
                    bg-green-500/90
                    hover:bg-green-500
                    backdrop-blur-sm
                    text-sm
                    font-semibold
                    text-white
                    transition
                ">
                                    🏪 UMKM Dibuka ↓
                                </a>
                            @elseif ($umkm->pendaftaran_terbuka && $today->lt(\Carbon\Carbon::parse($umkm->pendaftaran_terbuka)))
                                <span
                                    class="
                    inline-flex
                    items-center
                    gap-2
                    px-4 py-2
                    rounded-full
                    bg-yellow-500/90
                    backdrop-blur-sm
                    text-sm
                    font-semibold
                ">
                                    🏪 UMKM Akan Dibuka
                                </span>
                            @else
                                <span
                                    class="
                    inline-flex
                    items-center
                    gap-2
                    px-4 py-2
                    rounded-full
                    bg-red-500/90
                    backdrop-blur-sm
                    text-sm
                    font-semibold
                ">
                                    🏪 UMKM Ditutup
                                </span>
                            @endif
                        @else
                            <span
                                class="
                inline-flex
                items-center
                gap-2
                px-4 py-2
                rounded-full
                bg-gray-500/80
                backdrop-blur-sm
                text-sm
                font-semibold
            ">
                                🏪 Tidak Ada UMKM
                            </span>
                        @endif

                    </div>


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

                    @if ($event->link_gmaps)
                        <div class="mt-6 overflow-hidden rounded-2xl border border-gray-200 shadow-sm">
                            <iframe src="{{ $event->link_gmaps }}" width="100%" height="400" style="border:0;"
                                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    @endif

                </div>


                {{-- Informasi --}}
                <div>

                    {{-- Poster UMKM --}}
                    @if (!empty($event->poster))
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-2 overflow-hidden">
                            <img src="{{ asset('storage/' . $event->poster) }}" alt="Poster {{ $event->nama ?? 'UMKM' }}"
                                class="w-full h-auto rounded-xl object-cover hover:scale-[1.02] transition-transform duration-300">
                        </div>
                    @endif

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

                            {{-- Penyelenggara --}}

                            @if ($event->penyelenggara)
                                <div>
                                    <p class="text-xs text-gray-500">
                                        Penyelenggara
                                    </p>

                                    <p class="mt-1 font-semibold text-gray-800">
                                        {{ $event->penyelenggara }}
                                    </p>
                                </div>
                            @endif

                            {{-- Biaya --}}

                            <div>
                                <p class="text-xs text-gray-500">
                                    Biaya
                                </p>

                                <p class="mt-1 font-semibold text-gray-800">
                                    @if ($event->biaya > 0)
                                        Rp {{ number_format($event->biaya, 0, ',', '.') }}
                                    @else
                                        Gratis
                                    @endif
                                </p>
                            </div>



                            {{-- Tanggal --}}
                            <div class="py-5 border-b border-gray-100">

                                <p class="text-sm text-gray-500">
                                    Tanggal
                                </p>

                                <p class="mt-1 font-semibold text-gray-800 leading-relaxed">

                                    {{ \Carbon\Carbon::parse($event->tanggal_mulai)->translatedFormat('d F Y') }}

                                    @if ($event->tanggal_selesai)
                                        -

                                        {{ \Carbon\Carbon::parse($event->tanggal_selesai)->translatedFormat('d F Y') }}
                                    @endif

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

    <section class="py-16 bg-gray-50" x-data="{
        lombas: @js($event->lombas),
        search: '',
        biaya: 'all',
    
        filteredLombas() {
    
            const keyword = this.search
                .toLowerCase()
                .trim();
    
            return this.lombas.filter(lomba => {
    
                const nama = (
                    lomba.nama_lomba ?? ''
                ).toLowerCase();
    
                const deskripsi = (
                    lomba.deskripsi ?? ''
                ).toLowerCase();
    
                const cocokSearch =
                    nama.includes(keyword) ||
                    deskripsi.includes(keyword);
    
    
                let cocokBiaya = true;
    
                if (this.biaya === 'gratis') {
    
                    cocokBiaya =
                        Number(lomba.biaya ?? 0) === 0;
    
                }
    
                if (this.biaya === 'berbayar') {
    
                    cocokBiaya =
                        Number(lomba.biaya ?? 0) > 0;
    
                }
    
    
                return cocokSearch && cocokBiaya;
            });
        }
    }">

        <div class="max-w-7xl mx-auto px-6 lg:px-8">


            {{-- ================================================= --}}
            {{-- HEADER --}}
            {{-- ================================================= --}}

            <div class="text-center">

                <p class="text-blue-600 font-semibold">
                    KOMPETISI
                </p>

                <h2
                    class="mt-2
                       text-3xl
                       font-bold
                       text-gray-900">
                    Lomba yang Tersedia
                </h2>

                <p class="mt-3 text-gray-500">
                    Pilih lomba yang ingin kamu ikuti.
                </p>

            </div>


            {{-- ================================================= --}}
            {{-- FILTER --}}
            {{-- ================================================= --}}

            <div class="mt-10">

                <div
                    class="max-w-4xl
                       mx-auto
                       bg-white
                       border border-gray-100
                       rounded-2xl
                       shadow-sm
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


                            <input type="text" x-model="search" placeholder="Cari nama lomba atau deskripsi..."
                                class="w-full
                                   pl-11
                                   pr-4
                                   py-3
                                   rounded-xl
                                   border border-gray-200
                                   bg-gray-50
                                   focus:border-blue-500
                                   focus:ring-blue-500">

                        </div>


                        {{-- Filter Biaya --}}
                        <div class="md:w-52">

                            <select x-model="biaya"
                                class="w-full
                                   py-3
                                   px-4
                                   rounded-xl
                                   border border-gray-200
                                   bg-gray-50
                                   text-gray-700
                                   focus:border-blue-500
                                   focus:ring-blue-500">

                                <option value="all">
                                    Semua Lomba
                                </option>

                                <option value="gratis">
                                    Gratis
                                </option>

                                <option value="berbayar">
                                    Berbayar
                                </option>

                            </select>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- JUMLAH HASIL --}}
            {{-- ================================================= --}}

            <div class="mt-8">

                <p class="text-sm text-gray-500">

                    Menampilkan

                    <span class="font-semibold text-gray-800" x-text="filteredLombas().length"></span>

                    lomba

                </p>

            </div>


            {{-- ================================================= --}}
            {{-- TIDAK ADA LOMBA --}}
            {{-- ================================================= --}}

            <template x-if="lombas.length === 0">

                <div
                    class="mt-8
                       bg-white
                       rounded-2xl
                       p-10
                       text-center">

                    <div class="text-5xl mb-4">
                        🏆
                    </div>

                    <h3 class="text-xl
                           font-semibold
                           text-gray-800">
                        Belum Ada Lomba
                    </h3>

                    <p class="mt-2 text-gray-500">
                        Belum ada lomba untuk event ini.
                    </p>

                </div>

            </template>


            {{-- ================================================= --}}
            {{-- FILTER TIDAK MENEMUKAN HASIL --}}
            {{-- ================================================= --}}

            <template
                x-if="
                lombas.length > 0 &&
                filteredLombas().length === 0
            ">

                <div
                    class="mt-8
                       bg-white
                       rounded-2xl
                       p-10
                       text-center">

                    <div class="text-5xl mb-4">
                        🔎
                    </div>

                    <h3 class="text-xl
                           font-semibold
                           text-gray-800">
                        Lomba Tidak Ditemukan
                    </h3>

                    <p class="mt-2 text-gray-500">
                        Coba gunakan kata kunci atau filter biaya lainnya.
                    </p>

                </div>

            </template>


            {{-- ================================================= --}}
            {{-- CARDS LOMBA --}}
            {{-- ================================================= --}}

            <div x-show="filteredLombas().length > 0"
                class="mt-8
                   grid
                   grid-cols-1
                   md:grid-cols-2
                   lg:grid-cols-3
                   gap-6">

                <template x-for="lomba in filteredLombas()" :key="lomba.id">

                    <a :href="'{{ url('/lomba') }}/' + lomba.id" class="group">

                        <div
                            class="bg-white
                               rounded-2xl
                               border border-gray-100
                               overflow-hidden
                               shadow-sm
                               hover:shadow-xl
                               hover:-translate-y-1
                               transition-all
                               duration-300">


                            {{-- Poster --}}
                            <div
                                class="relative
                                   h-52
                                   overflow-hidden">

                                <template x-if="lomba.poster">

                                    <img :src="'{{ asset('storage') }}/' + lomba.poster" :alt="lomba.nama_lomba"
                                        class="w-full
                                           h-full
                                           object-cover
                                           transition-transform
                                           duration-700
                                           group-hover:scale-105">

                                </template>


                                <template x-if="!lomba.poster">

                                    <div
                                        class="w-full
                                           h-full
                                           bg-gray-100
                                           flex
                                           items-center
                                           justify-center
                                           text-5xl">
                                        🏆
                                    </div>

                                </template>


                                {{-- Overlay --}}
                                <div
                                    class="absolute
                                       inset-0
                                       bg-gradient-to-t
                                       from-black/60
                                       via-transparent
                                       to-transparent">
                                </div>


                                {{-- Biaya --}}
                                <div
                                    class="absolute
                                       top-4
                                       right-4">

                                    <template
                                        x-if="
                                        Number(lomba.biaya ?? 0) === 0
                                    ">

                                        <span
                                            class="inline-flex
                                               px-3 py-1.5
                                               rounded-full
                                               bg-green-500/90
                                               text-white
                                               text-xs
                                               font-bold">
                                            Gratis
                                        </span>

                                    </template>


                                    <template
                                        x-if="
                                        Number(lomba.biaya ?? 0) > 0
                                    ">

                                        <span
                                            class="inline-flex
                                               px-3 py-1.5
                                               rounded-full
                                               bg-blue-600/90
                                               text-white
                                               text-xs
                                               font-bold">
                                            Berbayar
                                        </span>

                                    </template>

                                </div>

                            </div>


                            {{-- Content --}}
                            <div class="p-6">


                                {{-- Nama Lomba --}}
                                <h3 class="text-xl
                                       font-bold
                                       text-gray-900
                                       group-hover:text-blue-600
                                       transition"
                                    x-text="lomba.nama_lomba"></h3>


                                {{-- Penyelenggara --}}


                                <p class="mt-3 text-sm font-bold text-black" x-text="lomba.penyelenggara">



                                    {{-- Footer --}}
                                <div
                                    class="mt-5
                                       flex
                                       items-center
                                       justify-between">

                                    <span class="text-sm
                                           text-gray-500">
                                        Kuota:
                                        <span x-text="lomba.kuota"></span>
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

                        </div>

                    </a>

                </template>

            </div>

        </div>

    </section>


    {{-- ===================================================== --}}
    {{-- WORKSHOP --}}
    {{-- ===================================================== --}}

    <section class="py-16 bg-white" x-data="{
        workshops: @js($event->workshops),
    
        search: '',
    
        waktu: 'all',
    
    
        filteredWorkshops() {
    
            const keyword = this.search
                .toLowerCase()
                .trim();
    
    
            return this.workshops.filter(workshop => {
    
                const judul = (
                    workshop.judul ?? ''
                ).toLowerCase();
    
                const narasumber = (
                    workshop.narasumber ?? ''
                ).toLowerCase();
    
                const deskripsi = (
                    workshop.deskripsi ?? ''
                ).toLowerCase();
    
                const lokasi = (
                    workshop.lokasi ?? ''
                ).toLowerCase();
    
    
                const cocokSearch =
                    judul.includes(keyword) ||
                    narasumber.includes(keyword) ||
                    deskripsi.includes(keyword) ||
                    lokasi.includes(keyword);
    
    
                let cocokWaktu = true;
    
    
                const tanggalMulai =
                    new Date(workshop.tanggal_mulai);
    
                const tanggalSelesai =
                    new Date(workshop.tanggal_selesai);
    
                const sekarang = new Date();
    
    
                if (this.waktu === 'mendatang') {
    
                    cocokWaktu =
                        sekarang < tanggalMulai;
    
                }
    
    
                if (this.waktu === 'berlangsung') {
    
                    cocokWaktu =
                        sekarang >= tanggalMulai &&
                        sekarang <= tanggalSelesai;
    
                }
    
    
                if (this.waktu === 'selesai') {
    
                    cocokWaktu =
                        sekarang > tanggalSelesai;
    
                }
    
    
                return cocokSearch && cocokWaktu;
    
            });
        },
    
    
        getStatus(workshop) {
    
            const tanggalMulai =
                new Date(workshop.tanggal_mulai);
    
            const tanggalSelesai =
                new Date(workshop.tanggal_selesai);
    
            const sekarang = new Date();
    
    
            if (sekarang < tanggalMulai) {
    
                return 'mendatang';
    
            }
    
    
            if (
                sekarang >= tanggalMulai &&
                sekarang <= tanggalSelesai
            ) {
    
                return 'berlangsung';
    
            }
    
    
            return 'selesai';
    
        }
    }">

        <div class="max-w-7xl mx-auto px-6 lg:px-8">


            {{-- ================================================= --}}
            {{-- HEADER --}}
            {{-- ================================================= --}}

            <div class="text-center">

                <p class="text-blue-600 font-semibold">
                    PEMBELAJARAN
                </p>

                <h2
                    class="mt-2
                       text-3xl
                       font-bold
                       text-gray-900">
                    Workshop yang Tersedia
                </h2>

                <p class="mt-3 text-gray-500">
                    Ikuti workshop yang tersedia dalam event ini.
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


                            <input type="text" x-model="search"
                                placeholder="Cari workshop, narasumber, atau lokasi..."
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


                        {{-- Filter Waktu --}}
                        <div class="md:w-60">

                            <select x-model="waktu"
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
                                    Semua Workshop
                                </option>

                                <option value="mendatang">
                                    Akan Datang
                                </option>

                                <option value="berlangsung">
                                    Sedang Berlangsung
                                </option>

                                <option value="selesai">
                                    Sudah Berlangsung
                                </option>

                            </select>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- JUMLAH HASIL --}}
            {{-- ================================================= --}}

            <div class="mt-8">

                <p class="text-sm text-gray-500">

                    Menampilkan

                    <span class="font-semibold text-gray-800" x-text="filteredWorkshops().length"></span>

                    workshop

                </p>

            </div>


            {{-- ================================================= --}}
            {{-- BELUM ADA WORKSHOP --}}
            {{-- ================================================= --}}

            <template x-if="workshops.length === 0">

                <div
                    class="mt-8
                       bg-gray-50
                       rounded-2xl
                       p-10
                       text-center">

                    <div class="text-5xl mb-4">
                        🎓
                    </div>

                    <h3 class="text-xl
                           font-semibold
                           text-gray-800">
                        Belum Ada Workshop
                    </h3>

                    <p class="mt-2 text-gray-500">
                        Belum ada workshop untuk event ini.
                    </p>

                </div>

            </template>


            {{-- ================================================= --}}
            {{-- HASIL FILTER KOSONG --}}
            {{-- ================================================= --}}

            <template
                x-if="
                workshops.length > 0 &&
                filteredWorkshops().length === 0
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
                        Workshop Tidak Ditemukan
                    </h3>

                    <p class="mt-2 text-gray-500">
                        Coba gunakan kata kunci atau filter waktu lainnya.
                    </p>

                </div>

            </template>


            {{-- ================================================= --}}
            {{-- CARDS WORKSHOP --}}
            {{-- ================================================= --}}

            <div x-show="filteredWorkshops().length > 0"
                class="mt-8
                   grid
                   grid-cols-1
                   md:grid-cols-2
                   lg:grid-cols-3
                   gap-6">

                <template x-for="workshop in filteredWorkshops()" :key="workshop.id">

                    <a :href="'{{ url('/workshop') }}/' + workshop.id" class="group">

                        <div
                            class="bg-white
                               rounded-2xl
                               border border-gray-100
                               overflow-hidden
                               shadow-sm
                               hover:shadow-xl
                               hover:-translate-y-1
                               transition-all
                               duration-300">


                            {{-- ================================================= --}}
                            {{-- POSTER --}}
                            {{-- ================================================= --}}

                            <div
                                class="relative
                                   h-52
                                   overflow-hidden">

                                <template x-if="workshop.poster">

                                    <img :src="'{{ asset('storage') }}/' + workshop.poster" :alt="workshop.judul"
                                        class="w-full
                                           h-full
                                           object-cover
                                           transition-transform
                                           duration-700
                                           group-hover:scale-105">

                                </template>


                                <template x-if="!workshop.poster">

                                    <div
                                        class="w-full
                                           h-full
                                           bg-gray-100
                                           flex
                                           items-center
                                           justify-center
                                           text-5xl">
                                        🎓
                                    </div>

                                </template>


                                {{-- Status --}}
                                <div
                                    class="absolute
                                       top-4
                                       right-4">


                                    {{-- Akan Datang --}}
                                    <template
                                        x-if="
                                        getStatus(workshop)
                                        === 'mendatang'
                                    ">

                                        <span
                                            class="inline-flex
                                               px-3 py-1.5
                                               rounded-full
                                               bg-blue-600/90
                                               text-white
                                               text-xs
                                               font-bold">
                                            Akan Datang
                                        </span>

                                    </template>


                                    {{-- Sedang Berlangsung --}}
                                    <template
                                        x-if="
                                        getStatus(workshop)
                                        === 'berlangsung'
                                    ">

                                        <span
                                            class="inline-flex
                                               px-3 py-1.5
                                               rounded-full
                                               bg-green-500/90
                                               text-white
                                               text-xs
                                               font-bold">
                                            Sedang Berlangsung
                                        </span>

                                    </template>


                                    {{-- Selesai --}}
                                    <template
                                        x-if="
                                        getStatus(workshop)
                                        === 'selesai'
                                    ">

                                        <span
                                            class="inline-flex
                                               px-3 py-1.5
                                               rounded-full
                                               bg-gray-700/90
                                               text-white
                                               text-xs
                                               font-bold">
                                            Sudah Berlangsung
                                        </span>

                                    </template>

                                </div>

                            </div>


                            {{-- ================================================= --}}
                            {{-- CONTENT --}}
                            {{-- ================================================= --}}

                            <div class="p-6">


                                {{-- Judul --}}
                                <h3 class="text-xl
                                       font-bold
                                       text-gray-900
                                       group-hover:text-blue-600
                                       transition"
                                    x-text="workshop.judul"></h3>


                                {{-- Narasumber --}}
                                <p
                                    class="mt-3
                                       text-sm
                                       text-gray-500">
                                    🎤
                                    <span x-text="workshop.narasumber"></span>
                                </p>





                                {{-- Info --}}
                                <div
                                    class="mt-5
                                       space-y-2
                                       text-sm
                                       text-gray-500">


                                    {{-- Tanggal --}}
                                    <div
                                        class="flex
                                           items-start
                                           gap-2">

                                        <span>📅</span>

                                        <span>

                                            <span
                                                x-text="
                                                new Date(
                                                    workshop.tanggal_mulai
                                                ).toLocaleDateString('id-ID', {
                                                    day: 'numeric',
                                                    month: 'long',
                                                    year: 'numeric'
                                                })
                                            "></span>

                                            <span>
                                                -
                                            </span>

                                            <span
                                                x-text="
                                                new Date(
                                                    workshop.tanggal_selesai
                                                ).toLocaleDateString('id-ID', {
                                                    day: 'numeric',
                                                    month: 'long',
                                                    year: 'numeric'
                                                })
                                            "></span>

                                        </span>

                                    </div>


                                    {{-- Lokasi --}}
                                    <div
                                        class="flex
                                           items-center
                                           gap-2">

                                        <span>📍</span>

                                        <span
                                            x-text="
                                            workshop.lokasi
                                            || 'Lokasi belum ditentukan'
                                        "></span>

                                    </div>


                                    {{-- Kuota --}}
                                    <div
                                        class="flex
                                           items-center
                                           gap-2">

                                        <span>👥</span>

                                        <span>

                                            Kuota:

                                            <span x-text="workshop.kuota"></span>

                                            peserta

                                        </span>

                                    </div>

                                </div>


                                {{-- ================================================= --}}
                                {{-- FOOTER --}}
                                {{-- ================================================= --}}

                                <div
                                    class="mt-5
                                       flex
                                       items-center
                                       justify-between">

                                    <span
                                        class="text-blue-600
                                           font-semibold
                                           text-sm">
                                        Lihat Workshop
                                    </span>

                                    <span
                                        class="text-blue-600
                                           group-hover:translate-x-1
                                           transition">
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


    {{-- ===================================================== --}}
    {{-- UMKM --}}
    {{-- ===================================================== --}}

    @if ($umkm)

        <section id="umkm-section" class=" relative py-24 bg-gray-900 bg-cover bg-center overflow-hidden "
            style="background-image:url('{{ asset('images/background bazar.jpeg') }}');">

            {{-- Overlay --}}

            <div class="
                absolute
                inset-0
                bg-black/60
            "></div>


            {{-- Content --}}

            <div
                class="
                relative
                max-w-5xl
                mx-auto
                px-6
                lg:px-8
                text-center
            ">

                {{-- Label --}}

                <span
                    class="
                    inline-flex
                    px-4
                    py-2
                    rounded-full
                    bg-blue-600/90
                    text-white
                    text-sm
                    font-bold
                    backdrop-blur-sm
                ">
                    KEGIATAN UMKM
                </span>


                {{-- Judul --}}

                <h2
                    class="
                    mt-5
                    text-3xl
                    md:text-5xl
                    font-black
                    text-white
                ">
                    {{ $umkm->nama }}
                </h2>


                {{-- Deskripsi --}}


                <p class="mt-5 text-gray-200">
                    Ikuti kegiatan UMKM pada event ini dan
                    manfaatkan kesempatan untuk berpartisipasi.
                </p>



                {{-- ================================================= --}}
                {{-- INFORMASI --}}
                {{-- ================================================= --}}

                <div class="mt-8 flex flex-wrap justify-center gap-3">

                    {{-- Lokasi --}}

                    @if ($umkm->lokasi)
                        <div
                            class="px-4 py-2 rounded-full bg-white/10 border border-white/20 text-white text-sm backdrop-blur-sm">
                            📍 {{ $umkm->lokasi }}
                        </div>
                    @endif


                    {{-- Biaya --}}

                    <div
                        class="px-4 py-2 rounded-full bg-white/10 border border-white/20 text-white text-sm backdrop-blur-sm">
                        💰

                        @if ($umkm->biaya > 0)
                            Rp {{ number_format($umkm->biaya, 0, ',', '.') }}
                        @else
                            Gratis
                        @endif

                    </div>


                    {{-- Kuota --}}

                    <div
                        class="
                        px-4
                        py-2
                        rounded-full
                        bg-white/10
                        border border-white/20
                        text-white
                        text-sm
                        backdrop-blur-sm
                    ">
                        👥

                        @if ($umkm->kuota !== null)
                            {{ $umkm->kuota }} Peserta
                        @else
                            Tanpa Batas
                        @endif

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- PERIODE --}}
                {{-- ================================================= --}}

                @if ($umkm->pendaftaran_terbuka || $umkm->pendaftaran_tertutup)
                    <div class="mt-6 text-gray-200">

                        <p class="text-sm opacity-80">
                            Periode Pendaftaran
                        </p>

                        <p class="mt-1 font-semibold">

                            @if ($umkm->pendaftaran_terbuka)
                                {{ \Carbon\Carbon::parse($umkm->pendaftaran_terbuka)->translatedFormat('d F Y') }}
                            @endif

                            @if ($umkm->pendaftaran_terbuka && $umkm->pendaftaran_tertutup)
                                -
                            @endif

                            @if ($umkm->pendaftaran_tertutup)
                                {{ \Carbon\Carbon::parse($umkm->pendaftaran_tertutup)->translatedFormat('d F Y') }}
                            @endif

                        </p>

                    </div>
                @endif


                {{-- ================================================= --}}
                {{-- BUTTON --}}
                {{-- ================================================= --}}

                <div class="mt-10">

                    @if ($umkmDibuka)
                        <a href="{{ route('public.umkm.show', $umkm->id) }}"
                            class="
                            inline-flex
                            items-center
                            justify-center
                            px-8
                            py-4
                            rounded-2xl
                            bg-blue-600
                            hover:bg-blue-700
                            text-white
                            font-bold
                            shadow-xl
                            hover:-translate-y-1
                            transition-all
                            duration-300
                        ">
                            Lihat & Daftar UMKM
                            <span class="ml-2 text-xl">→</span>
                        </a>
                    @elseif ($umkm->pendaftaran_terbuka && $today->lt(\Carbon\Carbon::parse($umkm->pendaftaran_terbuka)))
                        <div
                            class="
                            inline-flex
                            items-center
                            px-6
                            py-3
                            rounded-xl
                            bg-yellow-500/90
                            text-white
                            font-semibold
                        ">
                            🟡 Pendaftaran Belum Dibuka
                        </div>
                    @else
                        <div
                            class="
                            inline-flex
                            items-center
                            px-6
                            py-3
                            rounded-xl
                            bg-red-500/90
                            text-white
                            font-semibold
                        ">
                            🔴 Pendaftaran Telah Ditutup
                        </div>
                    @endif

                </div>

            </div>

        </section>

    @endif
    @if ($umkm && $umkmDibuka)
        <a href="#umkm-section"
            class="
            fixed
            right-5
            bottom-5
            z-40
            flex
            items-center
            gap-2.5
            px-5
            py-3
            rounded-full
            text-white
            font-bold
            shadow-2xl
            animate-rainbow
            hover:scale-105
            active:scale-95
            transition-transform
            duration-300
        ">

            <span class="text-xl">🏪</span>

            <span class="tracking-wide drop-shadow-sm">
                UMKM Dibuka
            </span>

            <span class="text-lg drop-shadow-sm">
                ↓
            </span>
        </a>
    @endif

@endsection
