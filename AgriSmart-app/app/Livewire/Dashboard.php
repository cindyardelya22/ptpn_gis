<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Block;
use App\Services\SoilAnalysisService;
use Carbon\Carbon;

class Dashboard extends Component
{
    // Filter properties — bound ke form
    public string $filterBlock = '';
    public string $filterDateFrom = '';
    public string $filterDateTo = '';

    public function applyFilter(): void
    {
        // Trigger re-render saja; logika filtering ada di render()
    }

    public function resetFilter(): void
    {
        $this->filterBlock = '';
        $this->filterDateFrom = '';
        $this->filterDateTo = '';
    }

    public function render(SoilAnalysisService $analysisService)
    {
        $query = Block::with(['nutrients' => function ($q) {
            if ($this->filterDateFrom) {
                $q->where('measured_at', '>=', Carbon::parse($this->filterDateFrom)->startOfDay());
            }
            if ($this->filterDateTo) {
                $q->where('measured_at', '<=', Carbon::parse($this->filterDateTo)->endOfDay());
            }
            $q->latest('measured_at');
        }]);

        // Filter nama blok
        if ($this->filterBlock) {
            $query->where('name', $this->filterBlock);
        }

        // ← TAMBAH INI: sembunyikan blok yang tidak punya nutrient di rentang waktu
        if ($this->filterDateFrom || $this->filterDateTo) {
            $query->whereHas('nutrients', function ($q) {
                if ($this->filterDateFrom) {
                    $q->where('measured_at', '>=', Carbon::parse($this->filterDateFrom)->startOfDay());
                }
                if ($this->filterDateTo) {
                    $q->where('measured_at', '<=', Carbon::parse($this->filterDateTo)->endOfDay());
                }
            });
        }

        $blocks = $query->get()->map(function (Block $block) use ($analysisService) {
            $latest = $block->nutrients->first();

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
                'id'           => $block->id,
                'name'         => $block->name,
                'area_ha'      => $block->area_ha,
                'planted_at'   => $block->planted_at?->format('Y-m-d'),
                'coords'       => $block->polygon_coords,
                'status'       => $analysis['status'] ?? 'N/A',
                'color_name'   => $analysis['color'] ?? 'slate',
                'analysis'     => $analysis,
                'raw_nutrients' => $latest ? $latest->toArray() : null,
            ];
        });

        // Summary dihitung dari $blocks yang sudah difilter
        $summary = [
            'total_blocks'       => $blocks->count(),
            'total_area'         => $blocks->sum('area_ha'),
            'fertile_count'      => $blocks->where('status', 'Subur')->count(),
            'less_fertile_count' => $blocks->where('status', 'Kurang Subur')->count(),
            'not_fertile_count'  => $blocks->where('status', 'Tidak Subur')->count(),
            'distribution'       => [
                'Subur'        => $blocks->where('status', 'Subur')->count(),
                'Kurang Subur' => $blocks->where('status', 'Kurang Subur')->count(),
                'Tidak Subur'  => $blocks->where('status', 'Tidak Subur')->count(),
            ],
        ];

        // Semua blok untuk dropdown (tanpa filter blok)
        $allBlocks = Block::orderBy('name')->get(['id', 'name']);

        return view('livewire.dashboard', [
            'blocks'    => $blocks,
            'summary'   => $summary,
            'allBlocks' => $allBlocks,
        ])->layout('layouts.app');
    }
}
