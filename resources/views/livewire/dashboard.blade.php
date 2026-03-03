<div class="p-8 max-w-2xl">
    <h1 class="text-2xl font-bold text-slate-800 mb-1">H</h1>


    <!-- Active menu display -->
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200 mb-5">
        <p class="text-xs text-slate-400 uppercase tracking-wider mb-1">Menu Aktif</p>
        <p class="text-2xl font-bold capitalize"
            :class="{
             'text-indigo-600': active==='dashboard',
             'text-violet-600': active.startsWith('form'),
             'text-pink-600':   active==='analytics',
             'text-cyan-600':   active==='users',
             'text-amber-600':  active==='settings'
           }"
            x-text="active.replace('-',' ')"></p>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200">
            <p class="text-xs text-slate-400 uppercase tracking-wider mb-1">Total Users</p>
            <p class="text-3xl font-bold text-indigo-600">1,248</p>
            <p class="text-xs text-emerald-500 mt-1">↑ 12% bulan ini</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200">
            <p class="text-xs text-slate-400 uppercase tracking-wider mb-1">Active Forms</p>
            <p class="text-3xl font-bold text-violet-600">42</p>
            <p class="text-xs text-emerald-500 mt-1">↑ 3 form baru</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200">
            <p class="text-xs text-slate-400 uppercase tracking-wider mb-1">Revenue</p>
            <p class="text-3xl font-bold text-pink-600">$8.4k</p>
            <p class="text-xs text-rose-500 mt-1">↓ 2% minggu ini</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200">
            <p class="text-xs text-slate-400 uppercase tracking-wider mb-1">Sessions</p>
            <p class="text-3xl font-bold text-cyan-600">9,312</p>
            <p class="text-xs text-emerald-500 mt-1">↑ 8% hari ini</p>
        </div>
    </div>
</div>