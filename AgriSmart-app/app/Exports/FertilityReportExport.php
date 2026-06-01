<?php

namespace App\Exports;

use App\Models\Block;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\ConditionalFormatting\Wizard;

class FertilityReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, WithColumnWidths, WithEvents
{
    protected $filters;
    protected int $rowCount = 0;

    // ── Palet warna tema hijau-bumi ──────────────────────────────────────
    const COLOR_HEADER_BG    = '155724';   // hijau sangat tua
    const COLOR_HEADER_FONT  = 'FFFFFF';
    const COLOR_SUBHEADER_BG = '1E6B3C';   // hijau tua sekunder
    const COLOR_ROW_ODD      = 'F0F7F2';
    const COLOR_ROW_EVEN     = 'FFFFFF';
    const COLOR_BORDER       = 'C8DFC9';

    // Status
    const COLOR_SUBUR        = '155724';
    const COLOR_SUBUR_BG     = 'D1FAE5';
    const COLOR_KURANG       = '92400E';
    const COLOR_KURANG_BG    = 'FEF3C7';
    const COLOR_TIDAK        = '991B1B';
    const COLOR_TIDAK_BG     = 'FEE2E2';

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function title(): string
    {
        return 'Rekap Kesuburan';
    }

    public function collection()
    {
        $query = Block::with(['nutrients' => fn($q) => $q->latest('measured_at')]);

        if (!empty($this->filters['block_id'])) {
            $query->where('id', $this->filters['block_id']);
        }

        $blocks = $query->get();

        return $blocks->filter(function ($block) {
            $latest = $block->nutrients->first();
            if (!$latest) return false;

            if (!empty($this->filters['status']) && ($latest->fertility_status ?? '') !== $this->filters['status']) {
                return false;
            }
            if (!empty($this->filters['date_from']) && $latest->measured_at && $latest->measured_at->lt($this->filters['date_from'])) {
                return false;
            }
            if (!empty($this->filters['date_to']) && $latest->measured_at && $latest->measured_at->gt($this->filters['date_to'])) {
                return false;
            }
            return true;
        })->values();
    }

    public function headings(): array
    {
        return [
            'Nama Blok',
            'Luas (Ha)',
            'Tgl Pengukuran',
            'Status Kesuburan',
            'N (%)',
            'P (ppm)',
            'K (cmol)',
            'pH',
            'EC (dS/m)',
            'C-Organik (%)',
            'S (ppm)',
            'Mg (cmol)',
            'B (ppm)',
            'Prob. Subur (%)',
            'Prob. Kurang Subur (%)',
            'Prob. Tidak Subur (%)',
        ];
    }

    public function map($block): array
    {
        $this->rowCount++;

        $n     = $block->nutrients->first();
        $probs = $n->fertility_probabilities ?? [];

        return [
            $block->name,
            $block->area_ha,
            $n->measured_at ? $n->measured_at->format('d/m/Y') : '-',
            $n->fertility_status ?? 'N/A',
            $n->nitrogen,
            $n->phosphorus,
            $n->potassium,
            $n->ph,
            $n->ec,
            $n->organic_carbon,
            $n->s,
            $n->magnesium,
            $n->boron,
            isset($probs['Subur'])         ? round($probs['Subur'] * 100, 1)         : '-',
            isset($probs['Kurang Subur'])  ? round($probs['Kurang Subur'] * 100, 1)  : '-',
            isset($probs['Tidak Subur'])   ? round($probs['Tidak Subur'] * 100, 1)   : '-',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 22,  // Nama Blok
            'B' => 12,  // Luas
            'C' => 18,  // Tgl
            'D' => 22,  // Status
            'E' => 10,  'F' => 10,  'G' => 10,
            'H' => 8,   'I' => 12,  'J' => 14,
            'K' => 10,  'L' => 12,  'M' => 10,
            'N' => 18,  // Prob Subur
            'O' => 22,  // Prob Kurang
            'P' => 20,  // Prob Tidak
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => [
                    'bold'  => true,
                    'size'  => 11,
                    'color' => ['argb' => 'FF' . self::COLOR_HEADER_FONT],
                ],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF' . self::COLOR_HEADER_BG],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical'   => Alignment::VERTICAL_CENTER,
                    'wrapText'   => true,
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet   = $event->sheet->getDelegate();
                $lastCol = 'P';

                // ── 1. Insert 2 baris judul di atas ──────────────────────
                $sheet->insertNewRowBefore(1, 2);

                $sheet->mergeCells('A1:P1');
                $sheet->setCellValue('A1', 'REKAP KESUBURAN TANAH KEBUN KELAPA SAWIT');
                $sheet->getStyle('A1')->applyFromArray([
                    'font'      => ['bold' => true, 'size' => 15, 'color' => ['argb' => 'FFFFFFFF']],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF0B3D2A']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                ]);
                $sheet->getRowDimension(1)->setRowHeight(36);

                $sheet->mergeCells('A2:P2');
                $sheet->setCellValue('A2', 'Tanggal Ekspor: ' . now()->format('d F Y, H:i') . ' WIB');
                $sheet->getStyle('A2')->applyFromArray([
                    'font'      => ['italic' => true, 'size' => 9, 'color' => ['argb' => 'FF555555']],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFEDF7EE']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
                $sheet->getRowDimension(2)->setRowHeight(18);

                // ── 2. Tinggi header & subheader grouping ─────────────────
                $sheet->getRowDimension(3)->setRowHeight(32);

                // Subheader group: warna beda untuk kolom probabilitas (N–P)
                $sheet->getStyle('N3:P3')->applyFromArray([
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF' . self::COLOR_SUBHEADER_BG]],
                ]);

                // ── 3. Data baris: alternating + border ──────────────────
                $dataLastRow = $this->rowCount + 3;

                for ($row = 4; $row <= $dataLastRow; $row++) {
                    $bgColor = ($row % 2 !== 0) ? self::COLOR_ROW_ODD : self::COLOR_ROW_EVEN;
                    $sheet->getStyle("A{$row}:{$lastCol}{$row}")->applyFromArray([
                        'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF' . $bgColor]],
                        'font'      => ['size' => 10],
                        'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                    ]);
                    $sheet->getRowDimension($row)->setRowHeight(20);
                }

                // ── 4. Border tabel ───────────────────────────────────────
                if ($dataLastRow >= 4) {
                    $sheet->getStyle("A3:{$lastCol}{$dataLastRow}")->applyFromArray([
                        'borders' => [
                            'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF' . self::COLOR_BORDER]],
                            'outline'    => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['argb' => 'FF' . self::COLOR_HEADER_BG]],
                        ],
                    ]);
                }

                // ── 5. Center numerik ─────────────────────────────────────
                $numCols = ['B', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M'];
                foreach ($numCols as $col) {
                    $sheet->getStyle("{$col}4:{$col}{$dataLastRow}")
                          ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }

                // ── 6. Status Kesuburan — badge warna ────────────────────
                for ($row = 4; $row <= $dataLastRow; $row++) {
                    $status = (string) $sheet->getCell("D{$row}")->getValue();

                    [$fg, $bg] = match (true) {
                        str_contains($status, 'Kurang') => [self::COLOR_KURANG, self::COLOR_KURANG_BG],
                        str_contains($status, 'Tidak')  => [self::COLOR_TIDAK, self::COLOR_TIDAK_BG],
                        str_contains($status, 'Subur')  => [self::COLOR_SUBUR, self::COLOR_SUBUR_BG],
                        default                         => ['555555', 'F3F4F6'],
                    };

                    $sheet->getStyle("D{$row}")->applyFromArray([
                        'font'      => ['bold' => true, 'color' => ['argb' => 'FF' . $fg]],
                        'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF' . $bg]],
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    ]);
                }

                // ── 7. Probabilitas — data bar visual ─────────────────────
                // Kolom N (Prob Subur) → hijau
                $sheet->getStyle("N4:N{$dataLastRow}")
                      ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                // Kolom O (Prob Kurang) → amber
                $sheet->getStyle("O4:O{$dataLastRow}")
                      ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                // Kolom P (Prob Tidak) → merah
                $sheet->getStyle("P4:P{$dataLastRow}")
                      ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Header probabilitas: tebal + italic
                $sheet->getStyle('N3:P3')->getFont()->setItalic(true);

                // ── 8. Freeze & filter ────────────────────────────────────
                $sheet->freezePane('A4');
                $sheet->setAutoFilter("A3:{$lastCol}3");

                // ── 9. Ringkasan di bawah tabel ───────────────────────────
                if ($dataLastRow >= 4) {
                    $summaryRow = $dataLastRow + 2;
                    $sheet->mergeCells("A{$summaryRow}:D{$summaryRow}");
                    $sheet->setCellValue("A{$summaryRow}", '📌 Ringkasan');
                    $sheet->getStyle("A{$summaryRow}")->getFont()->setBold(true)->setSize(11);

                    $sheet->setCellValue("A" . ($summaryRow + 1), 'Total Blok');
                    $sheet->setCellValue("B" . ($summaryRow + 1), "=COUNTA(A4:A{$dataLastRow})");

                    $sheet->setCellValue("A" . ($summaryRow + 2), 'Total Luas (Ha)');
                    $sheet->setCellValue("B" . ($summaryRow + 2), "=SUM(B4:B{$dataLastRow})");

                    $sheet->setCellValue("A" . ($summaryRow + 3), 'Blok Subur');
                    $sheet->setCellValue("B" . ($summaryRow + 3), "=COUNTIF(D4:D{$dataLastRow},\"Subur\")");

                    $sheet->setCellValue("A" . ($summaryRow + 4), 'Blok Kurang Subur');
                    $sheet->setCellValue("B" . ($summaryRow + 4), "=COUNTIF(D4:D{$dataLastRow},\"Kurang Subur\")");

                    $sheet->setCellValue("A" . ($summaryRow + 5), 'Blok Tidak Subur');
                    $sheet->setCellValue("B" . ($summaryRow + 5), "=COUNTIF(D4:D{$dataLastRow},\"Tidak Subur\")");

                    $summaryRange = "A{$summaryRow}:B" . ($summaryRow + 5);
                    $sheet->getStyle($summaryRange)->applyFromArray([
                        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFCCCCCC']]],
                        'fill'    => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFF9FAFB']],
                    ]);

                    // Warna label ringkasan
                    for ($i = 1; $i <= 5; $i++) {
                        $sheet->getStyle("A" . ($summaryRow + $i))->getFont()->setSize(10);
                        $sheet->getStyle("B" . ($summaryRow + $i))->getAlignment()
                              ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    }
                }

                // ── 10. Print & tab ───────────────────────────────────────
                $sheet->getPageSetup()
                      ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE)
                      ->setFitToPage(true)->setFitToWidth(1);
                $sheet->getPageMargins()->setTop(0.5)->setBottom(0.5)->setLeft(0.5)->setRight(0.5);
                $sheet->getHeaderFooter()
                      ->setOddHeader('&C&B Rekap Kesuburan Tanah')
                      ->setOddFooter('&L&D &T&R Halaman &P dari &N');

                $event->sheet->getDelegate()->getTabColor()->setARGB('FF155724');
            },
        ];
    }
}