<?php

namespace App\Exports;

use App\Models\SoilNutrient;
use Maatwebsite\Excel\Concerns\FromQuery;
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
use PhpOffice\PhpSpreadsheet\Style\Color;

class NutrientHistoryExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle, WithColumnWidths, WithEvents
{
    protected $filters;
    protected int $rowCount = 0;

    // ── Palet warna tema hijau-bumi (kelapa sawit) ──────────────────────────
    const COLOR_HEADER_BG   = '1E6B3C';   // hijau tua → header
    const COLOR_HEADER_FONT = 'FFFFFF';   // putih      → teks header
    const COLOR_ROW_ODD     = 'F0F7F2';   // hijau pucat → baris ganjil
    const COLOR_ROW_EVEN    = 'FFFFFF';   // putih       → baris genap
    const COLOR_BORDER      = 'C8DFC9';   // hijau muda  → garis batas

    // Status badge colors
    const COLOR_SUBUR       = '1A7A3A';   // hijau
    const COLOR_KURANG      = 'D97706';   // amber
    const COLOR_TIDAK       = 'DC2626';   // merah

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function title(): string
    {
        return 'Riwayat Pengukuran';
    }

    public function query()
    {
        $query = SoilNutrient::with('block')->orderBy('measured_at', 'desc');

        if (!empty($this->filters['block_id'])) {
            $query->where('block_id', $this->filters['block_id']);
        }
        if (!empty($this->filters['status'])) {
            $query->where('fertility_status', $this->filters['status']);
        }
        if (!empty($this->filters['date_from'])) {
            $query->whereDate('measured_at', '>=', $this->filters['date_from']);
        }
        if (!empty($this->filters['date_to'])) {
            $query->whereDate('measured_at', '<=', $this->filters['date_to']);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'Nama Blok',
            'Tanggal Pengukuran',
            'N (%)',
            'P (ppm)',
            'K (cmol)',
            'pH',
            'EC (dS/m)',
            'C-Organik (%)',
            'S (ppm)',
            'Mg (cmol)',
            'B (ppm)',
            'Status Kesuburan',
        ];
    }

    public function map($nutrient): array
    {
        $this->rowCount++;

        return [
            $nutrient->block->name ?? '-',
            $nutrient->measured_at ? $nutrient->measured_at->format('d/m/Y') : '-',
            $nutrient->nitrogen,
            $nutrient->phosphorus,
            $nutrient->potassium,
            $nutrient->ph,
            $nutrient->ec,
            $nutrient->organic_carbon,
            $nutrient->s,
            $nutrient->magnesium,
            $nutrient->boron,
            $nutrient->fertility_status ?? 'N/A',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 22,   // Nama Blok
            'B' => 22,   // Tanggal
            'C' => 10,   // N
            'D' => 10,   // P
            'E' => 10,   // K
            'F' => 8,    // pH
            'G' => 12,   // EC
            'H' => 14,   // C-Organik
            'I' => 10,   // S
            'J' => 12,   // Mg
            'K' => 10,   // B
            'L' => 22,   // Status
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        // Header row styling
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
                $sheet     = $event->sheet->getDelegate();
                $lastRow   = $this->rowCount + 1; // +1 for header
                $lastCol   = 'L';

                // ── 1. Tambah baris judul di atas header ─────────────────
                $sheet->insertNewRowBefore(1, 2);

                $sheet->mergeCells('A1:L1');
                $sheet->setCellValue('A1', 'LAPORAN RIWAYAT PENGUKURAN UNSUR HARA TANAH');
                $sheet->getStyle('A1')->applyFromArray([
                    'font'      => ['bold' => true, 'size' => 14, 'color' => ['argb' => 'FF' . self::COLOR_HEADER_FONT]],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF0F4C27']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                ]);
                $sheet->getRowDimension(1)->setRowHeight(32);

                $sheet->mergeCells('A2:L2');
                $sheet->setCellValue('A2', 'Diekspor pada: ' . now()->format('d F Y, H:i') . ' WIB');
                $sheet->getStyle('A2')->applyFromArray([
                    'font'      => ['italic' => true, 'size' => 9, 'color' => ['argb' => 'FF555555']],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFF5F5F5']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
                $sheet->getRowDimension(2)->setRowHeight(18);

                // Recalculate lastRow after inserting 2 rows
                $dataLastRow = $this->rowCount + 3; // header=row3, data starts row4

                // ── 2. Styling header (kini di baris 3) ──────────────────
                $sheet->getRowDimension(3)->setRowHeight(28);

                // ── 3. Alternating row colors + border untuk data ─────────
                for ($row = 4; $row <= $dataLastRow; $row++) {
                    $isOdd = ($row % 2 !== 0);
                    $bgColor = $isOdd ? self::COLOR_ROW_ODD : self::COLOR_ROW_EVEN;

                    $sheet->getStyle("A{$row}:{$lastCol}{$row}")->applyFromArray([
                        'fill' => [
                            'fillType'   => Fill::FILL_SOLID,
                            'startColor' => ['argb' => 'FF' . $bgColor],
                        ],
                        'font'      => ['size' => 10],
                        'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                    ]);
                    $sheet->getRowDimension($row)->setRowHeight(20);
                }

                // ── 4. Border seluruh tabel ───────────────────────────────
                if ($dataLastRow >= 4) {
                    $sheet->getStyle("A3:{$lastCol}{$dataLastRow}")->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color'       => ['argb' => 'FF' . self::COLOR_BORDER],
                            ],
                            'outline' => [
                                'borderStyle' => Border::BORDER_MEDIUM,
                                'color'       => ['argb' => 'FF' . self::COLOR_HEADER_BG],
                            ],
                        ],
                    ]);
                }

                // ── 5. Kolom numerik rata tengah ─────────────────────────
                $numericCols = ['C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K'];
                foreach ($numericCols as $col) {
                    $sheet->getStyle("{$col}4:{$col}{$dataLastRow}")
                          ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }

                // ── 6. Status kesuburan — warna teks per nilai ───────────
                for ($row = 4; $row <= $dataLastRow; $row++) {
                    $status = $sheet->getCell("L{$row}")->getValue();
                    $color  = match (true) {
                        str_contains((string)$status, 'Subur') && !str_contains((string)$status, 'Kurang') && !str_contains((string)$status, 'Tidak') => self::COLOR_SUBUR,
                        str_contains((string)$status, 'Kurang') => self::COLOR_KURANG,
                        str_contains((string)$status, 'Tidak')  => self::COLOR_TIDAK,
                        default => '555555',
                    };
                    $sheet->getStyle("L{$row}")->applyFromArray([
                        'font'      => ['bold' => true, 'color' => ['argb' => 'FF' . $color]],
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    ]);
                }

                // ── 7. Freeze panes & auto-filter ────────────────────────
                $sheet->freezePane('A4');
                $sheet->setAutoFilter("A3:{$lastCol}3");

                // ── 8. Print setup ────────────────────────────────────────
                $sheet->getPageSetup()
                      ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE)
                      ->setFitToPage(true)
                      ->setFitToWidth(1);
                $sheet->getPageMargins()->setTop(0.5)->setBottom(0.5)->setLeft(0.5)->setRight(0.5);
                $sheet->getHeaderFooter()
                      ->setOddHeader('&C&B Riwayat Pengukuran Unsur Hara Tanah')
                      ->setOddFooter('&L&D &T&R Halaman &P dari &N');

                // ── 9. Tab warna ──────────────────────────────────────────
                $event->sheet->getDelegate()->getTabColor()->setARGB('FF1E6B3C');
            },
        ];
    }
}