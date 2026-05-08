<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>NexAdmin Sidebar</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Outfit', sans-serif;
            margin: 0;
            overflow: hidden;
        }

        ::-webkit-scrollbar {
            width: 4px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(129, 140, 248, 0.3);
            border-radius: 9999px;
        }

        .sidebar-width-open {
            width: 17rem;
        }

        .sidebar-width-close {
            width: 5rem;
        }

        .glow-indigo {
            box-shadow: 0 0 14px 2px rgba(99, 102, 241, .45);
        }

        .glow-violet {
            box-shadow: 0 0 14px 2px rgba(139, 92, 246, .45);
        }

        .glow-pink {
            box-shadow: 0 0 14px 2px rgba(236, 72, 153, .45);
        }

        .glow-cyan {
            box-shadow: 0 0 14px 2px rgba(6, 182, 212, .45);
        }

        .glow-amber {
            box-shadow: 0 0 14px 2px rgba(245, 158, 11, .45);
        }
    </style>
</head>

<body class="bg-slate-100 flex h-screen">

    <div x-data="{
  open: true,
  active: 'dashboard',
  sub: false,
  setActive(k){ this.active = k; }
}" class="relative flex h-full w-full">

        <livewire:sidebar />

        <!-- Main Content -->
        <main class="flex-1 bg-slate-100 overflow-auto">
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
        </main>
    </div>
</body>

</html>