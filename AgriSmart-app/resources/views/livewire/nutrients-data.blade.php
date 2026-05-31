<div class="p-6 lg:p-8 space-y-6 max-w-7xl mx-auto">

    <!-- ══ HEADER ══ -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-100 tracking-tight">Data Unsur Hara</h1>
            <p class="text-slate-400 dark:text-slate-500 text-sm mt-0.5">Manajemen dan pemantauan data laboratorium unsur hara per blok kebun.</p>
        </div>
        <button wire:click="openAddModal"
            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-white text-sm font-semibold transition-all hover:scale-105 active:scale-95 shadow-md shadow-emerald-500/20 self-start md:self-auto"
            style="background:linear-gradient(135deg,#10b981,#059669)">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Data
        </button>
    </div>

    <!-- ══ FILTER BAR ══ -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-white/5 shadow-sm p-4">
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input wire:model.live="search" type="text" placeholder="Cari nama blok..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl text-sm text-slate-700 dark:text-slate-300 placeholder-slate-400 dark:placeholder-slate-600 border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-700/50 focus:outline-none focus:border-emerald-400 dark:focus:border-emerald-500/50 transition" />
            </div>
            <div class="relative">
                <div class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z" />
                    </svg>
                </div>
                <select wire:model.live="statusFilter"
                    class="pl-9 pr-9 py-2.5 rounded-xl text-sm text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-700/50 focus:outline-none focus:border-emerald-400 transition appearance-none font-medium min-w-[170px]">
                    <option value="">Semua Status</option>
                    <option value="Subur">Subur</option>
                    <option value="Kurang Subur">Kurang Subur</option>
                    <option value="Tidak Subur">Tidak Subur</option>
                </select>
                <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- ══ TABLE ══ -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-white/5 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-700/30 border-b border-slate-100 dark:border-white/5 text-center">
                        <th class="px-4 py-3 text-xs font-semibold text-slate-400 uppercase">Blok</th>
                        <th class="px-4 py-3 text-xs font-semibold text-slate-400 uppercase">Ha</th>
                        <th class="px-4 py-3 text-xs font-semibold text-slate-400 uppercase">Detail</th>
                        <th class="px-4 py-3 text-xs font-semibold text-slate-400 uppercase">Status</th>
                        <th class="px-4 py-3 text-xs font-semibold text-slate-400 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-white/5">
                    @forelse($blocks as $block)
                    <tr class="group hover:bg-slate-50 dark:hover:bg-white/[0.02] transition-colors duration-150">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl flex items-center justify-center font-black text-xs text-white flex-shrink-0
                                    @if ($block['color'] == 'emerald') bg-emerald-500
                                    @elseif($block['color'] == 'amber') bg-amber-500
                                    @else bg-rose-500 @endif">
                                    {{ substr($block['name'], 0, 1) }}
                                </div>
                                <p class="text-sm font-bold text-slate-800 dark:text-slate-100 whitespace-nowrap">{{ $block['name'] }}</p>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="text-sm font-medium text-slate-600 dark:text-slate-400">{{ number_format($block['area_ha'], 1) }}</span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <button wire:click="showDetail({{ $block['id'] }})"
                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-500/10 text-blue-600 hover:bg-blue-500/20 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0A9 9 0 113 12a9 9 0 0118 0z" />
                                </svg>
                                Detail
                            </button>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold border
                                @if ($block['color'] == 'emerald') bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 border-emerald-100 dark:border-emerald-800/30
                                @elseif($block['color'] == 'amber') bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-400 border-amber-100 dark:border-amber-800/30
                                @else bg-rose-50 dark:bg-rose-900/20 text-rose-700 dark:text-rose-400 border-rose-100 dark:border-rose-800/30 @endif">
                                <span class="w-1.5 h-1.5 rounded-full
                                    @if ($block['color'] == 'emerald') bg-emerald-500
                                    @elseif($block['color'] == 'amber') bg-amber-500
                                    @else bg-rose-500 @endif"></span>
                                {{ $block['status'] }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-center gap-2">
                                <button wire:click="editBlock({{ $block['id'] }})"
                                    class="w-8 h-8 rounded-lg flex items-center justify-center transition-all hover:scale-110"
                                    style="background:rgba(245,158,11,.15);color:#d97706" title="Edit">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button wire:click="deleteBlock({{ $block['id'] }})"
                                    wire:confirm="Yakin ingin menghapus data blok ini dan semua data haranya?"
                                    class="w-8 h-8 rounded-lg flex items-center justify-center transition-all hover:scale-110"
                                    style="background:rgba(251,113,133,.15);color:#fb7185" title="Hapus">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-14 h-14 rounded-2xl flex items-center justify-center" style="background:#10b98112">
                                    <svg class="w-7 h-7 text-emerald-400/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                </div>
                                <p class="text-slate-400 font-medium text-sm">Tidak ada data ditemukan.</p>
                                <button wire:click="openAddModal" class="text-emerald-600 text-xs font-semibold hover:underline">+ Tambah data pertama</button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($blocks->hasPages())
        <div class="flex items-center justify-between px-6 py-4 border-t border-slate-100 dark:border-white/5">
            <p class="text-xs text-slate-400">
                Menampilkan <span class="font-semibold text-slate-600 dark:text-slate-300">{{ $blocks->firstItem() }}</span>–<span class="font-semibold text-slate-600 dark:text-slate-300">{{ $blocks->lastItem() }}</span>
                dari <span class="font-semibold text-slate-600 dark:text-slate-300">{{ $blocks->total() }}</span> data
            </p>
            <div class="flex items-center gap-1">
                <button wire:click="previousPage" @disabled(!$blocks->onFirstPage())
                    class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 border border-slate-200 dark:border-white/10 bg-white dark:bg-transparent hover:border-emerald-300 hover:text-emerald-500 transition disabled:opacity-30 disabled:cursor-not-allowed">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                @foreach ($blocks->getUrlRange(1, $blocks->lastPage()) as $page => $url)
                <button wire:click="gotoPage({{ $page }})"
                    class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-semibold border transition-all duration-150
                        {{ $blocks->currentPage() == $page ? 'text-white border-transparent shadow-sm shadow-emerald-500/20' : 'text-slate-500 dark:text-slate-400 border-slate-200 dark:border-white/10 bg-white dark:bg-transparent hover:border-emerald-300 hover:text-emerald-500' }}"
                    style="{{ $blocks->currentPage() == $page ? 'background:linear-gradient(135deg,#10b981,#059669)' : '' }}">
                    {{ $page }}
                </button>
                @endforeach
                <button wire:click="nextPage" @disabled($blocks->onLastPage())
                    class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 border border-slate-200 dark:border-white/10 bg-white dark:bg-transparent hover:border-emerald-300 hover:text-emerald-500 transition disabled:opacity-30 disabled:cursor-not-allowed">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
        @endif
    </div>

    <!-- ══ MODAL FORM ══ -->
    @if ($showModal)
    <div class="fixed inset-0 z-[100] flex items-center justify-center p-4" style="background:rgba(15,23,42,.55);backdrop-filter:blur(8px)">
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-2xl flex flex-col max-h-[90vh] border border-slate-200 dark:border-white/10 overflow-hidden"
            style="box-shadow:0 25px 60px rgba(0,0,0,.15),0 0 0 1px rgba(16,185,129,.08)">

            <div class="h-1 w-full shrink-0" style="background:linear-gradient(90deg,#10b981,#059669,#047857)"></div>

            <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100 dark:border-white/5 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background:#10b98115">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if ($isEdit)
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            @endif
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-800 dark:text-slate-100">{{ $isEdit ? 'Edit Data Blok & Hara' : 'Tambah Data Blok & Hara' }}</h3>
                        <p class="text-[10px] text-slate-400 font-medium mt-0.5">{{ $isEdit ? 'Perbarui informasi blok dan pengukuran hara' : 'Isi form untuk menambahkan data blok baru' }}</p>
                    </div>
                </div>
                <button wire:click="closeModal" class="w-8 h-8 rounded-xl flex items-center justify-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-white/5 transition shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form wire:submit.prevent="save" class="flex flex-col flex-1 overflow-hidden">
                <div class="overflow-y-auto px-6 py-6 space-y-7 flex-1">

                    {{-- Informasi Blok --}}
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <span class="w-5 h-5 rounded-md flex items-center justify-center shrink-0" style="background:#10b98115">
                                <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6z" />
                                </svg>
                            </span>
                            <h4 class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Informasi Blok</h4>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Nama Blok <span class="text-rose-400 normal-case font-normal">*</span></label>
                                <input wire:model="name" type="text" placeholder="Contoh: Blok A1"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm text-slate-700 dark:text-slate-300 placeholder-slate-300 dark:placeholder-slate-600 border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-800/60 focus:outline-none focus:border-emerald-400 dark:focus:border-emerald-500/50 transition" required />
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Luas (Ha) <span class="text-rose-400 normal-case font-normal">*</span></label>
                                    <input wire:model="area_ha" type="number" step="0.01" placeholder="0.00"
                                        class="w-full px-4 py-2.5 rounded-xl text-sm text-slate-700 dark:text-slate-300 placeholder-slate-300 dark:placeholder-slate-600 border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-800/60 focus:outline-none focus:border-emerald-400 transition" required />
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Tgl Tanam <span class="text-rose-400 normal-case font-normal">*</span></label>
                                    <input wire:model="planted_at" type="date"
                                        class="w-full px-4 py-2.5 rounded-xl text-sm text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-800/60 focus:outline-none focus:border-emerald-400 transition" required />
                                </div>
                            </div>
                            @foreach ([['coord_1','Titik 1 – Barat Laut'],['coord_2','Titik 2 – Timur Laut'],['coord_3','Titik 3 – Tenggara'],['coord_4','Titik 4 – Barat Daya']] as [$field, $label])
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">{{ $label }}</label>
                                <input wire:model="{{ $field }}" type="text" placeholder="Lng, Lat (Cth: 101.44, 0.50)"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm text-slate-700 dark:text-slate-300 placeholder-slate-300 dark:placeholder-slate-600 border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-800/60 focus:outline-none focus:border-emerald-400 transition font-mono" />
                            </div>
                            @endforeach
                            <div class="md:col-span-2">
                                <div class="flex items-start gap-2.5 p-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-white/5">
                                    <svg class="w-4 h-4 text-slate-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed">
                                        Masukkan koordinat dipisah koma <strong class="font-semibold">(Bujur, Lintang)</strong>. Keempat titik harus membentuk polygon searah atau berlawanan jarum jam.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-dashed border-slate-200 dark:border-white/5"></div>

                    {{-- Pengukuran Hara --}}
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <span class="w-5 h-5 rounded-md flex items-center justify-center shrink-0" style="background:#10b98115">
                                <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </span>
                            <h4 class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Pengukuran Hara Terakhir</h4>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">

                            {{-- N --}}
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Nitrogen / N (mg/kg)</label>
                                <input wire:model="nitrogen" type="number" step="0.1" placeholder="0.0"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm text-slate-700 dark:text-slate-300 placeholder-slate-300 dark:placeholder-slate-600 border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-800/60 focus:outline-none focus:border-emerald-400 transition font-mono" />
                            </div>

                            {{-- P --}}
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Fosfor / P (ppm)</label>
                                <input wire:model="phosphorus" type="number" step="0.1" placeholder="0.0"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm text-slate-700 dark:text-slate-300 placeholder-slate-300 dark:placeholder-slate-600 border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-800/60 focus:outline-none focus:border-emerald-400 transition font-mono" />
                            </div>

                            {{-- K --}}
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Kalium / K (mg/kg)</label>
                                <input wire:model="potassium" type="number" step="1" placeholder="0"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm text-slate-700 dark:text-slate-300 placeholder-slate-300 dark:placeholder-slate-600 border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-800/60 focus:outline-none focus:border-emerald-400 transition font-mono" />
                            </div>

                            {{-- pH --}}
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">pH Tanah</label>
                                <input wire:model="ph" type="number" step="0.01" placeholder="0.00"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm text-slate-700 dark:text-slate-300 placeholder-slate-300 dark:placeholder-slate-600 border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-800/60 focus:outline-none focus:border-emerald-400 transition font-mono" />
                            </div>

                            {{-- EC --}}
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">EC (dS/m)</label>
                                <input wire:model="ec" type="number" step="0.01" placeholder="0.00"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm text-slate-700 dark:text-slate-300 placeholder-slate-300 dark:placeholder-slate-600 border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-800/60 focus:outline-none focus:border-emerald-400 transition font-mono" />
                            </div>

                            {{-- OC --}}
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">C-Organik / OC (%)</label>
                                <input wire:model="organic_carbon" type="number" step="0.01" placeholder="0.00"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm text-slate-700 dark:text-slate-300 placeholder-slate-300 dark:placeholder-slate-600 border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-800/60 focus:outline-none focus:border-emerald-400 transition font-mono" />
                            </div>

                            {{-- S --}}
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Sulfur / S (ppm)</label>
                                <input wire:model="s" type="number" step="0.01" placeholder="0.00"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm text-slate-700 dark:text-slate-300 placeholder-slate-300 dark:placeholder-slate-600 border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-800/60 focus:outline-none focus:border-emerald-400 transition font-mono" />
                            </div>

                            {{-- Mg --}}
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Magnesium / Mg (cmol)</label>
                                <input wire:model="magnesium" type="number" step="0.01" placeholder="0.00"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm text-slate-700 dark:text-slate-300 placeholder-slate-300 dark:placeholder-slate-600 border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-800/60 focus:outline-none focus:border-emerald-400 transition font-mono" />
                            </div>

                            {{-- B --}}
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Boron / B (ppm)</label>
                                <input wire:model="boron" type="number" step="0.001" placeholder="0.000"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm text-slate-700 dark:text-slate-300 placeholder-slate-300 dark:placeholder-slate-600 border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-800/60 focus:outline-none focus:border-emerald-400 transition font-mono" />
                            </div>

                            {{-- Tanggal --}}
                            <div class="col-span-2 md:col-span-3">
                                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Tanggal Pengukuran <span class="text-rose-400 normal-case font-normal">*</span></label>
                                <input wire:model="measured_at" type="date"
                                    class="w-full md:w-1/3 px-4 py-2.5 rounded-xl text-sm text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-800/60 focus:outline-none focus:border-emerald-400 transition" required />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-2 px-6 py-4 bg-slate-50 dark:bg-white/[0.02] border-t border-slate-100 dark:border-white/5 shrink-0">
                    <button type="button" wire:click="closeModal"
                        class="px-5 py-2.5 rounded-xl text-slate-500 dark:text-slate-400 text-sm font-medium border border-slate-200 dark:border-white/10 hover:bg-white dark:hover:bg-white/5 transition">Batal</button>
                    <button type="submit"
                        class="px-6 py-2.5 rounded-xl text-white text-sm font-semibold shadow-md shadow-emerald-500/20 transition-all hover:scale-105 active:scale-95"
                        style="background:linear-gradient(135deg,#10b981,#059669)">
                        {{ $isEdit ? 'Simpan Perubahan' : 'Tambahkan Data' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- ══ MODAL DETAIL ══ -->
    @if ($showDetailModal)
    <div class="fixed inset-0 z-[100] flex items-center justify-center p-4" style="background:rgba(15,23,42,.55);backdrop-filter:blur(8px)">
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-2xl flex flex-col max-h-[90vh] border border-slate-200 dark:border-white/10 overflow-hidden"
            style="box-shadow:0 25px 60px rgba(0,0,0,.15),0 0 0 1px rgba(16,185,129,.08)">

            <div class="h-1 w-full shrink-0" style="background:linear-gradient(90deg,#10b981,#059669,#047857)"></div>

            <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100 dark:border-white/5 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background:#10b98115">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h4" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13a9 9 0 1118 0A9 9 0 013 13z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-800 dark:text-slate-100">Detail Unsur Hara</h3>
                        <p class="text-[10px] text-slate-400 font-medium mt-0.5">Informasi kesuburan dan kandungan tanah blok</p>
                    </div>
                </div>
                <button wire:click="$set('showDetailModal', false)"
                    class="w-8 h-8 rounded-xl flex items-center justify-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-white/5 transition shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="overflow-y-auto px-6 py-6 space-y-7 flex-1">

                {{-- Info Blok --}}
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="w-5 h-5 rounded-md flex items-center justify-center shrink-0" style="background:#10b98115">
                            <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <h4 class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Informasi Blok</h4>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="rounded-2xl border border-slate-100 dark:border-white/5 bg-slate-50 dark:bg-slate-800/50 p-4">
                            <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide mb-1">Nama Blok</p>
                            <p class="text-sm font-bold text-slate-700 dark:text-slate-100">{{ $selectedBlock['name'] ?? '-' }}</p>
                        </div>
                        <div class="rounded-2xl border border-slate-100 dark:border-white/5 bg-slate-50 dark:bg-slate-800/50 p-4">
                            <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide mb-1">Luas Area</p>
                            <p class="text-sm font-bold text-slate-700 dark:text-slate-100">{{ $selectedBlock['area_ha'] ?? 0 }} Ha</p>
                        </div>
                        <div class="rounded-2xl border border-slate-100 dark:border-white/5 bg-slate-50 dark:bg-slate-800/50 p-4">
                            <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide mb-1">Status</p>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold border
                                @if (($selectedBlock['color'] ?? '') == 'emerald') bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 border-emerald-100 dark:border-emerald-800/30
                                @elseif(($selectedBlock['color'] ?? '') == 'amber') bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-400 border-amber-100 dark:border-amber-800/30
                                @else bg-rose-50 dark:bg-rose-900/20 text-rose-700 dark:text-rose-400 border-rose-100 dark:border-rose-800/30 @endif">
                                {{ $selectedBlock['status'] ?? '-' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Probabilities dari ML --}}
                @if(!empty($selectedBlock['probabilities']))
                <div class="rounded-2xl border border-slate-100 dark:border-white/5 bg-slate-50 dark:bg-slate-800/50 p-4">
                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide mb-3">Probabilitas Hasil Prediksi</p>
                    <div class="space-y-2">
                        @foreach($selectedBlock['probabilities'] as $label => $prob)
                        <div class="flex items-center gap-3">
                            <span class="text-xs text-slate-500 w-24 shrink-0">{{ $label }}</span>
                            <div class="flex-1 bg-slate-200 dark:bg-slate-700 rounded-full h-2">
                                <div class="h-2 rounded-full
                                    @if($label == 'Subur') bg-emerald-500
                                    @elseif($label == 'Kurang Subur') bg-amber-500
                                    @else bg-rose-500 @endif"
                                    style="width: {{ $prob * 100 }}%"></div>
                            </div>
                            <span class="text-xs font-bold text-slate-600 dark:text-slate-300 w-10 text-right">{{ round($prob * 100) }}%</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="border-t border-dashed border-slate-200 dark:border-white/5"></div>

                {{-- Kandungan Hara --}}
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="w-5 h-5 rounded-md flex items-center justify-center shrink-0" style="background:#10b98115">
                            <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </span>
                        <h4 class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Detail Kandungan Hara</h4>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach([
                            ['nitrogen',     'N – Nitrogen',    'mg/kg'],
                            ['phosphorus',   'P – Fosfor',      'ppm'  ],
                            ['potassium',    'K – Kalium',      'mg/kg'],
                            ['ph',           'pH Tanah',        ''     ],
                            ['ec',           'EC',              'dS/m' ],
                            ['organic_carbon','OC – C.Organik', '%'    ],
                            ['s',            'S – Sulfur',      'ppm'  ],
                            ['magnesium',    'Mg – Magnesium',  'cmol' ],
                            ['boron',        'B – Boron',       'ppm'  ],
                        ] as [$field, $label, $unit])
                        <div class="rounded-2xl border border-slate-100 dark:border-white/5 bg-slate-50 dark:bg-slate-800/50 p-4">
                            <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide mb-1">{{ $label }}</p>
                            <p class="text-lg font-black text-slate-700 dark:text-slate-100 font-mono">
                                {{ number_format($selectedBlock['nutrients'][$field] ?? 0, 2) }}
                                @if($unit)<span class="text-xs font-normal text-slate-400 ml-1">{{ $unit }}</span>@endif
                            </p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-2 px-6 py-4 bg-slate-50 dark:bg-white/[0.02] border-t border-slate-100 dark:border-white/5 shrink-0">
                <button wire:click="closeDetailModal"
                    class="px-5 py-2.5 rounded-xl text-slate-500 dark:text-slate-400 text-sm font-medium border border-slate-200 dark:border-white/10 hover:bg-white dark:hover:bg-white/5 transition">Tutup</button>
            </div>
        </div>
    </div>
    @endif
</div>