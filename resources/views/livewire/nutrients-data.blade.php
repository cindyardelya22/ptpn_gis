<div class="p-6 space-y-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-100 tracking-tight">Data Unsur Hara</h1>
            <p class="text-slate-500 text-sm mt-1">Manajemen dan pemantauan data laboratorium unsur hara per blok kebun.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <div class="relative">
                <input wire:model.live="search" type="text" placeholder="Cari block..."
                    class="pl-10 pr-4 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all outline-none w-64">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            <div class="relative">
                <select wire:model.live="statusFilter"
                    class="pl-4 pr-10 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all outline-none text-slate-600 dark:text-slate-300 appearance-none font-medium cursor-pointer min-w-[160px]">
                    <option value="">Semua Status</option>
                    <option value="Subur">Subur</option>
                    <option value="Cukup Subur">Cukup Subur</option>
                    <option value="Kurang Subur">Kurang Subur</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>

            <button wire:click="openAddModal"
                class="flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition-all shadow-lg shadow-emerald-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Data
            </button>
        </div>
    </div>

    <!-- Table Section -->
    <div
        class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-700">
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Nama Blok
                        </th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-center">
                            Luas (Ha)</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-center">
                            N (%)</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-center">
                            P (ppm)</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-center">
                            K (cmol)</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-center">
                            pH</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-center">
                            Mg (cmol)</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-center">
                            C-Org (%)</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status
                            Kesuburan</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-right">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($blocks as $block)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-lg bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 font-bold text-xs">
                                        {{ substr($block['name'], 0, 1) }}
                                    </div>
                                    <p class="text-sm font-bold text-slate-800 dark:text-slate-100">{{ $block['name'] }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="text-sm font-medium text-slate-600 dark:text-slate-300">{{ number_format($block['area_ha'], 1) }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="text-sm font-semibold {{ ($block['nutrients']['nitrogen'] ?? 0) < 2 ? 'text-red-500' : 'text-slate-700 dark:text-slate-200' }}">
                                    {{ number_format($block['nutrients']['nitrogen'] ?? 0, 2) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="text-sm font-semibold {{ ($block['nutrients']['phosphorus'] ?? 0) < 15 ? 'text-red-500' : 'text-slate-700 dark:text-slate-200' }}">
                                    {{ number_format($block['nutrients']['phosphorus'] ?? 0, 1) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="text-sm font-semibold {{ ($block['nutrients']['potassium'] ?? 0) < 0.2 ? 'text-red-500' : 'text-slate-700 dark:text-slate-200' }}">
                                    {{ number_format($block['nutrients']['potassium'] ?? 0, 2) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="text-sm font-semibold {{ ($block['nutrients']['ph'] ?? 0) < 5 ? 'text-amber-500' : 'text-slate-700 dark:text-slate-200' }}">
                                    {{ number_format($block['nutrients']['ph'] ?? 0, 1) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="text-sm font-semibold {{ ($block['nutrients']['magnesium'] ?? 0) < 0.25 ? 'text-red-500' : 'text-slate-700 dark:text-slate-200' }}">
                                    {{ number_format($block['nutrients']['magnesium'] ?? 0, 2) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="text-sm font-semibold {{ ($block['nutrients']['c_organic'] ?? 0) < 1.5 ? 'text-red-500' : 'text-slate-700 dark:text-slate-200' }}">
                                    {{ number_format($block['nutrients']['c_organic'] ?? 0, 1) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-[10px] font-bold uppercase tracking-wider border
                                                        @if($block['color'] == 'emerald') bg-emerald-50/50 text-emerald-600 border-emerald-200
                                                        @elseif($block['color'] == 'amber') bg-amber-50/50 text-amber-600 border-amber-200
                                                        @else bg-rose-50/50 text-rose-600 border-rose-200 @endif">
                                    <span
                                        class="w-1.5 h-1.5 rounded-full mr-2 @if($block['color'] == 'emerald') bg-emerald-500 @elseif($block['color'] == 'amber') bg-amber-500 @else bg-rose-500 @endif"></span>
                                    {{ $block['status'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button wire:click="editBlock({{ $block['id'] }})"
                                        class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all"
                                        title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <button wire:click="deleteBlock({{ $block['id'] }})"
                                        wire:confirm="Yakin ingin menghapus data blok ini dan semua data haranya?"
                                        class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all"
                                        title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <p class="text-slate-500 font-medium">Tidak ada data ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Form (Tambah/Edit) -->
    @if($showModal)
        <div
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm transition-opacity">
            <div
                class="bg-white dark:bg-slate-800 rounded-[2rem] shadow-2xl w-full max-w-3xl overflow-hidden flex flex-col max-h-[90vh]">
                <div
                    class="p-6 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between bg-slate-50/50 dark:bg-slate-800/50">
                    <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100">
                        {{ $isEdit ? 'Edit Data Blok & Hara' : 'Tambah Data Blok & Hara' }}
                    </h3>
                    <button wire:click="closeModal"
                        class="p-2 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-full transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="save" class="overflow-y-auto p-6 md:p-8 space-y-8">
                    <!-- Block Info Section -->
                    <div>
                        <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Informasi Blok</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">Nama Blok
                                    <span class="text-rose-500">*</span></label>
                                <input wire:model="name" type="text"
                                    class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all outline-none"
                                    required>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">Luas
                                        (Ha)
                                        <span class="text-rose-500">*</span></label>
                                    <input wire:model="area_ha" type="number" step="0.01"
                                        class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all outline-none"
                                        required>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">Tgl
                                        Tanam
                                        <span class="text-rose-500">*</span></label>
                                    <input wire:model="planted_at" type="date"
                                        class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all outline-none"
                                        required>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">Titik 1
                                    (Barat Laut)</label>
                                <input wire:model="coord_1" type="text" placeholder="Lng, Lat (Msl: 101.44, 0.50)"
                                    class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">Titik 2
                                    (Timur Laut)</label>
                                <input wire:model="coord_2" type="text" placeholder="Lng, Lat (Msl: 101.44, 0.50)"
                                    class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">Titik 3
                                    (Tenggara)</label>
                                <input wire:model="coord_3" type="text" placeholder="Lng, Lat (Msl: 101.44, 0.50)"
                                    class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">Titik 4
                                    (Barat Daya)</label>
                                <input wire:model="coord_4" type="text" placeholder="Lng, Lat (Msl: 101.44, 0.50)"
                                    class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all outline-none">
                            </div>
                            <div class="md:col-span-2">
                                <span
                                    class="text-[10px] text-slate-400 font-bold block bg-slate-100 dark:bg-slate-800 p-2 rounded px-3 border border-slate-200 dark:border-slate-700">📌
                                    Tips: Masukkan nilai dipisah dengan koma (Bujur/Lng, Lintang/Lat). Pastikan keempat
                                    titik membentuk polygon (searah / berlawanan jarum jam). Jika form ini dibiarkan kosong,
                                    blok mungkin tidak tergambar pada peta.</span>
                            </div>
                        </div>
                    </div>

                    <!-- Nutrients Section -->
                    <div>
                        <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Pengukuran Hara
                            Terakhir</h4>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">Nitrogen
                                    (%)</label>
                                <input wire:model="nitrogen" type="number" step="0.01"
                                    class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">Fosfor
                                    (ppm)</label>
                                <input wire:model="phosphorus" type="number" step="0.01"
                                    class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">Kalium
                                    (cmol)</label>
                                <input wire:model="potassium" type="number" step="0.01"
                                    class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">pH
                                    Tanah</label>
                                <input wire:model="ph" type="number" step="0.01"
                                    class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">Magnesium
                                    (cmol)</label>
                                <input wire:model="magnesium" type="number" step="0.01"
                                    class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">C-Organik
                                    (%)</label>
                                <input wire:model="organic_carbon" type="number" step="0.01"
                                    class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all outline-none">
                            </div>
                            <div class="col-span-2 md:col-span-3">
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">Tanggal
                                    Pengukuran <span class="text-rose-500">*</span></label>
                                <input wire:model="measured_at" type="date"
                                    class="w-full md:w-1/3 px-4 py-2 bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all outline-none"
                                    required>
                            </div>
                        </div>
                    </div>

                    <div
                        class="pt-6 border-t border-slate-100 dark:border-slate-700 flex items-center justify-end gap-3 mt-6">
                        <button type="button" wire:click="closeModal"
                            class="px-6 py-2.5 text-slate-600 dark:text-slate-300 font-semibold text-sm hover:bg-slate-100 rounded-xl transition-colors">Batal</button>
                        <button type="submit"
                            class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm rounded-xl shadow-lg shadow-emerald-200 transition-colors">
                            {{ $isEdit ? 'Simpan Perubahan' : 'Tambahkan Data' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>