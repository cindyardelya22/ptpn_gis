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
        Schema::create('soil_nutrients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('block_id')->constrained()->onDelete('cascade');
            $table->decimal('nitrogen', 8, 3)->comment('Nitrogen (%)');
            $table->decimal('phosphorus', 8, 3)->comment('P2O5 (ppm)');
            $table->decimal('potassium', 8, 3)->comment('K2O (cmol/kg)');
            $table->decimal('ph', 5, 2)->comment('Soil pH');
            $table->decimal('magnesium', 8, 3)->comment('MgO (cmol/kg)');
            $table->decimal('organic_carbon', 8, 3)->comment('C-Organic (%)');
            $table->date('measured_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soil_nutrients');
    }
};
