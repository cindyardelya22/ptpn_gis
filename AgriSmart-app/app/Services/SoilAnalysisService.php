<?php

namespace App\Services;

use App\Models\SoilNutrient;

class SoilAnalysisService
{
    /**
     * Calculate fertility status based on nutrient levels.
     * 
     * Scoring Rules (Simplified for Palm Oil):
     * 1. Nitrogen (N) %: >0.15 (3 pts), 0.12-0.15 (2 pts), <0.12 (1 pt)
     * 2. Phosphorus (P) ppm: >20 (3 pts), 15-20 (2 pts), <15 (1 pt)
     * 3. Potassium (K) cmol/kg: >0.20 (3 pts), 0.15-0.20 (2 pts), <0.15 (1 pt)
     * 4. pH: 5.0 - 6.5 (3 pts), 4.5 - 5.0 or 6.5 - 7.0 (2 pts), else (1 pt)
     * 5. Magnesium (Mg) cmol/kg: >0.25 (3 pts), 0.15-0.25 (2 pts), <0.15 (1 pt)
     * 6. C-Organic %: >2.0 (3 pts), 1.2-2.0 (2 pts), <1.2 (1 pt)
     * 
     * Total Max Score: 18
     */
    public function analyzeFertility(SoilNutrient $nutrient): array
    {
        $scores = [
            'nitrogen' => $this->scoreN($nutrient->nitrogen),
            'phosphorus' => $this->scoreP($nutrient->phosphorus),
            'potassium' => $this->scoreK($nutrient->potassium),
            'ph' => $this->scorePH($nutrient->ph),
            'magnesium' => $this->scoreMg($nutrient->magnesium),
            'organic_carbon' => $this->scoreCOrg($nutrient->organic_carbon),
        ];

        $totalScore = array_sum($scores);
        
        $status = 'Kurang Subur';
        $color = 'rose';

        if ($totalScore >= 16) {
            $status = 'Subur';
            $color = 'emerald';
        } elseif ($totalScore >= 12) {
            $status = 'Cukup Subur';
            $color = 'amber';
        }

        return [
            'total_score' => $totalScore,
            'status' => $status,
            'color' => $color,
            'scores' => $scores
        ];
    }

    private function scoreN($val): int {
        if ($val > 0.15) return 3;
        if ($val >= 0.12) return 2;
        return 1;
    }

    private function scoreP($val): int {
        if ($val > 20) return 3;
        if ($val >= 15) return 2;
        return 1;
    }

    private function scoreK($val): int {
        if ($val > 0.20) return 3;
        if ($val >= 0.15) return 2;
        return 1;
    }

    private function scorePH($val): int {
        if ($val >= 5.0 && $val <= 6.5) return 3;
        if (($val >= 4.5 && $val < 5.0) || ($val > 6.5 && $val <= 7.0)) return 2;
        return 1;
    }

    private function scoreMg($val): int {
        if ($val > 0.25) return 3;
        if ($val >= 0.15) return 2;
        return 1;
    }

    private function scoreCOrg($val): int {
        if ($val > 2.0) return 3;
        if ($val >= 1.2) return 2;
        return 1;
    }
}
