<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Block;
use App\Services\SoilAnalysisService;
use Carbon\Carbon;

class Analytics extends Component
{
    public $selectedFertility = 'all';

    public function render(SoilAnalysisService $analysisService)
    {
        $allBlocks = Block::with(['nutrients' => function ($q) {
            $q->latest('measured_at');
        }])->get()->map(function (Block $block) use ($analysisService) {
            $latest = $block->nutrients->first();

            // Baca status dari DB, fallback ke Flask jika belum ada
            if ($latest && $latest->fertility_status) {
                $analysis = [
                    'status'        => $latest->fertility_status,
                    'color'         => $latest->fertility_color ?? 'slate',
                    'probabilities' => $latest->fertility_probabilities ?? [],
                ];
            } else {
                $analysis = $latest ? $analysisService->analyzeFertility($latest) : null;
            }

            return [
                'id' => $block->id,
                'name' => $block->name,
                'area_ha' => $block->area_ha,
                'status' => $analysis['status'] ?? 'N/A',
                'color' => $analysis['color'] ?? 'slate',
                'probabilities' => $analysis['probabilities'] ?? [],
                'nutrients' => $latest ? [
                    'nitrogen'       => (float) ($latest->nitrogen ?? 0),
                    'phosphorus'     => (float) ($latest->phosphorus ?? 0),
                    'potassium'      => (float) ($latest->potassium ?? 0),
                    'ph'             => (float) ($latest->ph ?? 0),
                    'ec'             => (float) ($latest->ec ?? 0),
                    'organic_carbon' => (float) ($latest->organic_carbon ?? 0),
                    's'              => (float) ($latest->s ?? 0),
                    'magnesium'      => (float) ($latest->magnesium ?? 0),
                    'boron'          => (float) ($latest->boron ?? 0),
                    'measured_at'    => $latest->measured_at ? $latest->measured_at->format('d M Y') : '-',
                ] : null,
            ];
        });

        // Apply Filters
        $filteredBlocks = $allBlocks;
        if ($this->selectedFertility !== 'all') {
            $filteredBlocks = $allBlocks->filter(
                fn($b) => $b['status'] === $this->selectedFertility
            );
        }

        // Aggregations
        $summary = [
            'total_blocks' => $filteredBlocks->count(),
            'fertile_pct'  => $filteredBlocks->count() > 0
                ? round(($filteredBlocks->where('status', 'Subur')->count() / $filteredBlocks->count()) * 100)
                : 0,
            'needs_improvement' => $filteredBlocks
                ->filter(fn($b) => $b['status'] === 'Kurang Subur' || $b['status'] === 'Tidak Subur')
                ->values(),
            'critical_count' => $filteredBlocks->where('status', 'Tidak Subur')->count(),
            'distribution' => [
                'Subur' => $filteredBlocks->where('status', 'Subur')->count(),
                'Kurang Subur' => $filteredBlocks->where('status', 'Kurang Subur')->count(),
                'Tidak Subur' => $filteredBlocks->where('status', 'Tidak Subur')->count(),
            ],
        ];

        // Average nutrient values for comparison chart
        $nutrientAvg = [];
        $nutrientKeys = ['nitrogen', 'phosphorus', 'potassium', 'ph', 'organic_carbon', 'magnesium'];
        foreach ($nutrientKeys as $key) {
            $vals = $filteredBlocks->filter(fn($b) => $b['nutrients'] !== null)->pluck("nutrients.$key");
            $nutrientAvg[$key] = $vals->count() > 0 ? round($vals->avg(), 2) : 0;
        }

        return view('livewire.analytics', [
            'blocks' => $filteredBlocks,
            'summary' => $summary,
            'nutrientAvg' => $nutrientAvg,
        ])->layout('layouts.app');
    }
}
