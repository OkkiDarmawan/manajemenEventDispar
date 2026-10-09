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
                Temukan jawaban dari pertanyaan yang sering ditanyakan mengenai
                pendaftaran dan kegiatan.
            </p>

        </div>


        {{-- ISI FAQ --}}
        <div id="faq-content">

            @include('public.partials.faq-content')

        </div>

    </div>

</section>
@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    const faqContent = document.getElementById('faq-content');

    if (!faqContent) {
        return;
    }


    // Fungsi memuat FAQ tanpa refresh halaman
    async function loadFaq(url) {

        try {

            faqContent.style.opacity = '0.5';
            faqContent.style.pointerEvents = 'none';

            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                }
            });

            if (!response.ok) {
                throw new Error('Gagal memuat FAQ.');
            }

            const html = await response.text();

            faqContent.innerHTML = html;

            // Aktifkan kembali Alpine pada elemen yang baru
            if (window.Alpine) {
                Alpine.initTree(faqContent);
            }

            faqContent.style.opacity = '1';
            faqContent.style.pointerEvents = 'auto';

        } catch (error) {

            console.error(error);

            faqContent.style.opacity = '1';
            faqContent.style.pointerEvents = 'auto';

        }
    }


    // Submit Search
    faqContent.addEventListener('submit', function (event) {

        if (!event.target.matches('#faq-form')) {
            return;
        }

        event.preventDefault();

        const form = event.target;

        const params = new URLSearchParams(
            new FormData(form)
        );

        loadFaq(
            `${form.action}?${params.toString()}`
        );

    });


    // Filter kategori langsung jalan
    faqContent.addEventListener('change', function (event) {

        if (!event.target.matches('#faq-kategori')) {
            return;
        }

        const form = document.getElementById('faq-form');

        const params = new URLSearchParams(
            new FormData(form)
        );

        // Reset pagination ke halaman 1 saat filter berubah
        params.delete('faq_page');

        loadFaq(
            `${form.action}?${params.toString()}`
        );

    });


    // Tombol reset
    faqContent.addEventListener('click', function (event) {

        if (!event.target.matches('#faq-reset')) {
            return;
        }

        loadFaq('{{ url('/') }}');

    });


    // Pagination tanpa refresh
    faqContent.addEventListener('click', function (event) {

        const link = event.target.closest('.pagination a');

        if (!link) {
            return;
        }

        event.preventDefault();

        loadFaq(link.href);

    });

});
</script>

@endpush

@endsection
