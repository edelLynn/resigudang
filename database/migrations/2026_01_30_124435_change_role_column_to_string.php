<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // UBAH KOLOM ROLE JADI VARCHAR (STRING) BIASA
        // Biar bisa nerima 'admin_pt', 'admin_koperasi', dll.
        DB::statement("ALTER TABLE users MODIFY COLUMN role VARCHAR(50) NOT NULL DEFAULT 'petani'");
    }

    public function down()
    {
        // Balikin ke ENUM kalau di-rollback (Opsional)
        // DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'petani') NOT NULL DEFAULT 'petani'");
    }
};
