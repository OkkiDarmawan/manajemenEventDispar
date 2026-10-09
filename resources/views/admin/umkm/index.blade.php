@extends('layouts.admin')

@section('title', 'Kelola UMKM')

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
                    Kelola UMKM
                </h1>

                <p class="text-gray-500 mt-2">
                    Kelola kegiatan dan pendaftaran UMKM pada setiap event.
                </p>

            </div>

            <a href="{{ route('admin.umkm.create') }}"
                class="inline-flex items-center justify-center
                       px-5 py-3
                       rounded-xl
                       bg-blue-600
                       hover:bg-blue-700
                       text-white
                       font-semibold
                       transition">
                + Tambah UMKM
            </a>

        </div>


        {{-- Summary --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

            {{-- Total UMKM --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

                <p class="text-sm text-gray-500">
                    Total UMKM
                </p>

                <p class="text-3xl font-bold text-gray-800 mt-2">
                    {{ $totalUmkm }}
                </p>

            </div>


            {{-- Total Kuota --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

                <p class="text-sm text-gray-500">
                    Total Kuota
                </p>

                <p class="text-3xl font-bold text-gray-800 mt-2">
                    {{ $totalKuota }}
                </p>

            </div>

        </div>


        {{-- Search & Filter --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-6">

            <form method="GET" action="{{ route('admin.umkm.index') }}" class="flex flex-col lg:flex-row gap-4">

                {{-- Search --}}
                <div class="flex-1">

                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                        Cari UMKM
                    </label>

                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                        placeholder="Cari nama UMKM atau event..."
                        class="w-full rounded-xl border-gray-300
                               focus:border-blue-500
                               focus:ring-blue-500">

                </div>


                {{-- Filter Event --}}
                <div class="w-full lg:w-64">

                    <label for="event_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Event
                    </label>

                    <select name="event_id" id="event_id"
                        class="w-full rounded-xl border-gray-300
                               focus:border-blue-500
                               focus:ring-blue-500">

                        <option value="">
                            Semua Event
                        </option>

                        @foreach ($events as $event)
                            <option value="{{ $event->id }}" {{ request('event_id') == $event->id ? 'selected' : '' }}>
                                {{ $event->nama_event }}
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


                    @if (request('search') || request('event_id'))
                        <a href="{{ route('admin.umkm.index') }}"
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


        {{-- Info hasil filter --}}
        @if (request('search') || request('event_id'))

            <div class="mb-5 text-sm text-gray-500">

                Menampilkan
                <span class="font-semibold text-gray-800">
                    {{ $umkms->total() }}
                </span>
                UMKM

                @if (request('search'))
                    untuk pencarian
                    <span class="font-semibold text-blue-600">
                        "{{ request('search') }}"
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
                                Nama UMKM
                            </th>

                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">
                                Event
                            </th>

                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">
                                Kuota
                            </th>

                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">
                                Biaya
                            </th>

                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">
                                Periode
                            </th>

                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y">

                        @forelse ($umkms as $umkm)
                            <tr class="hover:bg-gray-50">

                                {{-- No --}}
                                <td class="px-6 py-4">
                                    {{ $umkms->firstItem() + $loop->index }}
                                </td>


                                {{-- Nama --}}
                                <td class="px-6 py-4">

                                    <div class="flex items-center gap-3">

                                        @if ($umkm->poster)
                                            <img src="{{ asset('storage/' . $umkm->poster) }}" alt="{{ $umkm->nama }}"
                                                class="w-12 h-12
                                                       rounded-lg
                                                       object-cover
                                                       border border-gray-200">
                                        @else
                                            <div
                                                class="w-12 h-12
                                                       rounded-lg
                                                       bg-gray-100
                                                       flex items-center
                                                       justify-center
                                                       text-gray-400">
                                                -
                                            </div>
                                        @endif


                                        <div>

                                            <p class="font-semibold text-gray-800">
                                                {{ $umkm->nama }}
                                            </p>

                                        </div>

                                    </div>

                                </td>


                                {{-- Event --}}
                                <td class="px-6 py-4">

                                    <span class="text-gray-700">
                                        {{ $umkm->event->nama_event }}
                                    </span>

                                </td>


                                {{-- Kuota --}}
                                <td class="px-6 py-4">

                                    @if ($umkm->kuota)
                                        {{ $umkm->kuota }} orang
                                    @else
                                        -
                                    @endif

                                </td>


                                {{-- Biaya --}}
                                <td class="px-6 py-4">

                                    @if ($umkm->biaya > 0)
                                        Rp {{ number_format($umkm->biaya, 0, ',', '.') }}
                                    @else
                                        <span class="text-green-600 font-medium">
                                            Gratis
                                        </span>
                                    @endif

                                </td>


                                {{-- Periode --}}
                                <td class="px-6 py-4">

                                    @if ($umkm->pendaftaran_terbuka && $umkm->pendaftaran_tertutup)
                                        <p class="text-sm text-gray-700">
                                            {{ \Carbon\Carbon::parse($umkm->pendaftaran_terbuka)->translatedFormat('d F Y') }}
                                        </p>

                                        <p class="text-sm text-gray-400">
                                            s/d
                                        </p>

                                        <p class="text-sm text-gray-700">
                                            {{ \Carbon\Carbon::parse($umkm->pendaftaran_tertutup)->translatedFormat('d F Y') }}
                                        </p>
                                    @else
                                        <span class="text-gray-400">
                                            -
                                        </span>
                                    @endif

                                </td>


                                {{-- Aksi --}}
                                <td class="px-6 py-4">

                                    <div class="flex justify-center items-center gap-2">




                                        <a href="{{ route('admin.umkm.field', $umkm->id) }}"
                                            class="px-3 py-1 bg-indigo-600 hover:bg-indigo-700 text-white text-center rounded-lg">

                                            Kelola Field

                                        </a>

                                        <a href="{{ route('admin.umkm.edit', $umkm->id) }}"
                                            class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white text-center rounded">

                                            Edit

                                        </a>


                                        <form id="delete-form-{{ $umkm->id }}"
                                            action="{{ route('admin.umkm.destroy', $umkm->id) }}" method="POST">

                                            @csrf
                                            @method('DELETE')

                                            <button type="button" onclick="confirmDelete({{ $umkm->id }})"
                                                class="px-3 py-2
                                                       rounded-lg
                                                       bg-red-600
                                                       hover:bg-red-700
                                                       text-white">
                                                Hapus
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7"
                                    class="px-6 py-10
                                           text-center
                                           text-gray-500">

                                    @if (request('search') || request('event_id'))
                                        Data UMKM tidak ditemukan.
                                    @else
                                        Belum ada data UMKM.
                                    @endif

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}
            @if ($umkms->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">

                    {{ $umkms->onEachSide(1)->links() }}

                </div>
            @endif

        </div>

    </div>

@endsection
