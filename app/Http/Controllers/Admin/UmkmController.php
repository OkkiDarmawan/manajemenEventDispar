<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UmkmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Umkm::with('event');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%")
                    ->orWhereHas('event', function ($eventQuery) use ($search) {
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
            $query->where('event_id', $request->event_id);
        }

        // Pagination
        $umkms = $query
            ->latest()
            ->paginate(6)
            ->withQueryString();

        // Data summary
        $totalUmkm = Umkm::count();
        $totalKuota = Umkm::sum('kuota');

        $events = Event::orderBy('nama_event')->get();

        return view(
            'admin.umkm.index',
            compact(
                'umkms',
                'totalUmkm',
                'totalKuota',
                'events'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $events = Event::orderBy('nama_event')->get();

        return view(
            'admin.umkm.create',
            compact('events')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => [
                'required',
                'exists:events,id',
            ],

            'nama' => [
                'required',
                'string',
                'max:255',
            ],

            'penyelenggara' => [
                'required',
                'string',
                'max:255',
            ],

            'deskripsi' => [
                'nullable',
                'string',
            ],

            'syarat' => [
                'nullable',
                'string',
            ],

            'poster' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],

            'pendaftaran_terbuka' => [
                'nullable',
                'date',
            ],

            'pendaftaran_tertutup' => [
                'nullable',
                'date',
                'after_or_equal:pendaftaran_terbuka',
            ],

            'kuota' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'biaya' => [
                'required',
                'numeric',
                'min:0',
            ],
        ], [
            'event_id.required' => 'Event wajib dipilih.',

            'event_id.exists' => 'Event tidak ditemukan.',

            'nama.required' => 'Nama UMKM wajib diisi.',

            'nama.max' => 'Nama UMKM maksimal 255 karakter.',

            'poster.image' => 'Poster harus berupa gambar.',

            'poster.mimes' => 'Poster harus berformat JPG, JPEG, atau PNG.',

            'poster.max' => 'Ukuran poster maksimal 2 MB.',

            'pendaftaran_tertutup.after_or_equal' => 'Tanggal penutupan harus setelah atau sama dengan tanggal pembukaan.',

            'kuota.integer' => 'Kuota harus berupa angka.',

            'kuota.min' => 'Kuota minimal 1 peserta.',

            'biaya.required' => 'Biaya wajib diisi.',

            'biaya.numeric' => 'Biaya harus berupa angka.',

            'biaya.min' => 'Biaya tidak boleh kurang dari 0.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Upload poster
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('poster')) {
            $validated['poster'] = $request->file('poster')
                ->store('poster-umkm', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Simpan UMKM
        |--------------------------------------------------------------------------
        |
        | Deskripsi dan syarat dapat berisi HTML custom.
        |
        */

        Umkm::create($validated);

        return redirect()
            ->route('admin.umkm.index')
            ->with(
                'success',
                'UMKM berhasil ditambahkan.'
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(Umkm $umkm)
    {
        return view(
            'admin.umkm.show',
            compact('umkm')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Umkm $umkm)
    {
        $events = Event::orderBy('nama_event')->get();

        return view(
            'admin.umkm.edit',
            compact(
                'umkm',
                'events'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Umkm $umkm)
    {
        $validated = $request->validate([
            'event_id' => [
                'required',
                'exists:events,id',
            ],

            'nama' => [
                'required',
                'string',
                'max:255',
            ],

            'penyelenggara' => [
                'required',
                'string',
                'max:255',
            ],

            'deskripsi' => [
                'nullable',
                'string',
            ],

            'syarat' => [
                'nullable',
                'string',
            ],

            'poster' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],

            'pendaftaran_terbuka' => [
                'nullable',
                'date',
            ],

            'pendaftaran_tertutup' => [
                'nullable',
                'date',
                'after_or_equal:pendaftaran_terbuka',
            ],

            'kuota' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'biaya' => [
                'required',
                'numeric',
                'min:0',
            ],
        ], [
            'event_id.required' => 'Event wajib dipilih.',

            'event_id.exists' => 'Event tidak ditemukan.',

            'nama.required' => 'Nama UMKM wajib diisi.',

            'nama.max' => 'Nama UMKM maksimal 255 karakter.',

            'poster.image' => 'Poster harus berupa gambar.',

            'poster.mimes' => 'Poster harus berformat JPG, JPEG, atau PNG.',

            'poster.max' => 'Ukuran poster maksimal 2 MB.',

            'pendaftaran_tertutup.after_or_equal' => 'Tanggal penutupan harus setelah atau sama dengan tanggal pembukaan.',

            'kuota.integer' => 'Kuota harus berupa angka.',

            'kuota.min' => 'Kuota minimal 1 peserta.',

            'biaya.required' => 'Biaya wajib diisi.',

            'biaya.numeric' => 'Biaya harus berupa angka.',

            'biaya.min' => 'Biaya tidak boleh kurang dari 0.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Upload poster baru
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('poster')) {

            if ($umkm->poster) {
                Storage::disk('public')->delete($umkm->poster);
            }

            $validated['poster'] = $request->file('poster')
                ->store('poster-umkm', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Update UMKM
        |--------------------------------------------------------------------------
        */

        $umkm->update($validated);

        return redirect()
            ->route('admin.umkm.index')
            ->with(
                'success',
                'UMKM berhasil diperbarui.'
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Umkm $umkm)
    {
        // Hapus poster jika ada
        if ($umkm->poster) {
            Storage::disk('public')->delete($umkm->poster);
        }

        $umkm->delete();

        return redirect()
            ->route('admin.umkm.index')
            ->with(
                'success',
                'UMKM berhasil dihapus.'
            );
    }
}
