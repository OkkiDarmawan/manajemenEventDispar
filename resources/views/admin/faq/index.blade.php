@extends('layouts.admin')

@section('title', 'Kelola FAQ')

@section('content')

    <div class="p-6">

        {{-- Header --}}
        <div
            class="flex flex-col md:flex-row
                   md:items-center
                   md:justify-between
                   gap-4 mb-8">

            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Kelola FAQ
                </h1>

                <p class="text-gray-500 mt-2">
                    Kelola pertanyaan yang sering ditanyakan masyarakat.
                </p>
            </div>

            <a href="{{ route('admin.faq.create') }}"
                class="inline-flex items-center justify-center
                       px-5 py-3
                       rounded-xl
                       bg-blue-600
                       hover:bg-blue-700
                       text-white font-semibold
                       transition">
                + Tambah FAQ
            </a>

        </div>


        {{-- Search & Filter --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-6">

            <form method="GET" action="{{ route('admin.faq.index') }}" class="flex flex-col lg:flex-row gap-4">

                {{-- Search --}}
                <div class="flex-1">

                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                        Cari FAQ
                    </label>

                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                        placeholder="Cari kategori, pertanyaan, atau jawaban..."
                        class="w-full rounded-xl border-gray-300
                               focus:border-blue-500
                               focus:ring-blue-500">

                </div>


                {{-- Kategori --}}
                <div class="w-full lg:w-64">

                    <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori
                    </label>

                    <select name="kategori" id="kategori"
                        class="w-full rounded-xl border-gray-300
                               focus:border-blue-500
                               focus:ring-blue-500">

                        <option value="">
                            Semua Kategori
                        </option>

                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>
                                {{ $kategori }}
                            </option>
                        @endforeach

                    </select>

                </div>


                {{-- Tombol --}}
                <div class="flex items-end gap-2">

                    <button type="submit"
                        class="px-5 py-3
                               rounded-xl
                               bg-blue-600
                               hover:bg-blue-700
                               text-white
                               font-semibold
                               transition">
                        Cari
                    </button>

                    @if (request('search') || request('kategori'))
                        <a href="{{ route('admin.faq.index') }}"
                            class="px-5 py-3
                                   rounded-xl
                                   bg-gray-100
                                   hover:bg-gray-200
                                   text-gray-700
                                   font-semibold
                                   transition">
                            Reset
                        </a>
                    @endif

                </div>

            </form>

        </div>


        {{-- Hasil pencarian --}}
        @if (request('search') || request('kategori'))

            <div class="mb-5 text-sm text-gray-500">

                Menampilkan
                <span class="font-semibold text-gray-800">
                    {{ $faqs->total() }}
                </span>
                FAQ

                @if (request('search'))
                    untuk pencarian
                    <span class="font-semibold text-blue-600">
                        "{{ request('search') }}"
                    </span>
                @endif

                @if (request('kategori'))
                    dalam kategori
                    <span class="font-semibold text-blue-600">
                        {{ request('kategori') }}
                    </span>
                @endif

            </div>

        @endif


        {{-- Table --}}
        <div
            class="bg-white rounded-2xl
                   shadow-sm
                   border border-gray-100
                   overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full text-left">

                    <thead class="bg-gray-100 border-b">

                        <tr>

                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">
                                No
                            </th>

                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">
                                Kategori
                            </th>

                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">
                                Pertanyaan
                            </th>

                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">
                                Urutan
                            </th>

                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">
                                Status
                            </th>

                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y">

                        @forelse ($faqs as $faq)
                            <tr class="hover:bg-gray-50">

                                {{-- No --}}
                                <td class="px-6 py-4">
                                    {{ $faqs->firstItem() + $loop->index }}
                                </td>


                                {{-- Kategori --}}
                                <td class="px-6 py-4">

                                    @if ($faq->kategori)
                                        <span
                                            class="inline-flex items-center
                                                   px-3 py-1
                                                   rounded-full
                                                   bg-blue-100
                                                   text-blue-700
                                                   text-sm font-medium">
                                            {{ $faq->kategori }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-sm">
                                            -
                                        </span>
                                    @endif

                                </td>


                                {{-- Pertanyaan --}}
                                <td class="px-6 py-4">

                                    <p class="font-semibold text-gray-800">
                                        {{ $faq->pertanyaan }}
                                    </p>

                                </td>


                                {{-- Urutan --}}
                                <td class="px-6 py-4">
                                    {{ $faq->urutan }}
                                </td>


                                {{-- Status --}}
                                <td class="px-6 py-4">

                                    @if ($faq->is_active)
                                        <span
                                            class="px-3 py-1
                                                   rounded-full
                                                   bg-green-100
                                                   text-green-700
                                                   text-sm">
                                            Aktif
                                        </span>
                                    @else
                                        <span
                                            class="px-3 py-1
                                                   rounded-full
                                                   bg-gray-100
                                                   text-gray-600
                                                   text-sm">
                                            Nonaktif
                                        </span>
                                    @endif

                                </td>


                                {{-- Aksi --}}
                                <td class="px-6 py-4">

                                    <div class="flex items-center gap-2">

                                        <a href="{{ route('admin.faq.edit', $faq->id) }}"
                                            class="px-3 py-2
                                                   rounded-lg
                                                   bg-yellow-500
                                                   hover:bg-yellow-600
                                                   text-white">
                                            Edit
                                        </a>


                                        <form id="delete-form-{{ $faq->id }}"
                                            action="{{ route('admin.faq.destroy', $faq->id) }}" method="POST">

                                            @csrf
                                            @method('DELETE')

                                            <button type="button" onclick="confirmDelete({{ $faq->id }})"
                                                class="px-3 py-1
                                                       bg-red-600
                                                       hover:bg-red-700
                                                       text-white
                                                       rounded">
                                                Hapus
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6"
                                    class="px-6 py-10
                                           text-center
                                           text-gray-500">

                                    @if (request('search') || request('kategori'))
                                        FAQ yang dicari tidak ditemukan.
                                    @else
                                        Belum ada FAQ.
                                    @endif

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}
            @if ($faqs->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">

                    {{ $faqs->onEachSide(1)->links() }}

                </div>
            @endif

        </div>

    </div>

@endsection
