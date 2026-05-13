<x-super-admin-layout>
    @section('title', 'Kelola User & Admin 👥')
    @section('subtitle', 'Tambah Admin Koperasi baru atau kelola akun petani.')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-1">
            <div class="glass-card p-6 rounded-2xl sticky top-6">
                <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                    <span class="material-symbols-rounded text-primary">person_add</span> Tambah User Baru
                </h3>

                @if ($errors->any())
                    <div class="mb-4 p-3 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-xs font-bold">
                        ❌ Oops! Ada kesalahan:
                        <ul class="list-disc pl-4 mt-1 font-normal">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 p-3 rounded-xl bg-orange-500/10 border border-orange-500/20 text-orange-400 text-xs font-bold">
                        ⚠️ {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('superadmin.users.store') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label class="text-xs font-bold text-white/60 uppercase">Nama Lengkap</label>
                        <input type="text" name="name" required class="w-full mt-1 px-4 py-2 rounded-xl bg-white/5 border border-white/10 focus:border-primary focus:ring-1 focus:ring-primary text-white outline-none" placeholder="Contoh: Budi Admin">
                    </div>

                    <div>
                        <label class="text-xs font-bold text-white/60 uppercase">Email Login</label>
                        <input type="email" name="email" required class="w-full mt-1 px-4 py-2 rounded-xl bg-white/5 border border-white/10 focus:border-primary focus:ring-1 focus:ring-primary text-white outline-none" placeholder="email@resigudang.com">
                    </div>

                    <div>
                        <label class="text-xs font-bold text-white/60 uppercase">Jabatan / Role</label>
                        <select name="role" class="w-full mt-1 px-4 py-2 rounded-xl bg-white/5 border border-white/10 focus:border-primary focus:ring-1 focus:ring-primary text-white outline-none [&>option]:text-black">
                            <option value="admin_koperasi">👮 Admin Koperasi (Unit)</option>
                            <option value="petani">🌾 Petani</option>
                            <option value="admin_pt">🤴 Super Admin (PT)</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-xs font-bold text-white/60 uppercase">Password</label>
                        <input type="password" name="password" required class="w-full mt-1 px-4 py-2 rounded-xl bg-white/5 border border-white/10 focus:border-primary focus:ring-1 focus:ring-primary text-white outline-none" placeholder="Minimal 6 karakter">
                    </div>

                    <button type="submit" class="w-full py-3 rounded-xl bg-primary text-dark font-bold hover:bg-[#11d632] transition-all shadow-[0_0_15px_rgba(19,236,55,0.3)]">
                        + Simpan User
                    </button>
                </form>

                @if(session('success'))
                    <div class="mt-4 p-3 rounded-xl bg-primary/10 border border-primary/20 text-primary text-xs font-bold">
                        ✅ {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="glass-card rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-white/5 bg-white/5 flex justify-between items-center">
                    <h3 class="font-bold">Daftar Pengguna Aktif</h3>
                    <span class="text-xs text-white/40">{{ $users->count() }} User Terdaftar</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="text-xs uppercase text-white/40 bg-black/20 font-bold">
                            <tr>
                                <th class="px-6 py-3">User Info</th>
                                <th class="px-6 py-3">Role</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach($users as $user)
                            <tr class="hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-white">{{ $user->name }}</div>
                                    <div class="text-xs text-white/50">{{ $user->email }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($user->role == 'admin_koperasi')
                                        <span class="px-2 py-1 rounded text-[10px] font-bold bg-purple-500/20 text-purple-400 border border-purple-500/20">ADMIN UNIT</span>
                                    @elseif($user->role == 'petani')
                                        <span class="px-2 py-1 rounded text-[10px] font-bold bg-green-500/20 text-green-400 border border-green-500/20">PETANI</span>
                                    @else
                                        <span class="px-2 py-1 rounded text-[10px] font-bold bg-blue-500/20 text-blue-400 border border-blue-500/20">SUPER ADMIN</span>
                                    @endif
                                </td>
                                
                                <td class="px-6 py-4">
                                    @if($user->status === 'pending')
                                        <span class="flex items-center gap-1 text-xs text-orange-400 font-bold bg-orange-500/10 px-2 py-1 rounded w-fit border border-orange-500/20">
                                            <span class="material-symbols-rounded text-[14px]">schedule</span> Pending
                                        </span>
                                    @else
                                        <span class="flex items-center gap-1 text-xs text-primary font-bold bg-primary/10 px-2 py-1 rounded w-fit border border-primary/20">
                                            <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span> Active
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <form action="{{ route('superadmin.users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus user ini? Data setoran dia bakal ilang loh!');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white transition-all" title="Hapus User">
                                            <span class="material-symbols-rounded text-lg">delete</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</x-super-admin-layout>