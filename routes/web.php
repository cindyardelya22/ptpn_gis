<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\Auth\Login;
use App\Livewire\Users;

Route::get('/login', Login::class)->name('login');
Route::get('/users', Users::class)->name('user');

Route::get('/', Dashboard::class)->name('dashboard');

Route::get('/tes', function () {
    return view('welcome');
});
