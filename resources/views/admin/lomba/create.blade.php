@extends('layouts.admin')

@section('content')
    <div class="max-w-5xl mx-auto space-y-6">

        <!-- Header -->
        <div class="flex items-center justify-between">

            <div>

                <h1 class="text-3xl font-bold text-gray-800">
                    Tambah Lomba
                </h1>

                <p class="text-gray-500 mt-1">
                    Tambahkan data lomba baru untuk event yang dipilih.
                </p>

            </div>

            <a href="{{ route('admin.lomba.index') }}" class="px-5 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition">

                ← Kembali

            </a>

        </div>

        <!-- Form -->

        <div class="bg-white rounded-xl shadow p-8">

            <form id="lomba-form" action="{{ route('admin.lomba.store') }}" method="POST" enctype="multipart/form-data">

                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Event -->

                    <div class="md:col-span-2">

                        <label class="block font-medium mb-2">
                            Event
                        </label>

                        <select name="event_id" class="w-full rounded-lg border border-gray-300 px-4 py-2">

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

                    <!-- Nama Lomba -->

                    <div class="md:col-span-2">

                        <label class="block font-medium mb-2">
                            Nama Lomba
                        </label>

                        <input type="text" name="nama_lomba" value="{{ old('nama_lomba') }}"
                            placeholder="Masukkan nama lomba..." class="w-full rounded-lg border border-gray-300 px-4 py-2">

                        @error('nama_lomba')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    <div class="md:col-span-2">

                        <label for="penyelenggara" class="block font-semibold text-gray-700 mb-2">
                            Penyelenggara
                        </label>

                        <input type="text" id="penyelenggara" name="penyelenggara" value="{{ old('penyelenggara') }}" placeholder="Masukkan nama penyelenggara" class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                        @error('penyelenggara')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    <!-- Kuota -->

                    <div>

                        <label class="block font-medium mb-2">
                            Kuota
                        </label>

                        <input type="number" name="kuota" value="{{ old('kuota') }}" min="1"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2">

                        @error('kuota')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>



                    <!-- Biaya -->

                    <div>

                        <label class="block font-medium mb-2">
                            Biaya
                        </label>

                        <input type="number" name="biaya" value="{{ old('biaya') }}" min="0"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2">

                        @error('biaya')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- Poster --}}

                    <div class="md:col-span-2">

                        <label for="poster" class="block font-semibold text-gray-700 mb-2">
                            Poster Lomba
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

                    <!-- Hadiah -->

                    <div class="md:col-span-2">

                        <label class="block font-medium mb-2">
                            Hadiah
                        </label>

                        <input type="text" name="hadiah" value="{{ old('hadiah') }}"
                            placeholder="Contoh: Trofi, Sertifikat, Uang Tunai"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2">

                        @error('hadiah')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    <!-- Pendaftaran Dibuka -->

                    <div>

                        <label class="block font-medium mb-2">
                            Pendaftaran Dibuka
                        </label>

                        <input type="date" name="pendaftaran_terbuka" value="{{ old('pendaftaran_terbuka') }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2">

                        @error('pendaftaran_terbuka')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    <!-- Pendaftaran Ditutup -->

                    <div>

                        <label class="block font-medium mb-2">
                            Pendaftaran Ditutup
                        </label>

                        <input type="date" name="pendaftaran_tertutup" value="{{ old('pendaftaran_tertutup') }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2">

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

                <!-- Button -->

                <div class="mt-8 flex justify-end gap-3">

                    <a href="{{ route('admin.lomba.index') }}"
                        class="px-5 py-2 rounded-lg bg-gray-300 hover:bg-gray-400">

                        Batal

                    </a>

                    <button type="submit" class="px-6 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white">

                        Simpan Lomba

                    </button>

                </div>

            </form>

        </div>

    </div>
@endsection
