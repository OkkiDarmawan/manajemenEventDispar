@extends('layouts.admin')

@section('content')
    <div class="space-y-6">

        <!-- Header -->
        <div class="flex items-center justify-between">

            <div>

                <h1 class="text-3xl font-bold text-gray-800">
                    Event
                </h1>

                <p class="text-gray-500 mt-1">
                    Kelola data event.
                </p>

            </div>

            <a href="{{ route('admin.event.create') }}"
                class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow transition">
                + Tambah Event
            </a>

        </div>

        <!-- Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Total Event -->
            <div class="bg-white rounded-xl shadow p-6">

                <div class="flex justify-between items-center">

                    <div>

                        <p class="text-gray-500 text-sm">
                            Total Event
                        </p>

                        <h2 class="text-3xl font-bold text-gray-800 mt-2">
                            {{ $totalEvent }}
                        </h2>

                    </div>

                    <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-blue-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3M5 11h14M5 5h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />

                        </svg>

                    </div>

                </div>

            </div>

            <!-- Sedang Berlangsung -->
            <div class="bg-white rounded-xl shadow p-6">

                <div class="flex justify-between items-center">

                    <div>

                        <p class="text-gray-500 text-sm">
                            Sedang Berlangsung
                        </p>

                        <h2 class="text-3xl font-bold text-green-600 mt-2">
                            {{ $eventAktif }}
                        </h2>

                    </div>

                    <div class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-green-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />

                        </svg>

                    </div>

                </div>

            </div>

            <!-- Event Selesai -->
            <div class="bg-white rounded-xl shadow p-6">

                <div class="flex justify-between items-center">

                    <div>

                        <p class="text-gray-500 text-sm">
                            Event Selesai
                        </p>

                        <h2 class="text-3xl font-bold text-red-600 mt-2">
                            {{ $eventSelesai }}
                        </h2>

                    </div>

                    <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-red-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />

                        </svg>

                    </div>

                </div>

            </div>

        </div>

        <!-- Search -->
        <div class="bg-white
           rounded-2xl
           border border-gray-100
           shadow-sm
           p-5">

            <form method="GET" action="{{ route('admin.event.index') }}" class="flex flex-col md:flex-row gap-4">

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
                    <a href="{{ route('admin.event.index') }}"
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
                    Menampilkan data event
                @endif

            </p>

            <p class="text-sm text-gray-500">

                Total:
                <span class="font-semibold text-gray-800">
                    {{ $events->total() }}
                </span>
                event

            </p>

        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl shadow overflow-hidden">

            <table class="min-w-full">

                <thead class="bg-gray-100">

                    <tr>

                        <th class="px-6 py-3 text-left">No</th>

                        <th class="px-6 py-3 text-left">Poster</th>

                        <th class="px-6 py-3 text-left">Nama Event</th>

                        <th class="px-6 py-3 text-left">Lokasi</th>

                        <th class="px-6 py-3 text-left">Mulai</th>

                        <th class="px-6 py-3 text-left">Selesai</th>

                        <th class="px-6 py-3 text-center">Status</th>

                        <th class="px-6 py-3 text-center">Aksi</th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-200">

                    @forelse($events as $event)
                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-4">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-6 py-4">
                                <br>
                                @if ($event->poster)
                                    <img src="{{ asset('storage/' . $event->poster) }}"
                                        class="w-16 h-16 object-cover rounded-lg">
                                @else
                                    <span class="text-gray-400">
                                        Tidak ada
                                    </span>
                                @endif

                            </td>

                            <td class="px-6 py-4 font-medium">
                                {{ $event->nama_event }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $event->lokasi }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $event->tanggal_mulai }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $event->tanggal_selesai }}
                            </td>

                            <td class="px-6 py-4 text-center">

                                {!! $event->status_badge !!}

                            </td>

                            <td class="px-6 py-4">

                                <div class="flex justify-center gap-2">

                                    <a href="{{ route('admin.event.edit', $event->id) }}"
                                        class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded">

                                        Edit

                                    </a>

                                    <form id="delete-form-{{ $event->id }}"
                                        action="{{ route('admin.event.destroy', $event->id) }}" method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button type="button" onclick="confirmDelete({{ $event->id }})"
                                            class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded">
                                            Hapus
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8" class="text-center py-8 text-gray-500">

                                Belum ada data Event.

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

        <!-- Pagination -->

        <div class="px-6 py-5 border-t border-gray-100">

            {{ $events->links() }}

        </div>

    </div>
@endsection
