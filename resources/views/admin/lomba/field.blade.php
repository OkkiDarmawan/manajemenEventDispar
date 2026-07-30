@extends('layouts.admin')

@section('content')

<div class="max-w-5xl mx-auto space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">

        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                Kelola Field
            </h1>

            <p class="text-gray-500 mt-1">

                {{ $lomba->nama_lomba }}

                •

                {{ $lomba->event->nama_event }}

            </p>

        </div>

        <a
            href="{{ route('admin.lomba.index') }}"
            class="px-5 py-2 bg-gray-200 rounded-lg">

            ← Kembali

        </a>

    </div>

    <div class="bg-white rounded-xl shadow p-8">

        <form
            action="{{ route('admin.lomba.field.store',$lomba->id) }}"
            method="POST">

            @csrf

            <div class="grid md:grid-cols-2 gap-4">

                @foreach($masterFields as $field)

                    <label
                        class="flex items-center gap-3 border rounded-lg p-4 hover:bg-gray-50 cursor-pointer">

                        <input
                            type="checkbox"
                            name="master_fields[]"
                            value="{{ $field->id }}">

                        <div>

                            <div class="font-semibold">

                                {{ $field->label }}

                            </div>

                            <div class="text-sm text-gray-500">

                                {{ $field->kategori }}

                                •

                                {{ $field->tipe }}

                            </div>

                        </div>

                    </label>

                @endforeach

            </div>

            <div class="mt-8 flex justify-end">

                <button
                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">

                    Simpan

                </button>

            </div>

        </form>

    </div>

</div>

@endsection