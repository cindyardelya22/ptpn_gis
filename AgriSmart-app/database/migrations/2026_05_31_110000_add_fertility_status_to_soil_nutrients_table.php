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
            $table->string('fertility_status')->nullable()->after('measured_at')
                  ->comment('Status kesuburan dari ML: Subur, Kurang Subur, Tidak Subur');
            $table->string('fertility_color')->nullable()->after('fertility_status')
                  ->comment('Warna badge: emerald, amber, rose');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('soil_nutrients', function (Blueprint $table) {
            $table->dropColumn(['fertility_status', 'fertility_color']);
        });
    }
};
