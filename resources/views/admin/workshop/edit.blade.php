@extends('layouts.admin')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">

        {{-- Header --}}
        <div class="flex items-center justify-between">

            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Edit Workshop
                </h1>

                <p class="text-gray-500 mt-1">
                    Perbarui informasi workshop.
                </p>
            </div>

            <a href="{{ route('admin.workshop.index') }}"
                class="px-5 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition">
                ← Kembali
            </a>

        </div>


        {{-- Form --}}
        <div class="bg-white rounded-xl shadow p-8">

            <form action="{{ route('admin.workshop.update', $workshop->id) }}" method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')


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
                            <option value="{{ $event->id }}"
                                {{ old('event_id', $workshop->event_id) == $event->id ? 'selected' : '' }}>
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

                    <input type="text" id="judul" name="judul" value="{{ old('judul', $workshop->judul) }}"
                        class="w-full rounded-lg border-gray-300" required>

                    @error('judul')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Narasumber --}}
                <div class="mb-6">

                    <label for="narasumber" class="block font-semibold text-gray-700 mb-2">
                        Narasumber
                    </label>

                    <input type="text" id="narasumber" name="narasumber"
                        value="{{ old('narasumber', $workshop->narasumber) }}" class="w-full rounded-lg border-gray-300"
                        required>

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

                        <input type="text" id="penyelenggara" name="penyelenggara" value="{{ old('penyelenggara', $workshop->penyelenggara) }}"
                            placeholder="Masukkan nama penyelenggara"
                            class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                        @error('penyelenggara')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                {{-- Poster --}}

                <div class="mb-6">

                    <label for="poster" class="block font-semibold text-gray-700 mb-2">
                        Poster Lomba
                    </label>

                    @if ($workshop->poster)
                        <img src="{{ asset('storage/' . $workshop->poster) }}" alt="{{ $workshop->judul }}"
                            class="w-48 h-32 object-cover rounded-xl">
                    @endif

                    <input type="file" id="poster" name="poster" accept="image/*"
                        class="w-full rounded-lg border-gray-300 border px-4 py-2">

                    <p class="text-xs text-gray-500 mt-1">
                        Kosongkan jika tidak ingin mengganti poster.
                    </p>

                    @error('poster')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>




                {{-- Tanggal --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div>

                        <label for="tanggal_mulai" class="block font-semibold text-gray-700 mb-2">
                            Tanggal Mulai
                        </label>

                        <input type="date" id="tanggal_mulai" name="tanggal_mulai"
                            value="{{ old('tanggal_mulai', $workshop->tanggal_mulai) }}"
                            class="w-full rounded-xl border-gray-300
                   focus:border-blue-500
                   focus:ring-blue-500">

                        @error('tanggal_mulai')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    <div>

                        <label for="tanggal_selesai" class="block font-semibold text-gray-700 mb-2">
                            Tanggal Selesai
                        </label>

                        <input type="date" id="tanggal_selesai" name="tanggal_selesai"
                            value="{{ old('tanggal_selesai', $workshop->tanggal_selesai) }}"
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

                    <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi', $workshop->lokasi) }}"
                        class="w-full rounded-lg border-gray-300" required>

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

                        <input type="url" name="link_gmaps" value="{{ old('link_gmaps', $workshop->link_gmaps ?? '') }}"
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

                        <input type="number" id="biaya" name="biaya" value="{{ old('biaya', $workshop->biaya) }}"
                            min="0" step="1000"
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


                {{-- Kuota --}}
                <div class="mb-6">

                    <label for="kuota" class="block font-semibold text-gray-700 mb-2">
                        Kuota Peserta
                    </label>

                    <input type="number" id="kuota" name="kuota" value="{{ old('kuota', $workshop->kuota) }}"
                        min="1" class="w-full rounded-lg border-gray-300" required>

                    @error('kuota')
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
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 font-mono text-sm focus:border-blue-500 focus:ring-blue-500">{{ old('deskripsi', $workshop->deskripsi) }}</textarea>

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
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 font-mono text-sm focus:border-blue-500 focus:ring-blue-500">{{ old('syarat', $workshop->syarat) }}</textarea>

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
                        class="px-5 py-3 rounded-xl
                           border border-gray-300
                           text-gray-700 hover:bg-gray-50">
                        Kembali
                    </a>

                    <button type="submit"
                        class="px-5 py-3 rounded-xl
                           bg-blue-600 hover:bg-blue-700
                           text-white font-semibold">
                        Simpan Perubahan
                    </button>

                </div>

            </form>

        </div>

    </div>
@endsection
