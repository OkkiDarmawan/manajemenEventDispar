<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Lomba;
use App\Models\PendaftaranLomba;
use App\Models\PendaftaranUmkm;
use App\Models\PendaftaranWorkshop;
use App\Models\Umkm;
use App\Models\Workshop;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Filter
        |--------------------------------------------------------------------------
        */

        $periode = $request->input('periode', 'tahunan');
        $tahun = (int) $request->input('tahun', now()->year);
        $bulan = (int) $request->input('bulan', now()->month);

        if (! in_array($periode, ['bulanan', 'tahunan'])) {
            $periode = 'tahunan';
        }

        if ($tahun < 2020 || $tahun > 2100) {
            $tahun = now()->year;
        }

        if ($bulan < 1 || $bulan > 12) {
            $bulan = now()->month;
        }

        /*
        |--------------------------------------------------------------------------
        | Tentukan tanggal awal dan akhir
        |--------------------------------------------------------------------------
        */

        if ($periode === 'bulanan') {
            $startDate = now()
                ->setYear($tahun)
                ->setMonth($bulan)
                ->startOfMonth();

            $endDate = $startDate->copy()->endOfMonth();
        } else {
            $startDate = now()
                ->setYear($tahun)
                ->startOfYear();

            $endDate = $startDate->copy()->endOfYear();
        }

        /*
        |--------------------------------------------------------------------------
        | Total kegiatan pada periode yang dipilih
        |--------------------------------------------------------------------------
        */

        $totalEvent = Event::whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $totalLomba = Lomba::whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $totalWorkshop = Workshop::whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $totalUmkm = Umkm::whereBetween('created_at', [$startDate, $endDate])
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Data pendaftaran
        |--------------------------------------------------------------------------
        */

        $lombaQuery = PendaftaranLomba::whereBetween(
            'created_at',
            [$startDate, $endDate]
        );

        $workshopQuery = PendaftaranWorkshop::whereBetween(
            'created_at',
            [$startDate, $endDate]
        );

        $umkmQuery = PendaftaranUmkm::whereBetween(
            'created_at',
            [$startDate, $endDate]
        );

        $totalPendaftaran =
            (clone $lombaQuery)->count()
            + (clone $workshopQuery)->count()
            + (clone $umkmQuery)->count();

        /*
        |--------------------------------------------------------------------------
        | Grafik tren pendaftaran
        |--------------------------------------------------------------------------
        */

        $grafikLabels = [];
        $grafikLomba = [];
        $grafikWorkshop = [];
        $grafikUmkm = [];

        if ($periode === 'bulanan') {

            // Jumlah hari dalam bulan
            $jumlahHari = $startDate->daysInMonth;

            // Data lomba berdasarkan tanggal
            $dataLomba = (clone $lombaQuery)
                ->selectRaw('DATE(created_at) as periode, COUNT(*) as total')
                ->groupBy('periode')
                ->pluck('total', 'periode');

            // Data workshop berdasarkan tanggal
            $dataWorkshop = (clone $workshopQuery)
                ->selectRaw('DATE(created_at) as periode, COUNT(*) as total')
                ->groupBy('periode')
                ->pluck('total', 'periode');

            // Data UMKM berdasarkan tanggal
            $dataUmkm = (clone $umkmQuery)
                ->selectRaw('DATE(created_at) as periode, COUNT(*) as total')
                ->groupBy('periode')
                ->pluck('total', 'periode');

            for ($hari = 1; $hari <= $jumlahHari; $hari++) {

                $tanggal = $startDate->copy()->day($hari);
                $key = $tanggal->toDateString();

                $grafikLabels[] = (string) $hari;

                $grafikLomba[] = (int) ($dataLomba[$key] ?? 0);
                $grafikWorkshop[] = (int) ($dataWorkshop[$key] ?? 0);
                $grafikUmkm[] = (int) ($dataUmkm[$key] ?? 0);
            }

        } else {

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

            $grafikLabels = array_values($namaBulan);

            $dataLomba = (clone $lombaQuery)
                ->selectRaw('MONTH(created_at) as periode, COUNT(*) as total')
                ->groupBy('periode')
                ->pluck('total', 'periode');

            $dataWorkshop = (clone $workshopQuery)
                ->selectRaw('MONTH(created_at) as periode, COUNT(*) as total')
                ->groupBy('periode')
                ->pluck('total', 'periode');

            $dataUmkm = (clone $umkmQuery)
                ->selectRaw('MONTH(created_at) as periode, COUNT(*) as total')
                ->groupBy('periode')
                ->pluck('total', 'periode');

            for ($bulanKe = 1; $bulanKe <= 12; $bulanKe++) {

                $grafikLomba[] = (int) ($dataLomba[$bulanKe] ?? 0);
                $grafikWorkshop[] = (int) ($dataWorkshop[$bulanKe] ?? 0);
                $grafikUmkm[] = (int) ($dataUmkm[$bulanKe] ?? 0);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Grafik status pendaftaran
        |--------------------------------------------------------------------------
        */

        $statusPendaftaran = [
            'Menunggu' => 0,
            'Diterima' => 0,
            'Ditolak' => 0,
        ];

        foreach ($statusPendaftaran as $status => $jumlah) {

            $statusPendaftaran[$status] =
                (clone $lombaQuery)->where('status', $status)->count()
                + (clone $workshopQuery)->where('status', $status)->count()
                + (clone $umkmQuery)->where('status', $status)->count();
        }

        /*
        |--------------------------------------------------------------------------
        | Tahun untuk filter
        |--------------------------------------------------------------------------
        */

        $tahunSekarang = now()->year;

        $tahunOptions = range(
            $tahunSekarang - 5,
            $tahunSekarang
        );

        rsort($tahunOptions);

        /*
        |--------------------------------------------------------------------------
        | Kirim ke view
        |--------------------------------------------------------------------------
        */

        return view('admin.dashboard', compact(
            'periode',
            'tahun',
            'bulan',
            'startDate',
            'endDate',

            'totalEvent',
            'totalLomba',
            'totalWorkshop',
            'totalUmkm',
            'totalPendaftaran',

            'grafikLabels',
            'grafikLomba',
            'grafikWorkshop',
            'grafikUmkm',

            'statusPendaftaran',

            'tahunOptions'
        ));
    }
}
