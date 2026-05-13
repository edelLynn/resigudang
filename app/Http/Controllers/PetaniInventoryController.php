<?php

namespace App\Http\Controllers;

use App\Models\CoffeeDeposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetaniInventoryController extends Controller
{
    public function index()
    {
        // 1. Ambil semua riwayat setoran milik petani ini yang SUDAH MASUK GUDANG
        // Syarat: User ID cocok DAN Status bukan Pending/Rejected
        $mutations = CoffeeDeposit::where('user_id', Auth::id())
            ->whereNotIn('status', ['PENDING', 'REJECTED'])
            ->latest('updated_at') // <--- UBAH JADI INI (Pake updated_at biar aman)
            ->get();

        // 2. Lempar ke view petani
        return view('petani.inventory.index', compact('mutations'));
    }
}