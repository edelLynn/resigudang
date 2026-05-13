<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoffeePrice extends Model
{
    use HasFactory;

    // Kasih tau Laravel kalau nama tabelnya ini
    protected $table = 'coffee_prices';
    
    // Kolom yang boleh diisi
    protected $fillable = [
        'coffee_variant',
        'grade',
        'price',
        'updated_by'
    ];
}