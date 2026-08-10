@extends('layouts.admin')

@section('content')

<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">

        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                Edit Master Field
            </h1>

            <p class="text-gray-500 mt-1">
                Perbarui informasi Master Field
            </p>

        </div>

        <a href="{{ route('admin.master-field.index') }}"
            class="px-5 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg">

            ← Kembali

        </a>

    </div>

    <!-- Form -->

    <div class="bg-white rounded-xl shadow p-8">

        <form action="{{ route('admin.master-field.update', $masterField->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Label -->
                <div>

                    <label class="block font-medium mb-2">
                        Label
                    </label>

                    <input
                        type="text"
                        name="label"
                        value="{{ old('label', $masterField->label) }}"
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
                       value="{{ old('nama_field', $masterField->nama_field) }}"
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

                        <option value="" {{ old('tipe', $masterField->tipe) == '' ? 'selected' : '' }}> -- Pilih Tipe --</option>

                        <option value="text" {{ old('tipe', $masterField->tipe) == 'text' ? 'selected' : '' }} >  Text</option>

                        <option value="number" {{ old('tipe', $masterField->tipe) == 'number' ? 'selected' : '' }} >  Number</option>

                        <option value="email" {{ old('tipe', $masterField->tipe) == 'email' ? 'selected' : '' }}>   Email</option>

                        <option value="date" {{ old('tipe', $masterField->tipe) == 'date' ? 'selected' : '' }}>   Date</option>

                        <option value="textarea" {{ old('tipe', $masterField->tipe) == 'textarea' ? 'selected' : '' }}>   Textarea</option>

                        <option value="file" {{ old('tipe', $masterField->tipe) == 'file' ? 'selected' : '' }}>   File</option>

                        <option value="select" {{ old('tipe', $masterField->tipe) == 'select' ? 'selected' : '' }}>   Select</option>

                        <option value="radio" {{ old('tipe', $masterField->tipe) == 'radio' ? 'selected' : '' }}>   Radio</option>

                        <option value="checkbox" {{ old('tipe', $masterField->tipe) == 'checkbox' ? 'selected' : '' }}>   Checkbox</option>

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

                        <option value="" {{ old('kategori', $masterField->kategori) == '' ? 'selected' : '' }}> -- Pilih Kategori --</option>

                        <option value="Identitas" {{ old('kategori', $masterField->kategori) == 'Identitas' ? 'selected' : '' }}> Identitas</option>

                        <option value="Fisik" {{ old('kategori', $masterField->kategori) == 'Fisik' ? 'selected' : '' }}> Fisik</option>

                        <option value="Pendidikan" {{ old('kategori', $masterField->kategori) == 'Pendidikan' ? 'selected' : '' }}> Pendidikan</option>

                        <option value="Dokumen" {{ old('kategori', $masterField->kategori) == 'Dokumen' ? 'selected' : '' }}> Dokumen</option>

                        <option value="Lainnya" {{ old('kategori', $masterField->kategori) == 'Lainnya' ? 'selected' : '' }} >Lainnya</option>

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
                        value="{{ old('placeholder', $masterField->placeholder) }}"
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
                                {{ old('aktif', $masterField->aktif)==1 ? 'checked  ' : '' }}
                                >

                            Aktif

                        </label>

                        <label>

                            <input
                                type="radio"
                                name="aktif"
                                value="0"
                                {{ old('aktif', $masterField->aktif)==0 ? 'checked' : '' }}
                                >

                            Tidak Aktif

                        </label>

                    </div>

                </div>

                <div>

                    <label class="inline-flex items-center gap-2">

                        <input
                            type="checkbox"
                            name="readonly"
                            value="1"
                            {{ old('readonly', $masterField->readonly) ? 'checked' : '' }}
                            >

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