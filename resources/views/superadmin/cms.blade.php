<x-super-admin-layout>
    @section('title', 'CMS Landing Page')

    <div class="max-w-5xl mx-auto space-y-8">
        
        @if(session('success'))
        <div class="p-4 bg-primary/10 border border-primary/20 rounded-xl flex items-center gap-3 text-primary font-bold animate-pulse">
            <span class="material-symbols-rounded">check_circle</span>
            {{ session('success') }}
        </div>
        @endif

        <div class="glass-card p-8 rounded-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 p-4 opacity-10 pointer-events-none">
                <span class="material-symbols-rounded text-9xl text-primary">web</span>
            </div>
            
            <h3 class="text-2xl font-black text-white mb-2 flex items-center gap-2">
                <span class="material-symbols-rounded text-primary">edit_document</span> 
                Edit Halaman Depan
            </h3>
            <p class="text-sm text-white/40 mb-8">Ubah teks dan gambar background yang dilihat pengunjung di halaman utama.</p>
            
            <form action="{{ route('superadmin.cms.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6 relative z-10">
                @csrf
                
                <h4 class="text-lg font-bold text-white mb-4 flex items-center gap-2 border-b border-white/10 pb-2">
                    <span class="material-symbols-rounded text-primary">home</span> Bagian "Beranda / Hero"
                </h4>

                <div>
                    <label class="text-xs font-bold text-white/60 mb-2 block uppercase tracking-wider">Teks Kecil (Subtitle)</label>
                    <input type="text" name="hero_subtitle" value="{{ $content->hero_subtitle }}" required
                           class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:border-primary outline-none transition-colors">
                </div>

                <div>
                    <label class="text-xs font-bold text-white/60 mb-2 block uppercase tracking-wider">Judul Utama (HTML Dibolehkan)</label>
                    <textarea name="hero_title" rows="3" required
                              class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:border-primary outline-none transition-colors">{{ $content->hero_title }}</textarea>
                    <p class="text-[10px] text-white/40 mt-1">*Gunakan tag &lt;br&gt; untuk enter baris.</p>
                </div>

                <div>
                    <label class="text-xs font-bold text-white/60 mb-2 block uppercase tracking-wider">Teks Deskripsi</label>
                    <textarea name="hero_text" rows="3" required
                              class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:border-primary outline-none transition-colors">{{ $content->hero_text }}</textarea>
                </div>

                <div class="bg-black/20 p-4 rounded-xl border border-white/5">
                    <label class="text-xs font-bold text-primary mb-2 block uppercase tracking-wider">Gambar Background (Opsional)</label>
                    
                    @if($content->hero_image)
                    <div class="mb-4">
                        <p class="text-xs text-white/40 mb-2">Background Saat Ini:</p>
                        <img src="{{ Str::startsWith($content->hero_image, 'http') ? $content->hero_image : asset($content->hero_image) }}" class="h-32 rounded-lg object-cover border border-white/10">
                    </div>
                    @endif

                    <input type="file" name="hero_image" accept="image/*"
                           class="w-full text-sm text-white/50 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-primary/20 file:text-primary hover:file:bg-primary/30 transition-colors cursor-pointer">
                    <p class="text-[10px] text-white/40 mt-2">*Biarkan kosong jika tidak ingin mengganti gambar. Maks 5MB.</p>
                </div>

                <div class="h-px bg-white/10 w-full my-8"></div>

                <h4 class="text-lg font-bold text-white mb-4 flex items-center gap-2 border-b border-white/10 pb-2">
                    <span class="material-symbols-rounded text-primary">info</span> Bagian "Tentang Kami"
                </h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-bold text-white/60 mb-2 block uppercase">Judul Tentang Kami</label>
                        <input type="text" name="about_title" value="{{ $content->about_title ?? 'Tentang ResiGudang' }}" 
                               class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:border-primary outline-none">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-white/60 mb-2 block uppercase">Isi Deskripsi Tentang Kami</label>
                        <textarea name="about_text" rows="3" 
                                  class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:border-primary outline-none">{{ $content->about_text ?? 'Kami adalah platform modern untuk petani dan pengusaha kopi...' }}</textarea>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div class="bg-black/20 p-4 rounded-xl border border-white/5">
                        <label class="text-xs font-bold text-primary mb-2 block uppercase">Sub-Poin 1 (Judul)</label>
                        <input type="text" name="about_val1_title" value="{{ $content->about_val1_title ?? 'Teknologi Rekayasa' }}" class="w-full bg-black/40 border border-white/10 rounded-lg px-3 py-2 text-sm text-white mb-3 focus:border-primary outline-none">
                        
                        <label class="text-xs font-bold text-white/60 mb-2 block uppercase">Sub-Poin 1 (Teks)</label>
                        <textarea name="about_val1_text" rows="3" class="w-full bg-black/40 border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:border-primary outline-none">{{ $content->about_val1_text ?? 'Dibangun dengan standar rekayasa teknologi modern...' }}</textarea>
                    </div>
                    
                    <div class="bg-black/20 p-4 rounded-xl border border-white/5">
                        <label class="text-xs font-bold text-primary mb-2 block uppercase">Sub-Poin 2 (Judul)</label>
                        <input type="text" name="about_val2_title" value="{{ $content->about_val2_title ?? 'Keamanan Terjamin' }}" class="w-full bg-black/40 border border-white/10 rounded-lg px-3 py-2 text-sm text-white mb-3 focus:border-primary outline-none">
                        
                        <label class="text-xs font-bold text-white/60 mb-2 block uppercase">Sub-Poin 2 (Teks)</label>
                        <textarea name="about_val2_text" rows="3" class="w-full bg-black/40 border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:border-primary outline-none">{{ $content->about_val2_text ?? 'Melalui sistem audit yang ketat...' }}</textarea>
                    </div>
                </div>

                <div class="bg-black/20 p-4 rounded-xl border border-white/5 mt-4">
                    <label class="text-xs font-bold text-primary mb-2 block uppercase">Kotak Bawah (Judul CTA)</label>
                    <input type="text" name="about_cta_title" value="{{ $content->about_cta_title ?? 'Ingin berkolaborasi atau bertanya lebih lanjut?' }}" class="w-full bg-black/40 border border-white/10 rounded-lg px-3 py-2 text-sm text-white mb-3 focus:border-primary outline-none">
                    
                    <label class="text-xs font-bold text-white/60 mb-2 block uppercase">Kotak Bawah (Teks CTA)</label>
                    <textarea name="about_cta_text" rows="2" class="w-full bg-black/40 border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:border-primary outline-none">{{ $content->about_cta_text ?? 'Tim kami siap membantu Anda memahami bagaimana sistem...' }}</textarea>
                </div>

                <div class="h-px bg-white/10 w-full my-8"></div>

                <h4 class="text-lg font-bold text-white mb-4 flex items-center gap-2 border-b border-white/10 pb-2">
                    <span class="material-symbols-rounded text-primary">star</span> Bagian "Fitur Unggulan"
                </h4>

                <div class="bg-black/20 p-4 rounded-xl border border-white/5 mb-6">
                    <label class="text-xs font-bold text-primary mb-2 block uppercase">Judul Utama Halaman Fitur (HTML Dibolehkan)</label>
                    <input type="text" name="features_header_title" value="{{ $content->features_header_title ?? 'Fitur <span class=\'text-primary\'>Ekosistem</span> Digital' }}" class="w-full bg-black/40 border border-white/10 rounded-lg px-3 py-2 text-sm text-white mb-3 focus:border-primary outline-none">
                    
                    <label class="text-xs font-bold text-white/60 mb-2 block uppercase">Sub-Judul Halaman Fitur</label>
                    <textarea name="features_header_subtitle" rows="2" class="w-full bg-black/40 border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:border-primary outline-none">{{ $content->features_header_subtitle ?? 'Dirancang dengan prinsip efisiensi industri untuk memaksimalkan...' }}</textarea>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-black/20 p-4 rounded-xl border border-white/5">
                        <label class="text-xs font-bold text-primary mb-2 block uppercase">Fitur 1 (Judul)</label>
                        <input type="text" name="feature_1_title" value="{{ $content->feature_1_title ?? 'Keamanan Terjamin' }}" class="w-full bg-black/40 border border-white/10 rounded-lg px-3 py-2 text-sm text-white mb-3 focus:border-primary outline-none">
                        
                        <label class="text-xs font-bold text-white/60 mb-2 block uppercase">Fitur 1 (Deskripsi)</label>
                        <textarea name="feature_1_text" rows="3" class="w-full bg-black/40 border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:border-primary outline-none">{{ $content->feature_1_text ?? 'Gudang bersertifikat dan diawasi ketat selama 24 jam.' }}</textarea>
                    </div>

                    <div class="bg-black/20 p-4 rounded-xl border border-white/5">
                        <label class="text-xs font-bold text-primary mb-2 block uppercase">Fitur 2 (Judul)</label>
                        <input type="text" name="feature_2_title" value="{{ $content->feature_2_title ?? 'Pencairan Cepat' }}" class="w-full bg-black/40 border border-white/10 rounded-lg px-3 py-2 text-sm text-white mb-3 focus:border-primary outline-none">
                        
                        <label class="text-xs font-bold text-white/60 mb-2 block uppercase">Fitur 2 (Deskripsi)</label>
                        <textarea name="feature_2_text" rows="3" class="w-full bg-black/40 border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:border-primary outline-none">{{ $content->feature_2_text ?? 'Dana langsung cair ke rekening Anda dalam hitungan jam.' }}</textarea>
                    </div>

                    <div class="bg-black/20 p-4 rounded-xl border border-white/5">
                        <label class="text-xs font-bold text-primary mb-2 block uppercase">Fitur 3 (Judul)</label>
                        <input type="text" name="feature_3_title" value="{{ $content->feature_3_title ?? 'Harga Transparan' }}" class="w-full bg-black/40 border border-white/10 rounded-lg px-3 py-2 text-sm text-white mb-3 focus:border-primary outline-none">
                        
                        <label class="text-xs font-bold text-white/60 mb-2 block uppercase">Fitur 3 (Deskripsi)</label>
                        <textarea name="feature_3_text" rows="3" class="w-full bg-black/40 border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:border-primary outline-none">{{ $content->feature_3_text ?? 'Ikuti harga pasar kopi terbaru dan transparan setiap hari.' }}</textarea>
                    </div>
                </div>

                <div class="pt-8 mt-4 border-t border-white/5">
                    <button type="submit" class="w-full bg-primary text-dark font-black text-sm px-6 py-4 rounded-xl hover:bg-[#0fd630] transition-all shadow-[0_0_20px_rgba(19,236,55,0.3)] flex items-center justify-center gap-2">
                        <span class="material-symbols-rounded">publish</span> UPDATE SEMUA KONTEN
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-super-admin-layout>