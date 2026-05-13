<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('landing_contents', function (Blueprint $table) {
            $table->id();
            $table->string('hero_title'); // Buat Judul Gede
            $table->string('hero_subtitle'); // Buat teks kecil di atas judul
            $table->text('hero_text'); // Buat deskripsi panjang
            $table->string('hero_image')->nullable(); // Buat link gambar background
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('landing_contents');
    }
};