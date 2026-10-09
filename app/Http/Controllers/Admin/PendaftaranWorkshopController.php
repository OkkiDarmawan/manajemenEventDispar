<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PendaftaranWorkshopExport;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\PendaftaranWorkshop;
use App\Models\Workshop;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PendaftaranWorkshopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PendaftaranWorkshop::with([
            'user',
            'workshop.event',
        ]);

        // =====================================================
        // SEARCH
        // =====================================================

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                // Cari berdasarkan data peserta
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
                'workshop',
                function ($workshopQuery) use ($request) {

                    $workshopQuery->where(
                        'event_id',
                        $request->event_id
                    );

                }
            );
        }

        // =====================================================
        // FILTER WORKSHOP
        // =====================================================

        if ($request->filled('workshop_id')) {

            $query->where(
                'workshop_id',
                $request->workshop_id
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
        // DATA FILTER
        // =====================================================

        $events = Event::orderBy('nama_event')
            ->get();

        $workshops = Workshop::orderBy('judul')
            ->get();

        return view(
            'admin.pendaftaran-workshop.index',
            compact(
                'pendaftarans',
                'events',
                'workshops'
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

            'alasan_penolakan' => [
                'required_if:status,Ditolak',
                'nullable',
                'string',
                'max:1000',
            ],
        ], [
            'status.required' => 'Status wajib dipilih.',

            'status.in' => 'Status tidak valid.',

            'alasan_penolakan.required_if' => 'Alasan penolakan wajib diisi.',

            'alasan_penolakan.max' => 'Alasan penolakan maksimal 1000 karakter.',
        ]);

        // =====================================================
        // JIKA DITERIMA
        // =====================================================

        if ($request->status === 'Diterima') {

            $jumlahDiterima = PendaftaranWorkshop::where(
                'workshop_id',
                $pendaftaranWorkshop->workshop_id
            )
                ->where('status', 'Diterima')
                ->where('id', '!=', $pendaftaranWorkshop->id)
                ->count();

            $kuota = $pendaftaranWorkshop->workshop->kuota;

            // Cek kuota
            if ($jumlahDiterima >= $kuota) {

                return back()
                    ->with(
                        'error',
                        'Kuota workshop sudah penuh. Peserta tidak dapat diterima.'
                    );
            }

            // =================================================
            // CARI NOMOR PESERTA YANG TERSEDIA
            // =================================================

            $nomorDigunakan = PendaftaranWorkshop::where(
                'workshop_id',
                $pendaftaranWorkshop->workshop_id
            )
                ->where('status', 'Diterima')
                ->whereNotNull('nomor_peserta')
                ->pluck('nomor_peserta')
                ->sort()
                ->values()
                ->toArray();

            $nomorPeserta = null;

            for ($i = 1; $i <= $kuota; $i++) {

                if (! in_array($i, $nomorDigunakan)) {

                    $nomorPeserta = $i;

                    break;
                }
            }

            if (! $nomorPeserta) {

                return back()
                    ->with(
                        'error',
                        'Nomor peserta tidak tersedia.'
                    );
            }

            $pendaftaranWorkshop->update([
                'status' => 'Diterima',
                'nomor_peserta' => $nomorPeserta,
                'alasan_penolakan' => null,
            ]);

        }

        // =====================================================
        // JIKA DITOLAK
        // =====================================================

        elseif ($request->status === 'Ditolak') {

            $pendaftaranWorkshop->update([
                'status' => 'Ditolak',
                'nomor_peserta' => null,
                'alasan_penolakan' => $request->alasan_penolakan,
            ]);

        }

        // =====================================================
        // JIKA KEMBALI MENUNGGU
        // =====================================================

        else {

            $pendaftaranWorkshop->update([
                'status' => 'Menunggu',
                'nomor_peserta' => null,
                'alasan_penolakan' => null,
            ]);

        }

        return redirect()
            ->route(
                'admin.pendaftaran-workshop.show',
                $pendaftaranWorkshop->id
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

    public function export(Request $request)
    {
          return Excel::download(
        new PendaftaranWorkshopExport(
            $request->only([
                'search',
                'event_id',
                'workshop_id',
                'status',
            ])
        ),
        'pendaftaran-workshop.xlsx'
    );
    }
}
