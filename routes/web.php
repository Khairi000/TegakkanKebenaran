<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AspirasiController;
use App\Http\Controllers\KomentarController;
use App\Http\Controllers\DiskusiController;
use App\Http\Controllers\DashboardController;

// 🏠 Halaman utama
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// 📊 Dashboard hanya untuk user login & terverifikasi
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 👤 Profil user (hanya untuk user login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 🗳️ ASPIRASI (semua aktivitas user terhadap aspirasi)
Route::middleware(['auth'])->group(function () {

    // daftar aspirasi
    Route::get('/aspirasi', [AspirasiController::class, 'index'])->name('aspirasi.index');

    // buat aspirasi baru
    Route::get('/aspirasi/create', [AspirasiController::class, 'create'])->name('aspirasi.create');
    Route::post('/aspirasi', [AspirasiController::class, 'store'])->name('aspirasi.store');

    // detail aspirasi
    Route::get('/aspirasi/{aspirasi}', [AspirasiController::class, 'show'])->name('aspirasi.show');

    // voting aspirasi (user)
    Route::post('/aspirasi/{aspirasi}/vote', [AspirasiController::class, 'vote'])->name('aspirasi.vote');

    // update status aspirasi (admin)
    Route::put('/aspirasi/{aspirasi}/status', [AspirasiController::class, 'updateStatus'])->name('aspirasi.updateStatus');

    // komentar di aspirasi
    Route::post('/aspirasi/{aspirasi}/komentar', [KomentarController::class, 'store'])->name('komentar.store');
});

// 💬 DISKUSI ASPIRASI (chat / diskusi realtime)
Route::middleware(['auth'])->group(function () {
    Route::get('/diskusi', [DiskusiController::class, 'index'])->name('diskusi.index'); // daftar aspirasi untuk diskusi
    Route::get('/diskusi/{aspirasi}', [DiskusiController::class, 'show'])->name('diskusi.show'); // tampilkan diskusi per aspirasi
    Route::post('/diskusi/{aspirasi}', [DiskusiController::class, 'storeDiskusi'])->name('diskusi.store');

});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

require __DIR__ . '/auth.php';
