<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranWorkshop;
use Illuminate\Http\Request;

class PendaftaranWorkshopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pendaftarans = PendaftaranWorkshop::with([
            'workshop',
            'user',
        ])
            ->latest()
            ->get();

        return view(
            'admin.pendaftaran-workshop.index',
            compact('pendaftarans')
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
    public function show(PendaftaranWorkshop $pendaftaranWorkshop)
    {
        $pendaftaranWorkshop->load([
            'user',
            'workshop',
        ]);

        return view(
            'admin.pendaftaran-workshop.show',
            compact('pendaftaranWorkshop')
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
    public function update(Request $request, PendaftaranWorkshop $pendaftaranWorkshop)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Diterima,Ditolak',
            'alasan_penolakan' => 'required_if:status,Ditolak|nullable|string|max:1000',
        ], [
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
            'alasan_penolakan.required_if' => 'Alasan penolakan wajib diisi.',
            'alasan_penolakan.max' => 'Alasan penolakan maksimal 1000 karakter.',
        ]);
        

         if ($request->status === 'Diterima') {

        $jumlahDiterima = PendaftaranWorkshop::where(
            'workshop_id',
            $pendaftaranWorkshop->workshop_id
        )
        ->where('status', 'Diterima')
        ->where('id', '!=', $pendaftaranWorkshop->id)
        ->count();

        $kuota = $pendaftaranWorkshop->workshop->kuota;

        if ($jumlahDiterima >= $kuota) {
            return back()
                ->with('error', 'Kuota workshop sudah penuh. Peserta tidak dapat diterima.');
        }
    }

        $pendaftaranWorkshop->update([
            'status' => $request->status,
            'alasan_penolakan' => $request->status === 'Ditolak'
                    ? $request->alasan_penolakan
                    : null,
        ]);

        return redirect()
            ->route(
                'admin.pendaftaran-workshop.show',
                $pendaftaranWorkshop->id
            )
            ->with('success', 'Status pendaftaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
