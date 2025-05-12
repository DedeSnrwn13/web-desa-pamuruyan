<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;

Route::name('front.')->group(function () {
    Route::get('/', [FrontController::class, 'index'])->name('index');

    // APBDEs & Inventaris
    Route::get('/apbdes', [FrontController::class, 'apbdes'])->name('apbdes');
    Route::get('/inventaris', [FrontController::class, 'inventaris'])->name('inventaris');

    // Detail & Kategori
    Route::prefix('berita')->name('berita.')->group(function () {
        Route::get('/', [FrontController::class, 'beritaIndex'])->name('index');
        Route::get('/detail/{berita:slug}', [FrontController::class, 'beritaDetail'])->name('detail');
        Route::get('kategori/{kategori_berita:slug}', [FrontController::class, 'category'])->name('kategori');
        Route::get('/cari', [FrontController::class, 'search'])->name('cari');
    });

    // Kepengurusan
    Route::get('/kepengurusan', [FrontController::class, 'kepengurusan'])->name('kepengurusan');

    // Jadwal
    Route::get('/jadwal-kegiatan', [FrontController::class, 'jadwalKegiatan'])->name('jadwal-kegiatan');

    // Layanan Surat
    Route::get('/layanan-surat', [FrontController::class, 'layananSurat'])->name('layanan-surat');

    // Visi Misi
    Route::get('/visi-misi', [FrontController::class, 'visiMisi'])->name('visi-misi');

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