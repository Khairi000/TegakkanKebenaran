<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AspirasiController;
use App\Http\Controllers\KomentarController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// dashboard hanya untuk user login
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// route profile (hanya user login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// route aspirasi (hanya user login)
Route::middleware(['auth'])->group(function () {
    // daftar aspirasi
    Route::get('/aspirasi', [AspirasiController::class, 'index'])->name('aspirasi.index');

    // buat aspirasi baru
    Route::get('/aspirasi/create', [AspirasiController::class, 'create'])->name('aspirasi.create');
    Route::post('/aspirasi', [AspirasiController::class, 'store'])->name('aspirasi.store');

    // detail aspirasi
    Route::get('/aspirasi/{aspirasi}', [AspirasiController::class, 'show'])->name('aspirasi.show');

    // voting (user)
    Route::post('/aspirasi/{aspirasi}/vote', [AspirasiController::class, 'vote'])->name('aspirasi.vote');

    // update status (admin)
    Route::put('/aspirasi/{aspirasi}/status', [AspirasiController::class, 'updateStatus'])->name('aspirasi.updateStatus');

    // komentar (user login)
    Route::post('/aspirasi/{aspirasi}/komentar', [KomentarController::class, 'store'])->name('komentar.store');
});

require __DIR__.'/auth.php';
