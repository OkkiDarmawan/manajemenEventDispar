@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6" x-data="{
        search: '',
    
        filterWorkshop(judul, narasumber, event) {
    
            const keyword = this.search
                .toLowerCase()
                .trim();
    
            return (
                judul.toLowerCase().includes(keyword) ||
                narasumber.toLowerCase().includes(keyword) ||
                event.toLowerCase().includes(keyword)
            );
        }
    }">

        {{-- ===================================================== --}}
        {{-- HEADER --}}
        {{-- ===================================================== --}}

        <div class="flex items-center justify-between">

            <div>

                <h1 class="text-3xl font-bold text-gray-800">
                    Kelola Workshop
                </h1>

                <p class="text-gray-500 mt-1">
                    Kelola data workshop yang tersedia.
                </p>

            </div>


            <a href="{{ route('admin.workshop.create') }}"
                class="px-5 py-3
                   bg-blue-600
                   hover:bg-blue-700
                   text-white
                   rounded-xl
                   transition">
                + Tambah Workshop
            </a>

        </div>


        {{-- ===================================================== --}}
        {{-- SUMMARY CARD --}}
        {{-- ===================================================== --}}

        <div class="grid
               grid-cols-1
               md:grid-cols-3
               gap-6">

            {{-- Total Workshop --}}
            <div
                class="bg-white
                   rounded-2xl
                   border border-gray-100
                   shadow-sm
                   p-6">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm text-gray-500">
                            Total Workshop
                        </p>

                        <h2
                            class="mt-2
                               text-3xl
                               font-bold
                               text-gray-800">
                            {{ $totalWorkshop }}
                        </h2>

                    </div>

                    <div
                        class="w-12 h-12
                           rounded-xl
                           bg-blue-50
                           flex items-center
                           justify-center
                           text-2xl">
                        🎓
                    </div>

                </div>

            </div>


            {{-- Akan Datang --}}
            <div
                class="bg-white
                   rounded-2xl
                   border border-gray-100
                   shadow-sm
                   p-6">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm text-gray-500">
                            Akan Datang
                        </p>

                        <h2
                            class="mt-2
                               text-3xl
                               font-bold
                               text-gray-800">
                            {{ $workshopAkanDatang }}
                        </h2>

                    </div>

                    <div
                        class="w-12 h-12
                           rounded-xl
                           bg-green-50
                           flex items-center
                           justify-center
                           text-2xl">
                        📅
                    </div>

                </div>

            </div>


            {{-- Sudah Berlangsung --}}
            <div
                class="bg-white
                   rounded-2xl
                   border border-gray-100
                   shadow-sm
                   p-6">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm text-gray-500">
                            Sudah Berlangsung
                        </p>

                        <h2
                            class="mt-2
                               text-3xl
                               font-bold
                               text-gray-800">
                            {{ $workshopSelesai }}
                        </h2>

                    </div>

                    <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center">
                        ✓
                    </div>

                </div>

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- SEARCH --}}
        {{-- ===================================================== --}}

        <div class="bg-white
           rounded-2xl
           border border-gray-100
           shadow-sm
           p-5">

            <form method="GET" action="{{ route('admin.workshop.index') }}" class="flex flex-col md:flex-row gap-4">

                <div class="relative flex-1">

                    <span
                        class="absolute
                       left-4
                       top-1/2
                       -translate-y-1/2
                       text-gray-400">
                        🔎
                    </span>

                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama event, lokasi, atau deskripsi..."
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


                @if (request('search'))
                    <a href="{{ route('admin.workshop.index') }}"
                        class="px-6 py-3
                       rounded-xl
                       bg-gray-100
                       hover:bg-gray-200
                       text-gray-700
                       font-semibold
                       transition
                       text-center">
                        Reset
                    </a>
                @endif

            </form>

        </div>

        <div class="flex items-center justify-between">

            <p class="text-sm text-gray-500">

                @if (request('search'))
                    Hasil pencarian untuk:
                    <span class="font-semibold text-gray-800">
                        "{{ request('search') }}"
                    </span>
                @else
                    Menampilkan data workshop
                @endif

            </p>

            <p class="text-sm text-gray-500">

                Total:
                <span class="font-semibold text-gray-800">
                    {{ $workshops->total() }}
                </span>
                workshop

            </p>

        </div>

        {{-- ===================================================== --}}
        {{-- TABLE --}}
        {{-- ===================================================== --}}

        <div class="bg-white
               rounded-xl
               shadow
               overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-gray-100 border-b">

                        <tr>

                            <th class="px-6 py-4 text-left">
                                No
                            </th>

                            <th class="px-6 py-4 text-left">
                                Poster
                            </th>

                            <th class="px-6 py-4 text-left">
                                Judul
                            </th>

                            <th class="px-6 py-4 text-left">
                                Narasumber
                            </th>

                            <th class="px-6 py-4 text-left">
                                Event
                            </th>

                            <th class="px-6 py-4 text-left">
                                Tanggal
                            </th>

                            <th class="px-6 py-4 text-left">
                                Kuota
                            </th>

                            <th class="px-6 py-4 text-left">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y">

                        @forelse ($workshops as $workshop)
                            <tr x-show="
                                filterWorkshop(
                                    @js($workshop->judul),
                                    @js($workshop->narasumber),
                                    @js($workshop->event->nama_event)
                                )
                            "
                                class="hover:bg-gray-50">

                                {{-- No --}}
                                <td class="px-6 py-4">
                                    {{ $loop->iteration }}
                                </td>


                                {{-- Poster --}}
                                <td class="px-6 py-4">

                                    @if ($workshop->poster)
                                        <img src="{{ asset('storage/' . $workshop->poster) }}"
                                            alt="{{ $workshop->judul }}"
                                            class="w-16 h-16
                                               object-cover
                                               rounded-lg
                                               border
                                               border-gray-200">
                                    @else
                                        <div
                                            class="w-16 h-16
                                               rounded-lg
                                               bg-gray-100
                                               flex items-center
                                               justify-center
                                               text-2xl">
                                            🎓
                                        </div>
                                    @endif

                                </td>


                                {{-- Judul --}}
                                <td class="px-6 py-4 font-semibold">
                                    {{ $workshop->judul }}
                                </td>


                                {{-- Narasumber --}}
                                <td class="px-6 py-4">
                                    {{ $workshop->narasumber }}
                                </td>


                                {{-- Event --}}
                                <td class="px-6 py-4">
                                    {{ $workshop->event->nama_event }}
                                </td>


                                {{-- Tanggal --}}
                                <td class="px-6 py-4">

                                    <div class="text-sm">

                                        <div>

                                            <span class="font-medium">
                                                Mulai:
                                            </span>

                                            {{ \Carbon\Carbon::parse($workshop->tanggal_mulai)->format('d-m-Y') }}

                                        </div>


                                        <div class="mt-1">

                                            <span class="font-medium">
                                                Selesai:
                                            </span>

                                            {{ \Carbon\Carbon::parse($workshop->tanggal_selesai)->format('d-m-Y') }}

                                        </div>

                                    </div>

                                </td>


                                {{-- Kuota --}}
                                <td class="px-6 py-4">
                                    {{ $workshop->kuota }} peserta
                                </td>


                                {{-- Aksi --}}
                                <td class="px-6 py-4">

                                    <div class="flex justify-center gap-2">

                                        <a href="{{ route('admin.workshop.edit', $workshop->id) }}"
                                            class="px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-center rounded-lg">
                                            Edit
                                        </a>


                                        <form id="delete-form-{{ $workshop->id }}"
                                            action="{{ route('admin.workshop.destroy', $workshop->id) }}" method="POST">

                                            @csrf
                                            @method('DELETE')

                                            <button type="button"
                                                onclick="confirmDelete(
                                                {{ $workshop->id }}
                                            )"
                                                class="px-3 py-2
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

                                <td colspan="8"
                                    class="px-6 py-10
                                       text-center
                                       text-gray-500">
                                    Belum ada workshop.
                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="px-6 py-5 border-t border-gray-100">

                {{ $workshops->links() }}

            </div>

        </div>

    </div>
@endsection
