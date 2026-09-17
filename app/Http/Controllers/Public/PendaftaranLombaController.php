<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\JawabanLomba;
use App\Models\Lomba;
use App\Models\PendaftaranLomba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

            // Jika field bertipe file
            if ($field->masterField->tipe === 'file') {

                $rules[$fieldName] = [
                    $field->required ? 'required' : 'nullable',
                    'file',
                    'mimes:jpg,jpeg,png,pdf',
                    'max:2048',
                ];

                if ($field->required) {

                    $messages[$fieldName.'.required'] =
                        $field->masterField->label.' wajib diunggah.';
                }

                $messages[$fieldName.'.mimes'] =
                    $field->masterField->label.' harus berupa JPG, JPEG, PNG, atau PDF.';

                $messages[$fieldName.'.max'] =
                    $field->masterField->label.' maksimal 2 MB.';

            } else {

                // Field biasa
                $rules[$fieldName] = [
                    $field->required ? 'required' : 'nullable',
                    'string',
                ];

                if ($field->required) {

                    $messages[$fieldName.'.required'] =
                        $field->masterField->label.' wajib diisi.';
                }
            }
        }

        $validated = $request->validate(
            $rules,
            $messages
        );

        // Cari pendaftaran sebelumnya
        $existing = PendaftaranLomba::where('user_id', auth()->id())
            ->where('lomba_id', $lomba->id)
            ->first();

        // Jika masih Menunggu atau sudah Diterima,
        // tidak boleh mendaftar lagi
        if ($existing && in_array($existing->status, ['Menunggu', 'Diterima'])) {

            return back()
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

        DB::transaction(function () use (
            $request,
            $validated,
            $fields,
            $lomba,
            $existing
        ) {

            /*
            |--------------------------------------------------------------------------
            | Jika sebelumnya Ditolak
            |--------------------------------------------------------------------------
            */
            if ($existing && $existing->status === 'Ditolak') {

                $pendaftaran = $existing;

                $pendaftaran->update([
                    'status' => 'Menunggu',
                    'alasan_penolakan' => null,
                    'nomor_peserta' => null,
                ]);

                // Ambil jawaban lama
                $jawabanLama = JawabanLomba::where(
                    'pendaftaran_lomba_id',
                    $pendaftaran->id
                )->get();

                // Hapus file lama jika ada
                foreach ($jawabanLama as $jawaban) {

                    $oldField = $fields->firstWhere(
                        'master_field_id',
                        $jawaban->master_field_id
                    );

                    if (
                        $oldField &&
                        $oldField->masterField->tipe === 'file' &&
                        $jawaban->value
                    ) {
                        Storage::disk('public')->delete($jawaban->value);
                    }
                }

                // Hapus jawaban lama
                JawabanLomba::where(
                    'pendaftaran_lomba_id',
                    $pendaftaran->id
                )->delete();

            } else {

                /*
                |--------------------------------------------------------------------------
                | Belum pernah mendaftar
                |--------------------------------------------------------------------------
                */
                $pendaftaran = PendaftaranLomba::create([
                    'lomba_id' => $lomba->id,
                    'user_id' => Auth::id(),
                    'status' => 'Menunggu',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Simpan jawaban
            |--------------------------------------------------------------------------
            */
            foreach ($fields as $field) {

                $fieldName = 'field_'.$field->master_field_id;

                /*
                |--------------------------------------------------------------------------
                | Jika field berupa file
                |--------------------------------------------------------------------------
                */
                if ($field->masterField->tipe === 'file') {

                    $filePath = null;

                    if ($request->hasFile($fieldName)) {

                        $filePath = $request
                            ->file($fieldName)
                            ->store('pendaftaran-lomba', 'public');
                    }

                    JawabanLomba::create([
                        'pendaftaran_lomba_id' => $pendaftaran->id,
                        'master_field_id' => $field->master_field_id,
                        'value' => $filePath,
                    ]);

                } else {

                    /*
                    |--------------------------------------------------------------------------
                    | Field biasa
                    |--------------------------------------------------------------------------
                    */
                    $value = $validated[$fieldName] ?? null;

                    JawabanLomba::create([
                        'pendaftaran_lomba_id' => $pendaftaran->id,
                        'master_field_id' => $field->master_field_id,
                        'value' => $value,
                    ]);
                }
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
