{{-- ============================================================
     USER MANAGEMENT — dengan Role Permission per Halaman
     Roles: superadmin, admin, viewer
     Pages: dashboard, data-unsur-hara, peta-blok, analisis-kesuburan, laporan, settings
     ============================================================ --}}

<div x-data="{
        activeSection: 'users',
        darkMode: false,
        showPermissions: false,

        pages: [
            { key: 'dashboard',       label: 'Dashboard',              icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6' },
            { key: 'data-unsur-hara', label: 'Data Unsur Hara',        icon: 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2' },
            { key: 'peta-blok',       label: 'Peta Blok Kebun',        icon: 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7' },
            { key: 'analisis-kesuburan',   label: 'Analisis Kesuburan',     icon: 'M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z' },
            { key: 'detail-blok',     label: 'Detail Blok',            icon: 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01' },
            { key: 'laporan',         label: 'Laporan',                icon: 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z' },
            { key: 'settings',        label: 'Setting',                icon: 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z' },
        ],

        permissions: @js($permissions),
        isSavingPerms: false,
        permsSaved: false,

        roleLabel(role) {
            return { superadmin: 'Super Admin', admin: 'Admin', viewer: 'Viewer' }[role] ?? role;
        },
        roleColor(role) {
            return {
                superadmin: 'bg-violet-100 text-violet-700 dark:bg-violet-900/30 dark:text-violet-300',
                admin:      'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300',
                viewer:     'bg-sky-100 text-sky-700 dark:bg-sky-900/30 dark:text-sky-300',
            }[role] ?? 'bg-slate-100 text-slate-600';
        },

        pageActions(pageKey) {
            const map = {
                'dashboard':       ['view'],
                'data-unsur-hara': ['view', 'create', 'edit', 'delete'],
                'peta-blok':       ['view'],
                'analisis-kesuburan':   ['view'],
                'detail-blok':     ['rekomendasi'],
                'laporan':         ['view', 'rekap_kesuburan', 'rekomendasi_pemupukan', 'riwayat_pengukuran'],
                'settings':        ['view', 'manage_users'],
            };
            return map[pageKey] ?? ['view'];
        },

        actionLabel(action) {
            const map = {
                view:                    'Lihat',
                create:                  'Tambah',
                edit:                    'Edit',
                delete:                  'Hapus',
                rekomendasi:             'Centang Rekomendasi',
                rekap_kesuburan:         'Rekap Kesuburan Tanah',
                rekomendasi_pemupukan:   'Rekomendasi Pemupukan',
                riwayat_pengukuran:      'Riwayat Pengukuran',
                manage_users:            'Kelola User',
            };
            return map[action] ?? action;
        },

        actionIcon(action) {
            const map = {
                view:                  'M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z',
                create:                'M12 4v16m8-8H4',
                edit:                  'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z',
                delete:                'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16',
                rekomendasi:           'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4',
                rekap_kesuburan:       'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
                rekomendasi_pemupukan: 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z',
                riwayat_pengukuran:    'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                manage_users:          'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
            };
            return map[action] ?? map.view;
        },

        hasPermission(role, pageKey, action) {
            return this.permissions?.[role]?.[pageKey]?.includes(action) ?? false;
        },

        togglePermission(role, pageKey, action) {
            // Deep clone to force Alpine reactivity
            let perms = JSON.parse(JSON.stringify(this.permissions));
            if (!perms[role]) perms[role] = {};
            if (!perms[role][pageKey]) perms[role][pageKey] = [];
            const arr = perms[role][pageKey];
            const idx = arr.indexOf(action);
            if (idx === -1) arr.push(action);
            else arr.splice(idx, 1);
            this.permissions = perms;
        },

        savePermissions() {
            this.isSavingPerms = true;
            this.permsSaved = false;
            $wire.savePermissions(this.permissions).then(() => {
                this.isSavingPerms = false;
                this.permsSaved = true;
                setTimeout(() => this.permsSaved = false, 3000);
            });
        }
    }"
    :class="darkMode ? 'dark' : ''"
    class="min-h-screen bg-slate-100 dark:bg-slate-900 transition-colors duration-300">

    <div class="p-6 lg:p-10 max-w-screen-xl mx-auto">

        {{-- ══ PAGE HEADER ══ --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 dark:text-white tracking-tight">Setting</h1>
                <p class="text-slate-400 dark:text-slate-500 text-sm mt-1">Kelola pengguna dan atur hak akses per halaman</p>
            </div>
            <div class="flex items-center gap-2">
                {{-- Tab switcher --}}
                <div class="flex items-center bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-white/10 p-1 gap-1">
                    <button @click="activeSection = 'users'"
                        :class="activeSection === 'users' ? 'bg-emerald-500 text-white shadow-md shadow-emerald-500/25' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'"
                        class="px-4 py-1.5 rounded-lg text-sm font-semibold transition-all duration-200">
                        Kelola User
                    </button>
                    <button @click="activeSection = 'permissions'"
                        :class="activeSection === 'permissions' ? 'bg-violet-500 text-white shadow-md shadow-violet-500/25' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'"
                        class="px-4 py-1.5 rounded-lg text-sm font-semibold transition-all duration-200">
                        Hak Akses
                    </button>
                </div>
            </div>
        </div>

        {{-- ══ SECTION: KELOLA USER ══ --}}
        <div x-show="activeSection === 'users'" x-transition:enter="transition duration-200" x-transition:enter-start="opacity-0 translate-y-2">

            {{-- Stats --}}
            <div class="grid grid-cols-3 gap-4 mb-6">
                <div class="bg-white dark:bg-slate-800/60 rounded-2xl p-5 border border-slate-200 dark:border-white/5 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-slate-400 text-xs uppercase tracking-wider mb-1">Total Users</p>
                            <p class="text-3xl font-bold text-slate-800 dark:text-white">{{ $users->total() }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-violet-50 dark:bg-violet-900/20">
                            <svg class="w-5 h-5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-800/60 rounded-2xl p-5 border border-slate-200 dark:border-white/5 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-slate-400 text-xs uppercase tracking-wider mb-1">Aktif</p>
                            <p class="text-3xl font-bold text-emerald-500">{{ $activeCount }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-emerald-50 dark:bg-emerald-900/20">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-800/60 rounded-2xl p-5 border border-slate-200 dark:border-white/5 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-slate-400 text-xs uppercase tracking-wider mb-1">Non-aktif</p>
                            <p class="text-3xl font-bold text-orange-400">{{ $inactiveCount }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-orange-50 dark:bg-orange-900/20">
                            <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Search & Filter --}}
            <div class="flex flex-col sm:flex-row gap-3 mb-5">
                <div class="relative flex-1">
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" placeholder="Cari username, SAP, atau role..."
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl text-sm text-slate-800 dark:text-white placeholder-slate-400 outline-none border border-slate-200 dark:border-white/10 focus:border-emerald-400 transition bg-white dark:bg-slate-800/60"
                        wire:model.live.debounce.300ms="search" />
                </div>
                <select wire:model.live="filterRole"
                    class="px-4 py-2.5 rounded-xl text-sm text-slate-700 dark:text-slate-300 outline-none border border-slate-200 dark:border-white/10 focus:border-emerald-400 transition bg-white dark:bg-slate-800/60">
                    <option value="">Semua Role</option>
                    <option value="superadmin">Super Admin</option>
                    <option value="admin">Admin</option>
                    <option value="viewer">Viewer</option>
                </select>
                <select wire:model.live="filterStatus"
                    class="px-4 py-2.5 rounded-xl text-sm text-slate-700 dark:text-slate-300 outline-none border border-slate-200 dark:border-white/10 focus:border-emerald-400 transition bg-white dark:bg-slate-800/60">
                    <option value="">Semua Status</option>
                    <option value="1">Aktif</option>
                    <option value="0">Non-aktif</option>
                </select>
                <button wire:click="openCreate"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-white text-sm font-semibold transition-all hover:scale-105 active:scale-95 shadow-lg shadow-emerald-500/25 bg-gradient-to-br from-emerald-500 to-emerald-600 shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah User
                </button>
            </div>

            {{-- Table --}}
            <div class="bg-white dark:bg-slate-800/60 rounded-2xl overflow-hidden border border-slate-200 dark:border-white/5 shadow-sm">
                <div class="grid grid-cols-12 gap-2 px-6 py-3.5 border-b border-slate-100 dark:border-white/5 bg-slate-50 dark:bg-white/[0.02]">
                    <div class="col-span-1 text-slate-400 text-xs font-semibold uppercase tracking-widest">#</div>
                    <div class="col-span-2 text-slate-400 text-xs font-semibold uppercase tracking-widest">User</div>
                    <div class="col-span-2 text-slate-400 text-xs font-semibold uppercase tracking-widest">Role</div>
                    <div class="col-span-2 text-slate-400 text-xs font-semibold uppercase tracking-widest">No SAP</div>
                    <div class="col-span-2 text-slate-400 text-xs font-semibold uppercase tracking-widest">Status</div>
                    <div class="col-span-1 text-slate-400 text-xs font-semibold uppercase tracking-widest">Bergabung</div>
                    <div class="col-span-2 text-slate-400 text-xs font-semibold uppercase tracking-widest text-end">Aksi</div>
                </div>

                @if ($users->isEmpty())
                <div class="flex flex-col items-center justify-center py-20 gap-3">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center bg-slate-50 dark:bg-white/5">
                        <svg class="w-7 h-7 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <p class="text-slate-400 text-sm font-medium">Tidak ada user ditemukan</p>
                </div>
                @endif

                @foreach ($users as $idx => $user)
                <div class="grid grid-cols-12 gap-2 px-6 py-3.5 border-b border-slate-100 dark:border-white/5 last:border-0 hover:bg-slate-50 dark:hover:bg-white/[0.02] transition-colors group">
                    <div class="col-span-1 flex items-center">
                        <span class="text-slate-400 text-sm">{{ $users->firstItem() + $idx }}</span>
                    </div>
                    <div class="col-span-2 flex items-center gap-3 min-w-0">
                        <div class="w-8 h-8 rounded-xl flex items-center justify-center text-white font-bold text-xs flex-shrink-0
                                {{ $user->role === 'superadmin' ? 'bg-gradient-to-br from-violet-500 to-violet-600' : ($user->role === 'admin' ? 'bg-gradient-to-br from-emerald-500 to-emerald-600' : 'bg-gradient-to-br from-sky-500 to-sky-600') }}">
                            {{ strtoupper(substr($user->username, 0, 2)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-slate-800 dark:text-white text-sm font-semibold truncate">{{ $user->username }}</p>
                        </div>
                    </div>
                    <div class="col-span-2 flex items-center">
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-lg capitalize
                                {{ $user->role === 'superadmin' ? 'bg-violet-100 text-violet-700 dark:bg-violet-900/30 dark:text-violet-300' : ($user->role === 'admin' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300' : 'bg-sky-100 text-sky-700 dark:bg-sky-900/30 dark:text-sky-300') }}">
                            {{ $user->role === 'superadmin' ? 'Super Admin' : ucfirst($user->role) }}
                        </span>
                    </div>
                    <div class="col-span-2 flex items-center">
                        <span class="text-slate-500 dark:text-slate-400 text-sm font-mono">{{ $user->sap ?? '—' }}</span>
                    </div>
                    <div class="col-span-2 flex items-center gap-1.5 flex-wrap">
                        {{-- Badge terkunci (jika locked_until masih di masa depan) --}}
                        @if ($user->locked_until && $user->locked_until->isFuture())
                        <span
                            wire:click="unlockUser({{ $user->id }})"
                            title="Terkunci hingga {{ $user->locked_until->format('H:i') }} — klik untuk buka kunci"
                            class="flex items-center gap-1 text-xs font-semibold px-2 py-1 rounded-lg cursor-pointer
                                    bg-red-50 dark:bg-red-900/20 text-red-500 dark:text-red-400
                                    border border-red-200 dark:border-red-500/30
                                    hover:bg-red-100 dark:hover:bg-red-900/40 transition">
                            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Terkunci
                        </span>
                        @else
                        {{-- Toggle aktif/nonaktif --}}
                        <span class="flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-lg cursor-pointer hover:opacity-80 transition"
                            wire:click="toggleActive({{ $user->id }})"
                            title="Klik untuk {{ $user->is_active ? 'nonaktifkan' : 'aktifkan' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $user->is_active ? 'bg-emerald-400' : 'bg-orange-400' }}"></span>
                            <span class="{{ $user->is_active ? 'text-emerald-600 dark:text-emerald-400' : 'text-orange-600 dark:text-orange-400' }}">
                                {{ $user->is_active ? 'Aktif' : 'Non-aktif' }}
                            </span>
                        </span>
                        @endif
                    </div>
                    <div class="col-span-1 flex items-center">
                        <span class="text-slate-400 text-xs">{{ $user->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="col-span-2 flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button onclick="Livewire.dispatch('openEditModal', { userId: {{ $user->id }} })"
                            class="w-7 h-7 rounded-lg flex items-center justify-center hover:scale-110 transition bg-violet-50 dark:bg-violet-900/20 text-violet-500">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                        <button onclick="Livewire.dispatch('openResetModal', { userId: {{ $user->id }}, userName: '{{ addslashes($user->username) }}' })"
                            class="w-7 h-7 rounded-lg flex items-center justify-center hover:scale-110 transition bg-amber-50 dark:bg-amber-900/20 text-amber-500"
                            title="Reset password">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                        </button>
                        <button onclick="Livewire.dispatch('openDeleteModal', { userId: {{ $user->id }}, userName: '{{ addslashes($user->username) }}' })"
                            class="w-7 h-7 rounded-lg flex items-center justify-center hover:scale-110 transition bg-rose-50 dark:bg-rose-900/20 text-rose-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
                @endforeach

                @if ($users->hasPages())
                <div class="flex items-center justify-between px-6 py-4 border-t border-slate-100 dark:border-white/5">
                    <p class="text-slate-400 text-xs">
                        Menampilkan <span class="text-slate-600 dark:text-slate-300 font-semibold">{{ $users->firstItem() }}</span>–<span class="text-slate-600 dark:text-slate-300 font-semibold">{{ $users->lastItem() }}</span> dari <span class="text-slate-600 dark:text-slate-300 font-semibold">{{ $users->total() }}</span> user
                    </p>
                    <div class="flex items-center gap-1">
                        <button wire:click="previousPage" @disabled($users->onFirstPage())
                            class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 border border-slate-200 dark:border-white/10 hover:border-emerald-300 hover:text-emerald-500 transition disabled:opacity-30 bg-white dark:bg-transparent">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                        <button wire:click="gotoPage({{ $page }})"
                            class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-semibold border transition
                                    {{ $users->currentPage() == $page ? 'text-white border-transparent bg-gradient-to-br from-emerald-500 to-emerald-600 shadow-md shadow-emerald-500/20' : 'text-slate-500 dark:text-slate-400 border-slate-200 dark:border-white/10 hover:border-emerald-300 hover:text-emerald-500 bg-white dark:bg-transparent' }}">
                            {{ $page }}
                        </button>
                        @endforeach
                        <button wire:click="nextPage" @disabled($users->onLastPage())
                            class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 border border-slate-200 dark:border-white/10 hover:border-emerald-300 hover:text-emerald-500 transition disabled:opacity-30 bg-white dark:bg-transparent">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- ══ SECTION: HAK AKSES ══ --}}
        <div x-show="activeSection === 'permissions'" x-transition:enter="transition duration-200" x-transition:enter-start="opacity-0 translate-y-2">

            {{-- Info banner --}}
            <div class="mb-6 p-4 rounded-2xl bg-white dark:bg-violet-900/20 border border-violet-200 dark:border-violet-500/20 flex items-start gap-3">
                <svg class="w-5 h-5 text-yellow-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <p class="text-yellow-800 dark:text-violet-200 text-sm font-semibold">Pengaturan Hak Akses Per Role</p>
                    <p class="text-yellow-600 dark:text-violet-300/70 text-xs mt-0.5">Klik aksi yang diizinkan untuk setiap role pada masing-masing halaman. Perubahan berlaku setelah disimpan.</p>
                </div>
            </div>

            {{-- Role legend --}}
            <div class="flex items-center gap-3 mb-5">
                <span class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Role:</span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-semibold bg-violet-100 text-violet-700 dark:bg-violet-900/30 dark:text-violet-300">
                    <span class="w-2 h-2 rounded-full bg-violet-500"></span> Super Admin
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-semibold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Admin
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-semibold bg-sky-100 text-sky-700 dark:bg-sky-900/30 dark:text-sky-300">
                    <span class="w-2 h-2 rounded-full bg-sky-500"></span> Viewer
                </span>
            </div>

            {{-- Permission Cards per page --}}
            <div class="space-y-4">
                <template x-for="page in pages" :key="page.key">
                    <div class="bg-white dark:bg-slate-800/60 rounded-2xl border border-slate-200 dark:border-white/5 shadow-sm overflow-hidden">
                        {{-- Page header --}}
                        <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-100 dark:border-white/5 bg-slate-50 dark:bg-white/[0.02]">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-white dark:bg-slate-800 border border-slate-200 dark:border-white/10 shrink-0">
                                <svg class="w-4 h-4 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="page.icon" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-slate-800 dark:text-white text-sm font-bold" x-text="page.label"></p>
                                <p class="text-slate-400 text-xs" x-text="'/' + page.key"></p>
                            </div>
                        </div>

                        {{-- Permission rows: one per role --}}
                        <div class="divide-y divide-slate-100 dark:divide-white/5">
                            <template x-for="role in ['superadmin', 'admin', 'viewer']" :key="role">
                                <div class="px-5 py-4 flex flex-col sm:flex-row sm:items-center gap-4">
                                    {{-- Role badge --}}
                                    <div class="w-28 shrink-0">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold"
                                            :class="roleColor(role)">
                                            <span class="w-1.5 h-1.5 rounded-full"
                                                :class="{
                                                    'bg-violet-500': role === 'superadmin',
                                                    'bg-emerald-500': role === 'admin',
                                                    'bg-sky-500': role === 'viewer'
                                                }"></span>
                                            <span x-text="roleLabel(role)"></span>
                                        </span>
                                    </div>

                                    {{-- Superadmin: locked full access --}}
                                    <template x-if="role === 'superadmin'">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center gap-1.5 text-xs font-medium text-violet-600 dark:text-violet-400 bg-violet-50 dark:bg-violet-900/20 px-3 py-1.5 rounded-lg border border-violet-200 dark:border-violet-500/20">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                </svg>
                                                Akses penuh ke semua fitur
                                            </span>
                                        </div>
                                    </template>

                                    {{-- Admin & Viewer: toggleable checkboxes --}}
                                    <template x-if="role !== 'superadmin'">
                                        <div class="flex flex-wrap gap-2">
                                            <template x-for="action in pageActions(page.key)" :key="action">
                                                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg border cursor-pointer transition-all select-none text-xs font-medium"
                                                    :class="hasPermission(role, page.key, action)
                                                        ? (role === 'admin' ? 'bg-emerald-50 border-emerald-300 text-emerald-700 dark:bg-emerald-900/20 dark:border-emerald-500/40 dark:text-emerald-300' : 'bg-sky-50 border-sky-300 text-sky-700 dark:bg-sky-900/20 dark:border-sky-500/40 dark:text-sky-300')
                                                        : 'bg-white dark:bg-slate-800 border-slate-200 dark:border-white/10 text-slate-400'"
                                                    @click.prevent="togglePermission(role, page.key, action)">
                                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="actionIcon(action)" />
                                                    </svg>
                                                    <span x-text="actionLabel(action)"></span>
                                                    <svg x-show="hasPermission(role, page.key, action)" class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </div>
                                            </template>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>

            {{-- Save Permissions Button --}}
            <div class="flex items-center justify-end gap-3 mt-6">
                <span x-show="permsSaved" x-transition class="text-sm font-semibold text-emerald-600 dark:text-emerald-400 flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Tersimpan!
                </span>
                <button @click="savePermissions()"
                    :disabled="isSavingPerms"
                    class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-white text-sm font-semibold transition-all hover:scale-105 active:scale-95 shadow-lg shadow-violet-500/25 bg-gradient-to-br from-violet-500 to-violet-600 disabled:opacity-60 disabled:cursor-not-allowed">
                    <template x-if="isSavingPerms">
                        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
                        </svg>
                    </template>
                    <template x-if="!isSavingPerms">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </template>
                    <span x-text="isSavingPerms ? 'Menyimpan...' : 'Simpan Hak Akses'"></span>
                </button>
            </div>
        </div>

    </div>


    {{-- ══ MODAL CREATE / EDIT ══ --}}
    @if ($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4"
        @keydown.escape.window="$wire.closeModal()"
        style="background:rgba(15,23,42,.6);backdrop-filter:blur(8px)">
        <div class="relative w-full max-w-md rounded-2xl overflow-hidden shadow-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/10" @click.stop>
            <div class="h-1 w-full bg-gradient-to-r from-emerald-400 via-emerald-500 to-emerald-600"></div>
            <div class="flex items-center justify-between px-6 pt-5 pb-4 border-b border-slate-100 dark:border-white/5">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center bg-emerald-50 dark:bg-emerald-900/20">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if ($isEdit)
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            @endif
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-slate-800 dark:text-white font-bold text-base">{{ $isEdit ? 'Edit User' : 'Tambah User Baru' }}</h2>
                        <p class="text-slate-400 text-xs mt-0.5">{{ $isEdit ? 'Perbarui informasi pengguna' : 'Isi form untuk membuat akun baru' }}</p>
                    </div>
                </div>
                <button wire:click="closeModal" class="w-8 h-8 rounded-xl flex items-center justify-center text-slate-400 hover:bg-slate-100 dark:hover:bg-white/5 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="px-6 py-5 space-y-4">
                <div>
                    <label class="block text-slate-500 dark:text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1.5">Username</label>
                    <input wire:model="form.username" type="text" placeholder="Masukkan username"
                        class="w-full px-4 py-2.5 rounded-xl text-slate-800 dark:text-white text-sm placeholder-slate-300 outline-none border transition bg-white dark:bg-slate-800/60
                            {{ $errors->has('form.username') ? 'border-red-400' : 'border-slate-200 dark:border-white/10 focus:border-emerald-400' }}" />
                    @error('form.username')<p class="text-red-400 text-xs mt-1.5">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-slate-500 dark:text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1.5">No SAP</label>
                    <input wire:model="form.sap" type="text" placeholder="Nomor SAP"
                        class="w-full px-4 py-2.5 rounded-xl text-slate-800 dark:text-white text-sm placeholder-slate-300 outline-none border transition bg-white dark:bg-slate-800/60
                            {{ $errors->has('form.sap') ? 'border-red-400' : 'border-slate-200 dark:border-white/10 focus:border-emerald-400' }}" />
                    @error('form.sap')<p class="text-red-400 text-xs mt-1.5">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-slate-500 dark:text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1.5">
                        Password @if ($isEdit)<span class="normal-case font-normal text-slate-400 ml-1">— kosongkan jika tidak diubah</span>@endif
                    </label>
                    <input wire:model="form.password" type="password"
                        placeholder="{{ $isEdit ? '••••••••' : 'Min. 8 karakter' }}"
                        class="w-full px-4 py-2.5 rounded-xl text-slate-800 dark:text-white text-sm placeholder-slate-300 outline-none border transition bg-white dark:bg-slate-800/60
                            {{ $errors->has('form.password') ? 'border-red-400' : 'border-slate-200 dark:border-white/10 focus:border-emerald-400' }}" />
                    @error('form.password')<p class="text-red-400 text-xs mt-1.5">{{ $message }}</p>@enderror
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-slate-500 dark:text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1.5">Role</label>
                        <select wire:model="form.role"
                            class="w-full px-4 py-2.5 rounded-xl text-slate-700 dark:text-slate-300 text-sm outline-none border border-slate-200 dark:border-white/10 focus:border-emerald-400 transition bg-white dark:bg-slate-800/60">
                            <option value="">Pilih Role</option>
                            <option value="superadmin">Super Admin</option>
                            <option value="admin">Admin</option>
                            <option value="viewer">Viewer</option>
                        </select>
                        @error('form.role')<p class="text-red-400 text-xs mt-1.5">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-slate-500 dark:text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1.5">Status</label>
                        <select wire:model="form.is_active"
                            class="w-full px-4 py-2.5 rounded-xl text-slate-700 dark:text-slate-300 text-sm outline-none border border-slate-200 dark:border-white/10 focus:border-emerald-400 transition bg-white dark:bg-slate-800/60">
                            <option value="1">Aktif</option>
                            <option value="0">Non-aktif</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="flex justify-end gap-2 px-6 py-4 bg-slate-50 dark:bg-white/[0.02] border-t border-slate-100 dark:border-white/5">
                <button wire:click="closeModal" class="px-4 py-2.5 rounded-xl text-slate-500 text-sm font-medium border border-slate-200 dark:border-white/10 hover:bg-white dark:hover:bg-white/5 transition">Batal</button>
                <button wire:click="save" class="px-5 py-2.5 rounded-xl text-white text-sm font-semibold shadow-lg shadow-emerald-500/20 hover:scale-105 active:scale-95 transition-all flex items-center gap-2 bg-gradient-to-br from-emerald-500 to-emerald-600">
                    <svg wire:loading wire:target="save" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
                    </svg>
                    <span wire:loading.remove wire:target="save">{{ $isEdit ? 'Simpan Perubahan' : 'Buat User' }}</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- ══ MODAL DELETE ══ --}}
    @if ($showDeleteModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background:rgba(15,23,42,.6);backdrop-filter:blur(8px)">
        <div class="absolute inset-0" wire:click="closeModal"></div>
        <div class="relative w-full max-w-sm rounded-2xl overflow-hidden shadow-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-red-500/10">
            <div class="h-1 w-full bg-gradient-to-r from-red-400 to-rose-500"></div>
            <div class="p-7 text-center">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-4 bg-rose-50 dark:bg-rose-900/20">
                    <svg class="w-7 h-7 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
                <h3 class="text-slate-800 dark:text-white font-bold text-lg mb-1">Hapus User?</h3>
                <p class="text-slate-400 text-sm mb-1">Tindakan ini tidak dapat dibatalkan.</p>
                <p class="text-slate-600 dark:text-slate-300 font-semibold text-sm mb-6">"{{ $deleteTargetName }}" akan dihapus permanen.</p>
                <div class="flex gap-2">
                    <button wire:click="closeModal" class="flex-1 px-4 py-2.5 rounded-xl text-slate-500 text-sm font-medium border border-slate-200 dark:border-white/10 hover:bg-slate-50 dark:hover:bg-white/5 transition">Batal</button>
                    <button wire:click="deleteUser" class="flex-1 px-4 py-2.5 rounded-xl text-white text-sm font-semibold hover:scale-105 active:scale-95 transition-all shadow-lg shadow-red-500/20 flex items-center justify-center gap-2 bg-gradient-to-br from-red-500 to-rose-500">
                        <svg wire:loading wire:target="deleteUser" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
                        </svg>
                        <span wire:loading.remove wire:target="deleteUser">Ya, Hapus</span>
                        <span wire:loading wire:target="deleteUser">Menghapus...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- ══ TOAST ══ --}}
    @if (session()->has('toast'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3500)"
        x-transition:enter="transition duration-300" x-transition:enter-start="opacity-0 translate-y-3 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 translate-y-2"
        class="fixed bottom-6 right-6 z-50 flex items-center gap-3 px-4 py-3 rounded-xl text-white text-sm font-medium shadow-xl border"
        style="{{ session('toast.type') === 'success' ? 'background:linear-gradient(135deg,rgba(16,185,129,.97),rgba(5,150,105,.97));border-color:rgba(52,211,153,.2)' : 'background:linear-gradient(135deg,rgba(239,68,68,.97),rgba(220,38,38,.97));border-color:rgba(251,113,133,.2)' }}">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ session('toast.type') === 'success' ? 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' : 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z' }}" />
        </svg>
        <span>{{ session('toast.message') }}</span>
    </div>
    @endif
    @if ($showResetModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background:rgba(15,23,42,.6);backdrop-filter:blur(8px)">
        <div class="absolute inset-0" wire:click="closeModal"></div>
        <div class="relative w-full max-w-sm rounded-2xl overflow-hidden shadow-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-amber-500/10">
            <div class="h-1 w-full bg-gradient-to-r from-amber-400 to-orange-500"></div>
            <div class="p-7 text-center">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-4 bg-amber-50 dark:bg-amber-900/20">
                    <svg class="w-7 h-7 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                </div>
                <h3 class="text-slate-800 dark:text-white font-bold text-lg mb-1">Reset Password?</h3>
                <p class="text-slate-400 text-sm mb-2">Password untuk akun berikut akan direset:</p>
                <p class="text-slate-700 dark:text-slate-200 font-bold text-sm mb-3">"{{ $resetTargetName }}"</p>

                {{-- Password baru yang akan diset --}}
                <div class="mb-5 mx-auto max-w-[200px] px-4 py-2.5 rounded-xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700/40">
                    <p class="text-[10px] font-bold text-amber-500 uppercase tracking-widest mb-1">Password baru</p>
                    <p class="text-base font-black text-amber-700 dark:text-amber-300 font-mono tracking-wide">Password123</p>
                </div>

                <p class="text-slate-400 text-xs mb-6">Pastikan user mengganti password setelah login kembali.</p>

                <div class="flex gap-2">
                    <button wire:click="closeModal"
                        class="flex-1 px-4 py-2.5 rounded-xl text-slate-500 text-sm font-medium border border-slate-200 dark:border-white/10 hover:bg-slate-50 dark:hover:bg-white/5 transition">
                        Batal
                    </button>
                    <button wire:click="resetPassword"
                        class="flex-1 px-4 py-2.5 rounded-xl text-white text-sm font-semibold hover:scale-105 active:scale-95 transition-all shadow-lg shadow-amber-500/20 flex items-center justify-center gap-2 bg-gradient-to-br from-amber-500 to-orange-500">
                        <svg wire:loading wire:target="resetPassword" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
                        </svg>
                        <svg wire:loading.remove wire:target="resetPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <span wire:loading.remove wire:target="resetPassword">Ya, Reset</span>
                        <span wire:loading wire:target="resetPassword">Mereset...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>