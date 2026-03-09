<div class="p-6 space-y-6 max-w-7xl mx-auto">
    <!-- Header Section with Global Filters -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 bg-white dark:bg-slate-800 p-8 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-700">
        <div class="space-y-1">
            <h1 class="text-3xl font-black text-slate-800 dark:text-slate-100 tracking-tight">Analitik Perkebunan</h1>
            <p class="text-slate-500 text-sm font-medium">Monitoring performa hara dan estimasi produksi real-time.</p>
        </div>
        
        <div class="flex flex-wrap items-center gap-3">
            <div class="space-y-1.5">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Tahun Analisis</label>
                <select wire:model.live="selectedYear" class="w-32 px-4 py-2.5 bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition-all">
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                </select>
            </div>
            
            <div class="space-y-1.5">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Kelompok Umur</label>
                <select wire:model.live="selectedAgeRange" class="w-40 px-4 py-2.5 bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition-all">
                    <option value="all">Semua Umur</option>
                    <option value="tbm">TBM (< 3 Thn)</option>
                    <option value="muda">TM Muda (3-7 Thn)</option>
                    <option value="prima">TM Prima (8-18 Thn)</option>
                    <option value="tua">TM Tua (> 18 Thn)</option>
                </select>
            </div>

            <div class="space-y-1.5">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Status Kesuburan</label>
                <select wire:model.live="selectedFertility" class="w-40 px-4 py-2.5 bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition-all">
                    <option value="all">Semua Status</option>
                    <option value="Subur">Subur</option>
                    <option value="Cukup Subur">Cukup Subur</option>
                    <option value="Kurang Subur">Kurang Subur</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Key Metrics Dashboard -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 p-6 rounded-[2rem] shadow-xl text-white">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total Est. Panen</p>
            <div class="flex items-center gap-2">
                <h3 class="text-3xl font-black">{{ number_format($summary['total_yield']) }}</h3>
                <span class="text-xs font-bold text-emerald-400">TON</span>
            </div>
            <div class="mt-4 pt-4 border-t border-white/10">
                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-tight">Tahun Anggaran {{ $selectedYear }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 p-6 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-700">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">Rata-rata Ton/Ha</p>
            <h3 class="text-3xl font-black text-slate-800 dark:text-slate-100">{{ number_format($summary['avg_ton_ha'], 1) }}</h3>
            <div class="mt-4 flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-[10px] text-emerald-600 font-bold">Performa Optimal</span>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 p-6 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-700">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">Blok Paling Produktif</p>
            <h3 class="text-xl font-black text-slate-800 dark:text-slate-100 truncate">{{ $summary['best_block']['name'] ?? '-' }}</h3>
            <p class="text-[11px] font-bold text-amber-600 mt-1">{{ number_format($summary['best_block']['yield'] ?? 0) }} Ton/Thn</p>
        </div>

        <div class="bg-white dark:bg-slate-800 p-6 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-700 border-l-4 border-l-rose-500">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">Prioritas Perbaikan</p>
            <h3 class="text-3xl font-black text-rose-600">{{ $summary['needs_improvement']->count() }}</h3>
            <p class="text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-tighter">Blok Kurang Subur</p>
        </div>
    </div>

    <!-- Charts Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Yield Estimation Chart -->
        <div class="bg-white dark:bg-slate-800 p-8 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-700">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h4 class="text-lg font-black text-slate-800 dark:text-slate-100 tracking-tight">Top 10 Estimasi Panen per Blok</h4>
                    <p class="text-xs text-slate-400 font-medium">Berdasarkan data terkini dan umur tanaman</p>
                </div>
            </div>

            <div class="space-y-5">
                @php $maxYield = $yieldChartData->max('yield') ?: 1; @endphp
                @foreach($yieldChartData as $data)
                    <div class="group">
                        <div class="flex justify-between items-end mb-1.5">
                            <span class="text-xs font-bold text-slate-600 dark:text-slate-300 tracking-tight group-hover:text-slate-900 transition-colors">{{ $data['name'] }}</span>
                            <span class="text-[11px] font-black text-slate-800 dark:text-slate-100">{{ number_format($data['yield']) }} <span class="text-slate-400 text-[9px] uppercase">Ton</span></span>
                        </div>
                        <div class="h-2.5 w-full bg-slate-50 dark:bg-slate-700/50 rounded-full overflow-hidden">
                            <div class="h-full bg-emerald-500 group-hover:bg-emerald-600 rounded-full transition-all duration-500 ease-out"
                                 style="width: {{ ($data['yield'] / $maxYield) * 100 }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Fertility Distribution Chart -->
        <div class="bg-white dark:bg-slate-800 p-8 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-700">
            <h4 class="text-lg font-black text-slate-800 dark:text-slate-100 tracking-tight mb-8">Distribusi Kesuburan Tanah</h4>
            
            <div class="flex flex-col items-center justify-center h-full space-y-12">
                <div class="relative w-48 h-48 flex items-center justify-center">
                    <!-- Semi-circle / Donut representation using CSS/SVG -->
                    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                        @php 
                            $total = array_sum($summary['distribution']);
                            $offset = 0;
                            $colors = ['Subur' => '#10b981', 'Cukup Subur' => '#f59e0b', 'Kurang Subur' => '#ef4444'];
                        @endphp
                        @foreach($summary['distribution'] as $status => $count)
                            @if($count > 0)
                                @php 
                                    $dashArray = ($count / ($total ?: 1)) * 100;
                                @endphp
                                <circle cx="50" cy="50" r="40" fill="transparent" stroke="{{ $colors[$status] }}" stroke-width="12"
                                        stroke-dasharray="{{ $dashArray }} {{ 100 - $dashArray }}" stroke-dashoffset="-{{ $offset }}" />
                                @php $offset += $dashArray; @endphp
                            @endif
                        @endforeach
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-3xl font-black text-slate-800 dark:text-slate-100">{{ $blocks->count() }}</span>
                        <span class="text-[10px] font-black text-slate-400 uppercase">Blok Terfilter</span>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-6 w-full max-w-sm">
                    @foreach($summary['distribution'] as $status => $count)
                        @php $color = $status === 'Subur' ? 'emerald' : ($status === 'Cukup Subur' ? 'amber' : 'rose'); @endphp
                        <div class="text-center group">
                            <div class="inline-flex items-center gap-1.5 mb-1 px-2 py-0.5 rounded-full bg-{{ $color }}-50 text-{{ $color }}-600 border border-{{ $color }}-100 group-hover:scale-105 transition-transform">
                                <span class="w-1.5 h-1.5 rounded-full bg-{{ $color }}-500"></span>
                                <span class="text-[9px] font-black uppercase tracking-tight">{{ $status }}</span>
                            </div>
                            <p class="text-xl font-black text-slate-800 dark:text-slate-100">{{ $count }}</p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase">{{ round(($count / ($total ?: 1)) * 100) }}%</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Insights Section: Needs Improvement -->
    <div class="bg-white dark:bg-slate-800 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
        <div class="p-8 border-b border-slate-50 dark:border-slate-700 flex items-center justify-between">
            <div>
                <h4 class="text-lg font-black text-slate-800 dark:text-slate-100 tracking-tight">Prioritas Perbaikan Unsur Hara</h4>
                <p class="text-xs text-slate-400 font-medium">Berdasarkan scoring terendah pada parameter Nitrogen, Fosfor, dan Kalium</p>
            </div>
            <button class="px-5 py-2.5 bg-rose-50 text-rose-700 text-xs font-black uppercase tracking-widest rounded-xl border border-rose-100 hover:bg-rose-100 transition-colors">
                Generate Maintenance Schedule
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-700/50">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Blok</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Defisit Hara</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Tanaman</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Potential Yield Loss</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($summary['needs_improvement'] as $block)
                    <tr class="group hover:bg-slate-50 dark:bg-slate-700/50 transition-colors">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-rose-500 flex items-center justify-center text-white font-black text-xs shadow-lg shadow-rose-100">
                                    {{ explode(' ', $block['name'])[1] }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800 dark:text-slate-100">{{ $block['name'] }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold tracking-tight">{{ $block['area_ha'] }} Ha • {{ $block['age_label'] }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <div class="flex justify-center gap-1">
                                @forelse($block['scores'] as $nutrient => $score)
                                    @if($score <= 1)
                                        <span class="px-2 py-0.5 bg-rose-50 text-rose-600 rounded-md text-[9px] font-black uppercase border border-rose-100">{{ $nutrient }}</span>
                                    @endif
                                @empty
                                    <span class="text-slate-300 text-[10px] font-bold">-</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <span class="text-xs font-bold text-slate-500 italic">{{ $block['age'] }} Tahun</span>
                        </td>
                        <td class="px-8 py-5 text-right font-black text-xs text-rose-500">
                            -{{ number_format($block['yield'] * 0.3) }} TON
                        </td>
                        <td class="px-8 py-5 text-right">
                             <a href="{{ route('block.detail', $block['id']) }}" wire:navigate class="text-slate-300 hover:text-slate-600 dark:text-slate-300 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                             </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-emerald-100 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <p class="text-slate-400 text-sm font-bold">Semua blok memenuhi standar hara minimal.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
