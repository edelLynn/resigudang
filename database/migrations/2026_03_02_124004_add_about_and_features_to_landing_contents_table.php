<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
    {
        Schema::table('landing_contents', function (Blueprint $table) {
            // Yang Kemaren
            $table->string('about_title')->nullable();
            $table->text('about_text')->nullable();
            $table->string('feature_1_title')->nullable();
            $table->text('feature_1_text')->nullable();
            $table->string('feature_2_title')->nullable();
            $table->text('feature_2_text')->nullable();
            $table->string('feature_3_title')->nullable();
            $table->text('feature_3_text')->nullable();
            
            $table->string('about_val1_title')->nullable();
            $table->text('about_val1_text')->nullable();
            $table->string('about_val2_title')->nullable();
            $table->text('about_val2_text')->nullable();
            $table->string('about_cta_title')->nullable();
            $table->text('about_cta_text')->nullable();
            $table->string('features_header_title')->nullable();
            $table->text('features_header_subtitle')->nullable();
        });
    }

    public function down()
    {
        Schema::table('landing_contents', function (Blueprint $table) {
            $table->dropColumn([
                'about_title', 'about_text', 
                'feature_1_title', 'feature_1_text',
                'feature_2_title', 'feature_2_text',
                'feature_3_title', 'feature_3_text'
            ]);
        });
    }
};