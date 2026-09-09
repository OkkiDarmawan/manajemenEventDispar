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

        $pendaftaran = PendaftaranLomba::where('user_id', Auth::id())
            ->where('lomba_id', $lomba->id)
            ->latest()
            ->first();

        if ($pendaftaran && $pendaftaran->status !== 'Ditolak') {

            return redirect()
                ->route('public.pendaftaran-saya.index', $pendaftaran->id)
                ->with(
                    'info',
                    'Anda sudah memiliki pendaftaran untuk lomba ini.'
                );
        }

        // Cek jumlah peserta yang sudah diterima
        $jumlahDiterima = PendaftaranLomba::where('lomba_id', $lomba->id)
            ->where('status', 'Diterima')
            ->count();

        // Cek apakah kuota sudah penuh
        if ($jumlahDiterima >= $lomba->kuota) {
            return redirect()
                ->route('public.lomba.show', $lomba->id)
                ->with('error', 'Maaf, kuota lomba sudah penuh.');
        }

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
            ->with('masterField')
            ->where('is_active', true)
            ->get();

        $rules = [];
        $messages = [];

        foreach ($fields as $field) {

            $fieldName = 'field_'.$field->master_field_id;

            $rules[$fieldName] = $field->required
                ? 'required'
                : 'nullable';

            if ($field->required) {

                $messages[$fieldName.'.required'] =
                    $field->masterField->label.' wajib diisi.';
            }
        }

        $validated = $request->validate(
            $rules,
            $messages
        );

        $existing = PendaftaranLomba::where('lomba_id', $lomba->id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($existing) {

            return redirect()
                ->route('public.lomba.show', $lomba->id)
                ->with('error', 'Anda sudah terdaftar pada lomba ini.');
        }

        // Cek jumlah peserta yang sudah diterima
        $jumlahDiterima = PendaftaranLomba::where('lomba_id', $lomba->id)
            ->where('status', 'Diterima')
            ->count();

        // Cek kuota sebelum menyimpan
        if ($jumlahDiterima >= $lomba->kuota) {
            return redirect()
                ->route('public.lomba.show', $lomba->id)
                ->with('error', 'Maaf, kuota lomba sudah penuh.');
        }

        DB::transaction(function () use ($validated, $fields, $lomba) {

            $pendaftaran = PendaftaranLomba::create([
                'lomba_id' => $lomba->id,
                'user_id' => Auth::id(),
                'status' => 'Menunggu',
            ]);

            foreach ($fields as $field) {

                $value = $validated[
                    'field_'.$field->master_field_id
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

    public function show(PendaftaranLomba $pendaftaranLomba)
    {

        if ($pendaftaranLomba->user_id !== auth()->id()) {
            abort(403);
        }

        $pendaftaranLomba->load([
            'lomba.event',
            'jawabanLombas.masterField',
        ]);

        return view(
            'public.pendaftaran.show',
            compact('pendaftaranLomba')
        );
    }
}
