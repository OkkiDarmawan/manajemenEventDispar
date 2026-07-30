<?php

use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\LombaController;
use App\Http\Controllers\Admin\MasterFieldController;
use App\Http\Controllers\Admin\LombaFieldController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('welcome');
});

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
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
