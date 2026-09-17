@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">


        {{-- ================================================= --}}
        {{-- HEADER --}}
        {{-- ================================================= --}}

        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                Pendaftaran Lomba
            </h1>

            <p class="text-gray-500 mt-1">
                Kelola peserta yang mendaftar pada lomba.
            </p>

        </div>


        {{-- ================================================= --}}
        {{-- FILTER --}}
        {{-- ================================================= --}}

        <div class="bg-white
               rounded-xl
               shadow
               p-6">

            <form action="{{ route('admin.pendaftaran-lomba.index') }}" method="GET"
                class="grid
                   grid-cols-1
                   md:grid-cols-2
                   lg:grid-cols-5
                   gap-4
                   items-end">


                {{-- Search --}}
                <div class="lg:col-span-2">

                    <label
                        class="block
                           text-sm
                           font-medium
                           text-gray-700
                           mb-2">
                        Cari Peserta / Nomor Peserta
                    </label>


                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Nama, NIK, No. HP, atau #Nomor..."
                        class="w-full
                           rounded-lg
                           border-gray-300
                           focus:border-blue-500
                           focus:ring-blue-500">

                </div>


                {{-- Filter Event --}}
                <div>

                    <label
                        class="block
                           text-sm
                           font-medium
                           text-gray-700
                           mb-2">
                        Event
                    </label>


                    <select name="event_id"
                        class="w-full
                           rounded-lg
                           border-gray-300
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


                {{-- Filter Lomba --}}
                <div>

                    <label
                        class="block
                           text-sm
                           font-medium
                           text-gray-700
                           mb-2">
                        Lomba
                    </label>


                    <select name="lomba_id"
                        class="w-full
                           rounded-lg
                           border-gray-300
                           focus:border-blue-500
                           focus:ring-blue-500">

                        <option value="">
                            Semua Lomba
                        </option>


                        @foreach ($lombas as $lomba)
                            <option value="{{ $lomba->id }}" {{ request('lomba_id') == $lomba->id ? 'selected' : '' }}>
                                {{ $lomba->nama_lomba }}
                            </option>
                        @endforeach

                    </select>

                </div>


                {{-- Status --}}
                <div>

                    <label
                        class="block
                           text-sm
                           font-medium
                           text-gray-700
                           mb-2">
                        Status
                    </label>


                    <select name="status"
                        class="w-full
                           rounded-lg
                           border-gray-300
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
                <div class="flex
                       gap-2
                       lg:col-span-5">

                    <button type="submit"
                        class="px-5
                           py-2
                           bg-blue-600
                           hover:bg-blue-700
                           text-white
                           rounded-lg
                           transition">
                        Filter
                    </button>


                    @if (request('search') || request('event_id') || request('lomba_id') || request('status'))
                        <a href="{{ route('admin.pendaftaran-lomba.index') }}"
                            class="px-5
                               py-2
                               bg-gray-200
                               hover:bg-gray-300
                               rounded-lg
                               transition">
                            Reset
                        </a>
                    @endif

                </div>

            </form>

        </div>


        {{-- ================================================= --}}
        {{-- INFO HASIL --}}
        {{-- ================================================= --}}

        <div class="flex
               items-center
               justify-between">

            <p class="text-sm text-gray-500">

                @if (request('search'))
                    Hasil pencarian:
                    <span class="font-semibold text-gray-800">
                        "{{ request('search') }}"
                    </span>
                @else
                    Menampilkan data pendaftaran
                @endif

            </p>


            <p class="text-sm text-gray-500">

                Total:

                <span class="font-semibold text-gray-800">
                    {{ $pendaftarans->total() }}
                </span>

                pendaftaran

            </p>

        </div>


        {{-- ================================================= --}}
        {{-- TABLE --}}
        {{-- ================================================= --}}

        <div class="bg-white
               rounded-xl
               shadow
               overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full">


                    {{-- HEADER TABLE --}}
                    <thead class="bg-gray-50
                           border-b">

                        <tr>

                            <th class="px-6 py-4 text-left">
                                No
                            </th>

                            <th class="px-6 py-4 text-left">
                                Nomor Peserta
                            </th>

                            <th class="px-6 py-4 text-left">
                                Peserta
                            </th>

                            <th class="px-6 py-4 text-left">
                                Lomba
                            </th>

                            <th class="px-6 py-4 text-left">
                                Event
                            </th>

                            <th class="px-6 py-4 text-left">
                                Status
                            </th>

                            <th class="px-6 py-4 text-left">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    {{-- BODY --}}
                    <tbody>

                        @forelse ($pendaftarans as $pendaftaran)
                            <tr class="border-b
                                   hover:bg-gray-50">


                                {{-- No --}}
                                <td class="px-6 py-4">

                                    {{ $pendaftarans->firstItem() + $loop->index }}

                                </td>


                                {{-- Nomor Peserta --}}
                                <td class="px-6 py-4">

                                    @if ($pendaftaran->status === 'Diterima' && $pendaftaran->nomor_peserta)
                                        <span
                                            class="inline-flex
                                               items-center
                                               px-3 py-1
                                               rounded-full
                                               bg-green-100
                                               text-green-700
                                               font-bold">
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

                                    <div class="font-semibold text-gray-800">
                                        {{ $pendaftaran->user->name }}
                                    </div>

                                    <div class="text-xs text-gray-500 mt-1">
                                        NIK: {{ $pendaftaran->user->nik }}
                                    </div>

                                </td>


                                {{-- Lomba --}}
                                <td class="px-6 py-4">

                                    {{ $pendaftaran->lomba->nama_lomba }}

                                </td>


                                {{-- Event --}}
                                <td class="px-6 py-4">

                                    {{ $pendaftaran->lomba->event->nama_event }}

                                </td>


                                {{-- Status --}}
                                <td class="px-6 py-4">

                                    @if ($pendaftaran->status === 'Menunggu')
                                        <span
                                            class="px-3
                                               py-1
                                               text-sm
                                               rounded-full
                                               bg-yellow-100
                                               text-yellow-700">
                                            Menunggu
                                        </span>
                                    @elseif ($pendaftaran->status === 'Diterima')
                                        <span
                                            class="px-3
                                               py-1
                                               text-sm
                                               rounded-full
                                               bg-green-100
                                               text-green-700">
                                            Diterima
                                        </span>
                                    @elseif ($pendaftaran->status === 'Ditolak')
                                        <span
                                            class="px-3
                                               py-1
                                               text-sm
                                               rounded-full
                                               bg-red-100
                                               text-red-700">
                                            Ditolak
                                        </span>
                                    @endif

                                </td>


                                {{-- Aksi --}}
                                <td class="px-6 py-4">

                                    <a href="{{ route('admin.pendaftaran-lomba.show', $pendaftaran->id) }}"
                                        class="px-4
                                           py-2
                                           bg-blue-600
                                           hover:bg-blue-700
                                           text-white
                                           rounded-lg">
                                        Detail
                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7"
                                    class="px-6
                                       py-8
                                       text-center
                                       text-gray-500">
                                    Belum ada pendaftaran.
                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- ================================================= --}}
            {{-- PAGINATION --}}
            {{-- ================================================= --}}

            @if ($pendaftarans->hasPages())
                <div
                    class="px-6
                       py-5
                       border-t
                       border-gray-100">

                    {{ $pendaftarans->links() }}

                </div>
            @endif

        </div>

    </div>
@endsection
