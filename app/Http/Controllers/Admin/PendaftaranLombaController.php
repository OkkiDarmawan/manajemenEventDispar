<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Lomba;
use App\Models\PendaftaranLomba;
use Illuminate\Http\Request;

class PendaftaranLombaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = PendaftaranLomba::with([
        'user',
        'lomba.event',
    ]);


    // =====================================================
    // SEARCH
    // =====================================================

    if ($request->filled('search')) {

        $search = trim($request->search);

        $query->where(function ($q) use ($search) {

            // Cari berdasarkan nama peserta
            $q->whereHas('user', function ($userQuery) use ($search) {

                $userQuery->where(
                    'name',
                    'like',
                    "%{$search}%"
                )
                ->orWhere(
                    'nik',
                    'like',
                    "%{$search}%"
                )
                ->orWhere(
                    'no_hp',
                    'like',
                    "%{$search}%"
                );

            });


            // Cari berdasarkan nomor peserta
            $nomorPeserta = ltrim($search, '#');

            if (is_numeric($nomorPeserta)) {

                $q->orWhere(
                    'nomor_peserta',
                    (int) $nomorPeserta
                );

            }

        });
    }


    // =====================================================
    // FILTER EVENT
    // =====================================================

    if ($request->filled('event_id')) {

        $query->whereHas(
            'lomba',
            function ($lombaQuery) use ($request) {

                $lombaQuery->where(
                    'event_id',
                    $request->event_id
                );

            }
        );
    }


    // =====================================================
    // FILTER LOMBA
    // =====================================================

    if ($request->filled('lomba_id')) {

        $query->where(
            'lomba_id',
            $request->lomba_id
        );
    }


    // =====================================================
    // FILTER STATUS
    // =====================================================

    if ($request->filled('status')) {

        $query->where(
            'status',
            $request->status
        );
    }


    // =====================================================
    // PAGINATION
    // =====================================================

    $pendaftarans = $query
        ->latest()
        ->paginate(6)
        ->withQueryString();


    // =====================================================
    // DATA UNTUK FILTER
    // =====================================================

    $events = Event::orderBy('nama_event')
        ->get();

    $lombas = Lomba::orderBy('nama_lomba')
        ->get();


    return view(
        'admin.pendaftaran-lomba.index',
        compact(
            'pendaftarans',
            'events',
            'lombas'
        )
    );
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PendaftaranLomba $pendaftaranLomba)
    {
        $pendaftaranLomba->load([
            'user',
            'lomba.event',
            'jawabanLombas.masterField',
        ]);

        return view(
            'admin.pendaftaran-lomba.show',
            compact('pendaftaranLomba')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
    Request $request,
    PendaftaranLomba $pendaftaranLomba
) {
    $request->validate([
        'status' => 'required|in:Menunggu,Diterima,Ditolak',

        'alasan_penolakan' => [
            'required_if:status,Ditolak',
            'nullable',
            'string',
            'max:1000',
        ],
    ], [
        'status.required' =>
            'Status wajib dipilih.',

        'status.in' =>
            'Status tidak valid.',

        'alasan_penolakan.required_if' =>
            'Alasan penolakan wajib diisi.',

        'alasan_penolakan.max' =>
            'Alasan penolakan maksimal 1000 karakter.',
    ]);


    // =====================================================
    // JIKA PESERTA DITERIMA
    // =====================================================

    if ($request->status === 'Diterima') {

        $jumlahDiterima = PendaftaranLomba::where(
            'lomba_id',
            $pendaftaranLomba->lomba_id
        )
            ->where('status', 'Diterima')
            ->where('id', '!=', $pendaftaranLomba->id)
            ->count();


        $kuota = $pendaftaranLomba->lomba->kuota;


        // Kuota penuh
        if ($jumlahDiterima >= $kuota) {

            return back()
                ->with(
                    'error',
                    'Kuota lomba sudah penuh. Peserta tidak dapat diterima.'
                );
        }


        // =================================================
        // CARI NOMOR PESERTA YANG TERSEDIA
        // =================================================

        $nomorDigunakan = PendaftaranLomba::where(
            'lomba_id',
            $pendaftaranLomba->lomba_id
        )
            ->where('status', 'Diterima')
            ->whereNotNull('nomor_peserta')
            ->pluck('nomor_peserta')
            ->sort()
            ->values()
            ->toArray();


        $nomorPeserta = null;


        for ($i = 1; $i <= $kuota; $i++) {

            if (!in_array($i, $nomorDigunakan)) {

                $nomorPeserta = $i;

                break;
            }
        }


        // Kalau tidak menemukan slot
        if (!$nomorPeserta) {

            return back()
                ->with(
                    'error',
                    'Nomor peserta tidak tersedia.'
                );
        }


        $pendaftaranLomba->update([
            'status' => 'Diterima',
            'nomor_peserta' => $nomorPeserta,
            'alasan_penolakan' => null,
        ]);

    }


    // =====================================================
    // JIKA DITOLAK
    // =====================================================

    elseif ($request->status === 'Ditolak') {

        $pendaftaranLomba->update([
            'status' => 'Ditolak',
            'nomor_peserta' => null,
            'alasan_penolakan' => $request->alasan_penolakan,
        ]);

    }


    // =====================================================
    // JIKA DIKEMBALIKAN KE MENUNGGU
    // =====================================================

    else {

        $pendaftaranLomba->update([
            'status' => 'Menunggu',
            'nomor_peserta' => null,
            'alasan_penolakan' => null,
        ]);

    }


    return redirect()
        ->route(
            'admin.pendaftaran-lomba.show',
            $pendaftaranLomba->id
        )
        ->with(
            'success',
            'Status pendaftaran berhasil diperbarui.'
        );
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //  
    }
}
