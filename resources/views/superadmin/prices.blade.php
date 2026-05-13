<x-super-admin-layout>
    @section('title', 'Kelola Harga & Grade Kopi')

    <div class="max-w-6xl mx-auto space-y-8">
        
        @if(session('success'))
        <div class="p-4 bg-primary/10 border border-primary/20 rounded-xl flex items-center gap-3 text-primary font-bold animate-pulse">
            <span class="material-symbols-rounded">check_circle</span>
            {{ session('success') }}
        </div>
        @endif

        @if ($errors->any())
        <div class="p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1">
                <div class="glass-card p-6 rounded-2xl relative overflow-hidden sticky top-6">
                    <div class="absolute top-0 right-0 p-4 opacity-10 pointer-events-none">
                        <span class="material-symbols-rounded text-8xl text-primary">add_business</span>
                    </div>
                    
                    <h3 class="text-lg font-black text-white mb-2 flex items-center gap-2">
                        <span class="material-symbols-rounded text-primary">edit_square</span> 
                        Input Harga / Grade
                    </h3>
                    <p class="text-xs text-white/40 mb-6">Tambah varian/grade baru, atau update harga yang sudah ada.</p>
                    
                    <form action="{{ route('superadmin.prices.store') }}" method="POST" class="space-y-4 relative z-10">
                        @csrf
                        
                        <div>
                            <label class="text-xs font-bold text-white/60 mb-1 block uppercase tracking-wider">Varian Kopi</label>
                            <input type="text" name="coffee_variant" placeholder="Contoh: Robusta, Arabica, Liberica..." required list="variantList"
                                   class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:border-primary outline-none transition-colors">
                            <datalist id="variantList">
                                <option value="Robusta">
                                <option value="Arabica">
                            </datalist>
                        </div>

                        <div>
                            <label class="text-xs font-bold text-white/60 mb-1 block uppercase tracking-wider">Grade / Kualitas</label>
                            <input type="text" name="grade" placeholder="Contoh: A, B, S, Premium..." required list="gradeList"
                                   class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:border-primary outline-none transition-colors uppercase">
                            <datalist id="gradeList">
                                <option value="A">
                                <option value="B">
                                <option value="C">
                            </datalist>
                        </div>

                        <div>
                            <label class="text-xs font-bold text-primary mb-1 block uppercase tracking-wider">Harga per Kg (Rp)</label>
                            <div class="relative">
                                <span class="absolute left-4 top-3 text-white/50 font-bold text-sm">Rp</span>
                                <input type="number" name="price" placeholder="0" required min="0"
                                       class="w-full bg-primary/5 border border-primary/30 rounded-xl pl-10 pr-4 py-3 text-lg font-black text-primary focus:border-primary outline-none transition-colors">
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-primary text-dark font-black text-sm px-6 py-4 rounded-xl hover:bg-[#0fd630] hover:scale-[1.02] transition-all shadow-[0_0_20px_rgba(19,236,55,0.3)] flex items-center justify-center gap-2 mt-4">
                            <span class="material-symbols-rounded">save</span> SIMPAN DATA
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="glass-card rounded-2xl overflow-hidden">
                    <div class="p-6 border-b border-white/5 flex items-center justify-between bg-black/20">
                        <h3 class="text-lg font-bold text-white">Daftar Harga & Grade Aktif</h3>
                        <span class="text-xs font-bold bg-white/10 text-white/60 px-3 py-1 rounded-full">{{ $prices->count() }} Data Aktif</span>
                    </div>
                    
                    <div class="overflow-x-auto min-h-[400px]">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-black/40 text-white/40 text-xs uppercase tracking-wider font-bold">
                                <tr>
                                    <th class="px-6 py-4">Jenis Kopi</th>
                                    <th class="px-6 py-4 text-center">Grade</th>
                                    <th class="px-6 py-4 text-right">Harga / Kg</th>
                                    <th class="px-6 py-4 text-center w-24">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @forelse($prices as $p)
                                <tr class="hover:bg-white/5 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg flex items-center justify-center font-bold text-xs
                                                {{ strtolower($p->coffee_variant) == 'robusta' ? 'bg-orange-500/20 text-orange-500' : 
                                                  (strtolower($p->coffee_variant) == 'arabica' ? 'bg-primary/20 text-primary' : 'bg-blue-500/20 text-blue-500') }}">
                                                <span class="material-symbols-rounded text-sm">coffee</span>
                                            </div>
                                            <span class="font-bold text-white">{{ $p->coffee_variant }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-3 py-1 bg-white/10 rounded-lg text-white font-bold text-xs uppercase">
                                            Grade {{ $p->grade }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-mono font-bold text-primary text-lg">
                                        Rp {{ number_format($p->price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('superadmin.prices.delete', $p->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus Grade ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-8 h-8 rounded-lg bg-red-500/10 text-red-500 flex items-center justify-center hover:bg-red-500 hover:text-white transition-all opacity-50 group-hover:opacity-100 mx-auto" title="Hapus Grade">
                                                <span class="material-symbols-rounded text-sm">delete</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-white/30 italic">
                                        <span class="material-symbols-rounded text-4xl mb-2 block">inventory_2</span>
                                        Belum ada data harga kopi. Silahkan input di sebelah kiri.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-super-admin-layout>