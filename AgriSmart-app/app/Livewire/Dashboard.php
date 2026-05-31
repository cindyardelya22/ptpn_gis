<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Block;
use App\Services\SoilAnalysisService;

class Dashboard extends Component
{
    public function render(SoilAnalysisService $analysisService)
    {
        $blocks = Block::with(['nutrients' => function ($q) {
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
                'planted_at' => $block->planted_at ? $block->planted_at->format('Y-m-d') : null,
                'coords' => $block->polygon_coords,
                'status' => $analysis['status'] ?? 'N/A',
                'color_name' => $analysis['color'] ?? 'slate',
                'analysis' => $analysis,
                'raw_nutrients' => $latest ? $latest->toArray() : null
            ];
        });

        $totalArea = $blocks->sum('area_ha');

        $summary = [
            'total_blocks' => $blocks->count(),
            'total_area'   => $totalArea,
            'fertile_count' => $blocks->where('status', 'Subur')->count(),
            'less_fertile_count' => $blocks->where('status', 'Kurang Subur')->count(),
            'not_fertile_count' => $blocks->where('status', 'Tidak Subur')->count(),
            'distribution' => [
                'Subur'        => $blocks->where('status', 'Subur')->count(),
                'Kurang Subur' => $blocks->where('status', 'Kurang Subur')->count(),
                'Tidak Subur'  => $blocks->where('status', 'Tidak Subur')->count(),
            ],
        ];

        return view('livewire.dashboard', [
            'blocks' => $blocks,
            'summary' => $summary,
        ])->layout('layouts.app');
    }
}
