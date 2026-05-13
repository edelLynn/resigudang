<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>419 - Sesi Habis | ResiGudang</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class', theme: { extend: { colors: { primary: '#13ec37', dark: '#10221f' } } } }
    </script>
</head>
<body class="bg-dark text-white h-screen flex items-center justify-center overflow-hidden relative">
    <div class="absolute w-[500px] h-[500px] bg-blue-500/20 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="text-center relative z-10 px-6">
        <span class="material-symbols-rounded text-9xl text-blue-500 mb-4 drop-shadow-[0_0_30px_rgba(59,130,246,0.5)]">hourglass_disabled</span>
        <h1 class="text-7xl font-black mb-2 tracking-tight text-blue-500">419</h1>
        <h2 class="text-2xl font-bold text-white/80 mb-6">Waduh, Sesi Lu Habis Bos!</h2>
        <p class="text-sm text-white/50 max-w-md mx-auto mb-8 leading-relaxed">
            Kelamaan ditinggal ngopi nih kayaknya. Form yang lu isi udah kedaluwarsa demi keamanan.
        </p>
        <button onclick="window.history.back()" class="inline-flex items-center gap-2 bg-blue-500/20 text-blue-400 hover:bg-blue-500 hover:text-white px-8 py-4 rounded-xl text-sm font-bold transition-all">
            <span class="material-symbols-rounded">refresh</span> Kembali & Coba Lagi
        </button>
    </div>
</body>
</html>