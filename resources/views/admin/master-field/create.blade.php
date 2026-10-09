@extends('layouts.admin')

@section('content')

<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">

        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                Tambah Master Field
            </h1>

            <p class="text-gray-500 mt-1">
                Tambahkan field baru yang dapat digunakan pada formulir pendaftaran lomba.
            </p>

        </div>

        <a href="{{ route('admin.master-field.index') }}"
            class="px-5 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg">

            ← Kembali

        </a>

    </div>

    <!-- Form -->

    <div class="bg-white rounded-xl shadow p-8">

        <form action="{{ route('admin.master-field.store') }}" method="POST">

            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Label -->
                <div>

                    <label class="block font-medium mb-2">
                        Label
                    </label>

                    <input
                        type="text"
                        name="label"
                        value="{{ old('label') }}"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-blue-500">

                    @error('label')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                <!-- Nama Field -->

                <div>

                    <label class="block font-medium mb-2">
                        Nama Field
                    </label>

                    <input
                        type="text"
                        name="nama_field"
                        value="{{ old('nama_field') }}"
                        placeholder="contoh: berat_badan"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-blue-500">

                    @error('nama_field')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                <!-- Tipe -->

                <div>

                    <label class="block font-medium mb-2">
                        Tipe
                    </label>

                    <select
                        name="tipe"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2">

                        <option value="">-- Pilih Tipe --</option>

                        <option value="text">Text</option>

                        <option value="number">Number</option>

                        <option value="email">Email</option>

                        <option value="date">Date</option>

                        <option value="textarea">Textarea</option>

                        <option value="file">File</option>

                        <option value="select">Select</option>

                        <option value="radio">Radio</option>

                        <option value="checkbox">Checkbox</option>

                    </select>

                    @error('tipe')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                <!-- Kategori -->

                <div>

                    <label class="block font-medium mb-2">
                        Kategori
                    </label>

                    <select
                        name="kategori"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2">

                        <option value="">-- Pilih Kategori --</option>

                        <option value="Identitas">Identitas</option>

                        <option value="Fisik">Fisik</option>

                        <option value="Pendidikan">Pendidikan</option>

                        <option value="Dokumen">Dokumen</option>

                        <option value="galeri">Galeri</option>

                        <option value="Lainnya">Lainnya</option>

                    </select>

                </div>

                <!-- Placeholder -->

                <div class="md:col-span-2">

                    <label class="block font-medium mb-2">
                        Placeholder
                    </label>

                    <input
                        type="text"
                        name="placeholder"
                        value="{{ old('placeholder') }}"
                        placeholder="Masukkan placeholder..."
                        class="w-full rounded-lg border border-gray-300 px-4 py-2">

                </div>

            </div>

            <!-- Status -->

            <div class="mt-8 space-y-4">

                <div>

                    <label class="block font-medium mb-2">

                        Status

                    </label>

                    <div class="flex gap-6">

                        <label>

                            <input
                                type="radio"
                                name="aktif"
                                value="1"
                                checked>

                            Aktif

                        </label>

                        <label>

                            <input
                                type="radio"
                                name="aktif"
                                value="0">

                            Tidak Aktif

                        </label>

                    </div>

                </div>

                <div>

                    <label class="inline-flex items-center gap-2">

                        <input
                            type="checkbox"
                            name="readonly"
                            value="1">

                        Tidak dapat dihapus

                    </label>

                </div>

            </div>

            <!-- Button -->

            <div class="mt-8 flex justify-end gap-3">

                <a
                    href="{{ route('admin.master-field.index') }}"
                    class="px-5 py-2 rounded-lg bg-gray-300 hover:bg-gray-400">

                    Batal

                </a>

                <button
                    type="submit"
                    class="px-6 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white">

                    Simpan

                </button>

            </div>

        </form>

    </div>

</div>

@endsection