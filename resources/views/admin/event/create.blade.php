@extends('layouts.admin')

@section('content')
    <div class="max-w-5xl mx-auto space-y-6">

        <!-- Header -->
        <div class="flex items-center justify-between">

            <div>

                <h1 class="text-3xl font-bold text-gray-800">
                    Tambah Event
                </h1>

                <p class="text-gray-500 mt-1">
                    Tambahkan event baru yang akan ditampilkan pada sistem.
                </p>

            </div>

            <a href="{{ route('admin.event.index') }}" class="px-5 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition">

                ← Kembali

            </a>

        </div>

        <!-- Form -->

        <div class="bg-white rounded-xl shadow p-8">

            <form action="{{ route('admin.event.store') }}" method="POST" enctype="multipart/form-data">

                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Nama Event -->

                    <div class="md:col-span-2">

                        <label class="block font-medium mb-2">
                            Nama Event
                        </label>

                        <input type="text" name="nama_event" value="{{ old('nama_event') }}"
                            placeholder="Masukkan nama event..."
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-blue-500">

                        @error('nama_event')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- Penyelenggara --}}
                    <div class="md:col-span-2">

                        <label class="block font-medium mb-2">
                            Nama Penyelenggara
                        </label>

                        <input type="text" name="penyelenggara"
                            value="{{ old('penyelenggara', $event->penyelenggara ?? '') }}"
                            placeholder="Masukkan nama penyelenggara"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-blue-500">

                        @error('penyelenggara')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- Biaya --}}
                    <div class="md:col-span-2">

                        <label class="block font-medium mb-2">
                            Biaya
                        </label>

                        <input type="number" id="biaya" name="biaya" min="0"
                            value="{{ old('biaya', $event->biaya ?? 0) }}" placeholder="0"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2">

                        <p class="text-xs text-gray-500 mt-1">
                            Isi 0 jika event gratis.
                        </p>

                        @error('biaya')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>



                    <!-- Lokasi -->

                    <div>

                        <label class="block font-medium mb-2">
                            Lokasi
                        </label>

                        <input type="text" name="lokasi" value="{{ old('lokasi') }}"
                            placeholder="Masukkan lokasi event..."
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-blue-500">

                        @error('lokasi')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- LINK GMAPS --}}

                    <div>

                        <label class="block font-medium mb-2">
                            Link Google Maps
                        </label>

                        <input type="url" name="link_gmaps" value="{{ old('link_gmaps', $event->link_gmaps ?? '') }}"
                            placeholder="Tempel link Google Maps di sini"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                        <p class="text-xs text-gray-500 mt-1">
                            Masukkan URL Google Maps untuk lokasi kegiatan.
                        </p>

                        @error('link_gmaps')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    <!-- Poster -->

                    <div>

                        <label class="block font-medium mb-2">
                            Poster Event
                        </label>

                        <input type="file" name="poster" accept="image/*"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2">

                        @error('poster')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    <!-- Tanggal Mulai -->

                    <div>

                        <label class="block font-medium mb-2">
                            Tanggal Mulai
                        </label>

                        <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-blue-500">

                        @error('tanggal_mulai')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    <!-- Tanggal Selesai -->

                    <div>

                        <label class="block font-medium mb-2">
                            Tanggal Selesai
                        </label>

                        <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-blue-500">

                        @error('tanggal_selesai')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    <!-- Deskripsi -->

                    <div class="md:col-span-2">

                        <label class="block font-medium mb-2">
                            Deskripsi Event
                        </label>

                        <textarea name="deskripsi" rows="6" placeholder="Masukkan deskripsi event..."
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-blue-500">{{ old('deskripsi') }}</textarea>

                        @error('deskripsi')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>

                <!-- Button -->

                <div class="mt-8 flex justify-end gap-3">

                    <a href="{{ route('admin.event.index') }}"
                        class="px-5 py-2 rounded-lg bg-gray-300 hover:bg-gray-400 transition">

                        Batal

                    </a>

                    <button type="submit" class="px-6 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition">

                        Simpan Event

                    </button>

                </div>

            </form>

        </div>

    </div>
@endsection
