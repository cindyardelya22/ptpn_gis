<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;

Route::get('/', Dashboard::class)->name('dashboard');

Route::get('/tes', function () {
    return view('welcome');
});
