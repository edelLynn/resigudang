<x-landing-layout>
    <!-- {{-- NAVBAR --}}
    <nav class="absolute top-0 w-full z-50 border-b border-white/10">
        <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded bg-primary flex items-center justify-center text-background-dark">
                    <span class="material-symbols-outlined text-[20px]">warehouse</span>
                </div>
                <span class="text-xl font-bold tracking-tight">ResiGudang</span>
            </div>

            <div class="hidden md:flex items-center gap-8 text-sm font-medium">
                <a href="{{ url('/') }}" class="text-white/80 hover:text-white transition">Beranda</a>
                <a href="{{ route('about') }}" class="text-white/80 hover:text-white transition">Tentang Kami</a>
                <a href="{{ route('features') }}" class="text-white/80 hover:text-white transition">Fitur</a>
            </div>

            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('redirect') }}" class="text-white font-semibold hover:text-primary transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="bg-primary/20 border border-primary/50 text-primary px-5 py-2.5 rounded-lg font-bold backdrop-blur hover:bg-primary/30 transition"> Masuk</a>
                    {{--  <a href="{{ route('register') }}"
                       class="bg-primary/20 border border-primary/50 text-primary px-5 py-2.5 rounded-lg font-bold backdrop-blur hover:bg-primary/30 transition">
                        Daftar
                    </a>--}}
                @endauth
            </div>
        </div>
    </nav> -->

{{-- HERO SECTION --}}
    <header class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-background-dark/85 z-10"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-background-dark via-transparent to-transparent z-10"></div>
            
            @php
                $bgImage = !empty($content->hero_image) 
                    ? (Str::startsWith($content->hero_image, 'http') ? $content->hero_image : asset($content->hero_image)) 
                    : 'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?q=80&w=2070&auto=format&fit=crop';
            @endphp
            <div class="w-full h-full bg-cover bg-center" style="background-image:url('{{ $bgImage }}')"></div>
        </div>

        <div class="relative z-20 px-6 text-center max-w-4xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 backdrop-blur mb-8">
                <span class="material-symbols-outlined text-primary text-sm">eco</span>
                
                <span class="text-primary text-xs font-bold uppercase tracking-wider">
                    {{ $content->hero_subtitle ?? 'Solusi Petani Modern' }}
                </span>
            </div>

            <h1 class="text-4xl md:text-6xl lg:text-7xl font-black leading-[1.1] tracking-tight mb-6">
                @safeHtml($content->hero_title ?? 'Ubah Panen Kopi <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-leaf-green">Jadi Uang Tunai</span><br> Lebih Cepat')
            </h1>

            <p class="text-gray-300 text-lg md:text-xl max-w-2xl mx-auto mb-10">
                {{ $content->hero_text ?? 'Sistem resi gudang digital terpercaya. Simpan hasil panen Anda dengan aman dan dapatkan pembiayaan instan.' }}
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
            </div>
        </div>
    </header>

    {{-- STATS CARDS --}}
    <section class="-mt-24 relative z-30">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Stok Kopi --}}
            <div class="bg-[#1a2c29] p-8 rounded-xl border border-white/10 shadow-2xl">
                <div class="flex items-center gap-3 text-gray-400 mb-2">
                    <span class="material-symbols-outlined text-primary">inventory_2</span>
                    <span class="text-xs font-semibold uppercase tracking-wider">Kopi Disimpan</span>
                </div>
                <p class="text-3xl font-bold">11.050 Kg</p>
                <div class="w-full h-1.5 bg-gray-700 rounded-full mt-4">
                    <div class="h-full w-[85%] bg-primary rounded-full"></div>
                </div>
            </div>

            {{-- Total Petani --}}
            <div class="bg-[#1a2c29] p-8 rounded-xl border border-white/10 shadow-2xl text-white">
                <div class="flex items-center gap-3 text-gray-400 mb-2">
                    <span class="material-symbols-outlined text-leaf-green">groups</span>
                    <span class="text-xs font-semibold uppercase tracking-wider">Petani Mitra</span>
                </div>
                <p class="text-3xl font-bold">500+ Petani</p>
                <div class="flex -space-x-2 mt-4">
                    <div class="w-8 h-8 rounded-full border-2 border-[#1a2c29] bg-gray-500"></div>
                    <div class="w-8 h-8 rounded-full border-2 border-[#1a2c29] bg-gray-600 flex items-center justify-center text-[10px] font-bold">+497</div>
                </div>
            </div>

            {{-- Pencairan --}}
            <div class="bg-[#1a2c29] p-8 rounded-xl border border-white/10 shadow-2xl text-white">
                <div class="flex items-center gap-3 text-gray-400 mb-2">
                    <span class="material-symbols-outlined text-yellow-400">payments</span>
                    <span class="text-xs font-semibold uppercase tracking-wider">Pencairan Dana</span>
                </div>
                <p class="text-3xl font-bold">24 Jam</p>
                <p class="text-gray-400 text-sm mt-3 flex items-center gap-1">
                    <span class="material-symbols-outlined text-leaf-green text-sm">check_circle</span>
                    Langsung ke rekening
                </p>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="mt-24 border-t border-white/10 py-12">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">warehouse</span>
                <span class="text-xl font-bold">ResiGudang</span>
            </div>
            <div class="text-center md:text-right text-gray-500 text-xs">
                <p>© {{ date('Y') }} ResiGudang. All rights reserved.</p>
                <p class="mt-1 font-bold">Developed by <span class="text-primary tracking-widest uppercase">NHK IT</span></p>
            </div>
        </div>
    </footer>

    <!--Start of Tawk.to Script-->
        <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/69a551efa6900b1c2fa78453/1jimsg4lu';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
        })();
        </script>
    <!--End of Tawk.to Script-->
</x-landing-layout>