<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLombaFieldRequest;
use App\Models\Lomba;
use App\Models\LombaField;
use App\Models\MasterField;

class LombaFieldController extends Controller
{
    public function index(Lomba $lomba)
    {
        $masterFields = MasterField::where('aktif', true)
            ->orderBy('kategori')
            ->orderBy('label')
            ->get();

        $selectedFields = $lomba->fields()
            ->pluck('master_field_id')
            ->toArray();

        $requiredFields = $lomba->fields() 
            ->where('required', true)
            ->pluck('master_field_id')
            ->toArray();

        $fieldOrders = $lomba->fields()
            ->pluck('urutan', 'master_field_id')
            ->toArray();



        return view('admin.lomba.field', compact(
            'lomba',
            'masterFields',
            'selectedFields',
            'requiredFields',
            'fieldOrders'
        ));

    }

    public function store(StoreLombaFieldRequest $request, Lomba $lomba)
    {
        // Hapus konfigurasi lama
        $lomba->fields()->delete();

        // Simpan konfigurasi baru
        foreach ($request->master_fields ?? [] as $index => $fieldId) {

            LombaField::create([
                'lomba_id' => $lomba->id,
                'master_field_id' => $fieldId,
                'required' => in_array(
                    $fieldId,
                    $request->required_fields ?? []
                ),
                'urutan' => $request->order[$fieldId] ?? ($index + 1),
                'is_active' => true,
            ]);

        }

        return redirect()
            ->route('admin.lomba.field', $lomba)
            ->with('success', 'Konfigurasi field berhasil disimpan.');
    }

    public function preview(Lomba $lomba){
         $fields = $lomba->fields()
        ->where('is_active', true)
        ->with('masterField')
        ->orderBy('urutan')
        ->get();

    return view('admin.lomba.preview',compact(
            'lomba',
            'fields'
        )
    );
    }
}
