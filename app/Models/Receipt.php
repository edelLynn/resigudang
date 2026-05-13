<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jenis_kopi',
        'berat_awal_kg',
        'berat_asli_kg',
        'harga_deal_per_kg',
        'persentase_dp',
        'nominal_dp',
        'sisa_tagihan',
        'status',
    ];

    // Tambahin ini biar Receipt tau siapa pemiliknya
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}