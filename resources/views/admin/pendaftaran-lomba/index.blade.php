@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Pendaftaran Lomba
            </h1>

            <p class="text-gray-500 mt-1">
                Kelola peserta yang mendaftar pada lomba.
            </p>
        </div>

        <div class="bg-white rounded-xl shadow p-6">

            <form action="{{ route('admin.pendaftaran-lomba.index') }}" method="GET"
                class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">

                {{-- Search --}}

                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Cari Peserta
                    </label>

                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama peserta..."
                        class="w-full rounded-lg border-gray-300">

                </div>


                {{-- Filter Lomba --}}

                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Lomba
                    </label>

                    <select name="lomba_id" class="w-full rounded-lg border-gray-300">

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


                {{-- Filter Status --}}

                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Status
                    </label>

                    <select name="status" class="w-full rounded-lg border-gray-300">

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

                <div class="flex gap-2">

                    <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">

                        Filter

                    </button>

                    <a href="{{ route('admin.pendaftaran-lomba.index') }}"
                        class="px-5 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg">

                        Reset

                    </a>

                </div>

            </form>

        </div>
        <div class="bg-white rounded-xl shadow overflow-hidden">

            <table class="w-full">

                <thead class="bg-gray-50 border-b">

                    <tr>

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

                <tbody>

                    @forelse($pendaftarans as $pendaftaran)
                        <tr class="border-b">

                            <td class="px-6 py-4">

                                {{ $pendaftaran->user->name }}

                            </td>

                            <td class="px-6 py-4">

                                {{ $pendaftaran->lomba->nama_lomba }}

                            </td>

                            <td class="px-6 py-4">

                                {{ $pendaftaran->lomba->event->nama_event }}

                            </td>

                            <td class="px-6 py-4">

                                @if ($pendaftaran->status === 'Menunggu')
                                    <span class="px-3 py-1 text-sm rounded-full bg-yellow-100 text-yellow-700">
                                        Menunggu
                                    </span>
                                @elseif ($pendaftaran->status === 'Diterima')
                                    <span class="px-3 py-1 text-sm rounded-full bg-green-100 text-green-700">
                                        Diterima
                                    </span>
                                @elseif ($pendaftaran->status === 'Ditolak')
                                    <span class="px-3 py-1 text-sm rounded-full bg-red-100 text-red-700">
                                        Ditolak
                                    </span>
                                @endif

                            </td>

                            <td class="px-6 py-4">

                                <a href="{{ route('admin.pendaftaran-lomba.show', $pendaftaran->id) }}"
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">

                                    Detail

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">

                                Belum ada pendaftaran.

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>
@endsection
