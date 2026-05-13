<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Nyasar Bos! | ResiGudang</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class', theme: { extend: { colors: { primary: '#13ec37', dark: '#10221f' } } } }
    </script>
</head>
<body class="bg-dark text-white h-screen flex items-center justify-center overflow-hidden relative">
    <div class="absolute w-[500px] h-[500px] bg-primary/20 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="text-center relative z-10 px-6">
        <span class="material-symbols-rounded text-9xl text-primary mb-4 drop-shadow-[0_0_30px_rgba(19,236,55,0.5)]">explore_off</span>
        <h1 class="text-7xl font-black mb-2 tracking-tight">404</h1>
        <h2 class="text-2xl font-bold text-white/80 mb-6">Waduh, Nyasar Nih Bos!</h2>
        <p class="text-sm text-white/50 max-w-md mx-auto mb-8 leading-relaxed">
            Halaman yang lu cari kayaknya udah dipindah, dihapus, atau emang gak pernah ada di gudang kita.
        </p>
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 bg-primary hover:bg-[#0fd630] text-dark px-8 py-4 rounded-xl text-sm font-bold shadow-[0_0_20px_rgba(19,236,55,0.4)] transition-all transform hover:scale-105">
            <span class="material-symbols-rounded">home</span> Balik ke Jalan yang Benar
        </a>
    </div>
</body>
</html>