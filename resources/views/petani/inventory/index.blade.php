<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Stok Saya - ResiGudang</title>
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
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-500 to-emerald-700 flex items-center justify-center shadow-lg shadow-green-500/20">
                <span class="material-symbols-rounded text-white font-bold text-xl">potted_plant</span>
            </div>
            <div>
                <h1 class="text-lg font-bold tracking-tight leading-tight">ResiGudang</h1>
                <p class="text-xs text-white/40 font-medium">Panel Petani</p>
            </div>
        </div>
        <nav class="flex-1 px-4 py-4 space-y-2 overflow-y-auto">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/60 hover:bg-white/5 hover:text-white transition-all group">
                <span class="material-symbols-rounded group-hover:scale-110 transition-transform">dashboard</span>
                <span class="text-sm font-medium">Dashboard</span>
            </a>
            <a href="{{ route('setoran.history') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/60 hover:bg-white/5 hover:text-white transition-all group">
                <span class="material-symbols-rounded group-hover:scale-110 transition-transform">history</span>
                <span class="text-sm font-medium">History</span>
            </a>
            <a href="{{ route('petani.inventory.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-primary/10 text-primary border border-primary/20 shadow-[0_0_15px_rgba(19,236,55,0.1)] transition-all">
                <span class="material-symbols-rounded">inventory_2</span>
                <span class="text-sm font-bold">Stok Saya</span>
            </a>
        </nav>
        
        <div class="p-4 border-t border-white/5">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 p-3 rounded-xl bg-white/5 border border-white/5 hover:bg-red-500/10 hover:border-red-500/20 hover:text-red-400 transition-all text-left">
                    <span class="material-symbols-rounded text-white/50">logout</span>
                    <span class="text-sm font-bold text-white/70">Keluar Sistem</span>
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col relative h-full overflow-hidden w-full bg-[#10221f]">
        
        <header class="h-20 px-8 flex items-center justify-between border-b border-white/5 bg-dark/80 backdrop-blur-md z-10 shrink-0">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-white">Stok Saya di Gudang</h2>
                <p class="text-white/40 text-xs">Informasi berat kopi yang belum dijual/dilunasi.</p>
            </div>
            <div class="bg-primary/10 text-primary px-4 py-2 rounded-xl font-bold border border-primary/20 flex items-center gap-2 shadow-[0_0_15px_rgba(19,236,55,0.1)]">
                <span class="material-symbols-rounded text-sm">info</span>
                <span class="text-xs uppercase tracking-wider">Status Gudang: Aktif</span>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8 space-y-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                @php 
                    // Kita hitung stok punya petani yang statusnya PARTIAL_PAID (Sudah DP tapi barang masih di gudang)
                    $myStokRobusta = $mutations->where('coffee_variant', 'Robusta')->whereIn('status', ['PARTIAL_PAID', 'REQUEST_FINAL'])->sum('weight_verified'); 
                @endphp
                <div class="glass-card p-8 rounded-3xl relative overflow-hidden group hover:bg-white/5 transition duration-300 border-l-4 border-l-blue-500">
                    <div class="absolute -right-6 -top-6 p-3 opacity-10 group-hover:opacity-20 transition duration-500 transform group-hover:rotate-12">
                        <span class="material-symbols-rounded text-[160px] text-blue-400">coffee_maker</span>
                    </div>
                    <div class="relative z-10">
                        <p class="text-xs font-bold text-blue-400 uppercase tracking-widest mb-1">Varian Kopi</p>
                        <h2 class="text-3xl font-black text-white mb-4">ROBUSTA</h2>
                        <div class="flex items-baseline gap-2">
                            <span class="text-7xl font-black text-white tracking-tighter">{{ number_format($myStokRobusta, 0, ',', '.') }}</span>
                            <span class="text-2xl font-bold text-white/40">Kg</span>
                        </div>
                        <p class="mt-4 text-[10px] text-white/30 italic">*Hanya menampilkan stok yang belum dilunasi total.</p>
                    </div>
                </div>

                @php 
                    $myStokArabica = $mutations->where('coffee_variant', 'Arabica')->whereIn('status', ['PARTIAL_PAID', 'REQUEST_FINAL'])->sum('weight_verified'); 
                @endphp
                <div class="glass-card p-8 rounded-3xl relative overflow-hidden group hover:bg-white/5 transition duration-300 border-l-4 border-l-emerald-500">
                    <div class="absolute -right-6 -top-6 p-3 opacity-10 group-hover:opacity-20 transition duration-500 transform group-hover:rotate-12">
                        <span class="material-symbols-rounded text-[160px] text-emerald-400">local_cafe</span>
                    </div>
                    <div class="relative z-10">
                        <p class="text-xs font-bold text-emerald-400 uppercase tracking-widest mb-1">Varian Kopi</p>
                        <h2 class="text-3xl font-black text-white mb-4">ARABICA</h2>
                        <div class="flex items-baseline gap-2">
                            <span class="text-7xl font-black text-white tracking-tighter">{{ number_format($myStokArabica, 0, ',', '.') }}</span>
                            <span class="text-2xl font-bold text-white/40">Kg</span>
                        </div>
                        <p class="mt-4 text-[10px] text-white/30 italic">*Data sinkron dengan hasil timbangan Admin.</p>
                    </div>
                </div>
            </div>

            <div class="glass-card rounded-2xl overflow-hidden">
                <div class="px-6 py-5 border-b border-white/5 flex justify-between items-center bg-white/5">
                    <h3 class="font-bold text-white flex items-center gap-2">
                        <span class="material-symbols-rounded text-primary">history</span> Riwayat Barang Masuk Saya
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-black/20 text-white/40 font-bold uppercase text-[10px]">
                            <tr>
                                <th class="p-4">Tanggal Masuk</th>
                                <th class="p-4">Jenis Kopi</th>
                                <th class="p-4 text-right">Berat Verified</th>
                                <th class="p-4 text-center">Status Barang</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5 text-white/80">
                            @forelse($mutations as $m)
                            <tr class="hover:bg-white/5 transition">
                                <td class="p-4 text-white/50 font-mono">{{ \Carbon\Carbon::parse($m->verified_at)->format('d/m/Y H:i') }}</td>
                                <td class="p-4">
                                    <span class="px-2 py-1 rounded text-[10px] font-bold border {{ $m->coffee_variant == 'Robusta' ? 'bg-blue-500/10 text-blue-400 border-blue-500/20' : 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' }}">
                                        {{ $m->coffee_variant }}
                                    </span>
                                </td>
                                <td class="p-4 text-right font-mono font-bold text-primary">+{{ number_format($m->weight_verified) }} Kg</td>
                                <td class="p-4 text-center">
                                    @if($m->status == 'PAID_OFF')
                                        <span class="text-[10px] font-bold px-2 py-1 rounded-full bg-blue-500/20 text-blue-400 border border-blue-500/20">SUDAH TERJUAL</span>
                                    @else
                                        <span class="text-[10px] font-bold px-2 py-1 rounded-full bg-green-500/20 text-green-400 border border-green-500/20">DI GUDANG</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="p-8 text-center text-white/30 italic">Anda belum memiliki stok barang di gudang.</td>
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