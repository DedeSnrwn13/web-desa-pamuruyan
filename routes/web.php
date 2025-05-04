<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;

Route::name('front.')->group(function () {
    Route::get('/', [FrontController::class, 'index'])->name('index');

    // APBDEs & Inventaris
    Route::get('/apbdes', [FrontController::class, 'apbdes'])->name('apbdes');
    Route::get('/inventaris', [FrontController::class, 'inventaris'])->name('inventaris');
    Route::get('/jadwal', [FrontController::class, 'jadwal'])->name('jadwal');

    // Detail & Kategori
    Route::get('/detail/{beritas:slug}', [FrontController::class, 'detail'])->name('berita.detail');
    Route::get('kategori/{kategori_berita:slug}', [FrontController::class, 'category'])->name('kategori');
    Route::get('/search', [FrontController::class, 'search'])->name('search');
});

// Login & Register
Route::get('/login', function () {
    return redirect('/warga/login');
})->name('login');
Route::get('/register', function () {
    return redirect()->route('filament.warga.auth.register');
})->name('register');