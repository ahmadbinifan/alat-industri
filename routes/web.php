<?php

use Illuminate\Support\Facades\Route;


Route::get('/', \App\Livewire\Home::class)->name('home')->middleware('guest');
Route::get('/equipment', \App\Livewire\equipment\Equipment::class)->name('equipment')->middleware('guest');
Route::get('/certificateRegulation', \App\Livewire\CertificateRegulation\Index::class)->name('certificateRegulation')->middleware('guest');
