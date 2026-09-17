@extends('layouts.admin')

@section('content')
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">

    <style>
        .ql-container {
            height: auto !important;
            min-height: 220px;
        }

        .ql-editor {
            min-height: 220px;
            height: auto;
        }

        #syarat-editor .ql-editor {
            min-height: 260px;
        }

        #deskripsi-editor .ql-editor {
            min-height: 220px;
        }
    </style>

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


                {{-- Deskripsi --}}
                <div class="mb-6">

                    <label for="deskripsi" class="block font-semibold text-gray-700 mb-2">
                        Deskripsi
                    </label>

                    <textarea id="deskripsi" name="deskripsi" rows="5" class="w-full rounded-lg border-gray-300" required>{{ old('deskripsi', $workshop->deskripsi) }}</textarea>

                    @error('deskripsi')
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
                <div class="mb-6">

                    <label class="block font-semibold text-gray-700 mb-2">
                        Deskripsi
                    </label>

                    <div id="deskripsi-editor" class="bg-white"></div>

                    <input type="hidden" name="deskripsi" id="deskripsi"
                        value="{{ old('deskripsi', $workshop->deskripsi) }}">

                    @error('deskripsi')
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

    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const toolbarOptions = [
                ['bold', 'italic', 'underline'],
                [{
                    'header': [1, 2, 3, false]
                }],
                [{
                    'list': 'ordered'
                }, {
                    'list': 'bullet'
                }],
                [{
                    'align': []
                }],
                ['blockquote', 'clean']
            ];

            // Editor Deskripsi
            const deskripsiEditor = new Quill('#deskripsi-editor', {
                theme: 'snow',
                placeholder: 'Tulis deskripsi lomba...',
                modules: {
                    toolbar: toolbarOptions
                }
            });

           


            // Ambil old input jika validasi gagal
            const oldDeskripsi = @json(old('deskripsi'));


            if (oldDeskripsi) {
                deskripsiEditor.clipboard.dangerouslyPasteHTML(oldDeskripsi);
            }



            // Sebelum submit, masukkan HTML editor ke hidden input
            const form = document.getElementById('workshop-form');

            form.addEventListener('submit', function() {

                document.getElementById('deskripsi').value =
                    deskripsiEditor.root.innerHTML;
            });

        });
    </script>
@endsection
