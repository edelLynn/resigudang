<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Input Setoran Kopi - Admin Unit</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0" rel="stylesheet"/>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: { primary: '#13ec37', dark: '#10221f', surface: '#162e26' },
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        body { background-color: #10221f; font-family: 'Inter', sans-serif; }
        .glass-card {
            background: rgba(22, 46, 38, 0.5);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
        }
        input, select, textarea {
            background-color: #112214 !important; 
            border-color: rgba(255,255,255,0.1) !important; 
            color: white !important;
        }
        input:focus, select:focus, textarea:focus {
            border-color: #13ec37 !important; 
            box-shadow: 0 0 0 1px #13ec37 !important; 
            outline: none;
        }
        ::-webkit-calendar-picker-indicator { filter: invert(1); opacity: 0.6; cursor: pointer; }

        /* 🔥 CUSTOM SELECT2 DARK MODE 🔥 */
        .select2-container--default .select2-selection--single {
            background-color: #112214 !important;
            border: 1px solid rgba(255,255,255,0.1) !important;
            border-radius: 0.75rem !important;
            height: 46px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: white !important;
            line-height: 46px !important;
            padding-left: 1rem !important;
            font-weight: 700 !important;
            font-size: 0.875rem !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 46px !important;
            right: 10px !important;
        }
        .select2-dropdown {
            background-color: #162e26 !important;
            border: 1px solid rgba(255,255,255,0.1) !important;
            border-radius: 0.75rem !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5) !important;
            overflow: hidden;
        }
        .select2-search--dropdown .select2-search__field {
            background-color: #112214 !important;
            color: white !important;
            border: 1px solid rgba(255,255,255,0.1) !important;
            border-radius: 0.5rem !important;
            padding: 8px !important;
        }
        .select2-results__option {
            color: rgba(255,255,255,0.7) !important;
            font-size: 0.875rem !important;
        }
        .select2-results__option--highlighted[aria-selected],
        .select2-results__option[aria-selected=true] {
            background-color: #13ec37 !important;
            color: #10221f !important;
            font-weight: bold !important;
        }
    </style>
</head>
<body class="text-white h-screen flex overflow-hidden">

    <aside class="w-64 flex flex-col border-r border-white/5 bg-[#112214]/50 backdrop-blur-xl relative z-20 shrink-0">
        <div class="p-6 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center shadow-lg">
                <span class="material-symbols-rounded text-white font-bold text-xl">admin_panel_settings</span>
            </div>
            <div>
                <h1 class="text-lg font-bold tracking-tight">ResiGudang</h1>
                <p class="text-xs text-white/40 font-medium">Admin Unit</p>
            </div>
        </div>

        <nav class="flex-1 px-4 py-4 space-y-2">
            <a href="{{ route('koperasi.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/60 hover:bg-white/5 hover:text-white transition-all">
                <span class="material-symbols-rounded">dashboard</span>
                <span class="text-sm font-medium">Dashboard</span>
            </a>
            
            <a href="{{ route('koperasi.deposits.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-primary/10 text-primary border border-primary/20 shadow-[0_0_15px_rgba(19,236,55,0.1)] transition-all">
                <span class="material-symbols-rounded">add_circle</span>
                <span class="text-sm font-bold">Setor kopi</span>
            </a>

            <a href="{{ route('koperasi.inventory.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/60 hover:bg-white/5 hover:text-white transition-all">
                <span class="material-symbols-rounded">inventory_2</span>
                <span class="text-sm font-medium">Warehouse Stock</span>
            </a>
            <a href="{{ route('koperasi.history') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/60 hover:bg-white/5 hover:text-white transition-all">
                <span class="material-symbols-rounded">receipt_long</span>
                <span class="text-sm font-medium">History</span>
            </a>
        </nav>
    </aside>

    <main class="flex-1 flex flex-col relative h-full overflow-hidden w-full bg-[#10221f]">
        <div class="absolute top-[-20%] right-[-10%] w-[600px] h-[600px] bg-primary/5 rounded-full blur-[120px] pointer-events-none"></div>

        <header class="h-20 px-8 flex items-center justify-between border-b border-white/5 bg-dark/80 backdrop-blur-md z-10 shrink-0">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-white">Input Baru</h2>
                <p class="text-white/40 text-xs">Catat setoran kopi dari petani hari ini.</p>
            </div>
            <a href="{{ route('koperasi.dashboard') }}" class="text-sm text-white/50 hover:text-white flex items-center gap-2 transition-colors">
                <span class="material-symbols-rounded text-lg">arrow_back</span> Kembali ke Dashboard
            </a>
        </header>

        <div class="flex-1 overflow-y-auto p-8">
            <div class="max-w-4xl mx-auto glass-card rounded-2xl p-8 shadow-2xl">
                
                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm">
                        <div class="flex items-center gap-2 mb-2 font-bold">
                            <span class="material-symbols-rounded">warning</span> Cek Kembali Inputan:
                        </div>
                        <ul class="list-disc pl-8 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('koperasi.deposits.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-white/70 block mb-1 uppercase tracking-wider text-[10px]">Pilih Petani</label>
                            
                            <select name="user_id" id="select-petani" class="w-full" required>
                                <option value="" disabled selected></option>
                                @foreach($petani as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->email }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-bold text-white/70 block mb-1 uppercase tracking-wider text-[10px]">Tanggal Setoran</label>
                            <input type="date" name="deposit_date" value="{{ date('Y-m-d') }}" class="w-full px-4 py-3 rounded-xl text-sm" required>
                        </div>
                    </div>

                    <div class="h-px bg-white/5 w-full mb-6"></div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-white/70 block mb-1 uppercase tracking-wider text-[10px]">Varian Kopi</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="cursor-pointer relative group">
                                    <input type="radio" name="coffee_variant" value="Robusta" class="peer sr-only" required onchange="updatePrice()">
                                    <div class="p-3 rounded-xl border border-white/10 bg-black/20 peer-checked:border-orange-500 peer-checked:bg-orange-500/10 hover:bg-white/5 transition-all text-center">
                                        <span class="font-bold text-white peer-checked:text-orange-400 text-sm">🟤 Robusta</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer relative group">
                                    <input type="radio" name="coffee_variant" value="Arabica" class="peer sr-only" onchange="updatePrice()">
                                    <div class="p-3 rounded-xl border border-white/10 bg-black/20 peer-checked:border-primary peer-checked:bg-primary/10 hover:bg-white/5 transition-all text-center">
                                        <span class="font-bold text-white peer-checked:text-primary text-sm">🟢 Arabica</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-bold text-white/70 block mb-1 uppercase tracking-wider text-[10px]">Kualitas (Grade)</label>
                            <div class="relative">
                                <select name="grade" id="gradeSelect" class="w-full px-4 py-3 rounded-xl appearance-none text-sm font-bold" required onchange="updatePrice()">
                                    <option value="" disabled selected>-- Pilih Grade --</option>
                                    @foreach($grades as $grade)
                                        <option value="{{ $grade }}">Grade {{ $grade }}</option>
                                    @endforeach
                                </select>
                                <span class="material-symbols-rounded absolute right-4 top-3 text-white/50 pointer-events-none">expand_more</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div>
                            <label class="text-xs font-bold text-white/60 mb-1 block uppercase tracking-wider">Bentuk Fisik</label>
                            
                            <input type="text" name="coffee_form" placeholder="Contoh: Greenbean, Cherry, Wine..." required list="bentukFisikList"
                                class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                            
                            <datalist id="bentukFisikList">
                                <option value="Greenbean">
                                <option value="Cherry">
                                <option value="Gabah">
                                
                                @if(isset($bentukFisikList))
                                    @foreach($bentukFisikList as $bentuk)
                                        @if(!in_array($bentuk, ['Greenbean', 'Cherry', 'Gabah']))
                                            <option value="{{ $bentuk }}">
                                        @endif
                                    @endforeach
                                @endif
                            </datalist>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-bold text-white/70 block mb-1 uppercase tracking-wider text-[10px]">Berat Bersih</label>
                            <div class="flex rounded-xl shadow-sm relative">
                                <input type="number" step="0.01" name="weight_input" placeholder="0.00" class="w-full rounded-xl px-4 py-3 text-sm font-mono border border-white/10" required>
                                <span class="absolute right-4 top-3 text-sm font-bold text-primary">KG</span>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-bold text-white/70 block mb-1 uppercase tracking-wider text-[10px]">Total Karung</label>
                            <div class="relative">
                                <input type="number" name="bag_count" placeholder="0" class="w-full px-4 py-3 rounded-xl text-sm font-mono border border-white/10" required>
                                <span class="absolute right-4 top-3 text-xs font-bold text-white/30 pointer-events-none">BAGS</span>
                            </div>
                        </div>
                    </div>

                    <div class="h-px bg-white/5 w-full mb-6"></div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-white/70 flex items-center gap-2 mb-1 uppercase tracking-wider text-[10px]">
                                <span class="material-symbols-rounded text-sm text-yellow-400">edit</span> Harga Per Kg (Manual)
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-3 text-sm font-bold text-white/50">Rp</span>
                                <input type="number" id="priceManual" name="price_manual" class="w-full pl-10 pr-4 py-3 rounded-xl text-sm font-mono font-bold bg-yellow-400/10 border-yellow-400/30 text-yellow-400 focus:border-yellow-400" required placeholder="0">
                            </div>
                            <p class="text-[10px] text-white/30 italic">*Harga otomatis terisi saat pilih Grade, tapi bisa diubah manual.</p>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-bold text-white/70 block mb-1 uppercase tracking-wider text-[10px]">Metode Pembayaran</label>
                            <div class="relative">
                                <select name="payment_method" class="w-full px-4 py-3 rounded-xl appearance-none text-sm font-bold text-blue-400 bg-blue-400/10 border border-blue-400/30" required>
                                    <option value="TRANSFER">Transfer Bank</option>
                                    <option value="CASH">Uang Tunai (Cash)</option>
                                </select>
                                <span class="material-symbols-rounded absolute right-4 top-3 text-blue-400 pointer-events-none">expand_more</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-8 p-6 rounded-xl border border-white/5 bg-black/20">
                        <label class="text-sm font-bold text-white/70 flex justify-between mb-4">
                            Request Pembayaran (DP)
                            <span class="text-xs text-primary font-bold bg-primary/20 px-2 py-1 rounded" id="dpDisplay">60%</span>
                        </label>
                        <input type="range" name="dp_percentage" id="dpSlider" min="0" max="100" value="60" class="w-full accent-primary h-2 bg-white/10 rounded-lg appearance-none cursor-pointer" oninput="document.getElementById('dpDisplay').innerText = this.value + '%'">
                        <div class="flex justify-between text-[10px] text-white/40 mt-2 font-mono">
                            <span>0% (Hanya Titip)</span>
                            <span>100% (Jual Langsung)</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-white/70 block mb-1 uppercase tracking-wider text-[10px]">Catatan / Asal Kopi</label>
                            <textarea name="notes" rows="4" placeholder="Contoh: Kebun Blok A, Desa Sukamaju..." class="w-full px-4 py-3 rounded-xl text-sm"></textarea>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-white/70 block mb-1 uppercase tracking-wider text-[10px]">Foto Fisik Kopi (Opsional)</label>
                            <div onclick="document.getElementById('photo_input').click()" 
                                 class="h-32 border-2 border-dashed border-white/10 hover:border-primary hover:bg-white/5 rounded-xl flex flex-col items-center justify-center cursor-pointer group transition-all relative overflow-hidden">
                                <input type="file" id="photo_input" name="photo_proof" class="hidden" accept=".png, .jpg, .jpeg" onchange="previewImage(event)">
                                <div id="preview_placeholder" class="flex flex-col items-center">
                                    <span class="material-symbols-rounded text-2xl text-white/30 group-hover:text-primary mb-1">cloud_upload</span>
                                    <p class="text-[10px] text-white/50">Klik upload foto</p>
                                </div>
                                <img id="image_preview" class="hidden absolute inset-0 w-full h-full object-cover" />
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-4 border-t border-white/5 pt-6">
                        <a href="{{ route('koperasi.dashboard') }}" class="px-8 py-3 rounded-xl text-sm font-bold text-white/50 hover:text-white hover:bg-white/5 transition-colors">Batal</a>
                        <button type="submit" class="bg-primary hover:bg-[#0fd630] text-dark px-8 py-3 rounded-xl text-sm font-bold shadow-[0_0_20px_rgba(19,236,55,0.4)] transition-all transform hover:scale-105 flex items-center gap-2">
                            <span class="material-symbols-rounded text-lg">save</span> Simpan Setoran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        const pricesData = JSON.parse('<?php echo json_encode($prices ?? []); ?>');

        function updatePrice() {
            let variant = document.querySelector('input[name="coffee_variant"]:checked')?.value;
            let grade = document.getElementById('gradeSelect').value;
            let priceInput = document.getElementById('priceManual');

            if (variant && grade) {
                let autoPrice = pricesData[variant]?.[grade] || 0;
                priceInput.value = autoPrice;
                
                priceInput.classList.add('shadow-[0_0_15px_rgba(250,204,21,0.5)]');
                setTimeout(() => {
                    priceInput.classList.remove('shadow-[0_0_15px_rgba(250,204,21,0.5)]');
                }, 500);
            }
        }

        function previewImage(event) {
            const file = event.target.files[0];
            const placeholder = document.getElementById('preview_placeholder');
            const preview = document.getElementById('image_preview');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        }

        // 🔥 SCRIPT SELECT2 BIAR BISA SEARCH PETANI 🔥
        $(document).ready(function() {
            $('#select-petani').select2({
                placeholder: "Ketik Nama Petani...",
                allowClear: true
            });
        });
    </script>
</body>
</html>