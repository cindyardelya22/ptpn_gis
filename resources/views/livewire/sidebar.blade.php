<div>
    <!-- ===== SIDEBAR ===== -->
    <aside :class="open ? 'sidebar-width-open' : 'sidebar-width-close'"
        class="relative flex flex-col h-full flex-shrink-0 transition-all duration-300 ease-in-out overflow-hidden z-30 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800">

        <!-- Logo Section -->
        <div class="relative flex items-center px-6 py-6 border-b border-slate-50 dark:border-slate-800">
            <div
                class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center bg-emerald-500 shadow-lg shadow-emerald-200 dark:shadow-emerald-900/50">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div x-show="open" x-transition:enter="transition duration-150 delay-100"
                x-transition:enter-start="opacity-0 -translate-x-2" x-transition:enter-end="opacity-100 translate-x-0"
                class="ml-3">
                <p class="text-slate-800 dark:text-white font-bold text-lg leading-tight tracking-tight">AgriSmart</p>
                <p class="text-emerald-600 dark:text-emerald-400 text-[10px] font-bold uppercase tracking-widest">Palm
                    Oil GIS</p>
            </div>
        </div>

        <!-- Navigation Section -->
        <nav class="flex-1 overflow-y-auto overflow-x-hidden py-6 space-y-1.5 px-4">

            @php
                $menus = [
                    ['id' => 'dashboard', 'label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z'],
                    ['id' => 'unsur-hara', 'label' => 'Data Unsur Hara', 'route' => 'unsur-hara', 'icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                    ['id' => 'peta-blok', 'label' => 'Peta Blok Kebun', 'route' => 'peta-blok', 'icon' => 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7l5-2.5 5.553 2.776a1 1 0 01.447.894v10.764a1 1 0 01-1.447.894L15 17l-6 3z'],
                    ['id' => 'analytics', 'label' => 'Prediksi Panen', 'route' => 'analytics', 'icon' => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6'],
                    ['id' => 'laporan', 'label' => 'Laporan', 'route' => 'reports', 'icon' => 'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z'],
                    ['id' => 'users', 'label' => 'User Management', 'route' => 'user', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z']
                ];
            @endphp

            @foreach($menus as $menu)
                <a href="{{ route($menu['route']) }}" wire:navigate
                    class="group flex items-center gap-4 px-3.5 py-3 rounded-xl transition-all duration-200 
                           {{ request()->routeIs($menu['route']) ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-800 dark:hover:text-slate-200' }}">
                    <div
                        class="{{ request()->routeIs($menu['route']) ? 'text-emerald-600 dark:text-emerald-500' : 'text-slate-400 group-hover:text-emerald-500 dark:group-hover:text-emerald-400' }} flex-shrink-0 transition-all duration-200">
                        <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $menu['icon'] }}" />
                        </svg>
                    </div>
                    <span x-show="open" class="text-sm font-medium tracking-wide">{{ $menu['label'] }}</span>
                </a>
            @endforeach
        </nav>

        <!-- Profile Section & Theme Toggle -->
        <div class="p-4 border-t border-slate-100 dark:border-slate-800 space-y-2">

            <!-- Theme Toggle -->
            <button @click="darkMode = !darkMode"
                class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-800 dark:hover:text-slate-200 transition-colors"
                :title="darkMode ? 'Switch to Light Mode' : 'Switch to Dark Mode'">
                <div class="flex-shrink-0">
                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                        </path>
                    </svg>
                    <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        style="display:none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </div>
                <span x-show="open" class="text-sm font-medium" x-text="darkMode ? 'Light Mode' : 'Dark Mode'"></span>
            </button>

            <!-- Profile Info -->
            <div :class="open ? 'px-2' : 'justify-center'"
                class="flex items-center gap-3 py-2 rounded-2xl hover:bg-slate-50 dark:hover:bg-slate-800 cursor-pointer transition-all duration-200">
                <div class="relative flex-shrink-0">
                    <div
                        class="w-10 h-10 rounded-xl flex items-center justify-center bg-gradient-to-br from-emerald-400 to-emerald-600 text-white font-bold text-sm shadow-md shadow-emerald-100 dark:shadow-emerald-900/50 italic">
                        AD
                    </div>
                </div>
                <div x-show="open" class="flex-1 min-w-0">
                    <p class="text-slate-800 dark:text-slate-200 text-sm font-bold truncate">Administrator</p>
                    <p
                        class="text-slate-400 dark:text-slate-500 text-[10px] font-medium uppercase tracking-tighter truncate">
                        Estate Manager
                    </p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Toggle Button -->
    <button @click="open = !open" :class="open ? 'left-[244px]' : 'left-16'"
        class="absolute z-50 top-10 w-8 h-8 rounded-full flex items-center justify-center 
           shadow-xl shadow-slate-200 dark:shadow-slate-900 transition-all duration-300 focus:outline-none
           bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 text-slate-400 hover:text-emerald-500 dark:hover:text-emerald-400">

        <svg :class="open ? '' : 'rotate-180'" class="w-4 h-4 transition-transform duration-300" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">

            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
        </svg>
    </button>
</div>