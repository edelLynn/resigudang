<x-super-admin-layout>
    @section('title', 'Laporan Setoran 📄')
    @section('subtitle', 'Rekap data setoran kopi dan keuangan dari seluruh unit koperasi.')

    <div class="glass-card rounded-2xl overflow-hidden">
        
        <div class="px-6 py-5 border-b border-white/5 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex flex-wrap gap-4">
                <div class="text-center px-4 py-2 rounded-xl bg-white/5 border border-white/5">
                    <p class="text-[10px] text-white/40 uppercase">Total Transaksi</p>
                    <p class="text-lg font-black text-white">{{ $deposits->count() }} Data</p>
                </div>
                <div class="text-center px-4 py-2 rounded-xl bg-white/5 border border-white/5">
                    <p class="text-[10px] text-white/40 uppercase">Total Berat Disetujui</p>
                    <p class="text-lg font-black text-amber-500">
                        {{ number_format($deposits->whereNotIn('status', ['PENDING', 'REJECTED'])->sum(function($d) { return $d->weight_verified ?? $d->weight_input; }), 0, ',', '.') }} Kg
                    </p>
                </div>
                <div class="text-center px-4 py-2 rounded-xl bg-primary/10 border border-primary/20">
                    <p class="text-[10px] text-primary/60 uppercase font-bold">Total Uang Keluar</p>
                    <p class="text-lg font-black text-primary">
                        Rp {{ number_format($deposits->sum(function($d) { return ($d->total_dp_amount ?? 0) + ($d->total_final_amount ?? 0); }), 0, ',', '.') }}
                    </p>
                </div>
            </div>
            
            <button onclick="window.print()" class="px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-white text-sm font-bold flex items-center gap-2 transition-all">
                <span class="material-symbols-rounded">print</span> Print Laporan
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="text-xs uppercase text-white/40 bg-black/20 font-bold">
                    <tr>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Petani & Unit</th>
                        <th class="px-6 py-3">Data Kopi</th>
                        <th class="px-6 py-3 text-right">Berat (Kg)</th>
                        <th class="px-6 py-3 text-right">Keuangan (Rp)</th>
                        <th class="px-6 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($deposits as $d)
                    <tr class="hover:bg-white/5 transition-colors group">
                        <td class="px-6 py-4 font-mono text-white/60">
                            {{ \Carbon\Carbon::parse($d->deposit_date)->format('d/m/Y') }}
                            <div class="text-[10px] opacity-50">{{ $d->created_at->format('H:i') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-white">{{ $d->user->name ?? 'Unknown' }}</div>
                            <div class="text-xs text-white/50">{{ $d->user->email ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-primary">{{ $d->coffee_variant }}</span>
                            <span class="text-xs text-white/40 block">{{ $d->coffee_form }}</span>
                        </td>
                        <td class="px-6 py-4 text-right font-mono font-bold text-white text-lg">
                            {{ number_format($d->weight_verified ?? $d->weight_input, 0, ',', '.') }}
                        </td>
                        
                        <td class="px-6 py-4 text-right">
                            @php
                                $dp = $d->total_dp_amount ?? 0;
                                $final = $d->total_final_amount ?? 0;
                                $totalKeluar = $dp + $final;
                            @endphp

                            @if($totalKeluar > 0)
                                <div class="font-mono font-bold {{ $final > 0 ? 'text-primary' : 'text-emerald-400' }} text-lg tracking-tight">
                                    {{ number_format($totalKeluar, 0, ',', '.') }}
                                </div>
                                @if($final > 0)
                                    <span class="text-[10px] bg-primary/20 text-primary px-2 py-0.5 rounded font-bold uppercase">Total (Lunas)</span>
                                @else
                                    <span class="text-[10px] bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-2 py-0.5 rounded font-bold uppercase">Baru DP</span>
                                @endif
                            @else
                                <span class="text-white/30 italic text-xs">-</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-center">
                            @php
                                $badges = [
                                    'PENDING'       => ['bg' => 'bg-orange-500/10', 'text' => 'text-orange-500', 'border' => 'border-orange-500/20', 'label' => 'PENDING'],
                                    'VERIFIED'      => ['bg' => 'bg-blue-500/10', 'text' => 'text-blue-400', 'border' => 'border-blue-500/20', 'label' => 'GUDANG'],
                                    'PARTIAL_PAID'  => ['bg' => 'bg-emerald-500/10', 'text' => 'text-emerald-400', 'border' => 'border-emerald-500/20', 'label' => 'SUDAH DP'],
                                    'REQUEST_FINAL' => ['bg' => 'bg-purple-500/10', 'text' => 'text-purple-400', 'border' => 'border-purple-500/20', 'label' => 'REQ LUNAS'],
                                    'PAID_OFF'      => ['bg' => 'bg-primary/20', 'text' => 'text-primary', 'border' => 'border-primary/20', 'label' => 'LUNAS'],
                                    'REJECTED'      => ['bg' => 'bg-red-500/20', 'text' => 'text-red-500', 'border' => 'border-red-500/20', 'label' => 'DITOLAK'],
                                ];
                                $style = $badges[$d->status] ?? $badges['PENDING'];
                            @endphp

                            <span class="px-2 py-1 rounded text-[10px] font-bold {{ $style['bg'] }} {{ $style['text'] }} border {{ $style['border'] }}">
                                {{ $style['label'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2 opacity-100 transition-opacity">
                                <button 
                                    onclick="openDetailModal(this)"
                                    data-variant="{{ $d->coffee_variant }}"
                                    data-form="{{ $d->coffee_form }}"
                                    data-weight="{{ number_format($d->weight_verified ?? $d->weight_input, 0, ',', '.') }}"
                                    data-status="{{ $d->status }}"
                                    data-farmer="{{ $d->user->name ?? '-' }}"
                                    data-date="{{ \Carbon\Carbon::parse($d->deposit_date)->format('d F Y') }}"
                                    data-photo="{{ $d->photo_proof_path ? asset('storage/'.$d->photo_proof_path) : '' }}"
                                    data-note="{{ $d->notes ?? '-' }}"
                                    class="w-8 h-8 rounded-lg bg-blue-500/20 text-blue-400 hover:bg-blue-500 hover:text-white flex items-center justify-center transition-colors" 
                                    title="Lihat Detail">
                                    <span class="material-symbols-rounded text-lg">visibility</span>
                                </button>

                                <a href="{{ route('superadmin.reports.print', $d->id) }}" target="_blank" 
                                   class="w-8 h-8 rounded-lg bg-white/10 text-white/60 hover:bg-white hover:text-dark flex items-center justify-center transition-colors" title="Cetak Resi">
                                    <span class="material-symbols-rounded text-lg">print</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-white/30 italic">
                            Belum ada data setoran masuk.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="detailModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeDetailModal()"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-lg">
            <div class="glass-card p-6 rounded-2xl shadow-2xl border border-white/10 m-4">
                
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-white">Detail Setoran</h3>
                        <p class="text-xs text-white/40" id="modalDate">loading...</p>
                    </div>
                    <button onclick="closeDetailModal()" class="text-white/40 hover:text-white">
                        <span class="material-symbols-rounded">close</span>
                    </button>
                </div>

                <div class="space-y-4">
                    <div id="modalPhotoArea" class="hidden w-full h-48 bg-black/30 rounded-xl overflow-hidden mb-4 border border-white/5 relative group">
                        <img id="modalPhoto" src="" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <a id="modalPhotoLink" href="" target="_blank" class="px-4 py-2 bg-white text-dark rounded-lg text-xs font-bold">Lihat Full Size</a>
                        </div>
                    </div>
                    <div id="noPhoto" class="hidden w-full h-24 bg-white/5 rounded-xl flex items-center justify-center text-white/20 text-xs italic">
                        Tidak ada foto bukti
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-3 bg-white/5 rounded-xl">
                            <p class="text-[10px] text-white/40 uppercase">Nama Petani</p>
                            <p class="font-bold text-white" id="modalFarmer">-</p>
                        </div>
                        <div class="p-3 bg-white/5 rounded-xl">
                            <p class="text-[10px] text-white/40 uppercase">Status</p>
                            <p class="font-bold" id="modalStatus">-</p>
                        </div>
                        <div class="p-3 bg-white/5 rounded-xl">
                            <p class="text-[10px] text-white/40 uppercase">Jenis Kopi</p>
                            <p class="font-bold text-primary" id="modalCoffee">-</p>
                        </div>
                        <div class="p-3 bg-white/5 rounded-xl">
                            <p class="text-[10px] text-white/40 uppercase">Berat Bersih</p>
                            <p class="font-bold text-white text-lg" id="modalWeight">-</p>
                        </div>
                    </div>

                    <div class="p-3 bg-white/5 rounded-xl">
                        <p class="text-[10px] text-white/40 uppercase mb-1">Alamat Petani</p>
                        <p class="text-sm text-white/80 italic" id="modalNote">-</p>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-white/5 flex justify-end">
                    <button onclick="closeDetailModal()" class="px-6 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-sm transition-colors">
                        Tutup
                    </button>
                </div>

            </div>
        </div>
    </div>

    <script>
        function openDetailModal(button) {
            const data = button.dataset;

            document.getElementById('modalDate').innerText = data.date;
            document.getElementById('modalFarmer').innerText = data.farmer;
            document.getElementById('modalCoffee').innerText = data.variant + ' (' + data.form + ')';
            document.getElementById('modalWeight').innerText = data.weight + ' Kg';
            document.getElementById('modalNote').innerText = data.note !== '-' ? data.note : 'Tidak ada catatan tambahan.';

            const statusEl = document.getElementById('modalStatus');
            statusEl.innerText = data.status.replace('_', ' ');
            statusEl.className = 'font-bold'; 
            
            if(data.status === 'VERIFIED' || data.status === 'PAID_OFF' || data.status === 'PARTIAL_PAID') {
                statusEl.classList.add('text-primary');
            } else if(data.status === 'REJECTED') {
                statusEl.classList.add('text-red-500');
            } else if(data.status === 'REQUEST_FINAL') {
                statusEl.classList.add('text-purple-400');
            } else {
                statusEl.classList.add('text-orange-500');
            }

            const photoArea = document.getElementById('modalPhotoArea');
            const noPhoto = document.getElementById('noPhoto');
            
            if (data.photo && data.photo !== window.location.origin + '/storage/') {
                document.getElementById('modalPhoto').src = data.photo;
                document.getElementById('modalPhotoLink').href = data.photo;
                photoArea.classList.remove('hidden');
                noPhoto.classList.add('hidden');
            } else {
                photoArea.classList.add('hidden');
                noPhoto.classList.remove('hidden');
            }

            document.getElementById('detailModal').classList.remove('hidden');
        }

        function closeDetailModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }
    </script>
</x-super-admin-layout>