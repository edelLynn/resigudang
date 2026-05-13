<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sultan Dashboard - PT. ResiGudang</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: { primary: '#13ec37', dark: '#10221f', surface: '#162e26' },
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>
        body { background-color: #10221f; font-family: 'Inter', sans-serif; }
        .glass-card {
            background: rgba(22, 46, 38, 0.5); backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05); box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body class="text-white h-screen flex overflow-hidden">

    <aside class="w-64 flex flex-col border-r border-white/5 bg-[#112214]/50 backdrop-blur-xl shrink-0">
        <div class="p-6 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary/80 to-primary/20 flex items-center justify-center">
                <span class="material-symbols-rounded text-black font-bold text-xl">admin_panel_settings</span>
            </div>
            <div>
                <h1 class="text-lg font-bold leading-tight">ResiGudang</h1>
                <p class="text-xs text-white/40 font-medium">Headquarters (PT)</p>
            </div>
        </div>

        <nav class="flex-1 px-4 space-y-2 overflow-y-auto">
            <a href="{{ route('superadmin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('superadmin.dashboard') ? 'bg-primary/10 text-primary border border-primary/20 shadow-[0_0_15px_rgba(19,236,55,0.1)]' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                <span class="material-symbols-rounded">dashboard</span>
                <span class="text-sm {{ request()->routeIs('superadmin.dashboard') ? 'font-bold' : 'font-medium' }}">Dashboard</span>
            </a>
            
            <a href="{{ route('superadmin.prices') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('superadmin.prices') ? 'bg-primary/10 text-primary border border-primary/20 shadow-[0_0_15px_rgba(19,236,55,0.1)]' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                <span class="material-symbols-rounded">currency_exchange</span>
                <span class="text-sm {{ request()->routeIs('superadmin.prices') ? 'font-bold' : 'font-medium' }}">Atur Harga Pasar</span>
            </a>
            
            <a href="{{ route('superadmin.users') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('superadmin.users') ? 'bg-primary/10 text-primary border border-primary/20 shadow-[0_0_15px_rgba(19,236,55,0.1)]' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                <span class="material-symbols-rounded">group_add</span>
                <span class="text-sm {{ request()->routeIs('superadmin.users') ? 'font-bold' : 'font-medium' }}">Kelola Admin & User</span>
            </a>
            
            <a href="{{ route('superadmin.reports') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('superadmin.reports') ? 'bg-primary/10 text-primary border border-primary/20 shadow-[0_0_15px_rgba(19,236,55,0.1)]' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                <span class="material-symbols-rounded">description</span>
                <span class="text-sm {{ request()->routeIs('superadmin.reports') ? 'font-bold' : 'font-medium' }}">Laporan Bulanan</span>
            </a>
            
            <a href="{{ route('superadmin.cms') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('superadmin.cms') ? 'bg-primary/10 text-primary border border-primary/20 shadow-[0_0_15px_rgba(19,236,55,0.1)]' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                <span class="material-symbols-rounded">web</span>
                <span class="text-sm {{ request()->routeIs('superadmin.cms') ? 'font-bold' : 'font-medium' }}">CMS Website</span>
            </a>
        </nav>

        <div class="p-4 border-t border-white/5">
             <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 p-3 rounded-xl bg-white/5 hover:bg-red-500/10 hover:text-red-400 transition-colors text-left">
                    <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-xs font-bold">{{ substr(Auth::user()->name ?? 'SA', 0, 2) }}</div>
                    <div class="flex-1 overflow-hidden">
                        <p class="text-xs font-bold truncate">{{ Auth::user()->name ?? 'Super Admin' }}</p>
                        <p class="text-[10px] opacity-50">Logout</p>
                    </div>
                    <span class="material-symbols-rounded text-base">logout</span>
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col relative h-full overflow-hidden w-full">
        <div class="absolute top-[-20%] right-[-10%] w-[600px] h-[600px] bg-primary/5 rounded-full blur-[120px] pointer-events-none"></div>
        <header class="h-20 px-8 flex items-center justify-between border-b border-white/5 bg-dark/80 backdrop-blur-md z-10 shrink-0">
            <div>
                <h2 class="text-2xl font-bold tracking-tight">@yield('title', 'Dashboard')</h2>
                <p class="text-white/40 text-xs">@yield('subtitle', 'Panel Kontrol Utama')</p>
            </div>
        </header>
        <div class="flex-1 overflow-y-auto p-8 space-y-8">
            {{ $slot }}
        </div>
    </main>
</body>
</html>