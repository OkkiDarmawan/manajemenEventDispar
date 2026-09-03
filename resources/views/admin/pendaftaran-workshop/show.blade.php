@extends('layouts.admin')

@section('content')

<div class="max-w-5xl mx-auto space-y-6">

    {{-- Header --}}

    <div class="flex items-center justify-between">

        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                Detail Pendaftaran
            </h1>

            <p class="text-gray-500 mt-1">
                {{ $pendaftaranWorkshop->workshop->judul }}
            </p>

        </div>

        <a
            href="{{ route('admin.pendaftaran-workshop.index') }}"
            class="px-5 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg"
        >
            ← Kembali
        </a>

    </div>


    {{-- Informasi Pendaftaran --}}

    <div class="bg-white rounded-xl shadow p-8">

        <h2 class="text-xl font-bold mb-6">
            Informasi Pendaftaran
        </h2>

        <div class="grid md:grid-cols-2 gap-6">

            <div>

                <p class="text-sm text-gray-500">
                    Nama Peserta
                </p>

                <p class="font-semibold">
                    {{ $pendaftaranWorkshop->user->name }}
                </p>

            </div>


            <div>

                <p class="text-sm text-gray-500">
                    Event
                </p>

                <p class="font-semibold">
                    {{ $pendaftaranWorkshop->workshop->event->nama_event }}
                </p>

            </div>


            <div>

                <p class="text-sm text-gray-500">
                    Workshop
                </p>

                <p class="font-semibold">
                    {{ $pendaftaranWorkshop->workshop->judul }}
                </p>

            </div>


            <div>

                <p class="text-sm text-gray-500">
                    Status
                </p>

                <p class="font-semibold">
                    {{ $pendaftaranWorkshop->status }}
                </p>

            </div>

        </div>


        {{-- Kelola Status --}}

        <div class="mt-8 pt-6 border-t">

            <h2 class="text-lg font-bold text-gray-800 mb-5">
                Kelola Status
            </h2>

            <form
                action="{{ route('admin.pendaftaran-workshop.status', $pendaftaranWorkshop->id) }}"
                method="POST"
            >

                @csrf
                @method('PATCH')


                <div class="mb-4">

                    <label
                        for="status"
                        class="block text-sm font-semibold text-gray-700 mb-2"
                    >
                        Status Pendaftaran
                    </label>

                    <select
                        id="status"
                        name="status"
                        class="w-full rounded-lg border-gray-300"
                        required
                    >

                        <option
                            value="Menunggu"
                            {{ $pendaftaranWorkshop->status === 'Menunggu' ? 'selected' : '' }}
                        >
                            Menunggu
                        </option>

                        <option
                            value="Diterima"
                            {{ $pendaftaranWorkshop->status === 'Diterima' ? 'selected' : '' }}
                        >
                            Diterima
                        </option>

                        <option
                            value="Ditolak"
                            {{ $pendaftaranWorkshop->status === 'Ditolak' ? 'selected' : '' }}
                        >
                            Ditolak
                        </option>

                    </select>

                </div>


                <div class="mb-4">

                    <label
                        for="alasan_penolakan"
                        class="block text-sm font-semibold text-gray-700 mb-2"
                    >
                        Alasan Penolakan
                    </label>

                    <textarea
                        id="alasan_penolakan"
                        name="alasan_penolakan"
                        rows="4"
                        class="w-full rounded-lg border-gray-300"
                        placeholder="Masukkan alasan jika pendaftaran ditolak..."
                    >{{ old('alasan_penolakan', $pendaftaranWorkshop->alasan_penolakan) }}</textarea>

                    @error('alasan_penolakan')

                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                <button
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700
                           text-white py-3 rounded-xl
                           transition"
                >
                    Simpan Status
                </button>

            </form>

        </div>

    </div>

</div>

@endsection