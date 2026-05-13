<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingContent extends Model
{
    use HasFactory;

protected $fillable = [
        'hero_title', 'hero_subtitle', 'hero_text', 'hero_image',
        'about_title', 'about_text',
        'feature_1_title', 'feature_1_text',
        'feature_2_title', 'feature_2_text',
        'feature_3_title', 'feature_3_text',
        'about_val1_title', 'about_val1_text',
        'about_val2_title', 'about_val2_text',
        'about_cta_title', 'about_cta_text',
        'features_header_title', 'features_header_subtitle'
    ];
}