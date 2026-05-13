<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riwayat Setoran - ResiGudang</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
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
        body { font-family: 'Inter', sans-serif; background-color: #10221f; }
        .glass-panel {
            background: rgba(22, 46, 38, 0.6); backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08); box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
        }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        #resi-modal.hidden { opacity: 0; pointer-events: none; }
        #resi-modal:not(.hidden) { opacity: 1; pointer-events: auto; }
        #resi-modal { transition: opacity 0.3s ease; }
    </style>
</head>
<body class="bg-dark text-white h-screen flex overflow-hidden">

    <aside class="w-64 flex flex-col border-r border-white/5 bg-[#112214]/50 backdrop-blur-md relative z-20">
        <div class="p-6 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary/80 to-primary/20 flex items-center justify-center shadow-lg shadow-primary/20">
                <span class="material-symbols-outlined text-black font-bold">local_cafe</span>
            </div>
            <div class="flex flex-col">
                <h1 class="text-white text-lg font-bold tracking-tight">ResiGudang</h1>
                <p class="text-white/50 text-xs font-medium">Petani Panel</p>
            </div>
        </div>
        <nav class="flex-1 flex flex-col gap-2 px-4 py-4 overflow-y-auto">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white/60 hover:bg-white/5 hover:text-white transition-all group">
                <span class="material-symbols-outlined group-hover:scale-110">dashboard</span>
                <span class="text-sm font-medium">Dashboard</span>
            </a>
            <div class="flex items-center gap-3 px-4 py-3 rounded-lg bg-primary/10 text-primary border-r-2 border-primary transition-all">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">history</span>
                <span class="text-sm font-bold">History</span>
            </div>
            <a href="{{ route('petani.inventory.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white/60 hover:bg-white/5 hover:text-white transition-all group">
                <span class="material-symbols-outlined group-hover:scale-110">inventory_2</span>
                <span class="text-sm font-medium">Stok Saya</span>
            </a>
        </nav>
        <div class="p-4 border-t border-white/5">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex w-full items-center gap-3 p-3 rounded-xl bg-white/5 border border-white/5 hover:bg-red-500/10 hover:text-red-400 transition-all text-left">
                    <span class="material-symbols-outlined">logout</span>
                    <div class="flex flex-col overflow-hidden">
                        <span class="text-sm font-bold truncate">Keluar</span>
                        <span class="text-[10px] opacity-60">{{ Auth::user()->name }}</span>
                    </div>
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col relative h-full overflow-hidden">
        <div class="absolute top-[-20%] right-[-10%] w-[800px] h-[800px] bg-primary/5 rounded-full blur-[150px] pointer-events-none"></div>

        <header class="h-20 px-8 flex items-center justify-between border-b border-white/5 bg-dark/80 backdrop-blur-sm z-10 shrink-0">
            <div>
                <h2 class="text-2xl font-bold text-white tracking-tight">Deposit History</h2>
                <div class="flex items-center gap-2 text-white/40 text-sm mt-0.5">
                    <a href="{{ route('dashboard') }}" class="hover:text-primary">Dashboard</a>
                    <span class="text-[10px]">›</span>
                    <span class="text-white/60">Deposits</span>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8 space-y-6 scroll-smooth">
            <div class="glass-panel rounded-2xl overflow-hidden flex flex-col min-h-[500px]">
                
                <div class="px-6 pt-6 border-b border-white/5 bg-black/20">
                    <div class="flex items-center gap-8 overflow-x-auto">
                        @foreach(['semua', 'verified', 'pending', 'rejected'] as $tab)
                        <a href="{{ route('setoran.history', ['status' => $tab]) }}" 
                           class="relative pb-4 text-sm font-medium transition-all hover:text-white capitalize
                           {{ ($status ?? 'semua') == $tab ? 'text-white' : 'text-white/40' }}">
                            {{ $tab }}
                            @if(($status ?? 'semua') == $tab)
                                <span class="absolute bottom-0 left-0 w-full h-[3px] bg-primary shadow-[0_0_10px_#13ec37] rounded-t-full"></span>
                            @endif
                        </a>
                        @endforeach
                    </div>
                </div>

                <div class="flex-1 overflow-auto bg-dark/30">
                <table class="w-full text-left border-collapse">
                    <thead class="sticky top-0 z-10 bg-[#112214] border-b border-white/10 text-xs uppercase tracking-wider text-white/40">
                        <tr>
                            <th class="px-6 py-4 font-semibold">ID / Date</th>
                            <th class="px-6 py-4 font-semibold">Coffee Info</th>
                            <th class="px-6 py-4 font-semibold text-right">Weight</th>
                            <th class="px-6 py-4 font-semibold">Harga</th>
                            <th class="px-6 py-4 font-semibold text-center">Bukti Transfer</th> 
                            <th class="px-6 py-4 font-semibold text-center">Status</th>
                            <th class="px-6 py-4 text-right">Download resi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5 text-sm">
                        @forelse($histories as $item)
                        <tr class="group hover:bg-white/[0.02] transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="font-bold text-primary">#Item-{{ $item->id }}</span>
                                    <span class="text-xs text-white/50">{{ \Carbon\Carbon::parse($item->deposit_date)->format('d M Y') }}</span>
                                </div>
                            </td>
                            
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-xs font-bold text-white/60">
                                        {{ substr($item->coffee_variant, 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-white">{{ $item->coffee_variant }}</p>
                                        <p class="text-xs text-white/40">{{ $item->coffee_form }}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-right">
                                @if($item->weight_verified)
                                    <span class="font-mono font-bold text-primary">{{ number_format($item->weight_verified, 0, ',', '.') }}</span> <span class="text-xs text-primary/50">kg</span>
                                @else
                                    <span class="font-mono font-bold text-white">{{ number_format($item->weight_input, 0, ',', '.') }}</span> <span class="text-xs text-white/40">kg</span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                @if($item->status == 'PARTIAL_PAID' || $item->status == 'PAID_OFF' || $item->status == 'REQUEST_FINAL')
                                    <div class="flex flex-col">
                                        <span class="text-[10px] text-white/40 uppercase">Total Dibayar</span>
                                        <span class="text-primary font-bold">Rp {{ number_format($item->total_dp_amount + $item->total_final_amount, 0, ',', '.') }}</span>
                                    </div>
                                @else
                                    <span class="text-white/20 text-xs italic">-</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    
                                    {{-- Cek Bukti DP --}}
                                    @if($item->proof_payment)
                                        <a href="{{ Storage::url($item->proof_payment) }}" target="_blank" 
                                        class="text-[10px] bg-blue-500/10 text-blue-400 border border-blue-500/20 px-2 py-1 rounded hover:bg-blue-500 hover:text-white transition-colors flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[10px]">image</span> Bukti DP
                                        </a>
                                    @endif

                                    {{-- Cek Bukti Lunas --}}
                                    @if($item->proof_payment_final)
                                        <a href="{{ Storage::url($item->proof_payment_final) }}" target="_blank" 
                                        class="text-[10px] bg-green-500/10 text-green-400 border border-green-500/20 px-2 py-1 rounded hover:bg-green-500 hover:text-white transition-colors flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[10px]">image</span> Bukti Lunas
                                        </a>
                                    @endif

                                    {{-- Kalau gak ada bukti sama sekali --}}
                                    @if(!$item->proof_payment && !$item->proof_payment_final)
                                        <span class="text-white/20 text-[10px] italic">Belum ada</span>
                                    @endif
                                </div>
                            </td>

                            <td class="px-6 py-4 text-center">
                                @php
                                    $badges = [
                                        'PENDING' => ['bg' => 'bg-orange-500/10', 'text' => 'text-orange-400', 'border' => 'border-orange-500/20'],
                                        'VERIFIED' => ['bg' => 'bg-blue-500/10', 'text' => 'text-blue-400', 'border' => 'border-blue-500/20'],
                                        'PARTIAL_PAID' => ['bg' => 'bg-primary/10', 'text' => 'text-primary', 'border' => 'border-primary/20'],
                                        'REQUEST_FINAL' => ['bg' => 'bg-purple-500/10', 'text' => 'text-purple-400', 'border' => 'border-purple-500/20'],
                                        'PAID_OFF' => ['bg' => 'bg-green-500/10', 'text' => 'text-green-400', 'border' => 'border-green-500/20'],
                                        'REJECTED' => ['bg' => 'bg-red-500/10', 'text' => 'text-red-400', 'border' => 'border-red-500/20'],
                                    ];
                                    $style = $badges[$item->status] ?? $badges['PENDING'];
                                    $label = str_replace('_', ' ', $item->status);
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold {{ $style['bg'] }} {{ $style['text'] }} border {{ $style['border'] }}">
                                    {{ $label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    
                                    {{-- A. TOMBOL JUAL SISA (Hanya Muncul Jika Masih DP / Partial Paid) --}}
                                    @if($item->status == 'PARTIAL_PAID')
                                        <form action="{{ route('deposit.request_final', $item->id) }}" method="POST" onsubmit="return confirm('Cairkan sisa pembayaran?');">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 rounded-lg bg-orange-500 hover:bg-orange-600 text-white text-xs font-bold transition-all shadow-lg shadow-orange-500/20">
                                                Jual Sisa
                                            </button>
                                        </form>
                                    @endif

                                    {{-- B. TOMBOL DOWNLOAD RESI (Muncul Jika Sudah Diverifikasi Admin) --}}
                                    @if(in_array($item->status, ['VERIFIED', 'PARTIAL_PAID', 'PAID_OFF', 'REQUEST_FINAL']))
                                        <a href="{{ route('deposit.download', $item->id) }}" target="_blank" 
                                        class="flex items-center gap-1 px-3 py-1.5 rounded-lg bg-white/5 border border-white/10 text-white text-xs font-bold hover:bg-white/20 transition-all" 
                                        title="Download Resi PDF">
                                            <span class="material-symbols-outlined text-[16px]">description</span> Resi
                                        </a>
                                    @endif

                                    {{-- C. TANDA STRIP (Jika Belum Ada Aksi) --}}
                                    @if(!in_array($item->status, ['PARTIAL_PAID', 'VERIFIED', 'PAID_OFF', 'REQUEST_FINAL']))
                                        <span class="text-white/20 text-xs">-</span>
                                    @endif

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-20 text-center text-white/30">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <span class="material-symbols-outlined text-4xl">inbox</span>
                                    <p>Belum ada data setoran</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </main>

    <div id="resi-modal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/80 backdrop-blur-sm p-4">
        <div class="bg-[#10221f] border border-white/10 w-full max-w-md rounded-2xl shadow-2xl overflow-hidden transform transition-all scale-100">
            <div class="p-6 border-b border-white/5 flex justify-between items-center bg-primary/5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-dark font-bold">
                        <span class="material-symbols-outlined">payments</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">Bukti Transfer</h3>
                        <p class="text-xs text-white/50">Pembayaran Resmi</p>
                    </div>
                </div>
                <button onclick="closeResiModal()" class="w-8 h-8 rounded-full hover:bg-white/10 flex items-center justify-center text-white/50 hover:text-white transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div class="p-6 space-y-6">
                <div class="rounded-xl overflow-hidden border border-white/10 bg-black/40 min-h-[300px] flex items-center justify-center relative">
                    <img id="modal-proof-img" src="" class="w-full h-full object-contain hidden">
                    <div id="modal-no-proof" class="text-center p-6">
                        <span class="material-symbols-outlined text-4xl text-white/20 mb-2">image_not_supported</span>
                        <p class="text-xs text-white/40">Bukti transfer belum tersedia.</p>
                    </div>
                </div>
                <a id="modal-download-btn" href="#" class="block w-full py-3 rounded-xl bg-primary text-dark font-bold text-center hover:bg-[#0fd630] transition-colors shadow-lg shadow-primary/20">
                    Download Resi (PDF)
                </a>
            </div>
        </div>
    </div>

    <script>
        function openResiModal(element) {
            // Ambil data dari atribut
            const proofUrl = element.getAttribute('data-proof');
            const id = element.getAttribute('data-id');

            const imgEl = document.getElementById('modal-proof-img');
            const noProofEl = document.getElementById('modal-no-proof');

            // Logic Tampilkan Gambar
            if (proofUrl) {
                imgEl.src = proofUrl;
                imgEl.classList.remove('hidden');
                noProofEl.classList.add('hidden');
            } else {
                imgEl.classList.add('hidden');
                noProofEl.classList.remove('hidden');
            }
            
            // Set Link Download PDF
            document.getElementById('modal-download-btn').href = "/deposit/" + id + "/download";
            
            // Buka Modal
            document.getElementById('resi-modal').classList.remove('hidden');
        }

        function closeResiModal() {
            document.getElementById('resi-modal').classList.add('hidden');
        }
    </script>
</body>
</html>