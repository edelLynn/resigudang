<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'ResiGudang – Digital Coffee Warehousing' }}</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">

    {{-- Fonts & Icons --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700&display=swap" rel="stylesheet">

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#0cedc4',
                        'leaf-green': '#13ec37',
                        'background-dark': '#10221f',
                    },
                    fontFamily: {
                        display: ['Inter', 'sans-serif'],
                    },
                },
            },
        }
    </script>

    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        
        /* ======================================================== */
        /* 🔥 ILMU HITAM LEVEL 99: MUSNAHKAN UI GOOGLE TRANSLATE 🔥 */
        /* ======================================================== */
        
        /* 1. Sembunyikan paksa Iframe Banner Putih di Atas */
        .goog-te-banner-frame.skiptranslate, 
        iframe.goog-te-banner-frame { 
            display: none !important; 
        }
        
        /* 2. Sembunyikan elemen bawaan Google yang nyelip di Body */
        body > .skiptranslate {
            display: none !important;
        }
        
        /* 3. Paksa body gak turun ke bawah (Google suka inject top: 40px) */
        body { 
            top: 0px !important; 
            position: static !important; 
        }
        
        /* 4. Sembunyikan Pop-up / Tooltip "Teks Asli" saat di-hover */
        #goog-gt-tt, 
        .goog-te-balloon-frame { 
            display: none !important; 
        }
        
        /* 5. Hilangkan blok highlight warna kuning norak dari Google */
        .goog-text-highlight { 
            background: transparent !important; 
            background-color: transparent !important; 
            box-shadow: none !important; 
        }
    </style>
</head>

<body class="bg-[#10221f] text-white font-display antialiased overflow-x-hidden relative">
    
    {{-- NAVBAR GLOBAL --}}
    <nav class="absolute top-0 w-full z-50 border-b border-white/10">
        <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">
            
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded bg-leaf-green flex items-center justify-center text-background-dark">
                    <span class="material-symbols-outlined text-[20px]">warehouse</span>
                </div>
                <span class="text-xl font-bold tracking-tight">ResiGudang</span>
            </div>
            
            <div class="hidden md:flex items-center gap-8 text-sm font-medium">
                <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'text-primary' : 'text-white/80 hover:text-white' }} transition">Beranda</a>
                <a href="{{ route('about') }}" class="{{ request()->is('tentang-kami') ? 'text-primary' : 'text-white/80 hover:text-white' }} transition">Tentang Kami</a>
                <a href="{{ route('features') }}" class="{{ request()->is('fitur') ? 'text-primary' : 'text-white/80 hover:text-white' }} transition">Fitur</a>
            </div>
            
            <div class="flex items-center gap-6">
                
                <div class="relative group">
                    <button class="flex items-center gap-1 text-white/80 hover:text-white transition cursor-pointer text-sm font-bold pb-1">
                        <span id="active-flag">🇮🇩 ID</span>
                        <span class="material-symbols-outlined text-[18px]">expand_more</span>
                    </button>
                    <div class="absolute right-0 top-full mt-1 hidden group-hover:block w-24 bg-[#1a2c29] border border-white/10 rounded-xl shadow-2xl overflow-hidden z-[100]">
                        <button onclick="switchLang('id')" class="w-full text-left block px-4 py-3 text-sm text-white/70 hover:bg-white/10 hover:text-white transition font-bold border-b border-white/5">🇮🇩 IND</button>
                        <button onclick="switchLang('en')" class="w-full text-left block px-4 py-3 text-sm text-white/70 hover:bg-white/10 hover:text-white transition font-bold">🇬🇧 ENG</button>
                    </div>
                </div>

                <a href="{{ route('login') }}" class="text-white font-semibold hover:text-background-dark hover:bg-primary transition border border-primary px-5 py-2 rounded-xl">Masuk</a>
            </div>

        </div>
    </nav>

    {{-- Slot untuk konten --}}
    {{ $slot }}

    <div style="display: none !important; visibility: hidden !important; width: 0px; height: 0px; overflow: hidden; position: absolute; z-index: -99999;">
        <div id="google_translate_element"></div>
    </div>
    
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'id', 
                includedLanguages: 'id,en',
                autoDisplay: false
            }, 'google_translate_element');
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let cookieMatch = document.cookie.match(/(?:^|;)\s*googtrans=([^;]*)/);
            let currentLang = cookieMatch ? cookieMatch[1].split('/')[2] : 'id';
            
            if (currentLang === 'en') {
                document.getElementById('active-flag').innerText = '🇬🇧 EN';
            } else {
                document.getElementById('active-flag').innerText = '🇮🇩 ID';
            }
        });

        function switchLang(lang) {
            document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; domain=." + document.domain + "; path=/;";
            
            document.cookie = `googtrans=/id/${lang}; path=/`;
            document.cookie = `googtrans=/id/${lang}; domain=.${location.hostname}; path=/`;
            
            location.reload();
        }
    </script>

</body>
</html>