@extends('layouts.admin')

@section('content')

<div class="max-w-7xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Kelola Workshop
            </h1>

            <p class="text-gray-500 mt-1">
                Kelola data workshop yang tersedia.
            </p>
        </div>

        <a
            href="{{ route('admin.workshop.create') }}"
            class="px-5 py-3
                   bg-blue-600
                   hover:bg-blue-700
                   text-white
                   rounded-xl
                   transition"
        >
            + Tambah Workshop
        </a>

    </div>


    {{-- Table --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-gray-100 border-b">

                    <tr>

                        <th class="px-6 py-4 text-left">
                            No
                        </th>

                        <th class="px-6 py-4 text-left">
                            Judul
                        </th>

                        <th class="px-6 py-4 text-left">
                            Narasumber
                        </th>

                        <th class="px-6 py-4 text-left">
                            Event
                        </th>

                        <th class="px-6 py-4 text-left">
                            Tanggal
                        </th>

                        <th class="px-6 py-4 text-left">
                            Kuota
                        </th>

                        <th class="px-6 py-4 text-left">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y">

                    @forelse ($workshops as $workshop)

                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-4">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-6 py-4 font-semibold">
                                {{ $workshop->judul }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $workshop->narasumber }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $workshop->event->nama_event }}
                            </td>

                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($workshop->tanggal)->format('d-m-Y') }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $workshop->kuota }} peserta
                            </td>

                            <td class="px-6 py-4">

                                <div class="flex gap-2">

                                    <a
                                        href="{{ route('admin.workshop.edit', $workshop->id) }}"
                                        class="px-3 py-2
                                               bg-yellow-500 hover:bg-yellow-600 text-white
                                               rounded-lg"
                                    >
                                        Edit
                                    </a>

                                   <form id="delete-form-{{ $workshop->id }}" action="{{ route('admin.workshop.destroy', $workshop->id) }}" method="POST">

                                            @csrf
                                            @method('DELETE')

                                             <button type="button" onclick="confirmDelete({{ $workshop->id }})"
                                            class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded">

                                            Hapus

                                        </button>

                                        </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="px-6 py-10
                                       text-center
                                       text-gray-500"
                            >
                                Belum ada workshop.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection