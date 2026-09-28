@extends('layouts.admin')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">

        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                Tambah Workshop
            </h1>

            <p class="text-gray-500 mt-1">
                Tambahkan informasi workshop baru.
            </p>

        </div>


        <div class="bg-white rounded-xl shadow p-8">

            <form id="workshop-form" action="{{ route('admin.workshop.store') }}" method="POST" enctype="multipart/form-data">

                @csrf


                {{-- Event --}}
                <div class="mb-6">

                    <label for="event_id" class="block font-semibold text-gray-700 mb-2">
                        Event
                    </label>

                    <select id="event_id" name="event_id" class="w-full rounded-lg border-gray-300" required>

                        <option value="">
                            -- Pilih Event --
                        </option>

                        @foreach ($events as $event)
                            <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>
                                {{ $event->nama_event }}
                            </option>
                        @endforeach

                    </select>

                    @error('event_id')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Judul --}}
                <div class="mb-6">

                    <label for="judul" class="block font-semibold text-gray-700 mb-2">
                        Judul Workshop
                    </label>

                    <input type="text" id="judul" name="judul" value="{{ old('judul') }}"
                        class="w-full rounded-lg border-gray-300" placeholder="Masukkan judul workshop" required>

                    @error('judul')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- narasumber --}}
                <div class="mb-6">

                    <label for="narasumber" class="block font-semibold text-gray-700 mb-2">
                        Narasumber
                    </label>

                    <input type="text" id="narasumber" name="narasumber" value="{{ old('narasumber') }}"
                        class="w-full rounded-lg border-gray-300" placeholder="Nama penyelenggara" required>

                    @error('narasumber')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- Penyelenggara --}}

                <div class="md:col-span-2">

                    <label for="penyelenggara" class="block font-semibold text-gray-700 mb-2">
                        Penyelenggara
                    </label>

                    <input type="text" id="penyelenggara" name="penyelenggara" value="{{ old('penyelenggara') }}"
                        placeholder="Masukkan nama penyelenggara"
                        class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                    @error('penyelenggara')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                <div class="mb-6">

                    <label for="poster" class="block font-semibold text-gray-700 mb-2">
                        Poster Workshop
                    </label>

                    <input type="file" id="poster" name="poster" accept="image/*"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2">

                    <p class="text-xs text-gray-500 mt-1">
                        Format JPG, JPEG, atau PNG.
                    </p>

                    @error('poster')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>





                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">

                    {{-- Tanggal Mulai --}}
                    <div>

                        <label for="tanggal_mulai" class="block font-semibold text-gray-700 mb-2">
                            Tanggal Mulai
                        </label>

                        <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}"
                            class="w-full rounded-xl border-gray-300
                   focus:border-blue-500
                   focus:ring-blue-500">

                        @error('tanggal_mulai')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Tanggal Selesai --}}
                    <div>

                        <label for="tanggal_selesai" class="block font-semibold text-gray-700 mb-2">
                            Tanggal Selesai
                        </label>

                        <input type="date" id="tanggal_selesai" name="tanggal_selesai"
                            value="{{ old('tanggal_selesai') }}"
                            class="w-full rounded-xl border-gray-300
                   focus:border-blue-500
                   focus:ring-blue-500">

                        @error('tanggal_selesai')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>


                {{-- Lokasi --}}
                <div class="mb-6">

                    <label for="lokasi" class="block font-semibold text-gray-700 mb-2">
                        Lokasi
                    </label>

                    <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi') }}"
                        class="w-full rounded-lg border-gray-300" placeholder="Lokasi workshop" required>

                    @error('lokasi')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Kuota --}}
                <div class="mb-6">

                    <label for="kuota" class="block font-semibold text-gray-700 mb-2">
                        Kuota Peserta
                    </label>

                    <input type="number" id="kuota" name="kuota" value="{{ old('kuota') }}" min="1"
                        class="w-full rounded-lg border-gray-300" placeholder="Contoh: 50" required>

                    @error('kuota')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- BIAYA --}}

                <div class="mb-6">

                    <label for="biaya" class="block font-semibold text-gray-700 mb-2">
                        Biaya Workshop
                    </label>

                    <div class="flex">

                        <span
                            class="inline-flex items-center px-4 rounded-l-xl border border-r-0 border-gray-300 bg-gray-50 text-gray-600 font-medium">
                            Rp
                        </span>

                        <input type="number" id="biaya" name="biaya" value="{{ old('biaya', 0) }}"
                            min="0" step="1000" placeholder="0"
                            class="w-full
                   rounded-r-xl
                   border-gray-300
                   focus:border-blue-500
                   focus:ring-blue-500
                   py-3">

                    </div>

                    <p class="text-xs text-gray-500 mt-1">
                        Isi 0 jika workshop gratis.
                    </p>

                    @error('biaya')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- Deskripsi --}}
                <div class="md:col-span-2">

                    <label for="deskripsi" class="block font-semibold text-gray-700 mb-2">
                        Deskripsi
                    </label>

                    <textarea name="deskripsi" id="deskripsi" rows="15" placeholder="Masukkan HTML untuk deskripsi lomba..."
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 font-mono text-sm focus:border-blue-500 focus:ring-blue-500">{{ old('deskripsi') }}</textarea>

                    <p class="text-xs text-gray-500 mt-2">
                        Mendukung HTML dan inline CSS.
                    </p>

                    @error('deskripsi')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Syarat --}}
                <div class="md:col-span-2">

                    <label for="syarat" class="block font-semibold text-gray-700 mb-2">
                        Syarat dan Ketentuan
                    </label>

                    <textarea name="syarat" id="syarat" rows="15" placeholder="Masukkan HTML untuk syarat dan ketentuan..."
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 font-mono text-sm focus:border-blue-500 focus:ring-blue-500">{{ old('syarat') }}</textarea>

                    <p class="text-xs text-gray-500 mt-2">
                        Mendukung HTML dan inline CSS.
                    </p>

                    @error('syarat')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Button --}}
                <div class="flex gap-3">

                    <a href="{{ route('admin.workshop.index') }}"
                        class="px-5 py-3
                           rounded-xl
                           border border-gray-300
                           text-gray-700
                           hover:bg-gray-50">
                        Kembali
                    </a>

                    <button type="submit"
                        class="px-5 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold">
                        Simpan Workshop
                    </button>

                </div>

            </form>

        </div>

    </div>
@endsection
