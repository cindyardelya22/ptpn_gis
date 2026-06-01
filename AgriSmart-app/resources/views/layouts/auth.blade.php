<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Auth - Sistem GIS' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        @keyframes float-slow {
            0%, 100% { transform: translateY(0px) translateX(0px) scale(1); }
            33%       { transform: translateY(-30px) translateX(15px) scale(1.05); }
            66%       { transform: translateY(15px) translateX(-10px) scale(0.97); }
        }
        @keyframes float-medium {
            0%, 100% { transform: translateY(0px) translateX(0px) rotate(0deg); }
            50%       { transform: translateY(-20px) translateX(20px) rotate(8deg); }
        }
        @keyframes float-fast {
            0%, 100% { transform: translateY(0px) scale(1); }
            50%       { transform: translateY(-15px) scale(1.08); }
        }
        @keyframes grid-drift {
            0%   { transform: translateX(0) translateY(0); }
            100% { transform: translateX(40px) translateY(40px); }
        }
        @keyframes drift {
            0%   { transform: translateY(0) translateX(0) rotate(0deg); opacity: 0; }
            10%  { opacity: 0.6; }
            90%  { opacity: 0.3; }
            100% { transform: translateY(-120vh) translateX(60px) rotate(360deg); opacity: 0; }
        }

        .orb-1 { animation: float-slow 9s ease-in-out infinite; }
        .orb-2 { animation: float-medium 7s ease-in-out infinite 1s; }
        .orb-3 { animation: float-fast 5s ease-in-out infinite 2s; }
        .orb-4 { animation: float-slow 11s ease-in-out infinite 3s; }

        .bg-grid {
            background-image:
                linear-gradient(rgba(22,163,74,0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(22,163,74,0.06) 1px, transparent 1px);
            background-size: 40px 40px;
            animation: grid-drift 20s linear infinite;
        }

        .particle {
            position: absolute;
            border-radius: 50%;
            background: rgba(22, 163, 74, 0.25);
            animation: drift linear infinite;
            pointer-events: none;
        }
        .p1 { left:10%;  bottom:-10px; animation-duration:14s; animation-delay:0s;  width:5px; height:5px; }
        .p2 { left:25%;  bottom:-10px; animation-duration:18s; animation-delay:3s;  width:4px; height:4px; }
        .p3 { left:40%;  bottom:-10px; animation-duration:12s; animation-delay:1s;  width:7px; height:7px; }
        .p4 { left:60%;  bottom:-10px; animation-duration:16s; animation-delay:5s;  width:4px; height:4px; }
        .p5 { left:75%;  bottom:-10px; animation-duration:20s; animation-delay:2s;  width:6px; height:6px; }
        .p6 { left:88%;  bottom:-10px; animation-duration:15s; animation-delay:7s;  width:3px; height:3px; }
    </style>

    @livewireStyles
</head>

<body class="min-h-screen flex items-center justify-center relative overflow-hidden"
      style="background: linear-gradient(135deg, #f8fafc 0%, #ffffff 50%, #f0fdf4 100%);">

    {{-- Animated Grid Background --}}
    <div class="absolute inset-0 bg-grid opacity-70 pointer-events-none"></div>

    {{-- Floating Orbs --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="orb-1 absolute rounded-full"
             style="top:-128px; left:-128px; width:320px; height:320px;
                    background: radial-gradient(circle, rgba(134,239,172,0.45) 0%, rgba(74,222,128,0.18) 50%, transparent 70%);"></div>
        <div class="orb-2 absolute rounded-full"
             style="bottom:-96px; right:-96px; width:384px; height:384px;
                    background: radial-gradient(circle, rgba(110,231,183,0.4) 0%, rgba(52,211,153,0.15) 50%, transparent 70%);"></div>
        <div class="orb-3 absolute rounded-full"
             style="top:33%; right:-64px; width:192px; height:192px;
                    background: radial-gradient(circle, rgba(187,247,208,0.5) 0%, transparent 70%);"></div>
        <div class="orb-4 absolute rounded-full"
             style="top:32px; right:25%; width:128px; height:128px;
                    background: radial-gradient(circle, rgba(167,243,208,0.35) 0%, transparent 70%);"></div>
    </div>

    {{-- Floating Particles --}}
    <div class="particle p1"></div>
    <div class="particle p2"></div>
    <div class="particle p3"></div>
    <div class="particle p4"></div>
    <div class="particle p5"></div>
    <div class="particle p6"></div>

    {{-- Decorative Rings --}}
    <div class="absolute rounded-full border pointer-events-none"
         style="top:50%; left:50%; transform:translate(-50%,-50%); width:600px; height:600px; border-color:rgba(74,222,128,0.15);"></div>
    <div class="absolute rounded-full border pointer-events-none"
         style="top:50%; left:50%; transform:translate(-50%,-50%); width:820px; height:820px; border-color:rgba(74,222,128,0.08);"></div>

    {{-- Slot Content --}}
    <div class="relative w-full max-w-md px-4">
        {{ $slot }}
    </div>

    @livewireScripts
</body>
</html>