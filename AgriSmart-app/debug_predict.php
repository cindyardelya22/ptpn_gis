<?php

// Debug: send actual DB data to Flask and show prediction results
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Http;

$flaskUrl = config('services.ml.url', 'http://127.0.0.1:5000');

echo "=== TESTING FLASK CONNECTION ===\n\n";
echo "Flask URL: {$flaskUrl}\n\n";

// Test 1: Check model info
echo "--- TEST 1: Model Info ---\n";
try {
    $resp = Http::timeout(5)->get("{$flaskUrl}/model-info");
    if ($resp->successful()) {
        $info = $resp->json();
        echo "Model type: " . ($info['model_type'] ?? 'unknown') . "\n";
        echo "Features: " . json_encode($info['feature_columns'] ?? []) . "\n";
        echo "Model feature names: " . json_encode($info['model_feature_names'] ?? 'N/A') . "\n";
        echo "N features: " . ($info['n_features'] ?? 'unknown') . "\n";
        echo "Classes: " . json_encode($info['classes'] ?? []) . "\n";
        echo "Label map: " . json_encode($info['label_map'] ?? []) . "\n";
    } else {
        echo "ERROR: HTTP {$resp->status()}\n";
    }
} catch (\Throwable $e) {
    echo "ERROR: {$e->getMessage()}\n";
    echo "Is Flask running? Start with: cd Flask-ml && python app.py\n";
    exit(1);
}

// Test 2: Flask /test endpoint (hardcoded sample)
echo "\n--- TEST 2: Flask /test endpoint ---\n";
try {
    $resp = Http::timeout(5)->get("{$flaskUrl}/test");
    $result = $resp->json();
    echo "Test input: " . json_encode($result['test_input'] ?? []) . "\n";
    echo "Prediksi: " . ($result['prediksi'] ?? 'N/A') . "\n";
    echo "Kategori: " . ($result['kategori'] ?? 'N/A') . "\n";
} catch (\Throwable $e) {
    echo "ERROR: {$e->getMessage()}\n";
}

// Test 3: Send each block's data directly to /predict
echo "\n--- TEST 3: Predict each block ---\n";
$nutrients = App\Models\SoilNutrient::with('block')->get();

foreach ($nutrients as $n) {
    $blockName = $n->block ? $n->block->name : 'Block ' . $n->block_id;

    $payload = [
        'N'  => (float) ($n->nitrogen ?? 0),
        'P'  => (float) ($n->phosphorus ?? 0),
        'K'  => (float) ($n->potassium ?? 0),
        'pH' => (float) ($n->ph ?? 0),
        'EC' => (float) ($n->ec ?? 0),
        'OC' => (float) ($n->organic_carbon ?? 0),
        'S'  => (float) ($n->s ?? 0),
        'Mg' => (float) ($n->magnesium ?? 0),
        'B'  => (float) ($n->boron ?? 0),
    ];

    echo "\n{$blockName}:\n";
    echo "  Payload: " . json_encode($payload) . "\n";

    try {
        $resp = Http::timeout(5)->post("{$flaskUrl}/predict", $payload);
        $result = $resp->json();

        if ($result['success'] ?? false) {
            echo "  Prediksi: {$result['prediksi']} → {$result['kategori']}\n";
            if (isset($result['probabilities'])) {
                echo "  Probabilities: " . json_encode($result['probabilities']) . "\n";
            }
        } else {
            echo "  ERROR: " . ($result['error'] ?? 'unknown') . "\n";
            if (isset($result['details'])) {
                echo "  Details: " . json_encode($result['details']) . "\n";
            }
        }
    } catch (\Throwable $e) {
        echo "  ERROR: {$e->getMessage()}\n";
    }
}

echo "\n\n=== DONE ===\n";
echo "Check Flask terminal and flask_ml_debug.log for detailed logs.\n";
