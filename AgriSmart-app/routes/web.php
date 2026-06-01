<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Livewire\Auth\Login;
use App\Livewire\Dashboard;
use App\Livewire\Analytics;
use App\Livewire\NutrientsData;
use App\Livewire\BlockMap;
use App\Livewire\BlockDetail;
use App\Livewire\Reports;
use App\Livewire\Setting;
use App\Livewire\Profile;
use App\Http\Controllers\MLDebugController;
use App\Models\SoilNutrient;

// ─── Guest Only ──────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
});

// ─── Auth Required ───────────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/', Dashboard::class)->name('dashboard');

    // Main Features
    Route::get('/unsur-hara',    NutrientsData::class)->name('unsur-hara');
    Route::get('/peta-blok',     BlockMap::class)->name('peta-blok');
    Route::get('/analisis-kesuburan', Analytics::class)->name('analytics');
    Route::get('/laporan',       Reports::class)->name('reports');
    Route::get('/blok/{id}',     BlockDetail::class)->name('block.detail');

    // User
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/setting', Setting::class)->name('setting');

    // Nutrient Recommendation Progress
    Route::patch('/nutrients/{nutrient}/recommendation-progress', function (
        Request $request,
        SoilNutrient $nutrient
    ) {
        $nutrient->update([
            'recommendation_progress' => $request->input('progress', []),
        ]);
        return response()->json(['ok' => true]);
    })->name('nutrients.recommendation-progress');

    // Logout
    Route::post('/logout', function (Request $request) {
        Auth::user()
            ->devices()
            ->where('is_current', true)
            ->update(['is_current' => false]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    })->name('logout');

});

// ─── ML Debug (hanya saat APP_DEBUG=true) ────────────────────────────
if (config('app.debug')) {
    Route::prefix('ml-debug')->name('ml.')->group(function () {
        Route::get('/test',              [MLDebugController::class, 'testConnection'])->name('test');
        Route::get('/model-info',        [MLDebugController::class, 'modelInfo'])->name('model-info');
        Route::get('/predict-sample',    [MLDebugController::class, 'predictSample'])->name('predict-sample');
        Route::get('/compare/{blockId}', [MLDebugController::class, 'compareBlock'])->name('compare');
        Route::get('/compare-all',       [MLDebugController::class, 'compareAll'])->name('compare-all');
    });
}