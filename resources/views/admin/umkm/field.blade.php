@extends('layouts.admin')

@section('title', 'Kelola Field UMKM')

@section('content')

    <div class="p-6">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

            <div>

                <p class="text-blue-600 font-semibold">
                    {{ $umkm->event->nama_event }}
                </p>

                <h1 class="text-3xl font-bold text-gray-800 mt-1">
                    Kelola Field UMKM
                </h1>

                <p class="text-gray-500 mt-2">
                    Atur field yang akan digunakan pada formulir pendaftaran
                    <span class="font-semibold text-gray-700">
                        {{ $umkm->nama }}
                    </span>.
                </p>

            </div>


            <a href="{{ route('admin.umkm.index') }}"
                class="inline-flex items-center justify-center
                       px-5 py-2
                       bg-gray-200
                       hover:bg-gray-300
                       rounded-lg
                       transition">
                ← Kembali
            </a>

        </div>


        {{-- Informasi --}}
        <div class="bg-blue-50 border border-blue-200 rounded-2xl p-5 mb-6">

            <p class="font-semibold text-blue-800">
                Pengaturan Field
            </p>

            <p class="text-sm text-blue-700 mt-1">
                Centang <strong>Aktif</strong> untuk menampilkan field pada
                formulir pendaftaran masyarakat. Centang <strong>Wajib</strong>
                jika field tersebut harus diisi.
            </p>

        </div>


        {{-- Form --}}
        <form action="{{ route('admin.umkm.field.store', $umkm->id) }}" method="POST">

            @csrf


            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">


                {{-- Header Table --}}
                <div class="px-6 py-5 border-b border-gray-100">

                    <div class="grid grid-cols-12 gap-4 items-center">

                        <div class="col-span-1"></div>

                        <div class="col-span-5">
                            <p class="text-sm font-semibold text-gray-600">
                                Field
                            </p>
                        </div>

                        <div class="col-span-3">
                            <p class="text-sm font-semibold text-gray-600">
                                Tipe
                            </p>
                        </div>

                        <div class="col-span-3 text-center">
                            <p class="text-sm font-semibold text-gray-600">
                                Wajib
                            </p>
                        </div>

                    </div>

                </div>


                {{-- Daftar Master Field --}}
                <div class="divide-y divide-gray-100">

                    @forelse ($masterFields as $masterField)
                        @php
                            $oldFields = old('master_fields');

                            if (is_array($oldFields) && array_key_exists($masterField->id, $oldFields)) {
                                $isSelected = isset($oldFields[$masterField->id]['active']);
                                $isRequired = isset($oldFields[$masterField->id]['required']);
                            } else {
                                $isSelected = in_array($masterField->id, $selectedFields ?? []);

                                $isRequired = in_array($masterField->id, $requiredFields ?? []);
                            }
                        @endphp


                        <div class="field-row px-6 py-5
                                   hover:bg-gray-50
                                   transition"
                            data-field-id="{{ $masterField->id }}">

                            <div class="grid grid-cols-12 gap-4 items-center">


                                {{-- Aktif --}}
                                <div class="col-span-1 flex justify-center">

                                    <input type="checkbox" name="master_fields[{{ $masterField->id }}][active]"
                                        value="1"
                                        class="active-field
                                               rounded
                                               border-gray-300
                                               text-blue-600
                                               focus:ring-blue-500"
                                        {{ $isSelected ? 'checked' : '' }}>

                                </div>


                                {{-- Informasi Field --}}
                                <div class="col-span-5">

                                    <p class="font-semibold text-gray-800">
                                        {{ $masterField->label }}
                                    </p>

                                    @if ($masterField->placeholder)
                                        <p class="text-xs text-gray-400 mt-1">
                                            {{ $masterField->placeholder }}
                                        </p>
                                    @endif

                                </div>


                                {{-- Tipe --}}
                                <div class="col-span-3">

                                    @php
                                        $typeLabel = match ($masterField->tipe) {
                                            'text' => 'Text',
                                            'textarea' => 'Textarea',
                                            'select' => 'Select',
                                            'number' => 'Number',
                                            'date' => 'Date',
                                            'file' => 'File',
                                            default => ucfirst($masterField->tipe),
                                        };
                                    @endphp

                                    <span
                                        class="inline-flex
                                               px-3 py-1
                                               rounded-full
                                               bg-gray-100
                                               text-gray-700
                                               text-sm
                                               font-medium">
                                        {{ $typeLabel }}
                                    </span>

                                </div>


                                {{-- Wajib --}}
                                <div class="col-span-3">

                                    <label class="flex items-center justify-center gap-2">

                                        <input type="checkbox" name="master_fields[{{ $masterField->id }}][required]"
                                            value="1"
                                            class="required-field
                                                   rounded
                                                   border-gray-300
                                                   text-blue-600
                                                   focus:ring-blue-500"
                                            {{ $isRequired ? 'checked' : '' }} {{ !$isSelected ? 'disabled' : '' }}>

                                        <span class="text-sm text-gray-700">
                                            Wajib
                                        </span>

                                    </label>

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="px-6 py-10 text-center">

                            <p class="text-gray-500">
                                Belum ada Master Field yang tersedia.
                            </p>

                        </div>
                    @endforelse

                </div>


                {{-- Footer --}}
                <div
                    class="px-6 py-5
                           border-t border-gray-100
                           bg-gray-50
                           flex flex-col sm:flex-row
                           justify-between
                           gap-3">

                    <a href="{{ route('admin.umkm.index') }}"
                        class="px-5 py-3
                               rounded-xl
                               border border-gray-300
                               bg-white
                               hover:bg-gray-50
                               text-gray-700
                               text-center
                               transition">
                        Batal
                    </a>

                    <button type="submit"
                        class="px-6 py-3
                               rounded-xl
                               bg-blue-600
                               hover:bg-blue-700
                               text-white
                               font-semibold
                               transition">
                        Simpan Field
                    </button>

                </div>

            </div>

        </form>

    </div>


    {{-- Aktif / Wajib --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const rows = document.querySelectorAll('.field-row');

            rows.forEach(function(row) {

                const activeCheckbox =
                    row.querySelector('.active-field');

                const requiredCheckbox =
                    row.querySelector('.required-field');


                function updateRequiredState() {

                    requiredCheckbox.disabled = !activeCheckbox.checked;

                    if (!activeCheckbox.checked) {
                        requiredCheckbox.checked = false;
                    }
                }


                activeCheckbox.addEventListener(
                    'change',
                    updateRequiredState
                );


                updateRequiredState();

            });

        });
    </script>

@endsection
