<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

use App\Models\JawabanLomba;
use App\Models\Lomba;
use App\Models\PendaftaranLomba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PendaftaranLombaController extends Controller
{
    public function create(Lomba $lomba)
    {
        $fields = $lomba->lombaFields()
            ->with('masterField')
            ->where('is_active', true)
            ->orderBy('urutan')
            ->get();

        return view('public.pendaftaran', compact(
            'lomba',
            'fields'
        ));
    }

    public function store(Request $request, Lomba $lomba)
    {

        $fields = $lomba->lombaFields()
        ->where('is_active', true)
        ->get();

    $rules = [];

    foreach ($fields as $field) {

        $rules['field_' . $field->master_field_id] =
            $field->is_required ? 'required' : 'nullable';
    }

    $validated = $request->validate($rules);

    DB::transaction(function () use ($validated, $fields, $lomba) {

        $pendaftaran = PendaftaranLomba::create([
            'lomba_id' => $lomba->id,
            'user_id' => Auth::id(),
            'status' => 'Menunggu',
        ]);

        foreach ($fields as $field) {

            $value = $validated[
                'field_' . $field->master_field_id
            ] ?? null;

            JawabanLomba::create([
                'pendaftaran_lomba_id' => $pendaftaran->id,
                'master_field_id' => $field->master_field_id,
                'value' => $value,
            ]);
        }
    });

    return redirect()
        ->route('public.lomba.show', $lomba->id)
        ->with('success', 'Pendaftaran berhasil dikirim.');
    }
}
