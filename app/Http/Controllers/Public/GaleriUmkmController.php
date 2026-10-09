<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranUmkm;

class GaleriUmkmController extends Controller
{
    public function index()
    {
        $pendaftarans = PendaftaranUmkm::with([
            'umkm.event',
            'jawabanUmkms.masterField',
        ])
            ->where('status', 'Diterima')
            ->latest()
            ->paginate(24);

        $pendaftarans->getCollection()->transform(
            function ($pendaftaran) {

                $namaUmkm = null;
                $fotoUmkm = null;

                foreach ($pendaftaran->jawabanUmkms as $jawaban) {

                    $namaField = strtolower(
                        trim(
                            $jawaban->masterField?->nama_field ?? ''
                        )
                    );

                    /*
                    |--------------------------------------------------------------------------
                    | Nama UMKM
                    |--------------------------------------------------------------------------
                    */

                    if ($namaField === 'nama_umkm') {
                        $namaUmkm = $jawaban->value;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Foto UMKM
                    |--------------------------------------------------------------------------
                    */

                    if ($namaField === 'foto_umkm') {
                        $fotoUmkm = $jawaban->value;
                    }
                }

                $pendaftaran->nama_umkm =
                    $namaUmkm ?: 'UMKM Peserta';

                $pendaftaran->foto_umkm =
                    $fotoUmkm;

                return $pendaftaran;
            }
        );

        return view(
            'public.galeri-umkm.index',
            compact('pendaftarans')
        );
    }

     public function show(PendaftaranUmkm $pendaftaranUmkm)
    {
        /*
        |--------------------------------------------------------------------------
        | Hanya UMKM yang sudah diterima yang boleh tampil
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $pendaftaranUmkm->status === 'Diterima',
            404
        );

        /*
        |--------------------------------------------------------------------------
        | Ambil semua relasi yang dibutuhkan
        |--------------------------------------------------------------------------
        */

        $pendaftaranUmkm->load([
            'umkm.event',
            'jawabanUmkms.masterField',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Ambil nama dan foto UMKM
        |--------------------------------------------------------------------------
        */

        $namaUmkm = null;
        $fotoUmkm = null;

        foreach ($pendaftaranUmkm->jawabanUmkms as $jawaban) {

            $namaField = strtolower(
                trim(
                    $jawaban->masterField?->nama_field ?? ''
                )
            );

            if ($namaField === 'nama_umkm') {
                $namaUmkm = $jawaban->value;
            }

            if ($namaField === 'foto_umkm') {
                $fotoUmkm = $jawaban->value;
            }
        }

        return view(
            'public.galeri-umkm.show',
            compact(
                'pendaftaranUmkm',
                'namaUmkm',
                'fotoUmkm'
            )
        );
    }
}