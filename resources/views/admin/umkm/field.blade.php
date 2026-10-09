@extends('layouts.admin')

@section('content')

    <div class="max-w-5xl mx-auto space-y-6">

        {{-- Header --}}
        <div class="flex items-center justify-between">

            <div>

                <h1 class="text-3xl font-bold text-gray-800">
                    Kelola Field
                </h1>

                <p class="text-gray-500 mt-1">

                    {{ $umkm->nama }}

                    •

                    {{ $umkm->event->nama_event }}

                </p>

            </div>

            <a
                href="{{ route('admin.umkm.index') }}"
                class="px-5 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition">

                ← Kembali

            </a>

        </div>


        {{-- Card utama --}}
        <div class="bg-white rounded-xl shadow p-8">

            <form
                action="{{ route('admin.umkm.field.store', $umkm->id) }}"
                method="POST">

                @csrf


                {{-- Daftar Master Field --}}
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

                    @foreach ($masterFields as $field)

                        <div
                            class="field-card border rounded-xl shadow-sm hover:shadow-md transition bg-white p-5">

                            {{-- Header --}}
                            <div class="flex items-start justify-between">

                                <div>

                                    <h3 class="font-bold text-lg text-gray-800">
                                        {{ $field->label }}
                                    </h3>

                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ ucfirst($field->tipe) }}
                                    </p>

                                </div>


                                {{-- Aktif --}}
                                <input
                                    type="checkbox"
                                    class="master-field w-5 h-5 text-blue-600 rounded"
                                    name="master_fields[]"
                                    value="{{ $field->id }}"
                                    {{ in_array($field->id, $selectedFields ?? []) ? 'checked' : '' }}>

                            </div>


                            {{-- Kategori --}}
                            <div class="mt-4">

                                <span
                                    class="inline-flex px-3 py-1 rounded-full text-xs bg-blue-100 text-blue-700">

                                    {{ $field->kategori }}

                                </span>

                            </div>


                            {{-- Required --}}
                            <div class="required-option mt-6">

                                <label class="flex items-center justify-between">

                                    <span class="text-sm text-gray-600">
                                        Wajib Diisi
                                    </span>

                                    <input
                                        type="checkbox"
                                        name="required_fields[]"
                                        value="{{ $field->id }}"
                                        class="w-5 h-5 text-green-600 rounded"
                                        {{ in_array($field->id, $requiredFields ?? []) ? 'checked' : '' }}>

                                </label>

                            </div>


                            {{-- Urutan --}}
                            <div class="order-option mt-5">

                                <label class="text-sm text-gray-600">
                                    Urutan Tampil
                                </label>

                                <select
                                    name="order[{{ $field->id }}]"
                                    class="mt-2 w-full rounded-lg border-gray-300">

                                    @for ($i = 1; $i <= count($masterFields); $i++)

                                        <option
                                            value="{{ $i }}"
                                            {{ ($fieldOrders[$field->id] ?? null) == $i ? 'selected' : '' }}>

                                            {{ $i }}

                                        </option>

                                    @endfor

                                </select>

                            </div>

                        </div>

                    @endforeach

                </div>


                {{-- Tombol --}}
                <div class="mt-8 flex justify-end gap-3">

                    <a
                        href="{{ route('admin.umkm.index') }}"
                        class="px-6 py-2 rounded-lg bg-gray-700 hover:bg-gray-800 text-white">

                        Batal

                    </a>

                    <button
                        type="submit"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">

                        Simpan

                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection


@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.master-field').forEach(function (checkbox) {

        updateCard(checkbox);

        checkbox.addEventListener('change', function () {

            updateCard(this);

        });

    });


    function updateCard(masterCheckbox) {

        const card = masterCheckbox.closest('.field-card');

        const required = card.querySelector('.required-option');
        const order = card.querySelector('.order-option');

        if (masterCheckbox.checked) {

            required.classList.remove('hidden');
            order.classList.remove('hidden');

            card.classList.add(
                'ring-2',
                'ring-blue-500',
                'border-blue-500',
                'bg-blue-50'
            );

        } else {

            required.classList.add('hidden');
            order.classList.add('hidden');

            const requiredInput = required.querySelector('input');

            if (requiredInput) {
                requiredInput.checked = false;
            }

            card.classList.remove(
                'ring-2',
                'ring-blue-500',
                'border-blue-500',
                'bg-blue-50'
            );

        }

    }

});
</script>

@endpush