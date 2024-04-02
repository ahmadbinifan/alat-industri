<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::middleware('auth')->group(
    function () {
        Route::get('/', \App\Livewire\Home::class)->name('home');
        Route::get('/equipment', \App\Livewire\equipment\Equipment::class)->name('equipment');
        Route::get('/certificateRegulation', \App\Livewire\CertificateRegulation\Index::class)->name('certificateRegulation');
    }
);

Route::get('/login', \App\Livewire\auth\login::class)->name('login');
// Route::post('logout', \App\Http\Controllers\LogoutController::class)->name('logout');
Route::post('/logout', function () {
    Auth::logout(); // Logout pengguna
    return redirect()->route('login'); // Redirect pengguna ke halaman login setelah logout
})->name('logout');
