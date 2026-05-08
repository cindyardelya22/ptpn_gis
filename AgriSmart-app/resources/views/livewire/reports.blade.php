<div class="p-6 lg:p-8 space-y-6 max-w-7xl mx-auto">

    <!-- ══ HEADER ══ -->
    <div>
        <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-100 tracking-tight">Laporan & Dokumen</h1>
        <p class="text-slate-400 dark:text-slate-500 text-sm mt-0.5">Export data operasional dan analisis kebun dalam
            format dokumen.</p>
    </div>

    <!-- ══ REPORT CARDS ══ -->
    @php
        $reports = [
            [
                'title' => 'Laporan Kesuburan Tanah',
                'desc' =>
                    'Rekapitulasi status hara seluruh blok per periode. Mencakup nilai N, P, K, pH, Mg, dan C-Organik.',
                'icon' =>
                    'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                'formats' => ['PDF', 'XLSX'],
                'badge' => 'Hara',
                'color' => 'emerald',
                'updated' => 'Update tersedia',
            ],
            [
                'title' => 'Prediksi Panen Tahunan',
                'desc' =>
                    'Estimasi produksi TBS (Tandan Buah Segar) per blok berdasarkan umur tanaman dan kondisi hara.',
                'icon' => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6',
                'formats' => ['PDF', 'XLSX'],
                'badge' => 'Produksi',
                'color' => 'amber',
                'updated' => 'Data real-time',
            ],
            [
                'title' => 'Log Aktivitas Pemupukan',
                'desc' => 'Histori lengkap pemupukan per blok kebun beserta tanggal, jenis pupuk, dan dosisnya.',
                'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                'formats' => ['PDF', 'XLSX'],
                'badge' => 'Aktivitas',
                'color' => 'indigo',
                'updated' => 'Histori lengkap',
            ],
            [
                'title' => 'Peta Sebaran Unsur',
                'desc' => 'Visualisasi distribusi N, P, K pada seluruh blok dalam peta interaktif format PDF.',
                'icon' =>
                    'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7l5-2.5 5.553 2.776a1 1 0 01.447.894v10.764a1 1 0 01-1.447.894L15 17l-6 3z',
                'formats' => ['PDF'],
                'badge' => 'Peta',
                'color' => 'rose',
                'updated' => 'Inkl. koordinat',
            ],
        ];

        $colorMap = [
            'emerald' => [
                'bg' => '#10b98115',
                'text' => '#059669',
                'badge_bg' => '#f0fdf4',
                'badge_text' => '#15803d',
                'badge_border' => '#bbf7d0',
                'btn' => 'linear-gradient(135deg,#10b981,#059669)',
            ],
            'amber' => [
                'bg' => '#f59e0b15',
                'text' => '#d97706',
                'badge_bg' => '#fffbeb',
                'badge_text' => '#b45309',
                'badge_border' => '#fde68a',
                'btn' => 'linear-gradient(135deg,#f59e0b,#d97706)',
            ],
            'indigo' => [
                'bg' => '#818cf815',
                'text' => '#4f46e5',
                'badge_bg' => '#eef2ff',
                'badge_text' => '#4338ca',
                'badge_border' => '#c7d2fe',
                'btn' => 'linear-gradient(135deg,#818cf8,#6366f1)',
            ],
            'rose' => [
                'bg' => '#f43f5e15',
                'text' => '#e11d48',
                'badge_bg' => '#fff1f2',
                'badge_text' => '#be123c',
                'badge_border' => '#fecdd3',
                'btn' => 'linear-gradient(135deg,#f43f5e,#e11d48)',
            ],
        ];
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        @foreach ($reports as $report)
            @php $c = $colorMap[$report['color']]; @endphp
            <div
                class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-white/5 shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden group flex flex-col">

                {{-- Top bar accent --}}
                <div class="h-1 w-full shrink-0" style="background:{{ $c['btn'] }}"></div>

                <div class="p-6 flex flex-col flex-1">

                    {{-- Icon + Badge --}}
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center transition-transform duration-200 group-hover:scale-105 shrink-0"
                            style="background:{{ $c['bg'] }}">
                            <svg class="w-5 h-5" style="color:{{ $c['text'] }}" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="{{ $report['icon'] }}" />
                            </svg>
                        </div>
                        <span class="text-[9px] font-black uppercase tracking-widest px-2.5 py-1 rounded-full border"
                            style="background:{{ $c['badge_bg'] }};color:{{ $c['badge_text'] }};border-color:{{ $c['badge_border'] }}">
                            {{ $report['badge'] }}
                        </span>
                    </div>

                    {{-- Title & Desc --}}
                    <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 mb-1.5">{{ $report['title'] }}
                    </h3>
                    <p class="text-xs text-slate-400 dark:text-slate-500 leading-relaxed flex-1">{{ $report['desc'] }}
                    </p>

                    {{-- Footer --}}
                    <div
                        class="mt-5 pt-4 border-t border-slate-100 dark:border-white/5 flex items-center justify-between gap-3">

                        {{-- Meta --}}
                        <div class="flex items-center gap-3">
                            {{-- Formats --}}
                            <div class="flex items-center gap-1">
                                @foreach ($report['formats'] as $fmt)
                                    <span
                                        class="text-[9px] font-black px-2 py-0.5 rounded-md bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                        {{ $fmt }}
                                    </span>
                                @endforeach
                            </div>
                            <span class="text-[10px] text-slate-400 font-medium hidden sm:block">·
                                {{ $report['updated'] }}</span>
                        </div>

                        {{-- Generate Buttons --}}
                        <div class="flex items-center gap-1.5 shrink-0">
                            @foreach ($report['formats'] as $fmt)
                                <button
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[11px] font-bold text-white transition-all hover:scale-105 active:scale-95 shadow-sm"
                                    style="background:{{ $c['btn'] }}">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    {{ $fmt }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
