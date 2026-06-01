<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Rekap Kesuburan Tanah</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap');

        :root {
            --green-dark: #14532d;
            --green-mid: #166534;
            --green-accent: #16a34a;
            --green-light: #dcfce7;
            --green-subtle: #f0fdf4;
            --amber: #b45309;
            --amber-light: #fef3c7;
            --red: #b91c1c;
            --red-light: #fee2e2;
            --ink: #1a2a1e;
            --ink-secondary: #4b6355;
            --border: #d1fae5;
            --border-strong: #86efac;
            --bg-page: #f8fdf9;
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
            background: var(--bg-page);
            padding: 28px 32px;
            line-height: 1.5;
        }

        /* ── HEADER ── */
        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding-bottom: 18px;
            margin-bottom: 20px;
            border-bottom: 1.5px solid var(--border-strong);
        }

        .header-left {}

        .brand-tag {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--green-accent);
            margin-bottom: 6px;
        }

        .report-title {
            font-family: 'DM Serif Display', serif;
            font-size: 26px;
            color: var(--green-dark);
            line-height: 1.15;
            margin-bottom: 4px;
        }

        .report-subtitle {
            font-size: 11px;
            color: var(--ink-secondary);
            font-weight: 300;
        }

        .header-right {
            text-align: right;
        }

        .header-badge {
            display: inline-block;
            background: var(--green-dark);
            color: #fff;
            font-size: 8px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 4px 10px;
            border-radius: 3px;
            margin-bottom: 8px;
        }

        .header-meta {
            font-size: 11px;
            color: var(--ink-secondary);
            line-height: 1.8;
        }

        .header-meta strong {
            color: var(--ink);
            font-weight: 600;
        }

        /* ── STAT STRIP ── */
        .stat-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 8px 0;
            margin-bottom: 20px;
        }

        .stat-table td {
            width: 20%;
            border: 1px solid var(--border-strong);
            border-radius: 6px;
            background: #fff;
            text-align: center;
            padding: 10px;
        }

        .stat-label {
            font-size: 8px;
            text-transform: uppercase;
            color: var(--ink-secondary);
            margin-bottom: 8px;
        }

        .stat-value {
            font-size: 22px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            background: var(--green-dark);
        }

        thead th {
            background: #166534;
            color: #ffffff;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            padding: 8px 10px;
            text-align: left;
        }

        thead th:first-child {
            text-align: left;
            padding-left: 12px;
        }

        tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background 0.1s;
        }

        tbody tr:nth-child(even) {
            background: var(--green-subtle);
        }

        tbody tr:nth-child(odd) {
            background: #fff;
        }

        tbody td {
            padding: 7px 7px;
            text-align: center;
            font-size: 11px;
            color: var(--ink);
        }

        tbody td:first-child {
            text-align: left;
            padding-left: 12px;
            font-weight: 600;
            font-size: 11px;
            color: var(--green-dark);
        }

        /* Kolom tanggal */
        td.date-col {
            white-space: nowrap;
            color: var(--ink-secondary);
            font-size: 10px;
        }

        /* Numerik — subtle highlight jika rendah */
        td.num {
            font-variant-numeric: tabular-nums;
        }

        /* ── STATUS BADGES ── */
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .badge-subur {
            background: var(--green-light);
            color: var(--green-mid);
        }

        .badge-kurang {
            background: var(--amber-light);
            color: var(--amber);
        }

        .badge-tidak {
            background: var(--red-light);
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
            background: var(--green-accent);
            margin-right: 5px;
            vertical-align: middle;
        }
    </style>
</head>

<body>

    @php
    $total = count($data);
    $subur = 0; $kurang = 0; $tidak = 0;
    foreach ($data as $block) {
    $st = $block->nutrients->first()->fertility_status ?? '';
    if ($st === 'Subur') $subur++;
    elseif ($st === 'Kurang Subur') $kurang++;
    elseif ($st === 'Tidak Subur') $tidak++;
    }
    @endphp

    {{-- HEADER --}}
    <div class="report-header">
        <div class="header-left">
            <div class="brand-tag">AgriSmart &mdash; PTPN IV Regional III</div>
            <div class="report-title">Rekap Kesuburan Tanah</div>
            <div class="report-subtitle">Laporan status kesuburan seluruh blok berdasarkan pengukuran terbaru</div>
        </div>
        <div class="header-right">
            <div class="header-meta">
                <strong>Tanggal Cetak</strong><br>
                {{ now()->format('d F Y') }}<br>
                {{ now()->format('H:i') }} WIB
            </div>
        </div>
    </div>

    {{-- STAT STRIP --}}
    <table class="stat-table">
        <tr>
            <td>
                <div class="stat-label" style="text-align: center;">Total Blok</div>
                <div class="stat-value ink" style="text-align: center;">{{ $total }}</div>
            </td>
            <td>
                <div class="stat-label">Subur</div>
                <div class="stat-value green">{{ $subur }}</div>
            </td>
            <td>
                <div class="stat-label">Kurang Subur</div>
                <div class="stat-value amber">{{ $kurang }}</div>
            </td>
            <td>
                <div class="stat-label">Tidak Subur</div>
                <div class="stat-value red">{{ $tidak }}</div>
            </td>
            <td>
                <div class="stat-label">Tingkat Kesuburan</div>
                <div class="stat-value ink">
                    {{ $total > 0 ? round($subur / $total * 100) : 0 }}%
                </div>
            </td>
        </tr>
    </table>

    {{-- TABLE --}}
    <div class="section-label">Data Detail Per Blok</div>
    <table>
        <thead>
            <tr>
                <th>Nama Blok</th>
                <th>Tgl Ukur</th>
                <th>Status</th>
                <th>N (%)</th>
                <th>P (ppm)</th>
                <th>K (cmol)</th>
                <th>pH</th>
                <th>EC (dS/m)</th>
                <th>C-Org (%)</th>
                <th>S (ppm)</th>
                <th>Mg (cmol)</th>
                <th>B (ppm)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $block)
            @php
            $n = $block->nutrients->first();
            $status = $n->fertility_status ?? '-';
            $badgeClass = match($status) {
            'Subur' => 'badge-subur',
            'Kurang Subur' => 'badge-kurang',
            'Tidak Subur' => 'badge-tidak',
            default => '',
            };
            @endphp
            <tr>
                <td>{{ $block->name }}</td>
                <td class="date-col">{{ $n && $n->measured_at ? $n->measured_at->format('d/m/Y') : '-' }}</td>
                <td>
                    @if($badgeClass)
                    <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                    @else
                    {{ $status }}
                    @endif
                </td>
                <td class="num">{{ $n->nitrogen ?? '-' }}</td>
                <td class="num">{{ $n->phosphorus ?? '-' }}</td>
                <td class="num">{{ $n->potassium ?? '-' }}</td>
                <td class="num">{{ $n->ph ?? '-' }}</td>
                <td class="num">{{ $n->ec ?? '-' }}</td>
                <td class="num">{{ $n->organic_carbon ?? '-' }}</td>
                <td class="num">{{ $n->s ?? '-' }}</td>
                <td class="num">{{ $n->magnesium ?? '-' }}</td>
                <td class="num">{{ $n->boron ?? '-' }}</td>
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