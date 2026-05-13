<!DOCTYPE html>
<html class="dark" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0" rel="stylesheet"/>
    
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#13ec37",
                        "background-light": "#f8f6f6",
                        "background-dark": "#10221f",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"],
                        "sans": ["Inter", "sans-serif"]
                    }
                },
            },
        }
    </script>
    <style>
        .material-symbols-rounded {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 48;
        }
    </style>
    <title>ResiGudang - Reset Password</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
</head>
<body class="bg-background-dark font-display text-slate-100 antialiased min-h-screen flex items-center justify-center p-4 overflow-x-hidden">
    
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-primary/20 rounded-full blur-[120px] -z-10"></div>
    <div class="fixed top-0 right-0 w-[300px] h-[300px] bg-primary/10 rounded-full blur-[100px] -z-10"></div>
    
    <div class="w-full max-w-md relative z-10">
        <div class="flex flex-col items-center mb-8">
            <div class="flex items-center gap-3 mb-2">
                <div class="size-10 bg-primary/20 rounded-xl flex items-center justify-center text-primary border border-primary/30">
                    <span class="material-symbols-rounded text-3xl">warehouse</span>
                </div>
                <h1 class="text-2xl font-extrabold tracking-tight text-white uppercase">ResiGudang</h1>
            </div>
        </div>

        <div class="relative bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl shadow-2xl p-8 md:p-10">
            <div class="flex flex-col items-center text-center mb-8">
                <div class="size-16 bg-primary/10 rounded-full flex items-center justify-center text-primary mb-4 border border-primary/20">
                    <span class="material-symbols-rounded text-4xl">shield_lock</span>
                </div>
                <h2 class="text-2xl font-bold text-white mb-2">Buat Password Baru</h2>
                <p class="text-slate-400 text-sm leading-relaxed">
                    Silakan buat password baru yang kuat dan aman untuk akun Anda agar tetap terlindungi.
                </p>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-xs font-bold">
                    <ul class="list-disc pl-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="space-y-2">
                    <label class="text-xs font-semibold uppercase tracking-wider text-slate-500 ml-1">Email Address</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500">
                            <span class="material-symbols-rounded text-xl">mail</span>
                        </div>
                        <input class="w-full bg-black/40 border border-white/5 text-slate-500 rounded-xl py-4 pl-12 pr-4 focus:ring-0 focus:outline-none text-sm font-medium" 
                               type="email" name="email" value="{{ old('email', $request->email) }}" required readonly/>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-semibold uppercase tracking-wider text-slate-300 ml-1">Password Baru</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary transition-colors">
                            <span class="material-symbols-rounded text-xl">lock</span>
                        </div>
                        <input class="w-full bg-black/20 border border-white/10 text-white rounded-xl py-4 pl-12 pr-12 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none text-sm" 
                               type="password" name="password" required placeholder="Minimal 8 Karakter" autofocus/>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-semibold uppercase tracking-wider text-slate-300 ml-1">Konfirmasi Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary transition-colors">
                            <span class="material-symbols-rounded text-xl">lock_reset</span>
                        </div>
                        <input class="w-full bg-black/20 border border-white/10 text-white rounded-xl py-4 pl-12 pr-12 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none text-sm" 
                               type="password" name="password_confirmation" required placeholder="Ketik ulang password"/>
                    </div>
                </div>

                <div class="px-1">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-[10px] font-bold text-slate-500 uppercase">Kekuatan Password</span>
                        <span class="text-[10px] font-bold text-primary uppercase">Kuat</span>
                    </div>
                    <div class="flex gap-1.5 h-1">
                        <div class="flex-1 bg-primary rounded-full"></div>
                        <div class="flex-1 bg-primary rounded-full"></div>
                        <div class="flex-1 bg-primary rounded-full"></div>
                        <div class="flex-1 bg-white/10 rounded-full"></div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-primary hover:bg-primary/90 text-background-dark font-bold py-4 rounded-xl shadow-[0_0_20px_rgba(19,236,55,0.3)] hover:shadow-[0_0_30px_rgba(19,236,55,0.5)] transition-all duration-300 transform hover:-translate-y-0.5 active:scale-95 flex items-center justify-center gap-2 mt-4">
                    <span>Simpan Password Baru</span>
                    <span class="material-symbols-rounded">arrow_forward</span>
                </button>
            </form>

            <div class="mt-8 text-center">
                <a href="{{ route('login') }}" class="text-sm text-slate-500 hover:text-primary transition-colors flex items-center justify-center gap-1">
                    <span class="material-symbols-rounded text-sm">keyboard_backspace</span>
                    Kembali ke halaman Login
                </a>
            </div>
        </div>

        <p class="mt-8 text-center text-slate-600 text-xs">
            &copy; {{ date('Y') }} ResiGudang AgriTech. Keamanan Anda adalah prioritas kami.
        </p>
    </div>
</body>
</html>