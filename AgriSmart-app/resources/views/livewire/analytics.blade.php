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
                        'nitrogen' => ['label' => 'Nitrogen (N)', 'unit' => '%', 'target' => 2.5],
                        'phosphorus' => ['label' => 'Fosfor (P)', 'unit' => 'ppm', 'target' => 15],
                        'potassium' => ['label' => 'Kalium (K)', 'unit' => 'cmol', 'target' => 0.2],
                        'ph' => ['label' => 'pH Tanah', 'unit' => '', 'target' => 5.5],
                        'organic_carbon' => ['label' => 'C-Organik', 'unit' => '%', 'target' => 1.5],
                        'magnesium' => ['label' => 'Magnesium (Mg)', 'unit' => 'cmol', 'target' => 0.25],
                    ];
                @endphp
                @foreach ($nutrientsDisplay as $key => $n)
                    @php 
                        $val = $nutrientAvg[$key] ?? 0;
                        $pct = $n['target'] > 0 ? min(100, ($val / $n['target']) * 100) : 0;
                        $isLow = $val < $n['target'];
                    @endphp
                    <div class="bg-slate-50 dark:bg-slate-700/30 p-4 rounded-xl border border-slate-100 dark:border-slate-700">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">{{ $n['label'] }}</p>
                        <div class="flex items-end gap-1 mb-2">
                            <span class="text-xl font-black {{ $isLow ? 'text-rose-500' : 'text-slate-800 dark:text-white' }}">{{ $val }}</span>
                            <span class="text-[10px] text-slate-400 font-medium mb-1">{{ $n['unit'] }}</span>
                        </div>
                        <!-- Progress Bar against target -->
                        <div class="h-1.5 w-full bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden">
                            <div class="h-full rounded-full {{ $isLow ? 'bg-rose-500' : 'bg-emerald-500' }}" style="width: {{ $pct }}%"></div>
                        </div>
                        <p class="text-[9px] text-slate-400 mt-1.5">Target: {{ $n['target'] }} {{ $n['unit'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Distribusi Kesuburan -->
        <div
            class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-white/5 shadow-sm p-6 flex flex-col">
            <div class="mb-6">
                <h4 class="text-sm font-bold text-slate-700 dark:text-slate-200">Distribusi Kesuburan</h4>
                <p class="text-[10px] text-slate-400 font-medium mt-0.5 uppercase tracking-wider">Proporsi status blok saat ini</p>
            </div>

            <!-- Donut Chart -->
            @php
                $total = array_sum($summary['distribution']);
                $offset = 25; 
                $circumference = 100.53; 
                $colors = ['Subur' => '#10b981', 'Kurang Subur' => '#f59e0b', 'Tidak Subur' => '#f43f5e'];
            @endphp
            <div class="flex justify-center mb-6">
                <div class="relative w-40 h-40">
                    <svg class="w-full h-full -rotate-90" viewBox="0 0 36 36">
                        <circle cx="18" cy="18" r="16" fill="none" stroke="#f1f5f9"
                            stroke-width="3.5" />
                        @foreach ($summary['distribution'] as $status => $count)
                            @if ($count > 0)
                                @php
                                    $pct = ($count / ($total ?: 1)) * $circumference;
                                    $gap = $circumference - $pct;
                                @endphp
                                <circle cx="18" cy="18" r="16" fill="none"
                                    stroke="{{ $colors[$status] }}" stroke-width="3.5"
                                    stroke-dasharray="{{ $pct }} {{ $gap }}"
                                    stroke-dashoffset="-{{ $offset }}" stroke-linecap="round" />
                                @php $offset += $pct; @endphp
                            @endif
                        @endforeach
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-2xl font-black text-slate-800 dark:text-white">{{ $summary['total_blocks'] }}</span>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Blok</span>
                    </div>
                </div>
            </div>

            <!-- Legend -->
            <div class="space-y-3 mt-auto">
                @foreach ($summary['distribution'] as $status => $count)
                    @php
                        $hex = $colors[$status];
                        $pct = round(($count / ($total ?: 1)) * 100);
                    @endphp
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <span class="w-2.5 h-2.5 rounded-full shrink-0"
                                style="background:{{ $hex }}"></span>
                            <span
                                class="text-xs font-semibold text-slate-600 dark:text-slate-300">{{ $status }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-20 h-1.5 bg-slate-100 dark:bg-slate-700 rounded-full overflow-hidden">
                                <div class="h-full rounded-full"
                                    style="width:{{ $pct }}%; background:{{ $hex }}"></div>
                            </div>
                            <span class="text-[10px] font-bold text-slate-400 w-12 text-right">{{ $count }}
                                ({{ $pct }}%)
                            </span>
                        </div>
                    </div>
                @endforeach
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
                        <tr class="group hover:bg-slate-50 dark:hover:bg-white/[0.02] transition-colors duration-150">

                            {{-- Blok --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white font-black text-xs shrink-0"
                                        style="background:linear-gradient(135deg,{{ $block['status'] == 'Tidak Subur' ? '#f43f5e,#e11d48' : '#f59e0b,#d97706' }})">
                                        {{ explode(' ', $block['name'])[1] ?? substr($block['name'], 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800 dark:text-slate-100">
                                            {{ $block['name'] }}</p>
                                        <p class="text-[10px] text-slate-400 font-medium">{{ $block['area_ha'] }} Ha</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold {{ $block['status'] == 'Tidak Subur' ? 'bg-rose-50 text-rose-700 border border-rose-200 dark:bg-rose-900/20 dark:text-rose-400 dark:border-rose-800' : 'bg-amber-50 text-amber-700 border border-amber-200 dark:bg-amber-900/20 dark:text-amber-400 dark:border-amber-800' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $block['status'] == 'Tidak Subur' ? 'bg-rose-500' : 'bg-amber-500' }}"></span>
                                    {{ $block['status'] }}
                                </span>
                            </td>

                            {{-- Pengukuran Terakhir --}}
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="text-xs font-semibold text-slate-500 dark:text-slate-400">{{ $block['nutrients']['measured_at'] ?? '-' }}</span>
                            </td>

                            {{-- Rekomendasi --}}
                            <td class="px-6 py-4 text-left">
                                <span class="text-xs text-slate-600 dark:text-slate-300">
                                    {{ $block['status'] == 'Tidak Subur' ? 'Pemupukan NPK intensif & evaluasi lahan' : 'Pemupukan minor untuk menyeimbangkan N & P' }}
                                </span>
                            </td>

                            {{-- Action --}}
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('block.detail', $block['id']) }}" wire:navigate
                                    class="w-8 h-8 rounded-lg flex items-center justify-center ml-auto transition-all duration-150 hover:scale-110 group-hover:opacity-100 opacity-0"
                                    style="background:rgba(16,185,129,.15);color:#10b981">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
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

</div>
