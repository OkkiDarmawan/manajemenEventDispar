@extends('layouts.admin')

@section('title', 'Tambah UMKM')

@section('content')



    <div class="max-w-5xl mx-auto space-y-6">

        {{-- Header --}}
        <div class="flex items-center justify-between">

            <div>

                <h1 class="text-3xl font-bold text-gray-800">
                    Tambah UMKM
                </h1>

                <p class="text-gray-500 mt-1">
                    Tambahkan kegiatan UMKM baru untuk event yang dipilih.
                </p>

            </div>

            <a href="{{ route('admin.umkm.index') }}"
                class="px-5 py-2
                       bg-gray-200
                       hover:bg-gray-300
                       rounded-lg
                       transition">
                ← Kembali
            </a>

        </div>


        {{-- Form --}}
        <div class="bg-white rounded-xl shadow p-8">

            <form id="umkm-form" action="{{ route('admin.umkm.store') }}" method="POST" enctype="multipart/form-data">

                @csrf


                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                    {{-- Event --}}
                    <div class="md:col-span-2">

                        <label for="event_id" class="block font-semibold text-gray-700 mb-2">
                            Event
                        </label>

                        <select id="event_id" name="event_id"
                            class="w-full rounded-lg border-gray-300
                                   focus:border-blue-500
                                   focus:ring-blue-500">

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


                    {{-- Nama UMKM --}}
                    <div class="md:col-span-2">

                        <label for="nama" class="block font-semibold text-gray-700 mb-2">
                            Nama Kegiatan UMKM
                        </label>

                        <input type="text" id="nama" name="nama" value="{{ old('nama') }}"
                            placeholder="Contoh: Bazar UMKM Festival"
                            class="w-full rounded-xl
                                   border-gray-300
                                   focus:border-blue-500
                                   focus:ring-blue-500">

                        @error('nama')
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

                    {{-- Lokasi --}}

                    <div class="md:col-span-2">

                        <label for="lokasi" class="block font-semibold text-gray-700 mb-2">
                            Lokasi
                        </label>

                        <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi') }}"
                            placeholder="Masukkan lokasi"
                            class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                        @error('lokasi')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                     {{-- LINK GMAPS --}}

                    <div class="md:col-span-2">

                        <label class="block font-medium mb-2">
                            Link Google Maps
                        </label>

                        <input type="url" name="link_gmaps" value="{{ old('link_gmaps', $umkm->link_gmaps ?? '') }}"
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


                   


                    {{-- Poster --}}
                    <div class="md:col-span-2">

                        <label for="poster" class="block font-semibold text-gray-700 mb-2">
                            Poster UMKM
                        </label>

                        <input type="file" id="poster" name="poster" accept="image/jpeg,image/png"
                            class="w-full
                                   rounded-xl
                                   border
                                   border-gray-300
                                   bg-white
                                   px-4 py-2">

                        <p class="text-xs text-gray-500 mt-2">
                            Format JPG, JPEG, atau PNG. Maksimal 2 MB.
                        </p>

                        @error('poster')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Kuota --}}
                    <div>

                        <label for="kuota" class="block font-semibold text-gray-700 mb-2">
                            Kuota
                        </label>

                        <input type="number" id="kuota" name="kuota" value="{{ old('kuota') }}" min="1"
                            placeholder="Contoh: 50"
                            class="w-full rounded-xl
                                   border-gray-300
                                   focus:border-blue-500
                                   focus:ring-blue-500">

                        <p class="text-xs text-gray-500 mt-1">
                            Kosongkan jika tidak ingin menentukan kuota.
                        </p>

                        @error('kuota')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Biaya --}}
                    <div>

                        <label for="biaya" class="block font-semibold text-gray-700 mb-2">
                            Biaya
                        </label>

                        <input type="number" id="biaya" name="biaya" value="{{ old('biaya', 0) }}" min="0"
                            placeholder="0"
                            class="w-full rounded-xl
                                   border-gray-300
                                   focus:border-blue-500
                                   focus:ring-blue-500">

                        <p class="text-xs text-gray-500 mt-1">
                            Isi 0 jika gratis.
                        </p>

                        @error('biaya')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Pendaftaran Dibuka --}}
                    <div>

                        <label for="pendaftaran_terbuka" class="block font-semibold text-gray-700 mb-2">
                            Pendaftaran Dibuka
                        </label>

                        <input type="date" id="pendaftaran_terbuka" name="pendaftaran_terbuka"
                            value="{{ old('pendaftaran_terbuka') }}"
                            class="w-full rounded-xl
                                   border-gray-300
                                   focus:border-blue-500
                                   focus:ring-blue-500">

                        @error('pendaftaran_terbuka')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Pendaftaran Ditutup --}}
                    <div>

                        <label for="pendaftaran_tertutup" class="block font-semibold text-gray-700 mb-2">
                            Pendaftaran Ditutup
                        </label>

                        <input type="date" id="pendaftaran_tertutup" name="pendaftaran_tertutup"
                            value="{{ old('pendaftaran_tertutup') }}"
                            class="w-full rounded-xl
                                   border-gray-300
                                   focus:border-blue-500
                                   focus:ring-blue-500">

                        @error('pendaftaran_tertutup')
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

                </div>


                {{-- Button --}}
                <div class="mt-8 flex justify-end gap-3">

                    <a href="{{ route('admin.umkm.index') }}"
                        class="px-5 py-3
                               rounded-xl
                               bg-gray-200
                               hover:bg-gray-300
                               text-gray-700
                               transition">
                        Batal
                    </a>

                    <button type="submit"
                        class="px-6 py-3
                               rounded-xl
                               bg-blue-600
                               hover:bg-blue-700
                               text-white
                               font-semibold
                               transition">
                        Simpan UMKM
                    </button>

                </div>

            </form>

        </div>

    </div>

   

@endsection
