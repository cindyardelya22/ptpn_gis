<div class="max-w-7xl mx-auto p-6 space-y-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <div class="flex items-center gap-3">
                <a href="{{ url()->previous() }}" wire:navigate
                    class="p-2 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-500 hover:text-slate-900 dark:hover:text-white transition bg-white dark:bg-slate-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Detail Analisis Blok
                    </h1>
                    <p class="text-slate-500 text-sm mt-1">Review detail unsur hara dan rekomendasi pemupukan lahan.</p>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <span
                class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold uppercase tracking-wider border
                @if (($analysis['color'] ?? 'slate') == 'emerald') bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 border-emerald-200 dark:border-emerald-800
                @elseif(($analysis['color'] ?? 'slate') == 'amber') bg-amber-50 dark:bg-amber-900/30 text-amber-600 border-amber-200 dark:border-amber-800
                @else bg-rose-50 dark:bg-rose-900/30 text-rose-600 border-rose-200 dark:border-rose-800 @endif
            ">
                <span
                    class="w-2 h-2 rounded-full mr-2 
                    @if (($analysis['color'] ?? 'slate') == 'emerald') bg-emerald-500 
                    @elseif(($analysis['color'] ?? 'slate') == 'amber') bg-amber-500 
                    @else bg-rose-500 @endif"></span>
                Status: {{ $analysis['status'] ?? 'N/A' }}
            </span>
        </div>
    </div>

    <!-- Main Overview Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Identity Card -->
        <div
            class="bg-white dark:bg-slate-800 p-8 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-700 flex flex-col justify-center">
            <div class="flex items-center gap-4 mb-6">
                <div
                    class="w-16 h-16 rounded-2xl flex items-center justify-center text-white font-black text-2xl shadow-lg shadow-slate-200 dark:shadow-slate-900 bg-gradient-to-br from-slate-700 to-slate-900 dark:from-slate-600 dark:to-slate-800">
                    {{ explode(' ', $block->name)[1] ?? substr($block->name, 0, 2) }}
                </div>
                <div>
                    <h2 class="text-2xl font-black text-slate-800 dark:text-white">{{ $block->name }}</h2>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mt-1">Tahun Tanam:
                        {{ $block->planted_at ? $block->planted_at->format('Y') : '-' }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4">
                <div
                    class="p-4 bg-slate-50 dark:bg-slate-700/50 rounded-2xl border border-slate-100 dark:border-slate-700">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Luas Area</p>
                    <p class="text-lg font-bold text-slate-800 dark:text-white">{{ number_format($block->area_ha, 2) }}
                        Ha</p>
                </div>
            </div>
        </div>

        <!-- Fertility Status Card with Probabilities -->
        <div
            class="lg:col-span-2 p-8 rounded-[2rem] shadow-xl text-white relative overflow-hidden
            @if (($analysis['color'] ?? 'slate') == 'emerald') bg-gradient-to-br from-emerald-600 to-emerald-900
            @elseif(($analysis['color'] ?? 'slate') == 'amber') bg-gradient-to-br from-amber-600 to-amber-900
            @else bg-gradient-to-br from-rose-600 to-rose-900 @endif
            ">
            <div class="relative z-10 flex flex-col md:flex-row gap-8 justify-between">
                <div class="flex-1">
                    <p class="text-[11px] font-black text-white/70 uppercase tracking-[0.2em] mb-4">Hasil Klasifikasi AI</p>
                    <div class="flex items-end gap-3 mb-6">
                        <h3 class="text-4xl font-black text-white">{{ $analysis['status'] ?? 'N/A' }}</h3>
                    </div>

                    <div class="flex flex-col gap-2 mt-4">
                        <p class="text-sm font-bold text-white/80">Probabilitas Machine Learning:</p>
                        <div class="grid gap-3">
                            @if(isset($analysis['probabilities']) && is_array($analysis['probabilities']) && count($analysis['probabilities']) > 0)
                                @foreach($analysis['probabilities'] as $status => $prob)
                                <div>
                                    <div class="flex justify-between text-xs font-bold mb-1">
                                        <span>{{ $status }}</span>
                                        <span>{{ round($prob * 100, 1) }}%</span>
                                    </div>
                                    <div class="h-2 w-full bg-black/20 rounded-full overflow-hidden">
                                        <div class="h-full bg-white rounded-full" style="width: {{ $prob * 100 }}%"></div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <p class="text-xs text-white/60 italic">Data probabilitas belum tersedia (historis).</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div
                    class="md:w-64 p-6 bg-black/10 border border-white/20 rounded-2xl backdrop-blur-md self-center relative flex-shrink-0">
                    <p
                        class="text-[10px] font-black text-white/80 uppercase tracking-widest mb-2 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                        Saran Utama
                    </p>
                    <p class="text-sm font-bold text-white mt-3">
                        @if (($analysis['color'] ?? 'slate') == 'emerald')
                            Pertahankan jadwal pemupukan rutin. Lahan subur.
                        @elseif(($analysis['color'] ?? 'slate') == 'amber')
                            Lakukan analisis daun untuk memastikan serapan hara. Perlu pupuk tambahan.
                        @else
                            Perhatian khusus diperlukan! Tanah tidak ideal untuk sawit saat ini.
                        @endif
                    </p>
                </div>
            </div>

            <!-- Abstract background shape -->
            <div class="absolute -right-20 -bottom-20 w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
        </div>
    </div>

    <!-- Diagnostic and Explanation -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Nutrient Breakdown -->
        <div
            class="bg-white dark:bg-slate-800 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
            <div class="p-6 border-b border-slate-50 dark:border-slate-700/50">
                <h3 class="text-lg font-black text-slate-800 dark:text-white tracking-tight">Kadar Unsur Hara Terbaru
                </h3>
                <p class="text-[10px] text-slate-400 uppercase tracking-widest mt-1 font-bold">Diukur pada:
                    {{ $latestNutrient ? $latestNutrient->measured_at->format('d M Y') : '-' }}</p>
            </div>

            <div class="p-6 grid grid-cols-2 md:grid-cols-3 gap-4">
                @php
                    $nutrientsList = [
                        [
                            'label' => 'Nitrogen (N)',
                            'value' => $latestNutrient->nitrogen ?? 0,
                            'unit' => '%',
                            'min' => 2.5,
                        ],
                        [
                            'label' => 'Fosfor (P)',
                            'value' => $latestNutrient->phosphorus ?? 0,
                            'unit' => 'ppm',
                            'min' => 15,
                        ],
                        [
                            'label' => 'Kalium (K)',
                            'value' => $latestNutrient->potassium ?? 0,
                            'unit' => 'cmol',
                            'min' => 0.2,
                        ],
                        [
                            'label' => 'pH Tanah',
                            'value' => $latestNutrient->ph ?? 0,
                            'unit' => '',
                            'min' => 5.5,
                        ],
                        [
                            'label' => 'Magnesium (Mg)',
                            'value' => $latestNutrient->magnesium ?? 0,
                            'unit' => 'cmol',
                            'min' => 0.25,
                        ],
                        [
                            'label' => 'C-Organik',
                            'value' => $latestNutrient->organic_carbon ?? 0,
                            'unit' => '%',
                            'min' => 1.5,
                        ],
                    ];
                @endphp

                @foreach ($nutrientsList as $nut)
                    @php
                        $isDeficit = $nut['value'] < $nut['min'];
                    @endphp
                    <div
                        class="p-4 rounded-2xl border transition-all {{ $isDeficit ? 'bg-red-50 dark:bg-red-900/10 border-red-200 dark:border-red-800' : 'bg-slate-50 dark:bg-slate-700/50 border-slate-100 dark:border-slate-700' }}">
                        <div class="flex justify-between items-start mb-2">
                            <p
                                class="text-[10px] font-black {{ $isDeficit ? 'text-red-500 dark:text-red-400' : 'text-slate-500 dark:text-slate-400' }} uppercase tracking-widest">
                                {{ $nut['label'] }}</p>
                            @if ($isDeficit)
                                <div class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></div>
                            @endif
                        </div>
                        <div class="flex items-end gap-1">
                            <p
                                class="text-xl font-black {{ $isDeficit ? 'text-red-600 dark:text-red-400' : 'text-slate-800 dark:text-white' }}">
                                {{ number_format($nut['value'], 2) }}</p>
                            <span class="text-[10px] font-bold text-slate-400 mb-1">{{ $nut['unit'] }}</span>
                        </div>
                        @if ($isDeficit)
                            <p class="text-[9px] font-bold text-red-500 dark:text-red-400 mt-2">Di bawah standar
                                ({{ $nut['min'] }})
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Analysis & Recommendation -->
        <div class="flex flex-col gap-6">
            
            {{-- Rekomendasi Card dengan Checklist --}}
            <div x-data="{
                items: [
                    { id: 1, label: 'Lakukan pemupukan NPK sesuai dengan rekomendasi dosis defisit hara', done: false },
                    { id: 2, label: 'Monitor tingkat keasaman (pH) jika berada di bawah 5.5 berikan dolomit', done: false },
                    { id: 3, label: 'Catat aktivitas pemupukan ke dalam log untuk tracking historis', done: false }
                ],
                get completedCount() { return this.items.filter(i => i.done).length },
                get totalCount() { return this.items.length },
                get progressPercent() { return this.totalCount ? Math.round((this.completedCount / this.totalCount) * 100) : 0 },
                get allDone() { return this.completedCount === this.totalCount }
            }"
                class="bg-emerald-50 dark:bg-emerald-900/10 rounded-[2rem] p-8 border border-emerald-200 dark:border-emerald-800/50 shadow-sm flex-1">
                {{-- Header --}}
                <div class="flex items-center justify-between mb-5">
                    <h3
                        class="text-sm font-black text-emerald-800 dark:text-emerald-500 uppercase tracking-widest flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Rekomendasi Pemupukan
                    </h3>
                    {{-- Progress Badge --}}
                    <span x-text="`${completedCount}/${totalCount} selesai`"
                        class="text-xs font-semibold px-3 py-1 rounded-full transition-colors duration-300"
                        :class="allDone
                            ?
                            'bg-emerald-200 dark:bg-emerald-800 text-emerald-800 dark:text-emerald-200' :
                            'bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-400'"></span>
                </div>

                {{-- Progress Bar --}}
                <div class="mb-5 h-1.5 w-full bg-emerald-100 dark:bg-emerald-900/40 rounded-full overflow-hidden">
                    <div class="h-full bg-emerald-500 dark:bg-emerald-400 rounded-full transition-all duration-500 ease-out"
                        :style="`width: ${progressPercent}%`"></div>
                </div>

                {{-- Checklist Items --}}
                <ul class="space-y-2">
                    <template x-for="item in items" :key="item.id">
                        <li>
                            <button type="button" @click="item.done = !item.done"
                                class="w-full flex items-start gap-3 p-3 rounded-2xl text-left transition-all duration-200 group"
                                :class="item.done ?
                                    'bg-emerald-100/80 dark:bg-emerald-900/30' :
                                    'hover:bg-emerald-100/60 dark:hover:bg-emerald-900/20 active:scale-[0.99]'">
                                {{-- Custom Checkbox --}}
                                <span
                                    class="mt-0.5 flex-shrink-0 w-5 h-5 rounded-full border-2 flex items-center justify-center transition-all duration-200"
                                    :class="item.done ?
                                        'bg-emerald-500 dark:bg-emerald-400 border-emerald-500 dark:border-emerald-400' :
                                        'border-emerald-300 dark:border-emerald-700 group-hover:border-emerald-400 dark:group-hover:border-emerald-500'">
                                    <svg class="w-3 h-3 text-white transition-all duration-200"
                                        :class="item.done ? 'opacity-100 scale-100' : 'opacity-0 scale-50'"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </span>

                                {{-- Label --}}
                                <span class="text-sm font-medium leading-relaxed transition-all duration-200"
                                    :class="item.done ?
                                        'text-emerald-400 dark:text-emerald-600 line-through' :
                                        'text-emerald-900 dark:text-emerald-200/80'"
                                    x-html="item.label"></span>
                            </button>
                        </li>
                    </template>
                </ul>

                {{-- All Done State --}}
                <div x-show="allDone" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="mt-4 flex items-center gap-2 p-3 rounded-2xl bg-emerald-100 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800/50">
                    <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 flex-shrink-0" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-xs font-semibold text-emerald-700 dark:text-emerald-400">
                        Rekomendasi telah diselesaikan. Tunggu pembaruan uji tanah berikutnya.
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>
