<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranLomba;
use App\Models\PendaftaranWorkshop;
use Illuminate\Http\Request;

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

        return view('public.pendaftaran-saya.index', compact(
            'pendaftaranLomba',
            'pendaftaranWorkshop'
        ));
    }
}
