<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranUmkm;
use App\Models\JawabanUmkm;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UmkmController extends Controller
{
    /**
     * Detail UMKM
     */
    public function show(Umkm $umkm)
    {
        $umkm->load([
            'event',
        ]);

        $jumlahDiterima = PendaftaranUmkm::where('umkm_id', $umkm->id)
            ->where('status', 'Diterima')
            ->count();

        $sisaKuota = $umkm->kuota !== null
            ? max($umkm->kuota - $jumlahDiterima, 0)
            : null;

        $kuotaPenuh = $umkm->kuota !== null
            && $jumlahDiterima >= $umkm->kuota;

        $pendaftaran = null;

        if (auth()->check()) {
            $pendaftaran = PendaftaranUmkm::where('umkm_id', $umkm->id)
                ->where('user_id', auth()->id())
                ->latest()
                ->first();
        }

        return view('public.umkm.show', compact(
            'umkm',
            'jumlahDiterima',
            'sisaKuota',
            'kuotaPenuh',
            'pendaftaran'
        ));
    }

    /**
     * Form pendaftaran UMKM
     */
    public function create(Umkm $umkm)
    {
        $fields = $umkm->umkmFields()
            ->with('masterField')
            ->where('is_active', true)
            ->get();

        return view('public.umkm.daftar', compact(
            'umkm',
            'fields'
        ));
    }

    public function store(Request $request, Umkm $umkm)
    {
        /*
        |--------------------------------------------------------------------------
        | Ambil field aktif UMKM
        |--------------------------------------------------------------------------
        */
        $fields = $umkm->umkmFields()
            ->with('masterField')
            ->where('is_active', true)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Buat validasi dinamis
        |--------------------------------------------------------------------------
        */
        $rules = [];
        $messages = [];

        foreach ($fields as $field) {

            $fieldName = 'field_'.$field->master_field_id;

            // Field bertipe file
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
                    $field->masterField->label.
                    ' harus berupa JPG, JPEG, PNG, atau PDF.';

                $messages[$fieldName.'.max'] =
                    $field->masterField->label.
                    ' maksimal 2 MB.';
            }

            // Field biasa
            else {

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

        /*
        |--------------------------------------------------------------------------
        | Validasi
        |--------------------------------------------------------------------------
        */
        $validated = $request->validate(
            $rules,
            $messages
        );

        /*
        |--------------------------------------------------------------------------
        | Cek pendaftaran sebelumnya
        |--------------------------------------------------------------------------
        */
        $existing = PendaftaranUmkm::where('umkm_id', $umkm->id)
            ->where('user_id', auth()->id())
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Menunggu / Diterima tidak boleh daftar lagi
        |--------------------------------------------------------------------------
        */
        if ($existing && in_array($existing->status, ['Menunggu', 'Diterima'])) {

            return back()
                ->with('error', 'Kamu sudah terdaftar pada UMKM ini.');
        }

        /*
        |--------------------------------------------------------------------------
        | Cek kuota
        |--------------------------------------------------------------------------
        */
        if ($umkm->kuota !== null) {

            $jumlahDiterima = PendaftaranUmkm::where('umkm_id', $umkm->id)
                ->where('status', 'Diterima')
                ->count();

            if ($jumlahDiterima >= $umkm->kuota) {

                return redirect()
                    ->route('public.umkm.show', $umkm->id)
                    ->with('error', 'Maaf, kuota UMKM sudah penuh.');
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Simpan pendaftaran dan jawaban
        |--------------------------------------------------------------------------
        */
        DB::transaction(function () use (
            $request,
            $validated,
            $fields,
            $umkm,
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

                /*
                | Ambil jawaban lama
                */
                $jawabanLama = JawabanUmkm::where(
                    'pendaftaran_umkm_id',
                    $pendaftaran->id
                )->get();

                /*
                | Hapus file lama
                */
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
                        Storage::disk('public')
                            ->delete($jawaban->value);
                    }
                }

                /*
                | Hapus jawaban lama
                */
                JawabanUmkm::where(
                    'pendaftaran_umkm_id',
                    $pendaftaran->id
                )->delete();

            } else {

                /*
                |--------------------------------------------------------------------------
                | Belum pernah mendaftar
                |--------------------------------------------------------------------------
                */
                $pendaftaran = PendaftaranUmkm::create([
                    'umkm_id' => $umkm->id,
                    'user_id' => Auth::id(),
                    'status' => 'Menunggu',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Simpan jawaban field
            |--------------------------------------------------------------------------
            */
            foreach ($fields as $field) {

                $fieldName = 'field_'.$field->master_field_id;

                /*
                |--------------------------------------------------------------------------
                | Field File
                |--------------------------------------------------------------------------
                */
                if ($field->masterField->tipe === 'file') {

                    $filePath = null;

                    if ($request->hasFile($fieldName)) {

                        $filePath = $request
                            ->file($fieldName)
                            ->store('pendaftaran-umkm', 'public');
                    }

                    JawabanUmkm::create([
                        'pendaftaran_umkm_id' => $pendaftaran->id,
                        'master_field_id' => $field->master_field_id,
                        'value' => $filePath,
                    ]);

                }

                /*
                |--------------------------------------------------------------------------
                | Field Biasa
                |--------------------------------------------------------------------------
                */
                else {

                    $value = $validated[$fieldName] ?? null;

                    JawabanUmkm::create([
                        'pendaftaran_umkm_id' => $pendaftaran->id,
                        'master_field_id' => $field->master_field_id,
                        'value' => $value,
                    ]);
                }
            }
        });

        return redirect()
            ->route('public.pendaftaran-saya.index')
            ->with(
                'success',
                'Pendaftaran UMKM berhasil dikirim.'
            );
    }
}
