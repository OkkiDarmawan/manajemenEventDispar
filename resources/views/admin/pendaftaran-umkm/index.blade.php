@extends('layouts.admin')

@section('title', 'Pendaftaran UMKM')

@section('content')

    <div class="p-6">

        {{-- Header --}}
        <div class="mb-8">

            <h1 class="text-3xl font-bold text-gray-800">
                Pendaftaran UMKM
            </h1>

            <p class="text-gray-500 mt-2">
                Kelola dan verifikasi pendaftaran UMKM masyarakat.
            </p>

        </div>


        {{-- Search & Filter --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-6">

            <form method="GET" action="{{ route('admin.pendaftaran-umkm.index') }}"
                class="grid grid-cols-1 lg:grid-cols-4 gap-4">

                {{-- Search --}}
                <div class="lg:col-span-2">

                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                        Cari
                    </label>

                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                        placeholder="Nama, NIK, No HP, nomor peserta, UMKM..."
                        class="w-full rounded-xl border-gray-300
                               focus:border-blue-500
                               focus:ring-blue-500">

                </div>


                {{-- Event --}}
                <div>

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


                {{-- UMKM --}}
                <div>

                    <label for="umkm_id" class="block text-sm font-medium text-gray-700 mb-2">
                        UMKM
                    </label>

                    <select name="umkm_id" id="umkm_id"
                        class="w-full rounded-xl border-gray-300
                               focus:border-blue-500
                               focus:ring-blue-500">

                        <option value="">
                            Semua UMKM
                        </option>

                        @foreach ($umkms as $umkm)
                            <option value="{{ $umkm->id }}" {{ request('umkm_id') == $umkm->id ? 'selected' : '' }}>
                                {{ $umkm->nama }}
                            </option>
                        @endforeach

                    </select>

                </div>


                {{-- Status --}}
                <div>

                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Status
                    </label>

                    <select name="status" id="status"
                        class="w-full rounded-xl border-gray-300
                               focus:border-blue-500
                               focus:ring-blue-500">

                        <option value="">
                            Semua Status
                        </option>

                        <option value="Menunggu" {{ request('status') === 'Menunggu' ? 'selected' : '' }}>
                            Menunggu
                        </option>

                        <option value="Diterima" {{ request('status') === 'Diterima' ? 'selected' : '' }}>
                            Diterima
                        </option>

                        <option value="Ditolak" {{ request('status') === 'Ditolak' ? 'selected' : '' }}>
                            Ditolak
                        </option>

                    </select>

                </div>


                {{-- Button --}}
                <div class="flex items-end gap-2 lg:col-span-3">

                    <button type="submit"
                        class="px-5 py-3 rounded-xl
                               bg-blue-600 hover:bg-blue-700
                               text-white font-semibold">
                        Cari
                    </button>

                    @if (request('search') || request('event_id') || request('umkm_id') || request('status'))
                        <a href="{{ route('admin.pendaftaran-umkm.index') }}"
                            class="px-5 py-3 rounded-xl
                                   bg-gray-100 hover:bg-gray-200
                                   text-gray-700 font-semibold">
                            Reset
                        </a>
                    @endif

                </div>

            </form>

        </div>

        <a href="{{ route('admin.pendaftaran-umkm.export', request()->except('page')) }}"
            class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition">
            Export Excel
        </a>


        {{-- Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full text-left">

                    <thead class="bg-gray-100 border-b">

                        <tr>

                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">
                                No
                            </th>

                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">
                                Nomor Peserta
                            </th>

                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">
                                Peserta
                            </th>

                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">
                                UMKM
                            </th>

                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">
                                Event
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

                        @forelse ($pendaftarans as $pendaftaran)
                            <tr class="hover:bg-gray-50">

                                {{-- No --}}
                                <td class="px-6 py-4">
                                    {{ $pendaftarans->firstItem() + $loop->index }}
                                </td>


                                {{-- Nomor Peserta --}}
                                <td class="px-6 py-4">

                                    @if ($pendaftaran->nomor_peserta)
                                        <span class="font-bold text-blue-600">
                                            #{{ $pendaftaran->nomor_peserta }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">
                                            -
                                        </span>
                                    @endif

                                </td>


                                {{-- Peserta --}}
                                <td class="px-6 py-4">

                                    <p class="font-semibold text-gray-800">
                                        {{ $pendaftaran->user->name }}
                                    </p>

                                    <p class="text-sm text-gray-500">
                                        {{ $pendaftaran->user->nik }}
                                    </p>

                                </td>


                                {{-- UMKM --}}
                                <td class="px-6 py-4">

                                    <p class="font-semibold text-gray-800">
                                        {{ $pendaftaran->umkm->nama }}
                                    </p>

                                </td>


                                {{-- Event --}}
                                <td class="px-6 py-4">

                                    <span class="text-gray-700">
                                        {{ $pendaftaran->umkm->event->nama_event }}
                                    </span>

                                </td>


                                {{-- Status --}}
                                <td class="px-6 py-4">

                                    @if ($pendaftaran->status === 'Menunggu')
                                        <span
                                            class="px-3 py-1 rounded-full
                                                   bg-yellow-100
                                                   text-yellow-700
                                                   text-sm">
                                            Menunggu
                                        </span>
                                    @elseif ($pendaftaran->status === 'Diterima')
                                        <span
                                            class="px-3 py-1 rounded-full
                                                   bg-green-100
                                                   text-green-700
                                                   text-sm">
                                            Diterima
                                        </span>
                                    @else
                                        <span
                                            class="px-3 py-1 rounded-full
                                                   bg-red-100
                                                   text-red-700
                                                   text-sm">
                                            Ditolak
                                        </span>
                                    @endif

                                </td>


                                {{-- Aksi --}}
                                <td class="px-6 py-4">

                                    <a href="{{ route('admin.pendaftaran-umkm.show', $pendaftaran->id) }}"
                                        class="px-3 py-2
                                               rounded-lg
                                               bg-blue-600
                                               hover:bg-blue-700
                                               text-white">
                                        Detail
                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                    Tidak ada data pendaftaran UMKM.

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}
            @if ($pendaftarans->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">

                    {{ $pendaftarans->onEachSide(1)->links() }}

                </div>
            @endif

        </div>

    </div>

@endsection
