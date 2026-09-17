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

        // Pagination 6 data per halaman
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

        return view('admin.lomba.create', compact('events'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLombaRequest $request)
    {
        $validated = $request->validate([
            'event_id' => [
                'required',
                'exists:events,id',
            ],

            'nama_lomba' => [
                'required',
                'string',
                'max:255',
            ],

            'kuota' => [
                'required',
                'integer',
                'min:1',
            ],

            'biaya' => [
                'required',
                'numeric',
                'min:0',
            ],

            'hadiah' => [
                'nullable',
                'string',
                'max:255',
            ],

            'pendaftaran_terbuka' => [
                'required',
                'date',
            ],

            'pendaftaran_tertutup' => [
                'required',
                'date',
                'after_or_equal:pendaftaran_terbuka',
            ],

            'syarat' => [
                'required',
                'string',
            ],

            'deskripsi' => [
                'required',
                'string',
            ],

            'poster' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],

            'penyelenggara' => [
                'required',
                'string',
                'max:255',
            ],
        ]);

        // Sanitasi HTML dari Quill
        $allowedTags = '<p><br><strong><b><em><i><u><ol><ul><li><h1><h2><h3><blockquote>';

        $validated['deskripsi'] = strip_tags(
            $validated['deskripsi'],
            $allowedTags
        );

        $validated['syarat'] = strip_tags(
            $validated['syarat'],
            $allowedTags
        );

        if ($request->hasFile('poster')) {
            $validated['poster'] = $request->file('poster')
                ->store('poster-lomba', 'public');
        }

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

        return view('admin.lomba.edit', compact(
            'lomba',
            'events'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLombaRequest $request, Lomba $lomba)
    {
        $data = [
            'event_id' => $request->event_id,
            'nama_lomba' => $request->nama_lomba,
            'kuota' => $request->kuota,
            'biaya' => $request->biaya,
            'hadiah' => $request->hadiah,
            'pendaftaran_terbuka' => $request->pendaftaran_terbuka,
            'pendaftaran_tertutup' => $request->pendaftaran_tertutup,
            'syarat' => $request->syarat,
            'deskripsi' => $request->deskripsi,
            'penyelenggara' => $request->penyelenggara,
        ];

        // Jika ada poster baru
        if ($request->hasFile('poster')) {

            $data['poster'] = $request->file('poster')
                ->store('poster-lomba', 'public');
        }

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
        // Hapus data lomba
        $lomba->delete();

        return redirect()
            ->route('admin.lomba.index')
            ->with('success', 'Data lomba berhasil dihapus.');
    }
}
