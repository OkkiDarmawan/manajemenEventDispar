<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLombaRequest;
use App\Models\Event;
use App\Models\Lomba;
use Illuminate\Http\Request;

class LombaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lombas = Lomba::with('event')
            ->latest()
            ->paginate(10);

        $totalLomba = Lomba::count();

        $totalEvent = Event::count();

        $totalKuota = Lomba::sum('kuota');

        return view('admin.lomba.index', compact(
            'lombas',
            'totalLomba',
            'totalEvent',
            'totalKuota'
        ));
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
        Lomba::create($request->validated());

        return redirect()
            ->route('admin.lomba.index')
            ->with('success', 'Data lomba berhasil ditambahkan.');
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
