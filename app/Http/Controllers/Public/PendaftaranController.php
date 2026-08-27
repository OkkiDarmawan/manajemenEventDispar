<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranLomba;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
     public function index()
    {
        $pendaftarans = PendaftaranLomba::with([
            'lomba.event'
        ])
        ->where('user_id', Auth::id())
        ->latest()
        ->get();

        return view(
            'public.pendaftaran.index',
            compact('pendaftarans')
        );
    }

    public function show(PendaftaranLomba $pendaftaranLomba)
{
    
    if ($pendaftaranLomba->user_id !== auth()->id()) {
        abort(403);
    }

    $pendaftaranLomba->load([
        'lomba.event',
        'jawabanLombas.masterField',
    ]);

    return view(
        'public.pendaftaran.show',
        compact('pendaftaranLomba')
    );
}
}
