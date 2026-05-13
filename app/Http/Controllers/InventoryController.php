<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WarehouseStock;
use App\Models\CoffeeDeposit;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index()
    {
        // 1. Ambil Data Stok dari tabel warehouse_stocks
        // (Pastikan tabel ini keisi pas Admin klik Verifikasi di Dashboard)
        $stocks = WarehouseStock::all();

        // 2. Ambil Harga Real dari Database
        $prices = DB::table('coffee_prices')->pluck('price', 'coffee_variant');
        // Hasil: ['Robusta' => 40000, 'Arabica' => 65000]

        // 3. Hitung Total Aset (Stok x Harga Varian Masing-masing)
        $total_aset = 0;
        foreach($stocks as $stock) {
            $price = $prices[$stock->coffee_type] ?? 0; // Ambil harga sesuai jenis kopi
            $total_aset += $stock->total_weight_kg * $price;
        }

        // 4. Ambil Riwayat Barang Masuk (Log Mutasi)
        // Kita ambil yang statusnya udah PARTIAL_PAID (udah ditimbang) atau PAID_OFF
        $mutations = CoffeeDeposit::with('user')
                        ->whereIn('status', ['PARTIAL_PAID', 'PAID_OFF']) 
                        ->latest()
                        ->take(10) // 10 transaksi terakhir
                        ->get();

        // Arahin ke folder admin/inventory
        return view('admin.inventory.index', compact('stocks', 'total_aset', 'mutations'));
    }
}