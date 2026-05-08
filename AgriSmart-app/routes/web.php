<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Analytics;
use App\Livewire\Dashboard;
use App\Livewire\Auth\Login;
use App\Livewire\Users;
use App\Livewire\NutrientsData;
use App\Livewire\BlockMap;
use App\Livewire\Reports;
use App\Livewire\BlockDetail;

Route::get('/login', Login::class)->name('login');
Route::get('/users', Users::class)->name('user');

Route::get('/', Dashboard::class)->name('dashboard');
Route::get('/unsur-hara', NutrientsData::class)->name('unsur-hara');
Route::get('/peta-blok', BlockMap::class)->name('peta-blok');
Route::get('/prediksi-panen', Analytics::class)->name('analytics');
Route::get('/laporan', Reports::class)->name('reports');
Route::get('/blok/{id}', BlockDetail::class)->name('block.detail');

Route::get('/tes', function () {
    return view('welcome');
});
