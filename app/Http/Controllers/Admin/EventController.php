<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $today = Carbon::today();

        // Query utama untuk data event
        $query = Event::query();

        // Search
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('nama_event', 'like', "%{$search}%")
                    ->orWhere('lokasi', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");

            });
        }

        // Pagination 6 data per halaman
        $events = $query
            ->latest()
            ->paginate(6)
            ->withQueryString();

        // Summary
        $totalEvent = Event::count();

        $eventAktif = Event::whereDate(
            'tanggal_mulai',
            '<=',
            $today
        )
            ->whereDate(
                'tanggal_selesai',
                '>=',
                $today
            )
            ->count();

        $eventSelesai = Event::whereDate(
            'tanggal_selesai',
            '<',
            $today
        )
            ->count();

        return view(
            'admin.event.index',
            compact(
                'events',
                'totalEvent',
                'eventAktif',
                'eventSelesai'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.event.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        $poster = null;

        if ($request->hasFile('poster')) {

            $poster = $request
                ->file('poster')
                ->store('event', 'public');

        }

        Event::create([

            'nama_event' => $request->nama_event,

            'deskripsi' => $request->deskripsi,

            'penyelenggara' => $request->penyelenggara,

            'biaya' => $request->biaya,

            'link_gmaps' => $request->link_gmaps,

            'lokasi' => $request->lokasi,

            'tanggal_mulai' => $request->tanggal_mulai,

            'tanggal_selesai' => $request->tanggal_selesai,

            'poster' => $poster,

        ]);

        return redirect()
            ->route('admin.event.index')
            ->with('success', 'Event berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $event->load([
            'lombas',
            'workshops',
            'umkms',
        ]);

        return view('public.event.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('admin.event.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        // Gunakan poster lama sebagai default
        $poster = $event->poster;

        // Jika ada poster baru
        if ($request->hasFile('poster')) {

            // Hapus poster lama jika ada
            if ($event->poster && Storage::disk('public')->exists($event->poster)) {
                Storage::disk('public')->delete($event->poster);
            }

            // Upload poster baru
            $poster = $request->file('poster')->store('event', 'public');
        }

        // Update data
        $event->update([
            'nama_event' => $request->nama_event,

            'deskripsi' => $request->deskripsi,

            'penyelenggara' => $request->penyelenggara,

            'biaya' => $request->biaya,

            'link_gmaps' => $request->link_gmaps,

            'lokasi' => $request->lokasi,

            'tanggal_mulai' => $request->tanggal_mulai,

            'tanggal_selesai' => $request->tanggal_selesai,
            
            'poster' => $poster,
        ]);

        return redirect()
            ->route('admin.event.index')
            ->with('success', 'Data event berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        // Hapus poster jika ada
        if ($event->poster && Storage::disk('public')->exists($event->poster)) {

            Storage::disk('public')->delete($event->poster);

        }

        // Hapus data event
        $event->delete();

        return redirect()
            ->route('admin.event.index')
            ->with('success', 'Data event berhasil dihapus.');
    }
}
