<div class="p-6 lg:p-8 space-y-6 max-w-7xl mx-auto">

    <!-- ══ HEADER & FILTERS ══ -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-white/5 shadow-sm p-6">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-100 tracking-tight">Analitik Perkebunan</h1>
                <p class="text-slate-400 dark:text-slate-500 text-sm mt-0.5">Monitoring performa hara dan estimasi
                    produksi real-time.</p>
            </div>

            <div class="flex flex-wrap items-end gap-3">
                <!-- Tahun -->
                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tahun</label>
                    <div class="relative">
                        <select wire:model.live="selectedYear"
                            class="pl-4 pr-8 py-2.5 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-700/50 focus:outline-none focus:border-emerald-400 transition appearance-none w-28">
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
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

                <!-- Kelompok Umur -->
                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Kelompok
                        Umur</label>
                    <div class="relative">
                        <select wire:model.live="selectedAgeRange"
                            class="pl-4 pr-8 py-2.5 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-700/50 focus:outline-none focus:border-emerald-400 transition appearance-none w-44">
                            <option value="all">Semua Umur</option>
                            <option value="tbm">TBM (&lt; 3 Thn)</option>
                            <option value="muda">TM Muda (3–7 Thn)</option>
                            <option value="prima">TM Prima (8–18 Thn)</option>
                            <option value="tua">TM Tua (&gt; 18 Thn)</option>
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

                <!-- Status Kesuburan -->
                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Status
                        Kesuburan</label>
                    <div class="relative">
                        <select wire:model.live="selectedFertility"
                            class="pl-4 pr-8 py-2.5 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-700/50 focus:outline-none focus:border-emerald-400 transition appearance-none w-44">
                            <option value="all">Semua Status</option>
                            <option value="Subur">Subur</option>
                            <option value="Cukup Subur">Cukup Subur</option>
                            <option value="Kurang Subur">Kurang Subur</option>
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
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

        <!-- Total Panen -->
        <div class="rounded-2xl p-5 text-white relative overflow-hidden col-span-1"
            style="background:linear-gradient(135deg,#0f172a,#1e293b)">
            <div class="flex items-start justify-between mb-3">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Est. Panen</p>
                <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                    style="background:rgba(16,185,129,.15)">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
            </div>
            <div class="flex items-end gap-1.5">
                <h3 class="text-3xl font-black">{{ number_format($summary['total_yield']) }}</h3>
                <span class="text-xs font-bold text-emerald-400 mb-1">TON</span>
            </div>
            <p class="text-[10px] text-slate-500 font-medium mt-2 uppercase tracking-wider">Tahun {{ $selectedYear }}
            </p>
        </div>

        <!-- Rata-rata Ton/Ha -->
        <div
            class="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-slate-200 dark:border-white/5 shadow-sm border-t-2 border-t-emerald-500">
            <div class="flex items-start justify-between mb-3">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Rata-rata Ton/Ha</p>
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:#10b98115">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
            </div>
            <h3 class="text-3xl font-black text-slate-800 dark:text-white">
                {{ number_format($summary['avg_ton_ha'], 1) }}</h3>
            <div class="flex items-center gap-1.5 mt-2">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-[10px] text-emerald-600 font-bold">Performa Optimal</span>
            </div>
        </div>

        <!-- Blok Paling Produktif -->
        <div
            class="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-slate-200 dark:border-white/5 shadow-sm border-t-2 border-t-amber-500">
            <div class="flex items-start justify-between mb-3">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Blok Terbaik</p>
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:#f59e0b15">
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                    </svg>
                </div>
            </div>
            <h3 class="text-xl font-black text-slate-800 dark:text-white truncate">
                {{ $summary['best_block']['name'] ?? '-' }}</h3>
            <p class="text-[10px] text-amber-600 font-bold mt-2">
                {{ number_format($summary['best_block']['yield'] ?? 0) }} Ton / Tahun</p>
        </div>

        <!-- Prioritas Perbaikan -->
        <div
            class="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-slate-200 dark:border-white/5 shadow-sm border-t-2 border-t-rose-500">
            <div class="flex items-start justify-between mb-3">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Perlu Perbaikan</p>
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:#f43f5e15">
                    <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>
            <h3 class="text-3xl font-black text-rose-500">{{ $summary['needs_improvement']->count() }}</h3>
            <p class="text-[10px] text-slate-400 font-medium mt-2 uppercase tracking-wider">Blok Kurang Subur</p>
        </div>
    </div>

    <!-- ══ CHARTS GRID ══ -->
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-5">

        <!-- Top 10 Yield — lebih lebar -->
        <div
            class="lg:col-span-3 bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-white/5 shadow-sm p-6">
            <div class="mb-6">
                <h4 class="text-sm font-bold text-slate-700 dark:text-slate-200">Top 10 Estimasi Panen per Blok</h4>
                <p class="text-[10px] text-slate-400 font-medium mt-0.5 uppercase tracking-wider">Berdasarkan data
                    terkini dan umur tanaman</p>
            </div>

            <div class="space-y-4">
                @php $maxYield = $yieldChartData->max('yield') ?: 1; @endphp
                @foreach ($yieldChartData as $i => $data)
                    <div class="group flex items-center gap-4">
                        <span
                            class="text-[10px] font-black text-slate-300 dark:text-slate-600 w-4 text-right shrink-0">{{ $i + 1 }}</span>
                        <div class="flex-1">
                            <div class="flex justify-between items-center mb-1.5">
                                <span
                                    class="text-xs font-bold text-slate-600 dark:text-slate-300">{{ $data['name'] }}</span>
                                <span class="text-xs font-black text-slate-800 dark:text-slate-100">
                                    {{ number_format($data['yield']) }}
                                    <span class="text-[9px] text-slate-400 font-medium ml-0.5">TON</span>
                                </span>
                            </div>
                            <div class="h-2 w-full bg-slate-100 dark:bg-slate-700 rounded-full overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-500 ease-out"
                                    style="width:{{ ($data['yield'] / $maxYield) * 100 }}%; background:linear-gradient(90deg,#10b981,#059669)">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Distribusi Kesuburan — lebih sempit -->
        <div
            class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-white/5 shadow-sm p-6 flex flex-col">
            <div class="mb-6">
                <h4 class="text-sm font-bold text-slate-700 dark:text-slate-200">Distribusi Kesuburan</h4>
                <p class="text-[10px] text-slate-400 font-medium mt-0.5 uppercase tracking-wider">Proporsi status blok
                    saat ini</p>
            </div>

            <!-- Donut Chart -->
            @php
                $total = array_sum($summary['distribution']);
                $offset = 25; // start from top (circumference/4)
                $circumference = 100.53; // 2π×16 (r=16)
                $colors = ['Subur' => '#10b981', 'Cukup Subur' => '#f59e0b', 'Kurang Subur' => '#f43f5e'];
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
                        <span class="text-2xl font-black text-slate-800 dark:text-white">{{ $blocks->count() }}</span>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Blok</span>
                    </div>
                </div>
            </div>

            <!-- Legend -->
            <div class="space-y-3 mt-auto">
                @foreach ($summary['distribution'] as $status => $count)
                    @php
                        $color = $status === 'Subur' ? 'emerald' : ($status === 'Cukup Subur' ? 'amber' : 'rose');
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
                <h4 class="text-sm font-bold text-slate-700 dark:text-slate-200">Prioritas Perbaikan Unsur Hara</h4>
                <p class="text-[10px] text-slate-400 font-medium mt-0.5 uppercase tracking-wider">Berdasarkan scoring
                    terendah pada Nitrogen, Fosfor, dan Kalium</p>
            </div>
            <button
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold border transition-all hover:scale-105 active:scale-95 self-start sm:self-auto"
                style="background:rgba(244,63,94,.08);color:#e11d48;border-color:rgba(244,63,94,.2)">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Generate Schedule
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-700/30">
                        <th class="px-6 py-3.5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Blok
                        </th>
                        <th
                            class="px-6 py-3.5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                            Defisit Hara</th>
                        <th
                            class="px-6 py-3.5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                            Umur</th>
                        <th
                            class="px-6 py-3.5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">
                            Potential Yield Loss</th>
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
                                        style="background:linear-gradient(135deg,#f43f5e,#e11d48)">
                                        {{ explode(' ', $block['name'])[1] ?? substr($block['name'], 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800 dark:text-slate-100">
                                            {{ $block['name'] }}</p>
                                        <p class="text-[10px] text-slate-400 font-medium">{{ $block['area_ha'] }} Ha
                                            &middot; {{ $block['age_label'] }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Defisit --}}
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-1 flex-wrap">
                                    @forelse($block['scores'] as $nutrient => $score)
                                        @if ($score <= 1)
                                            <span
                                                class="px-2 py-0.5 rounded-md text-[9px] font-black uppercase tracking-wider"
                                                style="background:rgba(244,63,94,.1);color:#e11d48;border:1px solid rgba(244,63,94,.2)">
                                                {{ $nutrient }}
                                            </span>
                                        @endif
                                    @empty
                                        <span class="text-slate-300 dark:text-slate-600 text-[10px]">—</span>
                                    @endforelse
                                </div>
                            </td>

                            {{-- Umur --}}
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="text-xs font-semibold text-slate-500 dark:text-slate-400">{{ $block['age'] }}
                                    Tahun</span>
                            </td>

                            {{-- Yield Loss --}}
                            <td class="px-6 py-4 text-right">
                                <span
                                    class="text-sm font-black text-rose-500">−{{ number_format($block['yield'] * 0.3) }}</span>
                                <span class="text-[9px] text-slate-400 font-bold ml-1 uppercase">Ton</span>
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
                                    <p class="text-slate-400 dark:text-slate-500 font-medium text-sm">Semua blok
                                        memenuhi standar hara minimal.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
