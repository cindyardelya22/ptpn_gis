<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Block;
use App\Models\SoilNutrient;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FertilityReportExport;
use App\Exports\RecommendationExport;
use App\Exports\NutrientHistoryExport;

class Reports extends Component
{
    public $filterBlock = '';
    public $filterStatus = '';
    public $filterDateFrom = '';
    public $filterDateTo = '';

    public $activeTab = 'fertility'; // fertility, recommendation, history

    protected $queryString = [
        'filterBlock' => ['except' => ''], 
        'filterStatus' => ['except' => ''], 
        'filterDateFrom' => ['except' => ''], 
        'filterDateTo' => ['except' => ''], 
        'activeTab'
    ];

    public function resetFilters()
    {
        $this->reset(['filterBlock', 'filterStatus', 'filterDateFrom', 'filterDateTo']);
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function exportExcel($type)
    {
        $filters = [
            'block_id' => $this->filterBlock,
            'status' => $this->filterStatus,
            'date_from' => $this->filterDateFrom,
            'date_to' => $this->filterDateTo,
        ];

        if ($type === 'fertility') {
            return Excel::download(new FertilityReportExport($filters), 'Rekap_Kesuburan_Tanah_' . date('Ymd_His') . '.xlsx');
        } elseif ($type === 'recommendation') {
            return Excel::download(new RecommendationExport($filters), 'Rekomendasi_Pemupukan_' . date('Ymd_His') . '.xlsx');
        } elseif ($type === 'history') {
            return Excel::download(new NutrientHistoryExport($filters), 'Riwayat_Pengukuran_Hara_' . date('Ymd_His') . '.xlsx');
        }
    }

    public function exportPdf($type)
    {
        $filters = [
            'block_id' => $this->filterBlock,
            'status' => $this->filterStatus,
            'date_from' => $this->filterDateFrom,
            'date_to' => $this->filterDateTo,
        ];

        if ($type === 'fertility') {
            $export = new FertilityReportExport($filters);
            $data = $export->collection();
            $pdf = Pdf::loadView('pdf.fertility-report', ['data' => $data])->setPaper('a4', 'landscape');
            return response()->streamDownload(function () use ($pdf) { echo $pdf->output(); }, 'Rekap_Kesuburan_Tanah_' . date('Ymd_His') . '.pdf');
        } elseif ($type === 'recommendation') {
            $export = new RecommendationExport($filters);
            $data = $export->collection();
            $pdf = Pdf::loadView('pdf.recommendation-report', ['data' => $data])->setPaper('a4', 'landscape');
            return response()->streamDownload(function () use ($pdf) { echo $pdf->output(); }, 'Rekomendasi_Pemupukan_' . date('Ymd_His') . '.pdf');
        } elseif ($type === 'history') {
            $export = new NutrientHistoryExport($filters);
            $data = $export->query()->get();
            $pdf = Pdf::loadView('pdf.nutrient-history', ['data' => $data])->setPaper('a4', 'landscape');
            return response()->streamDownload(function () use ($pdf) { echo $pdf->output(); }, 'Riwayat_Pengukuran_Hara_' . date('Ymd_His') . '.pdf');
        }
    }

    public function render()
    {
        $blocks = Block::orderBy('name')->get();

        $filters = [
            'block_id' => $this->filterBlock,
            'status' => $this->filterStatus,
            'date_from' => $this->filterDateFrom,
            'date_to' => $this->filterDateTo,
        ];

        $previewData = null;
        if ($this->activeTab === 'fertility') {
            $previewData = (new FertilityReportExport($filters))->collection()->take(10);
        } elseif ($this->activeTab === 'recommendation') {
            $previewData = (new RecommendationExport($filters))->collection()->take(10);
        } elseif ($this->activeTab === 'history') {
            $previewData = (new NutrientHistoryExport($filters))->query()->limit(10)->get();
        }

        return view('livewire.reports', [
            'blocks' => $blocks,
            'previewData' => $previewData
        ])->layout('layouts.app');
    }
}
