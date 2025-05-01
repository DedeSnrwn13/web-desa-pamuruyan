<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return redirect('/warga/login');
})->name('login');

Route::get('/register', function () {
    return redirect()->route('filament.warga.auth.register');
})->name('register');