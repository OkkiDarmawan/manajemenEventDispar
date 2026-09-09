<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
            'lomba.event',
            'user',
        ]);

        // Search nama peserta
        if ($request->filled('search')) {

            $search = $request->search;

            $query->whereHas('user', function ($q) use ($search) {

                $q->where('name', 'like', '%'.$search.'%');

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
            'status' => 'required|in:Menunggu,Diterima,Ditolak',
            'alasan_penolakan' => 'required_if:status,Ditolak|nullable|string|max:1000',
        ], [
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
            'alasan_penolakan.required_if' => 'Alasan penolakan wajib diisi.',
            'alasan_penolakan.max' => 'Alasan penolakan maksimal 1000 karakter.',
        ]);

         if ($request->status === 'Diterima') {

        $jumlahDiterima = PendaftaranLomba::where(
            'lomba_id',
            $pendaftaranLomba->lomba_id
        )
        ->where('status', 'Diterima')
        ->where('id', '!=', $pendaftaranLomba->id)
        ->count();

        $kuota = $pendaftaranLomba->lomba->kuota;
  
        if ($jumlahDiterima >= $kuota) {
            return back()
                ->with('error', 'Kuota lomba sudah penuh. Peserta tidak dapat diterima.');
        }
         }

        $pendaftaranLomba->update([
            'status' => $request->status,
            'alasan_penolakan' => $request->status === 'Ditolak'
                    ? $request->alasan_penolakan
                    : null,
        ]);

        return redirect()
            ->back()
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
