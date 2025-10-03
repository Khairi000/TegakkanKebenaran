<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AspirasiController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\CommentController;



Route::get('/', function () {
    return view('welcome');


    Route::middleware(['auth'])->group(function () {
    Route::get('/aspirasi', [AspirasiController::class, 'index'])->name('aspirasi.index');
    Route::get('/aspirasi/create', [AspirasiController::class, 'create'])->name('aspirasi.create');
    Route::post('/aspirasi', [AspirasiController::class, 'store'])->name('aspirasi.store');
    Route::get('/aspirasi/{aspirasi}', [AspirasiController::class, 'show'])->name('aspirasi.show');
});




    Route::middleware(['auth'])->group(function () {
    Route::resource('aspirasi', AspirasiController::class);

    // update status khusus admin
    Route::post('/aspirasi/{aspirasi}/status', [AspirasiController::class, 'updateStatus'])
        ->name('aspirasi.updateStatus');
});




    Route::middleware(['auth'])->group(function () {
    Route::post('/aspirasi/{aspirasi}/vote', [VoteController::class, 'store'])->name('aspirasi.vote');
});



    Route::middleware(['auth'])->group(function () {
    Route::post('/aspirasi/{aspirasi}/comment', [CommentController::class, 'store'])->name('aspirasi.comment');
});

});
