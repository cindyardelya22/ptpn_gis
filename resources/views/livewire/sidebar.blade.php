<div>
    <!-- ===== SIDEBAR ===== -->
    <aside
        :class="open ? 'sidebar-width-open' : 'sidebar-width-close'"
        class="relative flex flex-col h-full flex-shrink-0 transition-all duration-300 ease-in-out overflow-hidden z-30"
        style="background:linear-gradient(160deg,#0f172a 0%,#1e1b4b 55%,#0f172a 100%);">
        <!-- blob bg -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="absolute -top-24 -left-24 w-72 h-72 rounded-full opacity-10"
                style="background:radial-gradient(circle,#818cf8,transparent)"></div>
            <div class="absolute bottom-10 right-0 w-56 h-56 rounded-full opacity-10"
                style="background:radial-gradient(circle,#a78bfa,transparent)"></div>
        </div>

        <!-- Logo -->
        <div class="relative flex items-center px-4 py-5 border-b border-white/10">
            <div class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center glow-indigo"
                style="background:linear-gradient(135deg,#818cf8,#a78bfa)">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <div x-show="open" x-transition:enter="transition duration-150 delay-100"
                x-transition:enter-start="opacity-0 -translate-x-2"
                x-transition:enter-end="opacity-100 translate-x-0"
                class="ml-3">
                <p class="text-white font-bold text-xl leading-tight tracking-tight">NexAdmin</p>
                <p class="text-indigo-300 text-xs">Control Panel</p>
            </div>
        </div>

        <!-- Nav -->
        <nav class="flex-1 overflow-y-auto overflow-x-hidden py-3 space-y-0.5 px-3">

            <!-- Label -->
            <div x-show="open" class="px-2 pt-3 pb-1">
                <p class="text-indigo-400/50 text-xs font-semibold uppercase tracking-widest">Main</p>
            </div>

            <!-- Dashboard -->
            <a href="#" @click.prevent="setActive('dashboard')"
                :class="active==='dashboard'
           ? 'bg-indigo-600/30 text-white border border-indigo-500/30 glow-indigo'
           : 'text-indigo-200/60 hover:bg-white/5 hover:text-white'"
                class="group flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200">
                <div :class="active==='dashboard' ? 'bg-indigo-500 glow-indigo' : 'bg-white/10 group-hover:bg-indigo-500/40'"
                    class="flex-shrink-0 w-9 h-9 rounded-lg flex items-center justify-center transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1V7zm0 10a1 1 0 011-1h6a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2zm10-10a1 1 0 011-1h6a1 1 0 011 1v2a1 1 0 01-1 1h-6a1 1 0 01-1-1v-2zm0 6a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1h-6a1 1 0 01-1-1v-6z" />
                    </svg>
                </div>
                <span x-show="open" class="flex-1 text-sm font-medium">Dashboard</span>
                <span x-show="open" class="text-xs bg-indigo-500 text-white px-1.5 py-0.5 rounded-full font-bold">5</span>
            </a>

            <!-- Label Forms -->
            <div x-show="open" class="px-2 pt-4 pb-1">
                <p class="text-indigo-400/50 text-xs font-semibold uppercase tracking-widest">Formulir</p>
            </div>

            <!-- Forms collapsible -->
            <div>
                <button @click="sub=!sub; setActive('forms')"
                    :class="active==='forms'
            ? 'bg-violet-600/30 text-white border border-violet-500/30'
            : 'text-indigo-200/60 hover:bg-white/5 hover:text-white'"
                    class="group w-full flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200">
                    <div :class="active==='forms' ? 'bg-violet-500 glow-violet' : 'bg-white/10 group-hover:bg-violet-500/40'"
                        class="flex-shrink-0 w-9 h-9 rounded-lg flex items-center justify-center transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <span x-show="open" class="flex-1 text-left text-sm font-medium">Form</span>
                    <svg x-show="open" :class="sub ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="sub && open"
                    x-transition:enter="transition-all duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="ml-12 mt-1 space-y-0.5 border-l-2 border-violet-500/30 pl-3">
                    <template x-for="item in [{k:'form-input',l:'Input Form'},{k:'form-wizard',l:'Form Wizard'},{k:'form-upload',l:'File Upload'},{k:'form-builder',l:'Form Builder'}]">
                        <a href="#" @click.prevent="setActive(item.k)"
                            :class="active===item.k ? 'text-violet-300 font-semibold' : 'text-indigo-300/50 hover:text-indigo-200'"
                            class="flex items-center gap-2 py-1.5 text-sm transition-colors duration-150">
                            <span :class="active===item.k ? 'bg-violet-400 w-2 h-2' : 'bg-indigo-700 w-1.5 h-1.5'"
                                class="rounded-full flex-shrink-0 transition-all duration-150"></span>
                            <span x-text="item.l"></span>
                        </a>
                    </template>
                </div>
            </div>

            <!-- Analytics -->
            <a href="#" @click.prevent="setActive('analytics')"
                :class="active==='analytics'
           ? 'bg-pink-600/30 text-white border border-pink-500/30'
           : 'text-indigo-200/60 hover:bg-white/5 hover:text-white'"
                class="group flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200">
                <div :class="active==='analytics' ? 'bg-pink-500 glow-pink' : 'bg-white/10 group-hover:bg-pink-500/40'"
                    class="flex-shrink-0 w-9 h-9 rounded-lg flex items-center justify-center transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <span x-show="open" class="text-sm font-medium">Analytics</span>
            </a>

            <!-- Users -->
            <a href="#" @click.prevent="setActive('users')"
                :class="active==='users'
           ? 'bg-cyan-600/30 text-white border border-cyan-500/30'
           : 'text-indigo-200/60 hover:bg-white/5 hover:text-white'"
                class="group flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200">
                <div :class="active==='users' ? 'bg-cyan-500 glow-cyan' : 'bg-white/10 group-hover:bg-cyan-500/40'"
                    class="flex-shrink-0 w-9 h-9 rounded-lg flex items-center justify-center transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <span x-show="open" class="text-sm font-medium">Users</span>
            </a>

            <!-- Settings -->
            <a href="#" @click.prevent="setActive('settings')"
                :class="active==='settings'
           ? 'bg-amber-600/30 text-white border border-amber-500/30'
           : 'text-indigo-200/60 hover:bg-white/5 hover:text-white'"
                class="group flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200">
                <div :class="active==='settings' ? 'bg-amber-500 glow-amber' : 'bg-white/10 group-hover:bg-amber-500/40'"
                    class="flex-shrink-0 w-9 h-9 rounded-lg flex items-center justify-center transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <span x-show="open" class="text-sm font-medium">Settings</span>
            </a>
        </nav>

        <!-- User Profile -->
        <div class="relative border-t border-white/10 px-3 py-4">
            <div class="flex items-center gap-3 px-2 py-2 rounded-xl hover:bg-white/5 cursor-pointer transition">
                <div class="relative flex-shrink-0">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white font-bold text-sm ring-2 ring-indigo-500/50"
                        style="background:linear-gradient(135deg,#f472b6,#818cf8)">AD</div>
                    <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-400 rounded-full border-2 border-slate-900"></span>
                </div>
                <div x-show="open" class="flex-1 min-w-0">
                    <p class="text-white text-sm font-semibold truncate">Admin User</p>
                    <p class="text-indigo-300/50 text-xs truncate">admin@nexadmin.app</p>
                </div>
                <svg x-show="open" class="w-4 h-4 text-indigo-400/50 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                </svg>
            </div>
        </div>
    </aside>

    <!-- Toggle Button -->
    <button
        @click="open = !open"
        :class="open ? 'left-64' : 'left-16'"
        class="absolute z-50 top-6  w-8 h-8 rounded-full flex items-center justify-center 
           shadow-xl transition-all duration-300 focus:outline-none
           bg-gradient-to-br from-indigo-400 to-purple-400">

        <svg
            :class="open ? '' : 'rotate-180'"
            class="w-4 h-4 text-white transition-transform duration-300"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24">

            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2.5"
                d="M15 19l-7-7 7-7" />
        </svg>
    </button>
</div>