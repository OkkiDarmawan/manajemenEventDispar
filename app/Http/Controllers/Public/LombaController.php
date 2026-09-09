<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Lomba;
use App\Models\PendaftaranLomba;
use Illuminate\Support\Facades\Auth;

class LombaController extends Controller
{
    public function show(Lomba $lomba)
    {
        $lomba->load('event');

        $pendaftaran = null;

        if (Auth::check()) {

            $pendaftaran = PendaftaranLomba::where('lomba_id', $lomba->id)
                ->where('user_id', Auth::id())
                ->first();
        }

        $jumlahDiterima = PendaftaranLomba::where('lomba_id', $lomba->id)
            ->where('status', 'Diterima')
            ->count();

        $sisaKuota = max(0, $lomba->kuota - $jumlahDiterima);

        $kuotaPenuh = $jumlahDiterima >= $lomba->kuota;

        return view('public.lomba.show', compact(
            'lomba',
            'pendaftaran',
            'jumlahDiterima',
            'sisaKuota',
            'kuotaPenuh'
        ));
    }
}
