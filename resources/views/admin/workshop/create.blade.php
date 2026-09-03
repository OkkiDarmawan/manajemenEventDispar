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

        <form
            action="{{ route('admin.workshop.store') }}"
            method="POST"
        >

            @csrf


            {{-- Event --}}
            <div class="mb-6">

                <label
                    for="event_id"
                    class="block font-semibold text-gray-700 mb-2"
                >
                    Event
                </label>

                <select
                    id="event_id"
                    name="event_id"
                    class="w-full rounded-lg border-gray-300"
                    required
                >

                    <option value="">
                        -- Pilih Event --
                    </option>

                    @foreach ($events as $event)

                        <option
                            value="{{ $event->id }}"
                            {{ old('event_id') == $event->id ? 'selected' : '' }}
                        >
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

                <label
                    for="judul"
                    class="block font-semibold text-gray-700 mb-2"
                >
                    Judul Workshop
                </label>

                <input
                    type="text"
                    id="judul"
                    name="judul"
                    value="{{ old('judul') }}"
                    class="w-full rounded-lg border-gray-300"
                    placeholder="Masukkan judul workshop"
                    required
                >

                @error('judul')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Narasumber --}}
            <div class="mb-6">

                <label
                    for="narasumber"
                    class="block font-semibold text-gray-700 mb-2"
                >
                    Narasumber
                </label>

                <input
                    type="text"
                    id="narasumber"
                    name="narasumber"
                    value="{{ old('narasumber') }}"
                    class="w-full rounded-lg border-gray-300"
                    placeholder="Nama narasumber"
                    required
                >

                @error('narasumber')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Deskripsi --}}
            <div class="mb-6">

                <label
                    for="deskripsi"
                    class="block font-semibold text-gray-700 mb-2"
                >
                    Deskripsi
                </label>

                <textarea
                    id="deskripsi"
                    name="deskripsi"
                    rows="5"
                    class="w-full rounded-lg border-gray-300"
                    placeholder="Masukkan deskripsi workshop"
                    required
                >{{ old('deskripsi') }}</textarea>

                @error('deskripsi')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Tanggal --}}
            <div class="mb-6">

                <label
                    for="tanggal"
                    class="block font-semibold text-gray-700 mb-2"
                >
                    Tanggal
                </label>

                <input
                    type="date"
                    id="tanggal"
                    name="tanggal"
                    value="{{ old('tanggal') }}"
                    class="w-full rounded-lg border-gray-300"
                    required
                >

                @error('tanggal')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Lokasi --}}
            <div class="mb-6">

                <label
                    for="lokasi"
                    class="block font-semibold text-gray-700 mb-2"
                >
                    Lokasi
                </label>

                <input
                    type="text"
                    id="lokasi"
                    name="lokasi"
                    value="{{ old('lokasi') }}"
                    class="w-full rounded-lg border-gray-300"
                    placeholder="Lokasi workshop"
                    required
                >

                @error('lokasi')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Kuota --}}
            <div class="mb-6">

                <label
                    for="kuota"
                    class="block font-semibold text-gray-700 mb-2"
                >
                    Kuota Peserta
                </label>

                <input
                    type="number"
                    id="kuota"
                    name="kuota"
                    value="{{ old('kuota') }}"
                    min="1"
                    class="w-full rounded-lg border-gray-300"
                    placeholder="Contoh: 50"
                    required
                >

                @error('kuota')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Button --}}
            <div class="flex gap-3">

                <a
                    href="{{ route('admin.workshop.index') }}"
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
                    Simpan Workshop
                </button>

            </div>

        </form>

    </div>

</div>

@endsection