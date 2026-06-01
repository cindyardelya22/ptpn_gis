<div class="p-6 lg:p-8 space-y-6 max-w-7xl mx-auto">

    <!-- ══ HEADER & FILTERS ══ -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-white/5 shadow-sm p-6">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-100 tracking-tight">Analisis Kesuburan Tanah</h1>
                <p class="text-slate-400 dark:text-slate-500 text-sm mt-0.5">Monitoring kondisi hara dan rekomendasi pemupukan kelapa sawit.</p>
            </div>

            <div class="flex flex-wrap items-end gap-3">
                <!-- Status Kesuburan -->
                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Filter Status Kesuburan</label>
                    <div class="relative">
                        <select wire:model.live="selectedFertility"
                            class="pl-4 pr-8 py-2.5 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-700/50 focus:outline-none focus:border-emerald-400 transition appearance-none w-48">
                            <option value="all">Semua Status</option>
                            <option value="Subur">Subur</option>
                            <option value="Kurang Subur">Kurang Subur</option>
                            <option value="Tidak Subur">Tidak Subur</option>
                        </select>
                        <div class="absolute right-2.5 top-1/2 -translate-y-1/2 pointer-events-none">
                            <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ══ KEY METRICS ══ -->
    <div class="grid grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- Total Blok -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-slate-200 dark:border-white/5 shadow-sm border-t-2 border-t-blue-500">
            <div class="flex items-start justify-between mb-3">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Blok Dianalisis</p>
                <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                    style="background:rgba(59,130,246,.15)">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7l5-2.5 5.553 2.776a1 1 0 01.447.894v10.764a1 1 0 01-1.447.894L15 17l-6 3z" />
                    </svg>
                </div>
            </div>
            <h3 class="text-3xl font-black">{{ $summary['total_blocks'] }}</h3>
            <p class="text-[10px] text-slate-500 font-medium mt-2 uppercase tracking-wider">Memiliki data hara</p>
        </div>

        <!-- Persentase Subur -->
        <div
            class="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-slate-200 dark:border-white/5 shadow-sm border-t-2 border-t-emerald-500">
            <div class="flex items-start justify-between mb-3">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Tanah Subur</p>
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:#10b98115">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
            <div class="flex items-end gap-1.5">
                <h3 class="text-3xl font-black text-emerald-500">{{ $summary['fertile_pct'] }}</h3>
                <span class="text-xs font-bold text-emerald-500 mb-1.5">%</span>
            </div>
            <p class="text-[10px] text-slate-500 font-medium mt-2 uppercase tracking-wider">Dari total blok</p>
        </div>

        <!-- Blok Kritis -->
        <div
            class="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-slate-200 dark:border-white/5 shadow-sm border-t-2 border-t-rose-500">
            <div class="flex items-start justify-between mb-3">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Kondisi Kritis (Tidak Subur)</p>
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:#f43f5e15">
                    <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>
            <h3 class="text-3xl font-black text-rose-500">{{ $summary['critical_count'] }}</h3>
            <p class="text-[10px] text-slate-400 font-medium mt-2 uppercase tracking-wider">Perlu Pemupukan Intensif</p>
        </div>
    </div>

    <!-- ══ CHARTS GRID ══ -->
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-5">

        <!-- Rata-rata Unsur Hara (Bar Chart Simulation) -->
        <div
            class="lg:col-span-3 bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-white/5 shadow-sm p-6">
            <div class="mb-6">
                <h4 class="text-sm font-bold text-slate-700 dark:text-slate-200">Rata-rata Kandungan Hara</h4>
                <p class="text-[10px] text-slate-400 font-medium mt-0.5 uppercase tracking-wider">Berdasarkan blok yang difilter</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                @php
                    $nutrientsDisplay = [
                        'nitrogen'       => ['label' => 'Nitrogen (N)',    'unit' => 'mg/kg', 'min' => 320.00, 'max' => 354.50],
                        'phosphorus'     => ['label' => 'Fosfor (P)',      'unit' => 'mg/kg', 'min' => 12.15,  'max' => 20.60],
                        'potassium'      => ['label' => 'Kalium (K)',      'unit' => 'mg/kg', 'min' => 422.00, 'max' => 602.00],
                        'ph'             => ['label' => 'pH Tanah',        'unit' => '',       'min' => 7.38,   'max' => 7.81],
                        'ec'             => ['label' => 'EC',              'unit' => 'dS/m',  'min' => 0.42,   'max' => 0.62],
                        'organic_carbon' => ['label' => 'C-Organik (OC)', 'unit' => '%',      'min' => 0.47,   'max' => 0.88],
                        's'         => ['label' => 'Sulfur (S)',      'unit' => 'mg/kg', 'min' => 4.22,   'max' => 7.54],
                        'magnesium'      => ['label' => 'Magnesium (Mg)', 'unit' => 'cmol',  'min' => 1.90,   'max' => 2.61],
                        'boron'          => ['label' => 'Boron (B)',       'unit' => 'mg/kg', 'min' => 0.32,   'max' => 0.66],
                    ];
                @endphp
                @foreach ($nutrientsDisplay as $key => $n)
                    @php
                        $val       = $nutrientAvg[$key] ?? 0;
                        $isDeficit = $val < $n['min'];
                        $isExcess  = $val > $n['max'];
                        $range     = $n['max'] - $n['min'];

                        // Progress: 0% = 0, 100% = tepat di max zona aman
                        $pct = $range > 0 ? min(100, ($val / $n['max']) * 100) : 0;
                    @endphp
                    <div class="bg-slate-50 dark:bg-slate-700/30 p-4 rounded-xl border transition-all
                        {{ $isDeficit ? 'border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-900/10' :
                        ($isExcess  ? 'border-amber-200 dark:border-amber-800 bg-amber-50 dark:bg-amber-900/10' :
                                        'border-slate-100 dark:border-slate-700') }}">

                        <div class="flex justify-between items-start mb-1">
                            <p class="text-[10px] font-bold uppercase tracking-widest
                                {{ $isDeficit ? 'text-red-400' : ($isExcess ? 'text-amber-400' : 'text-slate-400') }}">
                                {{ $n['label'] }}
                            </p>
                            @if ($isDeficit || $isExcess)
                                <div class="w-1.5 h-1.5 rounded-full animate-pulse
                                    {{ $isDeficit ? 'bg-red-500' : 'bg-amber-500' }}"></div>
                            @endif
                        </div>

                        <div class="flex items-end gap-1 mb-2">
                            <span class="text-xl font-black
                                {{ $isDeficit ? 'text-red-500' : ($isExcess ? 'text-amber-500' : 'text-slate-800 dark:text-white') }}">
                                {{ $val }}
                            </span>
                            <span class="text-[10px] text-slate-400 font-medium mb-1">{{ $n['unit'] }}</span>
                        </div>

                        <div class="h-1.5 w-full bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-500
                                {{ $isDeficit ? 'bg-red-500' : ($isExcess ? 'bg-amber-500' : 'bg-emerald-500') }}"
                                style="width: {{ $pct }}%"></div>
                        </div>

                        <p class="text-[9px] text-slate-400 mt-1.5">
                            Zona aman: {{ $n['min'] }} – {{ $n['max'] }} {{ $n['unit'] }}
                        </p>

                        @if ($isDeficit)
                            <p class="text-[9px] font-bold text-red-500 mt-0.5">↓ Di bawah standar</p>
                        @elseif ($isExcess)
                            <p class="text-[9px] font-bold text-amber-500 mt-0.5">↑ Di atas standar</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Distribusi Kesuburan -->
        <div class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-white/5 shadow-sm p-6 flex flex-col">
            <div class="mb-6">
                <h4 class="text-sm font-bold text-slate-700 dark:text-slate-200">Distribusi Kesuburan</h4>
                <p class="text-[10px] text-slate-400 font-medium mt-0.5 uppercase tracking-wider">Proporsi status blok saat ini</p>
            </div>

            @php
                $total  = array_sum($summary['distribution']);
                $colors = ['Subur' => '#10b981', 'Kurang Subur' => '#f59e0b', 'Tidak Subur' => '#f43f5e'];
                $dist   = $summary['distribution'];

                $subur      = $dist['Subur'] ?? 0;
                $kurang     = $dist['Kurang Subur'] ?? 0;
                $tidakSubur = $dist['Tidak Subur'] ?? 0;
                $subPct     = $total > 0 ? round(($subur / $total) * 100) : 0;
                $kritPct    = $total > 0 ? round(($tidakSubur / $total) * 100) : 0;

                // Tentukan kondisi keseluruhan
                if ($subPct >= 70) {
                    $overallColor = 'emerald';
                    $overallIcon  = '✓';
                    $overallLabel = 'Kondisi Baik';
                    $overallDesc  = 'Mayoritas blok dalam kondisi subur optimal.';
                } elseif ($kritPct >= 40) {
                    $overallColor = 'rose';
                    $overallIcon  = '!';
                    $overallLabel = 'Perlu Perhatian';
                    $overallDesc  = 'Proporsi blok kritis cukup tinggi, segera lakukan pemupukan.';
                } else {
                    $overallColor = 'amber';
                    $overallIcon  = '~';
                    $overallLabel = 'Cukup';
                    $overallDesc  = 'Sebagian blok masih memerlukan pemupukan tambahan.';
                }
            @endphp

            <div class="flex flex-col sm:flex-row items-center gap-6">
                <!-- Donut -->
                <div class="relative shrink-0" style="width:160px;height:160px">
                    <svg id="fertility-donut" width="160" height="160" viewBox="0 0 180 180"
                        role="img" aria-label="Donut chart distribusi kesuburan blok kebun">
                        <circle cx="90" cy="90" r="62" fill="none"
                                stroke="#f1f5f9" stroke-width="26"/>
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                        <span id="donut-center-val"
                            class="text-3xl font-black text-slate-800 dark:text-white leading-none transition-colors duration-200">
                            {{ $summary['total_blocks'] }}
                        </span>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-1">Total Blok</span>
                    </div>
                </div>

                <!-- Legend -->
                <div class="flex-1 w-full space-y-2">
                    @foreach ($dist as $status => $count)
                        @php
                            $hex = $colors[$status];
                            $pct = $total > 0 ? round(($count / $total) * 100) : 0;
                        @endphp
                        <div class="flex items-center gap-3 p-2.5 rounded-xl border border-slate-100 dark:border-white/5
                                    hover:bg-slate-50 dark:hover:bg-white/[0.02] transition-colors cursor-default donut-legend-item"
                            data-count="{{ $count }}" data-color="{{ $hex }}">
                            <span class="w-2.5 h-2.5 rounded-sm shrink-0" style="background:{{ $hex }}"></span>
                            <span class="text-xs font-semibold text-slate-600 dark:text-slate-300 min-w-[85px]">{{ $status }}</span>
                            <div class="flex-1 h-1.5 bg-slate-100 dark:bg-slate-700 rounded-full overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-500 donut-bar"
                                    style="width:0%; background:{{ $hex }}" data-width="{{ $pct }}"></div>
                            </div>
                            <span class="text-[10px] font-bold text-slate-400 min-w-[52px] text-right">
                                {{ $count }} · {{ $pct }}%
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ══ INSIGHT SECTION ══ --}}
            <div class="mt-5 space-y-3">

                {{-- Overall status banner --}}
                <div class="flex items-center gap-3 p-3.5 rounded-xl
                    {{ $overallColor === 'emerald' ? 'bg-emerald-50 dark:bg-emerald-900/10 border border-emerald-100 dark:border-emerald-800/30' :
                    ($overallColor === 'rose'   ? 'bg-rose-50 dark:bg-rose-900/10 border border-rose-100 dark:border-rose-800/30' :
                                                    'bg-amber-50 dark:bg-amber-900/10 border border-amber-100 dark:border-amber-800/30') }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center font-black text-sm text-white shrink-0
                        {{ $overallColor === 'emerald' ? 'bg-emerald-500' :
                        ($overallColor === 'rose'   ? 'bg-rose-500' : 'bg-amber-500') }}">
                        {{ $overallIcon }}
                    </div>
                    <div>
                        <p class="text-xs font-black
                            {{ $overallColor === 'emerald' ? 'text-emerald-700 dark:text-emerald-400' :
                            ($overallColor === 'rose'   ? 'text-rose-700 dark:text-rose-400' : 'text-amber-700 dark:text-amber-400') }}">
                            {{ $overallLabel }}
                        </p>
                        <p class="text-[10px] leading-relaxed
                            {{ $overallColor === 'emerald' ? 'text-emerald-600 dark:text-emerald-500' :
                            ($overallColor === 'rose'   ? 'text-rose-600 dark:text-rose-500' : 'text-amber-600 dark:text-amber-500') }}">
                            {{ $overallDesc }}
                        </p>
                    </div>
                </div>

                {{-- Stat pills --}}
                <div class="grid grid-cols-3 gap-2">
                    <div class="flex flex-col items-center p-3 rounded-xl bg-emerald-50 dark:bg-emerald-900/10 border border-emerald-100 dark:border-emerald-800/20">
                        <span class="text-xl font-black text-emerald-600 dark:text-emerald-400">{{ $subur }}</span>
                        <span class="text-[9px] font-bold text-emerald-500 uppercase tracking-wider mt-0.5">Subur</span>
                    </div>
                    <div class="flex flex-col items-center p-3 rounded-xl bg-amber-50 dark:bg-amber-900/10 border border-amber-100 dark:border-amber-800/20">
                        <span class="text-xl font-black text-amber-600 dark:text-amber-400">{{ $kurang }}</span>
                        <span class="text-[9px] font-bold text-amber-500 uppercase tracking-wider mt-0.5 text-center leading-tight">Kurang</span>
                    </div>
                    <div class="flex flex-col items-center p-3 rounded-xl bg-rose-50 dark:bg-rose-900/10 border border-rose-100 dark:border-rose-800/20">
                        <span class="text-xl font-black text-rose-600 dark:text-rose-400">{{ $tidakSubur }}</span>
                        <span class="text-[9px] font-bold text-rose-500 uppercase tracking-wider mt-0.5 text-center leading-tight">Kritis</span>
                    </div>
                </div>

                {{-- Tip --}}
                @if ($tidakSubur > 0)
                <div class="flex items-start gap-2 p-3 rounded-xl bg-slate-50 dark:bg-slate-700/30 border border-slate-100 dark:border-white/5">
                    <svg class="w-3.5 h-3.5 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-[10px] text-slate-500 dark:text-slate-400 leading-relaxed">
                        Ada <strong class="text-rose-500">{{ $tidakSubur }} blok kritis</strong> yang memerlukan pemupukan intensif segera. Cek tabel prioritas di bawah.
                    </p>
                </div>
                @elseif ($kurang > 0)
                <div class="flex items-start gap-2 p-3 rounded-xl bg-slate-50 dark:bg-slate-700/30 border border-slate-100 dark:border-white/5">
                    <svg class="w-3.5 h-3.5 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-[10px] text-slate-500 dark:text-slate-400 leading-relaxed">
                        <strong class="text-amber-500">{{ $kurang }} blok</strong> perlu pemupukan minor untuk menyeimbangkan kadar N dan P.
                    </p>
                </div>
                @else
                <div class="flex items-start gap-2 p-3 rounded-xl bg-emerald-50 dark:bg-emerald-900/10 border border-emerald-100 dark:border-emerald-800/20">
                    <svg class="w-3.5 h-3.5 text-emerald-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-[10px] text-emerald-600 dark:text-emerald-400 leading-relaxed">
                        Semua blok dalam kondisi optimal. Pertahankan jadwal pemupukan rutin.
                    </p>
                </div>
                @endif

            </div>
        </div>
    </div>

    <!-- ══ PRIORITAS PERBAIKAN ══ -->
    <div
        class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-white/5 shadow-sm overflow-hidden">

        <!-- Table Header -->
        <div
            class="px-6 py-5 border-b border-slate-100 dark:border-white/5 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h4 class="text-sm font-bold text-slate-700 dark:text-slate-200">Blok Memerlukan Perbaikan Pemupukan</h4>
                <p class="text-[10px] text-slate-400 font-medium mt-0.5 uppercase tracking-wider">Blok dengan status Kurang Subur dan Tidak Subur</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-700/30">
                        <th class="px-6 py-3.5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Blok
                        </th>
                        <th
                            class="px-6 py-3.5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                            Status</th>
                        <th
                            class="px-6 py-3.5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                            Pengukuran Terakhir</th>
                        <th
                            class="px-6 py-3.5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-left">
                            Rekomendasi Utama</th>
                        <th class="px-6 py-3.5 w-14"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-white/5">
                    @forelse($summary['needs_improvement'] as $block)
                        <tr class="group hover:bg-slate-50 dark:hover:bg-white/[0.02] transition-colors duration-150 cursor-pointer"
                        x-data
                        @click="$refs.rowlink.click()">

                        {{-- Blok --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white font-black text-xs shrink-0"
                                    style="background:linear-gradient(135deg,{{ $block['status'] == 'Tidak Subur' ? '#f43f5e,#e11d48' : '#f59e0b,#d97706' }})">
                                    {{ explode(' ', $block['name'])[1] ?? substr($block['name'], 0, 2) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800 dark:text-slate-100">{{ $block['name'] }}</p>
                                    <p class="text-[10px] text-slate-400 font-medium">{{ $block['area_ha'] }} Ha</p>
                                </div>
                            </div>
                        </td>

                        {{-- Status --}}
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold
                                {{ $block['status'] == 'Tidak Subur'
                                    ? 'bg-rose-50 text-rose-700 border border-rose-200 dark:bg-rose-900/20 dark:text-rose-400 dark:border-rose-800'
                                    : 'bg-amber-50 text-amber-700 border border-amber-200 dark:bg-amber-900/20 dark:text-amber-400 dark:border-amber-800' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $block['status'] == 'Tidak Subur' ? 'bg-rose-500' : 'bg-amber-500' }}"></span>
                                {{ $block['status'] }}
                            </span>
                        </td>

                        {{-- Pengukuran Terakhir --}}
                        <td class="px-6 py-4 text-center">
                            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                                {{ $block['nutrients']['measured_at'] ?? '-' }}
                            </span>
                        </td>

                        {{-- Rekomendasi --}}
                        <td class="px-6 py-4 text-left">
                            <span class="text-xs text-slate-600 dark:text-slate-300">
                                {{ $block['status'] == 'Tidak Subur' ? 'Pemupukan NPK intensif & evaluasi lahan' : 'Pemupukan minor untuk menyeimbangkan N & P' }}
                            </span>
                        </td>

                        {{-- Arrow --}}
                        <td class="px-6 py-4">
                            <a href="{{ route('block.detail', $block['id']) }}" wire:navigate x-ref="rowlink"
                            class="w-7 h-7 rounded-lg flex items-center justify-center bg-slate-100 dark:bg-slate-700 text-slate-400 group-hover:bg-slate-800 dark:group-hover:bg-slate-600 group-hover:text-white transition-all duration-150 ml-auto">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center"
                                        style="background:#10b98112">
                                        <svg class="w-7 h-7 text-emerald-400/60" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <p class="text-slate-400 dark:text-slate-500 font-medium text-sm">Semua blok dalam kondisi subur (optimal).</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @php
        $donutData = collect($dist)->map(function($count, $status) use ($colors) {
            return [
                'label' => $status,
                'count' => $count,
                'color' => $colors[$status],
            ];
        })->values();
    @endphp

@push('scripts')
    <script>
        (function () {
            @php
                $donutData = collect($dist)->map(function($count, $status) use ($colors) {
                    return [
                        'label' => $status,
                        'count' => $count,
                        'color' => $colors[$status],
                    ];
                })->values();
            @endphp

            const data = @json($donutData);
            const total = {{ $total }};
            const R = 62, cx = 90, cy = 90, C = 2 * Math.PI * R;
            const svg = document.getElementById('fertility-donut');
            const centerEl = document.getElementById('donut-center-val');
            let offset = -Math.PI / 2;

            data.forEach(d => {
                const frac = d.count / (total || 1);
                const arcLen = frac * C - 3;
                const startAngle = offset + (1.5 / R);
                const endAngle = startAngle + arcLen / R;

                const x1 = cx + R * Math.cos(startAngle);
                const y1 = cy + R * Math.sin(startAngle);
                const x2 = cx + R * Math.cos(endAngle);
                const y2 = cy + R * Math.sin(endAngle);
                const largeArc = arcLen / R > Math.PI ? 1 : 0;

                const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
                path.setAttribute('d', `M ${x1} ${y1} A ${R} ${R} 0 ${largeArc} 1 ${x2} ${y2}`);
                path.setAttribute('fill', 'none');
                path.setAttribute('stroke', d.color);
                path.setAttribute('stroke-width', '26');
                path.setAttribute('stroke-linecap', 'round');
                path.style.cursor = 'pointer';
                path.style.transition = 'opacity .2s';

                path.addEventListener('mouseenter', () => {
                    centerEl.textContent = d.count;
                    centerEl.style.color = d.color;
                });
                path.addEventListener('mouseleave', () => {
                    centerEl.textContent = total;
                    centerEl.style.color = '';
                });

                svg.appendChild(path);
                offset += frac * 2 * Math.PI;
            });

            requestAnimationFrame(() => {
                document.querySelectorAll('.donut-bar').forEach(el => {
                    el.style.width = el.dataset.width + '%';
                });
            });

            document.querySelectorAll('.donut-legend-item').forEach(row => {
                row.addEventListener('mouseenter', () => {
                    centerEl.textContent = row.dataset.count;
                    centerEl.style.color = row.dataset.color;
                });
                row.addEventListener('mouseleave', () => {
                    centerEl.textContent = total;
                    centerEl.style.color = '';
                });
            });
        })();
    </script>
@endpush
</div>
