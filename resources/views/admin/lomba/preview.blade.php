@extends('layouts.admin')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="bg-white rounded-xl shadow">

        <!-- Header -->
        <div class="border-b px-8 py-6">

            <h1 class="text-3xl font-bold text-gray-800">
                Preview Form
            </h1>

            <p class="text-gray-500 mt-2">
                {{ $lomba->nama_lomba }}
            </p>

        </div>

        <!-- Body -->
        <div class="p-8 space-y-6">

            @foreach($fields as $field)

                <div>

                    <label class="block font-semibold mb-2">

                        {{ $field->masterField->label }}

                        @if($field->required)
                            <span class="text-red-500">*</span>
                        @endif

                    </label>

                    <input
                        type="{{ $field->masterField->tipe }}"
                        placeholder="{{ $field->masterField->placeholder }}"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">

                </div>
                

            @endforeach

        </div>

    </div>

</div>

@endsection