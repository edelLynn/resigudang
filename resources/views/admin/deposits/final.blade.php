<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <title>Final Settlement - Admin</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: { extend: { colors: { primary: '#13ec37', dark: '#0b1210', surface: '#162e26' } } }
        }
    </script>
</head>
<body class="bg-dark text-white min-h-screen font-sans flex items-center justify-center p-4">

    <div class="w-full max-w-4xl bg-surface/50 border border-white/10 rounded-3xl overflow-hidden shadow-2xl flex flex-col md:flex-row">
        
        <div class="md:w-1/3 bg-black/20 p-8 border-r border-white/5">
            <h3 class="text-white/50 text-xs font-bold uppercase tracking-widest mb-6">Ringkasan Awal</h3>
            
            <div class="space-y-6">
                <div>
                    <p class="text-xs text-white/40 mb-1">Petani & Kopi</p>
                    <p class="font-bold">{{ $deposit->user->name }}</p>
                    <p class="text-xs text-primary">{{ $deposit->coffee_variant }} ({{ $deposit->weight_verified }} Kg)</p>
                </div>
                
                <div class="p-4 rounded-xl bg-white/5 border border-white/5">
                    <p class="text-xs text-white/40 mb-1">Sudah Dibayar (DP)</p>
                    <p class="font-bold text-lg text-white">Rp {{ number_format($deposit->total_dp_amount, 0, ',', '.') }}</p>
                    <p class="text-[10px] text-white/30">
                        Rate Dulu: Rp {{ number_format($deposit->price_base_dp, 0) }}/Kg
                    </p>
                </div>
            </div>
        </div>

        <div class="md:w-2/3 p-8 bg-[#112214]">
            <h2 class="text-2xl font-bold mb-2">Pelunasan Akhir</h2>
            <p class="text-white/40 text-sm mb-8">Hitung sisa pembayaran berdasarkan harga pasar HARI INI.</p>

            <form action="{{ route('koperasi.deposits.process_final', $deposit->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-6">
                    <label class="block text-xs font-bold text-white/60 mb-2 uppercase">Harga Pasar (Update Hari Ini)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-3 text-white/30 text-sm font-bold">Rp</span>
                        <input type="number" id="price_final" name="price_final_settlement" required
                               oninput="calculateFinal()"
                               class="w-full bg-black/20 border border-white/10 rounded-xl pl-10 pr-4 py-3 text-white font-mono focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"
                               placeholder="Masukkan Harga Sekarang...">
                    </div>
                </div>

                <div class="bg-primary/5 border border-primary/20 rounded-xl p-6 mb-6 space-y-3">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-white/50">Nilai Total Baru</span>
                        <span class="font-mono text-white" id="display_total_new">Rp 0</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-white/50">Dikurangi DP ({{ $deposit->dp_percentage }}%)</span>
                        <span class="font-mono text-red-400">- Rp {{ number_format($deposit->total_dp_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="border-t border-white/10 pt-3 flex justify-between items-center">
                        <span class="font-bold text-white">Sisa Transfer</span>
                        <span class="font-mono text-2xl font-bold text-primary" id="display_sisa">Rp 0</span>
                    </div>
                </div>

                <div class="mb-8">
                    <label class="block text-xs font-bold text-white/60 mb-2 uppercase">Upload Bukti Pelunasan</label>
                    <input type="file" name="proof_final" required accept="image/*"
                           class="block w-full text-sm text-white/50 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-primary/20 file:text-primary hover:file:bg-primary/30 cursor-pointer">
                </div>

                <div class="flex justify-end gap-4">
                    <button type="button" onclick="history.back()" class="px-6 py-3 rounded-xl text-sm font-bold text-white/50 hover:text-white">Batal</button>
                    <button type="submit" class="bg-primary hover:bg-[#0fd630] text-dark px-8 py-3 rounded-xl text-sm font-bold shadow-lg shadow-primary/20 transition-all transform hover:scale-105">
                        Transfer & Lunas
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const weight = Number("{{ $deposit->weight_verified }}");
        const dpPaid = Number("{{ $deposit->total_dp_amount }}");

        function calculateFinal() {
            let price = parseFloat(document.getElementById('price_final').value) || 0;
            
            // Rumus: (Berat x Harga Baru) - DP Lama
            let totalNew = weight * price;
            let sisa = totalNew - dpPaid;

            if(sisa < 0) sisa = 0; // Jaga-jaga kalau harga anjlok parah

            document.getElementById('display_total_new').innerText = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(totalNew);
            document.getElementById('display_sisa').innerText = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(sisa);
        }
    </script>
</body>
</html>