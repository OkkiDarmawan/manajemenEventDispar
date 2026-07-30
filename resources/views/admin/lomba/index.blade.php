@extends('layouts.admin')

@section('content')
    <div class="space-y-6">

        <!-- Header -->
        <div class="flex items-center justify-between">

            <div>

                <h1 class="text-3xl font-bold text-gray-800">
                    Lomba
                </h1>

                <p class="text-gray-500 mt-1">
                    Kelola data lomba pada setiap event.
                </p>

            </div>

            <a href="{{ route('admin.lomba.create') }}"
                class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow transition">

                + Tambah Lomba

            </a>

        </div>

        <!-- Statistik -->

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Total Lomba -->

            <div class="bg-white rounded-xl shadow p-6">

                <div class="flex justify-between items-center">

                    <div>

                        <p class="text-gray-500 text-sm">

                            Total Lomba

                        </p>

                        <h2 class="text-3xl font-bold text-blue-600 mt-2">

                            {{ $totalLomba }}

                        </h2>

                    </div>

                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">

                        🏆

                    </div>

                </div>

            </div>

            <!-- Total Event -->

            <div class="bg-white rounded-xl shadow p-6">

                <div class="flex justify-between items-center">

                    <div>

                        <p class="text-gray-500 text-sm">

                            Total Event

                        </p>

                        <h2 class="text-3xl font-bold text-green-600 mt-2">

                            {{ $totalEvent }}

                        </h2>

                    </div>

                    <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center">

                        🎉

                    </div>

                </div>

            </div>

            <!-- Total Kuota -->

            <div class="bg-white rounded-xl shadow p-6">

                <div class="flex justify-between items-center">

                    <div>

                        <p class="text-gray-500 text-sm">

                            Total Kuota

                        </p>

                        <h2 class="text-3xl font-bold text-purple-600 mt-2">

                            {{ $totalKuota }}

                        </h2>

                    </div>

                    <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center">

                        👥

                    </div>

                </div>

            </div>

        </div>

        <!-- Search -->

        <div class="bg-white rounded-xl shadow p-5">

            <form>

                <input type="text" placeholder="Cari nama lomba..."
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-blue-500">

            </form>

        </div>

        <!-- Table -->

        <div class="bg-white rounded-xl shadow overflow-hidden">

            <table class="min-w-full">

                <thead class="bg-gray-100">

                    <tr>

                        <th class="px-6 py-3 text-left">
                            No
                        </th>

                        <th class="px-6 py-3 text-left">
                            Nama Lomba
                        </th>

                        <th class="px-6 py-3 text-left">
                            Event
                        </th>

                        <th class="px-6 py-3 text-center">
                            Kuota
                        </th>

                        <th class="px-6 py-3 text-center">
                            Biaya
                        </th>

                        <th class="px-6 py-3 text-center">
                            Pendaftaran
                        </th>

                        <th class="px-6 py-3 text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-200">

                    @forelse($lombas as $lomba)
                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-4">

                                {{ $loop->iteration }}

                            </td>

                            <td class="px-6 py-4 font-medium">

                                {{ $lomba->nama_lomba }}

                            </td>

                            <td class="px-6 py-4">

                                {{ $lomba->event->nama_event }}

                            </td>

                            <td class="px-6 py-4 text-center">

                                {{ $lomba->kuota }}

                            </td>

                            <td class="px-6 py-4 text-center">

                                Rp {{ number_format($lomba->biaya, 0, ',', '.') }}

                            </td>

                            <td class="px-6 py-4 text-center text-sm">

                                {{ $lomba->pendaftaran_terbuka }}

                                <br>

                                s/d

                                <br>

                                {{ $lomba->pendaftaran_tertutup }}

                            </td>

                            <td class="px-6 py-4">

                                <div class="flex justify-center gap-2">

                                    <a href="{{ route('admin.lomba.field', $lomba->id) }}"
                                        class="px-3 py-1 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">

                                        Kelola Field

                                    </a>

                                    <a href="{{ route('admin.lomba.edit', $lomba->id) }}"
                                        class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded">

                                        Edit

                                    </a>

                                    <form id="delete-form-{{ $lomba->id }}"
                                        action="{{ route('admin.lomba.destroy', $lomba->id) }}" method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button type="button" onclick="confirmDelete({{ $lomba->id }})"
                                            class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded">

                                            Hapus

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7" class="text-center py-8 text-gray-500">

                                Belum ada data lomba.

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

        <!-- Pagination -->

        <div>

            {{ $lombas->links() }}

        </div>

    </div>
@endsection
