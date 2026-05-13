<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Petani - ResiGudang</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0" rel="stylesheet"/>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: { primary: '#13ec37', dark: '#0b1210' },
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    animation: { 'float': 'float 6s ease-in-out infinite' },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #0b1210; }
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }
        .glass-input {
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            transition: all 0.3s ease;
        }
        .glass-input:focus {
            border-color: #13ec37;
            background: rgba(0, 0, 0, 0.5);
            box-shadow: 0 0 0 2px rgba(19, 236, 55, 0.2);
        }
        /* Autofill Fix */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px #0b1210 inset !important;
            -webkit-text-fill-color: white !important;
            caret-color: white;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center relative overflow-hidden selection:bg-primary selection:text-black py-10">

    <div class="fixed top-[-10%] right-[-10%] w-[600px] h-[600px] bg-primary/10 rounded-full blur-[120px] animate-float opacity-60 pointer-events-none"></div>
    <div class="fixed bottom-[-10%] left-[-10%] w-[500px] h-[500px] bg-blue-500/10 rounded-full blur-[100px] animate-float opacity-40 pointer-events-none" style="animation-delay: 2s;"></div>

    <div class="w-full max-w-md p-6 relative z-10">
        
        <div class="text-center mb-6">
            <h1 class="text-3xl font-black text-white tracking-tight">Gabung ResiGudang</h1>
            <p class="text-white/40 text-sm mt-1">Daftar sekarang untuk mulai setor hasil panen.</p>
        </div>

        <div class="glass-card rounded-3xl p-8">
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-white/60 uppercase mb-2 ml-1">Nama Lengkap</label>
                    <div class="relative">
                        <input type="text" name="name" required autofocus placeholder="Nama Petani" 
                            class="glass-input w-full px-5 py-3.5 rounded-xl outline-none placeholder:text-white/20">
                        <span class="material-symbols-rounded absolute right-4 top-1/2 -translate-y-1/2 text-white/30 pointer-events-none">person</span>
                    </div>
                    @error('name') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-white/60 uppercase mb-2 ml-1">Email Address</label>
                    <div class="relative">
                        <input type="email" name="email" required placeholder="nama@email.com" 
                            class="glass-input w-full px-5 py-3.5 rounded-xl outline-none placeholder:text-white/20">
                        <span class="material-symbols-rounded absolute right-4 top-1/2 -translate-y-1/2 text-white/30 pointer-events-none">mail</span>
                    </div>
                    @error('email') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-white/60 uppercase mb-2 ml-1">Password</label>
                    <div class="relative">
                        <input type="password" name="password" required placeholder="Minimal 8 karakter" 
                            class="glass-input w-full px-5 py-3.5 rounded-xl outline-none placeholder:text-white/20">
                        <span class="material-symbols-rounded absolute right-4 top-1/2 -translate-y-1/2 text-white/30 pointer-events-none">lock</span>
                    </div>
                    @error('password') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-white/60 uppercase mb-2 ml-1">Konfirmasi Password</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" required placeholder="Ulangi password" 
                            class="glass-input w-full px-5 py-3.5 rounded-xl outline-none placeholder:text-white/20">
                        <span class="material-symbols-rounded absolute right-4 top-1/2 -translate-y-1/2 text-white/30 pointer-events-none">lock_reset</span>
                    </div>
                </div>

                <button type="submit" class="w-full py-4 rounded-xl bg-white text-dark font-bold text-lg shadow-[0_0_20px_rgba(255,255,255,0.2)] hover:bg-primary hover:shadow-[0_0_30px_rgba(19,236,55,0.4)] hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 mt-2">
                    Daftar Sekarang
                </button>
            </form>
        </div>

        <p class="text-center mt-8 text-white/40 text-sm">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="text-primary hover:text-white font-bold transition-colors">Masuk disini</a>
        </p>
    </div>

</body>
</html>