<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AgriSmartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // 1. Seed Blocks
        DB::table('blocks')->insert([
            [
                'id' => 1,
                'name' => 'Blok A01',
                'area_ha' => 25.50,
                'planted_at' => '2015-05-20',
                'polygon_coords' => '[[101.6, 0.4], [101.65, 0.42], [101.68, 0.38], [101.62, 0.36]]',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'name' => 'Blok B04',
                'area_ha' => 18.20,
                'planted_at' => '2023-01-15',
                'polygon_coords' => '[[101.7, 0.35], [101.75, 0.37], [101.78, 0.34], [101.73, 0.32]]',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'name' => 'Blok C12',
                'area_ha' => 30.10,
                'planted_at' => '2005-11-10',
                'polygon_coords' => '[[101.65, 0.3], [101.7, 0.33], [101.72, 0.31], [101.68, 0.28]]',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ]);

        // 2. Seed Settings (Role Permissions)
        DB::table('settings')->insert([
            [
                'id' => 1,
                'key' => 'role_permissions',
                'value' => '{"admin":{"dashboard":["view"],"data-unsur-hara":["view","create","edit","delete"],"peta-blok":[],"peta-analisis":["rekomendasi"],"laporan":["download_pdf","download_excel","view","rekomendasi_pemupukan","rekap_kesuburan"],"settings":[],"analisis-kesuburan":["view"],"detail-blok":["rekomendasi"]},"viewer":{"dashboard":[],"data-unsur-hara":["view"],"peta-blok":["view"],"peta-analisis":["view"],"laporan":["view"],"settings":[]}}',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ]);

        // 3. Seed Soil Nutrients
        DB::table('soil_nutrients')->insert([
            [
                'id' => 1,
                'block_id' => 1,
                'nitrogen' => 180.000,
                'phosphorus' => 22.500,
                'potassium' => 23.000,
                'ph' => 5.80,
                'magnesium' => 0.350,
                'organic_carbon' => 2.400,
                'ec' => 32.00,
                's' => 23.000,
                'boron' => 23.000,
                'measured_at' => '2026-06-01',
                'fertility_status' => 'Subur',
                'fertility_color' => 'emerald',
                'fertility_probabilities' => '{"Subur": 0.4, "Tidak Subur": 0.34, "Kurang Subur": 0.26}',
                'recommendation_progress' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'block_id' => 2,
                'nitrogen' => 14.000,
                'phosphorus' => 12.000,
                'potassium' => 14.000,
                'ph' => 4.20,
                'magnesium' => 0.120,
                'organic_carbon' => 1.100,
                'ec' => 14.00,
                's' => 4.000,
                'boron' => 4.000,
                'measured_at' => '2026-06-01',
                'fertility_status' => 'Tidak Subur',
                'fertility_color' => 'rose',
                'fertility_probabilities' => '{"Subur": 0.21, "Tidak Subur": 0.51, "Kurang Subur": 0.28}',
                'recommendation_progress' => '[0, 1, 2, 3, 4, 5, 6, 7, 8, 9]',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'block_id' => 3,
                'nitrogen' => 522.000,
                'phosphorus' => 18.500,
                'potassium' => 225.000,
                'ph' => 5.10,
                'magnesium' => 0.220,
                'organic_carbon' => 1.800,
                'ec' => 25.00,
                's' => 25.000,
                'boron' => 25.000,
                'measured_at' => '2026-06-01',
                'fertility_status' => 'Kurang Subur',
                'fertility_color' => 'amber',
                'fertility_probabilities' => '{"Subur": 0.29, "Tidak Subur": 0.02, "Kurang Subur": 0.69}',
                'recommendation_progress' => '[1]',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ]);

        // 4. Seed Users
        DB::table('users')->insert([
            [
                'id' => 1,
                'username' => 'Udin',
                'sap' => '12345',
                'password' => '$2y$12$tJ6iDVNas0QpM3nBNWtzpOUTXyUlmwJIE7HB33e/yuCTzAjFXCRm6',
                'role' => 'superadmin',
                'is_active' => 1,
                'failed_login_attempts' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'username' => 'Siregar',
                'sap' => '123456',
                'password' => '$2y$12$CpSC9x3PKiwp9g6LUfe2zee4yXFKdWvaCu8R5Dqud0z.BUBY2MXc2',
                'role' => 'admin',
                'is_active' => 1,
                'failed_login_attempts' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ]);
    }
}
