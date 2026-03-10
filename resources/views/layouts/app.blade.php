<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }"
    x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
    :class="{ 'dark': darkMode }">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>NexAdmin Sidebar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <link rel="stylesheet" href="/css/main.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
        
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
        open: true,
        active: 'dashboard',
        sub: false,
        setActive(k){ this.active = k; }
        }" class="relative flex h-full w-full">

        <livewire:sidebar />
        <!-- Main Content -->
        <main class="flex-1 bg-slate-100 dark:bg-slate-900 transition-colors duration-300 overflow-auto">
            {{ $slot }}
        </main>

        @livewireScripts

        @stack('scripts')
</body>

</html>