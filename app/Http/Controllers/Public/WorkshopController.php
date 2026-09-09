<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranWorkshop;
use App\Models\Workshop;

class WorkshopController extends Controller
{
    public function index()
    {
        $workshops = Workshop::with('event')
            ->latest()
            ->get();

        return view('public.workshop.index', compact('workshops'));
    }

    public function show(Workshop $workshop)
    {
        $workshop->load('event');

        $pendaftaran = null;

        if (auth()->check()) {
            $pendaftaran = PendaftaranWorkshop::where('workshop_id', $workshop->id)
                ->where('user_id', auth()->id())
                ->latest()
                ->first();
        }

        // Hitung jumlah peserta yang sudah diterima
        $jumlahDiterima = PendaftaranWorkshop::where('workshop_id', $workshop->id)
            ->where('status', 'Diterima')
            ->count();

        // Hitung sisa kuota
        $sisaKuota = max(0, $workshop->kuota - $jumlahDiterima);

        // Cek apakah kuota penuh
        $kuotaPenuh = $jumlahDiterima >= $workshop->kuota;

        return view(
            'public.workshop.show',
            compact(
                'workshop',
                'pendaftaran',
                'jumlahDiterima',
                'sisaKuota',
                'kuotaPenuh'
            )
        );
    }
}
