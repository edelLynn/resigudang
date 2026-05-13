<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoffeeDeposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_number',
        'user_id',
        'deposit_date',
        'coffee_variant',
        'coffee_form',
        'grade',
        
        // --- KOLOM ENTERPRISE ---
        'weight_input',
        'weight_verified',
        'bag_count',
        
        // --- DP & KEUANGAN ---
        'dp_percentage',
        'price_base_dp',
        'total_dp_amount',
        'proof_payment',
        
        // --- PELUNASAN ---
        'price_final_settlement',
        'total_final_amount',
        'proof_payment_final',
        
        // --- STATUS & LAINNYA ---
        'status',
        'notes',
        'photo_proof_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}