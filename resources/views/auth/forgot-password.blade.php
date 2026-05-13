<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>ResiGudang - Lupa Password</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
          theme: {
            extend: {
              colors: {
                brand: { dark: '#10221f', neon: '#13ec37' }
              },
              fontFamily: { sans: ['Inter', 'sans-serif'] },
            }
          }
        }
    </script>
    <style>
        body {
          background-color: #10221f;
          color: #ffffff;
          min-height: 100vh;
          display: flex;
          align-items: center;
          justify-content: center;
          overflow-x: hidden;
        }
        .blob-glow {
          position: absolute;
          width: 400px;
          height: 400px;
          background: radial-gradient(circle, rgba(19, 236, 55, 0.15) 0%, rgba(19, 236, 55, 0) 70%);
          filter: blur(40px);
          z-index: -1;
          border-radius: 50%;
        }
        .btn-neon-hover:hover {
          box-shadow: 0 0 20px rgba(19, 236, 55, 0.4);
          transition: all 0.3s ease;
        }
        .input-dark-focus:focus {
          border-color: #13ec37 !important;
          box-shadow: 0 0 0 1px #13ec37;
        }
    </style>
</head>
<body class="antialiased font-sans relative">
    
    <div class="blob-glow top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"></div>
    
    <main class="w-full max-w-md px-6 py-12 relative z-10">
        <div class="bg-[#162e26]/50 backdrop-blur-md border border-white/10 rounded-2xl p-8 md:p-10 shadow-2xl">
            <header class="flex flex-col items-center text-center mb-8">
                <div class="w-16 h-16 bg-brand-neon/10 rounded-full flex items-center justify-center mb-6">
                    <span class="material-symbols-rounded text-brand-neon text-4xl">lock_reset</span>
                </div>
                <h1 class="text-2xl font-bold text-white mb-3">Lupa Password?</h1>
                <p class="text-white/60 text-sm leading-relaxed">
                    Masukkan email yang terdaftar. Kami akan mengirimkan tautan untuk mengatur ulang password Anda.
                </p>
            </header>

            @if (session('status'))
                <div class="mb-6 p-4 rounded-xl bg-brand-neon/10 border border-brand-neon/20 text-brand-neon text-sm font-bold text-center">
                    ✅ {{ session('status') }}
                </div>
            @endif

            @error('email')
                <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm text-center font-bold">
                    ❌ {{ $message }}
                </div>
            @enderror

            <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
                @csrf
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold tracking-widest text-white/70 uppercase" for="email">
                        Email Address
                    </label>
                    <input class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-3 text-white placeholder:text-white/20 input-dark-focus transition-all duration-200 outline-none" 
                           id="email" name="email" value="{{ old('email') }}" placeholder="nama@perusahaan.com" required type="email" autofocus/>
                </div>
                
                <button class="w-full bg-brand-neon text-brand-dark font-bold py-3.5 rounded-xl btn-neon-hover transition-all duration-300 transform active:scale-[0.98]" type="submit">
                    Kirim Link Reset Password
                </button>
            </form>

            <footer class="mt-8 text-center">
                <p class="text-white/60 text-sm">
                    Ingat password? 
                    <a class="text-brand-neon hover:underline font-semibold ml-1 transition-all" href="{{ route('login') }}">
                        Kembali ke Login
                    </a>
                </p>
            </footer>
        </div>

        <div class="mt-8 text-center">
            <span class="text-white/20 text-xs font-semibold tracking-widest uppercase">ResiGudang &copy; {{ date('Y') }}</span>
        </div>
    </main>

</body>
</html>