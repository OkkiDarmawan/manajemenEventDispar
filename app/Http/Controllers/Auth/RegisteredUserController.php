<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {

        $noHp = preg_replace('/[^0-9]/', '', $request->no_hp);

        if (str_starts_with($noHp, '0')) {
            $noHp = substr($noHp, 1);
        }

        if (str_starts_with($noHp, '62')) {
            $noHp = substr($noHp, 2);
        }

       

        $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'nik' => [
                'required',
                'digits:16',
                'unique:users,nik',
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

            'password' => [
                'required',
                'confirmed',
                'min:6',
                'regex:/[A-Za-z]/',
                'regex:/[0-9]/',
            ],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',

            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus terdiri dari tepat 16 angka.',
            'nik.unique' => 'NIK sudah terdaftar.',

            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.regex' => 'Nomor HP harus menggunakan format Indonesia, contoh: 8123456789.',

            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid.',

            'alamat.required' => 'Alamat wajib diisi.',

            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.regex' => 'Password harus terdiri dari huruf dan angka.',
        ]);

        $noHp = '0' . $request->no_hp;

        $user = User::create([
            'name' => $request->name,
            'nik' => $request->nik,
            'no_hp' => $noHp,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('login', absolute: false));
    }
}
