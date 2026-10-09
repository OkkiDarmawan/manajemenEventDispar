<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Menampilkan profil masyarakat.
     */
    public function show()
    {
        $user = Auth::user();

        return view(
            'public.profile.show',
            compact('user')
        );
    }

    /**
     * Menampilkan form edit profil.
     */
    public function edit()
    {
        $user = Auth::user();

        return view(
            'public.profile.edit',
            compact('user')
        );
    }

    /**
     * Menyimpan perubahan profil.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'nik' => [
                'required',
                'digits:16',
                Rule::unique('users', 'nik')
                    ->ignore($user->id),
            ],

            'no_hp' => [
                'required',
                'regex:/^[1-9][0-9]{8,12}$/',
            ],

            'tanggal_lahir' => [
                'required',
                'date',
            ],

            'alamat' => [
                'required',
                'string',
            ],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',

            'nik.required' => 'NIK wajib diisi.',

            'nik.digits' => 'NIK harus terdiri dari tepat 16 angka.',

            'nik.unique' => 'NIK sudah digunakan oleh akun lain.',

            'no_hp.required' => 'Nomor handphone wajib diisi.',

            'no_hp.regex' => 'Nomor handphone harus diawali dengan angka 1-9 dan terdiri dari 9-13 angka.',

            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',

            'tanggal_lahir.date' => 'Tanggal lahir tidak valid.',

            'alamat.required' => 'Alamat wajib diisi.',
        ]);

        // Tambahkan 0 di depan nomor HP
        $validated['no_hp'] = '0'.$validated['no_hp'];

        $user->update($validated);

        return redirect()
            ->back()
            ->with('success', 'Data peserta berhasil diperbarui.');
    }
}
