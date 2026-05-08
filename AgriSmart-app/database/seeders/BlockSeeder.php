<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Block;
use App\Models\SoilNutrient;

class BlockSeeder extends Seeder
{
    public function run(): void
    {
        $blocks = [
            [
                'name' => 'Blok A01',
                'area_ha' => 25.5,
                'planted_at' => '2015-05-20', // ~11 years (Prime)
                'coords' => [[101.60, 0.40], [101.65, 0.42], [101.68, 0.38], [101.62, 0.36], [101.60, 0.40]],
                'nutrients' => [
                    'nitrogen' => 0.18,
                    'phosphorus' => 22.5,
                    'potassium' => 0.28,
                    'ph' => 5.8,
                    'magnesium' => 0.35,
                    'organic_carbon' => 2.4,
                ]
            ],
            [
                'name' => 'Blok B04',
                'area_ha' => 18.2,
                'planted_at' => '2023-01-15', // ~3 years (Immature/Young)
                'coords' => [[101.70, 0.35], [101.75, 0.37], [101.78, 0.34], [101.73, 0.32], [101.70, 0.35]],
                'nutrients' => [
                    'nitrogen' => 0.11,
                    'phosphorus' => 12.0,
                    'potassium' => 0.12,
                    'ph' => 4.2,
                    'magnesium' => 0.12,
                    'organic_carbon' => 1.1,
                ]
            ],
            [
                'name' => 'Blok C12',
                'area_ha' => 30.1,
                'planted_at' => '2005-11-10', // ~20 years (Old)
                'coords' => [[101.65, 0.30], [101.70, 0.33], [101.72, 0.31], [101.68, 0.28], [101.65, 0.30]],
                'nutrients' => [
                    'nitrogen' => 0.14,
                    'phosphorus' => 18.5,
                    'potassium' => 0.19,
                    'ph' => 5.1,
                    'magnesium' => 0.22,
                    'organic_carbon' => 1.8,
                ]
            ],
        ];

        foreach ($blocks as $b) {
            $block = Block::create([
                'name' => $b['name'],
                'area_ha' => $b['area_ha'],
                'planted_at' => $b['planted_at'],
                'polygon_coords' => $b['coords'],
            ]);

            $nutrientData = $b['nutrients'];
            $nutrientData['measured_at'] = now();
            $block->nutrients()->create($nutrientData);
        }
    }
}
