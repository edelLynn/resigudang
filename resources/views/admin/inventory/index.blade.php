<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Stok Gudang - Admin</title>
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
            background: rgba(22, 46, 38, 0.5);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body class="text-white h-screen flex overflow-hidden">

    <aside class="w-64 flex flex-col border-r border-white/5 bg-[#112214]/50 backdrop-blur-xl relative z-20 shrink-0">
        <div class="p-6 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center shadow-lg shadow-blue-500/20">
                <span class="material-symbols-rounded text-white font-bold text-xl">admin_panel_settings</span>
            </div>
            <div>
                <h1 class="text-lg font-bold tracking-tight leading-tight">ResiGudang</h1>
                <p class="text-xs text-white/40 font-medium">Admin Unit</p>
            </div>
        </div>
        <nav class="flex-1 px-4 py-4 space-y-2 overflow-y-auto">
            <a href="{{ route('koperasi.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/60 hover:bg-white/5 hover:text-white transition-all group">
                <span class="material-symbols-rounded group-hover:scale-110 transition-transform">dashboard</span>
                <span class="text-sm font-medium">Dashboard</span>
            </a>
            <a href="{{ route('koperasi.deposits.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/60 hover:bg-white/5 hover:text-white transition-all">
                <span class="material-symbols-rounded">add_circle</span>
                <span class="text-sm font-bold">Setor kopi</span>
            </a>
            <a href="{{ route('koperasi.inventory.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-primary/10 text-primary border border-primary/20 shadow-[0_0_15px_rgba(19,236,55,0.1)] transition-all">
                <span class="material-symbols-rounded">inventory_2</span>
                <span class="text-sm font-bold">Stok Gudang</span>
            </a>
            <a href="{{ route('koperasi.history') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/60 hover:bg-white/5 hover:text-white transition-all">
                <span class="material-symbols-rounded">receipt_long</span>
                <span class="text-sm font-medium">Riwayat</span>
            </a>
        </nav>
        <div class="p-4 border-t border-white/5">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 p-3 rounded-xl bg-white/5 border border-white/5 hover:bg-red-500/10 hover:border-red-500/20 hover:text-red-400 transition-all text-left">
                    <span class="material-symbols-rounded text-white/50">logout</span>
                    <span class="text-sm font-bold text-white/70">Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col relative h-full overflow-hidden w-full bg-[#10221f]">
        
        <header class="h-20 px-8 flex items-center justify-between border-b border-white/5 bg-dark/80 backdrop-blur-md z-10 shrink-0">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-white">Stok Gudang</h2>
                <p class="text-white/40 text-xs">Monitoring kapasitas real-time.</p>
            </div>
            <div class="bg-primary/10 text-primary px-4 py-2 rounded-xl font-bold border border-primary/20 flex items-center gap-2 shadow-[0_0_15px_rgba(19,236,55,0.1)]">
                <span class="material-symbols-rounded">payments</span>
                <span>Total Aset: <span class="text-white">Rp {{ number_format($total_aset, 0, ',', '.') }}</span></span>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8 space-y-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                @php $stokRobusta = $stocks->where('coffee_type', 'Robusta')->first()->total_weight_kg ?? 0; @endphp
                <div class="glass-card p-8 rounded-3xl relative overflow-hidden group hover:bg-white/5 transition duration-300 border-l-4 border-l-blue-500">
                    <div class="absolute -right-6 -top-6 p-3 opacity-10 group-hover:opacity-20 transition duration-500 transform group-hover:rotate-12">
                        <span class="material-symbols-rounded text-[160px] text-blue-400">coffee_maker</span>
                    </div>
                    <div class="relative z-10">
                        <p class="text-xs font-bold text-blue-400 uppercase tracking-widest mb-1">Gudang A</p>
                        <h2 class="text-3xl font-black text-white mb-4">ROBUSTA</h2>
                        <div class="flex items-baseline gap-2">
                            <span class="text-7xl font-black text-white tracking-tighter">{{ number_format($stokRobusta, 0, ',', '.') }}</span>
                            <span class="text-2xl font-bold text-white/40">Kg</span>
                        </div>
                        <div class="mt-6 flex gap-2">
                            <span class="px-3 py-1 bg-blue-500/10 text-blue-400 text-[10px] font-bold rounded-lg border border-blue-500/20">VERIFIED ONLY</span>
                        </div>
                    </div>
                </div>

                @php $stokArabica = $stocks->where('coffee_type', 'Arabica')->first()->total_weight_kg ?? 0; @endphp
                <div class="glass-card p-8 rounded-3xl relative overflow-hidden group hover:bg-white/5 transition duration-300 border-l-4 border-l-emerald-500">
                    <div class="absolute -right-6 -top-6 p-3 opacity-10 group-hover:opacity-20 transition duration-500 transform group-hover:rotate-12">
                        <span class="material-symbols-rounded text-[160px] text-emerald-400">local_cafe</span>
                    </div>
                    <div class="relative z-10">
                        <p class="text-xs font-bold text-emerald-400 uppercase tracking-widest mb-1">Gudang B</p>
                        <h2 class="text-3xl font-black text-white mb-4">ARABICA</h2>
                        <div class="flex items-baseline gap-2">
                            <span class="text-7xl font-black text-white tracking-tighter">{{ number_format($stokArabica, 0, ',', '.') }}</span>
                            <span class="text-2xl font-bold text-white/40">Kg</span>
                        </div>
                        <div class="mt-6 flex gap-2">
                            <span class="px-3 py-1 bg-emerald-500/10 text-emerald-400 text-[10px] font-bold rounded-lg border border-emerald-500/20">PREMIUM</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="glass-card rounded-2xl overflow-hidden">
                <div class="px-6 py-5 border-b border-white/5 flex justify-between items-center bg-white/5">
                    <h3 class="font-bold text-white flex items-center gap-2">
                        <span class="material-symbols-rounded text-primary">history</span> Riwayat Barang Masuk
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-black/20 text-white/40 font-bold uppercase text-[10px]">
                            <tr>
                                <th class="p-4">Tanggal</th>
                                <th class="p-4">Petani</th>
                                <th class="p-4">Jenis</th>
                                <th class="p-4 text-right">Jumlah</th>
                                <th class="p-4 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5 text-white/80">
                            @forelse($mutations as $m)
                            <tr class="hover:bg-white/5 transition">
                                <td class="p-4 text-white/50 font-mono">{{ \Carbon\Carbon::parse($m->verified_at)->format('d/m/Y H:i') }}</td>
                                <td class="p-4 font-bold text-white">{{ $m->user->name }}</td>
                                <td class="p-4">
                                    <span class="px-2 py-1 rounded text-[10px] font-bold border {{ $m->coffee_variant == 'Robusta' ? 'bg-blue-500/10 text-blue-400 border-blue-500/20' : 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' }}">
                                        {{ $m->coffee_variant }}
                                    </span>
                                </td>
                                <td class="p-4 text-right font-mono font-bold text-primary">+{{ number_format($m->weight_verified) }} Kg</td>
                                <td class="p-4 text-center">
                                    <span class="text-[10px] font-bold px-2 py-1 rounded-full bg-green-500/20 text-green-400 border border-green-500/20">SUKSES</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-white/30 italic">Belum ada barang masuk.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
</body>
</html>