<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Riwayat Pengukuran Hara</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap');

        :root {
            --indigo-dark: #1e1b4b;
            --indigo-mid: #3730a3;
            --indigo-accent: #4f46e5;
            --indigo-light: #e0e7ff;
            --indigo-subtle: #f5f3ff;
            --slate: #475569;
            --slate-light: #f8fafc;
            --amber: #b45309;
            --amber-bg: #fef3c7;
            --green: #15803d;
            --green-bg: #dcfce7;
            --red: #b91c1c;
            --red-bg: #fee2e2;
            --ink: #0f172a;
            --border: #e2e8f0;
            --border-accent: #a5b4fc;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            font-size: 9.5px;
            color: var(--ink);
            background: #fafbff;
            padding: 28px 32px;
            line-height: 1.5;
        }

        /* ── HEADER ── */
        .report-header {
            margin-bottom: 22px;
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding-bottom: 14px;
            border-bottom: 2px solid var(--indigo-accent);
        }

        .brand-line {
            font-size: 7.5px;
            font-weight: 700;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: var(--indigo-accent);
            margin-bottom: 5px;
        }

        .report-title {
            font-family: 'DM Serif Display', serif;
            font-size: 20px;
            color: var(--indigo-dark);
            margin-bottom: 3px;
            line-height: 1.2;
        }

        .report-subtitle {
            font-size: 9px;
            color: var(--slate);
            font-weight: 300;
        }

        .header-meta-box {
            text-align: right;
        }

        .meta-detail {
            font-size: 8.5px;
            color: var(--slate);
            line-height: 1.7;
        }

        .meta-detail strong {
            color: var(--ink);
            font-weight: 600;
        }

        /* ── INFO TABLE ── */
        .info-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 8px 0;
            margin-top: 12px;
            margin-bottom: 18px;
        }

        .info-table td {
            width: 25%;
            border: 1px solid var(--border-accent);
            border-radius: 6px;
            background: #fff;
            text-align: center;
            padding: 12px 10px;
        }

        .info-pill-label {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--indigo-mid);
            margin-bottom: 8px;
        }

        .info-pill-value {
            font-family: 'DM Serif Display', serif;
            font-size: 24px;
            font-weight: 700;
            line-height: 1;
            color: var(--indigo-dark);
        }

        /* ── TABLE ── */
        .section-header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .section-line {
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .section-label {
            font-size: 7.5px;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--slate);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            background: var(--indigo-dark);
        }

        thead th {
            background: #3730a3;
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

        thead th:nth-child(2) {
            text-align: left;
            padding-left: 8px;
        }

        tbody tr {
            border-bottom: 1px solid var(--border);
        }

        tbody tr:nth-child(even) {
            background: var(--indigo-subtle);
        }

        tbody tr:nth-child(odd) {
            background: #fff;
        }

        tbody td {
            padding: 6.5px 6px;
            text-align: center;
            font-size: 9px;
            color: var(--ink);
            vertical-align: middle;
        }

        /* Tanggal */
        td.date-col {
            text-align: left;
            padding-left: 12px;
            white-space: nowrap;
            color: var(--slate);
            font-size: 8.5px;
            font-weight: 600;
        }

        /* Nama blok */
        td.block-col {
            text-align: left;
            padding-left: 8px;
            font-weight: 600;
            color: var(--indigo-dark);
            font-size: 9.5px;
        }

        td.num {
            font-variant-numeric: tabular-nums;
            color: #334155;
        }

        /* Status */
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 7.5px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .badge-subur {
            background: var(--green-bg);
            color: var(--green);
        }

        .badge-kurang {
            background: var(--amber-bg);
            color: var(--amber);
        }

        .badge-tidak {
            background: var(--red-bg);
            color: var(--red);
        }

        /* ── DIVIDER TAHUN/BULAN (opsional grouping) ── */
        tr.group-divider td {
            background: var(--indigo-light);
            color: var(--indigo-mid);
            font-size: 7.5px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            padding: 4px 12px;
            text-align: left;
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
            background: var(--indigo-accent);
            margin-right: 5px;
            vertical-align: middle;
        }
    </style>
</head>

<body>

    @php
    $total = count($data);
    $subur = $data->where('fertility_status', 'Subur')->count();
    $kurang = $data->where('fertility_status', 'Kurang Subur')->count();
    $tidak = $data->where('fertility_status', 'Tidak Subur')->count();
    @endphp

    {{-- HEADER --}}
    <div class="report-header">
        <div class="header-top">
            <div>
                <div class="brand-line">AgriSmart &mdash; PTPN IV Regional III</div>
                <div class="report-title">Riwayat Pengukuran Unsur Hara</div>
                <div class="report-subtitle">Histori analisis tanah seluruh blok, diurutkan berdasarkan tanggal pengukuran</div>
            </div>
            <div class="header-meta-box">
                <div class="meta-detail">
                    <strong>Tanggal Cetak</strong><br>
                    {{ now()->format('d F Y') }}<br>
                    {{ now()->format('H:i') }} WIB
                </div>
            </div>
        </div>

        <table class="info-table">
            <tr>
                <td>
                    <div class="info-pill-label">Total Rekaman</div>
                    <div class="info-pill-value">{{ $total }}</div>
                </td>

                <td>
                    <div class="info-pill-label">Status Subur</div>
                    <div class="info-pill-value" style="color: var(--green);">
                        {{ $subur }}
                    </div>
                </td>

                <td>
                    <div class="info-pill-label">Kurang Subur</div>
                    <div class="info-pill-value" style="color: var(--amber);">
                        {{ $kurang }}
                    </div>
                </td>

                <td>
                    <div class="info-pill-label">Tidak Subur</div>
                    <div class="info-pill-value" style="color: var(--red);">
                        {{ $tidak }}
                    </div>
                </td>
            </tr>
        </table>
    </div>

    {{-- SECTION HEADER --}}
    <div class="section-header">
        <div class="section-label">Data Pengukuran</div>
        <div class="section-line"></div>
    </div>

    {{-- TABLE --}}
    <table>
        <thead>
            <tr>
                <th>Tgl Ukur</th>
                <th>Nama Blok</th>
                <th>N (%)</th>
                <th>P (ppm)</th>
                <th>K (cmol)</th>
                <th>pH</th>
                <th>EC (dS/m)</th>
                <th>C-Org (%)</th>
                <th>S (ppm)</th>
                <th>Mg (cmol)</th>
                <th>B (ppm)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $nutrient)
            @php
            $status = $nutrient->fertility_status ?? '-';
            $badgeClass = match($status) {
            'Subur' => 'badge-subur',
            'Kurang Subur' => 'badge-kurang',
            'Tidak Subur' => 'badge-tidak',
            default => '',
            };
            @endphp
            <tr>
                <td class="date-col">{{ $nutrient->measured_at ? $nutrient->measured_at->format('d/m/Y') : '-' }}</td>
                <td class="block-col">{{ $nutrient->block->name ?? '-' }}</td>
                <td class="num">{{ $nutrient->nitrogen ?? '-' }}</td>
                <td class="num">{{ $nutrient->phosphorus ?? '-' }}</td>
                <td class="num">{{ $nutrient->potassium ?? '-' }}</td>
                <td class="num">{{ $nutrient->ph ?? '-' }}</td>
                <td class="num">{{ $nutrient->ec ?? '-' }}</td>
                <td class="num">{{ $nutrient->organic_carbon ?? '-' }}</td>
                <td class="num">{{ $nutrient->s ?? '-' }}</td>
                <td class="num">{{ $nutrient->magnesium ?? '-' }}</td>
                <td class="num">{{ $nutrient->boron ?? '-' }}</td>
                <td>
                    @if($badgeClass)
                    <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                    @else
                    {{ $status }}
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