<?php

use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\LombaController;
use App\Http\Controllers\Admin\LombaFieldController;
use App\Http\Controllers\Admin\MasterFieldController;
use App\Http\Controllers\Public\LombaController as PublicLombaController;
use App\Http\Controllers\Public\PendaftaranLombaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class,'index'])->name('home') ;

Route::get('/lomba/{lomba}', [PublicLombaController::class, 'show'])
    ->name('public.lomba.show');

Route::middleware('auth')->group(function () {

    Route::get(
        '/lomba/{lomba}/daftar',
        [PendaftaranLombaController::class, 'create']
    )->name('public.lomba.daftar');

    Route::post(
        '/lomba/{lomba}/daftar',
        [PendaftaranLombaController::class, 'store']
    )->name('public.lomba.daftar.store');

});

// Route Admin Start

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('master-field', MasterFieldController::class);
    Route::resource('event', EventController::class);
    Route::resource('lomba', LombaController::class);

    Route::get(
        'lomba/{lomba}/field',
        [LombaFieldController::class, 'index']
    )->name('lomba.field');

    Route::post(
        'lomba/{lomba}/field',
        [LombaFieldController::class, 'store']
    )->name('lomba.field.store');

    Route::get(
        '/lomba/{lomba}/preview',
        [LombaFieldController::class, 'preview']
    )->name('lomba.preview');
});

// Route Admin End

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
