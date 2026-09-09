<?php

// Import Admin
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\LombaController;
use App\Http\Controllers\Admin\LombaFieldController;
use App\Http\Controllers\Admin\MasterFieldController;
use App\Http\Controllers\Admin\PendaftaranLombaController;
use App\Http\Controllers\Admin\PendaftaranWorkshopController;
use App\Http\Controllers\Admin\WorkshopController;
// Import Public
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\EventController as PublicEventController;
use App\Http\Controllers\Public\LombaController as PublicLombaController;
use App\Http\Controllers\Public\PendaftaranLombaController as PublicPendaftaranLombaController;
use App\Http\Controllers\Public\PendaftaranSayaController;
use App\Http\Controllers\Public\PendaftaranWorkshopController as PublicPendaftaranWorkshopController;
use App\Http\Controllers\Public\WorkshopController as PublicWorkshopController;
use Illuminate\Support\Facades\Route;

// ROUTE PUBLIC START
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/lomba/{lomba}', [PublicLombaController::class, 'show'])
    ->name('public.lomba.show');

Route::get('/event/{event}',[PublicEventController::class, 'show'])
    ->name('public.event.show');

Route::middleware('auth')->group(function () {

    Route::get(
        '/lomba/{lomba}/daftar',
        [PublicPendaftaranLombaController::class, 'create']
    )->name('public.lomba.daftar');

    Route::post(
        '/lomba/{lomba}/daftar',
        [PublicPendaftaranLombaController::class, 'store']
    )->name('public.lomba.daftar.store');

    Route::get('/workshop', [PublicWorkshopController::class, 'index'])
        ->name('public.workshop.index');

    Route::get('/workshop/{workshop}', [PublicWorkshopController::class, 'show'])
        ->name('public.workshop.show');

    Route::get(
        '/workshop/{workshop}/daftar',
        [PublicPendaftaranWorkshopController::class, 'create']
    )->name('public.workshop.daftar');

    Route::post(
        '/workshop/{workshop}/daftar',
        [PublicPendaftaranWorkshopController::class, 'store']
    )->name('public.workshop.daftar.store');

    Route::get(
        '/pendaftaran-saya',
        [PendaftaranSayaController::class, 'index']
    )->name('public.pendaftaran-saya.index');
});

// ROUTE PUBLIC END

// Route Admin Start

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('master-field', MasterFieldController::class);
    Route::resource('event', EventController::class);
    Route::resource('lomba', LombaController::class);
    Route::resource('faq', FaqController::class);
    Route::resource('workshop', WorkshopController::class);

    Route::get(
        '/pendaftaran-lomba',
        [PendaftaranLombaController::class, 'index']
    )->name('pendaftaran-lomba.index');

    Route::get(
        '/pendaftaran-lomba/{pendaftaranLomba}',
        [PendaftaranLombaController::class, 'show']
    )->name('pendaftaran-lomba.show');

    Route::patch(
        '/pendaftaran-lomba/{pendaftaranLomba}/status',
        [PendaftaranLombaController::class, 'update']
    )->name('pendaftaran-lomba.status');

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

    Route::get(
        '/pendaftaran-workshop',
        [PendaftaranWorkshopController::class, 'index']
    )->name('pendaftaran-workshop.index');

    Route::get(
        '/pendaftaran-workshop/{pendaftaranWorkshop}',
        [PendaftaranWorkshopController::class, 'show']
    )->name('pendaftaran-workshop.show');

    Route::patch(
        '/pendaftaran-workshop/{pendaftaranWorkshop}/status',
        [PendaftaranWorkshopController::class, 'update']
    )->name('pendaftaran-workshop.status');

});

// Route Admin End

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
