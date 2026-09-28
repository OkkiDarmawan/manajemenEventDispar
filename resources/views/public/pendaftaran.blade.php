@extends('public.layouts.app')

@section('title', 'Pendaftaran ' . $lomba->nama_lomba)

@section('content')

    <div class="max-w-3xl mx-auto px-6 py-12">

        {{-- Kembali --}}
        <a href="{{ route('public.lomba.show', $lomba->id) }}"
            class="inline-flex items-center gap-2
                   text-gray-600 hover:text-blue-600
                   font-medium transition mb-6">

            <span>←</span>

            Kembali

        </a>


        {{-- Header --}}
        <div class="mb-8">

            <p class="text-blue-600 font-semibold">
                {{ $lomba->event->nama_event }}
            </p>

            <h1 class="text-3xl font-bold text-gray-800 mt-2">
                Pendaftaran {{ $lomba->nama_lomba }}
            </h1>

            <p class="text-gray-500 mt-2">
                Silakan lengkapi data pendaftaran di bawah.
            </p>

        </div>


        {{-- Form --}}
        <div class="bg-white rounded-2xl shadow p-8">

            <form action="{{ route('public.lomba.daftar.store', $lomba->id) }}" method="POST" enctype="multipart/form-data">

                @csrf


                @foreach ($fields as $field)
                    @php
                        $masterField = $field->masterField;
                    @endphp


                    <div class="mb-6">

                        {{-- Label --}}
                        <label for="field_{{ $masterField->id }}" class="block font-semibold mb-2">

                            {{ $masterField->label }}

                            @if ($field->required)
                                <span class="text-red-500">*</span>
                            @endif

                        </label>


                        {{-- ===================================== --}}
                        {{-- TEXTAREA --}}
                        {{-- ===================================== --}}
                        @if ($masterField->tipe === 'textarea')
                            <textarea id="field_{{ $masterField->id }}" name="field_{{ $masterField->id }}" rows="4"
                                class="w-full rounded-lg border-gray-300" placeholder="{{ $masterField->placeholder }}">{{ old('field_' . $masterField->id) }}</textarea>


                            {{-- ===================================== --}}
                            {{-- SELECT --}}
                            {{-- ===================================== --}}
                        @elseif ($masterField->tipe === 'select')
                            <select id="field_{{ $masterField->id }}" name="field_{{ $masterField->id }}"
                                class="w-full rounded-lg border-gray-300">

                                <option value="">
                                    -- Pilih --
                                </option>

                            </select>


                            {{-- ===================================== --}}
                            {{-- FILE --}}
                            {{-- ===================================== --}}
                        @elseif ($masterField->tipe === 'file')
                            <input type="file" id="field_{{ $masterField->id }}" name="field_{{ $masterField->id }}"
                                accept=".jpg,.jpeg,.png,.pdf"
                                class="w-full
                                       rounded-lg
                                       border border-gray-300
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
                                       hover:file:bg-blue-100">

                            <p class="text-xs text-gray-500 mt-2">
                                Format yang diperbolehkan: JPG, JPEG, PNG, atau PDF.
                                Maksimal 2 MB.
                            </p>


                            {{-- ===================================== --}}
                            {{-- INPUT BIASA --}}
                            {{-- ===================================== --}}
                        @else
                            <input type="{{ $masterField->tipe }}" id="field_{{ $masterField->id }}"
                                name="field_{{ $masterField->id }}" value="{{ old('field_' . $masterField->id) }}"
                                class="w-full rounded-lg border-gray-300" placeholder="{{ $masterField->placeholder }}">
                        @endif


                        {{-- Error --}}
                        @error('field_' . $masterField->id)
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>
                @endforeach


                {{-- Tombol --}}
                <button type="submit"
                    class="w-full
                           bg-blue-600
                           hover:bg-blue-700
                           text-white
                           py-3
                           rounded-xl
                           font-semibold
                           transition">
                    Kirim Pendaftaran
                </button>

            </form>

        </div>

    </div>

@endsection
