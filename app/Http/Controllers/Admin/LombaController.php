<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLombaRequest;
use App\Http\Requests\UpdateLombaRequest;
use App\Models\Event;
use App\Models\Lomba;
use Illuminate\Http\Request;

class LombaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Lomba::with('event');

        // Search
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('nama_lomba', 'like', "%{$search}%")
                    ->orWhereHas('event', function ($eventQuery) use ($search) {

                        $eventQuery->where(
                            'nama_event',
                            'like',
                            "%{$search}%"
                        );

                    });
            });
        }

        // Pagination
        $lombas = $query
            ->latest()
            ->paginate(6)
            ->withQueryString();

        // Summary
        $totalLomba = Lomba::count();
        $totalEvent = Event::count();
        $totalKuota = Lomba::sum('kuota');

        return view(
            'admin.lomba.index',
            compact(
                'lombas',
                'totalLomba',
                'totalEvent',
                'totalKuota'
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
            'admin.lomba.create',
            compact('events')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLombaRequest $request)
    {
        $validated = $request->validated();

        /*
        |--------------------------------------------------------------------------
        | Upload Poster
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('poster')) {

            $validated['poster'] = $request->file('poster')
                ->store('poster-lomba', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Simpan Lomba
        |--------------------------------------------------------------------------
        |
        | Deskripsi dan syarat disimpan sebagai HTML.
        |
        */

        Lomba::create($validated);

        return redirect()
            ->route('admin.lomba.index')
            ->with('success', 'Lomba berhasil ditambahkan.');
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
    public function edit(Lomba $lomba)
    {
        $events = Event::orderBy('nama_event')->get();

        return view(
            'admin.lomba.edit',
            compact(
                'lomba',
                'events'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateLombaRequest $request,
        Lomba $lomba
    ) {
        $data = $request->validated();

        /*
        |--------------------------------------------------------------------------
        | Upload Poster Baru
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('poster')) {

            $data['poster'] = $request->file('poster')
                ->store('poster-lomba', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Update Data Lomba
        |--------------------------------------------------------------------------
        |
        | Deskripsi dan syarat tetap berupa HTML custom.
        |
        */

        $lomba->update($data);

        return redirect()
            ->route('admin.lomba.index')
            ->with('success', 'Data lomba berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lomba $lomba)
    {
        $lomba->delete();

        return redirect()
            ->route('admin.lomba.index')
            ->with('success', 'Data lomba berhasil dihapus.');
    }
}

