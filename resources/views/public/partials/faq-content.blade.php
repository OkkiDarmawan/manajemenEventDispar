{{-- SEARCH & FILTER --}}
<form
    id="faq-form"
    method="GET"
    action="{{ url('/') }}"
    class="mb-8">

    <div class="flex flex-col md:flex-row gap-4">

        {{-- Search --}}
        <div class="relative flex-1">

            <span
                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">

                <svg
                    class="w-5 h-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0z" />

                </svg>

            </span>

            <input
                type="text"
                name="faq_search"
                value="{{ request('faq_search') }}"
                placeholder="Cari pertanyaan atau jawaban..."
                class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 bg-white focus:border-blue-500 focus:ring-blue-500 transition">

        </div>


        {{-- Kategori --}}
        <div class="md:w-56">

            <select
                name="faq_kategori"
                id="faq-kategori"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white text-gray-700 focus:border-blue-500 focus:ring-blue-500 transition">

                <option value="">
                    Semua Kategori
                </option>

                @foreach ($kategoriFaq as $kat)

                    <option
                        value="{{ $kat }}"
                        @selected(request('faq_kategori') === $kat)>

                        {{ $kat }}

                    </option>

                @endforeach

            </select>

        </div>


        {{-- Tombol Cari --}}
        <button
            type="submit"
            class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold transition">

            Cari

        </button>


        {{-- Reset --}}
        @if (request('faq_search') || request('faq_kategori'))

            <button
                type="button"
                id="faq-reset"
                class="px-6 py-3 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold transition">

                Reset

            </button>

        @endif

    </div>

</form>


{{-- INFO JUMLAH --}}
<div class="mb-5 text-sm text-gray-500">

    Menampilkan

    <span class="font-semibold text-gray-800">
        {{ $faqs->count() }}
    </span>

    dari

    <span class="font-semibold text-gray-800">
        {{ $faqs->total() }}
    </span>

    FAQ

</div>


{{-- TIDAK ADA DATA --}}
@if ($faqs->total() === 0)

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-10 text-center">

        <div class="text-5xl mb-4">🔎</div>

        <h3 class="text-xl font-semibold text-gray-800">
            FAQ Tidak Ditemukan
        </h3>

        <p class="mt-2 text-gray-500">
            Tidak ada FAQ yang cocok dengan pencarian Anda.
        </p>

    </div>

@else

    {{-- DAFTAR FAQ --}}
    <div class="space-y-4">

        @foreach ($faqs as $faq)

            <div
                x-data="{ open: false }"
                class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">

                <button
                    type="button"
                    @click="open = !open"
                    class="w-full flex items-center justify-between text-left px-6 py-5 hover:bg-gray-50 transition">

                    <div class="flex-1">

                        <div class="flex flex-wrap items-center gap-3">

                            @if ($faq->kategori)

                                <span
                                    class="px-2.5 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold flex-shrink-0">

                                    {{ $faq->kategori }}

                                </span>

                            @endif

                            <span class="font-semibold text-gray-800">

                                {{ $faq->pertanyaan }}

                            </span>

                        </div>

                    </div>


                    <span
                        class="ml-4 text-gray-500 text-xl flex-shrink-0"
                        x-text="open ? '−' : '+'">

                    </span>

                </button>


                <div
                    x-show="open"
                    x-transition
                    class="px-6 pb-5">

                    <p class="text-gray-600 leading-relaxed">

                        {{ $faq->jawaban }}

                    </p>

                </div>

            </div>

        @endforeach

    </div>


    {{-- PAGINATION --}}
    <div class="mt-8">

        {{ $faqs->links() }}

    </div>

@endif