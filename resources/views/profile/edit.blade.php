<!DOCTYPE html>
<html class="dark" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Edit Profil - ResiGudang</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#13ec37",
                        "background-dark": "#102213", 
                    },
                    fontFamily: { "display": ["Inter", "sans-serif"] },
                    boxShadow: {
                        'glow': '0 0 20px rgba(19, 236, 55, 0.5)',
                        'glow-lg': '0 0 40px rgba(19, 236, 55, 0.3)',
                    }
                },
            },
        }
    </script>
    <style>
        /* SCROLLBAR KEREN */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #102213; }
        ::-webkit-scrollbar-thumb { background: #234829; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #32673b; }
        
        .glass-panel {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        
        /* CLASS INPUT SAKTI (ANTI PUTIH) */
        .glass-input {
            background-color: rgba(16, 34, 19, 0.6) !important; /* Paksa Gelap */
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white !important; /* Teks Selalu Putih */
            transition: all 0.3s ease;
        }
        .glass-input:focus {
            border-color: #13ec37;
            box-shadow: 0 0 0 1px #13ec37;
            background-color: rgba(16, 34, 19, 0.9) !important;
        }

        /* ANTI AUTOFILL PUTIH (Otomatis Timpa Warna Gelap) */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active,
        select:-webkit-autofill,
        select:-webkit-autofill:hover,
        select:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0 30px #102213 inset !important;
            -webkit-text-fill-color: white !important;
            transition: background-color 5000s ease-in-out 0s;
            caret-color: white;
        }
    </style>
</head>
<body class="bg-[#102213] font-display text-white overflow-x-hidden min-h-screen relative selection:bg-primary selection:text-black">

    <div class="fixed top-0 left-1/4 w-[500px] h-[500px] bg-primary/10 rounded-full blur-[120px] pointer-events-none z-0"></div>
    <div class="fixed bottom-0 right-0 w-[600px] h-[600px] bg-primary/5 rounded-full blur-[100px] pointer-events-none z-0"></div>

    <div class="relative z-10 flex flex-col min-h-screen">
        
        <header class="w-full border-b border-white/5 bg-[#102213]/80 backdrop-blur-md sticky top-0 z-50">
            <div class="max-w-[1280px] mx-auto px-6 h-20 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="size-8 text-primary">
                        <svg fill="none" viewbox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"><path d="M6 6H42L36 24L42 42H6L12 24L6 6Z" fill="currentColor"></path></svg>
                    </div>
                    <h2 class="text-white text-xl font-bold tracking-tight">ResiGudang</h2>
                </div>

                <nav class="hidden md:flex items-center gap-8">
                    <a class="text-white hover:text-primary transition-colors text-sm font-bold flex items-center gap-2" href="{{ route('dashboard') }}">
                        <span class="material-symbols-outlined text-lg">dashboard</span>
                        Dashboard
                    </a>
                </nav>

                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-white/50 uppercase">{{ Auth::user()->role }}</p>
                    </div>
                    <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 ring-2 ring-white/10" 
                         style='background-image: url("https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=13ec37&color=0b1210&bold=true");'>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 w-full max-w-[1024px] mx-auto px-6 py-10 flex flex-col items-center">
            
            @if(session('success'))
            <div class="w-full mb-6 bg-primary/10 border border-primary/20 text-primary p-4 rounded-2xl flex items-center gap-3 animate-pulse">
                <span class="material-symbols-outlined">check_circle</span>
                <span class="font-bold">{{ session('success') }}</span>
            </div>
            @endif

            <div class="flex flex-col items-center gap-6 mb-10 w-full animate-in fade-in slide-in-from-bottom-4 duration-700">
                <div class="relative group cursor-pointer">
                    <div class="size-32 rounded-full bg-cover bg-center border-4 border-[#102213] ring-4 ring-primary shadow-glow transition-transform group-hover:scale-105" 
                         style='background-image: url("https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=13ec37&color=0b1210&size=256&bold=true");'>
                    </div>
                </div>
                <div class="text-center">
                    <h1 class="text-3xl font-bold text-white mb-2 tracking-tight">{{ $user->name }}</h1>
                    <span class="inline-block px-4 py-1 rounded-full bg-primary/20 text-primary border border-primary/30 text-xs font-bold tracking-wider uppercase">
                        {{ $user->role }}
                    </span>
                </div>
            </div>

            <form action="{{ route('profile.update') }}" method="POST" class="w-full glass-panel rounded-[2rem] p-8 md:p-10 shadow-2xl animate-in fade-in slide-in-from-bottom-8 duration-700 delay-150">
                @csrf
                @method('PATCH')

                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-6 border-b border-white/10 pb-4">
                        <span class="material-symbols-outlined text-primary">security</span>
                        <h2 class="text-xl font-bold text-white tracking-tight">Informasi Pribadi & Keamanan</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <label class="flex flex-col gap-2">
                            <span class="text-sm font-medium text-gray-400 ml-1">Nama Lengkap</span>
                            <div class="relative">
                                <input name="name" class="glass-input w-full h-14 rounded-2xl px-5 text-base focus:ring-0 focus:outline-none" type="text" value="{{ old('name', $user->name) }}"/>
                                <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-gray-500">person</span>
                            </div>
                        </label>
                        
                        <label class="flex flex-col gap-2 opacity-70">
                            <span class="text-sm font-medium text-gray-500 ml-1 flex items-center gap-1">Email <span class="text-[10px] text-gray-600">(Tidak dapat diubah)</span></span>
                            <div class="relative">
                                <input name="email" class="glass-input w-full h-14 rounded-2xl px-5 text-base text-gray-400 cursor-not-allowed focus:outline-none" type="email" value="{{ old('email', $user->email) }}" readonly/>
                                <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-gray-600">lock</span>
                            </div>
                        </label>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <label class="flex flex-col gap-2">
                            <span class="text-sm font-medium text-gray-400 ml-1">Password Baru (Opsional)</span>
                            <div class="relative">
                                <input name="password" class="glass-input w-full h-14 rounded-2xl px-5 text-base focus:ring-0 focus:outline-none" placeholder="Isi jika ingin ganti" type="password"/>
                                <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-gray-500">lock_open</span>
                            </div>
                        </label>
                        <label class="flex flex-col gap-2">
                            <span class="text-sm font-medium text-gray-400 ml-1">Ulangi Password</span>
                            <div class="relative">
                                <input name="password_confirmation" class="glass-input w-full h-14 rounded-2xl px-5 text-base focus:ring-0 focus:outline-none" placeholder="Konfirmasi password baru" type="password"/>
                                <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-gray-500">lock_reset</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-6 border-b border-white/10 pb-4">
                        <span class="material-symbols-outlined text-primary">account_balance_wallet</span>
                        <h2 class="text-xl font-bold text-white tracking-tight">Rekening Pencairan Dana</h2>
                    </div>
                    
                    <div class="bg-black/20 border border-white/5 rounded-2xl p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            
                            <label class="flex flex-col gap-2">
                                <span class="text-sm font-medium text-gray-400 ml-1">Nama Bank</span>
                                <div class="relative">
                                    <input name="bank_name" class="glass-input w-full h-14 rounded-2xl px-5 text-base focus:ring-0 focus:outline-none uppercase" placeholder="Contoh: BCA / BRI" type="text" value="{{ old('bank_name', $user->bank_name) }}"/>
                                    <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-gray-500">account_balance</span>
                                </div>
                            </label>

                            <label class="flex flex-col gap-2">
                                <span class="text-sm font-medium text-gray-400 ml-1">Nomor Rekening</span>
                                <input name="account_number" class="glass-input w-full h-14 rounded-2xl px-5 text-base focus:ring-0 focus:outline-none font-mono tracking-wide" placeholder="Contoh: 1234567890" type="number" value="{{ old('account_number', $user->account_number) }}"/>
                            </label>

                            <label class="flex flex-col gap-2">
                                <span class="text-sm font-medium text-gray-400 ml-1">Atas Nama</span>
                                <input name="account_holder" class="glass-input w-full h-14 rounded-2xl px-5 text-base focus:ring-0 focus:outline-none uppercase" placeholder="Nama sesuai buku tabungan" type="text" value="{{ old('account_holder', $user->account_holder) }}"/>
                            </label>

                        </div>

                        <div class="mt-4 flex items-start gap-2">
                            <span class="material-symbols-outlined text-primary/70 text-sm mt-0.5">info</span>
                            <p class="text-xs text-gray-400 leading-relaxed">
                                Pastikan data rekening benar. Dana hasil penjualan kopi akan ditransfer otomatis ke rekening ini setelah transaksi selesai.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row items-center justify-center gap-6 pt-2">
                    <button type="submit" class="w-full md:w-auto min-w-[240px] h-14 rounded-full bg-gradient-to-r from-primary to-green-600 text-background-dark font-bold text-lg shadow-glow hover:shadow-glow-lg hover:scale-105 active:scale-95 transition-all duration-300 flex items-center justify-center gap-2">
                        <span>Simpan Perubahan</span>
                        <span class="material-symbols-outlined text-[20px] font-bold">check</span>
                    </button>
                    
                    <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-white font-medium text-sm hover:underline underline-offset-4 transition-colors">
                        Batalkan
                    </a>
                </div>
            </form>
            </main>

        <footer class="py-6 text-center text-xs text-gray-600 border-t border-white/5 mt-auto">
            <p>© 2026 ResiGudang System. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>