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
}
