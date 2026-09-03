@extends('layouts.admin')

@section('title', 'Kelola FAQ')

@section('content')

    <div class="p-6">

        {{-- Header --}}
        <div
            class="flex flex-col md:flex-row
                md:items-center
                md:justify-between
                gap-4 mb-8">

            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Kelola FAQ
                </h1>

                <p class="text-gray-500 mt-2">
                    Kelola pertanyaan yang sering ditanyakan masyarakat.
                </p>
            </div>

            <a href="{{ route('admin.faq.create') }}"
                class="inline-flex items-center justify-center
                   px-5 py-3
                   rounded-xl
                   bg-blue-600
                   hover:bg-blue-700
                   text-white font-semibold
                   transition">
                + Tambah FAQ
            </a>

        </div>

        {{-- Table --}}
        <div
            class="bg-white rounded-2xl
                shadow-sm
                border border-gray-100
                overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full text-left">

                    <thead class="bg-gray-100 border-b">

                        <tr>

                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">
                                No
                            </th>

                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">
                                Pertanyaan
                            </th>

                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">
                                Urutan
                            </th>

                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">
                                Status
                            </th>

                            <th class="px-6 py-4 text-sm font-semibold text-gray-600">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y">

                        @forelse ($faqs as $faq)
                            <tr class="hover:bg-gray-50">

                                <td class="px-6 py-4">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-6 py-4">

                                    <p class="font-semibold text-gray-800">
                                        {{ $faq->pertanyaan }}
                                    </p>

                                </td>

                                <td class="px-6 py-4">
                                    {{ $faq->urutan }}
                                </td>

                                <td class="px-6 py-4">

                                    @if ($faq->is_active)
                                        <span
                                            class="px-3 py-1
                                                 rounded-full
                                                 bg-green-100
                                                 text-green-700
                                                 text-sm">
                                            Aktif
                                        </span>
                                    @else
                                        <span
                                            class="px-3 py-1
                                                 rounded-full
                                                 bg-gray-100
                                                 text-gray-600
                                                 text-sm">
                                            Nonaktif
                                        </span>
                                    @endif

                                </td>

                                <td class="px-6 py-4">

                                    <div class="flex items-center gap-2">

                                        <a href="{{ route('admin.faq.edit', $faq->id) }}"
                                            class="px-3 py-2
                                               rounded-lg
                                             bg-yellow-500 hover:bg-yellow-600 text-white">
                                            Edit
                                        </a>


                                        <form id="delete-form-{{ $faq->id }}" action="{{ route('admin.faq.destroy', $faq->id) }}" method="POST">

                                            @csrf
                                            @method('DELETE')

                                             <button type="button" onclick="confirmDelete({{ $faq->id }})"
                                            class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded">

                                            Hapus

                                        </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5"
                                    class="px-6 py-10
                                       text-center
                                       text-gray-500">
                                    Belum ada FAQ.
                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

@endsection
