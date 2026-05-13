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
        Schema::create('coffee_prices', function (Blueprint $table) {
            $table->id();
            $table->string('coffee_variant'); 
            $table->string('grade', 5); 
            $table->integer('price'); // Harga
            $table->unsignedBigInteger('updated_by')->nullable(); // Siapa admin yg update
            $table->timestamps();
            $table->unique(['coffee_variant', 'grade']); 
        });

        // ISI DATA AWAL (SEEDER) - LENGKAP A, B, C
        $now = now();
        DB::table('coffee_prices')->insert([
            // --- ROBUSTA ---
            ['coffee_variant' => 'Robusta', 'grade' => 'A', 'price' => 40000, 'created_at' => $now, 'updated_at' => $now],
            ['coffee_variant' => 'Robusta', 'grade' => 'B', 'price' => 35000, 'created_at' => $now, 'updated_at' => $now],
            ['coffee_variant' => 'Robusta', 'grade' => 'C', 'price' => 30000, 'created_at' => $now, 'updated_at' => $now],

            // --- ARABICA ---
            ['coffee_variant' => 'Arabica', 'grade' => 'A', 'price' => 65000, 'created_at' => $now, 'updated_at' => $now],
            ['coffee_variant' => 'Arabica', 'grade' => 'B', 'price' => 60000, 'created_at' => $now, 'updated_at' => $now],
            ['coffee_variant' => 'Arabica', 'grade' => 'C', 'price' => 55000, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('coffee_prices');
    }
};