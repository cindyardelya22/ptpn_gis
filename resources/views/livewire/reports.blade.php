<div class="p-6 space-y-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-100 tracking-tight">Laporan & Dokumen</h1>
            <p class="text-slate-500 text-sm mt-1">Export data operasional dan analisis kebun dalam format dokumen.</p>
        </div>
    </div>

    <!-- Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 text-emerald-900">
        @php
            $reports = [
                ['title' => 'Laporan Kesuburan Tanah', 'desc' => 'Rekapitulasi status hara seluruh blok per periode.', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                ['title' => 'Prediksi Panen Tahunan', 'desc' => 'Estimasi produksi TBS (Tandan Buah Segar) per tahun.', 'icon' => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6'],
                ['title' => 'Log Aktivitas Pemupukan', 'desc' => 'Daftar blok yang telah dilakukan perawatan unsur hara.', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['title' => 'Peta Sebaran Unsur', 'desc' => 'Visualisasi distribusi N, P, K dalam format PDF.', 'icon' => 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7l5-2.5 5.553 2.776a1 1 0 01.447.894v10.764a1 1 0 01-1.447.894L15 17l-6 3z'],
            ];
        @endphp

        @foreach($reports as $report)
            <div
                class="bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-100 dark:border-slate-700 shadow-sm hover:shadow-xl hover:shadow-emerald-100/50 transition-all group cursor-pointer">
                <div
                    class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $report['icon'] }}" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100">{{ $report['title'] }}</h3>
                <p class="text-slate-500 text-xs mt-2 leading-relaxed">{{ $report['desc'] }}</p>
                <div class="mt-6 flex items-center justify-between">
                    <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest">Available: PDF,
                        XLSX</span>
                    <button class="flex items-center gap-2 text-sm font-bold text-emerald-600 hover:text-emerald-700">
                        Generate
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>