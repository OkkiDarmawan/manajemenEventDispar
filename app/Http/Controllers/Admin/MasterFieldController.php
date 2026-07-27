<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateMasterFieldRequest;
use App\Models\MasterField;
use Illuminate\Http\Request;

class MasterFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $masterFields = MasterField::latest()->paginate(10);

        $totalField = MasterField::count();

        $fieldAktif = MasterField::where('aktif', true)->count();

        $totalKategori = MasterField::distinct('kategori')->count('kategori');

        return view('admin.master-field.index', compact(
            'masterFields',
            'totalField',
            'fieldAktif',
            'totalKategori'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(MasterField $masterFields)
    {
        return view('admin.master-field.create', compact('masterField'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        MasterField::create([
            'label' => $request->label,
            'nama_field' => $request->nama_field,
            'tipe' => $request->tipe,
            'options' => null,
            'placeholder' => $request->placeholder,
            'kategori' => $request->kategori,
            'aktif' => $request->boolean('aktif'),
            'readonly' => $request->boolean('readonly'),
        ]);

        return redirect()
            ->route('admin.master-field.index')
            ->with('success', 'Master Field berhasil ditambahkan.');

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
    public function edit(MasterField $masterField)
    {
        return view('admin.master-field.edit', compact('masterField'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMasterFieldRequest $request, MasterField $masterField)
    {
         $masterField->update([
        'label' => $request->label,
        'nama_field' => $request->nama_field,
        'tipe' => $request->tipe,
        'kategori' => $request->kategori,
        'placeholder' => $request->placeholder,
        'aktif' => $request->boolean('aktif'),
        'readonly' => $request->boolean('readonly'),
    ]);

    return redirect()
        ->route('admin.master-field.index')
        ->with('success', 'Master Field berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterField $masterField)
    {
            // Cegah field readonly dihapus
    if ($masterField->readonly) {
        return redirect()
            ->route('admin.master-field.index')
            ->with('error', 'Field ini tidak dapat dihapus.');
    }

    $masterField->delete();

    return redirect()
        ->route('admin.master-field.index')
        ->with('success', 'Master Field berhasil dihapus.');
    }
}
