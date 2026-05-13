<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Gudang - Daftar Setoran Masuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Data Masuk Terbaru</h3>
                        <a href="{{ route('deposit.index') }}" class="text-sm text-blue-600 hover:text-blue-900">
                            🔄 Refresh Data
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 flex items-center shadow-sm">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                                ☕
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-bold uppercase">Stok Arabica</p>
                                <p class="text-2xl font-bold text-gray-800">
                                    {{ number_format($stok_arabica, 0, ',', '.') }} <span class="text-sm font-normal">Kg</span>
                                </p>
                            </div>
                        </div>

                        <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 flex items-center shadow-sm">
                            <div class="p-3 rounded-full bg-amber-100 text-amber-600 mr-4">
                                🟤
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-bold uppercase">Stok Robusta</p>
                                <p class="text-2xl font-bold text-gray-800">
                                    {{ number_format($stok_robusta, 0, ',', '.') }} <span class="text-sm font-normal">Kg</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Petani (ID)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Info Kopi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Berat Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bukti Foto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($deposits as $d)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($d->deposit_date)->format('d M Y') }}
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        User #{{ $d->farmer_id }}
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="text-gray-900 font-bold">{{ $d->coffee_variant }}</div>
                                        <div class="text-xs text-gray-500 bg-gray-100 inline-block px-2 rounded-full mt-1">
                                            {{ $d->coffee_form }}
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">
                                        {{ number_format($d->weight_kg, 0, ',', '.') }} Kg
                                        <div class="text-xs text-gray-400 font-normal mt-1">
                                            ({{ $d->bag_count }} Karung)
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($d->photo_proof_path)
                                            <a href="{{ asset('storage/' . $d->photo_proof_path) }}" target="_blank" class="group relative block w-12 h-12">
                                                <img src="{{ asset('storage/' . $d->photo_proof_path) }}" class="h-12 w-12 rounded object-cover border border-gray-300 group-hover:opacity-75" alt="Bukti">
                                                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 bg-black bg-opacity-30 rounded text-white text-xs">
                                                    🔍
                                                </div>
                                            </a>
                                        @else
                                            <span class="text-xs text-red-500">No Image</span>
                                        @endif
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($d->status == 'PENDING')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                                                ⏳ Menunggu
                                            </span>
                                        @elseif($d->status == 'VERIFIED')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 border border-green-200">
                                                ✅ Diterima
                                            </span>
                                        @else
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 border border-red-200">
                                                ❌ Ditolak
                                            </span>
                                        @endif
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @if($d->status == 'PENDING')
                                            <div class="flex space-x-2">
                                                
                                                <form action="{{ route('deposit.approve', $d->id) }}" method="POST" onsubmit="return confirm('Yakin terima setoran ini?');">
                                                    @csrf
                                                    <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded text-xs hover:bg-green-700 transition">
                                                        ✅ Terima
                                                    </button>
                                                </form>
                                                
                                                <form action="{{ route('deposit.reject', $d->id) }}" method="POST" onsubmit="return confirm('Yakin tolak setoran ini?');">
                                                    @csrf
                                                    <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-700 transition">
                                                        ❌ Tolak
                                                    </button>
                                                </form>

                                            </div>
                                        @else
                                            <span class="text-gray-400 text-xs italic">
                                                {{ $d->status == 'VERIFIED' ? 'Sudah Diterima' : 'Sudah Ditolak' }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                            </svg>
                                            <p>Belum ada data setoran yang masuk.</p>
                                        </div>
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
</x-app-layout> 