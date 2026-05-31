<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Block;
use App\Models\SoilNutrient;
use App\Services\SoilAnalysisService;
use Livewire\WithPagination;

class NutrientsData extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';

    // Modal state
    public $showModal = false;
    public $isEdit = false;
    public $blockId;

    // Detail Modal
    public $showDetailModal = false;
    public $selectedBlock = [];

    // Form fields (Block)
    public $name;
    public $area_ha;
    public $planted_at;
    public $coord_1;
    public $coord_2;
    public $coord_3;
    public $coord_4;

    // Form fields (Nutrients) — 9 field sesuai model ML
    public $nitrogen;       // N
    public $phosphorus;     // P
    public $potassium;      // K
    public $ph;             // pH
    public $ec;             // EC
    public $organic_carbon; // OC
    public $s;              // S
    public $magnesium;      // Mg
    public $boron;          // B
    public $measured_at;

    protected $rules = [
        'name'           => 'required|string|max:255',
        'area_ha'        => 'required|numeric|min:0.1',
        'planted_at'     => 'required|date',
        'nitrogen'       => 'nullable|numeric|min:0',
        'phosphorus'     => 'nullable|numeric|min:0',
        'potassium'      => 'nullable|numeric|min:0',
        'ph'             => 'nullable|numeric|min:0|max:14',
        'ec'             => 'nullable|numeric|min:0',
        'organic_carbon' => 'nullable|numeric|min:0',
        's'              => 'nullable|numeric|min:0',
        'magnesium'      => 'nullable|numeric|min:0',
        'boron'          => 'nullable|numeric|min:0',
        'measured_at'    => 'required|date',
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
        $this->isEdit  = true;
        $this->blockId = $id;

        $block = Block::with('nutrients')->findOrFail($id);
        $this->name      = $block->name;
        $this->area_ha   = $block->area_ha;
        $this->planted_at = $block->planted_at ? $block->planted_at->format('Y-m-d') : '';

        if ($block->polygon_coords && is_array($block->polygon_coords) && count($block->polygon_coords) >= 4) {
            $this->coord_1 = implode(', ', $block->polygon_coords[0]);
            $this->coord_2 = implode(', ', $block->polygon_coords[1]);
            $this->coord_3 = implode(', ', $block->polygon_coords[2]);
            $this->coord_4 = implode(', ', $block->polygon_coords[3]);
        }

        $latest = $block->nutrients()->latest('measured_at')->first();
        if ($latest) {
            $this->nitrogen       = $latest->nitrogen;
            $this->phosphorus     = $latest->phosphorus;
            $this->potassium      = $latest->potassium;
            $this->ph             = $latest->ph;
            $this->ec             = $latest->ec;
            $this->organic_carbon = $latest->organic_carbon;
            $this->s              = $latest->s;
            $this->magnesium      = $latest->magnesium;
            $this->boron          = $latest->boron;
            $this->measured_at    = $latest->measured_at ? $latest->measured_at->format('Y-m-d') : '';
        }

        $this->showModal = true;
    }

    public function showDetail($id, SoilAnalysisService $analysisService)
    {
        $block = Block::with([
            'nutrients' => fn($q) => $q->latest('measured_at')
        ])->findOrFail($id);

        $latest  = $block->nutrients->first();
        $analysis = $latest ? $analysisService->analyzeFertility($latest) : null;

        $this->selectedBlock = [
            'id'            => $block->id,
            'name'          => $block->name,
            'area_ha'       => $block->area_ha,
            'status'        => $analysis['status']        ?? 'N/A',
            'color'         => $analysis['color']         ?? 'slate',
            'probabilities' => $analysis['probabilities'] ?? [],
            'nutrients'     => [
                'nitrogen'       => $latest->nitrogen       ?? 0,
                'phosphorus'     => $latest->phosphorus     ?? 0,
                'potassium'      => $latest->potassium      ?? 0,
                'ph'             => $latest->ph             ?? 0,
                'ec'             => $latest->ec             ?? 0,
                'organic_carbon' => $latest->organic_carbon ?? 0,
                's'              => $latest->s              ?? 0,
                'magnesium'      => $latest->magnesium      ?? 0,
                'boron'          => $latest->boron          ?? 0,
            ],
        ];

        $this->showDetailModal = true;
    }

    public function closeDetailModal()
    {
        $this->showDetailModal = false;
        $this->selectedBlock   = [];
    }

    public function save()
    {
        $this->validate();

        // Parse koordinat
        $coords = [];
        foreach ([$this->coord_1, $this->coord_2, $this->coord_3, $this->coord_4] as $coordString) {
            if (!empty(trim((string) $coordString))) {
                $parts = array_map(fn($v) => (float) trim($v), explode(',', $coordString));
                if (count($parts) >= 2) {
                    $coords[] = [$parts[0], $parts[1]];
                }
            }
        }

        // Simpan / update block
        if ($this->isEdit) {
            $block = Block::findOrFail($this->blockId);
            $block->update([
                'name'           => $this->name,
                'area_ha'        => $this->area_ha,
                'planted_at'     => $this->planted_at,
                'polygon_coords' => $coords,
            ]);
        } else {
            $block = Block::create([
                'name'           => $this->name,
                'area_ha'        => $this->area_ha,
                'planted_at'     => $this->planted_at,
                'polygon_coords' => $coords,
            ]);
        }

        // Data nutrisi — 9 field sesuai ML
        $nutrientData = [
            'nitrogen'       => $this->nitrogen       ?: 0,
            'phosphorus'     => $this->phosphorus     ?: 0,
            'potassium'      => $this->potassium      ?: 0,
            'ph'             => $this->ph             ?: 0,
            'ec'             => $this->ec             ?: 0,
            'organic_carbon' => $this->organic_carbon ?: 0,
            's'              => $this->s              ?: 0,
            'magnesium'      => $this->magnesium      ?: 0,
            'boron'          => $this->boron          ?: 0,
            'measured_at'    => $this->measured_at,
        ];

        if ($this->isEdit) {
            $latest = $block->nutrients()->latest('measured_at')->first();
            $latest ? $latest->update($nutrientData) : $block->nutrients()->create($nutrientData);
        } else {
            $block->nutrients()->create($nutrientData);
        }

        $isEdit = $this->isEdit;
        $this->closeModal();
        $this->dispatch('notify', [
            'type'    => 'success',
            'message' => $isEdit ? 'Data blok berhasil diperbarui.' : 'Data blok berhasil ditambahkan.',
        ]);
    }

    public function deleteBlock($id)
    {
        $block = Block::findOrFail($id);
        $block->nutrients()->delete();
        $block->delete();

        $this->dispatch('notify', [
            'type'    => 'danger',
            'message' => 'Data blok berhasil dihapus.',
        ]);
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->reset([
            'isEdit', 'blockId',
            'name', 'area_ha', 'planted_at',
            'coord_1', 'coord_2', 'coord_3', 'coord_4',
            'nitrogen', 'phosphorus', 'potassium',
            'ph', 'ec', 'organic_carbon',
            's', 'magnesium', 'boron',
            'measured_at',
        ]);
        $this->measured_at = now()->format('Y-m-d');
        $this->planted_at  = now()->format('Y-m-d');
    }

    public function render(SoilAnalysisService $analysisService)
    {
        $blocksQuery = Block::with([
            'nutrients' => fn($q) => $q->latest('measured_at')
        ]);

        if ($this->search) {
            $blocksQuery->where('name', 'like', '%' . $this->search . '%');
        }

        $blocks = $blocksQuery->paginate(10);

        $blocks->getCollection()->transform(function ($block) use ($analysisService) {
            $latest   = $block->nutrients->first();
            $analysis = $latest ? $analysisService->analyzeFertility($latest) : null;

            return [
                'id'      => $block->id,
                'name'    => $block->name,
                'area_ha' => $block->area_ha,
                'status'  => $analysis['status'] ?? 'N/A',
                'color'   => $analysis['color']  ?? 'slate',
                'nutrients' => [
                    'nitrogen'       => $latest->nitrogen       ?? 0,
                    'phosphorus'     => $latest->phosphorus     ?? 0,
                    'potassium'      => $latest->potassium      ?? 0,
                    'ph'             => $latest->ph             ?? 0,
                    'magnesium'      => $latest->magnesium      ?? 0,
                    'organic_carbon' => $latest->organic_carbon ?? 0,
                ],
                'raw_block' => $block,
            ];
        });

        if ($this->statusFilter) {
            $filtered = $blocks->getCollection()->filter(
                fn($b) => $b['status'] === $this->statusFilter
            );
            $blocks->setCollection($filtered->values());
        }

        return view('livewire.nutrients-data', [
            'blocks' => $blocks,
        ])->layout('layouts.app');
    }
}