<?php

// Quick debug script to check DB data and test prediction
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== ALL SOIL NUTRIENT DATA IN DATABASE ===\n\n";

$nutrients = App\Models\SoilNutrient::with('block')->get();

if ($nutrients->isEmpty()) {
    echo "No nutrient data found in database.\n";
    exit;
}

foreach ($nutrients as $n) {
    $blockName = $n->block ? $n->block->name : 'Unknown';
    echo "Block: {$blockName} (block_id={$n->block_id})\n";
    echo "  N (nitrogen)       = {$n->nitrogen} (DB unit: %)\n";
    echo "  P (phosphorus)     = {$n->phosphorus} (DB unit: ppm)\n";
    echo "  K (potassium)      = {$n->potassium} (DB unit: cmol/kg)\n";
    echo "  pH                 = {$n->ph}\n";
    echo "  EC                 = {$n->ec}\n";
    echo "  OC (organic_carbon)= {$n->organic_carbon} (DB unit: %)\n";
    echo "  S                  = {$n->s}\n";
    echo "  Mg (magnesium)     = {$n->magnesium} (DB unit: cmol/kg)\n";
    echo "  B (boron)          = {$n->boron}\n";
    echo "  measured_at        = {$n->measured_at}\n";
    echo "\n";

    // Show what would be sent with OLD conversions
    echo "  >> Old payload (with conversions):\n";
    echo "     N  = " . ($n->nitrogen * 1000) . " (×1000)\n";
    echo "     P  = " . ($n->phosphorus) . "\n";
    echo "     K  = " . ($n->potassium * 390) . " (×390)\n";
    echo "     pH = " . ($n->ph) . "\n";
    echo "     EC = " . ($n->ec) . "\n";
    echo "     OC = " . ($n->organic_carbon) . "\n";
    echo "     S  = " . ($n->s) . "\n";
    echo "     Mg = " . ($n->magnesium * 12.15) . " (×12.15)\n";
    echo "     B  = " . ($n->boron) . "\n";

    echo "\n  >> New payload (NO conversions, factor=1):\n";
    echo "     N  = " . ($n->nitrogen) . "\n";
    echo "     P  = " . ($n->phosphorus) . "\n";
    echo "     K  = " . ($n->potassium) . "\n";
    echo "     pH = " . ($n->ph) . "\n";
    echo "     EC = " . ($n->ec) . "\n";
    echo "     OC = " . ($n->organic_carbon) . "\n";
    echo "     S  = " . ($n->s) . "\n";
    echo "     Mg = " . ($n->magnesium) . "\n";
    echo "     B  = " . ($n->boron) . "\n";
    echo "\n" . str_repeat('-', 50) . "\n\n";
}

echo "=== FLASK /test ENDPOINT REFERENCE VALUES ===\n";
echo "  N=138, P=8.6, K=560, pH=7.46, EC=0.62, OC=0.7, S=5.9, Mg=1.83, B=0.11\n\n";
echo "Compare the 'Old payload' values with these reference values.\n";
echo "If old payload values are in similar ranges, conversions are needed.\n";
echo "If raw DB values are in similar ranges, no conversions are needed.\n";
