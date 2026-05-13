<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. UPDATE TABEL USERS (Status Ban)
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'status')) {
                $table->string('status')->default('active')->after('role'); 
            }
        });

        // 2. UPDATE TABEL COFFEE_DEPOSITS (Tambah Grade)
        Schema::table('coffee_deposits', function (Blueprint $table) {
            if (!Schema::hasColumn('coffee_deposits', 'grade')) {
                // TARGETNYA GUE UBAH JADI 'coffee_variant'
                $table->integer('grade')->nullable()->after('coffee_variant');
            }
        });

        // 3. (BAGIAN TABEL HARGA GUE HAPUS BIAR GAK BENTROK)
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'status')) {
                $table->dropColumn(['status']);
            }
        });

        Schema::table('coffee_deposits', function (Blueprint $table) {
             if (Schema::hasColumn('coffee_deposits', 'grade')) {
                $table->dropColumn(['grade']);
            }
        });
    }
};