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

            <a href="{{ route('admin.pendaftaran-workshop.index') }}"
                class="px-5 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg">
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

            
            {{-- Bukti Pembayaran --}}

            <div class="mt-8 pt-6 border-t">

                <h2 class="text-lg font-bold text-gray-800 mb-5">
                    Bukti Pembayaran
                </h2>

                @if ($pendaftaranWorkshop->workshop->biaya > 0)

                    @if ($pendaftaranWorkshop->bukti_pembayaran)
                        <div class="bg-gray-50 rounded-xl border border-gray-200 p-5">

                            <p class="text-sm text-gray-500 mb-4">
                                Peserta telah mengunggah bukti pembayaran.
                            </p>

                            @php
                                $file = $pendaftaranWorkshop->bukti_pembayaran;
                                $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                            @endphp


                            {{-- Gambar --}}
                            @if (in_array($extension, ['jpg', 'jpeg', 'png']))
                                <div class="mb-4">

                                    <img src="{{ asset('storage/' . $file) }}" alt="Bukti Pembayaran"
                                        class="max-w-md w-full rounded-xl
                                   border border-gray-200
                                   shadow-sm">

                                </div>


                                <a href="{{ asset('storage/' . $file) }}" target="_blank"
                                    class="inline-flex items-center
                               px-4 py-2
                               bg-blue-600
                               hover:bg-blue-700
                               text-white
                               rounded-lg
                               transition">
                                    Lihat Ukuran Penuh
                                </a>


                                {{-- PDF --}}
                            @elseif ($extension === 'pdf')
                                <div class="flex items-center gap-4">

                                    <div
                                        class="w-12 h-12
                                   rounded-xl
                                   bg-red-100
                                   flex items-center
                                   justify-center
                                   text-red-600
                                   font-bold">
                                        PDF
                                    </div>

                                    <div>

                                        <p class="font-semibold text-gray-800">
                                            Bukti Pembayaran PDF
                                        </p>

                                        <p class="text-sm text-gray-500">
                                            File bukti pembayaran dalam format PDF.
                                        </p>

                                    </div>

                                </div>

                                <a href="{{ asset('storage/' . $file) }}" target="_blank"
                                    class="inline-flex items-center
                               mt-4
                               px-4 py-2
                               bg-blue-600
                               hover:bg-blue-700
                               text-white
                               rounded-lg
                               transition">
                                    Buka Bukti Pembayaran
                                </a>
                            @else
                                <p class="text-red-500">
                                    Format file tidak dikenali.
                                </p>
                            @endif

                        </div>
                    @else
                        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5">

                            <p class="text-yellow-700 font-semibold">
                                Bukti pembayaran belum diunggah.
                            </p>

                        </div>
                    @endif
                @else
                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-5">

                        <p class="text-gray-600">
                            Workshop ini gratis, sehingga tidak memerlukan bukti pembayaran.
                        </p>

                    </div>

                @endif

            </div>
            



            {{-- Kelola Status --}}

            <div class="mt-8 pt-6 border-t">

                <h2 class="text-lg font-bold text-gray-800 mb-5">
                    Kelola Status
                </h2>

                <form action="{{ route('admin.pendaftaran-workshop.status', $pendaftaranWorkshop->id) }}" method="POST">

                    @csrf
                    @method('PATCH')


                    <div class="mb-4">

                        <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                            Status Pendaftaran
                        </label>

                        <select id="status" name="status" class="w-full rounded-lg border-gray-300" required>

                            <option value="Menunggu" {{ $pendaftaranWorkshop->status === 'Menunggu' ? 'selected' : '' }}>
                                Menunggu
                            </option>

                            <option value="Diterima" {{ $pendaftaranWorkshop->status === 'Diterima' ? 'selected' : '' }}>
                                Diterima
                            </option>

                            <option value="Ditolak" {{ $pendaftaranWorkshop->status === 'Ditolak' ? 'selected' : '' }}>
                                Ditolak
                            </option>

                        </select>

                    </div>


                    <div class="mb-4">

                        <label for="alasan_penolakan" class="block text-sm font-semibold text-gray-700 mb-2">
                            Alasan Penolakan
                        </label>

                        <textarea id="alasan_penolakan" name="alasan_penolakan" rows="4" class="w-full rounded-lg border-gray-300"
                            placeholder="Masukkan alasan jika pendaftaran ditolak...">{{ old('alasan_penolakan', $pendaftaranWorkshop->alasan_penolakan) }}</textarea>

                        @error('alasan_penolakan')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700
                           text-white py-3 rounded-xl
                           transition">
                        Simpan Status
                    </button>

                </form>

            </div>

        </div>

    </div>

@endsection
