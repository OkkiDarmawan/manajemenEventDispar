<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUmkmFieldRequest;
use App\Models\MasterField;
use App\Models\Umkm;
use App\Models\UmkmField;

class UmkmFieldController extends Controller
{
    /**
     * Tampilkan halaman kelola field UMKM.
     */
    public function edit(Umkm $umkm)
    {
        $masterFields = MasterField::orderBy('label')->get();

        $selectedFields = $umkm->umkmFields()
            ->where('is_active', true)
            ->pluck('master_field_id')
            ->toArray();

        $requiredFields = $umkm->umkmFields()
            ->where('is_active', true)
            ->where('required', true)
            ->pluck('master_field_id')
            ->toArray();

        return view('admin.umkm.field', compact(
            'umkm',
            'masterFields',
            'selectedFields',
            'requiredFields'
        ));
    }

    /**
     * Simpan field UMKM.
     */
    public function store(StoreUmkmFieldRequest $request, Umkm $umkm)
    {
        $masterFields = $request->input('master_fields', []);

        // Nonaktifkan seluruh field lama
        $umkm->umkmFields()->update([
            'is_active' => false,
        ]);

        foreach ($masterFields as $masterFieldId => $data) {

            $isActive = isset($data['active']);

            UmkmField::updateOrCreate(
                [
                    'umkm_id' => $umkm->id,
                    'master_field_id' => $masterFieldId,
                ],
                [
                    'required' => $isActive && isset($data['required']),
                    'is_active' => $isActive,
                ]
            );
        }

        return redirect()
            ->route('admin.umkm.index')
            ->with('success', 'Field UMKM berhasil diperbarui.');
    }
}
