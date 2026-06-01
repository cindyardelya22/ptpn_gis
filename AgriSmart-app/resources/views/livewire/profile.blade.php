<div class="min-h-screen bg-slate-50 dark:bg-slate-950">
    <div class="max-w-7xl mx-auto px-6 py-8">

        {{-- Page Header --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">Profil Saya</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola informasi akun dan keamanan Anda</p>
        </div>

        {{-- Success Banner --}}
        @if($passwordSuccess)
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)"
            class="mb-6 flex items-center gap-3 px-4 py-3 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 text-sm font-medium">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Password berhasil diperbarui.
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- ===== LEFT: Identity Card ===== --}}
            <div class="lg:col-span-1 space-y-4">

                {{-- Avatar & Info Card --}}
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 p-6 flex flex-col items-center text-center shadow-sm">
                    <div class="relative mb-4">
                        <div class="w-20 h-20 rounded-2xl flex items-center justify-center bg-gradient-to-br from-emerald-400 to-emerald-600 text-white font-bold text-2xl shadow-lg shadow-emerald-100 dark:shadow-emerald-900/50 italic">
                            AD
                        </div>
                        <span class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full border-2 border-white dark:border-slate-900 bg-emerald-500"></span>
                    </div>
                    <h2 class="text-slate-800 dark:text-white font-bold text-lg leading-tight">Administrator</h2>
                    <span class="mt-1.5 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase tracking-wider bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400">
                        Admin
                    </span>

                    <div class="w-full mt-5 pt-5 border-t border-slate-100 dark:border-slate-800 space-y-3 text-left">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-50 dark:bg-slate-800 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-slate-400 uppercase tracking-widest font-semibold">No. SAP</p>
                                <p class="text-slate-700 dark:text-slate-200 text-sm font-semibold">1000234</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-50 dark:bg-slate-800 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-slate-400 uppercase tracking-widest font-semibold">Role</p>
                                <p class="text-slate-700 dark:text-slate-200 text-sm font-semibold">Admin</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-50 dark:bg-slate-800 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Informasi Akun
                    </button>
                    <button wire:click="$set('activeTab', 'devices')"
                        class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200
                            {{ $activeTab === 'devices' ? 'bg-emerald-500 text-white shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Perangkat Login
                    </button>
                </div>

                {{-- ---- TAB: Informasi Akun ---- --}}
                @if($activeTab === 'overview')
                <div class="space-y-4">

                    {{-- Detail Akun --}}
                    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-50 dark:border-slate-800">
                            <h3 class="text-sm font-bold text-slate-700 dark:text-slate-200">Detail Akun</h3>
                        </div>
                        <div class="p-6 space-y-5">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">Username</label>
                                <div class="flex items-center gap-3 px-4 py-3 bg-slate-50 dark:bg-slate-800/50 rounded-xl border border-slate-100 dark:border-slate-700">
                                    <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span class="text-slate-700 dark:text-slate-200 text-sm font-medium">Administrator</span>
                                </div>
                            </div>
                        </div>
                                             <div class="px-6 py-4 border-b border-slate-50 dark:border-slate-800 flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-bold text-slate-700 dark:text-slate-200">Ubah Password</h3>
                                <p class="text-xs text-slate-400 mt-0.5">Minimal 8 karakter dengan huruf besar, kecil, dan angka</p>
                            </div>
                            <button wire:click="$toggle('showPasswordForm')"
                                class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all duration-200
                                    {{ $showPasswordForm ? 'bg-slate-100 dark:bg-slate-800 text-slate-500' : 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-100' }}">
                                @if($showPasswordForm)
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Batal
                                @else
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                    Ubah
                                @endif
                            </button>
                        </div>

                        @if($showPasswordForm)
                        <div class="p-6 space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">Password Saat Ini</label>
                                <div x-data="{ show: false }" class="relative">
                                    <input :type="show ? 'text' : 'password'"
                                        wire:model="current_password"
                                        placeholder="Masukkan password saat ini"
                                        class="w-full px-4 py-3 pr-10 bg-slate-50 dark:bg-slate-800/50 border rounded-xl text-sm text-slate-700 dark:text-slate-200 placeholder-slate-300 dark:placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-emerald-400/30 focus:border-emerald-400
                                            {{ $errors->has('current_password') ? 'border-red-300 dark:border-red-700' : 'border-slate-100 dark:border-slate-700' }}">
                                    <button type="button" @click="show = !show" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                        <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <svg x-show="show" class="w-4 h-4" style="display:none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                    </button>
                                </div>
                                @error('current_password')
                                <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">Password Baru</label>
                                <div x-data="{ show: false }" class="relative">
                                    <input :type="show ? 'text' : 'password'"
                                        wire:model="new_password"
                                        placeholder="Minimal 8 karakter, huruf besar & angka"
                                        class="w-full px-4 py-3 pr-10 bg-slate-50 dark:bg-slate-800/50 border rounded-xl text-sm text-slate-700 dark:text-slate-200 placeholder-slate-300 dark:placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-emerald-400/30 focus:border-emerald-400
                                            {{ $errors->has('new_password') ? 'border-red-300 dark:border-red-700' : 'border-slate-100 dark:border-slate-700' }}">
                                    <button type="button" @click="show = !show" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                        <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <svg x-show="show" class="w-4 h-4" style="display:none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                    </button>
                                </div>
                                @error('new_password')
                                <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">Konfirmasi Password Baru</label>
                                <div x-data="{ show: false }" class="relative">
                                    <input :type="show ? 'text' : 'password'"
                                        wire:model="new_password_confirmation"
                                        placeholder="Ulangi password baru"
                                        class="w-full px-4 py-3 pr-10 bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700 rounded-xl text-sm text-slate-700 dark:text-slate-200 placeholder-slate-300 dark:placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-emerald-400/30 focus:border-emerald-400">
                                    <button type="button" @click="show = !show" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                        <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <svg x-show="show" class="w-4 h-4" style="display:none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                    </button>
                                </div>
                            </div>

                            <div class="flex items-center justify-end gap-3 pt-2">
                                <button type="button" wire:click="$set('showPasswordForm', false)"
                                    class="px-4 py-2 rounded-xl text-sm font-semibold text-slate-500 hover:text-slate-700 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                                    Batal
                                </button>
                                <button type="button" wire:click="changePassword"
                                    class="px-5 py-2 rounded-xl text-sm font-semibold bg-emerald-500 hover:bg-emerald-600 text-white shadow-sm transition-all duration-200 flex items-center gap-2">
                                    <span wire:loading.remove wire:target="changePassword">Simpan Password</span>
                                    <span wire:loading wire:target="changePassword" class="flex items-center gap-2">
                                        <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                                        </svg>
                                        Menyimpan...
                                    </span>
                                </button>
                            </div>
                        </div>
                        @else
                        <div class="px-6 py-5 flex items-center gap-3 text-slate-400 dark:text-slate-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <span class="text-sm">Password tersimpan aman dan terenkripsi</span>
                        </div>
                        @endif
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
                        <div class="px-6 py-4 flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-emerald-50 dark:bg-emerald-900/30 flex-shrink-0">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">Chrome — Windows</p>
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-400">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block animate-pulse"></span>
                                        Aktif
                                    </span>
                                </div>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="text-xs text-slate-400">192.168.1.10</span>
                                    <span class="text-slate-300 dark:text-slate-700">•</span>
                                    <span class="text-xs text-slate-400">Baru saja</span>
                                </div>
                            </div>
                            <span class="text-xs text-slate-300 dark:text-slate-600 flex-shrink-0">Perangkat ini</span>
                        </div>
                    </div>

                    {{-- Riwayat --}}
                    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-50 dark:border-slate-800">
                            <h3 class="text-sm font-bold text-slate-700 dark:text-slate-200">Riwayat Login</h3>
                            <p class="text-xs text-slate-400 mt-0.5">Perangkat yang pernah digunakan sebelumnya</p>
                        </div>
                        <div class="px-6 py-4 flex items-center gap-4 group border-b border-slate-50 dark:border-slate-800">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-slate-50 dark:bg-slate-800 flex-shrink-0">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-slate-600 dark:text-slate-300">Firefox — Android</p>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="text-xs text-slate-400">192.168.1.22</span>
                                    <span class="text-slate-300 dark:text-slate-700">•</span>
                                    <span class="text-xs text-slate-400">2 hari yang lalu</span>
                                </div>
                            </div>
                        </div>
                        <div class="px-6 py-4 flex items-center gap-4 group">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-slate-50 dark:bg-slate-800 flex-shrink-0">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-slate-600 dark:text-slate-300">Chrome — macOS</p>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="text-xs text-slate-400">10.0.0.5</span>
                                    <span class="text-slate-300 dark:text-slate-700">•</span>
                                    <span class="text-xs text-slate-400">5 hari yang lalu</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>