<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranWorkshop;
use App\Models\Workshop;
use Illuminate\Http\Request;

class PendaftaranWorkshopController extends Controller
{
    public function create(Workshop $workshop)
    {
        $pendaftaranAktif = PendaftaranWorkshop::where('workshop_id', $workshop->id)
            ->where('user_id', auth()->id())
            ->whereIn('status', ['Menunggu', 'Diterima'])
            ->first();

        if ($pendaftaranAktif) {
            return redirect()
                ->route('public.workshop.show', $workshop->id)
                ->with('error', 'Kamu sudah terdaftar pada workshop ini.');
        }

        return view('public.workshop.daftar', compact('workshop'));
    }

    public function store(Request $request, Workshop $workshop)
    {
    $user = auth()->user();

    $pendaftaranAktif = PendaftaranWorkshop::where('workshop_id', $workshop->id)
        ->where('user_id', $user->id)
        ->whereIn('status', ['Menunggu', 'Diterima'])
        ->first();

    if ($pendaftaranAktif) {
        return redirect()
            ->route('public.workshop.show', $workshop->id)
            ->with('error', 'Kamu sudah terdaftar pada workshop ini.');
    }

    PendaftaranWorkshop::create([
        'workshop_id' => $workshop->id,
        'user_id' => $user->id,
        'status' => 'Menunggu',
    ]);

    return redirect()
        ->route('public.pendaftaran-saya.index')
        ->with('success', 'Pendaftaran workshop berhasil dikirim.');
    }
}
