@extends('public.layouts.app')

@section('title', 'Pendaftaran ' . $lomba->nama_lomba)

@section('content')

    <div class="max-w-3xl mx-auto px-6 py-12">

 <a href="{{ route('public.lomba.show', $lomba->id) }}"
            class="inline-flex items-center gap-2
           text-gray-600 hover:text-blue-600
           font-medium transition mb-6">

            <span>←</span>

            Kembali

        </a>

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


        <div class="bg-white rounded-2xl shadow p-8">

            <form action="{{ route('public.lomba.daftar.store', $lomba->id) }}" method="POST">

                @csrf


                @foreach ($fields as $field)
                    @php
                        $masterField = $field->masterField;
                    @endphp


                    <div class="mb-6">

                        <label class="block font-semibold mb-2">

                            {{ $masterField->label }}

                            @if ($field->required)
                                <span class="text-red-500">*</span>
                            @endif

                        </label>


                        {{-- TEXTAREA --}}

                        @if ($masterField->tipe === 'textarea')
                            <textarea name="field_{{ $masterField->id }}" class="w-full rounded-lg border-gray-300"
                                placeholder="{{ $masterField->placeholder }}">{{ old('field_' . $masterField->id) }}</textarea>


                            {{-- SELECT --}}
                        @elseif($masterField->tipe === 'select')
                            <select name="field_{{ $masterField->id }}" class="w-full rounded-lg border-gray-300">

                                <option value="">
                                    -- Pilih --
                                </option>

                            </select>


                            {{-- INPUT BIASA --}}
                        @else
                            <input type="{{ $masterField->tipe }}" name="field_{{ $masterField->id }}"
                                value="{{ old('field_' . $masterField->id) }}" class="w-full rounded-lg border-gray-300"
                                placeholder="{{ $masterField->placeholder }}">
                        @endif


                        {{-- ERROR FIELD --}}

                        @error('field_' . $masterField->id)
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>
                @endforeach


                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl">

                    Kirim Pendaftaran

                </button>

            </form>

        </div>

    </div>

@endsection
