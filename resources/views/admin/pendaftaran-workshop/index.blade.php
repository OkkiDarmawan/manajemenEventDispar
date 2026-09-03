@extends('layouts.admin')

@section('content')
    <div class="p-6">

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                Pendaftaran Workshop
            </h1>

            <p class="text-gray-500 mt-1">
                Daftar peserta yang mendaftar workshop.
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full text-sm text-left">

                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-4 font-semibold text-gray-700">
                                No
                            </th>

                            <th class="px-6 py-4 font-semibold text-gray-700">
                                Peserta
                            </th>

                            <th class="px-6 py-4 font-semibold text-gray-700">
                                NIK
                            </th>

                            <th class="px-6 py-4 font-semibold text-gray-700">
                                Workshop
                            </th>

                            <th class="px-6 py-4 font-semibold text-gray-700">
                                Tanggal Daftar
                            </th>

                            <th class="px-6 py-4 font-semibold text-gray-700">
                                Status
                            </th>

                            <th class="px-6 py-4 font-semibold text-gray-700">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @forelse ($pendaftarans as $pendaftaran)
                            <tr class="hover:bg-gray-50">

                                <td class="px-6 py-4">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="font-semibold text-gray-800">
                                        {{ $pendaftaran->user->name }}
                                    </div>

                                    <div class="text-gray-500 text-xs mt-1">
                                        {{ $pendaftaran->user->no_hp }}
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    {{ $pendaftaran->user->nik }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="font-semibold text-gray-800">
                                        {{ $pendaftaran->workshop->judul }}
                                    </div>

                                    <div class="text-gray-500 text-xs mt-1">
                                        {{ $pendaftaran->workshop->tanggal
                                            ? \Carbon\Carbon::parse($pendaftaran->workshop->tanggal)->format('d-m-Y')
                                            : '-' }}
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    {{ $pendaftaran->created_at->format('d-m-Y H:i') }}
                                </td>

                                <td class="px-6 py-4">

                                    @if ($pendaftaran->status === 'Menunggu')
                                        <span
                                            class="inline-flex px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 font-semibold">
                                            Menunggu
                                        </span>
                                    @elseif ($pendaftaran->status === 'Diterima')
                                        <span
                                            class="inline-flex px-3 py-1 rounded-full bg-green-100 text-green-700 font-semibold">
                                            Diterima
                                        </span>
                                    @elseif ($pendaftaran->status === 'Ditolak')
                                        <span
                                            class="inline-flex px-3 py-1 rounded-full bg-red-100 text-red-700 font-semibold">
                                            Ditolak
                                        </span>
                                    @endif

                                </td>

                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.pendaftaran-workshop.show', $pendaftaran->id) }}"
                                        class="inline-flex px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold">
                                        Lihat Detail
                                    </a>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                    Belum ada pendaftaran workshop.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>
@endsection
