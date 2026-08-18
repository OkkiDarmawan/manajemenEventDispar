<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranLomba;
use App\Models\Lomba;
use Illuminate\Http\Request;

class PendaftaranLombaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       $query = PendaftaranLomba::with([
        'lomba.event',
        'user',
    ]);

    // Search nama peserta
    if ($request->filled('search')) {

        $search = $request->search;

        $query->whereHas('user', function ($q) use ($search) {

            $q->where('name', 'like', '%' . $search . '%');

        });
    }

    // Filter lomba
    if ($request->filled('lomba_id')) {

        $query->where('lomba_id', $request->lomba_id);

    }

    // Filter status
    if ($request->filled('status')) {

        $query->where('status', $request->status);

    }

    $pendaftarans = $query
        ->latest()
        ->get();

    $lombas = Lomba::orderBy('nama_lomba')
        ->get();

    return view('admin.pendaftaran-lomba.index', compact(
        'pendaftarans',
        'lombas'
    ));
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
    public function update(Request $request, PendaftaranLomba $pendaftaranLomba)
    {
        $request->validate([
            'status' => [
                'required',
                'in:Menunggu,Diterima,Ditolak',
            ],
        ]);

        $pendaftaranLomba->update([
            'status' => $request->status,
        ]);

        return redirect()
            ->route(
                'admin.pendaftaran-lomba.show',
                $pendaftaranLomba->id
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
