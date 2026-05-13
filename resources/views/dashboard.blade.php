<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - ResiGudang</title>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { background-color: #10221f; font-family: 'Inter', sans-serif; }
        .glass-card {
            background: rgba(22, 46, 38, 0.5);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
        }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #10221f; }
        ::-webkit-scrollbar-thumb { background: #162e26; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #13ec37; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="text-white h-screen flex overflow-hidden">

    <aside class="w-64 flex flex-col border-r border-white/5 bg-[#112214]/50 backdrop-blur-xl relative z-20 shrink-0">
        <div class="p-6 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary/80 to-primary/20 flex items-center justify-center shadow-lg shadow-primary/20">
                <span class="material-symbols-rounded text-black font-bold text-xl">warehouse</span>
            </div>
            <div>
                <h1 class="text-lg font-bold tracking-tight leading-tight">ResiGudang</h1>
                <p class="text-xs text-white/40 font-medium">Farmer Panel</p>
            </div>
        </div>

        <nav class="flex-1 px-4 py-4 space-y-2 overflow-y-auto">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-primary/10 text-primary border border-primary/20 shadow-[0_0_15px_rgba(19,236,55,0.1)] transition-all">
                <span class="material-symbols-rounded">dashboard</span>
                <span class="text-sm font-bold">Dashboard</span>
            </a>
            
            <a href="{{ route('setoran.history') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/60 hover:bg-white/5 hover:text-white transition-all group">
                <span class="material-symbols-rounded group-hover:scale-110 transition-transform">history</span>
                <span class="text-sm font-medium">History</span>
            </a>
            
            <a href="{{ route('petani.inventory.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/60 hover:bg-white/5 hover:text-white transition-all group">
                <span class="material-symbols-rounded group-hover:scale-110 transition-transform">receipt_long</span>
                <span class="text-sm font-medium">Transactions</span>
            </a>
        </nav>

        <div class="p-4 border-t border-white/5 relative">
            <button onclick="toggleProfileMenu()" class="w-full flex items-center gap-3 p-3 rounded-xl bg-white/5 border border-white/5 hover:bg-white/10 transition-colors cursor-pointer text-left">
                <div class="w-9 h-9 rounded-full bg-primary flex items-center justify-center text-dark font-bold text-sm">
                    {{ substr(Auth::user()->name, 0, 2) }}
                </div>
                <div class="flex-1 overflow-hidden">
                    <p class="text-sm font-bold truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-primary uppercase tracking-wider">Farmer</p>
                </div>
                <span class="material-symbols-rounded text-white/50">expand_less</span>
            </button>

            <div id="profile-menu" class="hidden absolute bottom-20 left-4 right-4 bg-[#162e26] border border-white/10 rounded-xl shadow-xl overflow-hidden backdrop-blur-md z-50">
                <div class="px-4 py-3 border-b border-white/5">
                    <p class="text-xs text-white/50">Signed in as</p>
                    <p class="text-sm font-bold text-white truncate">{{ Auth::user()->email }}</p>
                </div>
                <a href="{{ route('profile.edit') }}" class="block w-full text-left px-4 py-3 text-sm text-white/70 hover:bg-white/5 hover:text-white transition-colors flex items-center gap-2 border-b border-white/5">
                    <span class="material-symbols-rounded text-base">settings</span> Edit Profile & Bank
                </a>
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
        <div class="absolute top-[-20%] right-[-10%] w-[600px] h-[600px] bg-primary/5 rounded-full blur-[120px] pointer-events-none"></div>

        <header class="h-20 px-8 flex items-center justify-between border-b border-white/5 bg-dark/80 backdrop-blur-md z-10 shrink-0">
            <div>
                <h2 class="text-2xl font-bold tracking-tight">Overview</h2>
                <p class="text-white/40 text-xs">Welcome back, checking your latest crops?</p>
            </div>
            
            <div class="relative">
                <button onclick="toggleNotifMenu()" class="w-10 h-10 rounded-xl bg-surface border border-white/10 flex items-center justify-center text-white/60 hover:text-white hover:border-white/30 transition-all relative">
                    <span class="material-symbols-rounded">notifications</span>
                    @if($histories->count() > 0)
                    <span class="absolute top-2 right-2 w-2 h-2 rounded-full bg-red-500 border border-dark"></span>
                    @endif
                </button>

                <div id="notif-menu" class="hidden absolute right-0 mt-4 w-80 bg-[#162e26] border border-white/10 rounded-2xl shadow-2xl overflow-hidden backdrop-blur-xl z-50 origin-top-right transition-all">
                    <div class="px-5 py-4 border-b border-white/5 flex justify-between items-center bg-black/20">
                        <h3 class="font-bold text-sm">Notifications</h3>
                        <span class="text-[10px] bg-white/10 px-2 py-1 rounded-full text-white/60">{{ $histories->count() }} New</span>
                    </div>
                    
                    <div class="max-h-[300px] overflow-y-auto no-scrollbar">
                        @forelse($histories->take(7) as $item)
                        <div class="p-4 border-b border-white/5 hover:bg-white/5 transition-colors cursor-pointer flex gap-3">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 
                                {{ $item->status == 'VERIFIED' ? 'bg-primary/20 text-primary' : 
                                  ($item->status == 'REJECTED' ? 'bg-red-500/20 text-red-500' : 'bg-orange-500/20 text-orange-500') }}">
                                <span class="material-symbols-rounded text-sm">
                                    {{ $item->status == 'VERIFIED' ? 'check' : ($item->status == 'REJECTED' ? 'close' : 'hourglass_top') }}
                                </span>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-white mb-0.5">
                                    {{ $item->status == 'VERIFIED' ? 'Deposit Accepted!' : 
                                      ($item->status == 'REJECTED' ? 'Deposit Rejected' : 'Processing Deposit') }}
                                </p>
                                <p class="text-[10px] text-white/50 leading-tight">
                                    Deposit <b>{{ $item->coffee_variant }}</b> (<b>{{ $item->weight_kg }} Kg</b>) 
                                    {{ $item->status == 'VERIFIED' ? 'has entered the warehouse.' : 'is being reviewed.' }}
                                </p>
                                <p class="text-[9px] text-white/30 mt-1">{{ $item->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @empty
                        <div class="p-8 text-center text-white/30">
                            <span class="material-symbols-rounded text-3xl mb-2">notifications_off</span>
                            <p class="text-xs">No notifications</p>
                        </div>
                        @endforelse
                    </div>
                    <a href="{{ route('setoran.history') }}" class="block p-3 text-center text-xs font-bold text-primary hover:bg-white/5 transition-colors">
                        View All History
                    </a>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8 space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="glass-card p-6 rounded-2xl relative overflow-hidden group">
                    <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <span class="material-symbols-rounded text-6xl text-primary">check_circle</span>
                    </div>
                    <p class="text-white/50 text-xs font-bold uppercase tracking-wider mb-2">Total Accepted</p>
                    <div class="flex items-end gap-1">
                        <span class="text-3xl font-black">{{ number_format($total_setoran ?? 0, 0, ',', '.') }}</span>
                        <span class="text-sm font-bold text-primary mb-1">Kg</span>
                    </div>
                </div>
                <div class="glass-card p-6 rounded-2xl relative overflow-hidden group">
                    <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <span class="material-symbols-rounded text-6xl text-orange-400">hourglass_top</span>
                    </div>
                    <p class="text-white/50 text-xs font-bold uppercase tracking-wider mb-2">Pending</p>
                    <div class="flex items-end gap-1">
                        <span class="text-3xl font-black text-orange-400">{{ $total_pending ?? 0 }}</span>
                        <span class="text-sm text-white/50 mb-1">deposits</span>
                    </div>
                </div>
                <div class="glass-card p-6 rounded-2xl relative overflow-hidden group">
                    <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <span class="material-symbols-rounded text-6xl text-red-500">cancel</span>
                    </div>
                    <p class="text-white/50 text-xs font-bold uppercase tracking-wider mb-2">Rejected</p>
                    <div class="flex items-end gap-1">
                        <span class="text-3xl font-black text-red-500">{{ $total_ditolak ?? 0 }}</span>
                        <span class="text-sm text-white/50 mb-1">deposits</span>
                    </div>
                </div>
                <div class="glass-card p-6 rounded-2xl relative overflow-hidden bg-gradient-to-br from-primary/20 to-transparent border-primary/30">
                    <div class="absolute right-0 top-0 p-4 opacity-20">
                        <span class="material-symbols-rounded text-6xl text-white">payments</span>
                    </div>
                    <p class="text-primary text-xs font-bold uppercase tracking-wider mb-2">Est. Payment</p>
                    <div class="flex items-end gap-1">
                        <span class="text-sm font-bold text-primary mb-1">Rp</span>
                        <span class="text-2xl font-black text-white truncate">
                            {{ number_format($total_uang ?? 0, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 glass-card p-6 rounded-2xl">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-lg">Deposit Trend</h3>
                        <span class="text-xs text-primary bg-primary/10 px-2 py-1 rounded">Last 7 Days</span>
                    </div>
                    <div class="h-64">
                        <canvas id="depositChart"></canvas>
                    </div>
                </div>

                <div class="glass-card p-6 rounded-2xl flex flex-col">
                    <h3 class="font-bold text-lg mb-4 flex items-center gap-2">
                        <span class="material-symbols-rounded text-primary">payments</span>
                        Market Price (Per Kg)
                    </h3>
                    
                    <div class="space-y-4 overflow-y-auto h-80 no-scrollbar pr-1">
                        
                        <div class="p-4 rounded-xl bg-black/20 border border-white/5">
                            <div class="flex items-center gap-3 mb-3 border-b border-white/5 pb-2">
                                <div class="w-8 h-8 rounded bg-orange-500/20 flex items-center justify-center text-orange-500 font-bold text-[10px]">RB</div>
                                <div><p class="text-sm font-bold text-orange-400">ROBUSTA</p></div>
                            </div>
                            
                            <div class="space-y-2">
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-white/60">Grade A (Premium)</span>
                                    <span class="font-mono font-bold text-primary text-sm">Rp {{ isset($prices['Robusta']['A']) ? number_format($prices['Robusta']['A'], 0, ',', '.') : 0 }}</span>
                                </div>
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-white/60">Grade B (Standard)</span>
                                    <span class="font-mono font-bold text-yellow-400 text-sm">Rp {{ isset($prices['Robusta']['B']) ? number_format($prices['Robusta']['B'], 0, ',', '.') : 0 }}</span>
                                </div>
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-white/60">Grade C (Low)</span>
                                    <span class="font-mono font-bold text-red-400 text-sm">Rp {{ isset($prices['Robusta']['C']) ? number_format($prices['Robusta']['C'], 0, ',', '.') : 0 }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 rounded-xl bg-black/20 border border-white/5">
                            <div class="flex items-center gap-3 mb-3 border-b border-white/5 pb-2">
                                <div class="w-8 h-8 rounded bg-primary/20 flex items-center justify-center text-primary font-bold text-[10px]">AR</div>
                                <div><p class="text-sm font-bold text-primary">ARABICA</p></div>
                            </div>
                            
                            <div class="space-y-2">
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-white/60">Grade A (Premium)</span>
                                    <span class="font-mono font-bold text-primary text-sm">Rp {{ isset($prices['Arabica']['A']) ? number_format($prices['Arabica']['A'], 0, ',', '.') : 0 }}</span>
                                </div>
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-white/60">Grade B (Standard)</span>
                                    <span class="font-mono font-bold text-yellow-400 text-sm">Rp {{ isset($prices['Arabica']['B']) ? number_format($prices['Arabica']['B'], 0, ',', '.') : 0 }}</span>
                                </div>
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-white/60">Grade C (Low)</span>
                                    <span class="font-mono font-bold text-red-400 text-sm">Rp {{ isset($prices['Arabica']['C']) ? number_format($prices['Arabica']['C'], 0, ',', '.') : 0 }}</span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="mt-auto pt-4">
                        <p class="text-[10px] text-white/30 text-center italic">
                            *Final price is determined after quality check (Grade) by the Admin.
                        </p>
                    </div>
                </div>
            </div>

            <div class="glass-card rounded-2xl overflow-hidden">
                <div class="px-6 py-5 border-b border-white/5 flex justify-between items-center">
                    <h3 class="font-bold">Latest Deposits</h3>
                    <a href="{{ route('setoran.history') }}" class="text-xs text-primary hover:underline">View All</a>
                </div>
                <table class="w-full text-left text-sm">
                    <thead class="text-xs uppercase text-white/40 bg-black/20">
                        <tr>
                            <th class="px-6 py-3">Date</th>
                            <th class="px-6 py-3">Coffee</th>
                            <th class="px-6 py-3 text-right">Weight</th>
                            <th class="px-6 py-3 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($histories->take(5) as $item)
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4 text-white/60">{{ $item->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 font-bold">{{ $item->coffee_variant }}</td>
                            <td class="px-6 py-4 text-right font-mono">{{ number_format($item->weight_kg, 0) }} Kg</td>
                            <td class="px-6 py-4 text-right">
                                <span class="px-2 py-1 rounded text-[10px] font-bold 
                                    {{ $item->status == 'VERIFIED' ? 'bg-primary/10 text-primary' : 
                                      ($item->status == 'REJECTED' ? 'bg-red-500/10 text-red-500' : 'bg-orange-500/10 text-orange-500') }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-white/30">No activity yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </main>

    @if(session('success'))
    <div id="toast-success" class="fixed top-5 right-5 flex items-center gap-3 bg-[#162e26]/90 backdrop-blur-md border border-primary/30 p-4 rounded-xl shadow-[0_0_30px_rgba(19,236,55,0.2)] transform transition-all duration-500 translate-x-full z-[100]">
        <div class="w-8 h-8 rounded-full bg-primary/20 flex items-center justify-center text-primary">
            <span class="material-symbols-rounded text-xl">check</span>
        </div>
        <div>
            <h4 class="text-primary font-bold text-sm">Success!</h4>
            <p class="text-white/80 text-xs">{{ session('success') }}</p>
        </div>
        <button onclick="closeToast()" class="ml-4 text-white/40 hover:text-white">
            <span class="material-symbols-rounded text-lg">close</span>
        </button>
    </div>
    @endif

    <script id="chart-data-labels" type="application/json"> {!! json_encode($chartLabels ?? []) !!} </script>
    <script id="chart-data-values" type="application/json"> {!! json_encode($chartData ?? []) !!} </script>

    <script>
        function toggleProfileMenu() {
            document.getElementById('profile-menu').classList.toggle('hidden');
            document.getElementById('notif-menu').classList.add('hidden');
        }

        function toggleNotifMenu() {
            document.getElementById('notif-menu').classList.toggle('hidden');
            document.getElementById('profile-menu').classList.add('hidden');
        }

        window.onclick = function(event) {
            if (!event.target.closest('button')) {
                document.getElementById('profile-menu').classList.add('hidden');
                document.getElementById('notif-menu').classList.add('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const toast = document.getElementById('toast-success');
            if(toast) {
                setTimeout(() => toast.classList.remove('translate-x-full'), 100);
                setTimeout(() => closeToast(), 4000);
            }

            const labelEl = document.getElementById('chart-data-labels');
            const dataEl = document.getElementById('chart-data-values');
            const dbLabels = labelEl ? JSON.parse(labelEl.textContent) : [];
            const dbData = dataEl ? JSON.parse(dataEl.textContent) : [];

            const ctx = document.getElementById('depositChart').getContext('2d');
            let gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(19, 236, 55, 0.5)');
            gradient.addColorStop(1, 'rgba(19, 236, 55, 0.0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dbLabels.length > 0 ? dbLabels : ['No Data'], 
                    datasets: [{
                        label: 'Deposit Weight (Kg)',
                        data: dbData.length > 0 ? dbData : [0],
                        borderColor: '#13ec37',
                        backgroundColor: gradient,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#10221f',
                        pointBorderColor: '#13ec37',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    interaction: { intersect: false, mode: 'index' },
                    scales: {
                        y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#888' } },
                        x: { grid: { display: false }, ticks: { color: '#888' } }
                    }
                }
            });
            
        });

        function closeToast() {
            const toast = document.getElementById('toast-success');
            if(toast) {
                toast.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => toast.remove(), 500);
            }
        }
    </script>
</body>
</html>