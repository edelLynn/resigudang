<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            
            // 1. DATA KONEKSI (Siapa yang punya barang?)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 

            // 2. DATA INPUTAN PETANI (Barang Masuk)
            $table->string('jenis_kopi');
            $table->decimal('berat_awal_kg', 10, 2); // Klaim Petani
            
            // 3. DATA VERIFIKASI ADMIN (Setelah Cek Gudang)
            $table->decimal('berat_asli_kg', 10, 2)->nullable(); // Hasil timbangan gudang
            $table->decimal('harga_deal_per_kg', 15, 2)->nullable();
            
            // 4. DATA KESEPAKATAN DP
            $table->integer('persentase_dp')->nullable(); // Misal 60
            $table->decimal('nominal_dp', 15, 2)->nullable(); // Rupiah DP
            $table->decimal('sisa_tagihan', 15, 2)->nullable(); // Sisa duit (40%)

            // 5. STATUS WORKFLOW

            $table->enum('status', ['PENDING', 'DISETUJUI', 'BELUM_LUNAS', 'LUNAS'])
                  ->default('PENDING');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};