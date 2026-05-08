<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }"
    x-init="$watch('darkMode', val => {
        localStorage.setItem('theme', val ? 'dark' : 'light');
        document.documentElement.classList.toggle('dark', val);
    })"
    :class="{ 'dark': darkMode }"
    style="background-color: #0f172a;">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
            {{ $slot }}
        </main>

        @livewireScripts
        @stack('scripts')

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