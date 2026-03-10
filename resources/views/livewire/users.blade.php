<div x-data="{ ...app(), darkMode: false }" :class="darkMode ? 'dark' : ''"
    class="min-h-screen relative users bg-slate-100 dark:bg-slate-900 transition-colors duration-300">

    <div class="relative z-10 p-6 lg:p-10">

        <!-- ══ PAGE HEADER ══ -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8 fade-up">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 dark:text-white tracking-tight">User Management</h1>
                <p class="text-slate-400 dark:text-indigo-300/50 text-sm mt-1">Kelola semua pengguna sistem di sini</p>
            </div>
            <div class="flex items-center gap-2">
                <!-- Tambah User -->
                <button wire:click="openCreate"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-white text-sm font-semibold transition-all duration-200 hover:scale-105 active:scale-95 shadow-lg shadow-emerald-500/25"
                    style="background:linear-gradient(135deg,#059669,#10b981)">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah User
                </button>
            </div>
        </div>

        <!-- ══ STATS ══ -->
        <div class="grid grid-cols-3 gap-4 mb-8">
            <div class="bg-white dark:bg-slate-800/60 rounded-2xl p-5 border border-slate-200 dark:border-white/5 shadow-sm fade-up"
                style="animation-delay:0ms">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-slate-400 dark:text-indigo-300/50 text-xs uppercase tracking-wider mb-1">Total
                            Users</p>
                        <p class="text-3xl font-bold text-slate-800 dark:text-white">{{ $users->total() }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:#818cf818">
                        <svg class="w-5 h-5" style="color:#818cf8" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-slate-800/60 rounded-2xl p-5 border border-slate-200 dark:border-white/5 shadow-sm fade-up"
                style="animation-delay:60ms">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-slate-400 dark:text-indigo-300/50 text-xs uppercase tracking-wider mb-1">Aktif
                        </p>
                        <p class="text-3xl font-bold text-slate-800 dark:text-white">{{ $activeCount }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:#34d39918">
                        <svg class="w-5 h-5" style="color:#34d399" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-slate-800/60 rounded-2xl p-5 border border-slate-200 dark:border-white/5 shadow-sm fade-up"
                style="animation-delay:120ms">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-slate-400 dark:text-indigo-300/50 text-xs uppercase tracking-wider mb-1">
                            Non-aktif</p>
                        <p class="text-3xl font-bold text-slate-800 dark:text-white">{{ $inactiveCount }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:#fb923c18">
                        <svg class="w-5 h-5" style="color:#fb923c" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- ══ SEARCH BAR ══ -->
        <div class="flex flex-col sm:flex-row gap-3 mb-5 fade-up" style="animation-delay:180ms">
            <div class="relative flex-1">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 dark:text-slate-500"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" placeholder="Cari nama, email, atau role..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl text-sm text-slate-800 dark:text-white placeholder-slate-400 dark:placeholder-slate-600 outline-none border border-slate-200 dark:border-white/10 focus:border-emerald-400 dark:focus:border-emerald-500/60 transition bg-white dark:bg-slate-800/60"
                    wire:model.live.debounce.300ms="search" />
            </div>
            <select wire:model.live="filterRole"
                class="px-4 py-2.5 rounded-xl text-sm text-slate-700 dark:text-slate-300 outline-none border border-slate-200 dark:border-white/10 focus:border-emerald-400 transition bg-white dark:bg-slate-800/60">
                <option value="">Semua Role</option>
                <option value="admin">Admin</option>
                <option value="editor">Editor</option>
                <option value="user">User</option>
            </select>
            <select wire:model.live="filterStatus"
                class="px-4 py-2.5 rounded-xl text-sm text-slate-700 dark:text-slate-300 outline-none border border-slate-200 dark:border-white/10 focus:border-emerald-400 transition bg-white dark:bg-slate-800/60">
                <option value="">Semua Status</option>
                <option value="1">Aktif</option>
                <option value="0">Non-aktif</option>
            </select>
        </div>

        <!-- ══ TABLE ══ -->
        <div class="bg-white dark:bg-slate-800/60 rounded-2xl overflow-hidden border border-slate-200 dark:border-white/5 shadow-sm fade-up"
            style="animation-delay:240ms">

            <!-- Table Header -->
            <div
                class="grid grid-cols-12 gap-2 px-6 py-3.5 border-b border-slate-100 dark:border-white/5 bg-slate-50 dark:bg-white/[0.02]">
                <div
                    class="col-span-1 text-slate-400 dark:text-slate-600 text-xs font-semibold uppercase tracking-widest">
                    #</div>
                <div
                    class="col-span-4 text-slate-400 dark:text-slate-600 text-xs font-semibold uppercase tracking-widest">
                    User</div>
                <div
                    class="col-span-2 text-slate-400 dark:text-slate-600 text-xs font-semibold uppercase tracking-widest">
                    Role</div>
                <div
                    class="col-span-2 text-slate-400 dark:text-slate-600 text-xs font-semibold uppercase tracking-widest">
                    Status</div>
                <div
                    class="col-span-2 text-slate-400 dark:text-slate-600 text-xs font-semibold uppercase tracking-widest">
                    Bergabung</div>
                <div
                    class="col-span-1 text-slate-400 dark:text-slate-600 text-xs font-semibold uppercase tracking-widest text-right">
                    Aksi</div>
            </div>

            <!-- Empty State -->
            @if ($users->isEmpty())
                <div class="flex flex-col items-center justify-center py-20 gap-3">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center" style="background:#818cf812">
                        <svg class="w-7 h-7" style="color:#818cf860" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <p class="text-slate-400 dark:text-slate-600 text-sm font-medium">Tidak ada user ditemukan</p>
                </div>
            @endif

            <!-- Rows -->
            @foreach ($users as $idx => $user)
                <div
                    class="grid grid-cols-12 gap-2 px-6 py-3.5 border-b border-slate-100 dark:border-white/5 last:border-0 hover:bg-slate-50 dark:hover:bg-white/[0.02] transition-colors duration-150 group">

                    <!-- # -->
                    <div class="col-span-1 flex items-center">
                        <span class="text-slate-400 dark:text-slate-600 text-sm">
                            {{ $users->firstItem() + $idx }}
                        </span>
                    </div>

                    <!-- User -->
                    <div class="col-span-4 flex items-center gap-3 min-w-0">
                        <div class="w-8 h-8 rounded-xl flex items-center justify-center text-white font-bold text-xs flex-shrink-0"
                            style="background:linear-gradient(135deg,#059669,#10b981)">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-slate-800 dark:text-white text-sm font-semibold truncate">
                                {{ $user->name }}</p>
                            <p class="text-slate-400 dark:text-slate-600 text-xs truncate">{{ $user->email }}</p>
                        </div>
                    </div>

                    <!-- Role -->
                    <div class="col-span-2 flex items-center">
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-lg capitalize"
                            style="background:rgba(16,185,129,.12);color:#059669">
                            {{ $user->role }}
                        </span>
                    </div>

                    <!-- Status -->
                    <div class="col-span-2 flex items-center">
                        <span
                            class="flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-lg
                            {{ $user->status ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400' : 'bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400' }}">
                            <span
                                class="w-1.5 h-1.5 rounded-full {{ $user->status ? 'bg-emerald-400' : 'bg-orange-400' }}"></span>
                            {{ $user->status ? 'Aktif' : 'Non-aktif' }}
                        </span>
                    </div>

                    <!-- Date -->
                    <div class="col-span-2 flex items-center">
                        <span class="text-slate-400 dark:text-slate-600 text-xs">
                            {{ $user->created_at->format('d M Y') }}
                        </span>
                    </div>

                    <!-- Actions -->
                    <div
                        class="col-span-1 flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity duration-150">
                        <button onclick="Livewire.dispatch('openEditModal', { userId: {{ $user->id }} })"
                            class="w-7 h-7 rounded-lg flex items-center justify-center transition-all duration-150 hover:scale-110"
                            style="background:rgba(129,140,248,.15);color:#818cf8">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                        <button
                            onclick="Livewire.dispatch('openDeleteModal', { userId: {{ $user->id }}, userName: '{{ addslashes($user->name) }}' })"
                            class="w-7 h-7 rounded-lg flex items-center justify-center transition-all duration-150 hover:scale-110"
                            style="background:rgba(251,113,133,.15);color:#fb7185">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endforeach

            <!-- ══ PAGINATION ══ -->
            @if ($users->hasPages())
                <div class="flex items-center justify-between px-6 py-4 border-t border-slate-100 dark:border-white/5">
                    <p class="text-slate-400 dark:text-slate-600 text-xs">
                        Menampilkan
                        <span
                            class="text-slate-600 dark:text-slate-400 font-semibold">{{ $users->firstItem() }}</span>–<span
                            class="text-slate-600 dark:text-slate-400 font-semibold">{{ $users->lastItem() }}</span>
                        dari
                        <span class="text-slate-600 dark:text-slate-400 font-semibold">{{ $users->total() }}</span>
                        user
                    </p>
                    <div class="flex items-center gap-1">
                        {{-- Prev --}}
                        <button wire:click="previousPage" @disabled($users->onFirstPage())
                            class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 border border-slate-200 dark:border-white/10 hover:border-emerald-300 hover:text-emerald-500 transition disabled:opacity-30 disabled:cursor-not-allowed bg-white dark:bg-transparent">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>

                        {{-- Pages --}}
                        @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                            <button wire:click="gotoPage({{ $page }})"
                                class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-semibold border transition-all duration-150
                                {{ $users->currentPage() == $page
                                    ? 'text-white border-transparent shadow-md shadow-emerald-500/20'
                                    : 'text-slate-500 dark:text-slate-400 border-slate-200 dark:border-white/10 hover:border-emerald-300 hover:text-emerald-500 bg-white dark:bg-transparent' }}"
                                style="{{ $users->currentPage() == $page ? 'background:linear-gradient(135deg,#059669,#10b981)' : '' }}">
                                {{ $page }}
                            </button>
                        @endforeach

                        {{-- Next --}}
                        <button wire:click="nextPage" @disabled($users->onLastPage())
                            class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 border border-slate-200 dark:border-white/10 hover:border-emerald-300 hover:text-emerald-500 transition disabled:opacity-30 disabled:cursor-not-allowed bg-white dark:bg-transparent">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>


    <!-- ══════════════════════════
            MODAL CREATE / EDIT
        ══════════════════════════ -->
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4"
            @keydown.escape.window="$wire.closeModal()"
            style="background:rgba(15,23,42,.6);backdrop-filter:blur(8px)">

            <div class="relative w-full max-w-md rounded-2xl overflow-hidden shadow-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/10"
                style="box-shadow:0 25px 60px rgba(0,0,0,.15),0 0 0 1px rgba(16,185,129,.08)" @click.stop>

                {{-- Accent Bar --}}
                <div class="h-1 w-full" style="background:linear-gradient(90deg,#10b981,#059669,#047857)"></div>

                {{-- Header --}}
                <div
                    class="flex items-center justify-between px-6 pt-5 pb-4 border-b border-slate-100 dark:border-white/5">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0"
                            style="background:#10b98115">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                @if ($isEdit)
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                @endif
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-slate-800 dark:text-white font-bold text-base leading-tight">
                                {{ $isEdit ? 'Edit User' : 'Tambah User Baru' }}
                            </h2>
                            <p class="text-slate-400 dark:text-slate-600 text-xs mt-0.5">
                                {{ $isEdit ? 'Perbarui informasi pengguna' : 'Isi form untuk membuat akun baru' }}
                            </p>
                        </div>
                    </div>
                    <button wire:click="closeModal"
                        class="w-8 h-8 rounded-xl flex items-center justify-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/5 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Body --}}
                <div class="px-6 py-5 space-y-4">

                    {{-- Name --}}
                    <div>
                        <label
                            class="block text-slate-500 dark:text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1.5">Nama
                            Lengkap</label>
                        <input wire:model="form.name" type="text" placeholder="Masukkan nama lengkap"
                            class="w-full px-4 py-2.5 rounded-xl text-slate-800 dark:text-white text-sm placeholder-slate-300 dark:placeholder-slate-600 outline-none border transition bg-white dark:bg-slate-800/60
                            {{ $errors->has('form.name') ? 'border-red-400 focus:border-red-400' : 'border-slate-200 dark:border-white/10 focus:border-emerald-400 dark:focus:border-emerald-500/60' }}" />
                        @error('form.name')
                            <p class="text-red-400 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label
                            class="block text-slate-500 dark:text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1.5">Email</label>
                        <input wire:model="form.email" type="email" placeholder="email@domain.com"
                            class="w-full px-4 py-2.5 rounded-xl text-slate-800 dark:text-white text-sm placeholder-slate-300 dark:placeholder-slate-600 outline-none border transition bg-white dark:bg-slate-800/60
                            {{ $errors->has('form.email') ? 'border-red-400 focus:border-red-400' : 'border-slate-200 dark:border-white/10 focus:border-emerald-400 dark:focus:border-emerald-500/60' }}" />
                        @error('form.email')
                            <p class="text-red-400 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label
                            class="block text-slate-500 dark:text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1.5">NO
                            SAP</label>
                        <input wire:model="form.no_sap" type="no_sap" placeholder="NO SAP"
                            class="w-full px-4 py-2.5 rounded-xl text-slate-800 dark:text-white text-sm placeholder-slate-300 dark:placeholder-slate-600 outline-none border transition bg-white dark:bg-slate-800/60
                            {{ $errors->has('form.no_sap') ? 'border-red-400 focus:border-red-400' : 'border-slate-200 dark:border-white/10 focus:border-emerald-400 dark:focus:border-emerald-500/60' }}" />
                        @error('form.no_sap')
                            <p class="text-red-400 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label
                            class="block text-slate-500 dark:text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1.5">
                            Password
                            @if ($isEdit)
                                <span class="normal-case font-normal text-slate-400 dark:text-slate-600 ml-1">—
                                    kosongkan jika tidak diubah</span>
                            @endif
                        </label>
                        <input wire:model="form.password" type="password"
                            placeholder="{{ $isEdit ? '••••••••' : 'Min. 8 karakter' }}"
                            class="w-full px-4 py-2.5 rounded-xl text-slate-800 dark:text-white text-sm placeholder-slate-300 dark:placeholder-slate-600 outline-none border transition bg-white dark:bg-slate-800/60
                            {{ $errors->has('form.password') ? 'border-red-400 focus:border-red-400' : 'border-slate-200 dark:border-white/10 focus:border-emerald-400 dark:focus:border-emerald-500/60' }}" />
                        @error('form.password')
                            <p class="text-red-400 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Role & Status --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label
                                class="block text-slate-500 dark:text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1.5">Role</label>
                            <select wire:model="form.role"
                                class="w-full px-4 py-2.5 rounded-xl text-slate-700 dark:text-slate-300 text-sm outline-none border border-slate-200 dark:border-white/10 focus:border-emerald-400 transition bg-white dark:bg-slate-800/60">
                                <option value="">Pilih Role</option>
                                <option value="admin">Admin</option>
                                <option value="manager">Manager</option>
                            </select>
                            @error('form.role')
                                <p class="text-red-400 text-xs mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label
                                class="block text-slate-500 dark:text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1.5">Status</label>
                            <select wire:model="form.status"
                                class="w-full px-4 py-2.5 rounded-xl text-slate-700 dark:text-slate-300 text-sm outline-none border border-slate-200 dark:border-white/10 focus:border-emerald-400 transition bg-white dark:bg-slate-800/60">
                                <option value="active">Aktif</option>
                                <option value="inactive">Non-aktif</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Footer --}}
                <div
                    class="flex justify-end gap-2 px-6 py-4 bg-slate-50 dark:bg-white/[0.02] border-t border-slate-100 dark:border-white/5">
                    <button wire:click="closeModal"
                        class="px-4 py-2.5 rounded-xl text-slate-500 dark:text-slate-400 text-sm font-medium border border-slate-200 dark:border-white/10 hover:bg-white dark:hover:bg-white/5 transition">
                        Batal
                    </button>
                    <button wire:click="save"
                        class="px-5 py-2.5 rounded-xl text-white text-sm font-semibold shadow-lg shadow-emerald-500/20 transition-all duration-200 hover:scale-105 active:scale-95 flex items-center gap-2"
                        style="background:linear-gradient(135deg,#059669,#10b981)">
                        <svg wire:loading wire:target="save" class="w-4 h-4 animate-spin" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4" />
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
                        </svg>
                        <span wire:loading.remove wire:target="save">
                            {{ $isEdit ? 'Simpan Perubahan' : 'Buat User' }}
                        </span>
                        <span wire:loading wire:target="save">Menyimpan...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif


    <!-- ══════════════════════════
            MODAL DELETE
        ══════════════════════════ -->
    @if ($showDeleteModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4"
            style="background:rgba(15,23,42,.6);backdrop-filter:blur(8px)">
            <div class="absolute inset-0" wire:click="closeModal"></div>

            <div
                class="relative w-full max-w-sm rounded-2xl overflow-hidden shadow-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-red-500/10">
                <div class="h-1 w-full" style="background:linear-gradient(90deg,#ef4444,#fb7185)"></div>
                <div class="p-7 text-center">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-4"
                        style="background:rgba(251,113,133,.1)">
                        <svg class="w-7 h-7 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>
                    <h3 class="text-slate-800 dark:text-white font-bold text-lg mb-1">Hapus User?</h3>
                    <p class="text-slate-400 dark:text-slate-500 text-sm mb-1">Tindakan ini tidak dapat dibatalkan.</p>
                    <p class="text-slate-600 dark:text-slate-300 font-semibold text-sm mb-6">
                        "{{ $deleteTargetName }}" akan dihapus permanen.
                    </p>
                    <div class="flex gap-2">
                        <button wire:click="closeModal"
                            class="flex-1 px-4 py-2.5 rounded-xl text-slate-500 dark:text-slate-400 text-sm font-medium border border-slate-200 dark:border-white/10 hover:bg-slate-50 dark:hover:bg-white/5 transition">
                            Batal
                        </button>
                        <button wire:click="deleteUser"
                            class="flex-1 px-4 py-2.5 rounded-xl text-white text-sm font-semibold transition-all duration-200 hover:scale-105 active:scale-95 shadow-lg shadow-red-500/20 flex items-center justify-center gap-2"
                            style="background:linear-gradient(135deg,#ef4444,#fb7185)">
                            <svg wire:loading wire:target="deleteUser" class="w-4 h-4 animate-spin" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4" />
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


    <!-- ══ TOAST ══ -->
    @if (session()->has('toast'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3500)"
            x-transition:enter="transition duration-300" x-transition:enter-start="opacity-0 translate-y-3 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100" x-transition:leave="transition duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 translate-y-2"
            class="fixed bottom-6 right-6 z-50 flex items-center gap-3 px-4 py-3 rounded-xl text-white text-sm font-medium shadow-xl border"
            style="{{ session('toast.type') === 'success'
                ? 'background:linear-gradient(135deg,rgba(16,185,129,.97),rgba(5,150,105,.97));border-color:rgba(52,211,153,.2)'
                : 'background:linear-gradient(135deg,rgba(239,68,68,.97),rgba(220,38,38,.97));border-color:rgba(251,113,133,.2)' }}">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="{{ session('toast.type') === 'success'
                        ? 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
                        : 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z' }}" />
            </svg>
            <span>{{ session('toast.message') }}</span>
        </div>
    @endif

</div>
