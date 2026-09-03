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
    public function index()
    {
        $workshops = Workshop::with('event')
            ->latest()
            ->get();

        return view('admin.workshop.index', compact('workshops'));
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
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'lokasi' => 'required|string|max:255',
            'kuota' => 'required|integer|min:1',
            'event_id' => 'required|exists:events,id',
        ], [
            'judul.required' => 'Judul workshop wajib diisi.',
            'narasumber.required' => 'Narasumber wajib diisi.',
            'deskripsi.required' => 'Deskripsi workshop wajib diisi.',
            'tanggal.required' => 'Tanggal workshop wajib diisi.',
            'lokasi.required' => 'Lokasi workshop wajib diisi.',
            'kuota.required' => 'Kuota wajib diisi.',
            'kuota.min' => 'Kuota minimal 1 peserta.',
            'event_id.required' => 'Event wajib dipilih.',
            'event_id.exists' => 'Event yang dipilih tidak valid.',
        ]);

        Workshop::create($validated);

        return redirect()
            ->route('admin.workshop.index')
            ->with('success', 'Workshop berhasil ditambahkan.');
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

    return view('admin.workshop.edit', compact(
        'workshop',
        'events'
    ));
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
        'tanggal' => 'required|date',
        'lokasi' => 'required|string|max:255',
        'kuota' => 'required|integer|min:1',
        'event_id' => 'required|exists:events,id',
    ]);

    $workshop->update($validated);

    return redirect()
        ->route('admin.workshop.index')
        ->with('success', 'Workshop berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Workshop $workshop)
    {
         $workshop->delete();

    return redirect()
        ->route('admin.workshop.index')
        ->with('success', 'Workshop berhasil dihapus.');
    }
}
