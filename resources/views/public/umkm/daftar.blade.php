
@extends('public.layouts.app')

@section('title', 'Pendaftaran ' . $umkm->nama)

@section('content')

    <div class="max-w-3xl mx-auto px-6 py-12">

        {{-- Kembali --}}
        <a
            href="{{ route('public.umkm.show', $umkm->id) }}"
            class="inline-flex items-center gap-2
                   text-gray-600 hover:text-blue-600
                   font-medium transition mb-6"
        >
            <span>←</span>
            Kembali
        </a>


        {{-- Header --}}
        <div class="mb-8">

            <p class="text-blue-600 font-semibold">
                {{ $umkm->event->nama_event }}
            </p>

            <h1 class="text-3xl font-bold text-gray-800 mt-2">
                Pendaftaran {{ $umkm->nama }}
            </h1>

            <p class="text-gray-500 mt-2">
                Silakan lengkapi data pendaftaran di bawah.
            </p>

        </div>


        {{-- Form --}}
        <div class="bg-white rounded-2xl shadow p-8">

            <form
                action="{{ route('public.umkm.daftar.store', $umkm->id) }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf


                @if ($fields->isEmpty())

                    <div class="bg-yellow-50
                                border border-yellow-200
                                rounded-xl
                                p-5 mb-6">

                        <p class="font-semibold text-yellow-800">
                            Form pendaftaran belum tersedia.
                        </p>

                        <p class="text-sm text-yellow-700 mt-1">
                            Silakan hubungi administrator untuk informasi lebih lanjut.
                        </p>

                    </div>

                @else

                    @foreach ($fields as $field)

                        @php
                            $masterField = $field->masterField;
                            $fieldName = 'field_' . $masterField->id;
                        @endphp


                        <div class="mb-6">

                            {{-- Label --}}
                            <label
                                for="{{ $fieldName }}"
                                class="block font-semibold text-gray-700 mb-2"
                            >

                                {{ $masterField->label }}

                                @if ($field->required)

                                    <span class="text-red-500">
                                        *
                                    </span>

                                @endif

                            </label>


                            {{-- ======================================== --}}
                            {{-- TEXTAREA --}}
                            {{-- ======================================== --}}
                            @if ($masterField->tipe === 'textarea')

                                <textarea
                                    id="{{ $fieldName }}"
                                    name="{{ $fieldName }}"
                                    rows="4"
                                    placeholder="{{ $masterField->placeholder }}"
                                    class="w-full
                                           rounded-xl
                                           border-gray-300
                                           focus:border-blue-500
                                           focus:ring-blue-500"
                                >{{ old($fieldName) }}</textarea>


                            {{-- ======================================== --}}
                            {{-- SELECT --}}
                            {{-- ======================================== --}}
                            @elseif ($masterField->tipe === 'select')

                                <select
                                    id="{{ $fieldName }}"
                                    name="{{ $fieldName }}"
                                    class="w-full
                                           rounded-xl
                                           border-gray-300
                                           focus:border-blue-500
                                           focus:ring-blue-500"
                                >

                                    <option value="">
                                        -- Pilih --
                                    </option>

                                </select>


                            {{-- ======================================== --}}
                            {{-- FILE --}}
                            {{-- ======================================== --}}
                            @elseif ($masterField->tipe === 'file')

                                <input
                                    type="file"
                                    id="{{ $fieldName }}"
                                    name="{{ $fieldName }}"
                                    accept=".jpg,.jpeg,.png,.pdf"
                                    class="w-full
                                           rounded-xl
                                           border
                                           border-gray-300
                                           bg-white
                                           px-4 py-2
                                           text-gray-700
                                           file:mr-4
                                           file:py-2
                                           file:px-4
                                           file:rounded-lg
                                           file:border-0
                                           file:bg-blue-50
                                           file:text-blue-700
                                           hover:file:bg-blue-100"
                                >

                                <p class="text-xs text-gray-500 mt-2">
                                    Format yang diperbolehkan:
                                    JPG, JPEG, PNG, atau PDF.
                                    Maksimal 2 MB.
                                </p>


                            {{-- ======================================== --}}
                            {{-- INPUT BIASA --}}
                            {{-- ======================================== --}}
                            @else

                                <input
                                    type="{{ $masterField->tipe }}"
                                    id="{{ $fieldName }}"
                                    name="{{ $fieldName }}"
                                    value="{{ old($fieldName) }}"
                                    placeholder="{{ $masterField->placeholder }}"
                                    class="w-full
                                           rounded-xl
                                           border-gray-300
                                           focus:border-blue-500
                                           focus:ring-blue-500"
                                >

                            @endif


                            {{-- Error --}}
                            @error($fieldName)

                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>

                    @endforeach


                    {{-- Tombol --}}
                    <button
                        type="submit"
                        class="w-full
                               bg-blue-600
                               hover:bg-blue-700
                               text-white
                               py-3
                               rounded-xl
                               font-semibold
                               transition"
                    >
                        Kirim Pendaftaran
                    </button>

                @endif

            </form>

        </div>

    </div>

@endsection

