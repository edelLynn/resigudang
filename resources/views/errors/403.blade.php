<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 - Akses Ditolak | ResiGudang</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class', theme: { extend: { colors: { primary: '#13ec37', dark: '#10221f' } } } }
    </script>
</head>
<body class="bg-dark text-white h-screen flex items-center justify-center overflow-hidden relative">
    <div class="absolute w-[500px] h-[500px] bg-orange-500/20 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="text-center relative z-10 px-6">
        <span class="material-symbols-rounded text-9xl text-orange-500 mb-4 drop-shadow-[0_0_30px_rgba(249,115,22,0.5)]">gpp_bad</span>
        <h1 class="text-7xl font-black mb-2 tracking-tight text-orange-500">403</h1>
        <h2 class="text-2xl font-bold text-white/80 mb-6">Hayo, Mau Ngintip Ya?</h2>
        <p class="text-sm text-white/50 max-w-md mx-auto mb-8 leading-relaxed">
            Lu gak punya hak akses buat buka halaman atau data ini Bos! Jangan iseng nyari celah ya, satpam kita galak.
        </p>
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white px-8 py-4 rounded-xl text-sm font-bold border border-white/10 transition-all">
            <span class="material-symbols-rounded">arrow_back</span> Balik Kanan Gerak!
        </a>
    </div>
</body>
</html>