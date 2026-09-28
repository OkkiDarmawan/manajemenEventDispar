
@extends('layouts.admin')

@section('content')

<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">

    <div>
        <h2 class="text-2xl font-bold text-gray-800">
            Dashboard
        </h2>

        <p class="text-sm text-gray-500 mt-1">
            Statistik kegiatan dan pendaftaran pada periode yang dipilih.
        </p>
    </div>

    {{-- FILTER --}}
    <form action="{{ route('admin.dashboard') }}" method="GET"
        class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">

        <div class="flex flex-col sm:flex-row gap-3">

            {{-- Periode --}}
            <div>
                <label for="periode"
                    class="block text-xs font-medium text-gray-600 mb-1">
                    Periode
                </label>

                <select
                    name="periode"
                    id="periode"
                    onchange="this.form.submit()"
                    class="rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">

                    <option value="tahunan"
                        {{ $periode === 'tahunan' ? 'selected' : '' }}>
                        Per Tahun
                    </option>

                    <option value="bulanan"
                        {{ $periode === 'bulanan' ? 'selected' : '' }}>
                        Per Bulan
                    </option>

                </select>
            </div>

            {{-- Tahun --}}
            <div>
                <label for="tahun"
                    class="block text-xs font-medium text-gray-600 mb-1">
                    Tahun
                </label>

                <select
                    name="tahun"
                    id="tahun"
                    onchange="this.form.submit()"
                    class="rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">

                    @foreach ($tahunOptions as $tahunOption)

                        <option value="{{ $tahunOption }}"
                            {{ $tahun == $tahunOption ? 'selected' : '' }}>
                            {{ $tahunOption }}
                        </option>

                    @endforeach

                </select>
            </div>

            {{-- Bulan --}}
            @if ($periode === 'bulanan')

                @php
                    $namaBulan = [
                        1 => 'Januari',
                        2 => 'Februari',
                        3 => 'Maret',
                        4 => 'April',
                        5 => 'Mei',
                        6 => 'Juni',
                        7 => 'Juli',
                        8 => 'Agustus',
                        9 => 'September',
                        10 => 'Oktober',
                        11 => 'November',
                        12 => 'Desember',
                    ];
                @endphp

                <div>
                    <label for="bulan"
                        class="block text-xs font-medium text-gray-600 mb-1">
                        Bulan
                    </label>

                    <select
                        name="bulan"
                        id="bulan"
                        onchange="this.form.submit()"
                        class="rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">

                        @foreach ($namaBulan as $nomorBulan => $nama)
                            <option value="{{ $nomorBulan }}"
                                {{ $bulan == $nomorBulan ? 'selected' : '' }}>
                                {{ $nama }}
                            </option>
                        @endforeach

                    </select>
                </div>

            @endif

        </div>

    </form>

</div>


{{-- ========================================================= --}}
{{-- KARTU STATISTIK --}}
{{-- ========================================================= --}}

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">

    {{-- EVENT --}}
    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
        <p class="text-sm text-gray-500">
            Total Event
        </p>

        <h3 class="text-3xl font-bold text-gray-900 mt-2">
            {{ number_format($totalEvent) }}
        </h3>

        <p class="text-xs text-gray-400 mt-2">
            Pada periode terpilih
        </p>
    </div>


    {{-- LOMBA --}}
    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
        <p class="text-sm text-gray-500">
            Total Lomba
        </p>

        <h3 class="text-3xl font-bold text-gray-900 mt-2">
            {{ number_format($totalLomba) }}
        </h3>

        <p class="text-xs text-gray-400 mt-2">
            Pada periode terpilih
        </p>
    </div>


    {{-- WORKSHOP --}}
    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
        <p class="text-sm text-gray-500">
            Total Workshop
        </p>

        <h3 class="text-3xl font-bold text-gray-900 mt-2">
            {{ number_format($totalWorkshop) }}
        </h3>

        <p class="text-xs text-gray-400 mt-2">
            Pada periode terpilih
        </p>
    </div>


    {{-- UMKM --}}
    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
        <p class="text-sm text-gray-500">
            Total UMKM
        </p>

        <h3 class="text-3xl font-bold text-gray-900 mt-2">
            {{ number_format($totalUmkm) }}
        </h3>

        <p class="text-xs text-gray-400 mt-2">
            Pada periode terpilih
        </p>
    </div>


    {{-- PENDAFTARAN --}}
    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
        <p class="text-sm text-gray-500">
            Total Pendaftaran
        </p>

        <h3 class="text-3xl font-bold text-gray-900 mt-2">
            {{ number_format($totalPendaftaran) }}
        </h3>

        <p class="text-xs text-gray-400 mt-2">
            Semua jenis pendaftaran
        </p>
    </div>

</div>


{{-- ========================================================= --}}
{{-- GRAFIK PENDAFTARAN --}}
{{-- ========================================================= --}}

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">

    <div class="mb-5">
        <h3 class="text-lg font-bold text-gray-800">
            Tren Pendaftaran
        </h3>

        <p class="text-sm text-gray-500">
            {{ $periode === 'tahunan'
                ? 'Perbandingan jumlah pendaftaran setiap bulan.'
                : 'Perbandingan jumlah pendaftaran setiap hari.' }}
        </p>
    </div>

    <div class="relative h-[350px]">
        <canvas id="grafikPendaftaran"></canvas>
    </div>

</div>


{{-- ========================================================= --}}
{{-- GRAFIK STATUS + JUMLAH KEGIATAN --}}
{{-- ========================================================= --}}

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- STATUS PENDAFTARAN --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">

        <div class="mb-5">
            <h3 class="text-lg font-bold text-gray-800">
                Status Pendaftaran
            </h3>

            <p class="text-sm text-gray-500">
                Distribusi status seluruh pendaftaran.
            </p>
        </div>

        <div class="relative h-[300px] flex justify-center">
            <canvas id="grafikStatus"></canvas>
        </div>

    </div>


    {{-- JUMLAH KEGIATAN --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">

        <div class="mb-5">
            <h3 class="text-lg font-bold text-gray-800">
                Jumlah Kegiatan
            </h3>

            <p class="text-sm text-gray-500">
                Jumlah data kegiatan pada periode terpilih.
            </p>
        </div>

        <div class="relative h-[300px]">
            <canvas id="grafikKegiatan"></canvas>
        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- CHART.JS --}}
{{-- ========================================================= --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

<script>

    /*
    |--------------------------------------------------------------------------
    | DATA DARI LARAVEL
    |--------------------------------------------------------------------------
    */

    const grafikLabels = @json($grafikLabels);

    const grafikLomba = @json($grafikLomba);
    const grafikWorkshop = @json($grafikWorkshop);
    const grafikUmkm = @json($grafikUmkm);

    const statusPendaftaran = @json($statusPendaftaran);

    const totalEvent = {{ $totalEvent }};
    const totalLomba = {{ $totalLomba }};
    const totalWorkshop = {{ $totalWorkshop }};
    const totalUmkm = {{ $totalUmkm }};


    /*
    |--------------------------------------------------------------------------
    | GRAFIK TREN PENDAFTARAN
    |--------------------------------------------------------------------------
    */

    new Chart(document.getElementById('grafikPendaftaran'), {

        type: 'line',

        data: {

            labels: grafikLabels,

            datasets: [

                {
                    label: 'Lomba',
                    data: grafikLomba,
                    tension: 0.3,
                    borderWidth: 2,
                    fill: false
                },

                {
                    label: 'Workshop',
                    data: grafikWorkshop,
                    tension: 0.3,
                    borderWidth: 2,
                    fill: false
                },

                {
                    label: 'UMKM',
                    data: grafikUmkm,
                    tension: 0.3,
                    borderWidth: 2,
                    fill: false
                }

            ]
        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            interaction: {
                mode: 'index',
                intersect: false
            },

            plugins: {

                legend: {
                    position: 'top'
                }

            },

            scales: {

                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }

            }

        }

    });


    /*
    |--------------------------------------------------------------------------
    | GRAFIK STATUS
    |--------------------------------------------------------------------------
    */

    new Chart(document.getElementById('grafikStatus'), {

        type: 'doughnut',

        data: {

            labels: [
                'Menunggu',
                'Diterima',
                'Ditolak'
            ],

            datasets: [

                {
                    data: [
                        statusPendaftaran.Menunggu,
                        statusPendaftaran.Diterima,
                        statusPendaftaran.Ditolak
                    ],

                    borderWidth: 1
                }

            ]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {
                    position: 'bottom'
                }

            }

        }

    });


    /*
    |--------------------------------------------------------------------------
    | GRAFIK JUMLAH KEGIATAN
    |--------------------------------------------------------------------------
    */

    new Chart(document.getElementById('grafikKegiatan'), {

        type: 'bar',

        data: {

            labels: [
                'Event',
                'Lomba',
                'Workshop',
                'UMKM'
            ],

            datasets: [

                {
                    label: 'Jumlah Kegiatan',

                    data: [
                        totalEvent,
                        totalLomba,
                        totalWorkshop,
                        totalUmkm
                    ],

                    borderWidth: 1
                }

            ]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            scales: {

                y: {
                    beginAtZero: true,

                    ticks: {
                        precision: 0
                    }
                }

            },

            plugins: {

                legend: {
                    display: false
                }

            }

        }

    });

</script>

@endsection

