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

            // Baca status dari DB, fallback ke Flask jika belum ada
            if ($latest && $latest->fertility_status) {
                $status = $latest->fertility_status;
                $color  = $latest->fertility_color ?? 'slate';
            } elseif ($latest) {
                $analysis = $analysisService->analyzeFertility($latest);
                $status = $analysis['status'] ?? 'No Data';
                $color  = $analysis['color']  ?? 'slate';
            } else {
                $status = 'No Data';
                $color  = 'slate';
            }
            
            return [
                'id' => $block->id,
                'name' => $block->name,
                'area_ha' => $block->area_ha,
                'coords' => $block->polygon_coords,
                'status' => $status,
                'color' => $color,
            ];
        });

        return view('livewire.block-map', [
            'blocks' => $blocks
        ])->layout('layouts.app');
    }
}
