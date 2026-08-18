<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Lomba;
use App\Models\PendaftaranLomba;

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

        return view('public.lomba.show', compact(
            'lomba',
            'pendaftaran'
        ));
    }
}
