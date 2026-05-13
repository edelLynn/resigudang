<?php

namespace App\Http\Controllers;

use App\Models\CoffeeDeposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReceiptController extends Controller
{
public function index()
    {
        $userId = Auth::id();
        
        // --- 1. DATA CHART  ---
        $dates = collect();
        for ($i = 6; $i >= 0; $i--) {
            $dates->push(Carbon::now()->subDays($i));
        }

        $chartLabels = [];
        $chartData = [];

        foreach ($dates as $date) {
            $chartLabels[] = $date->format('d M');
            $sum = CoffeeDeposit::where('user_id', $userId)
                ->whereDate('deposit_date', $date->format('Y-m-d'))
                ->sum('weight_input');
            $chartData[] = $sum;
        }

        // --- 2. STATISTIK  ---
        $allDeposits = CoffeeDeposit::where('user_id', $userId)->get();
        $total_setoran = $allDeposits->whereNotIn('status', ['PENDING', 'REJECTED'])->sum('weight_verified'); 
        $total_pending = $allDeposits->where('status', 'PENDING')->count();
        $total_ditolak = $allDeposits->where('status', 'REJECTED')->count();
        
        $total_uang = $allDeposits->whereNotIn('status', ['PENDING', 'REJECTED'])
                                ->sum(function($row) {
                                    return $row->total_dp_amount + $row->total_final_amount;
                                });

        // --- 3. DATA RIWAYAT  ---
        $histories = CoffeeDeposit::where('user_id', $userId)->latest()->limit(20)->get();

        // --- 4.AMBIL HARGA LENGKAP (A, B, C) ---
        $pricesDB = DB::table('coffee_prices')->get();

        // Susun jadi array biar enak dipanggil di View
        $prices = [
            'Robusta' => [
                'A' => $pricesDB->where('coffee_variant', 'Robusta')->where('grade', 'A')->value('price') ?? 0,
                'B' => $pricesDB->where('coffee_variant', 'Robusta')->where('grade', 'B')->value('price') ?? 0,
                'C' => $pricesDB->where('coffee_variant', 'Robusta')->where('grade', 'C')->value('price') ?? 0,
            ],
            'Arabica' => [
                'A' => $pricesDB->where('coffee_variant', 'Arabica')->where('grade', 'A')->value('price') ?? 0,
                'B' => $pricesDB->where('coffee_variant', 'Arabica')->where('grade', 'B')->value('price') ?? 0,
                'C' => $pricesDB->where('coffee_variant', 'Arabica')->where('grade', 'C')->value('price') ?? 0,
            ]
        ];

        return view('dashboard', compact(
            'chartLabels', 'chartData', 'total_setoran', 'total_pending', 'total_ditolak',
            'total_uang', 'histories', 'prices' // <--- Kita kirim array $prices
        ));
    }

    public function create()
    {
        return view('petani.setor_kopi');
    }

    public function history()
    {
        return redirect()->route('setoran.history');
    }
}