<div class="p-6 lg:p-8 space-y-6 max-w-7xl mx-auto" x-data="{ activeTab: @entangle('activeTab') }">

    <!-- ══ HEADER ══ -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-100 tracking-tight">Laporan & Cetak Dokumen</h1>
            <p class="text-slate-400 dark:text-slate-500 text-sm mt-0.5">Filter data dan export ke dalam format PDF atau Excel.</p>
        </div>
    </div>

    <!-- ══ TABS ══ -->
    <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-hide">
        <button wire:click="setTab('fertility')" 
            class="px-5 py-2.5 rounded-xl text-sm font-semibold transition-all whitespace-nowrap border"
            :class="activeTab === 'fertility' ? 'bg-emerald-500 text-white border-emerald-500 shadow-md shadow-emerald-500/20' : 'bg-white dark:bg-slate-800 text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-700 border-slate-200 dark:border-white/5'">
            Rekap Kesuburan Tanah
        </button>
        <button wire:click="setTab('recommendation')" 
            class="px-5 py-2.5 rounded-xl text-sm font-semibold transition-all whitespace-nowrap border"
            :class="activeTab === 'recommendation' ? 'bg-amber-500 text-white border-amber-500 shadow-md shadow-amber-500/20' : 'bg-white dark:bg-slate-800 text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-700 border-slate-200 dark:border-white/5'">
            Rekomendasi Pemupukan
        </button>
        <button wire:click="setTab('history')" 
            class="px-5 py-2.5 rounded-xl text-sm font-semibold transition-all whitespace-nowrap border"
            :class="activeTab === 'history' ? 'bg-indigo-500 text-white border-indigo-500 shadow-md shadow-indigo-500/20' : 'bg-white dark:bg-slate-800 text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-700 border-slate-200 dark:border-white/5'">
            Riwayat Pengukuran
        </button>
    </div>

    <!-- ══ FILTER & EXPORT ACTION ══ -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-white/5 shadow-sm p-5">
        <div class="flex flex-col xl:flex-row gap-5 items-start xl:items-end justify-between">
            
            <!-- Filters -->
            <div class="flex-1 grid grid-cols-1 md:grid-cols-4 gap-4 w-full">
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Pilih Blok</label>
                    <select wire:model.live="filterBlock" class="w-full px-3 py-2.5 rounded-xl text-sm text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-700/50 focus:outline-none focus:border-emerald-400 transition font-medium">
                        <option value="">Semua Blok</option>
                        @foreach($blocks as $b)
                            <option value="{{ $b->id }}">{{ $b->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Status</label>
                    <select wire:model.live="filterStatus" class="w-full px-3 py-2.5 rounded-xl text-sm text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-700/50 focus:outline-none focus:border-emerald-400 transition font-medium">
                        <option value="">Semua Status</option>
                        <option value="Subur">Subur</option>
                        <option value="Kurang Subur">Kurang Subur</option>
                        <option value="Tidak Subur">Tidak Subur</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Dari Tanggal</label>
                    <input type="date" wire:model.live="filterDateFrom" class="w-full px-3 py-2.5 rounded-xl text-sm text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-700/50 focus:outline-none focus:border-emerald-400 transition font-medium">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Sampai Tanggal</label>
                    <input type="date" wire:model.live="filterDateTo" class="w-full px-3 py-2.5 rounded-xl text-sm text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-700/50 focus:outline-none focus:border-emerald-400 transition font-medium">
                </div>
            </div>

            <!-- Export Buttons -->
            <div class="flex items-center gap-3 shrink-0 pt-2 xl:pt-0">
                <button wire:click="resetFilters" class="px-4 py-2.5 rounded-xl text-slate-500 dark:text-slate-400 text-sm font-medium border border-slate-200 dark:border-white/10 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition">
                    Reset Filter
                </button>

                <div class="h-8 w-px bg-slate-200 dark:bg-white/10 mx-1"></div>

                <button wire:click="exportPdf(activeTab)" wire:loading.attr="disabled"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-white text-sm font-semibold transition-all hover:scale-105 active:scale-95 shadow-sm bg-rose-500 hover:bg-rose-600 shadow-rose-500/20 disabled:opacity-70 disabled:hover:scale-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>Cetak PDF</span>
                </button>

                <button wire:click="exportExcel(activeTab)" wire:loading.attr="disabled"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-white text-sm font-semibold transition-all hover:scale-105 active:scale-95 shadow-sm bg-emerald-500 hover:bg-emerald-600 shadow-emerald-500/20 disabled:opacity-70 disabled:hover:scale-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>Cetak Excel</span>
                </button>
            </div>
        </div>
    </div>

    <!-- ══ PREVIEW TABLE ══ -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-white/5 shadow-sm overflow-hidden flex flex-col">
        <div class="px-6 py-5 border-b border-slate-100 dark:border-white/5">
            <h4 class="text-sm font-bold text-slate-700 dark:text-slate-200 flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                Preview Laporan (Top 10 Data)
            </h4>
        </div>

        <div class="overflow-x-auto relative">
            
            
            <table class="w-full text-left">
                @if($activeTab === 'fertility' || $activeTab === 'history')
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-700/30">
                            <th class="px-4 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tgl Ukur</th>
                            <th class="px-4 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Blok</th>
                            <th class="px-4 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Status</th>
                            <th class="px-4 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">N</th>
                            <th class="px-4 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">P</th>
                            <th class="px-4 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">K</th>
                            <th class="px-4 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">pH</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                        @forelse($previewData as $item)
                            @php
                                $isHistory = ($activeTab === 'history');
                                $blockName = $isHistory ? ($item->block->name ?? '-') : $item->name;
                                $n = $isHistory ? $item : $item->nutrients->first();
                            @endphp
                            <tr class="hover:bg-slate-50 dark:hover:bg-white/[0.02] transition-colors">
                                <td class="px-4 py-3 text-xs font-semibold text-slate-500 dark:text-slate-400">
                                    {{ $n && $n->measured_at ? $n->measured_at->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-4 py-3 text-sm font-bold text-slate-800 dark:text-slate-100">{{ $blockName }}</td>
                                <td class="px-4 py-3">
                                    @php 
                                        $status = $n->fertility_status ?? '-'; 
                                        $color = match($status) {
                                            'Subur' => 'emerald',
                                            'Kurang Subur' => 'amber',
                                            'Tidak Subur' => 'rose',
                                            default => 'slate'
                                        };
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-{{ $color }}-50 dark:bg-{{ $color }}-900/20 text-{{ $color }}-600 dark:text-{{ $color }}-400">
                                        <span class="w-1.5 h-1.5 rounded-full bg-{{ $color }}-500"></span>
                                        {{ $status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-xs text-center font-medium">{{ $n->nitrogen ?? '-' }}</td>
                                <td class="px-4 py-3 text-xs text-center font-medium">{{ $n->phosphorus ?? '-' }}</td>
                                <td class="px-4 py-3 text-xs text-center font-medium">{{ $n->potassium ?? '-' }}</td>
                                <td class="px-4 py-3 text-xs text-center font-medium">{{ $n->ph ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-slate-500 text-sm">Tidak ada data yang sesuai filter.</td>
                            </tr>
                        @endforelse
                    </tbody>
                
                @elseif($activeTab === 'recommendation')
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-700/30">
                            <th class="px-6 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest w-1/4">Blok</th>
                            <th class="px-6 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest w-1/4">Status</th>
                            <th class="px-6 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest w-1/2">Preview Evaluasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                        @forelse($previewData as $block)
                            @php
                                $n = $block->nutrients->first();
                                $status = $n->fertility_status ?? '-';
                                $color = match($status) {
                                    'Subur' => 'emerald',
                                    'Kurang Subur' => 'amber',
                                    'Tidak Subur' => 'rose',
                                    default => 'slate'
                                };
                            @endphp
                            <tr class="hover:bg-slate-50 dark:hover:bg-white/[0.02] transition-colors">
                                <td class="px-6 py-4 text-sm font-bold text-slate-800 dark:text-slate-100">{{ $block->name }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-{{ $color }}-50 dark:bg-{{ $color }}-900/20 text-{{ $color }}-600 dark:text-{{ $color }}-400">
                                        <span class="w-1.5 h-1.5 rounded-full bg-{{ $color }}-500"></span>
                                        {{ $status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                                    <i>Lihat dokumen lengkap untuk detail rekomendasi unsur yang kurang.</i>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-slate-500 text-sm">Semua blok subur atau tidak ada data yang cocok.</td>
                            </tr>
                        @endforelse
                    </tbody>
                @endif
            </table>
        </div>
    </div>
</div>
