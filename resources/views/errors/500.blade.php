<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>500 - Server Pusing | ResiGudang</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class', theme: { extend: { colors: { primary: '#13ec37', dark: '#10221f' } } } }
    </script>
</head>
<body class="bg-dark text-white h-screen flex items-center justify-center overflow-hidden relative">
    <div class="absolute w-[500px] h-[500px] bg-red-500/20 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="text-center relative z-10 px-6">
        <span class="material-symbols-rounded text-9xl text-red-500 mb-4 drop-shadow-[0_0_30px_rgba(239,68,68,0.5)]">dns</span>
        <h1 class="text-7xl font-black mb-2 tracking-tight text-red-500">500</h1>
        <h2 class="text-2xl font-bold text-white/80 mb-6">Waduh, Servernya Lagi Ngambek!</h2>
        <p class="text-sm text-white/50 max-w-md mx-auto mb-8 leading-relaxed">
            Tenang, data lu aman kok. Cuma mesin kita lagi agak pusing dikit. Coba refresh lagi beberapa saat ya.
        </p>
        <button onclick="window.location.reload()" class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white px-8 py-4 rounded-xl text-sm font-bold border border-white/10 transition-all">
            <span class="material-symbols-rounded">refresh</span> Coba Refresh
        </button>
    </div>
</body>
</html>