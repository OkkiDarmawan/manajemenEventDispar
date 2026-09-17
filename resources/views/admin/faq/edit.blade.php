@extends('layouts.admin')

@section('content')

<div class="max-w-5xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">

        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                Edit FAQ
            </h1>

            <p class="text-gray-500 mt-1">
                Perbarui pertanyaan dan jawaban FAQ.
            </p>

        </div>

        <a href="{{ route('admin.faq.index') }}"
            class="px-5 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition">

            ← Kembali

        </a>

    </div>


    {{-- Form --}}
    <div class="bg-white rounded-xl shadow p-8">

        <form action="{{ route('admin.faq.update', $faq->id) }}" method="POST">

            @csrf
            @method('PUT')


            {{-- Kategori --}}
            <div class="mb-6">

                <label
                    for="kategori"
                    class="block font-semibold text-gray-700 mb-2"
                >
                    Kategori
                </label>

                <select
                    id="kategori"
                    name="kategori"
                    class="w-full rounded-lg border-gray-300
                           focus:border-blue-500
                           focus:ring-blue-500"
                >

                    <option value="">
                        Pilih Kategori
                    </option>

                    <option value="Umum"
                        {{ old('kategori', $faq->kategori) == 'Umum' ? 'selected' : '' }}>
                        Umum
                    </option>

                    <option value="Lomba"
                        {{ old('kategori', $faq->kategori) == 'Lomba' ? 'selected' : '' }}>
                        Lomba
                    </option>

                    <option value="Workshop"
                        {{ old('kategori', $faq->kategori) == 'Workshop' ? 'selected' : '' }}>
                        Workshop
                    </option>

                    <option value="Pendaftaran"
                        {{ old('kategori', $faq->kategori) == 'Pendaftaran' ? 'selected' : '' }}>
                        Pendaftaran
                    </option>

                    <option value="Akun"
                        {{ old('kategori', $faq->kategori) == 'Akun' ? 'selected' : '' }}>
                        Akun
                    </option>

                    <option value="UMKM"
                        {{ old('kategori', $faq->kategori) == 'UMKM' ? 'selected' : '' }}>
                        UMKM
                    </option>

                </select>

                @error('kategori')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Pertanyaan --}}
            <div class="mb-6">

                <label
                    for="pertanyaan"
                    class="block font-semibold text-gray-700 mb-2"
                >
                    Pertanyaan
                </label>

                <input
                    type="text"
                    id="pertanyaan"
                    name="pertanyaan"
                    value="{{ old('pertanyaan', $faq->pertanyaan) }}"
                    class="w-full rounded-lg border-gray-300"
                    placeholder="Contoh: Bagaimana cara mendaftar lomba?"
                >

                @error('pertanyaan')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Jawaban --}}
            <div class="mb-6">

                <label
                    for="jawaban"
                    class="block font-semibold text-gray-700 mb-2"
                >
                    Jawaban
                </label>

                <textarea
                    id="jawaban"
                    name="jawaban"
                    rows="5"
                    class="w-full rounded-lg border-gray-300"
                    placeholder="Masukkan jawaban..."
                >{{ old('jawaban', $faq->jawaban) }}</textarea>

                @error('jawaban')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Urutan --}}
            <div class="mb-6">

                <label
                    for="urutan"
                    class="block font-semibold text-gray-700 mb-2"
                >
                    Urutan
                </label>

                <input
                    type="number"
                    id="urutan"
                    name="urutan"
                    value="{{ old('urutan', $faq->urutan) }}"
                    min="0"
                    class="w-full rounded-lg border-gray-300"
                >

                @error('urutan')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Aktif --}}
            <div class="mb-6">

                <label class="inline-flex items-center gap-3">

                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        class="rounded border-gray-300 text-blue-600"
                        {{ $faq->is_active ? 'checked' : '' }}
                    >

                    <span class="font-semibold text-gray-700">
                        Tampilkan di public
                    </span>

                </label>

            </div>


            {{-- Button --}}
            <div class="flex items-center gap-3">

                <a
                    href="{{ route('admin.faq.index') }}"
                    class="px-5 py-3
                           rounded-xl
                           border border-gray-300
                           text-gray-700
                           hover:bg-gray-50"
                >
                    Kembali
                </a>

                <button
                    type="submit"
                    class="px-5 py-3
                           rounded-xl
                           bg-blue-600
                           hover:bg-blue-700
                           text-white font-semibold"
                >
                    Simpan FAQ
                </button>

            </div>

        </form>

    </div>

</div>

@endsection