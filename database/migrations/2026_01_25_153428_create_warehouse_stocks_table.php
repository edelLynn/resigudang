<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; 

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('warehouse_stocks', function (Blueprint $table) {
            $table->id();
            $table->string('coffee_type')->unique(); // Arabica, Robusta, dll
            $table->double('total_weight_kg')->default(0); // Total Berat
            $table->timestamps();
        });

        // --- SEEDER OTOMATIS (Biar gak kosong) ---
        DB::table('warehouse_stocks')->insert([
            ['coffee_type' => 'Arabica', 'total_weight_kg' => 0],
            ['coffee_type' => 'Robusta', 'total_weight_kg' => 0],
            ['coffee_type' => 'Liberica', 'total_weight_kg' => 0],
            ['coffee_type' => 'Excelsa', 'total_weight_kg' => 0],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouse_stocks');
    }
};
