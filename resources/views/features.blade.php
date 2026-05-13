<x-landing-layout>
    @push('styles')
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        body { background-color: #10221f !important; }
    </style>
    @endpush

    <div class="min-h-screen text-white font-display antialiased">
        {{-- NAVBAR SAMA FOOTER JUGA UDAH DIHAPUS DI SINI --}}

        {{-- MAIN CONTENT --}}
        <main class="pt-32 pb-20 px-6">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16">
                    <h1 class="text-4xl md:text-6xl font-black mb-6 tracking-tight">
                        @safeHtml($content->features_header_title ?? 'Fitur <span class="text-primary">Ekosistem</span> Digital')
                    </h1>
                    <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                        {{ $content->features_header_subtitle ?? 'Dirancang dengan prinsip efisiensi industri untuk memaksimalkan potensi setiap panen kopi lu.' }}
                    </p>
                </div>
                {{-- Fitur Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    {{-- Fitur 1 --}}
                    <div class="p-8 rounded-3xl bg-[#1a2c29] border border-white/5 shadow-xl">
                        <span class="material-symbols-outlined text-primary text-4xl mb-6">inventory_2</span>
                        <h3 class="text-xl font-bold mb-4">{{ $content->feature_1_title ?? 'Fitur 1' }}</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">
                            {{ $content->feature_1_text ?? 'Deskripsi fitur 1' }}
                        </p>
                    </div>

                    {{-- Fitur 2 --}}
                    <div class="p-8 rounded-3xl bg-[#1a2c29] border border-white/5 shadow-xl">
                        <span class="material-symbols-outlined text-leaf-green text-4xl mb-6">account_balance_wallet</span>
                        <h3 class="text-xl font-bold mb-4">{{ $content->feature_2_title ?? 'Fitur 2' }}</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">
                            {{ $content->feature_2_text ?? 'Deskripsi fitur 2' }}
                        </p>
                    </div>

                    {{-- Fitur 3 --}}
                    <div class="p-8 rounded-3xl bg-[#1a2c29] border border-white/5 shadow-xl">
                        <span class="material-symbols-outlined text-yellow-400 text-4xl mb-6">analytics</span>
                        <h3 class="text-xl font-bold mb-4">{{ $content->feature_3_title ?? 'Fitur 3' }}</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">
                            {{ $content->feature_3_text ?? 'Deskripsi fitur 3' }}
                        </p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-landing-layout>