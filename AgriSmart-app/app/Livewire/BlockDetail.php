<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Block;
use App\Services\SoilAnalysisService;

class BlockDetail extends Component
{
    public int $blockId;
    // HAPUS: public $block;
    // HAPUS: public $analysis;  
    // HAPUS: public $latestNutrient;
    public array $checkedItems = [];

    public function mount($id, SoilAnalysisService $analysisService)
    {
        $this->blockId = $id;

        // Load checkedItems saja di mount
        $latestNutrient = Block::findOrFail($id)
            ->nutrients()
            ->latest('measured_at')
            ->first();

        $saved = $latestNutrient?->recommendation_progress ?? [];
        $this->checkedItems = is_array($saved) ? $saved : json_decode($saved, true) ?? [];
    }

    public function toggleItem(int $index): void
    {
        if (in_array($index, $this->checkedItems)) {
            $this->checkedItems = array_values(array_filter(
                $this->checkedItems,
                fn($i) => $i !== $index
            ));
        } else {
            $this->checkedItems[] = $index;
        }

        $latestNutrient = Block::findOrFail($this->blockId)
            ->nutrients()
            ->latest('measured_at')
            ->first();

        $latestNutrient?->update([
            'recommendation_progress' => $this->checkedItems,
        ]);
    }

    private function loadData($analysisService)
    {
        $this->block = Block::with('nutrients')->findOrFail($this->blockId);
        $this->latestNutrient = $this->block->nutrients()->latest('measured_at')->first();

        if ($this->latestNutrient) {
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

    private function generateRecommendations($latestNutrient): array
    {
        if (!$latestNutrient) {
            return [['type' => 'general', 'label' => 'Belum ada data unsur hara.']];
        }

        $thresholds = [
            'nitrogen'       => ['label' => 'Nitrogen (N)',    'unit' => 'mg/kg', 'min' => 320.00, 'max' => 354.50, 'fertilizer' => 'Urea atau ZA'],
            'phosphorus'     => ['label' => 'Fosfor (P)',      'unit' => 'mg/kg', 'min' => 12.15,  'max' => 20.60,  'fertilizer' => 'SP-36 atau TSP'],
            'potassium'      => ['label' => 'Kalium (K)',      'unit' => 'mg/kg', 'min' => 422.00, 'max' => 602.00, 'fertilizer' => 'KCl atau MOP'],
            'ph'             => ['label' => 'pH Tanah',        'unit' => '',      'min' => 7.38,   'max' => 7.81,   'fertilizer' => 'Dolomit (jika asam) / Belerang (jika basa)'],
            'ec'             => ['label' => 'EC',              'unit' => 'dS/m',  'min' => 0.42,   'max' => 0.62,   'fertilizer' => 'Perbaiki drainase & sistem irigasi'],
            'organic_carbon' => ['label' => 'C-Organik',      'unit' => '%',     'min' => 0.47,   'max' => 0.88,   'fertilizer' => 'Kompos atau pupuk kandang'],
            's'              => ['label' => 'Sulfur (S)',      'unit' => 'mg/kg', 'min' => 4.22,   'max' => 7.54,   'fertilizer' => 'ZA atau Kieserit'],
            'magnesium'      => ['label' => 'Magnesium (Mg)', 'unit' => 'cmol',  'min' => 1.90,   'max' => 2.61,   'fertilizer' => 'Kieserit atau Dolomit'],
            'boron'          => ['label' => 'Boron (B)',       'unit' => 'mg/kg', 'min' => 0.32,   'max' => 0.66,   'fertilizer' => 'Borax atau Solubor'],
        ];

        $items = [];

        foreach ($thresholds as $key => $t) {
            $val = $latestNutrient->{$key} ?? 0; // ← PERBAIKAN DI SINI

            if ($val < $t['min']) {
                $kekurangan = round($t['min'] - $val, 2);
                $items[] = [
                    'type'  => 'deficit',
                    'label' => "Tambahkan <strong>{$t['fertilizer']}</strong> — {$t['label']} kurang {$kekurangan} {$t['unit']} dari batas minimum ({$t['min']} {$t['unit']})",
                ];
            } elseif ($val > $t['max']) {
                $kelebihan = round($val - $t['max'], 2);
                $items[] = [
                    'type'  => 'excess',
                    'label' => "Hentikan sementara aplikasi <strong>{$t['fertilizer']}</strong> — {$t['label']} melebihi batas aman sebesar {$kelebihan} {$t['unit']} (saat ini {$val}, batas {$t['max']} {$t['unit']})",
                ];
            }
        }

        if (empty($items)) {
            $items[] = [
                'type'  => 'optimal',
                'label' => 'Semua unsur hara dalam zona aman. Pertahankan jadwal pemupukan rutin setiap 3 bulan.',
            ];
        }

        $items[] = [
            'type'  => 'general',
            'label' => 'Catat seluruh aktivitas pemupukan ke dalam log untuk tracking historis.',
        ];

        return $items;
    }

    private function generateMainAdvice($latestNutrient, $analysis): string
    {
        $status = $analysis['status'] ?? 'N/A';

        if ($status === 'Subur') {
            return 'Kondisi tanah optimal. Pertahankan jadwal pemupukan rutin dan lakukan uji tanah berkala setiap 6 bulan.';
        } elseif ($status === 'Kurang Subur') {
            return 'Beberapa unsur hara perlu ditingkatkan. Lakukan pemupukan berimbang sesuai rekomendasi di bawah.';
        } else {
            return 'Kondisi tanah kritis. Segera lakukan pemupukan NPK intensif dan konsultasikan dengan agronomis.';
        }
    }

    public function render(SoilAnalysisService $analysisService)
    {
        // Load fresh setiap render — tidak disimpan di property
        $block = Block::with('nutrients')->findOrFail($this->blockId);
        $latestNutrient = $block->nutrients()->latest('measured_at')->first();

        $analysis = null;
        if ($latestNutrient) {
            if ($latestNutrient->fertility_status) {
                $analysis = [
                    'status'        => $latestNutrient->fertility_status,
                    'color'         => $latestNutrient->fertility_color ?? 'slate',
                    'probabilities' => $latestNutrient->fertility_probabilities ?? [],
                ];
            } else {
                $analysis = $analysisService->analyzeFertility($latestNutrient);
            }
        }

        return view('livewire.block-detail', [
            'block'           => $block,
            'latestNutrient'  => $latestNutrient,
            'analysis'        => $analysis ?? ['status' => 'N/A', 'color' => 'slate', 'probabilities' => []],
            'recommendations' => $this->generateRecommendations($latestNutrient),
            'mainAdvice'      => $this->generateMainAdvice($latestNutrient, $analysis),
        ])->layout('layouts.app');
    }
}
