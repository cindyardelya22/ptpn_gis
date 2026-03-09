<?php

namespace App\Services;

use App\Models\Block;
use Carbon\Carbon;

class HarvestPredictionService
{
    /**
     * Calculate harvest prediction for a block.
     * 
     * Formula:
     * Yield = Area * BaseYieldPerHa(Age) * FertilityMultiplier
     */
    public function predict(Block $block, array $fertilityAnalysis): array
    {
        $age = $this->calculateAge($block->planted_at);
        $baseYield = $this->getBaseYieldByAge($age);
        $multiplier = $this->getFertilityMultiplier($fertilityAnalysis['status']);
        
        $annualYieldPerHa = $baseYield * $multiplier;
        $totalAnnualYield = $block->area_ha * $annualYieldPerHa;
        
        // Monthly trend (standard seasonal curve for Palm Oil)
        // High peak in Oct-Dec, Low in Jan-Mar
        $monthlyDistribution = [
            0.06, 0.05, 0.06, 0.07, 0.08, 0.09, 
            0.09, 0.10, 0.11, 0.11, 0.10, 0.08
        ];

        $monthlyPredictions = [];
        $currentMonth = Carbon::now()->month;
        
        for ($i = 0; $i < 12; $i++) {
            $monthIndex = ($currentMonth - 1 + $i) % 12;
            $monthName = Carbon::now()->addMonths($i)->format('M');
            $monthlyPredictions[] = [
                'month' => $monthName,
                'yield' => round($totalAnnualYield * $monthlyDistribution[$monthIndex] / 1, 2)
            ];
        }

        return [
            'age_years' => $age,
            'ton_per_ha' => round($annualYieldPerHa, 2),
            'total_annual_ton' => round($totalAnnualYield, 2),
            'monthly_trend' => $monthlyPredictions,
            'status_label' => $this->getAgeLabel($age)
        ];
    }

    private function calculateAge($plantedAt): int
    {
        if (!$plantedAt) return 10; // Default to prime mature if unknown
        return Carbon::parse($plantedAt)->diffInYears(Carbon::now());
    }

    private function getBaseYieldByAge(int $age): float
    {
        if ($age < 3) return 0.0;
        if ($age <= 7) return 15.0 + ($age - 3) * 2; // Linear increase
        if ($age <= 18) return 26.0; // Peak productivity
        return max(15.0, 26.0 - ($age - 18) * 0.8); // Gradual decline
    }

    private function getFertilityMultiplier(string $status): float
    {
        return match ($status) {
            'Subur' => 1.2,
            'Cukup Subur' => 1.0,
            'Kurang Subur' => 0.7,
            default => 1.0,
        };
    }

    private function getAgeLabel(int $age): string
    {
        if ($age < 3) return 'TBM (Belum Menghasilkan)';
        if ($age <= 7) return 'TM Muda';
        if ($age <= 18) return 'TM Prima';
        return 'TM Tua';
    }
}
