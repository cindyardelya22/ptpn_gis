<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Block;
use App\Models\SoilNutrient;
use App\Services\SoilAnalysisService;

class NutrientsData extends Component
{
    public $search = '';
    public $statusFilter = '';

    // Modal state
    public $showModal = false;
    public $isEdit = false;
    public $blockId;

    // Form fields (Block)
    public $name;
    public $area_ha;
    public $planted_at;
    public $coord_1;
    public $coord_2;
    public $coord_3;
    public $coord_4;

    // Form fields (Nutrients)
    public $nitrogen;
    public $phosphorus;
    public $potassium;
    public $ph;
    public $magnesium;
    public $organic_carbon;
    public $measured_at;

    protected $rules = [
        'name' => 'required|string|max:255',
        'area_ha' => 'required|numeric|min:0.1',
        'planted_at' => 'required|date',
        'nitrogen' => 'nullable|numeric',
        'phosphorus' => 'nullable|numeric',
        'potassium' => 'nullable|numeric',
        'ph' => 'nullable|numeric',
        'magnesium' => 'nullable|numeric',
        'organic_carbon' => 'nullable|numeric',
        'measured_at' => 'required|date',
    ];

    public function openAddModal()
    {
        $this->resetForm();
        $this->isEdit = false;
        $this->showModal = true;
    }

    public function editBlock($id)
    {
        $this->resetForm();
        $this->isEdit = true;
        $this->blockId = $id;

        $block = Block::with('nutrients')->findOrFail($id);
        $this->name = $block->name;
        $this->area_ha = $block->area_ha;
        $this->planted_at = $block->planted_at ? $block->planted_at->format('Y-m-d') : '';
        
        if ($block->polygon_coords && is_array($block->polygon_coords) && count($block->polygon_coords) >= 4) {
            $this->coord_1 = implode(', ', $block->polygon_coords[0]);
            $this->coord_2 = implode(', ', $block->polygon_coords[1]);
            $this->coord_3 = implode(', ', $block->polygon_coords[2]);
            $this->coord_4 = implode(', ', $block->polygon_coords[3]);
        }

        $latestNutrient = $block->nutrients()->latest('measured_at')->first();
        if ($latestNutrient) {
            $this->nitrogen = $latestNutrient->nitrogen;
            $this->phosphorus = $latestNutrient->phosphorus;
            $this->potassium = $latestNutrient->potassium;
            $this->ph = $latestNutrient->ph;
            $this->magnesium = $latestNutrient->magnesium;
            $this->organic_carbon = $latestNutrient->organic_carbon;
            $this->measured_at = $latestNutrient->measured_at ? $latestNutrient->measured_at->format('Y-m-d') : '';
        }

        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $coords = [];
        foreach ([$this->coord_1, $this->coord_2, $this->coord_3, $this->coord_4] as $coordString) {
            if (!empty(trim($coordString))) {
                // Split by comma, trim whitespace, and convert to float
                $parts = array_map(function($val) {
                    return (float) trim($val);
                }, explode(',', $coordString));
                
                if (count($parts) >= 2) {
                    $coords[] = [$parts[0], $parts[1]];
                }
            }
        }

        if ($this->isEdit) {
            $block = Block::findOrFail($this->blockId);
            $block->update([
                'name' => $this->name,
                'area_ha' => $this->area_ha,
                'planted_at' => $this->planted_at,
                'polygon_coords' => $coords
            ]);
        } else {
            $block = Block::create([
                'name' => $this->name,
                'area_ha' => $this->area_ha,
                'planted_at' => $this->planted_at,
                'polygon_coords' => $coords
            ]);
        }

        // Always handle nutrient latest row (update or create)
        $nutrientData = [
            'nitrogen' => $this->nitrogen ?: 0,
            'phosphorus' => $this->phosphorus ?: 0,
            'potassium' => $this->potassium ?: 0,
            'ph' => $this->ph ?: 0,
            'magnesium' => $this->magnesium ?: 0,
            'organic_carbon' => $this->organic_carbon ?: 0,
            'measured_at' => $this->measured_at,
        ];

        if ($this->isEdit) {
            $latest = $block->nutrients()->latest('measured_at')->first();
            if ($latest) {
                $latest->update($nutrientData);
            } else {
                $block->nutrients()->create($nutrientData);
            }
        } else {
            $block->nutrients()->create($nutrientData);
        }

        $this->closeModal();
    }

    public function deleteBlock($id)
    {
        $block = Block::findOrFail($id);
        $block->nutrients()->delete();
        $block->delete();
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->reset([
            'isEdit', 'blockId', 'name', 'area_ha', 'planted_at',
            'coord_1', 'coord_2', 'coord_3', 'coord_4',
            'nitrogen', 'phosphorus', 'potassium', 'ph', 'magnesium', 'organic_carbon', 'measured_at'
        ]);
        $this->measured_at = now()->format('Y-m-d');
        $this->planted_at = now()->format('Y-m-d');
    }

    public function render(SoilAnalysisService $analysisService)
    {
        $blocksQuery = Block::with(['nutrients' => function($q) {
            $q->latest('measured_at');
        }]);

        if ($this->search) {
            $blocksQuery->where('name', 'like', '%' . $this->search . '%');
        }

        $allBlocks = $blocksQuery->get()->map(function($block) use ($analysisService) {
            $latest = $block->nutrients->first();
            $analysis = $latest ? $analysisService->analyzeFertility($latest) : null;

            return [
                'id' => $block->id,
                'name' => $block->name,
                'area_ha' => $block->area_ha,
                'status' => $analysis['status'] ?? 'N/A',
                'color' => $analysis['color'] ?? 'slate',
                'nutrients' => [
                    'nitrogen' => $latest->nitrogen ?? 0,
                    'phosphorus' => $latest->phosphorus ?? 0,
                    'potassium' => $latest->potassium ?? 0,
                    'ph' => $latest->ph ?? 0,
                    'magnesium' => $latest->magnesium ?? 0,
                    'c_organic' => $latest->organic_carbon ?? 0,
                ],
                'raw_block' => $block
            ];
        });

        if ($this->statusFilter) {
            $allBlocks = $allBlocks->filter(function($b) {
                return $b['status'] === $this->statusFilter;
            });
        }

        return view('livewire.nutrients-data', [
            'blocks' => $allBlocks
        ])->layout('layouts.app');
    }
}

