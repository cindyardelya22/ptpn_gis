<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Block;
use App\Services\SoilAnalysisService;
use App\Services\HarvestPredictionService;

class Dashboard extends Component
{
    public function render(SoilAnalysisService $analysisService, HarvestPredictionService $predictionService)
    {
        $blocks = Block::with(['nutrients' => function($q) {
            $q->latest('measured_at');
        }])->get()->map(function(Block $block) use ($analysisService, $predictionService) {
            $latest = $block->nutrients->first();
            $analysis = $latest ? $analysisService->analyzeFertility($latest) : null;
            $prediction = $analysis ? $predictionService->predict($block, $analysis) : null;
            
            return [
                'id' => $block->id,
                'name' => $block->name,
                'area_ha' => $block->area_ha,
                'planted_at' => $block->planted_at->format('Y-m-d'),
                'coords' => $block->polygon_coords,
                'status' => $analysis['status'] ?? 'N/A',
                'color_name' => $analysis['color'] ?? 'slate',
                'yield' => $prediction['total_annual_ton'] ?? 0,
                'ton_per_ha' => $prediction['ton_per_ha'] ?? 0,
                'prediction' => $prediction,
                'analysis' => $analysis,
                'raw_nutrients' => $latest ? $latest->toArray() : null
            ];
        });

        $summary = [
            'total_blocks' => $blocks->count(),
            'fertile_count' => $blocks->where('status', 'Subur')->count(),
            'unfertile_count' => $blocks->where('status', 'Kurang Subur')->count(),
            'estimated_total_yield' => $blocks->sum('yield'),
            'avg_ton_per_ha' => $blocks->avg('ton_per_ha'),
            'best_yield_block' => $blocks->sortByDesc('ton_per_ha')->first()['name'] ?? '-',
            'best_yield_val' => $blocks->max('yield'),
            'distribution' => $blocks->groupBy('status')->map->count(),
        ];

        // Aggregate 12 months trend for all blocks
        $trend = [];
        for ($i = 0; $i < 12; $i++) {
            $monthYield = 0;
            $monthName = '';
            foreach ($blocks as $b) {
                if (isset($b['prediction']['monthly_trend'][$i])) {
                    $monthYield += $b['prediction']['monthly_trend'][$i]['yield'];
                    $monthName = $b['prediction']['monthly_trend'][$i]['month'];
                }
            }
            $trend[] = ['month' => $monthName, 'yield' => round($monthYield, 1)];
        }

        return view('livewire.dashboard', [
            'blocks' => $blocks,
            'summary' => $summary,
            'harvestTrend' => $trend
        ])->layout('layouts.app');
    }
}
