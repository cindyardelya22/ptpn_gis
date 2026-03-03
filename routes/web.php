<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\Auth\Login;

Route::get('/login', Login::class)->name('login');

Route::get('/', Dashboard::class)->name('dashboard');

Route::get('/tes', function () {
    return view('welcome');
});
