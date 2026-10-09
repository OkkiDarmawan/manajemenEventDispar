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

        $fieldOrders = $umkm->umkmFields()
            ->pluck('urutan', 'master_field_id')
            ->toArray();

        return view('admin.umkm.field', compact(
            'umkm',
            'masterFields',
            'selectedFields',
            'requiredFields',
            'fieldOrders'
        ));
    }

    /**
     * Simpan field UMKM.
     */
    public function store(StoreUmkmFieldRequest $request, Umkm $umkm)
    {
        $selectedFields = $request->input('master_fields', []);
        $requiredFields = $request->input('required_fields', []);
        $orders = $request->input('order', []);

        // Nonaktifkan semua field lama
        $umkm->umkmFields()->update([
            'is_active' => false,
            'required' => false,
        ]);

        foreach ($selectedFields as $masterFieldId) {

            UmkmField::updateOrCreate(
                [
                    'umkm_id' => $umkm->id,
                    'master_field_id' => $masterFieldId,
                ],
                [
                    'is_active' => true,
                    'required' => in_array($masterFieldId, $requiredFields),
                    'urutan' => (int) ($orders[$masterFieldId] ?? 0),
                ]
            );
        }

        return redirect()
            ->route('admin.umkm.index')
            ->with('success', 'Field UMKM berhasil diperbarui.');
    }
}
