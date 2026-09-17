<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranWorkshop;
use App\Models\Workshop;
use Illuminate\Http\Request;

class PendaftaranWorkshopController extends Controller
{
    public function create(Workshop $workshop)
    {
        $pendaftaranAktif = PendaftaranWorkshop::where('workshop_id', $workshop->id)
            ->where('user_id', auth()->id())
            ->whereIn('status', ['Menunggu', 'Diterima'])
            ->first();

        if ($pendaftaranAktif) {
            return redirect()
                ->route('public.workshop.show', $workshop->id)
                ->with('error', 'Kamu sudah terdaftar pada workshop ini.');
        }

        // Cek jumlah peserta yang sudah diterima
        $jumlahDiterima = PendaftaranWorkshop::where('workshop_id', $workshop->id)
            ->where('status', 'Diterima')
            ->count();

        // Cek apakah kuota sudah penuh
        if ($jumlahDiterima >= $workshop->kuota) {
            return redirect()
                ->route('public.workshop.show', $workshop->id)
                ->with('error', 'Maaf, kuota workshop sudah penuh.');
        }

        return view('public.workshop.daftar', compact('workshop'));
    }

    public function store(Request $request, Workshop $workshop)
    {
        $user = auth()->user();

        // Cek apakah user masih memiliki pendaftaran aktif
        $pendaftaranAktif = PendaftaranWorkshop::where('workshop_id', $workshop->id)
            ->where('user_id', $user->id)
            ->whereIn('status', ['Menunggu', 'Diterima'])
            ->first();

        if ($pendaftaranAktif) {
            return redirect()
                ->route('public.workshop.show', $workshop->id)
                ->with('error', 'Kamu sudah terdaftar pada workshop ini.');
        }

        // Cek jumlah peserta yang sudah diterima
        $jumlahDiterima = PendaftaranWorkshop::where('workshop_id', $workshop->id)
            ->where('status', 'Diterima')
            ->count();

        // Cek kuota sebelum menyimpan pendaftaran
        if ($jumlahDiterima >= $workshop->kuota) {
            return redirect()
                ->route('public.workshop.show', $workshop->id)
                ->with('error', 'Maaf, kuota workshop sudah penuh.');
        }

        // Validasi bukti pembayaran
        $request->validate([
            'bukti_pembayaran' => [
                $workshop->biaya > 0 ? 'required' : 'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:2048',
            ],
        ], [
            'bukti_pembayaran.required' => 'Bukti pembayaran wajib diunggah.',

            'bukti_pembayaran.file' => 'Bukti pembayaran harus berupa file.',

            'bukti_pembayaran.mimes' => 'Bukti pembayaran harus berupa JPG, JPEG, PNG, atau PDF.',

            'bukti_pembayaran.max' => 'Ukuran bukti pembayaran maksimal 2 MB.',
        ]);

        // Simpan file bukti pembayaran
        $buktiPembayaran = null;

        if ($request->hasFile('bukti_pembayaran')) {
            $buktiPembayaran = $request->file('bukti_pembayaran')
                ->store('bukti-pembayaran-workshop', 'public');
        }

        // Simpan pendaftaran
        PendaftaranWorkshop::create([
            'workshop_id' => $workshop->id,
            'user_id' => $user->id,
            'status' => 'Menunggu',
            'bukti_pembayaran' => $buktiPembayaran,
        ]);

        return redirect()
            ->route('public.pendaftaran-saya.index')
            ->with('success', 'Pendaftaran workshop berhasil dikirim.');
    }
}
