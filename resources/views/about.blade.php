<x-landing-layout>
    @push('styles')
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        body { background-color: #10221f !important; }
    </style>
    @endpush

    <div class="min-h-screen text-white font-display antialiased">
        {{-- NAVBAR SAMA FOOTER UDAH DIHAPUS, BIAR INDUKNYA AJA YANG NAMPILIN --}}

        {{-- CONTENT --}}
        <main class="pt-32 pb-20 px-6">
            <div class="max-w-4xl mx-auto">
                {{-- Vision Section --}}
                <div class="mb-16">
                    <h1 class="text-4xl md:text-5xl font-black mb-6 tracking-tight">
                        {{ $content->about_title ?? 'Tentang Kami' }}
                    </h1>
                    <p class="text-gray-400 text-lg leading-relaxed mb-8">
                        {{ $content->about_text ?? 'Deskripsi tentang perusahaan kami.' }}
                    </p>
                </div>
                {{-- Efficiency Focus --}}
                <div class="grid md:grid-cols-2 gap-12 mb-20">
                    <div class="space-y-4">
                        <div class="w-12 h-12 rounded-lg bg-primary/20 flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined">precision_manufacturing</span>
                        </div>
                        <h3 class="text-xl font-bold">{{ $content->about_val1_title ?? 'Teknologi Rekayasa' }}</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">
                            {{ $content->about_val1_text ?? 'Dibangun dengan standar rekayasa teknologi modern, kami fokus pada pengurangan waste...' }}
                        </p>
                    </div>
                    <div class="space-y-4">
                        <div class="w-12 h-12 rounded-lg bg-leaf-green/20 flex items-center justify-center text-leaf-green">
                            <span class="material-symbols-outlined">security</span>
                        </div>
                        <h3 class="text-xl font-bold">{{ $content->about_val2_title ?? 'Keamanan Terjamin' }}</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">
                            {{ $content->about_val2_text ?? 'Melalui sistem audit yang ketat, setiap butir kopi yang disimpan di gudang...' }}
                        </p>
                    </div>
                </div>

                {{-- CTA Section --}}
                <div class="bg-gradient-to-r from-background-dark to-[#1a2c29] p-8 md:p-12 rounded-3xl border border-white/5 text-center relative z-20">
                    <h2 class="text-2xl md:text-3xl font-bold mb-4">{{ $content->about_cta_title ?? 'Ingin berkolaborasi atau bertanya lebih lanjut?' }}</h2>
                    <p class="text-gray-400 mb-8 max-w-xl mx-auto">{{ $content->about_cta_text ?? 'Tim kami siap membantu Anda memahami bagaimana sistem resi gudang digital...' }}</p>
                    
                    <button type="button" onclick="document.getElementById('contactModal').classList.remove('hidden'); document.getElementById('contactModal').classList.add('flex')" 
                            class="inline-flex items-center gap-2 bg-primary text-background-dark px-8 py-4 rounded-xl font-bold hover:bg-[#0bcba8] transition cursor-pointer">
                        Hubungi Kami <span class="material-symbols-outlined">mail</span>
                    </button>
                </div>

                <div id="contactModal" class="fixed inset-0 z-[100] hidden items-center justify-center">
                    <div class="absolute inset-0 bg-black/80 backdrop-blur-sm cursor-pointer" 
                         onclick="document.getElementById('contactModal').classList.add('hidden'); document.getElementById('contactModal').classList.remove('flex')"></div>
                    
                    <div class="relative bg-[#1a2c29] border border-white/10 p-8 rounded-3xl w-full max-w-md mx-4 shadow-2xl z-50">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-2xl font-bold text-white flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary">send</span> Kirim Pesan
                            </h3>
                            <button type="button" onclick="document.getElementById('contactModal').classList.add('hidden'); document.getElementById('contactModal').classList.remove('flex')" 
                                    class="text-white/40 hover:text-white transition cursor-pointer">
                                <span class="material-symbols-outlined">close</span>
                            </button>
                        </div>

                        <form action="/contact/send" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-white/60 uppercase mb-2">Nama Lengkap</label>
                                <input type="text" name="name" required placeholder="Masukkan nama Anda" 
                                       class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:border-primary outline-none transition-colors">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-white/60 uppercase mb-2">Email Anda</label>
                                <input type="email" name="email" required placeholder="nama@email.com" 
                                       class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:border-primary outline-none transition-colors">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-white/60 uppercase mb-2">Pesan & Pertanyaan</label>
                                <textarea name="message" rows="4" required placeholder="Tuliskan pesan Anda di sini..." 
                                          class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:border-primary outline-none transition-colors"></textarea>
                            </div>
                            
                            <button type="submit" class="w-full bg-primary text-background-dark font-black py-4 rounded-xl hover:bg-[#0bcba8] transition-all shadow-[0_0_20px_rgba(19,236,55,0.2)] mt-2">
                                KIRIM SEKARANG
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    @if(session('success_contact'))
        <script>
            alert("{{ session('success_contact') }}");
        </script>
    @endif
    
</x-landing-layout>