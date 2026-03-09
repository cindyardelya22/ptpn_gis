<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Block;
use App\Services\SoilAnalysisService;
use App\Services\HarvestPredictionService;

class BlockDetail extends Component
{
    public $blockId;
    public $block;
    public $analysis;
    public $prediction;
    public $latestNutrient;

    public function mount($id, SoilAnalysisService $analysisService, HarvestPredictionService $predictionService)
    {
        $this->blockId = $id;
        $this->loadData($analysisService, $predictionService);
    }

    private function loadData($analysisService, $predictionService)
    {
        $this->block = Block::with('nutrients')->findOrFail($this->blockId);
        $this->latestNutrient = $this->block->nutrients()->latest('measured_at')->first();

        if ($this->latestNutrient) {
            $this->analysis = $analysisService->analyzeFertility($this->latestNutrient);
            $this->prediction = $predictionService->predict($this->block, $this->analysis);
        }
    }

    public function render()
    {
        return view('livewire.block-detail')->layout('layouts.app');
    }
}
