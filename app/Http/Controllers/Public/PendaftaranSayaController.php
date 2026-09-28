<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranLomba;
use App\Models\PendaftaranUmkm;
use App\Models\PendaftaranWorkshop;

class PendaftaranSayaController extends Controller
{
    public function index()
    {
        $pendaftaranLomba = PendaftaranLomba::with('lomba')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        $pendaftaranWorkshop = PendaftaranWorkshop::with('workshop')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        $pendaftaranUmkm = PendaftaranUmkm::with('umkm.event')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('public.pendaftaran-saya.index', compact(
            'pendaftaranLomba',
            'pendaftaranWorkshop',
            'pendaftaranUmkm'
        ));
    }
}
