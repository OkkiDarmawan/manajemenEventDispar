@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">


        {{-- ================================================= --}}
        {{-- HEADER --}}
        {{-- ================================================= --}}

        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                Pendaftaran Workshop
            </h1>

            <p class="text-gray-500 mt-1">
                Kelola peserta yang mendaftar pada workshop.
            </p>

        </div>


        {{-- ================================================= --}}
        {{-- FILTER --}}
        {{-- ================================================= --}}

        <div class="bg-white
               rounded-xl
               shadow
               p-6">

            <form action="{{ route('admin.pendaftaran-workshop.index') }}" method="GET"
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


                {{-- Filter Workshop --}}
                <div>

                    <label
                        class="block
                           text-sm
                           font-medium
                           text-gray-700
                           mb-2">
                        Workshop
                    </label>


                    <select name="workshop_id"
                        class="w-full
                           rounded-lg
                           border-gray-300
                           focus:border-blue-500
                           focus:ring-blue-500">

                        <option value="">
                            Semua Workshop
                        </option>


                        @foreach ($workshops as $workshop)
                            <option value="{{ $workshop->id }}"
                                {{ request('workshop_id') == $workshop->id ? 'selected' : '' }}>
                                {{ $workshop->judul }}
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
                <div class="flex gap-2 lg:col-span-5">

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


                    @if (request('search') || request('event_id') || request('workshop_id') || request('status'))
                        <a href="{{ route('admin.pendaftaran-workshop.index') }}"
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
                    Menampilkan data pendaftaran workshop
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

        <div
            class="bg-white
               rounded-2xl
               shadow-sm
               border border-gray-100
               overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full text-sm text-left">

                    <thead class="bg-gray-50 border-b">

                        <tr>

                            <th class="px-6 py-4 font-semibold text-gray-700">
                                No
                            </th>

                            <th class="px-6 py-4 font-semibold text-gray-700">
                                Nomor Peserta
                            </th>

                            <th class="px-6 py-4 font-semibold text-gray-700">
                                Peserta
                            </th>

                            <th class="px-6 py-4 font-semibold text-gray-700">
                                NIK
                            </th>

                            <th class="px-6 py-4 font-semibold text-gray-700">
                                Workshop
                            </th>

                            <th class="px-6 py-4 font-semibold text-gray-700">
                                Event
                            </th>

                            <th class="px-6 py-4 font-semibold text-gray-700">
                                Tanggal Daftar
                            </th>

                            <th class="px-6 py-4 font-semibold text-gray-700">
                                Status
                            </th>

                            <th class="px-6 py-4 font-semibold text-gray-700">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-100">

                        @forelse ($pendaftarans as $pendaftaran)
                            <tr class="hover:bg-gray-50">


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
                                               px-3
                                               py-1
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

                                    <div class="font-semibold
                                           text-gray-800">
                                        {{ $pendaftaran->user->name }}
                                    </div>

                                    <div
                                        class="text-gray-500
                                           text-xs
                                           mt-1">
                                        {{ $pendaftaran->user->no_hp }}
                                    </div>

                                </td>


                                {{-- NIK --}}
                                <td class="px-6 py-4">

                                    {{ $pendaftaran->user->nik }}

                                </td>


                                {{-- Workshop --}}
                                <td class="px-6 py-4">

                                    <div class="font-semibold
                                           text-gray-800">
                                        {{ $pendaftaran->workshop->judul }}
                                    </div>

                                    <div
                                        class="text-gray-500
                                           text-xs
                                           mt-1">

                                        {{ \Carbon\Carbon::parse($pendaftaran->workshop->tanggal_mulai)->format('d-m-Y') }}

                                        -

                                        {{ \Carbon\Carbon::parse($pendaftaran->workshop->tanggal_selesai)->format('d-m-Y') }}

                                    </div>

                                </td>


                                {{-- Event --}}
                                <td class="px-6 py-4">

                                    {{ $pendaftaran->workshop->event->nama_event }}

                                </td>


                                {{-- Tanggal Daftar --}}
                                <td class="px-6 py-4">

                                    {{ $pendaftaran->created_at->format('d-m-Y H:i') }}

                                </td>


                                {{-- Status --}}
                                <td class="px-6 py-4">

                                    @if ($pendaftaran->status === 'Menunggu')
                                        <span
                                            class="inline-flex
                                               px-3
                                               py-1
                                               rounded-full
                                               bg-yellow-100
                                               text-yellow-700
                                               font-semibold">
                                            Menunggu
                                        </span>
                                    @elseif ($pendaftaran->status === 'Diterima')
                                        <span
                                            class="inline-flex
                                               px-3
                                               py-1
                                               rounded-full
                                               bg-green-100
                                               text-green-700
                                               font-semibold">
                                            Diterima
                                        </span>
                                    @elseif ($pendaftaran->status === 'Ditolak')
                                        <span
                                            class="inline-flex
                                               px-3
                                               py-1
                                               rounded-full
                                               bg-red-100
                                               text-red-700
                                               font-semibold">
                                            Ditolak
                                        </span>
                                    @endif

                                </td>


                                {{-- Aksi --}}
                                <td class="px-6 py-4">

                                    <a href="{{ route('admin.pendaftaran-workshop.show', $pendaftaran->id) }}"
                                        class="inline-flex
                                           px-4
                                           py-2
                                           rounded-lg
                                           bg-blue-600
                                           hover:bg-blue-700
                                           text-white
                                           text-sm
                                           font-semibold">
                                        Lihat Detail
                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="9"
                                    class="px-6
                                       py-10
                                       text-center
                                       text-gray-500">
                                    Belum ada pendaftaran workshop.
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
