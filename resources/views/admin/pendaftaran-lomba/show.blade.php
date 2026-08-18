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
                    {{ $pendaftaranLomba->lomba->nama_lomba }}
                </p>

            </div>

            <a href="{{ route('admin.pendaftaran-lomba.index') }}" class="px-5 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg">

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
                        {{ $pendaftaranLomba->user->name }}
                    </p>

                </div>


                <div>

                    <p class="text-sm text-gray-500">
                        Event
                    </p>

                    <p class="font-semibold">
                        {{ $pendaftaranLomba->lomba->event->nama_event }}
                    </p>

                </div>


                <div>

                    <p class="text-sm text-gray-500">
                        Lomba
                    </p>

                    <p class="font-semibold">
                        {{ $pendaftaranLomba->lomba->nama_lomba }}
                    </p>

                </div>


                <div>

                    <p class="text-sm text-gray-500">
                        Status
                    </p>

                    <p class="font-semibold">
                        {{ $pendaftaranLomba->status }}
                    </p>

                </div>

            </div>

            <div class="mt-8 pt-6 border-t">

                <h3 class="font-semibold text-gray-800 mb-4">
                    Ubah Status Pendaftaran
                </h3>

                <form action="{{ route('admin.pendaftaran-lomba.status', $pendaftaranLomba->id) }}" method="POST"
                    class="flex items-center gap-3">

                    @csrf
                    @method('PATCH')

                    <select name="status" class="rounded-lg border-gray-300">

                        <option value="Menunggu" {{ $pendaftaranLomba->status === 'Menunggu' ? 'selected' : '' }}>
                            Menunggu
                        </option>

                        <option value="Diterima" {{ $pendaftaranLomba->status === 'Diterima' ? 'selected' : '' }}>
                            Diterima
                        </option>

                        <option value="Ditolak" {{ $pendaftaranLomba->status === 'Ditolak' ? 'selected' : '' }}>
                            Ditolak
                        </option>

                    </select>

                    <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">

                        Simpan Status

                    </button>

                </form>

            </div>

        </div>




        {{-- Jawaban Peserta --}}

        <div class="bg-white rounded-xl shadow p-8">

            <h2 class="text-xl font-bold mb-6">
                Data Pendaftaran
            </h2>

            <div class="space-y-5">

                @foreach ($pendaftaranLomba->jawabanLombas as $jawaban)
                    <div>

                        <p class="text-sm text-gray-500">
                            {{ $jawaban->masterField->label }}
                        </p>

                        <p class="font-semibold text-gray-800">
                            {{ $jawaban->value }}
                        </p>

                    </div>
                @endforeach

            </div>

        </div>

    </div>
@endsection
