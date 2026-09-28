@extends('layouts.admin')

@section('title', 'Detail Pendaftaran UMKM')

@section('content')

    <div class="max-w-5xl mx-auto space-y-6">

        {{-- Header --}}
        <div class="flex items-center justify-between">

            <div>

                <h1 class="text-3xl font-bold text-gray-800">
                    Detail Pendaftaran
                </h1>

                <p class="text-gray-500 mt-1">
                    {{ $pendaftaranUmkm->umkm->nama }}
                </p>

            </div>

            <a href="{{ route('admin.pendaftaran-umkm.index') }}"
                class="px-5 py-2
                       bg-gray-200 hover:bg-gray-300
                       rounded-lg">
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
                        {{ $pendaftaranUmkm->user->name }}
                    </p>

                </div>


                <div>

                    <p class="text-sm text-gray-500">
                        NIK
                    </p>

                    <p class="font-semibold">
                        {{ $pendaftaranUmkm->user->nik }}
                    </p>

                </div>


                <div>

                    <p class="text-sm text-gray-500">
                        Event
                    </p>

                    <p class="font-semibold">
                        {{ $pendaftaranUmkm->umkm->event->nama_event }}
                    </p>

                </div>


                <div>

                    <p class="text-sm text-gray-500">
                        UMKM
                    </p>

                    <p class="font-semibold">
                        {{ $pendaftaranUmkm->umkm->nama }}
                    </p>

                </div>


                <div>

                    <p class="text-sm text-gray-500">
                        Status
                    </p>

                    @if ($pendaftaranUmkm->status === 'Menunggu')
                        <span class="text-yellow-600 font-bold">
                            🟡 Menunggu
                        </span>
                    @elseif ($pendaftaranUmkm->status === 'Diterima')
                        <span class="text-green-600 font-bold">
                            🟢 Diterima
                        </span>
                    @else
                        <span class="text-red-600 font-bold">
                            🔴 Ditolak
                        </span>
                    @endif

                </div>


                <div>

                    <p class="text-sm text-gray-500">
                        Nomor Peserta
                    </p>

                    <p class="font-bold text-blue-600 text-xl">
                        {{ $pendaftaranUmkm->nomor_peserta ? '#' . $pendaftaranUmkm->nomor_peserta : '-' }}
                    </p>

                </div>

            </div>

        </div>


        {{-- Data Pendaftaran Dinamis --}}
        <div class="bg-white rounded-xl shadow p-8">

            <h2 class="text-xl font-bold mb-6">
                Data Pendaftaran
            </h2>

            <div class="space-y-6">

                @forelse ($pendaftaranUmkm->jawabanUmkms as $jawaban)

                    <div>

                        <p class="text-sm text-gray-500 mb-2">
                            {{ $jawaban->masterField->label }}
                        </p>


                        {{-- File --}}
                        @if ($jawaban->masterField->tipe === 'file')
                            @if ($jawaban->value)
                                @php
                                    $file = $jawaban->value;

                                    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                @endphp


                                {{-- Gambar --}}
                                @if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp']))
                                    <div class="space-y-3">

                                        <img src="{{ asset('storage/' . $file) }}" alt="{{ $jawaban->masterField->label }}"
                                            class="max-w-md w-full
                                                   rounded-xl
                                                   border border-gray-200
                                                   shadow-sm">

                                        <a href="{{ asset('storage/' . $file) }}" target="_blank"
                                            class="inline-flex
                                                   px-4 py-2
                                                   bg-blue-600
                                                   hover:bg-blue-700
                                                   text-white
                                                   rounded-lg">
                                            Lihat Ukuran Penuh
                                        </a>

                                    </div>


                                    {{-- PDF --}}
                                @elseif ($extension === 'pdf')
                                    <div class="flex items-center gap-4">

                                        <div
                                            class="w-12 h-12
                                                   rounded-xl
                                                   bg-red-100
                                                   text-red-600
                                                   flex items-center
                                                   justify-center
                                                   font-bold">
                                            PDF
                                        </div>

                                        <p class="font-semibold text-gray-800">
                                            Dokumen PDF
                                        </p>

                                    </div>

                                    <a href="{{ asset('storage/' . $file) }}" target="_blank"
                                        class="inline-flex
                                               mt-3
                                               px-4 py-2
                                               bg-blue-600
                                               hover:bg-blue-700
                                               text-white
                                               rounded-lg">
                                        Buka File
                                    </a>
                                @else
                                    <a href="{{ asset('storage/' . $file) }}" target="_blank"
                                        class="inline-flex
                                               px-4 py-2
                                               bg-gray-100
                                               hover:bg-gray-200
                                               text-gray-700
                                               rounded-lg">
                                        Buka File
                                    </a>
                                @endif
                            @else
                                <p class="text-gray-400">
                                    Tidak ada file.
                                </p>
                            @endif


                            {{-- Field biasa --}}
                        @else
                            <p class="font-semibold text-gray-800">
                                {{ $jawaban->value ?: '-' }}
                            </p>
                        @endif

                    </div>

                @empty

                    <p class="text-gray-500">
                        Belum ada data pendaftaran.
                    </p>

                @endforelse

            </div>

        </div>


        {{-- Kelola Status --}}
        <div class="bg-white rounded-xl shadow p-8">

            <h2 class="text-lg font-bold text-gray-800 mb-5">
                Kelola Status
            </h2>

            <form
                action="{{ route('admin.pendaftaran-umkm.status', $pendaftaranUmkm->id) }}"
                method="POST">

                @csrf
                @method('PATCH')


                <div class="mb-4">

                    <label for="status"
                        class="block text-sm font-semibold
                               text-gray-700 mb-2">
                        Status Pendaftaran
                    </label>

                    <select id="status" name="status" class="w-full rounded-lg border-gray-300">

                        <option value="Menunggu"
                            {{ $pendaftaranUmkm->status === 'Menunggu' ? 'selected' : '' }}>
                            Menunggu
                        </option>

                        <option value="Diterima"
                            {{ $pendaftaranUmkm->status === 'Diterima' ? 'selected' : '' }}>
                            Diterima
                        </option>

                        <option value="Ditolak"
                            {{ $pendaftaranUmkm->status === 'Ditolak' ? 'selected' : '' }}>
                            Ditolak
                        </option>

                    </select>

                </div>


                <div class="mb-4">

                    <label for="alasan_penolakan"
                        class="block text-sm font-semibold
                               text-gray-700 mb-2">
                        Alasan Penolakan
                    </label>

                    <textarea id="alasan_penolakan" name="alasan_penolakan" rows="4" class="w-full rounded-lg border-gray-300"
                        placeholder="Masukkan alasan jika pendaftaran ditolak...">{{ old('alasan_penolakan', $pendaftaranUmkm->alasan_penolakan) }}</textarea>

                    @error('alasan_penolakan')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                <button type="submit"
                    class="w-full
                           bg-blue-600
                           hover:bg-blue-700
                           text-white
                           py-3
                           rounded-xl">
                    Simpan Status
                </button>

            </form>

        </div>

    </div>

@endsection
