<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="{ darkMode: false }"
    x-init="$watch('darkMode', val => {
        localStorage.setItem('theme', val ? 'dark' : 'light');
        document.documentElement.classList.toggle('dark', val);
    })"
    :class="{ 'dark': darkMode }"
    style="background-color: #0f172a;">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Agrismart Dashboard</title>
    <script>
        (function() {
            const theme = localStorage.getItem('theme');
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <style>
        html.dark {
            background-color: #0f172a;
        }
    </style>
    <link rel="stylesheet" href="/css/main.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    <!-- OpenLayers CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@latest/ol.css">

    <!-- OpenLayers JS -->
    <script src="https://cdn.jsdelivr.net/npm/ol@latest/dist/ol.js"></script>

    @stack('styles')

    @livewireStyles
</head>

<body
    class="bg-slate-100 dark:bg-slate-900 transition-colors duration-300 flex h-screen text-slate-800 dark:text-slate-200">

    <div x-data="{
         open:  localStorage.getItem('sidebar') 
                ? localStorage.getItem('sidebar') === 'open' 
                : true,
        active: 'dashboard',
        sub: false,
        setActive(k) { this.active = k; }
    }" x-init="$watch('open', val => localStorage.setItem('sidebar', val ? 'open' : 'close'))" class="relative flex h-full w-full">

        <livewire:sidebar />
        <!-- Main Content -->
        <main class="flex-1 bg-slate-100 dark:bg-slate-900 transition-colors duration-300 overflow-auto">
            <div
                x-data="{
        notifications: [],
        add(event) {
            const id = Date.now();
            this.notifications.push({ id, ...event.detail[0] });
            setTimeout(() => this.remove(id), 3500);
        },
        remove(id) {
            this.notifications = this.notifications.filter(n => n.id !== id);
        }
    }"
                @notify.window="add($event)"
                class="fixed bottom-6 right-6 z-[200] flex flex-col gap-2 pointer-events-none"
                style="max-width: 340px;">
                <template x-for="notif in notifications" :key="notif.id">
                    <div
                        x-show="true"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                        x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                        class="pointer-events-auto flex items-center gap-3 px-4 py-3 rounded-2xl shadow-xl border text-sm font-semibold"
                        :class="{
                'bg-white dark:bg-slate-800 border-emerald-100 dark:border-emerald-800/30 text-emerald-700 dark:text-emerald-400': notif.type === 'success',
                'bg-white dark:bg-slate-800 border-rose-100 dark:border-rose-800/30 text-rose-600 dark:text-rose-400': notif.type === 'danger',
                'bg-white dark:bg-slate-800 border-amber-100 dark:border-amber-800/30 text-amber-700 dark:text-amber-400': notif.type === 'warning',
            }"
                        style="box-shadow: 0 8px 32px rgba(0,0,0,0.12), 0 2px 8px rgba(0,0,0,0.06);">
                        {{-- Icon --}}
                        <div
                            class="w-7 h-7 rounded-xl flex items-center justify-center shrink-0"
                            :class="{
                    'bg-emerald-50 dark:bg-emerald-900/30': notif.type === 'success',
                    'bg-rose-50 dark:bg-rose-900/30': notif.type === 'danger',
                    'bg-amber-50 dark:bg-amber-900/30': notif.type === 'warning',
                }">
                            <svg x-show="notif.type === 'success'" class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                            <svg x-show="notif.type === 'danger'" class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            <svg x-show="notif.type === 'warning'" class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                            </svg>
                        </div>

                        {{-- Message --}}
                        <span x-text="notif.message" class="flex-1 leading-snug"></span>

                        {{-- Close --}}
                        <button
                            @click="remove(notif.id)"
                            class="shrink-0 w-5 h-5 flex items-center justify-center rounded-lg opacity-40 hover:opacity-100 transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </template>
            </div>
            {{ $slot }}
        </main>

        @livewireScripts
        @stack('scripts')

        {{-- AgriBot Chatbot Widget --}}
        <x-chatbot />

</body>
<script>
    document.addEventListener('livewire:navigated', () => {
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    });
</script>

</html>