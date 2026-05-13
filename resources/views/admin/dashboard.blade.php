<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - ResiGudang</title>
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
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #10221f; }
        ::-webkit-scrollbar-thumb { background: #13ec37; border-radius: 10px; }
    </style>
</head>
<body class="text-white h-screen flex overflow-hidden">

    <aside class="w-64 flex flex-col border-r border-white/5 bg-[#112214]/50 backdrop-blur-xl relative z-20 shrink-0">
        <div class="p-6 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center shadow-lg">
                <span class="material-symbols-rounded text-white font-bold text-xl">admin_panel_settings</span>
            </div>
            <div>
                <h1 class="text-lg font-bold tracking-tight">ResiGudang</h1>
                <p class="text-xs text-white/40 font-medium">Admin Unit</p>
            </div>
        </div>

        <nav class="flex-1 px-4 py-4 space-y-2">
            <a href="{{ route('koperasi.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-primary/10 text-primary border border-primary/20 shadow-[0_0_15px_rgba(19,236,55,0.1)] transition-all">
                <span class="material-symbols-rounded">dashboard</span>
                <span class="text-sm font-bold">Dashboard</span>
            </a>
            
            <a href="{{ route('koperasi.deposits.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/60 hover:bg-white/5 hover:text-white transition-all">
                <span class="material-symbols-rounded">add_circle</span>
                <span class="text-sm font-medium">Setor kopi</span>
            </a>

            <a href="{{ route('koperasi.inventory.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/60 hover:bg-white/5 hover:text-white transition-all">
                <span class="material-symbols-rounded">inventory_2</span>
                <span class="text-sm font-medium">Stok Gudang</span>
            </a>
            <a href="{{ route('koperasi.history') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/60 hover:bg-white/5 hover:text-white transition-all">
                <span class="material-symbols-rounded">receipt_long</span>
                <span class="text-sm font-medium">Riwayat</span>
            </a>
        </nav>

        <div class="p-4 border-t border-white/5 relative">
            <button onclick="toggleProfileMenu()" class="w-full flex items-center gap-3 p-3 rounded-xl bg-white/5 border border-white/5 hover:bg-white/10 transition-colors cursor-pointer text-left group">
                <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-blue-500 to-cyan-400 flex items-center justify-center text-white font-bold text-sm shadow-lg shadow-blue-500/20 group-hover:scale-110 transition-transform">
                    {{ substr(Auth::user()->name ?? 'AD', 0, 2) }}
                </div>
                <div class="flex-1 overflow-hidden">
                    <p class="text-sm font-bold text-white truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                    <p class="text-[10px] text-white/40 group-hover:text-white/60 transition-colors">Admin Unit</p>
                </div>
                <span class="material-symbols-rounded text-white/30 group-hover:text-white transition-colors">expand_less</span>
            </button>
            <div id="profile-menu" class="hidden absolute bottom-20 left-4 right-4 bg-[#162e26] border border-white/10 rounded-xl shadow-2xl overflow-hidden backdrop-blur-xl z-50 origin-bottom transition-all">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-3 text-sm text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-colors flex items-center gap-2 font-bold">
                        <span class="material-symbols-rounded text-lg">logout</span> Log Out
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <main class="flex-1 flex flex-col relative h-full overflow-hidden bg-[#10221f]">
        <header class="h-20 px-8 flex items-center justify-between border-b border-white/5 bg-dark/80 backdrop-blur-md z-10 shrink-0">
            <h2 class="text-2xl font-bold text-white">Admin Dashboard</h2>
            <div class="px-3 py-1 bg-primary/10 border border-primary/20 text-primary text-xs font-bold rounded-full animate-pulse">System Online</div>
        </header>

        <div class="flex-1 overflow-y-auto p-8 space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                <div class="glass-card p-6 rounded-2xl">
                    <p class="text-white/50 text-xs font-bold uppercase mb-2">Pending</p>
                    <p class="text-3xl font-black text-amber-500">{{ $total_pending ?? 0 }}</p>
                </div>
                <div class="glass-card p-6 rounded-2xl">
                    <p class="text-white/50 text-xs font-bold uppercase mb-2">Total Stok</p>
                    <p class="text-3xl font-black text-white">{{ number_format($total_weight ?? 0) }} Kg</p>
                </div>
                <div class="glass-card p-6 rounded-2xl">
                    <p class="text-white/50 text-xs font-bold uppercase mb-2">Total Uang Keluar</p>
                    <p class="text-2xl font-black text-primary">Rp {{ number_format(($total_money ?? 0)/1000000, 1) }} Jt</p>
                </div>
                <div class="glass-card p-6 rounded-2xl">
                    <p class="text-white/50 text-xs font-bold uppercase mb-2">Petani</p>
                    <p class="text-3xl font-black text-purple-500">{{ $total_farmers ?? 0 }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <div class="lg:col-span-2 space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                            <span class="material-symbols-rounded text-primary">today</span> Transaksi Hari Ini
                        </h3>
                        
                        <div class="flex items-center gap-3">
                            <a href="{{ route('koperasi.history') }}" class="text-xs text-white/40 hover:text-white transition-colors">Lihat Semua →</a>
                            <a href="{{ route('koperasi.deposits.create') }}" class="bg-primary hover:bg-[#0fd630] text-dark px-4 py-2 rounded-xl text-xs font-bold shadow-[0_0_15px_rgba(19,236,55,0.3)] transition-all flex items-center gap-1">
                                <span class="material-symbols-rounded text-sm">add</span> Catat Setoran
                            </a>
                        </div>
                    </div>

                    <div class="glass-card rounded-2xl overflow-hidden min-h-[400px]">
                        <table class="w-full text-left text-sm text-white/80">
                            <thead class="bg-black/20 text-white/40 font-bold uppercase text-[10px]">
                                <tr>
                                    <th class="px-6 py-4">Petani & Kopi</th>
                                    <th class="px-6 py-4 text-center">Berat Awal</th>
                                    <th class="px-6 py-4 text-center">Status</th>
                                    <th class="px-6 py-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @forelse($deposits as $d)
                                <tr class="hover:bg-white/5 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold text-xs">
                                                {{ substr($d->user->name ?? '?', 0, 2) }}
                                            </div>
                                            <div>
                                                <p class="font-bold text-white">{{ $d->user->name ?? '-' }}</p>
                                                <div class="flex items-center gap-2">
                                                    <span class="text-[10px] px-1.5 py-0.5 rounded bg-white/10 border border-white/5 text-white/60">
                                                        {{ $d->coffee_variant }}
                                                    </span>
                                                    <span class="text-[10px] px-1.5 py-0.5 rounded bg-white/5 text-white/40 italic">
                                                        Grade {{ $d->grade ?? '?' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center font-mono font-bold">
                                        {{ number_format($d->weight_input) }} Kg
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-2 py-1 rounded text-[10px] font-bold 
                                            @if($d->status == 'PENDING') bg-amber-500/20 text-amber-500 
                                            @elseif($d->status == 'REQUEST_FINAL') bg-purple-500/20 text-purple-400 animate-pulse
                                            @elseif($d->status == 'PAID_OFF') bg-primary/20 text-primary
                                            @else bg-red-500/20 text-red-500 @endif">
                                            {{ str_replace('_', ' ', $d->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right flex justify-end gap-2">
                                        @php
                                            $finalGrade = $d->grade ?? 'A';
                                            $basePrice = $d->price_base_dp ?? 0;
                                        @endphp

                                        @if($d->status == 'PENDING')
                                            <form action="{{ route('koperasi.deposits.reject', $d->id) }}" method="POST" class="inline-block" onsubmit="return tolakSetoran(this, 'Masukkan alasan penolakan kopi ini:')">
                                                @csrf
                                                <input type="hidden" name="note" value="">
                                                <button type="submit" class="bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white px-3 py-1.5 rounded-lg font-bold text-xs transition-all" title="Tolak">
                                                    <span class="material-symbols-rounded text-sm">close</span>
                                                </button>
                                            </form>
                                            
                                            <button onclick="openVerifyModal('{{ $d->id }}', '{{ $d->weight_input }}', '{{ $d->dp_percentage }}', '{{ $d->coffee_variant }}', '{{ $finalGrade }}', '{{ $basePrice }}')" 
                                                class="bg-primary text-dark px-3 py-1.5 rounded-lg font-bold text-xs hover:bg-green-400 shadow-lg shadow-green-500/20 transition-all">
                                                Verifikasi DP
                                            </button>
                                        @elseif($d->status == 'REQUEST_FINAL')
                                            <form action="{{ route('koperasi.deposits.reject', $d->id) }}" method="POST" class="inline-block" onsubmit="return tolakSetoran(this, 'Masukkan alasan pembatalan:')">
                                                @csrf
                                                <input type="hidden" name="note" value="">
                                                <button type="submit" class="bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white px-3 py-1.5 rounded-lg font-bold text-xs transition-all" title="Batalkan">
                                                    <span class="material-symbols-rounded text-sm">close</span>
                                                </button>
                                            </form>
                                            
                                            <button onclick="openFinalModal('{{ $d->id }}', '{{ $d->weight_verified }}', '{{ $d->total_dp_amount }}', '{{ $d->coffee_variant }}', '{{ $d->grade }}')" 
                                                class="bg-purple-500 text-white px-3 py-1.5 rounded-lg font-bold text-xs hover:bg-purple-600 shadow-lg shadow-purple-500/20 transition-all">
                                                Proses Lunas
                                            </button>
                                        @elseif($d->status == 'PAID_OFF')
                                            <span class="text-primary text-xs font-bold flex items-center justify-end gap-1">
                                                <span class="material-symbols-rounded text-sm">check_circle</span> Selesai
                                            </span>
                                        @else
                                            <span class="text-white/30 text-xs italic">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-white/30 italic">
                                        Tidak ada setoran masuk hari ini.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="glass-card p-6 rounded-2xl relative overflow-hidden h-fit">
                        <div class="absolute right-[-20px] top-[-20px] opacity-5 pointer-events-none">
                            <span class="material-symbols-rounded text-9xl text-primary">request_quote</span>
                        </div>
                        
                        <h3 class="text-sm font-bold text-white/70 uppercase tracking-wider mb-6 flex justify-between items-center relative z-10">
                            HARGA PASAR (HARI INI)
                            <span class="material-symbols-rounded text-primary text-xl bg-primary/10 p-2 rounded-full">payments</span>
                        </h3>

                        <div class="space-y-6 relative z-10">
                            
                            <div>
                                <h4 class="text-orange-500 font-bold mb-3 flex items-center gap-2 text-sm bg-orange-500/10 w-fit px-3 py-1 rounded-lg">
                                    <span class="material-symbols-rounded text-base">emoji_food_beverage</span> Robusta
                                </h4>
                                <div class="space-y-2 pl-1">
                                    @forelse($robustaPrices as $p)
                                        <div class="flex justify-between items-center border-b border-white/5 pb-2">
                                            <span class="text-xs text-white/60 font-medium">Grade {{ $p->grade }}</span>
                                            <span class="text-sm font-bold text-white">Rp {{ number_format($p->price, 0, ',', '.') }}</span>
                                        </div>
                                    @empty
                                        <p class="text-xs text-white/40 italic">Belum ada data harga dari pusat.</p>
                                    @endforelse
                                </div>
                            </div>

                            <div>
                                <h4 class="text-primary font-bold mb-3 flex items-center gap-2 text-sm bg-primary/10 w-fit px-3 py-1 rounded-lg">
                                    <span class="material-symbols-rounded text-base">eco</span> Arabica
                                </h4>
                                <div class="space-y-2 pl-1">
                                    @forelse($arabicaPrices as $p)
                                        <div class="flex justify-between items-center border-b border-white/5 pb-2">
                                            <span class="text-xs text-white/60 font-medium">Grade {{ $p->grade }}</span>
                                            <span class="text-sm font-bold text-white">Rp {{ number_format($p->price, 0, ',', '.') }}</span>
                                        </div>
                                    @empty
                                        <p class="text-xs text-white/40 italic">Belum ada data harga dari pusat.</p>
                                    @endforelse
                                </div>
                            </div>

                        </div>

                        <p class="text-[10px] text-white/30 italic text-center mt-6 relative z-10">*Harga dari pusat PT. ResiGudang.</p>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <div id="verifyModal" class="hidden fixed inset-0 bg-black/80 z-50 flex items-center justify-center backdrop-blur-sm p-4">
        <div class="bg-[#162e26] border border-white/10 rounded-2xl p-6 w-full max-w-md shadow-2xl">
            <h3 class="text-xl font-bold text-white mb-4">Verifikasi Kualitas & Berat</h3>
            <form id="verifyForm" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="bg-black/20 p-4 rounded-xl mb-4 text-sm border border-white/5 space-y-2">
                    <div class="flex justify-between"><span class="text-white/60">Berat Awal:</span> <span class="text-white font-bold" id="modalEstWeight">0 Kg</span></div>
                    <div class="flex justify-between"><span class="text-white/60">Grade Awal:</span> <span class="text-yellow-400 font-bold" id="modalEstGrade">-</span></div>
                    <div class="flex justify-between"><span class="text-white/60">DP Request:</span> <span class="text-orange-400 font-bold" id="modalDP">0%</span></div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-bold text-white/60 mb-1 uppercase">Berat Real (Kg)</label>
                        <input type="number" step="0.01" id="weight_real" name="weight_verified" required
                               oninput="calculateTotal()"
                               class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-2 text-white font-bold outline-none focus:border-primary">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-white/60 mb-1 uppercase">Grade Final</label>
                        <select id="finalGradeSelect" name="final_grade" onchange="updatePriceFromGrade()" class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-2 text-white font-bold outline-none focus:border-primary">
                            <option value="A">Grade A</option>
                            <option value="B">Grade B</option>
                            <option value="C">Grade C</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-xs font-bold text-white/60 mb-1 uppercase flex items-center justify-between">
                        <span>Harga per Kg</span>
                        <span class="text-[9px] text-yellow-400 normal-case">*Bisa diedit</span>
                    </label>
                    <input type="number" id="finalPriceInput" name="final_price" required oninput="calculateTotal()"
                           class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-2 text-white font-mono font-bold outline-none focus:border-primary transition-all">
                </div>

                <div class="bg-primary/5 border border-primary/20 rounded-xl p-4 mb-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-bold text-white">Total DP (Bayar Sekarang)</span>
                        <span class="font-mono text-xl font-bold text-primary" id="display_dp_amount">Rp 0</span>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-bold text-white/60 mb-2 uppercase text-primary">Upload Bukti Transfer DP</label>
                    <input type="file" name="proof_payment" class="w-full text-xs text-white/50 bg-black/40 p-2 rounded-xl border border-white/10" required>
                </div>

                <div class="flex gap-3">
                    <button type="button" onclick="document.getElementById('verifyModal').classList.add('hidden')" class="flex-1 py-2 rounded-xl border border-white/10 text-white font-bold hover:bg-white/5">Batal</button>
                    <button type="submit" class="flex-1 py-2 rounded-xl bg-primary text-dark font-bold hover:bg-green-400">Konfirmasi</button>
                </div>
            </form>
        </div>
    </div>

    <div id="finalModal" class="hidden fixed inset-0 bg-black/80 z-50 flex items-center justify-center backdrop-blur-sm p-4">
        <div class="bg-[#162e26] border border-white/10 rounded-2xl p-6 w-full max-w-md shadow-2xl relative">
            <h3 class="text-xl font-bold text-white mb-4">Pelunasan Akhir</h3>
            <form id="finalForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="bg-black/20 p-4 rounded-xl mb-4 text-sm border border-white/5 space-y-2">
                    <div class="flex justify-between text-white/60"><span>Berat Verified:</span> <span class="text-white font-bold" id="finalWeightDisplay">0 Kg</span></div>
                    <div class="flex justify-between text-white/60"><span>Grade Final:</span> <span class="text-yellow-400 font-bold" id="finalGradeDisplay">-</span></div>
                    <div class="flex justify-between text-white/60"><span>Sudah Dibayar (DP):</span> <span class="text-blue-400 font-bold" id="finalDPPaid">Rp 0</span></div>
                </div>
                <div class="mb-4">
                    <label class="text-xs text-white/60 block mb-1 uppercase font-bold">Harga Pasar Hari Ini (Rp/Kg)</label>
                    <input type="number" id="marketPrice" readonly class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-2 text-white/50 font-bold outline-none cursor-not-allowed">
                </div>
                <div class="mb-4 p-3 bg-primary/10 border border-primary/20 rounded-xl text-center">
                    <p class="text-xs text-primary mb-1 uppercase font-bold tracking-widest">Sisa Yang Harus Transfer</p>
                    <input type="hidden" name="final_amount" id="inputFinalAmount">
                    <p class="text-2xl font-black text-white" id="displayTransfer">Rp 0</p>
                </div>
                <div class="mb-6">
                    <label class="block text-xs font-bold text-white/60 mb-2 uppercase text-purple-400">Upload Bukti Pelunasan</label>
                    <input type="file" name="proof_payment_final" class="w-full text-xs text-white/50 bg-black/40 p-2 rounded-xl border border-white/10" required>
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="document.getElementById('finalModal').classList.add('hidden')" class="flex-1 py-3 rounded-xl border border-white/10 text-white font-bold hover:bg-white/5">Batal</button>
                    <button type="submit" class="flex-1 py-3 rounded-xl bg-primary text-dark font-bold hover:bg-green-400 shadow-lg shadow-primary/20">KONFIRMASI LUNAS</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const prices = JSON.parse('<?php echo json_encode($prices ?? []); ?>');
        
        let currentVariant = '';
        let currentDPPercent = 0;

        function toggleProfileMenu() {
            document.getElementById('profile-menu').classList.toggle('hidden');
        }

        // 🔥 INI MESIN BARUNYA WAK!
        function tolakSetoran(form, pesan) {
            let alasan = prompt(pesan);
            if (alasan) {
                form.note.value = alasan;
                return true;
            }
            return false;
        }

        function openVerifyModal(id, estWeight, dpPercent, variant, estGrade, basePrice) {
            document.getElementById('verifyForm').action = `/koperasi/deposits/${id}/process-dp`;
            
            document.getElementById('modalEstWeight').innerText = estWeight + ' Kg';
            document.getElementById('modalEstGrade').innerText = 'Grade ' + estGrade;
            document.getElementById('modalDP').innerText = dpPercent + '%';

            document.getElementById('weight_real').value = estWeight;
            
            let gradeSelect = document.getElementById('finalGradeSelect');
            let optionExists = Array.from(gradeSelect.options).some(opt => opt.value === estGrade);
            if (!optionExists && estGrade) {
                let newOption = new Option("Grade " + estGrade, estGrade);
                gradeSelect.add(newOption);
            }
            gradeSelect.value = estGrade || 'A';

            currentVariant = variant;
            currentDPPercent = parseFloat(dpPercent);

            document.getElementById('finalPriceInput').value = basePrice;
            
            calculateTotal();
            document.getElementById('verifyModal').classList.remove('hidden');
        }

        function updatePriceFromGrade() {
            let selectedGrade = document.getElementById('finalGradeSelect').value;
            let price = document.getElementById('finalPriceInput').value; 
            
            if(prices[currentVariant] && prices[currentVariant][selectedGrade]) {
                price = prices[currentVariant][selectedGrade];
            }
            
            document.getElementById('finalPriceInput').value = price;
            calculateTotal();
        }

        function calculateTotal() {
            let weight = parseFloat(document.getElementById('weight_real').value) || 0;
            let price = parseFloat(document.getElementById('finalPriceInput').value) || 0;

            let totalValue = weight * price;
            let dpAmount = totalValue * (currentDPPercent / 100);

            document.getElementById('display_dp_amount').innerText = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(dpAmount);
        }

        function openFinalModal(id, weight, dpPaid, variant, grade) {
            document.getElementById('finalForm').action = '/koperasi/deposits/' + id + '/process-final';
            
            document.getElementById('finalWeightDisplay').innerText = weight + ' Kg';
            document.getElementById('finalGradeDisplay').innerText = 'Grade ' + grade;
            document.getElementById('finalDPPaid').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(dpPaid);

            let priceNow = 0;
            if(prices[variant] && prices[variant][grade]) {
                priceNow = prices[variant][grade];
            }
            document.getElementById('marketPrice').value = priceNow;

            let totalValue = parseFloat(weight) * priceNow;
            let sisa = totalValue - parseFloat(dpPaid);
            if(sisa < 0) sisa = 0;

            document.getElementById('displayTransfer').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(sisa);
            document.getElementById('inputFinalAmount').value = sisa;

            document.getElementById('finalModal').classList.remove('hidden');
        }
    </script>
</body>
</html>