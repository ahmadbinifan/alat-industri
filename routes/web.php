<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::middleware('auth')->group(
    function () {
        Route::get('/', \App\Livewire\Home::class)->name('home');
        Route::get('/equipment', \App\Livewire\equipment\Equipment::class)->name('equipment');
        Route::get('/certificateRegulation', \App\Livewire\CertificateRegulation\Index::class)->name('certificateRegulation');
        Route::get('/equipment/exportpdf/{id}', [\App\Livewire\equipment\Equipment::class, 'exportpdf'])->name('equipment.exportpdf');
    }
);

Route::get('/login', \App\Livewire\auth\login::class)->name('login');
// Route::post('logout', \App\Http\Controllers\LogoutController::class)->name('logout');
Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');
