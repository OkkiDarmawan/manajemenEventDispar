<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Workshop;
use Illuminate\Http\Request;

class WorkshopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Workshop::with('event');

        // Search
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('narasumber', 'like', "%{$search}%")
                    ->orWhere('lokasi', 'like', "%{$search}%")
                    ->orWhereHas('event', function ($eventQuery) use ($search) {

                        $eventQuery->where(
                            'nama_event',
                            'like',
                            "%{$search}%"
                        );
                    });
            });
        }

        // Pagination 6 data per halaman
        $workshops = $query
            ->latest()
            ->paginate(6)
            ->withQueryString();

        // Summary
        $totalWorkshop = Workshop::count();

        $workshopAkanDatang = Workshop::whereDate(
            'tanggal_mulai',
            '>',
            now()->toDateString()
        )->count();

        $workshopSelesai = Workshop::whereDate(
            'tanggal_selesai',
            '<',
            now()->toDateString()
        )->count();

        return view(
            'admin.workshop.index',
            compact(
                'workshops',
                'totalWorkshop',
                'workshopAkanDatang',
                'workshopSelesai'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $events = Event::orderBy('nama_event')->get();

        return view('admin.workshop.create', compact('events'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',

            'narasumber' => 'required|string|max:255',

            'penyelenggara' => 'required|string|max:255',

            'deskripsi' => 'required|string',

            'syarat' => 'nullable|string',

            'tanggal_mulai' => 'required|date',

            'tanggal_selesai' => [
                'required',
                'date',
                'after_or_equal:tanggal_mulai',
            ],

            'lokasi' => 'required|string|max:255',

            'kuota' => 'required|integer|min:1',

            'biaya' => [
                'required',
                'numeric',
                'min:0',
            ],

            'event_id' => 'required|exists:events,id',

            'poster' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],
        ], [
            'judul.required' => 'Judul workshop wajib diisi.',

            'narasumber.required' => 'Narasumber wajib diisi.',

            'deskripsi.required' => 'Deskripsi workshop wajib diisi.',

            'tanggal_mulai.required' => 'Tanggal mulai workshop wajib diisi.',

            'tanggal_mulai.date' => 'Tanggal mulai workshop tidak valid.',

            'tanggal_selesai.required' => 'Tanggal selesai workshop wajib diisi.',

            'tanggal_selesai.date' => 'Tanggal selesai workshop tidak valid.',

            'tanggal_selesai.after_or_equal' =>
                'Tanggal selesai harus sama atau setelah tanggal mulai.',

            'lokasi.required' => 'Lokasi workshop wajib diisi.',

            'kuota.required' => 'Kuota wajib diisi.',

            'kuota.min' => 'Kuota minimal 1 peserta.',

            'biaya.required' => 'Biaya workshop wajib diisi.',

            'biaya.numeric' => 'Biaya workshop harus berupa angka.',

            'biaya.min' => 'Biaya workshop tidak boleh kurang dari 0.',

            'event_id.required' => 'Event wajib dipilih.',

            'event_id.exists' => 'Event yang dipilih tidak valid.',

            'poster.image' => 'File poster harus berupa gambar.',

            'poster.mimes' =>
                'Poster harus berformat JPG, JPEG, atau PNG.',

            'poster.max' =>
                'Ukuran poster maksimal 2 MB.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Upload poster
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('poster')) {
            $validated['poster'] = $request->file('poster')
                ->store('poster-workshop', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Simpan workshop
        |--------------------------------------------------------------------------
        |
        | Deskripsi dan syarat dapat berisi HTML custom.
        |
        */

        Workshop::create($validated);

        return redirect()
            ->route('admin.workshop.index')
            ->with(
                'success',
                'Workshop berhasil ditambahkan.'
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Workshop $workshop)
    {
        $events = Event::orderBy('nama_event')->get();

        return view(
            'admin.workshop.edit',
            compact(
                'workshop',
                'events'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Workshop $workshop)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',

            'narasumber' => 'required|string|max:255',

            'deskripsi' => 'required|string',

            'penyelenggara' => 'required|string|max:255',

            'syarat' => 'nullable|string',

            'tanggal_mulai' => 'required|date',

            'tanggal_selesai' => [
                'required',
                'date',
                'after_or_equal:tanggal_mulai',
            ],

            'lokasi' => 'required|string|max:255',

            'kuota' => 'required|integer|min:1',

            'biaya' => [
                'required',
                'numeric',
                'min:0',
            ],

            'event_id' => 'required|exists:events,id',

            'poster' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],
        ], [
            'judul.required' => 'Judul workshop wajib diisi.',

            'narasumber.required' => 'Narasumber wajib diisi.',

            'deskripsi.required' => 'Deskripsi workshop wajib diisi.',

            'tanggal_mulai.required' =>
                'Tanggal mulai workshop wajib diisi.',

            'tanggal_mulai.date' =>
                'Tanggal mulai workshop tidak valid.',

            'tanggal_selesai.required' =>
                'Tanggal selesai workshop wajib diisi.',

            'tanggal_selesai.date' =>
                'Tanggal selesai workshop tidak valid.',

            'tanggal_selesai.after_or_equal' =>
                'Tanggal selesai harus sama atau setelah tanggal mulai.',

            'lokasi.required' =>
                'Lokasi workshop wajib diisi.',

            'kuota.required' =>
                'Kuota wajib diisi.',

            'kuota.min' =>
                'Kuota minimal 1 peserta.',

            'biaya.required' =>
                'Biaya workshop wajib diisi.',

            'biaya.numeric' =>
                'Biaya workshop harus berupa angka.',

            'biaya.min' =>
                'Biaya workshop tidak boleh kurang dari 0.',

            'event_id.required' =>
                'Event wajib dipilih.',

            'event_id.exists' =>
                'Event yang dipilih tidak valid.',

            'poster.image' =>
                'File poster harus berupa gambar.',

            'poster.mimes' =>
                'Poster harus berformat JPG, JPEG, atau PNG.',

            'poster.max' =>
                'Ukuran poster maksimal 2 MB.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Upload poster baru jika ada
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('poster')) {
            $validated['poster'] = $request->file('poster')
                ->store('poster-workshop', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Update workshop
        |--------------------------------------------------------------------------
        */

        $workshop->update($validated);

        return redirect()
            ->route('admin.workshop.index')
            ->with(
                'success',
                'Workshop berhasil diperbarui.'
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Workshop $workshop)
    {
        $workshop->delete();

        return redirect()
            ->route('admin.workshop.index')
            ->with(
                'success',
                'Workshop berhasil dihapus.'
            );
    }
}

