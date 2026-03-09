<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Block;
use App\Services\SoilAnalysisService;

class BlockMap extends Component
{
    public function render(SoilAnalysisService $analysisService)
    {
        $blocks = Block::with(['nutrients' => function($q) {
            $q->latest('measured_at');
        }])->get()->map(function($block) use ($analysisService) {
            $latest = $block->nutrients->first();
            $analysis = $latest ? $analysisService->analyzeFertility($latest) : null;
            
            return [
                'id' => $block->id,
                'name' => $block->name,
                'area_ha' => $block->area_ha,
                'coords' => $block->polygon_coords,
                'status' => $analysis['status'] ?? 'No Data',
                'color' => $analysis['color'] ?? 'slate',
            ];
        });

        return view('livewire.block-map', [
            'blocks' => $blocks
        ])->layout('layouts.app');
    }
}
