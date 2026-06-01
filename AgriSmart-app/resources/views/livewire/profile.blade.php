<div class="min-h-screen bg-slate-50 dark:bg-slate-950">
    <div class="max-w-7xl mx-auto px-6 py-8">

        {{-- Page Header --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">Profil Saya</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola informasi akun dan keamanan Anda</p>
        </div>

        {{-- Success Banner --}}
        @if($accountSuccess)
        <div
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => { show = false; $wire.set('accountSuccess', false) }, 4000)"
            class="flex items-center gap-2 px-4 py-3 mb-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 text-emerald-700 text-sm font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Data akun berhasil diperbarui.
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- ===== LEFT: Identity Card ===== --}}
            <div class="lg:col-span-1 space-y-4">

                {{-- Avatar & Info Card --}}
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 p-6 flex flex-col items-center text-center shadow-sm">
                    <div class="relative mb-4">
                        <div class="w-20 h-20 rounded-2xl flex items-center justify-center bg-gradient-to-br from-emerald-400 to-emerald-600 text-white font-bold text-2xl shadow-lg shadow-emerald-100 dark:shadow-emerald-900/50 italic">
                            {{ strtoupper(substr($username, 0, 2)) }}
                        </div>
                        <span class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full border-2 border-white dark:border-slate-900 bg-emerald-500"></span>
                    </div>
                    <h2 class="text-slate-800 dark:text-white font-bold text-lg leading-tight">{{ $username }}</h2>
                    <span class="mt-1.5 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase tracking-wider bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400">
                        {{ ucfirst($role) }}
                    </span>

                    <div class="w-full mt-5 pt-5 border-t border-slate-100 dark:border-slate-800 space-y-3 text-left">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-50 dark:bg-slate-800 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-slate-400 uppercase tracking-widest font-semibold">No. SAP</p>
                                <p class="text-slate-700 dark:text-slate-200 text-sm font-semibold">{{ $sap }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-50 dark:bg-slate-800 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-slate-400 uppercase tracking-widest font-semibold">Role</p>
                                <p class="text-slate-700 dark:text-slate-200 text-sm font-semibold">{{ ucfirst($role) }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-50 dark:bg-slate-800 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-slate-400 uppercase tracking-widest font-semibold">Status</p>
                                <span class="inline-flex items-center gap-1 text-sm font-semibold text-emerald-600 dark:text-emerald-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span>
                                    Aktif
                                </span>
                            </div>
                        </div>

                        {{-- Logout Form --}}
                        <div class="pt-4 mt-2 border-t border-slate-100 dark:border-slate-800">
                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-rose-500 dark:text-rose-400 bg-rose-50 dark:bg-rose-900/20 hover:bg-rose-100 dark:hover:bg-rose-900/40 font-semibold text-sm transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Keluar dari Sistem
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ===== RIGHT: Tabs ===== --}}
            <div class="lg:col-span-2 space-y-4">

                {{-- Tab Bar --}}
                <div class="flex gap-1 bg-white dark:bg-slate-900 p-1 rounded-xl border border-slate-100 dark:border-slate-800 shadow-sm">
                    <button wire:click="$set('activeTab', 'overview')"
                        class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200
                            {{ $activeTab === 'overview' ? 'bg-emerald-500 text-white shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Pengaturan Akun
                    </button>
                    <button wire:click="$set('activeTab', 'devices')"
                        class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200
                            {{ $activeTab === 'devices' ? 'bg-emerald-500 text-white shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Perangkat Login
                    </button>
                </div>

                {{-- ---- TAB: Informasi Akun ---- --}}
                @if($activeTab === 'overview')
                <div class="space-y-4">

                    {{-- Detail Akun --}}
                    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">

                        <div class="p-6 space-y-5">

                            {{-- Username --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">
                                    Username
                                </label>

                                <input
                                    wire:model.live="displayName"
                                    type="text"
                                    placeholder="Masukkan username"
                                    class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700 rounded-xl text-sm text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-400/30 focus:border-emerald-400">

                                @error('displayName')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Password Saat Ini --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">
                                    Password Saat Ini
                                </label>

                                <input
                                    wire:model.defer="current_password"
                                    type="password"
                                    placeholder="Isi jika ingin mengganti password"
                                    class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700 rounded-xl text-sm text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-400/30 focus:border-emerald-400">

                                @error('current_password')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Password Baru --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">
                                    Password Baru
                                </label>

                                <input
                                    wire:model.defer="new_password"
                                    type="password"
                                    placeholder="Kosongkan jika tidak ingin mengganti password"
                                    class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700 rounded-xl text-sm text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-400/30 focus:border-emerald-400">

                                @error('new_password')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Konfirmasi Password --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">
                                    Konfirmasi Password Baru
                                </label>

                                <input
                                    wire:model.defer="new_password_confirmation"
                                    type="password"
                                    placeholder="Ulangi password baru"
                                    class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700 rounded-xl text-sm text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-400/30 focus:border-emerald-400">
                            </div>

                            <div class="flex justify-end pt-2">
                                <button
                                    wire:click="updateAccount"
                                    wire:loading.attr="disabled"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold shadow-sm transition-all">
                                    <span wire:loading.remove wire:target="updateAccount">
                                        Simpan Perubahan
                                    </span>

                                    <span wire:loading wire:target="updateAccount">
                                        Menyimpan...
                                    </span>
                                </button>
                            </div>

                        </div>

                    </div>
                </div>
                @endif

                {{-- ---- TAB: Perangkat Login ---- --}}
                @if($activeTab === 'devices')
                <div class="space-y-4">

                    {{-- Aktif --}}
                    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-50 dark:border-slate-800 flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-bold text-slate-700 dark:text-slate-200">Perangkat Aktif</h3>
                                <p class="text-xs text-slate-400 mt-0.5">Perangkat yang sedang digunakan saat ini</p>
                            </div>
                        </div>
                        @foreach($devices->where('is_current', true) as $device)
                        <div class="px-6 py-4 flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-emerald-50 dark:bg-emerald-900/30 flex-shrink-0">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">{{ $device->device_name }}</p>
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-400">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block animate-pulse"></span>
                                        Aktif
                                    </span>
                                </div>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="text-xs text-slate-400">{{ $device->ip_address }}</span>
                                    <span class="text-slate-300 dark:text-slate-700">•</span>
                                    <span class="text-xs text-slate-400">Baru saja</span>
                                </div>
                            </div>
                            <span class="text-xs text-slate-300 dark:text-slate-600 flex-shrink-0">Perangkat ini</span>
                        </div>
                        @endforeach
                    </div>

                    {{-- Riwayat --}}
                    @if($devices->where('is_current', false)->count() > 0)
                    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-50 dark:border-slate-800 flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-bold text-slate-700 dark:text-slate-200">Riwayat Login</h3>
                                <p class="text-xs text-slate-400 mt-0.5">Perangkat yang pernah digunakan sebelumnya</p>
                            </div>
                            <button wire:click="terminateAllDevices" class="text-xs font-semibold text-rose-500 hover:text-rose-600 dark:text-rose-400">
                                Terminate Semua
                            </button>
                        </div>

                        @foreach($devices->where('is_current', false) as $device)
                        <div class="px-6 py-4 flex items-center gap-4 group border-b border-slate-50 dark:border-slate-800 last:border-0">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-slate-50 dark:bg-slate-800 flex-shrink-0">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-slate-600 dark:text-slate-300">{{ $device->device_name }}</p>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="text-xs text-slate-400">{{ $device->ip_address }}</span>
                                    <span class="text-slate-300 dark:text-slate-700">•</span>
                                    <span class="text-xs text-slate-400">{{ $device->last_activity_at ? $device->last_activity_at->diffForHumans() : 'Tidak diketahui' }}</span>
                                </div>
                            </div>
                            <button wire:click="removeDevice({{ $device->id }})" class="opacity-0 group-hover:opacity-100 transition-opacity p-2 text-rose-400 hover:text-rose-600 bg-rose-50 dark:bg-rose-900/20 rounded-lg" title="Terminate sesi ini">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                @endif

            </div>
        </div>
    </div>
</div>