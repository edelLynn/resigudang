<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('coffee_deposits', function (Blueprint $table) {
            // 🔥 KITA BIKIN DAFTAR ISI BUAT KOLOM YANG SERING DICARI BOS
            $table->index('status');
            $table->index('deposit_date');
            
            // Note: transaction_number sama user_id biasanya udah otomatis di-index 
            // pas awal kita bikin unique() sama foreignId().
        });
    }

    public function down()
    {
        Schema::table('coffee_deposits', function (Blueprint $table) {
            // Kalau misal kita mau ngebatalin, daftar isinya diapus lagi
            $table->dropIndex(['status']);
            $table->dropIndex(['deposit_date']);
        });
    }
};