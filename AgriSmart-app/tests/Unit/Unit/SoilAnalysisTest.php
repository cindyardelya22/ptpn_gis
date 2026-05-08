<?php

namespace Tests\Unit\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\SoilAnalysisService;
use App\Models\SoilNutrient;

class SoilAnalysisTest extends TestCase
{
    public function test_analyze_fertile_soil()
    {
        $service = new SoilAnalysisService();
        $nutrient = new SoilNutrient([
            'nitrogen' => 0.18,
            'phosphorus' => 25,
            'potassium' => 0.25,
            'ph' => 5.5,
            'magnesium' => 0.30,
            'organic_carbon' => 2.5,
        ]);

        $result = $service->analyzeFertility($nutrient);

        $this->assertEquals('Subur', $result['status']);
        $this->assertEquals(18, $result['total_score']);
    }

    public function test_analyze_low_fertility_soil()
    {
        $service = new SoilAnalysisService();
        $nutrient = new SoilNutrient([
            'nitrogen' => 0.10,
            'phosphorus' => 10,
            'potassium' => 0.10,
            'ph' => 4.0,
            'magnesium' => 0.10,
            'organic_carbon' => 0.8,
        ]);

        $result = $service->analyzeFertility($nutrient);

        $this->assertEquals('Kurang Subur', $result['status']);
        $this->assertEquals(6, $result['total_score']);
    }

    public function test_analyze_moderate_fertility_soil()
    {
        $service = new SoilAnalysisService();
        $nutrient = new SoilNutrient([
            'nitrogen' => 0.13,
            'phosphorus' => 17,
            'potassium' => 0.18,
            'ph' => 5.2,
            'magnesium' => 0.20,
            'organic_carbon' => 1.5,
        ]);

        $result = $service->analyzeFertility($nutrient);

        $this->assertEquals('Cukup Subur', $result['status']);
        $this->assertEquals(13, $result['total_score']);
    }
}
