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

class RecommendationExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, WithColumnWidths, WithEvents
{
    protected $filters;
    protected int $rowCount = 0;

    // Standar minimum unsur hara untuk kelapa sawit
    protected $standards = [
        'nitrogen'       => ['min' => 2.5,  'label' => 'Nitrogen (N)',    'unit' => '%'],
        'phosphorus'     => ['min' => 15,   'label' => 'Fosfor (P)',      'unit' => 'ppm'],
        'potassium'      => ['min' => 0.2,  'label' => 'Kalium (K)',      'unit' => 'cmol'],
        'ph'             => ['min' => 5.5,  'label' => 'pH Tanah',        'unit' => ''],
        'organic_carbon' => ['min' => 1.5,  'label' => 'C-Organik',       'unit' => '%'],
        'magnesium'      => ['min' => 0.25, 'label' => 'Magnesium (Mg)',  'unit' => 'cmol'],
    ];

    // ── Palet warna tema oranye-hijau (aksi/warning) ─────────────────────
    const COLOR_HEADER_BG    = '7C3AED';   // ungu profesional → header utama
    const COLOR_HEADER_FONT  = 'FFFFFF';
    const COLOR_ROW_ODD      = 'FAF5FF';   // lavender sangat pucat
    const COLOR_ROW_EVEN     = 'FFFFFF';
    const COLOR_BORDER       = 'DDD6FE';   // lavender muda

    // Status badges
    const COLOR_KURANG       = '92400E';
    const COLOR_KURANG_BG    = 'FEF3C7';
    const COLOR_TIDAK        = '991B1B';
    const COLOR_TIDAK_BG     = 'FEE2E2';

    // Deficit / rekomendasi cell
    const COLOR_DEFICIT_BG   = 'FFF7ED';   // oranye pucat
    const COLOR_ACTION_BG    = 'EFF6FF';   // biru pucat

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function title(): string
    {
        return 'Rekomendasi Pemupukan';
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

            $status = $latest->fertility_status ?? 'N/A';

            if (!empty($this->filters['status'])) {
                if ($status !== $this->filters['status']) return false;
            } else {
                if ($status === 'Subur') return false;
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
            'Status Kesuburan',
            'Unsur Defisit',
            'Rekomendasi Tindakan',
        ];
    }

    public function map($block): array
    {
        $this->rowCount++;

        $n               = $block->nutrients->first();
        $deficits        = [];
        $recommendations = [];

        foreach ($this->standards as $field => $std) {
            $val = (float) ($n->$field ?? 0);
            if ($val < $std['min']) {
                $deficits[]        = "• {$std['label']}: {$val} {$std['unit']} (min: {$std['min']})";
                $recommendations[] = "→ Tambah {$std['label']} hingga ≥ {$std['min']} {$std['unit']}";
            }
        }

        return [
            $block->name,
            $block->area_ha,
            $n->fertility_status ?? 'N/A',
            implode("\n", $deficits)        ?: '✓ Tidak ada defisit terdeteksi',
            implode("\n", $recommendations) ?: '✓ Pertahankan pemupukan rutin',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 24,   // Nama Blok
            'B' => 12,   // Luas
            'C' => 24,   // Status
            'D' => 48,   // Defisit
            'E' => 52,   // Rekomendasi
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
                $lastCol = 'E';

                // ── 1. Insert 2 baris: judul + info ──────────────────────
                $sheet->insertNewRowBefore(1, 2);

                // Baris 1: Judul utama
                $sheet->mergeCells('A1:E1');
                $sheet->setCellValue('A1', 'LAPORAN REKOMENDASI PEMUPUKAN LAHAN KELAPA SAWIT');
                $sheet->getStyle('A1')->applyFromArray([
                    'font'      => ['bold' => true, 'size' => 15, 'color' => ['argb' => 'FFFFFFFF']],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF4C1D95']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                ]);
                $sheet->getRowDimension(1)->setRowHeight(38);

                // Baris 2: Sub-info
                $sheet->mergeCells('A2:E2');
                $sheet->setCellValue('A2', 'Laporan ini menampilkan blok yang memerlukan tindakan pemupukan. Diekspor: ' . now()->format('d F Y, H:i') . ' WIB');
                $sheet->getStyle('A2')->applyFromArray([
                    'font'      => ['italic' => true, 'size' => 9, 'color' => ['argb' => 'FF4B5563']],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFF5F3FF']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
                $sheet->getRowDimension(2)->setRowHeight(20);


                $sheet->getRowDimension(3)->setRowHeight(18);

                // ── 2. Header (kini baris 3) ──────────────────────────────
                $sheet->getRowDimension(3)->setRowHeight(32);

                // ── 3. Data rows ──────────────────────────────────────────
                $dataLastRow = $this->rowCount + 3;

                for ($row = 4; $row <= $dataLastRow; $row++) {
                    $bgColor = ($row % 2 !== 0) ? self::COLOR_ROW_ODD : self::COLOR_ROW_EVEN;
                    $sheet->getStyle("A{$row}:E{$row}")->applyFromArray([
                        'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF' . $bgColor]],
                        'font'      => ['size' => 10],
                        'alignment' => ['vertical' => Alignment::VERTICAL_TOP, 'wrapText' => true],
                    ]);
                    // Beri warna khusus kolom Defisit & Rekomendasi
                    $sheet->getStyle("D{$row}")->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('FF' . self::COLOR_DEFICIT_BG);
                    $sheet->getStyle("E{$row}")->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('FF' . self::COLOR_ACTION_BG);
                    $sheet->getStyle("D{$row}")->getFont()->setSize(9);
                    $sheet->getStyle("E{$row}")->getFont()->setSize(9)->setItalic(true);

                    // Row height adaptif (min 40 px)
                    $sheet->getRowDimension($row)->setRowHeight(50);
                }

                // ── 4. Border tabel ───────────────────────────────────────
                if ($dataLastRow >= 5) {
                    $sheet->getStyle("A3:{$lastCol}{$dataLastRow}")->applyFromArray([
                        'borders' => [
                            'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF' . self::COLOR_BORDER]],
                            'outline'    => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['argb' => 'FF' . self::COLOR_HEADER_BG]],
                        ],
                    ]);
                }

                // ── 5. Center kolom Luas & Status ─────────────────────────
                $sheet->getStyle("B4:B{$dataLastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("C4:C{$dataLastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // ── 6. Badge warna Status Kesuburan ───────────────────────
                for ($row = 4; $row <= $dataLastRow; $row++) {
                    $status = (string) $sheet->getCell("C{$row}")->getValue();

                    [$fg, $bg] = match (true) {
                        str_contains($status, 'Tidak')  => [self::COLOR_TIDAK, self::COLOR_TIDAK_BG],
                        str_contains($status, 'Kurang') => [self::COLOR_KURANG, self::COLOR_KURANG_BG],
                        default                         => ['155724', 'D1FAE5'],
                    };

                    $sheet->getStyle("C{$row}")->applyFromArray([
                        'font'      => ['bold' => true, 'size' => 10, 'color' => ['argb' => 'FF' . $fg]],
                        'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF' . $bg]],
                    ]);
                }

                // ── 7. Highlight baris jika defisit banyak ────────────────
                for ($row = 4; $row <= $dataLastRow; $row++) {
                    $defisit = (string) $sheet->getCell("D{$row}")->getValue();
                    $count   = substr_count($defisit, '•');
                    if ($count >= 3) {
                        // 3+ defisit = highlight nama blok
                        $sheet->getStyle("A{$row}")->getFont()->setBold(true);
                        $sheet->getStyle("A{$row}")->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('FFFEF2F2');
                    }
                }

                // ── 8. Freeze & filter ────────────────────────────────────
                $sheet->freezePane('A4');
                $sheet->setAutoFilter("A3:{$lastCol}3");

                // ── 9. Ringkasan di bawah ─────────────────────────────────
                if ($dataLastRow >= 5) {
                    $sumRow = $dataLastRow + 2;
                    $sheet->mergeCells("A{$sumRow}:B{$sumRow}");
                    $sheet->setCellValue("A{$sumRow}", '📌 Ringkasan');
                    $sheet->getStyle("A{$sumRow}")->getFont()->setBold(true)->setSize(11);

                    $sheet->setCellValue("A" . ($sumRow + 1), 'Total Blok Perlu Penanganan');
                    $sheet->setCellValue("B" . ($sumRow + 1), "=COUNTA(A4:A{$dataLastRow})");

                    $sheet->setCellValue("A" . ($sumRow + 2), 'Total Luas (Ha)');
                    $sheet->setCellValue("B" . ($sumRow + 2), "=SUM(B4:B{$dataLastRow})");

                    $sheet->setCellValue("A" . ($sumRow + 3), 'Tidak Subur');
                    $sheet->setCellValue("B" . ($sumRow + 3), "=COUNTIF(C4:C{$dataLastRow},\"Tidak Subur\")");
                    $sheet->getStyle("B" . ($sumRow + 3))->getFont()->setBold(true)->getColor()->setARGB('FF' . self::COLOR_TIDAK);

                    $sheet->setCellValue("A" . ($sumRow + 4), 'Kurang Subur');
                    $sheet->setCellValue("B" . ($sumRow + 4), "=COUNTIF(C4:C{$dataLastRow},\"Kurang Subur\")");
                    $sheet->getStyle("B" . ($sumRow + 4))->getFont()->setBold(true)->getColor()->setARGB('FF' . self::COLOR_KURANG);

                    $sumRange = "A{$sumRow}:B" . ($sumRow + 4);
                    $sheet->getStyle($sumRange)->applyFromArray([
                        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFCCCCCC']]],
                        'fill'    => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFFAF5FF']],
                        'font'    => ['size' => 10],
                    ]);
                    for ($i = 1; $i <= 4; $i++) {
                        $sheet->getStyle("B" . ($sumRow + $i))->getAlignment()
                            ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    }
                }

                // ── 10. Print & tab ───────────────────────────────────────
                $sheet->getPageSetup()
                    ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE)
                    ->setFitToPage(true)->setFitToWidth(1);
                $sheet->getPageMargins()->setTop(0.5)->setBottom(0.5)->setLeft(0.5)->setRight(0.5);
                $sheet->getHeaderFooter()
                    ->setOddHeader('&C&B Rekomendasi Pemupukan Lahan')
                    ->setOddFooter('&L&D &T&R Halaman &P dari &N');

                $event->sheet->getDelegate()->getTabColor()->setARGB('FF7C3AED');
            },
        ];
    }
}
