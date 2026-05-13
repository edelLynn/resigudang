<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <title>Verifikasi Setoran - Admin</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0" rel="stylesheet"/>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: { extend: { colors: { primary: '#13ec37', dark: '#0b1210', surface: '#162e26' } } }
        }
    </script>
</head>
<body class="bg-dark text-white min-h-screen font-sans flex items-center justify-center p-4">

    <div class="w-full max-w-4xl bg-surface/50 border border-white/10 rounded-3xl overflow-hidden shadow-2xl flex flex-col md:flex-row">
        
        {{-- PANEL KIRI: Info Petani --}}
        <div class="md:w-1/3 bg-black/20 p-8 border-r border-white/5">
            <a href="{{ route('koperasi.dashboard') }}" class="inline-flex items-center gap-2 text-white/40 hover:text-white mb-6 text-sm transition-colors">
                <span class="material-symbols-rounded text-lg">arrow_back</span> Kembali
            </a>

            <h3 class="text-white/50 text-xs font-bold uppercase tracking-widest mb-4">Data Petani</h3>
            
            <div class="space-y-6">
                <div>
                    <p class="text-xs text-white/40 mb-1">Nama Petani</p>
                    <p class="font-bold text-lg">{{ $deposit->user->name }}</p>
                </div>
                <div>
                    <p class="text-xs text-white/40 mb-1">Varian Kopi</p>
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-1 bg-white/10 rounded text-xs font-bold">{{ $deposit->coffee_variant }}</span>
                        <span class="text-sm">{{ $deposit->coffee_form }}</span>
                    </div>
                </div>
                <div>
                    <p class="text-xs text-white/40 mb-1">Estimasi Awal</p>
                    <p class="font-mono text-xl text-white/80">{{ number_format($deposit->weight_input, 0) }} Kg</p>
                </div>
                <div>
                    <p class="text-xs text-white/40 mb-1">Request DP</p>
                    <p class="font-bold text-orange-400 text-xl">{{ $deposit->dp_percentage }}%</p>
                </div>
                
                @if($deposit->photo_proof_path)
                <div>
                    <p class="text-xs text-white/40 mb-2">Foto Barang</p>
                    <img src="{{ Storage::url($deposit->photo_proof_path) }}" class="rounded-xl border border-white/10 w-full h-32 object-cover opacity-70 hover:opacity-100 transition-opacity">
                </div>
                @endif
            </div>
        </div>

        {{-- PANEL KANAN: Form Verifikasi --}}
        <div class="md:w-2/3 p-8 bg-[#112214]">
            <h2 class="text-2xl font-bold mb-2">Verifikasi & Pembayaran DP</h2>
            <p class="text-white/40 text-sm mb-8">Input hasil timbangan real dan proses transfer DP.</p>

            <form action="{{ route('koperasi.deposits.process_dp', $deposit->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                @if ($errors->any())
                    <div class="bg-red-500/10 border border-red-500/30 rounded-xl p-4 mb-6">
                        @foreach ($errors->all() as $error)
                            <p class="text-red-400 text-sm">• {{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    {{-- Berat Timbangan — field: weight_verified --}}
                    <div>
                        <label class="block text-xs font-bold text-white/60 mb-2 uppercase">Berat Timbangan (Real)</label>
                        <div class="relative">
                            <input type="number" step="0.01" id="weight_real" name="weight_verified" required
                                   oninput="calculateTotal()"
                                   class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-3 text-white font-mono focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"
                                   placeholder="0.00">
                            <span class="absolute right-4 top-3 text-white/30 text-sm font-bold">Kg</span>
                        </div>
                    </div>

                    {{-- Grade Final — field: final_grade (wajib ada, sesuai controller) --}}
                    <div>
                        <label class="block text-xs font-bold text-white/60 mb-2 uppercase">Grade Final</label>
                        <select name="final_grade" required
                                class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-primary outline-none transition-all">
                            <option value="">-- Pilih Grade --</option>
                            <option value="A">Grade A</option>
                            <option value="B">Grade B</option>
                            <option value="C">Grade C</option>
                        </select>
                    </div>

                    {{-- Harga Pasar — field: final_price (sesuai controller) --}}
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-white/60 mb-2 uppercase">Harga Pasar (Rp/Kg)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-white/30 text-sm font-bold">Rp</span>
                            <input type="number" id="price_market" name="final_price" required
                                   oninput="calculateTotal()"
                                   class="w-full bg-black/20 border border-white/10 rounded-xl pl-10 pr-4 py-3 text-white font-mono focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"
                                   placeholder="0">
                        </div>
                    </div>
                </div>

                {{-- Kalkulasi Otomatis --}}
                <div class="bg-primary/5 border border-primary/20 rounded-xl p-6 mb-6">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm text-primary/80 font-medium">Total Nilai Barang</span>
                        <span class="font-mono text-white" id="display_total_value">Rp 0</span>
                    </div>
                    <div class="flex justify-between items-center pt-2 border-t border-primary/10">
                        <span class="text-sm font-bold text-white">Wajib Bayar (DP {{ $deposit->dp_percentage }}%)</span>
                        <span class="font-mono text-2xl font-bold text-primary" id="display_dp_amount">Rp 0</span>
                    </div>
                </div>

                {{-- Upload Bukti — field: proof_payment (sesuai controller) --}}
                <div class="mb-8">
                    <label class="block text-xs font-bold text-white/60 mb-2 uppercase">Upload Bukti Transfer DP</label>
                    <input type="file" name="proof_payment" required accept="image/*"
                           class="block w-full text-sm text-white/50 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-primary/20 file:text-primary hover:file:bg-primary/30 cursor-pointer">
                </div>

                <div class="flex justify-end gap-4">
                    <button type="button" onclick="history.back()" class="px-6 py-3 rounded-xl text-sm font-bold text-white/50 hover:text-white">Batal</button>
                    <button type="submit" class="bg-primary hover:bg-[#0fd630] text-dark px-8 py-3 rounded-xl text-sm font-bold shadow-lg shadow-primary/20 transition-all transform hover:scale-105">
                        Konfirmasi & Bayar DP
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const dpPercent = Number("{{ $deposit->dp_percentage ?? 60 }}");

        function calculateTotal() {
            let weight = parseFloat(document.getElementById('weight_real').value) || 0;
            let price  = parseFloat(document.getElementById('price_market').value) || 0;
            let totalValue = weight * price;
            let dpAmount   = totalValue * (dpPercent / 100);

            document.getElementById('display_total_value').innerText =
                new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(totalValue);
            document.getElementById('display_dp_amount').innerText =
                new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(dpAmount);
        }
    </script>

</body>
</html>