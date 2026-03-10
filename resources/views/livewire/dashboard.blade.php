<div x-data="{
    selectedBlock: null,
    darkMode: false,
    filterBlock: '',
    filterDateFrom: '',
    filterDateTo: '',
    closeDetail() { this.selectedBlock = null; }
}" :class="darkMode ? 'dark' : ''"
    class="min-h-screen bg-slate-50 dark:bg-slate-900 transition-colors duration-300">

    <div class="p-6 lg:p-8 space-y-6 max-w-7xl mx-auto">

        <!-- ══ PAGE HEADER ══ -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span
                        class="flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 rounded-full text-[10px] font-bold border border-emerald-100 dark:border-emerald-800/40 uppercase tracking-wider">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                        Live Analytics
                    </span>
                </div>
                <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-100 tracking-tight">Status Kesuburan Tanah
                </h1>
                <p class="text-slate-400 dark:text-slate-500 text-sm mt-0.5">Ringkasan kondisi hara dan prediksi panen
                    estate saat ini.</p>
            </div>
            <div class="flex items-center gap-2">
                <!-- Dark Mode Toggle -->
                <button @click="darkMode = !darkMode"
                    class="w-9 h-9 rounded-xl flex items-center justify-center border transition-all duration-200 hover:scale-105 bg-white dark:bg-slate-800 border-slate-200 dark:border-white/10">
                    <svg x-show="!darkMode" class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <svg x-show="darkMode" class="w-4 h-4 text-indigo-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>
                <!-- Export -->
                <button
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-white/10 rounded-xl text-slate-600 dark:text-slate-300 text-sm font-semibold hover:bg-slate-50 dark:hover:bg-slate-700/50 transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="hidden md:inline">Export Report</span>
                </button>
            </div>
        </div>

        <!-- ══ FILTER BAR ══ -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-white/5 shadow-sm p-4">
            <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-center">
                <div class="flex items-center gap-2 text-slate-400 dark:text-slate-500 shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z" />
                    </svg>
                    <span class="text-xs font-semibold uppercase tracking-wider">Filter</span>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 flex-1 w-full">
                    <!-- Block Dropdown -->
                    <div class="relative flex-1">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h8m-8 6h16" />
                            </svg>
                        </div>
                        <select x-model="filterBlock"
                            class="w-full pl-9 pr-4 py-2.5 rounded-xl text-sm text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-700/50 focus:outline-none focus:border-emerald-400 dark:focus:border-emerald-500/50 transition appearance-none font-medium">
                            <option value="">Semua Blok Kebun</option>
                            @foreach ($blocks as $block)
                                <option value="{{ $block['name'] }}">{{ $block['name'] }}</option>
                            @endforeach
                        </select>
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>

                    <!-- Date From -->
                    <div class="relative">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input x-model="filterDateFrom" type="date"
                            class="pl-9 pr-4 py-2.5 rounded-xl text-sm text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-700/50 focus:outline-none focus:border-emerald-400 dark:focus:border-emerald-500/50 transition font-medium w-full sm:w-auto" />
                    </div>

                    <span
                        class="hidden sm:flex items-center text-slate-300 dark:text-slate-600 text-sm font-medium">—</span>

                    <!-- Date To -->
                    <div class="relative">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input x-model="filterDateTo" type="date"
                            class="pl-9 pr-4 py-2.5 rounded-xl text-sm text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-700/50 focus:outline-none focus:border-emerald-400 dark:focus:border-emerald-500/50 transition font-medium w-full sm:w-auto" />
                    </div>

                    <!-- Apply Button -->
                    <button
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-white text-sm font-semibold transition-all hover:scale-105 active:scale-95 shadow-sm shadow-emerald-500/20 shrink-0"
                        style="background:linear-gradient(135deg,#10b981,#059669)">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Terapkan
                    </button>

                    <!-- Reset -->
                    <button @click="filterBlock=''; filterDateFrom=''; filterDateTo='';"
                        class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl text-slate-500 dark:text-slate-400 text-sm font-medium border border-slate-200 dark:border-white/10 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition shrink-0">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reset
                    </button>
                </div>
            </div>
        </div>

        <!-- ══ SUMMARY CARDS ══ -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Blok -->
            <div
                class="bg-white dark:bg-slate-800 p-5 rounded-2xl border border-slate-200 dark:border-white/5 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between mb-3">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Blok</p>
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:#818cf815">
                        <svg class="w-4 h-4" style="color:#818cf8" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-3xl font-black text-slate-800 dark:text-white">{{ $summary['total_blocks'] }}</h3>
                <p class="text-[10px] text-slate-400 font-medium mt-1">128.5 Ha total area</p>
            </div>

            <!-- Avg Ton/Ha -->
            <div
                class="bg-white dark:bg-slate-800 p-5 rounded-2xl border border-slate-200 dark:border-white/5 shadow-sm hover:shadow-md transition-shadow border-t-2 border-t-emerald-500">
                <div class="flex items-start justify-between mb-3">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Avg Ton/Ha</p>
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:#10b98115">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-3xl font-black text-slate-800 dark:text-white">
                    {{ number_format($summary['avg_ton_per_ha'], 1) }}</h3>
                <p class="text-[10px] text-emerald-500 font-bold mt-1">+2.4% yield dari bulan lalu</p>
            </div>

            <!-- Best Yield -->
            <div
                class="bg-white dark:bg-slate-800 p-5 rounded-2xl border border-slate-200 dark:border-white/5 shadow-sm hover:shadow-md transition-shadow border-t-2 border-t-amber-500">
                <div class="flex items-start justify-between mb-3">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Best Yield</p>
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:#f59e0b15">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-3xl font-black text-slate-800 dark:text-white">{{ $summary['best_yield_block'] }}</h3>
                <p class="text-[10px] text-amber-500 font-bold mt-1">{{ $summary['best_yield_val'] ?? 0 }} Ton produksi
                </p>
            </div>

            <!-- Est. Total -->
            <div class="p-5 rounded-2xl shadow-lg text-white border-t-2 border-t-emerald-400 relative overflow-hidden"
                style="background:linear-gradient(135deg,#0f172a,#1e293b)">
                <div class="flex items-start justify-between mb-3">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Est. Total Panen</p>
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                        style="background:rgba(16,185,129,.15)">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-3xl font-black">{{ number_format($summary['estimated_total_yield']) }}</h3>
                <p class="text-[10px] text-emerald-400 font-bold mt-1 uppercase tracking-wider">Ton / Tahun</p>
            </div>
        </div>

        <!-- ══ MAP & CHARTS ══ -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Map -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-white/5 shadow-sm overflow-hidden relative"
                    style="height:480px">
                    <div id="map" class="w-full h-full" wire:ignore></div>
                    <!-- Legend -->
                    <div
                        class="absolute bottom-5 right-5 p-4 bg-white/90 dark:bg-slate-800/90 backdrop-blur-md rounded-xl shadow-lg border border-white/50 dark:border-white/5 z-10">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2.5">Indikator</p>
                        <div class="space-y-1.5">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                                <span class="text-[11px] font-semibold text-slate-600 dark:text-slate-300">Subur</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                                <span class="text-[11px] font-semibold text-slate-600 dark:text-slate-300">Cukup
                                    Subur</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>
                                <span class="text-[11px] font-semibold text-slate-600 dark:text-slate-300">Kurang
                                    Subur</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Side Charts -->
            <div class="space-y-5">
                <!-- Harvest Trend -->
                <div
                    class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-white/5 shadow-sm">
                    <div class="mb-5">
                        <h4 class="text-sm font-bold text-slate-700 dark:text-slate-200">Tren Panen 12 Bulan</h4>
                        <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider mt-0.5">Estimasi
                            Produksi (Ton)</p>
                    </div>
                    <div class="h-44 w-full relative">
                        <canvas id="harvestChart"></canvas>
                    </div>
                </div>

                <!-- Fertility Distribution -->
                <div
                    class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-white/5 shadow-sm">
                    <h4 class="text-sm font-bold text-slate-700 dark:text-slate-200 mb-5">Distribusi Kesuburan</h4>
                    <div class="space-y-4">
                        @foreach ($summary['distribution'] as $status => $count)
                            @php
                                $color =
                                    $status === 'Subur' ? 'emerald' : ($status === 'Cukup Subur' ? 'amber' : 'rose');
                                $hex =
                                    $status === 'Subur'
                                        ? '#10b981'
                                        : ($status === 'Cukup Subur'
                                            ? '#f59e0b'
                                            : '#f43f5e');
                                $percentage = ($count / $summary['total_blocks']) * 100;
                            @endphp
                            <div class="space-y-1.5">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full"
                                            style="background:{{ $hex }}"></span>
                                        <span
                                            class="text-[11px] font-semibold text-slate-600 dark:text-slate-300">{{ $status }}</span>
                                    </div>
                                    <span class="text-[10px] text-slate-400 font-bold">{{ $count }} Blok ·
                                        {{ round($percentage) }}%</span>
                                </div>
                                <div class="h-1.5 w-full bg-slate-100 dark:bg-slate-700 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full transition-all duration-500"
                                        style="width:{{ $percentage }}%; background:{{ $hex }}"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- ══ TABLE ══ -->
        <div
            class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-white/5 shadow-sm overflow-hidden">
            <!-- Table Header -->
            <div
                class="px-6 py-5 border-b border-slate-100 dark:border-white/5 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h4 class="text-sm font-bold text-slate-700 dark:text-slate-200">Status Operasional Per Blok</h4>
                    <p class="text-[10px] text-slate-400 font-medium mt-0.5 uppercase tracking-wider">
                        {{ count($blocks) }} blok terdaftar</p>
                </div>
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" placeholder="Cari blok..."
                        class="pl-9 pr-4 py-2 rounded-xl text-sm text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-700/50 focus:outline-none focus:border-emerald-400 transition font-medium placeholder-slate-300 dark:placeholder-slate-600 w-48" />
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
                                Umur</th>
                            <th
                                class="px-6 py-3.5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                                Status</th>
                            <th
                                class="px-6 py-3.5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">
                                Ton/Ha</th>
                            <th
                                class="px-6 py-3.5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">
                                Est. Tahunan</th>
                            <th class="px-6 py-3.5 w-12"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-white/5">
                        @foreach ($blocks as $block)
                            <tr class="group hover:bg-slate-50 dark:hover:bg-white/[0.02] transition-colors cursor-pointer"
                                @click="selectedBlock = {{ json_encode($block) }}; setTimeout(() => window.initDetailChart(selectedBlock), 100);">
                                <!-- Blok Identity -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-9 h-9 rounded-xl flex items-center justify-center text-white font-black text-xs bg-{{ $block['color_name'] }}-500 shadow-sm">
                                            {{ explode(' ', $block['name'])[1] }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-800 dark:text-slate-100">
                                                {{ $block['name'] }}</p>
                                            <p class="text-[10px] text-slate-400 font-medium">{{ $block['area_ha'] }}
                                                Ha</p>
                                        </div>
                                    </div>
                                </td>
                                <!-- Umur -->
                                <td class="px-6 py-4 text-center">
                                    <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                                        {{ $block['prediction']['age_years'] }} Thn
                                    </span>
                                </td>
                                <!-- Status -->
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-{{ $block['color_name'] }}-50 dark:bg-{{ $block['color_name'] }}-900/20 text-{{ $block['color_name'] }}-700 dark:text-{{ $block['color_name'] }}-400 border border-{{ $block['color_name'] }}-100 dark:border-{{ $block['color_name'] }}-800/30">
                                        <span
                                            class="w-1.5 h-1.5 rounded-full bg-{{ $block['color_name'] }}-500"></span>
                                        {{ $block['status'] }}
                                    </span>
                                </td>
                                <!-- Ton/Ha -->
                                <td class="px-6 py-4 text-right">
                                    <span
                                        class="text-sm font-black text-slate-800 dark:text-slate-100">{{ $block['ton_per_ha'] }}</span>
                                </td>
                                <!-- Est. Yield -->
                                <td class="px-6 py-4 text-right">
                                    <p class="text-sm font-black text-slate-800 dark:text-slate-100">
                                        {{ number_format($block['yield']) }}</p>
                                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">Ton</p>
                                </td>
                                <!-- Arrow -->
                                <td class="px-6 py-4">
                                    <div
                                        class="w-7 h-7 rounded-lg flex items-center justify-center bg-slate-100 dark:bg-slate-700 text-slate-400 group-hover:bg-slate-800 dark:group-hover:bg-slate-600 group-hover:text-white transition-all duration-150 ml-auto">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div><!-- /container -->


    <!-- ══════════════════════════
            DETAIL PANEL
        ══════════════════════════ -->
    <template x-if="selectedBlock">
        <div class="fixed inset-0 z-[100] flex items-center justify-end" @click.self="closeDetail()"
            style="background:rgba(15,23,42,.5);backdrop-filter:blur(6px)">

            <div x-show="selectedBlock" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="translate-x-full opacity-0"
                x-transition:enter-end="translate-x-0 opacity-100"
                class="w-full max-w-sm h-full bg-white dark:bg-slate-900 shadow-2xl flex flex-col relative border-l border-slate-200 dark:border-white/5">

                <!-- Accent top bar -->
                <div class="h-1 w-full shrink-0" style="background:linear-gradient(90deg,#10b981,#059669,#047857)">
                </div>

                <!-- Close -->
                <button @click="closeDetail()"
                    class="absolute top-4 right-4 w-8 h-8 rounded-xl flex items-center justify-center bg-slate-100 dark:bg-slate-800 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition z-20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Header -->
                <div class="p-6 pb-5 border-b border-slate-100 dark:border-white/5 shrink-0">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center text-white font-black text-sm"
                            :class="'bg-' + selectedBlock.color_name + '-500'">
                            <span x-text="selectedBlock.name.split(' ')[1]"></span>
                        </div>
                        <div>
                            <h2 class="text-lg font-black text-slate-800 dark:text-slate-100"
                                x-text="selectedBlock.name"></h2>
                            <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider"
                                x-text="selectedBlock.prediction.age_years + ' Tahun · ' + selectedBlock.area_ha + ' Ha'">
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Scrollable Content -->
                <div class="flex-1 overflow-y-auto p-6 space-y-5">

                    <!-- Prediction Card -->
                    <div class="p-5 rounded-2xl text-white relative overflow-hidden"
                        style="background:linear-gradient(135deg,#0f172a,#1e293b)">
                        <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-2">Estimasi Panen
                            Tahunan</p>
                        <div class="flex items-end gap-2">
                            <h4 class="text-3xl font-black" x-text="parseFloat(selectedBlock.yield).toLocaleString()">
                            </h4>
                            <span class="text-sm font-bold text-slate-400 mb-1">TON</span>
                        </div>
                        <div class="mt-4 pt-4 border-t border-white/10 grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-[9px] text-slate-500 uppercase font-black tracking-wider">Efisiensi</p>
                                <p class="text-sm font-bold mt-0.5" x-text="selectedBlock.ton_per_ha + ' Ton/Ha'"></p>
                            </div>
                            <div>
                                <p class="text-[9px] text-slate-500 uppercase font-black tracking-wider">Status Umur
                                </p>
                                <p class="text-sm font-bold text-emerald-400 mt-0.5"
                                    x-text="selectedBlock.prediction.status_label"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Monthly Chart -->
                    <div
                        class="bg-slate-50 dark:bg-slate-800 rounded-2xl p-4 border border-slate-100 dark:border-white/5">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">Prediksi Panen
                            Bulanan</p>
                        <div class="h-28 w-full">
                            <canvas id="detailHarvestChart"></canvas>
                        </div>
                    </div>

                    <!-- Nutrients -->
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">Kondisi Hara
                            Terakhir</p>
                        <div class="grid grid-cols-2 gap-2">
                            <div
                                class="bg-slate-50 dark:bg-slate-800 p-3.5 rounded-xl border border-slate-100 dark:border-white/5 hover:shadow-sm transition">
                                <p class="text-[9px] font-bold text-slate-400 uppercase mb-1">Nitrogen (N)</p>
                                <p class="text-base font-black text-slate-800 dark:text-slate-100"
                                    x-text="selectedBlock.raw_nutrients.nitrogen + '%'"></p>
                            </div>
                            <div
                                class="bg-slate-50 dark:bg-slate-800 p-3.5 rounded-xl border border-slate-100 dark:border-white/5 hover:shadow-sm transition">
                                <p class="text-[9px] font-bold text-slate-400 uppercase mb-1">Fosfor (P)</p>
                                <p class="text-base font-black text-slate-800 dark:text-slate-100"
                                    x-text="selectedBlock.raw_nutrients.phosphorus + ' ppm'"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Recommendation -->
                    <div
                        class="p-4 bg-emerald-50 dark:bg-emerald-900/10 rounded-xl border border-emerald-100 dark:border-emerald-800/30">
                        <h5
                            class="text-[10px] font-black text-emerald-700 dark:text-emerald-400 uppercase tracking-widest mb-2 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Rekomendasi Agronomi
                        </h5>
                        <p class="text-xs text-emerald-700 dark:text-emerald-300/80 leading-relaxed"
                            x-text="selectedBlock.status === 'Subur'
                                ? 'Pertahankan pemupukan standar. Monitor serangan hama pada daun.'
                                : 'Segera lakukan pemupukan tambahan Nitrogen dan Fosfor. Perbaiki drainase di area rendah.'">
                        </p>
                    </div>
                </div>

                <!-- Footer -->
                <div class="p-5 border-t border-slate-100 dark:border-white/5 shrink-0">
                    <button
                        class="w-full py-3 rounded-xl text-white text-xs font-black uppercase tracking-widest transition-all hover:scale-[1.02] active:scale-[0.98] shadow-md shadow-emerald-500/20"
                        style="background:linear-gradient(135deg,#10b981,#059669)">
                        Download Full Report
                    </button>
                </div>
            </div>
        </div>
    </template>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("livewire:navigated", initApp);
    document.addEventListener("DOMContentLoaded", initApp);

    function initApp() {
        initMap();
        initChart();
    }

    function initChart() {
        const ctx = document.getElementById('harvestChart');
        if (!ctx) return;
        if (window.harvestChartInstance) window.harvestChartInstance.destroy();

        const rawData = @json($harvestTrend);
        const yields = rawData.map(item => item.yield);
        const maxYield = Math.max(...yields, 1);

        window.harvestChartInstance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: rawData.map(item => item.month.substring(0, 3).toUpperCase()),
                datasets: [{
                    data: yields,
                    backgroundColor: yields.map(val => `rgba(16,185,129,${0.2 + (val/maxYield)*0.75})`),
                    hoverBackgroundColor: '#059669',
                    borderRadius: 4,
                    borderWidth: 0,
                    barPercentage: 0.7,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleFont: {
                            size: 10
                        },
                        bodyFont: {
                            size: 11,
                            weight: 'bold'
                        },
                        padding: 10,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            label: ctx => ctx.parsed.y + ' Ton'
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 9,
                                weight: 'bold'
                            },
                            color: '#94a3b8'
                        }
                    },
                    y: {
                        display: false,
                        beginAtZero: true
                    }
                }
            }
        });
    }

    function initMap() {
        const mapContainer = document.getElementById('map');
        if (!mapContainer || mapContainer.innerHTML.trim() !== '') return;

        const map = new ol.Map({
            target: 'map',
            layers: [new ol.layer.Tile({
                source: new ol.source.XYZ({
                    url: 'https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}'
                })
            })],
            view: new ol.View({
                center: ol.proj.fromLonLat([101.7068, 0.2933]),
                zoom: 12
            })
        });

        const blocks = @json($blocks).map(b => ({
            id: b.id,
            name: b.name,
            coords: b.coords,
            color: b.color_name === 'emerald' ? '#10b981' : (b.color_name === 'amber' ? '#fbbf24' :
                '#f43f5e'),
            rawData: b
        }));

        const features = [];
        blocks.forEach(block => {
            if (block.coords && Array.isArray(block.coords) && block.coords.length > 0) {
                const polygon = new ol.Feature({
                    geometry: new ol.geom.Polygon([block.coords.map(c => ol.proj.fromLonLat(c))]),
                    name: block.name,
                    rawData: block.rawData
                });
                polygon.setStyle(new ol.style.Style({
                    stroke: new ol.style.Stroke({
                        color: block.color,
                        width: 3
                    }),
                    fill: new ol.style.Fill({
                        color: block.color + '44'
                    })
                }));
                features.push(polygon);
            }
        });

        const vectorSource = new ol.source.Vector({
            features
        });
        map.addLayer(new ol.layer.Vector({
            source: vectorSource
        }));

        const tooltip = document.createElement('div');
        tooltip.className =
            "bg-slate-900 px-3 py-1.5 rounded-lg shadow-xl text-[11px] font-bold text-white pointer-events-none z-50";
        tooltip.style.cssText = "position:fixed;display:none";
        document.body.appendChild(tooltip);

        map.on('pointermove', evt => {
            const feature = map.forEachFeatureAtPixel(evt.pixel, f => f);
            if (feature) {
                tooltip.style.display = "block";
                tooltip.style.left = evt.originalEvent.clientX + 15 + "px";
                tooltip.style.top = evt.originalEvent.clientY + 15 + "px";
                tooltip.innerHTML = feature.get("name");
                map.getTargetElement().style.cursor = 'pointer';
            } else {
                tooltip.style.display = "none";
                map.getTargetElement().style.cursor = '';
            }
        });

        map.on('click', evt => {
            const feature = map.forEachFeatureAtPixel(evt.pixel, f => f);
            if (feature) {
                const data = feature.get("rawData");
                const component = document.querySelector('[x-data]');
                try {
                    Alpine.$data(component).selectedBlock = data;
                } catch (e) {
                    if (component?.__x) component.__x.$data.selectedBlock = data;
                }
                setTimeout(() => window.initDetailChart(data), 100);
            }
        });

        const extent = vectorSource.getExtent();
        if (!ol.extent.isEmpty(extent)) map.getView().fit(extent, {
            padding: [80, 80, 80, 80]
        });
    }

    window.initDetailChart = function(data) {
        const ctx = document.getElementById('detailHarvestChart');
        if (!ctx) return;
        if (window.detailChartInstance) window.detailChartInstance.destroy();

        const rawData = data.prediction.monthly_trend;
        const yields = rawData.map(item => item.yield);
        const maxYield = Math.max(...yields, 1);

        window.detailChartInstance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: rawData.map(item => item.month.substring(0, 3).toUpperCase()),
                datasets: [{
                    data: yields,
                    backgroundColor: yields.map(val =>
                        `rgba(16,185,129,${0.2 + (val/maxYield)*0.75})`),
                    hoverBackgroundColor: '#059669',
                    borderRadius: 3,
                    borderWidth: 0,
                    barPercentage: 0.8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        bodyFont: {
                            size: 10,
                            weight: 'bold'
                        },
                        padding: 8,
                        cornerRadius: 6,
                        displayColors: false,
                        callbacks: {
                            label: ctx => ctx.parsed.y + ' Ton'
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 8,
                                weight: 'bold'
                            },
                            color: '#94a3b8'
                        }
                    },
                    y: {
                        display: false,
                        beginAtZero: true
                    }
                }
            }
        });
    }
</script>
