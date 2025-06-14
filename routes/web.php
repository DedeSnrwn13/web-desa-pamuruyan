<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;

Route::name('front.')->group(function () {
    Route::get('/', [FrontController::class, 'index'])->name('index');

    // APBDes
    Route::get('/apbdes', [FrontController::class, 'apbdes'])->name('apbdes');

    // Detail
    Route::prefix('berita')->name('berita.')->group(function () {
        Route::get('/', [FrontController::class, 'beritaIndex'])->name('index');
        Route::get('/detail/{berita:slug}', [FrontController::class, 'beritaDetail'])->name('detail');
        Route::get('/cari', [FrontController::class, 'search'])->name('cari');
    });

    // Jadwal
    Route::get('/jadwal-kegiatan', [FrontController::class, 'jadwalKegiatan'])->name('jadwal-kegiatan');

    // Layanan Surat
    Route::get('/layanan-surat', [FrontController::class, 'layananSurat'])->name('layanan-surat');

    // Galeri
    Route::get('/galeri', [FrontController::class, 'galeri'])->name('galeri');
});

// Login & Register
Route::get('/login', function () {
    return redirect('/warga/login');
})->name('login');
Route::get('/register', function () {
    return redirect()->route('filament.warga.auth.register');
})->name('register');