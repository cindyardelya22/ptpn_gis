<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Block;
use App\Services\SoilAnalysisService;

class BlockDetail extends Component
{
    public $blockId;
    public $block;
    public $analysis;
    public $latestNutrient;

    public function mount($id, SoilAnalysisService $analysisService)
    {
        $this->blockId = $id;
        $this->loadData($analysisService);
    }

    private function loadData($analysisService)
    {
        $this->block = Block::with('nutrients')->findOrFail($this->blockId);
        $this->latestNutrient = $this->block->nutrients()->latest('measured_at')->first();

        if ($this->latestNutrient) {
            // Baca dari DB, fallback ke Flask jika belum ada
            if ($this->latestNutrient->fertility_status) {
                $this->analysis = [
                    'status'        => $this->latestNutrient->fertility_status,
                    'color'         => $this->latestNutrient->fertility_color ?? 'slate',
                    'probabilities' => $this->latestNutrient->fertility_probabilities ?? [],
                ];
            } else {
                $this->analysis = $analysisService->analyzeFertility($this->latestNutrient);
            }
        }
    }

    public function render()
    {
        return view('livewire.block-detail')->layout('layouts.app');
    }
}
