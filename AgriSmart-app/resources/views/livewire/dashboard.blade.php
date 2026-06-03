<div x-data="{
    selectedBlock: null,
    darkMode: false,
    closeDetail() { this.selectedBlock = null; }
}" :class="darkMode ? 'dark' : ''"
    class="min-h-screen bg-slate-50 dark:bg-slate-900 transition-colors duration-300">

    <div class="p-6 lg:p-8 space-y-6 max-w-7xl mx-auto">

        <!-- ══ PAGE HEADER ══ -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>

                <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-100 tracking-tight">Dashboard
                </h1>
                <p class="text-slate-400 dark:text-slate-500 text-sm mt-0.5">Ringkasan kondisi hara dan status kesuburan kebun.</p>
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
                    <!-- Block Dropdown — pakai allBlocks & wire:model -->
                    <div class="relative flex-1">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                            </svg>
                        </div>
                        <select wire:model="filterBlock"
                            class="w-full pl-9 pr-4 py-2.5 rounded-xl text-sm text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-700/50 focus:outline-none focus:border-emerald-400 dark:focus:border-emerald-500/50 transition appearance-none font-medium">
                            <option value="">Semua Blok Kebun</option>
                            @foreach ($allBlocks as $b)
                            <option value="{{ $b->name }}">{{ $b->name }}</option>
                            @endforeach
                        </select>
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>

                    <!-- Date From -->
                    <div class="relative">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input wire:model="filterDateFrom" type="date"
                            class="pl-9 pr-4 py-2.5 rounded-xl text-sm text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-700/50 focus:outline-none focus:border-emerald-400 dark:focus:border-emerald-500/50 transition font-medium w-full sm:w-auto" />
                    </div>

                    <span class="hidden sm:flex items-center text-slate-300 dark:text-slate-600 text-sm font-medium">—</span>

                    <!-- Date To -->
                    <div class="relative">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input wire:model="filterDateTo" type="date"
                            class="pl-9 pr-4 py-2.5 rounded-xl text-sm text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-700/50 focus:outline-none focus:border-emerald-400 dark:focus:border-emerald-500/50 transition font-medium w-full sm:w-auto" />
                    </div>

                    <!-- Apply Button -->
                    <button wire:click="applyFilter"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-white text-sm font-semibold transition-all hover:scale-105 active:scale-95 shadow-sm shadow-emerald-500/20 shrink-0"
                        style="background:linear-gradient(135deg,#10b981,#059669)">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <span wire:loading.remove wire:target="applyFilter">Terapkan</span>
                        <span wire:loading wire:target="applyFilter">...</span>
                    </button>

                    <!-- Reset -->
                    <button wire:click="resetFilter"
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
                class="bg-white dark:bg-slate-800 p-5 rounded-2xl border border-slate-200 dark:border-white/5 shadow-sm hover:shadow-md transition-shadow border-t-2 border-t-purple-500">
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
                <p class="text-[10px] text-slate-400 font-medium mt-1">{{ number_format($summary['total_area'], 1) }} Ha total area</p>
            </div>

            <!-- Blok Subur -->
            <div
                class="bg-white dark:bg-slate-800 p-5 rounded-2xl border border-slate-200 dark:border-white/5 shadow-sm hover:shadow-md transition-shadow border-t-2 border-t-emerald-500">
                <div class="flex items-start justify-between mb-3">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Blok Subur</p>
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:#10b98115">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-3xl font-black text-emerald-500">
                    {{ $summary['fertile_count'] }}
                </h3>
                <p class="text-[10px] text-slate-400 font-medium mt-1">Kondisi Hara Optimal</p>
            </div>

            <!-- Blok Kurang Subur -->
            <div
                class="bg-white dark:bg-slate-800 p-5 rounded-2xl border border-slate-200 dark:border-white/5 shadow-sm hover:shadow-md transition-shadow border-t-2 border-t-amber-500">
                <div class="flex items-start justify-between mb-3">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Blok Kurang Subur</p>
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:#f59e0b15">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-3xl font-black text-amber-500">{{ $summary['less_fertile_count'] }}</h3>
                <p class="text-[10px] text-slate-400 font-medium mt-1">Perlu Pemupukan Minor</p>
            </div>

            <!-- Blok Tidak Subur -->
            <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl border border-slate-200 dark:border-white/5 
            shadow-sm hover:shadow-md transition-shadow border-t-2 border-t-rose-500">
                <div class="flex items-start justify-between mb-3">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Blok Tidak Subur</p>
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:#f43f5e15">
                        <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-3xl font-black text-rose-500">
                    {{ $summary['not_fertile_count'] }}
                </h3>
                <p class="text-[10px] text-slate-400 font-medium mt-1">Butuh Tindakan Segera</p>
            </div>
        </div>

        <!-- ══ MAP & CHARTS ══ -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Map -->
            <div class="lg:col-span-2">
                <a href="{{ route('peta-blok') }}" wire:navigate>
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
                                    <span class="text-[11px] font-semibold text-slate-600 dark:text-slate-300">Kurang
                                        Subur</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>
                                    <span class="text-[11px] font-semibold text-slate-600 dark:text-slate-300">Tidak
                                        Subur</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Side Charts -->
            <div class="space-y-5">
                <!-- Fertility Distribution -->
                <div
                    class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-white/5 shadow-sm flex-1 flex flex-col justify-center h-[480px]">
                    <h4 class="text-sm font-bold text-slate-700 dark:text-slate-200 mb-8 text-center">Proporsi Status Kesuburan</h4>
                    <div class="flex justify-center mb-10">
                        @php
                        $total = array_sum($summary['distribution']);
                        $offset = 25;
                        $circumference = 100.53;
                        $colors = ['Subur' => '#10b981', 'Kurang Subur' => '#f59e0b', 'Tidak Subur' => '#f43f5e'];
                        @endphp
                        <div class="relative w-48 h-48">
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
                                <span class="text-3xl font-black text-slate-800 dark:text-white">{{ $summary['total_blocks'] }}</span>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Blok</span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4 px-2">
                        @foreach ($summary['distribution'] as $status => $count)
                        @php
                        $hex = $colors[$status] ?? '#94a3b8';
                        $percentage = $total > 0 ? ($count / $total) * 100 : 0;
                        @endphp
                        <div class="space-y-1.5">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full"
                                        style="background:{{ $hex }}"></span>
                                    <span
                                        class="text-[12px] font-semibold text-slate-600 dark:text-slate-300">{{ $status }}</span>
                                </div>
                                <span class="text-[11px] text-slate-400 font-bold">{{ $count }} Blok ·
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
                    <h4 class="text-sm font-bold text-slate-700 dark:text-slate-200">Status Kesuburan Per Blok</h4>
                    <p class="text-[10px] text-slate-400 font-medium mt-0.5 uppercase tracking-wider">
                        Berdasarkan hasil analisis terbaru
                    </p>
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
                                Luas Tanah</th>
                            <th
                                class="px-6 py-3.5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                                Waktu Pengukuran</th>
                            <th
                                class="px-6 py-3.5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                                Status Kesuburan</th>
                            <th class="px-6 py-3.5 w-12"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-white/5">
                        @foreach ($blocks as $block)
                        <tr class="group hover:bg-slate-50 dark:hover:bg-white/[0.02] transition-colors cursor-pointer"
                            @click="selectedBlock = {{ json_encode($block) }};">
                            <!-- Blok Identity -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-9 h-9 rounded-xl flex items-center justify-center text-white font-black text-xs bg-{{ $block['color_name'] }}-500 shadow-sm">
                                        {{ explode(' ', $block['name'])[1] ?? substr($block['name'], 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800 dark:text-slate-100">
                                            {{ $block['name'] }}
                                        </p>
                                        <p class="text-[10px] text-slate-400 font-medium">{{ $block['area_ha'] }}
                                            Ha</p>
                                    </div>
                                </div>
                            </td>
                            <!-- Luas Tanah -->
                            <td class="px-6 py-4 text-center">
                                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                                    {{ $block['area_ha'] }}
                                </span>
                            </td>
                            <!-- Waktu Pengukuran -->
                            <td class="px-6 py-4 text-center">
                                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                                    {{
                                        isset($block['raw_nutrients']['measured_at']) 
                                            ? \Carbon\Carbon::parse($block['raw_nutrients']['measured_at'])->translatedFormat('l, d F Y')
                                            : '-' 
                                    }}
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

                {{-- Pagination --}}
                @if ($blocks->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 dark:border-white/5 flex items-center justify-between">
                    <p class="text-xs text-slate-400">
                        Menampilkan {{ $blocks->firstItem() }}–{{ $blocks->lastItem() }} dari {{ $blocks->total() }} blok
                    </p>
                    <div>
                        {{ $blocks->links() }}
                    </div>
                </div>
                @endif
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
                <div class="h-1 w-full shrink-0" :class="'bg-' + selectedBlock.color_name + '-500'">
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
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center text-white font-black text-sm shadow-sm"
                            :class="'bg-' + selectedBlock.color_name + '-500'">
                            <span x-text="selectedBlock.name.split(' ')[1] || selectedBlock.name.substring(0,2)"></span>
                        </div>
                        <div>
                            <h2 class="text-lg font-black text-slate-800 dark:text-slate-100"
                                x-text="selectedBlock.name"></h2>
                            <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider"
                                x-text="selectedBlock.area_ha + ' Ha'">
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Scrollable Content -->
                <div class="flex-1 overflow-y-auto p-4 space-y-6">

                    <!-- Fertility Status Card -->
                    <div class="p-5 rounded-2xl relative overflow-hidden text-white shadow-lg"
                        :class="
                            selectedBlock.status === 'Subur' ? 'bg-gradient-to-br from-emerald-500 to-emerald-700' :
                            (selectedBlock.status === 'Kurang Subur' ? 'bg-gradient-to-br from-amber-500 to-amber-700' :
                            'bg-gradient-to-br from-rose-500 to-rose-700')
                        ">
                        <p class="text-[9px] font-black text-white/70 uppercase tracking-widest mb-1">Prediksi Status Kesuburan </p>
                        <h4 class="text-3xl font-black mb-4" x-text="selectedBlock.status"></h4>

                        <div class="mt-4 pt-4 border-t border-white/20">
                            <p class="text-[9px] text-white/70 uppercase font-black tracking-wider mb-2">Probabilitas Prediksi</p>
                            <div class="space-y-2">
                                <template x-for="(prob, statusKey) in selectedBlock.analysis.probabilities" :key="statusKey">
                                    <div>
                                        <div class="flex justify-between text-[10px] font-bold mb-1">
                                            <span x-text="statusKey" class="text-white"></span>
                                            <span x-text="Math.round(prob * 100) + '%'" class="text-white"></span>
                                        </div>
                                        <div class="h-1.5 w-full bg-black/20 rounded-full overflow-hidden">
                                            <div class="h-full bg-white rounded-full" :style="`width: ${prob * 100}%`"></div>
                                        </div>
                                    </div>
                                </template>
                                <div x-show="!selectedBlock.analysis.probabilities || Object.keys(selectedBlock.analysis.probabilities).length === 0" class="text-xs text-white/80 italic">
                                    Probabilitas tidak tersedia untuk data historis ini.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recommendation -->
                    <div class="rounded-xl border overflow-hidden"
                        :class="
                            selectedBlock.status === 'Subur' ? 'bg-emerald-50 dark:bg-emerald-900/10 border-emerald-100 dark:border-emerald-800/30' :
                            (selectedBlock.status === 'Kurang Subur' ? 'bg-amber-50 dark:bg-amber-900/10 border-amber-100 dark:border-amber-800/30' :
                            'bg-rose-50 dark:bg-rose-900/10 border-rose-100 dark:border-rose-800/30')
                        "
                        x-data="{
                            thresholds: {
                                nitrogen:       { label: 'Nitrogen (N)',    unit: 'mg/kg', min: 320.00, max: 354.50, fertilizer: 'Urea atau ZA', icon: 'N' },
                                phosphorus:     { label: 'Fosfor (P)',      unit: 'mg/kg', min: 12.15,  max: 20.60,  fertilizer: 'SP-36 atau TSP', icon: 'P' },
                                potassium:      { label: 'Kalium (K)',      unit: 'mg/kg', min: 422.00, max: 602.00, fertilizer: 'KCl atau MOP', icon: 'K' },
                                ph:             { label: 'pH Tanah',        unit: '',      min: 7.38,   max: 7.81,   fertilizer: 'Dolomit / Belerang', icon: 'pH' },
                                ec:             { label: 'EC',              unit: 'dS/m',  min: 0.42,   max: 0.62,   fertilizer: 'Perbaiki drainase & irigasi', icon: 'EC' },
                                organic_carbon: { label: 'C-Organik',      unit: '%',     min: 0.47,   max: 0.88,   fertilizer: 'Kompos atau pupuk kandang', icon: 'CO' },
                                s:              { label: 'Sulfur (S)',      unit: 'mg/kg', min: 4.22,   max: 7.54,   fertilizer: 'ZA atau Kieserit', icon: 'S' },
                                magnesium:      { label: 'Magnesium (Mg)', unit: 'cmol',  min: 1.90,   max: 2.61,   fertilizer: 'Kieserit atau Dolomit', icon: 'Mg' },
                                boron:          { label: 'Boron (B)',       unit: 'mg/kg', min: 0.32,   max: 0.66,   fertilizer: 'Borax atau Solubor', icon: 'B' },
                            },
                            get nutrients() { return selectedBlock?.raw_nutrients ?? {}; },
                            get issues() {
                                const items = [];
                                const n = this.nutrients;
                                for (const [key, t] of Object.entries(this.thresholds)) {
                                    const val = parseFloat(n[key] ?? 0);
                                    if (val < t.min) {
                                        items.push({
                                            icon: t.icon,
                                            label: t.label,
                                            fertilizer: t.fertilizer,
                                            type: 'kurang',
                                            diff: (t.min - val).toFixed(2),
                                            unit: t.unit
                                        });
                                    } else if (val > t.max) {
                                        items.push({
                                            icon: t.icon,
                                            label: t.label,
                                            fertilizer: t.fertilizer,
                                            type: 'lebih',
                                            diff: (val - t.max).toFixed(2),
                                            unit: t.unit
                                        });
                                    }
                                }
                                return items;
                            }
                        }">

                        {{-- Header --}}
                        <div class="p-3 flex items-center gap-2 border-b"
                            :class="
                                selectedBlock.status === 'Subur' ? 'border-emerald-100 dark:border-emerald-800/30' :
                                (selectedBlock.status === 'Kurang Subur' ? 'border-amber-100 dark:border-amber-800/30' :
                                'border-rose-100 dark:border-rose-800/30')">
                            <div class="w-6 h-6 rounded-lg flex items-center justify-center"
                                :class="
                                    selectedBlock.status === 'Subur' ? 'bg-emerald-100 dark:bg-emerald-900/30' :
                                    (selectedBlock.status === 'Kurang Subur' ? 'bg-amber-100 dark:bg-amber-900/30' :
                                    'bg-rose-100 dark:bg-rose-900/30')">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    :class="
                                        selectedBlock.status === 'Subur' ? 'text-emerald-600 dark:text-emerald-400' :
                                        (selectedBlock.status === 'Kurang Subur' ? 'text-amber-600 dark:text-amber-400' :
                                        'text-rose-600 dark:text-rose-400')">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <h5 class="text-[10px] font-black uppercase tracking-widest"
                                :class="
                                    selectedBlock.status === 'Subur' ? 'text-emerald-700 dark:text-emerald-400' :
                                    (selectedBlock.status === 'Kurang Subur' ? 'text-amber-700 dark:text-amber-400' :
                                    'text-rose-700 dark:text-rose-400')">
                                Rekomendasi Pemupukan
                            </h5>
                            {{-- Badge jumlah masalah --}}
                            <span x-show="issues.length > 0"
                                class="ml-auto text-[9px] font-black px-2 py-0.5 rounded-full text-white"
                                :class="
                                    selectedBlock.status === 'Subur' ? 'bg-emerald-500' :
                                    (selectedBlock.status === 'Kurang Subur' ? 'bg-amber-500' : 'bg-rose-500')"
                                x-text="issues.length + ' item'">
                            </span>
                        </div>

                        {{-- Kondisi Optimal --}}
                        <div x-show="issues.length === 0" class="p-3">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-emerald-700 dark:text-emerald-400 mb-1">Semua Hara Optimal</p>
                                    <p class="text-[11px] text-emerald-600/80 dark:text-emerald-300/70 leading-relaxed">
                                        Pertahankan jadwal pemupukan rutin setiap 3 bulan dan lakukan uji tanah berkala.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Daftar Item Masalah --}}
                        <div x-show="issues.length > 0" class="px-3 py-3 space-y-2">
                            <template x-for="(item, idx) in issues" :key="idx">
                                <div class="flex items-start gap-3 p-3 rounded-xl"
                                    :class="
                                        selectedBlock.status === 'Subur' ? 'bg-white dark:bg-emerald-900/20' :
                                        (selectedBlock.status === 'Kurang Subur' ? 'bg-white dark:bg-amber-900/20' :
                                        'bg-white dark:bg-rose-900/20')">

                                    {{-- Icon Unsur --}}
                                    <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white font-black text-[10px] shrink-0 shadow-sm"
                                        :class="
                                            selectedBlock.status === 'Subur' ? 'bg-emerald-500' :
                                            (selectedBlock.status === 'Kurang Subur' ? 'bg-amber-500' : 'bg-rose-500')"
                                        x-text="item.icon">
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        {{-- Nama unsur + arah --}}
                                        <div class="flex items-center gap-1.5 mb-1 flex-wrap">
                                            <span class="text-[11px] font-bold text-slate-700 dark:text-slate-200" x-text="item.label"></span>
                                            <span class="text-[9px] font-black px-1.5 py-0.5 rounded-md"
                                                :class="item.type === 'kurang'
                                                    ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400'
                                                    : 'bg-orange-50 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400'"
                                                x-text="item.type === 'kurang' ? '▼ KURANG' : '▲ BERLEBIH'">
                                            </span>
                                        </div>

                                        {{-- Pupuk yang direkomendasikan --}}
                                        <p class="text-[11px] font-semibold text-slate-600 dark:text-slate-300" x-text="item.fertilizer"></p>

                                        {{-- Selisih --}}
                                        <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-0.5">
                                            <span x-text="item.type === 'kurang' ? 'Kurang ' : 'Lebih '"></span>
                                            <span class="font-bold"
                                                :class="item.type === 'kurang' ? 'text-blue-500' : 'text-orange-500'"
                                                x-text="item.diff + (item.unit ? ' ' + item.unit : '')">
                                            </span>
                                            <span x-text="item.type === 'kurang' ? ' dari minimum' : ' dari batas aman'"></span>
                                        </p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="p-5 border-t border-slate-100 dark:border-white/5 shrink-0">
                    <a :href="`{{ route('block.detail', ['id' => '__ID__']) }}`.replace('__ID__', selectedBlock.id)" wire:navigate
                        class="w-full flex items-center justify-center py-3 rounded-xl text-white text-xs font-black uppercase tracking-widest transition-all hover:scale-[1.02] active:scale-[0.98] shadow-md shadow-emerald-500/20"
                        style="background:linear-gradient(135deg,#10b981,#059669)">
                        Lihat Analisis Lengkap
                    </a>
                </div>
            </div>
        </div>
    </template>

</div>

<script>
    document.addEventListener("livewire:navigated", initApp);
    document.addEventListener("DOMContentLoaded", initApp);

    function initApp() {
        initMap();
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
            }
        });

        const extent = vectorSource.getExtent();
        if (!ol.extent.isEmpty(extent)) map.getView().fit(extent, {
            padding: [80, 80, 80, 80]
        });
    }
</script>