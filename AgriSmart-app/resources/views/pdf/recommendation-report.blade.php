<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Rekomendasi Pemupukan</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap');

        :root {
            --amber-dark: #78350f;
            --amber-mid: #b45309;
            --amber-accent: #d97706;
            --amber-light: #fef3c7;
            --amber-subtle: #fffbeb;
            --blue-act: #1d4ed8;
            --blue-bg: #eff6ff;
            --blue-border: #bfdbfe;
            --red: #b91c1c;
            --red-bg: #fee2e2;
            --red-border: #fecaca;
            --green: #15803d;
            --green-bg: #dcfce7;
            --slate: #475569;
            --slate-light: #f8fafc;
            --ink: #1e1b18;
            --border: #e7e5e4;
            --border-warm: #d6d3d1;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            font-size: 11px;
            color: var(--ink);
            background: #fafaf9;
            padding: 28px 32px;
            line-height: 1.5;
        }

        /* ── HEADER ── */
        .report-header {
            padding-bottom: 16px;
            margin-bottom: 20px;
            border-bottom: 2px solid var(--amber-accent);
        }

        .header-inner {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .brand-tag {
            font-size: 9px;
            font-weight: 600;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--amber-accent);
            margin-bottom: 5px;
        }

        .report-title {
            font-family: 'DM Serif Display', serif;
            font-size: 26px;
            color: var(--amber-dark);
            line-height: 1.15;
            margin-bottom: 3px;
        }

        .report-subtitle {
            font-size: 11px;
            color: var(--slate);
            font-weight: 300;
        }

        .header-right {
            text-align: right;
        }

        .urgency-tag {
            display: inline-block;
            background: var(--amber-dark);
            color: #fff;
            font-size: 9px;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 3px 10px;
            border-radius: 2px;
            margin-bottom: 7px;
        }

        .header-meta {
            font-size: 10px;
            color: var(--slate);
            line-height: 1.7;
        }

        .header-meta strong {
            color: var(--ink);
            font-weight: 600;
        }

        /* ── SUMMARY TABLE ── */

        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: 1px solid #fde68a;
            background: var(--amber-subtle);
        }

        .summary-table td {
            border-right: 1px solid #fde68a;
            vertical-align: middle;
        }

        .summary-table td:last-child {
            border-right: none;
        }

        .summary-cell {
            width: 110px;
            text-align: center;
            padding: 12px;
        }

        .summary-note-cell {
            padding: 12px 16px;
            font-size: 10px;
            color: var(--amber-dark);
            line-height: 1.6;
        }

        .summary-num {
            font-family: 'DM Serif Display', serif;
            font-size: 28px;
            line-height: 1;
            color: var(--amber-dark);
            margin-bottom: 4px;
        }

        .summary-num.red {
            color: var(--red);
        }

        .summary-num.amber {
            color: var(--amber-mid);
        }

        .summary-label {
            font-size: 9px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--slate);
        }

        /* ── SECTION ── */
        .section-header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
        }

        .section-label {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--slate);
            white-space: nowrap;
        }

        .section-rule {
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* ── TABLE ── */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            background: var(--amber-dark);
        }

        thead th {
            background: #b45309;
            color: #ffffff;
            font-size: 9px;
            font-weight: 600;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            padding: 8px 10px;
            text-align: left;
        }

        thead th:nth-child(1) {
            width: 17%;
        }

        thead th:nth-child(2) {
            width: 14%;
            text-align: center;
        }

        thead th:nth-child(3) {
            width: 35%;
        }

        thead th:nth-child(4) {
            width: 34%;
        }

        tbody tr {
            border-bottom: 1px solid var(--border);
        }

        tbody tr:nth-child(even) {
            background: var(--amber-subtle);
        }

        tbody tr:nth-child(odd) {
            background: #fff;
        }

        tbody td {
            padding: 8px 10px;
            font-size: 10px;
            color: var(--ink);
            vertical-align: top;
        }

        /* Nama blok */
        td.name-col {
            font-weight: 600;
            font-size: 10px;
            color: var(--amber-dark);
        }

        td.name-col small {
            display: block;
            font-weight: 400;
            font-size: 8px;
            color: var(--slate);
            margin-top: 1px;
        }

        td.status-col {
            text-align: center;
            vertical-align: middle;
        }

        /* ── STATUS BADGES ── */
        .badge {
            display: inline-block;
            padding: 3px 9px;
            border-radius: 20px;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .badge-kurang {
            background: var(--amber-light);
            color: var(--amber-mid);
        }

        .badge-tidak {
            background: var(--red-bg);
            color: var(--red);
        }

        .badge-subur {
            background: var(--green-bg);
            color: var(--green);
        }

        /* ── DEFICIT LIST ── */
        .deficit-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .deficit-list li {
            display: flex;
            align-items: baseline;
            gap: 5px;
            margin-bottom: 3px;
            font-size: 8.5px;
            color: #44403c;
            line-height: 1.4;
        }

        .deficit-none {
            font-style: italic;
            color: var(--green);
            font-size: 10px;
        }

        /* ── RECOMMENDATION LIST ── */
        .rec-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .rec-list li {
            display: flex;
            align-items: baseline;
            gap: 5px;
            margin-bottom: 3px;
            font-size: 10px;
            line-height: 1.4;
            color: var(--blue-act);
        }

        .rec-none {
            font-size: 10px;
            color: var(--slate);
            font-style: italic;
        }

        /* Row khusus tidak subur */
        tr.row-kritis td.name-col {
            color: var(--red);
        }

        /* ── FOOTER ── */
        .report-footer {
            margin-top: 22px;
            padding-top: 10px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-left {
            font-size: 10px;
            color: var(--ink-secondary);
        }

        .footer-right {
            font-size: 10px;
            color: var(--ink-secondary);
            text-align: right;
        }

        .footer-dot {
            display: inline-block;
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: var(--amber-accent);
            margin-right: 5px;
            vertical-align: middle;
        }
    </style>
</head>

<body>

    @php
    $total = count($data);
    $tidak = 0;
    $kurang = 0;
    foreach ($data as $block) {
    $st = optional($block->nutrients->first())->fertility_status ?? '';
    if ($st === 'Tidak Subur') $tidak++;
    if ($st === 'Kurang Subur') $kurang++;
    }

    $standards = [
    'nitrogen' => ['min' => 2.5, 'label' => 'Nitrogen (N)', 'unit' => '%'],
    'phosphorus' => ['min' => 15, 'label' => 'Fosfor (P)', 'unit' => 'ppm'],
    'potassium' => ['min' => 0.2, 'label' => 'Kalium (K)', 'unit' => 'cmol'],
    'ph' => ['min' => 5.5, 'label' => 'pH Tanah', 'unit' => ''],
    'organic_carbon' => ['min' => 1.5, 'label' => 'C-Organik', 'unit' => '%'],
    'magnesium' => ['min' => 0.25, 'label' => 'Magnesium (Mg)', 'unit' => 'cmol'],
    ];
    @endphp

    {{-- HEADER --}}
    <div class="report-header">
        <div class="header-inner">
            <div>
                <div class="brand-tag">AgriSmart &mdash; PTPN IV Regional III</div>
                <div class="report-title">Rekomendasi Pemupukan</div>
                <div class="report-subtitle">Daftar blok defisit hara beserta rekomendasi tindakan perbaikan</div>
            </div>
            <div class="header-right">
                <div class="header-meta">
                    <strong>Tanggal Cetak</strong><br>
                    {{ now()->format('d F Y') }}<br>
                    {{ now()->format('H:i') }} WIB
                </div>
            </div>
        </div>
    </div>

    {{-- SUMMARY BAND --}}
    <table class="summary-table">
        <tr>
            <td class="summary-cell">
                <div class="summary-num">{{ $total }}</div>
                <div class="summary-label">Total Blok</div>
            </td>

            <td class="summary-cell">
                <div class="summary-num red">{{ $tidak }}</div>
                <div class="summary-label">Tidak Subur</div>
            </td>

            <td class="summary-cell">
                <div class="summary-num amber">{{ $kurang }}</div>
                <div class="summary-label">Kurang Subur</div>
            </td>

            <td class="summary-note-cell">
                Laporan ini mencakup seluruh blok yang memerlukan intervensi pemupukan.
                Prioritaskan blok dengan status <strong>Tidak Subur</strong>
                untuk tindakan segera.
            </td>
        </tr>
    </table>

    {{-- SECTION HEADER --}}
    <div class="section-header">
        <span class="section-label">Detail Rekomendasi Per Blok</span>
        <div class="section-rule"></div>
    </div>

    {{-- TABLE --}}
    <table>
        <thead>
            <tr>
                <th>Nama Blok</th>
                <th>Status</th>
                <th>Unsur Defisit</th>
                <th>Rekomendasi Tindakan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $block)
            @php
            $n = $block->nutrients->first();
            $status = optional($n)->fertility_status ?? '-';
            $badgeClass = match($status) {
            'Tidak Subur' => 'badge-tidak',
            'Kurang Subur' => 'badge-kurang',
            'Subur' => 'badge-subur',
            default => '',
            };
            $isKritis = $status === 'Tidak Subur';

            $deficits = [];
            $recs = [];
            if ($n) {
            foreach ($standards as $field => $std) {
            $val = (float) ($n->$field ?? 0);
            if ($val < $std['min']) {
                $deficits[]="{$std['label']}: {$val} {$std['unit']} &mdash; standar min. {$std['min']}" ;
                $recs[]="Aplikasi pupuk {$std['label']} hingga mencapai &ge; {$std['min']} {$std['unit']}" ;
                }
                }
                }
                @endphp
                <tr class="{{ $isKritis ? 'row-kritis' : '' }}">
                <td class="name-col">
                    {{ $block->name }}
                    @if($block->area_ha)
                    <small>Luas: {{ $block->area_ha }} Ha</small>
                    @endif
                </td>
                <td class="status-col">
                    @if($badgeClass)
                    <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                    @else
                    {{ $status }}
                    @endif
                </td>
                <td>
                    @if(empty($deficits))
                    <span class="deficit-none">Tidak ada defisit terdeteksi</span>
                    @else
                    <ul class="deficit-list">
                        @foreach($deficits as $d)
                        <li>{!! $d !!}</li>
                        @endforeach
                    </ul>
                    @endif
                </td>
                <td>
                    @if(empty($recs))
                    <span class="rec-none">Pertahankan pemupukan standar rutin.</span>
                    @else
                    <ul class="rec-list">
                        @foreach($recs as $r)
                        <li>{!! $r !!}</li>
                        @endforeach
                    </ul>
                    @endif
                </td>
                </tr>
                @endforeach
        </tbody>
    </table>

    {{-- FOOTER --}}
    <div class="report-footer">
        <div class="footer-left">
            <span class="footer-dot"></span>
            Dokumen ini digenerate secara otomatis oleh sistem AgriSmart
        </div>
        <div class="footer-right">
            PTPN IV Regional III &mdash; {{ now()->format('Y') }}
        </div>
    </div>

</body>

</html>