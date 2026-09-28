<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PendaftaranUmkmExport;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\PendaftaranUmkm;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PendaftaranUmkmController extends Controller
{
    /**
     * Daftar pendaftaran UMKM
     */
    public function index(Request $request)
    {
        $query = PendaftaranUmkm::with([
            'user',
            'umkm.event',
        ]);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('nomor_peserta', 'like', "%{$search}%")

                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('nik', 'like', "%{$search}%")
                            ->orWhere('no_hp', 'like', "%{$search}%");
                    })

                    ->orWhereHas('umkm', function ($umkmQuery) use ($search) {
                        $umkmQuery->where('nama', 'like', "%{$search}%");
                    })

                    ->orWhereHas('umkm.event', function ($eventQuery) use ($search) {
                        $eventQuery->where(
                            'nama_event',
                            'like',
                            "%{$search}%"
                        );
                    });
            });
        }

        // Filter Event
        if ($request->filled('event_id')) {
            $query->whereHas('umkm', function ($q) use ($request) {
                $q->where('event_id', $request->event_id);
            });
        }

        // Filter UMKM
        if ($request->filled('umkm_id')) {
            $query->where('umkm_id', $request->umkm_id);
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pendaftarans = $query
            ->latest()
            ->paginate(6)
            ->withQueryString();

        // Data filter
        $events = Event::orderBy('nama_event')->get();

        $umkms = Umkm::with('event')
            ->orderBy('nama')
            ->get();

        return view(
            'admin.pendaftaran-umkm.index',
            compact(
                'pendaftarans',
                'events',
                'umkms'
            )
        );
    }

    /**
     * Detail pendaftaran
     */
    public function show(PendaftaranUmkm $pendaftaranUmkm)
    {
        $pendaftaranUmkm->load([
            'user',
            'umkm.event',
            'jawabanUmkms.masterField',
        ]);

        return view(
            'admin.pendaftaran-umkm.show',
            compact('pendaftaranUmkm')
        );
    }

    /**
     * Update status pendaftaran
     */
    public function updateStatus(
        Request $request,
        PendaftaranUmkm $pendaftaranUmkm
    ) {
        $validated = $request->validate([
            'status' => [
                'required',
                'in:Menunggu,Diterima,Ditolak',
            ],

            'alasan_penolakan' => [
                'required_if:status,Ditolak',
                'nullable',
                'string',
            ],
        ], [
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',

            'alasan_penolakan.required_if' => 'Alasan penolakan wajib diisi jika pendaftaran ditolak.',
        ]);

        DB::transaction(function () use (
            $validated,
            $pendaftaranUmkm
        ) {

            /*
            |--------------------------------------------------------------------------
            | Jika diterima
            |--------------------------------------------------------------------------
            */
            if ($validated['status'] === 'Diterima') {

                $umkm = $pendaftaranUmkm->umkm;

                /*
                | Cek kuota
                */
                if ($umkm->kuota !== null) {

                    $jumlahDiterima = PendaftaranUmkm::where(
                        'umkm_id',
                        $umkm->id
                    )
                        ->where('status', 'Diterima')
                        ->where('id', '!=', $pendaftaranUmkm->id)
                        ->count();

                    if ($jumlahDiterima >= $umkm->kuota) {
                        abort(
                            422,
                            'Kuota UMKM sudah penuh.'
                        );
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | Nomor peserta
                |--------------------------------------------------------------------------
                */
                if (! $pendaftaranUmkm->nomor_peserta) {

                    $nomor = 1;

                    while (
                        PendaftaranUmkm::where('umkm_id', $umkm->id)
                            ->where('status', 'Diterima')
                            ->where(
                                'nomor_peserta',
                                $nomor
                            )
                            ->exists()
                    ) {
                        $nomor++;
                    }

                    $pendaftaranUmkm->nomor_peserta = $nomor;
                }

                $pendaftaranUmkm->status = 'Diterima';
                $pendaftaranUmkm->alasan_penolakan = null;
            }

            /*
            |--------------------------------------------------------------------------
            | Jika ditolak
            |--------------------------------------------------------------------------
            */
            elseif ($validated['status'] === 'Ditolak') {

                $pendaftaranUmkm->status = 'Ditolak';

                $pendaftaranUmkm->alasan_penolakan =
                    $validated['alasan_penolakan'];

                $pendaftaranUmkm->nomor_peserta = null;
            }

            /*
            |--------------------------------------------------------------------------
            | Jika kembali Menunggu
            |--------------------------------------------------------------------------
            */
            else {

                $pendaftaranUmkm->status = 'Menunggu';

                $pendaftaranUmkm->alasan_penolakan = null;

                $pendaftaranUmkm->nomor_peserta = null;
            }

            $pendaftaranUmkm->save();
        });

        return redirect()
            ->route('admin.pendaftaran-umkm.show', $pendaftaranUmkm->id)
            ->with(
                'success',
                'Status pendaftaran UMKM berhasil diperbarui.'
            );
    }

    public function export()
    {
        return Excel::download(
            new PendaftaranUmkmExport,
            'pendaftaran-umkm.xlsx'
        );
    }
}
