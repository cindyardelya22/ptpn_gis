<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Block;
use App\Services\SoilAnalysisService;
use App\Services\HarvestPredictionService;
use Carbon\Carbon;

class Analytics extends Component
{
    public $selectedYear;
    public $selectedAgeRange = 'all';
    public $selectedFertility = 'all';

    public function mount()
    {
        $this->selectedYear = Carbon::now()->year;
    }

    public function render(SoilAnalysisService $analysisService, HarvestPredictionService $predictionService)
    {
        $allBlocks = Block::with(['nutrients' => function($q) {
            $q->latest('measured_at');
        }])->get()->map(function(Block $block) use ($analysisService, $predictionService) {
            $latest = $block->nutrients->first();
            $analysis = $latest ? $analysisService->analyzeFertility($latest) : null;
            $prediction = $analysis ? $predictionService->predict($block, $analysis) : null;
            
            return [
                'id' => $block->id,
                'name' => $block->name,
                'area_ha' => $block->area_ha,
                'status' => $analysis['status'] ?? 'N/A',
                'color' => $analysis['color'] ?? 'slate',
                'age' => $prediction['age_years'] ?? 0,
                'age_label' => $prediction['status_label'] ?? 'Unknown',
                'yield' => $prediction['total_annual_ton'] ?? 0,
                'ton_per_ha' => $prediction['ton_per_ha'] ?? 0,
                'nutrients' => $latest ? $latest->toArray() : null,
                'scores' => $analysis['scores'] ?? []
            ];
        });

        // Apply Filters
        $filteredBlocks = $allBlocks->filter(function($block) {
            $matchAge = true;
            if ($this->selectedAgeRange !== 'all') {
                $age = $block['age'];
                $matchAge = match($this->selectedAgeRange) {
                    'muda' => ($age >= 3 && $age <= 7),
                    'prima' => ($age > 7 && $age <= 18),
                    'tua' => ($age > 18),
                    'tbm' => ($age < 3),
                    default => true
                };
            }

            $matchFertility = ($this->selectedFertility === 'all' || $block['status'] === $this->selectedFertility);

            return $matchAge && $matchFertility;
        });

        // Aggregations
        $summary = [
            'total_yield' => $filteredBlocks->sum('yield'),
            'avg_ton_ha' => $filteredBlocks->avg('ton_per_ha') ?? 0,
            'best_block' => $filteredBlocks->sortByDesc('yield')->first(),
            'needs_improvement' => $filteredBlocks->filter(fn($b) => $b['status'] === 'Kurang Subur')->values(),
            'distribution' => [
                'Subur' => $filteredBlocks->where('status', 'Subur')->count(),
                'Cukup Subur' => $filteredBlocks->where('status', 'Cukup Subur')->count(),
                'Kurang Subur' => $filteredBlocks->where('status', 'Kurang Subur')->count(),
            ]
        ];

        // Yield by Block Chart Data
        $yieldChartData = $filteredBlocks->sortByDesc('yield')->take(10)->map(fn($b) => [
            'name' => $b['name'],
            'yield' => $b['yield']
        ])->values();

        return view('livewire.analytics', [
            'blocks' => $filteredBlocks,
            'summary' => $summary,
            'yieldChartData' => $yieldChartData
        ])->layout('layouts.app');
    }
}
