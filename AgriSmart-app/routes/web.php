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
use App\Http\Controllers\MLDebugController;

Route::get('/login', Login::class)->name('login');
Route::get('/users', Users::class)->name('user');

Route::get('/', Dashboard::class)->name('dashboard');
Route::get('/unsur-hara', NutrientsData::class)->name('unsur-hara');
Route::get('/peta-blok', BlockMap::class)->name('peta-blok');
Route::get('/prediksi-panen', Analytics::class)->name('analytics');
Route::get('/laporan', Reports::class)->name('reports');
Route::get('/blok/{id}', BlockDetail::class)->name('block.detail');
Route::patch('/nutrients/{nutrient}/recommendation-progress', function (
    \Illuminate\Http\Request $request,
    \App\Models\SoilNutrient $nutrient
) {
    $nutrient->update([
        'recommendation_progress' => $request->input('progress', []),
    ]);
    return response()->json(['ok' => true]);
})->middleware('auth');
Route::get('/tes', function () {
    return view('welcome');
});

// ─── ML Debug Routes (only available in debug mode) ─────────────────
if (config('app.debug')) {
    Route::prefix('ml-debug')->group(function () {
        Route::get('/test',              [MLDebugController::class, 'testConnection'])->name('ml.test');
        Route::get('/model-info',        [MLDebugController::class, 'modelInfo'])->name('ml.model-info');
        Route::get('/predict-sample',    [MLDebugController::class, 'predictSample'])->name('ml.predict-sample');
        Route::get('/compare/{blockId}', [MLDebugController::class, 'compareBlock'])->name('ml.compare');
        Route::get('/compare-all',       [MLDebugController::class, 'compareAll'])->name('ml.compare-all');
    });
}
