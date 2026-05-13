<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CEO Dashboard - PT. ResiGudang</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0" rel="stylesheet"/>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#13ec37',
                        dark: '#10221f',
                        surface: '#162e26',
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body { background-color: #10221f; font-family: 'Inter', sans-serif; }
        
        .glass-card {
            background: rgba(22, 46, 38, 0.5);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
        }

        .glass-btn:hover {
            background: rgba(19, 236, 55, 0.1);
            border-color: rgba(19, 236, 55, 0.4);
            box-shadow: 0 0 15px rgba(19, 236, 55, 0.2);
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #10221f; }
        ::-webkit-scrollbar-thumb { background: #162e26; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #13ec37; }
    </style>
</head>
<body class="text-white h-screen flex overflow-hidden">

    <aside class="w-64 flex flex-col border-r border-white/5 bg-[#112214]/50 backdrop-blur-xl relative z-20 shrink-0">
        <div class="p-6 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary/80 to-primary/20 flex items-center justify-center shadow-lg shadow-primary/20">
                <span class="material-symbols-rounded text-black font-bold text-xl">admin_panel_settings</span>
            </div>
            <div>
                <h1 class="text-lg font-bold tracking-tight leading-tight">ResiGudang</h1>
                <p class="text-xs text-white/40 font-medium">Headquarters (PT)</p>
            </div>
        </div>

        <nav class="flex-1 px-4 py-4 space-y-2 overflow-y-auto">
            <a href="{{ route('superadmin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-primary/10 text-primary border border-primary/20 shadow-[0_0_15px_rgba(19,236,55,0.1)] transition-all">
                <span class="material-symbols-rounded">dashboard</span>
                <span class="text-sm font-bold">Dashboard</span>
            </a>

            <a href="{{ route('superadmin.prices') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/60 hover:bg-white/5 hover:text-white transition-all group">
                <span class="material-symbols-rounded group-hover:scale-110 transition-transform">currency_exchange</span>
                <span class="text-sm font-medium">Atur Harga Pasar</span>
            </a>

            <a href="{{ route('superadmin.users') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/60 hover:bg-white/5 hover:text-white transition-all group">
                <span class="material-symbols-rounded group-hover:scale-110 transition-transform">group_add</span>
                <span class="text-sm font-medium">Kelola Admin & User</span>
            </a>

            <a href="{{ route('superadmin.reports') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/60 hover:bg-white/5 hover:text-white transition-all group">
                <span class="material-symbols-rounded group-hover:scale-110 transition-transform">description</span>
                <span class="text-sm font-medium">Laporan Bulanan</span>
            </a>
            <a href="{{ route('superadmin.cms') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/60 hover:bg-white/5 hover:text-white transition-all {{ request()->routeIs('superadmin.cms') ? 'bg-primary/10 text-primary font-bold border border-primary/20' : '' }}">
                <span class="material-symbols-rounded">web</span>
                <span class="text-sm font-medium">CMS Website</span>
            </a>
        </nav>

        <div class="p-4 border-t border-white/5 relative">
            <button onclick="toggleProfileMenu()" class="w-full flex items-center gap-3 p-3 rounded-xl bg-white/5 border border-white/5 hover:bg-white/10 transition-colors cursor-pointer text-left">
                <div class="w-9 h-9 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-sm">
                    {{ substr(Auth::user()->name, 0, 2) }}
                </div>
                <div class="flex-1 overflow-hidden">
                    <p class="text-sm font-bold truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-blue-400 uppercase tracking-wider">Super Admin</p>
                </div>
                <span class="material-symbols-rounded text-white/50">expand_less</span>
            </button>

            <div id="profile-menu" class="hidden absolute bottom-20 left-4 right-4 bg-[#162e26] border border-white/10 rounded-xl shadow-xl overflow-hidden backdrop-blur-md z-50">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-3 text-sm text-red-400 hover:bg-red-500/10 transition-colors flex items-center gap-2">
                        <span class="material-symbols-rounded text-base">logout</span> Log Out
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <main class="flex-1 flex flex-col relative h-full overflow-hidden w-full">
        <div class="absolute top-[-20%] right-[-10%] w-[600px] h-[600px] bg-blue-500/10 rounded-full blur-[120px] pointer-events-none"></div>

        <header class="h-20 px-8 flex items-center justify-between border-b border-white/5 bg-dark/80 backdrop-blur-md z-10 shrink-0">
            <div>
                <h2 class="text-2xl font-bold tracking-tight">Dashboard Pusat 🏢</h2>
                <p class="text-white/40 text-xs">Pantau harga pasar dan aktivitas keseluruhan.</p>
            </div>
            
            <div class="glass-card px-4 py-2 rounded-lg flex items-center gap-2">
                <span class="material-symbols-rounded text-primary text-sm">calendar_today</span>
                <span class="text-xs font-bold text-white/80">{{ date('d F Y') }}</span>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8 space-y-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="glass-card p-8 rounded-3xl relative overflow-hidden group hover:border-primary/50 transition-all">
                    <div class="absolute right-0 top-0 p-6 opacity-10 group-hover:opacity-20 transition-opacity">
                        <span class="material-symbols-rounded text-8xl text-primary">coffee</span>
                    </div>
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-bold text-white/90">Harga Robusta</h3>
                                <p class="text-xs text-white/40">Grade Standar (Acuan)</p>
                            </div>
                            <span class="px-3 py-1 rounded-full bg-primary/20 text-primary text-xs font-bold border border-primary/20">
                                Stabil
                            </span>
                        </div>
                        <div class="flex items-baseline gap-2 mb-2">
                            <span class="text-sm text-white/50 font-bold">Rp</span>
                            <span class="text-6xl font-black text-white tracking-tighter">
                                {{ number_format($stats['robusta_price'], 0, ',', '.') }}
                            </span>
                        </div>
                        <p class="text-xs text-white/40 flex items-center gap-1">
                            <span class="material-symbols-rounded text-sm">update</span> Update terakhir: Hari ini
                        </p>
                    </div>
                </div>

                <div class="glass-card p-8 rounded-3xl relative overflow-hidden group hover:border-blue-500/50 transition-all">
                    <div class="absolute right-0 top-0 p-6 opacity-10 group-hover:opacity-20 transition-opacity">
                        <span class="material-symbols-rounded text-8xl text-blue-500">coffee_maker</span>
                    </div>
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-bold text-white/90">Harga Arabica</h3>
                                <p class="text-xs text-white/40">Premium Grade</p>
                            </div>
                            <span class="px-3 py-1 rounded-full bg-blue-500/20 text-blue-400 text-xs font-bold border border-blue-500/20">
                                Auto (+25k)
                            </span>
                        </div>
                        <div class="flex items-baseline gap-2 mb-2">
                            <span class="text-sm text-white/50 font-bold">Rp</span>
                            <span class="text-6xl font-black text-white tracking-tighter">
                                {{ number_format($stats['arabica_price'], 0, ',', '.') }}
                            </span>
                        </div>
                        <p class="text-xs text-white/40">Harga otomatis mengikuti selisih Robusta</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                <div class="glass-card p-5 rounded-2xl flex flex-col items-center justify-center text-center hover:bg-white/5 transition-colors">
                    <p class="text-xs text-white/40 font-bold uppercase tracking-wider mb-2">Total Koperasi</p>
                    <h4 class="text-3xl font-black text-white">{{ $stats['total_koperasi'] }}</h4>
                    <span class="text-[10px] text-white/30">Unit Aktif</span>
                </div>
                
                <div class="glass-card p-5 rounded-2xl flex flex-col items-center justify-center text-center hover:bg-white/5 transition-colors">
                    <p class="text-xs text-white/40 font-bold uppercase tracking-wider mb-2">Total Petani</p>
                    <h4 class="text-3xl font-black text-white">{{ $stats['total_petani'] }}</h4>
                    <span class="text-[10px] text-white/30">Orang Terdaftar</span>
                </div>

                <div class="glass-card p-5 rounded-2xl flex flex-col items-center justify-center text-center hover:bg-white/5 transition-colors border-white/10 shadow-[0_0_15px_rgba(255,255,255,0.05)]">
                    <p class="text-xs text-white/40 font-bold uppercase tracking-wider mb-2">Total Stok Gudang</p>
                    <div class="flex items-baseline gap-1">
                        <h4 class="text-3xl font-black text-amber-500">{{ number_format($stats['total_stok'] ?? 0) }}</h4>
                        <span class="text-sm font-bold text-amber-500/50">Kg</span>
                    </div>
                    <span class="text-[10px] text-white/30 mt-1">Gabungan Semua Koperasi</span>
                </div>

                <div class="glass-card p-5 rounded-2xl flex flex-col items-center justify-center text-center hover:bg-white/5 transition-colors border-white/10 shadow-[0_0_15px_rgba(19,236,55,0.05)]">
                    <p class="text-xs text-white/40 font-bold uppercase tracking-wider mb-2">Total Uang Keluar</p>
                    <h4 class="text-2xl font-black text-primary">Rp {{ number_format(($stats['total_keuangan'] ?? 0) / 1000000, 1) }} Jt</h4>
                    <span class="text-[10px] text-white/30 mt-1">DP & Pelunasan Petani</span>
                </div>
                
            </div>

            <div>
                <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                    <span class="w-1 h-6 bg-primary rounded-full"></span> Akses Cepat
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
    
                    <a href="{{ route('superadmin.prices') }}" class="block glass-card glass-btn p-6 rounded-2xl text-left group transition-all relative overflow-hidden cursor-pointer">
                        <div class="absolute right-[-20px] bottom-[-20px] opacity-5 group-hover:opacity-20 transition-opacity">
                            <span class="material-symbols-rounded text-9xl">currency_exchange</span>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-primary/20 flex items-center justify-center text-primary mb-4">
                            <span class="material-symbols-rounded text-2xl">edit</span>
                        </div>
                        <h4 class="text-lg font-bold text-white mb-1">Update Harga</h4>
                        <p class="text-xs text-white/50 leading-relaxed">Ubah harga harian Robusta agar sinkron ke semua unit koperasi.</p>
                    </a>

                    <a href="{{ route('superadmin.users') }}" class="block glass-card glass-btn p-6 rounded-2xl text-left group transition-all relative overflow-hidden cursor-pointer">
                        <div class="absolute right-[-20px] bottom-[-20px] opacity-5 group-hover:opacity-20 transition-opacity">
                            <span class="material-symbols-rounded text-9xl">group</span>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-blue-500/20 flex items-center justify-center text-blue-500 mb-4">
                            <span class="material-symbols-rounded text-2xl">person_add</span>
                        </div>
                        <h4 class="text-lg font-bold text-white mb-1">Tambah Admin</h4>
                        <p class="text-xs text-white/50 leading-relaxed">Daftarkan Admin Koperasi baru atau blokir user bermasalah.</p>
                    </a>

                    <a href="{{ route('superadmin.reports') }}" class="block glass-card glass-btn p-6 rounded-2xl text-left group transition-all relative overflow-hidden cursor-pointer">
                        <div class="absolute right-[-20px] bottom-[-20px] opacity-5 group-hover:opacity-20 transition-opacity">
                            <span class="material-symbols-rounded text-9xl">description</span>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-purple-500/20 flex items-center justify-center text-purple-500 mb-4">
                            <span class="material-symbols-rounded text-2xl">download</span>
                        </div>
                        <h4 class="text-lg font-bold text-white mb-1">Download Laporan</h4>
                        <p class="text-xs text-white/50 leading-relaxed">Rekap data setoran masuk dan keuangan dalam format Excel.</p>
                    </a>

                </div>
            </div>

        </div>
    </main>

    <script>
        function toggleProfileMenu() {
            document.getElementById('profile-menu').classList.toggle('hidden');
        }
        
        // Klik di luar nutup menu
        window.onclick = function(event) {
            if (!event.target.closest('button')) {
                document.getElementById('profile-menu').classList.add('hidden');
            }
        }
    </script>
</body>
</html>