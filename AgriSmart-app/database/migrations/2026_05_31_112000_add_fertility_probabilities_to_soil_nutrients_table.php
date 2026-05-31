<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('soil_nutrients', function (Blueprint $table) {
            $table->json('fertility_probabilities')->nullable()->after('fertility_color')
                  ->comment('Probabilitas dari ML: {"Subur": 0.85, "Kurang Subur": 0.10, ...}');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('soil_nutrients', function (Blueprint $table) {
            $table->dropColumn('fertility_probabilities');
        });
    }
};
