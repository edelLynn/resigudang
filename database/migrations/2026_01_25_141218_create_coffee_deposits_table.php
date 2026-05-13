<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('coffee_deposits', function (Blueprint $table) {
            $table->id();
            
            // 🔥 UDAH GAK PAKE ->after() LAGI YA WAK
            $table->string('transaction_number')->unique();

            // PAKE USER_ID (Pengganti farmer_id)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // --- DATA FISIK BARANG ---
            $table->date('deposit_date');
            $table->string('coffee_variant'); // Arabica/Robusta
            $table->string('grade', 5)->nullable(); // Grade A, B, C
            $table->string('coffee_form');    // Cherry/Greenbean
            
            $table->double('weight_input');   
            $table->double('weight_verified')->nullable(); 
            
            $table->integer('bag_count');

            // --- DATA DP & PEMBAYARAN ---
            $table->integer('dp_percentage')->default(60); 
            $table->double('price_base_dp')->nullable();   
            $table->double('total_dp_amount')->nullable(); 
            $table->string('proof_payment')->nullable();        

            // --- DATA PELUNASAN (FINAL) ---
            $table->double('price_final_settlement')->nullable(); 
            $table->double('total_final_amount')->nullable();     
            $table->string('proof_payment_final')->nullable();    

            // 🔥 METODE PEMBAYARAN
            $table->enum('payment_method', ['CASH', 'TRANSFER'])->nullable();

            // --- STATUS ---
            $table->enum('status', ['PENDING', 'VERIFIED', 'PARTIAL_PAID', 'REQUEST_FINAL', 'PAID_OFF', 'REJECTED'])->default('PENDING');
            $table->text('notes')->nullable(); 
            $table->string('photo_proof_path')->nullable(); 
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('coffee_deposits');
    }
};