<div class="max-w-7xl mx-auto p-6 space-y-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" wire:navigate class="p-2 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-500 hover:text-slate-900 dark:hover:text-white transition bg-white dark:bg-slate-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Detail Analisis Blok</h1>
                    <p class="text-slate-500 text-sm mt-1">Review kesuburan hara, estimasi panen, dan rekomendasi agronomi.</p>
                </div>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold uppercase tracking-wider border
                @if(($analysis['color'] ?? 'slate') == 'emerald') bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 border-emerald-200 dark:border-emerald-800
                @elseif(($analysis['color'] ?? 'slate') == 'amber') bg-amber-50 dark:bg-amber-900/30 text-amber-600 border-amber-200 dark:border-amber-800
                @else bg-rose-50 dark:bg-rose-900/30 text-rose-600 border-rose-200 dark:border-rose-800 @endif
            ">
                <span class="w-2 h-2 rounded-full mr-2 
                    @if(($analysis['color'] ?? 'slate') == 'emerald') bg-emerald-500 
                    @elseif(($analysis['color'] ?? 'slate') == 'amber') bg-amber-500 
                    @else bg-rose-500 @endif"></span>
                Status: {{ $analysis['status'] ?? 'N/A' }}
            </span>
        </div>
    </div>

    <!-- Main Overview Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Identity Card -->
        <div class="bg-white dark:bg-slate-800 p-8 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-700 flex flex-col justify-center">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-white font-black text-2xl shadow-lg shadow-slate-200 dark:shadow-slate-900 bg-gradient-to-br from-slate-700 to-slate-900 dark:from-slate-600 dark:to-slate-800">
                    {{ explode(' ', $block->name)[1] ?? substr($block->name, 0, 2) }}
                </div>
                <div>
                    <h2 class="text-2xl font-black text-slate-800 dark:text-white">{{ $block->name }}</h2>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mt-1">Tahun Tanam: {{ $block->planted_at ? $block->planted_at->format('Y') : '-' }}</p>
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div class="p-4 bg-slate-50 dark:bg-slate-700/50 rounded-2xl border border-slate-100 dark:border-slate-700">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Luas Area</p>
                    <p class="text-lg font-bold text-slate-800 dark:text-white">{{ number_format($block->area_ha, 2) }} Ha</p>
                </div>
                <div class="p-4 bg-slate-50 dark:bg-slate-700/50 rounded-2xl border border-slate-100 dark:border-slate-700">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Umur Tanaman</p>
                    <p class="text-lg font-bold text-slate-800 dark:text-white">{{ $prediction['age_years'] ?? '-' }} Thn</p>
                </div>
            </div>
        </div>

        <!-- Yield Potential Card -->
        <div class="lg:col-span-2 bg-gradient-to-br from-slate-800 to-slate-900 p-8 rounded-[2rem] shadow-xl text-white relative overflow-hidden">
            @php
                $baseYield = $prediction['base_max_yield'] ?? 0;
                $actualYield = $prediction['total_annual_ton'] ?? 0;
                $yieldLoss = $baseYield - $actualYield;
                $lossPercentage = $baseYield > 0 ? ($yieldLoss / $baseYield) * 100 : 0;
            @endphp
            <div class="relative z-10 flex flex-col md:flex-row gap-8 justify-between">
                <div>
                    <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Estimasi Panen Berjalan</p>
                    <div class="flex items-end gap-3 mb-6">
                        <h3 class="text-5xl font-black text-white">{{ number_format($actualYield) }}</h3>
                        <span class="text-lg font-bold text-slate-400 mb-1">TON / Tahun</span>
                    </div>
                    
                    <div class="flex flex-col gap-1.5">
                        <p class="text-sm font-bold text-slate-300">Target Potensi Maksimal: <span class="text-white">{{ number_format($baseYield) }} Ton</span></p>
                        <p class="text-sm font-bold text-slate-300">Efisiensi Lahan Aktual: <span class="text-white">{{ number_format($prediction['ton_per_ha'] ?? 0, 1) }} Ton/Ha</span></p>
                    </div>
                </div>
                
                <div class="md:w-64 p-6 bg-red-500/10 border border-red-500/20 rounded-2xl backdrop-blur-md self-center relative flex-shrink-0">
                    <p class="text-[10px] font-black text-red-300 uppercase tracking-widest mb-2 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Potensi Yield Loss
                    </p>
                    <h4 class="text-3xl font-black text-red-400 mb-1">{{ number_format($yieldLoss) }} <span class="text-sm">TON</span></h4>
                    <p class="text-xs font-bold text-red-300/80">Karena defisiensi hara ({{ number_format($lossPercentage, 1) }}%)</p>
                </div>
            </div>
            
            <!-- Abstract background shape -->
            <div class="absolute -right-20 -bottom-20 w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
        </div>
    </div>

    <!-- Diagnostic and Explanation -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Nutrient Breakdown -->
        <div class="bg-white dark:bg-slate-800 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
            <div class="p-6 border-b border-slate-50 dark:border-slate-700/50">
                <h3 class="text-lg font-black text-slate-800 dark:text-white tracking-tight">Kadar Unsur Hara Terbaru</h3>
                <p class="text-[10px] text-slate-400 uppercase tracking-widest mt-1 font-bold">Diukur pada: {{ $latestNutrient ? $latestNutrient->measured_at->format('d M Y') : '-' }}</p>
            </div>
            
            <div class="p-6 grid grid-cols-2 md:grid-cols-3 gap-4">
                @php
                    $nutrientsList = [
                        ['label' => 'Nitrogen (N)', 'value' => $latestNutrient->nitrogen ?? 0, 'unit' => '%', 'min' => 2.5, 'score_key' => 'Nitrogen'],
                        ['label' => 'Fosfor (P)', 'value' => $latestNutrient->phosphorus ?? 0, 'unit' => 'ppm', 'min' => 15, 'score_key' => 'Fosfor'],
                        ['label' => 'Kalium (K)', 'value' => $latestNutrient->potassium ?? 0, 'unit' => 'cmol', 'min' => 0.2, 'score_key' => 'Kalium'],
                        ['label' => 'pH Tanah', 'value' => $latestNutrient->ph ?? 0, 'unit' => '', 'min' => 5.5, 'score_key' => 'pH'],
                        ['label' => 'Magnesium (Mg)', 'value' => $latestNutrient->magnesium ?? 0, 'unit' => 'cmol', 'min' => 0.25, 'score_key' => 'Magnesium'],
                        ['label' => 'C-Organik', 'value' => $latestNutrient->organic_carbon ?? 0, 'unit' => '%', 'min' => 1.5, 'score_key' => 'C-Org'],
                    ];
                @endphp
                
                @foreach($nutrientsList as $nut)
                    @php 
                        $isDeficit = $nut['value'] < $nut['min']; 
                        $score = $analysis['scores'][$nut['score_key']] ?? null;
                    @endphp
                    <div class="p-4 rounded-2xl border transition-all {{ $isDeficit ? 'bg-red-50 dark:bg-red-900/10 border-red-200 dark:border-red-800' : 'bg-slate-50 dark:bg-slate-700/50 border-slate-100 dark:border-slate-700' }}">
                        <div class="flex justify-between items-start mb-2">
                            <p class="text-[10px] font-black {{ $isDeficit ? 'text-red-500 dark:text-red-400' : 'text-slate-500 dark:text-slate-400' }} uppercase tracking-widest">{{ $nut['label'] }}</p>
                            @if($isDeficit)
                                <div class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></div>
                            @endif
                        </div>
                        <div class="flex items-end gap-1">
                            <p class="text-xl font-black {{ $isDeficit ? 'text-red-600 dark:text-red-400' : 'text-slate-800 dark:text-white' }}">{{ number_format($nut['value'], 2) }}</p>
                            <span class="text-[10px] font-bold text-slate-400 mb-1">{{ $nut['unit'] }}</span>
                        </div>
                        @if($isDeficit)
                            <p class="text-[9px] font-bold text-red-500 dark:text-red-400 mt-2">Di bawah standar ({{ $nut['min'] }})</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Analysis & Recommendation -->
        <div class="flex flex-col gap-6">
            
            <div class="bg-amber-50 dark:bg-amber-900/10 rounded-[2rem] p-8 border border-amber-200 dark:border-amber-800/50 shadow-sm flex-1">
                <h3 class="text-sm font-black text-amber-800 dark:text-amber-500 uppercase tracking-widest mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Diagnosis Kegagalan Hara
                </h3>
                
                @php
                    $deficits = [];
                    foreach($nutrientsList as $nut) {
                        if($nut['value'] < $nut['min']) {
                            $deficits[] = $nut['label'];
                        }
                    }
                @endphp
                
                <p class="text-sm font-medium text-amber-900 dark:text-amber-200/80 leading-relaxed mb-4">
                    Berdasarkan sampel tanah terakhir, blok ini mengindikasikan 
                    @if(count($deficits) > 0)
                        defisiensi pada unsur <strong class="font-bold text-amber-700 dark:text-amber-400">{{ implode(', ', $deficits) }}</strong>. 
                        Kekurangan hara ini secara langsung menghambat pertumbuhan vegetatif dan mengganggu pembentukan tandan buah sawit (TBS), sehingga lahan tidak dapat mencapai potensi optimal sesuai umurnya (mengakibatkan penurunan tonase).
                    @else
                        kondisi kesuburan yang sudah mencapai standar minimal perkebunan di seluruh parameter. Tanaman dapat tumbuh secara optimal.
                    @endif
                </p>
            </div>

            <div class="bg-emerald-50 dark:bg-emerald-900/10 rounded-[2rem] p-8 border border-emerald-200 dark:border-emerald-800/50 shadow-sm flex-1">
                <h3 class="text-sm font-black text-emerald-800 dark:text-emerald-500 uppercase tracking-widest mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Rekomendasi Agronomi
                </h3>
                <ul class="space-y-3">
                    @if(count($deficits) > 0)
                        @foreach($deficits as $def)
                            <li class="flex items-start gap-3 text-sm font-medium text-emerald-900 dark:text-emerald-200/80 leading-relaxed">
                                <span class="w-5 h-5 rounded-full bg-emerald-200 dark:bg-emerald-800 text-emerald-700 dark:text-emerald-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </span>
                                <span>Lakukan pemberian pupuk tambahan yang difokuskan pada pengembalian nilai standar <strong>{{ $def }}</strong>.</span>
                            </li>
                        @endforeach
                            <li class="flex items-start gap-3 text-sm font-medium text-emerald-900 dark:text-emerald-200/80 leading-relaxed">
                                <span class="w-5 h-5 rounded-full bg-emerald-200 dark:bg-emerald-800 text-emerald-700 dark:text-emerald-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </span>
                                <span>Tingkatkan pengawasan terhadap serangan hama sekunder yang sering menyerang kelapa sawit pada kondisi tanah inferior.</span>
                            </li>
                    @else
                        <li class="flex items-start gap-3 text-sm font-medium text-emerald-900 dark:text-emerald-200/80 leading-relaxed">
                            <span class="w-5 h-5 rounded-full bg-emerald-200 dark:bg-emerald-800 text-emerald-700 dark:text-emerald-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </span>
                            <span>Pertahankan dosis pemupukan reguler sesuai jadwal standar pemeliharaan estate.</span>
                        </li>
                    @endif
                </ul>
            </div>
            
        </div>
    </div>
</div>
