@extends('layouts.admin')

@section('content')
   

    <div class="space-y-6">

        <!-- Header -->
        <div class="flex items-center justify-between">

            <div>

                <h1 class="text-3xl font-bold text-gray-800">
                    Master Field
                </h1>

                <p class="text-gray-500 mt-1">
                    Kelola field yang dapat digunakan pada formulir pendaftaran lomba.
                </p>

            </div>

            <a href="{{ route('admin.master-field.create') }}"
                class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow transition">

                + Tambah Field

            </a>

        </div>

        <!-- Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Total Field -->
            <div class="bg-white rounded-xl shadow p-6">

                <div class="flex justify-between items-center">

                    <div>

                        <p class="text-gray-500 text-sm">
                            Total Field
                        </p>

                        <h2 class="text-3xl font-bold text-gray-800 mt-2">
                            {{ $totalField }}
                        </h2>

                    </div>

                    <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-blue-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 7h16M4 12h16M4 17h16" />

                        </svg>

                    </div>

                </div>

            </div>

            <!-- Field Aktif -->
            <div class="bg-white rounded-xl shadow p-6">

                <div class="flex justify-between items-center">

                    <div>

                        <p class="text-gray-500 text-sm">
                            Field Aktif
                        </p>

                        <h2 class="text-3xl font-bold text-green-600 mt-2">
                            {{ $fieldAktif }}
                        </h2>

                    </div>

                    <div class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-green-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />

                        </svg>

                    </div>

                </div>

            </div>

            <!-- Total Kategori -->
            <div class="bg-white rounded-xl shadow p-6">

                <div class="flex justify-between items-center">

                    <div>

                        <p class="text-gray-500 text-sm">
                            Total Kategori
                        </p>

                        <h2 class="text-3xl font-bold text-purple-600 mt-2">
                            {{ $totalKategori }}
                        </h2>

                    </div>

                    <div class="w-14 h-14 rounded-full bg-purple-100 flex items-center justify-center">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-purple-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 9l4-4 4 4m0 6l-4 4-4-4" />

                        </svg>

                    </div>

                </div>

            </div>

        </div>

        <!-- Search -->
        <div class="bg-white rounded-xl shadow p-5">

            <form>

                <input type="text" placeholder="Cari label atau nama field..."
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">

            </form>

        </div>


        <!-- Table -->
        <div class="bg-white rounded-xl shadow overflow-hidden">

            <table class="min-w-full">

                <thead class="bg-gray-100">

                    <tr>

                        <th class="px-6 py-3 text-left">No</th>

                        <th class="px-6 py-3 text-left">Label</th>

                        <th class="px-6 py-3 text-left">Nama Field</th>

                        <th class="px-6 py-3 text-left">Tipe</th>

                        <th class="px-6 py-3 text-left">Kategori</th>

                        <th class="px-6 py-3 text-center">Status</th>

                        <th class="px-6 py-3 text-center">Aksi</th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-200">

                    @forelse ($masterFields as $field)
                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-4">

                                {{ $loop->iteration }}

                            </td>

                            <td class="px-6 py-4 font-medium">

                                {{ $field->label }}

                            </td>

                            <td class="px-6 py-4 text-gray-600">

                                {{ $field->nama_field }}

                            </td>

                            <td class="px-6 py-4">

                                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm">

                                    {{ ucfirst($field->tipe) }}

                                </span>

                            </td>

                            <td class="px-6 py-4">

                                {{ $field->kategori }}

                            </td>

                            <td class="px-6 py-4 text-center">

                                @if ($field->aktif)
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">

                                        Aktif

                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm">

                                        Nonaktif

                                    </span>
                                @endif

                            </td>

                            <td class="px-6 py-4">

                                <div class="flex justify-center gap-2">

                                    <a href="{{ route('admin.master-field.edit', $field->id) }}"
                                        class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 rounded text-white">

                                        Edit

                                    </a>

                                    <form action="{{ route('admin.master-field.destroy', $field->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus field ini?')">
                                        
                                        @csrf
                                        @method('DELETE')

                                        <button class="px-3 py-1 bg-red-600 hover:bg-red-700 rounded text-white">

                                            Hapus

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7" class="text-center py-8 text-gray-500">

                                Belum ada data Master Field.

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>


        <!-- Pagination -->

        <div>

            {{ $masterFields->links() }}

        </div>

    </div>
@endsection
