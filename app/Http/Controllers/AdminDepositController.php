<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\CoffeeDeposit;
use App\Models\User;
use App\Models\WarehouseStock;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class AdminDepositController extends Controller
{
    // ================================================================
    // 1. DASHBOARD ADMIN
    // ================================================================
    public function index(Request $request)
    {
        $query = CoffeeDeposit::with('user')
                ->whereDate('created_at', now())
                ->latest();

        if ($request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%");
            });
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->date) {
            $query->whereDate('deposit_date', $request->date);
        }
        $deposits = $query->get();

        // ... (Logic Statistik) ...
        $total_weight = CoffeeDeposit::whereIn('status', ['VERIFIED', 'PARTIAL_PAID', 'REQUEST_FINAL', 'PAID_OFF'])->sum('weight_verified');
        $total_money   = CoffeeDeposit::sum('total_dp_amount') + CoffeeDeposit::sum('total_final_amount');
        $total_farmers = User::where('role', 'petani')->count();
        $total_pending = CoffeeDeposit::whereIn('status', ['PENDING', 'REQUEST_FINAL'])->count();

        $allPrices = Cache::remember('semua_harga_kopi', 60 * 24, function () {
            return DB::table('coffee_prices')->get();
        });
        
        $prices = [];
        foreach($allPrices as $p) {
            $prices[$p->coffee_variant][$p->grade] = $p->price;
        }

        $robustaPrices = \Illuminate\Support\Facades\DB::table('coffee_prices')
                            ->where('coffee_variant', 'Robusta')
                            ->orderBy('grade', 'asc')
                            ->get();
                            
        $arabicaPrices = \Illuminate\Support\Facades\DB::table('coffee_prices')
                            ->where('coffee_variant', 'Arabica')
                            ->orderBy('grade', 'asc')
                            ->get();

        return view('admin.dashboard', compact(
            'deposits', 'total_weight', 'total_money', 'total_farmers', 'total_pending', 'prices', 'robustaPrices', 'arabicaPrices'
        ));
    }

    // ================================================================
    // FITUR BARU: ADMIN BUKA FORM SETOR KOPI
    // ================================================================
    public function create()
    {
        $petani = User::where('role', 'petani')->get();

        $allPrices = Cache::remember('semua_harga_kopi', 60 * 24, function () {
            return DB::table('coffee_prices')->get();
        });
        $prices = [];
        $grades = [];
        
        foreach($allPrices as $p) {
            $prices[$p->coffee_variant][$p->grade] = $p->price;
            
            if (!in_array($p->grade, $grades)) {
                $grades[] = $p->grade;
            }
        }
        
        sort($grades);

        $bentukFisikList = \App\Models\CoffeeDeposit::select('coffee_form')
                            ->distinct()
                            ->whereNotNull('coffee_form')
                            ->pluck('coffee_form');

        return view('admin.deposits.create', compact('petani', 'prices', 'grades', 'bentukFisikList'));
    }

    // ================================================================
    // ADMIN SIMPAN DATA SETORAN
    // ================================================================
    public function store(Request $request)
    {
        $request->validate([
            'user_id'        => 'required|exists:users,id',
            'deposit_date'   => 'required|date',
            'coffee_variant' => 'required',
            'grade'          => 'required',
            'coffee_form'    => 'required',
            'weight_input'   => 'required|numeric',
            'bag_count'      => 'required|integer',
            'dp_percentage'  => 'required|numeric|min:0|max:100',
            'price_manual'   => 'required|numeric',
            'payment_method' => 'required|in:CASH,TRANSFER',
            'photo_proof'    => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'notes'          => 'nullable|string',
        ]);

        $datePrefix = now()->format('ymd');
        $trxNumber = 'TRX-' . $datePrefix . '-' . strtoupper(Str::random(5));

        while(CoffeeDeposit::where('transaction_number', $trxNumber)->exists()) {
            $trxNumber = 'TRX-' . $datePrefix . '-' . strtoupper(Str::random(5));
        }

        $path = null;
        if ($request->hasFile('photo_proof')) {
            $path = $request->file('photo_proof')->store('deposits', 'public');
        }

        CoffeeDeposit::create([
            'transaction_number' => $trxNumber,
            'user_id'            => $request->user_id, 
            'deposit_date'       => $request->deposit_date,
            'coffee_variant'     => $request->coffee_variant,
            'grade'              => $request->grade,
            'coffee_form'        => $request->coffee_form,
            'weight_input'       => $request->weight_input, 
            'weight_verified'    => null,
            'bag_count'          => $request->bag_count,
            'dp_percentage'      => $request->dp_percentage,
            'price_base_dp'      => $request->price_manual, 
            'payment_method'     => $request->payment_method, 
            'notes'              => $request->notes,
            'photo_proof_path'   => $path,
            'status'             => 'PENDING',
        ]);

        return redirect()->route('koperasi.dashboard')->with('success', 'Setoran Kopi berhasil dicatat! Silahkan proses pembayaran di menu Transaksi Hari Ini.');
    }

    // ================================================================
    // 2. PROSES VERIFIKASI & BAYAR DP (PARTIAL PAID)
    // ================================================================

    public function showVerifyForm($id)
    {
        $deposit = CoffeeDeposit::with('user')
                        ->where('id', $id)
                        ->where('status', 'PENDING')
                        ->firstOrFail();

        return view('admin.deposits.verify', compact('deposit'));
    }

    public function processDp(Request $request, $id)
    {
        $request->validate([
            'weight_verified' => 'required|numeric|min:0.1',
            'final_grade' => 'required',
            'final_price' => 'required|numeric|min:0',
            'proof_payment' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $deposit = CoffeeDeposit::where('id', $id)
                        ->where('status', 'PENDING')
                        ->firstOrFail();
        
        $proofPath = $request->file('proof_payment')->store('payment_proofs', 'public');

        $weight_verified = $request->weight_verified; 
        $final_grade     = $request->final_grade;     
        $harga_per_kg    = $request->final_price;     

        $total_nilai_barang = $weight_verified * $harga_per_kg;
        $nominal_dp         = $total_nilai_barang * ($deposit->dp_percentage / 100);

        $is_lunas_langsung = ($deposit->dp_percentage >= 100);

        $deposit->update([
            'weight_verified' => $weight_verified,
            'grade'           => $final_grade,
            'price_base_dp'   => $harga_per_kg,
            'total_dp_amount' => $nominal_dp,
            'status'          => $is_lunas_langsung ? 'PAID_OFF' : 'PARTIAL_PAID', 
            'verified_at'     => now(),
            'proof_payment'   => $proofPath,
            'price_final_settlement' => $is_lunas_langsung ? $harga_per_kg : null,
            'total_final_amount'     => $is_lunas_langsung ? 0 : null,
            'proof_payment_final'    => $is_lunas_langsung ? $proofPath : null,
        ]);

        $stock = WarehouseStock::firstOrCreate(
            ['coffee_type' => $deposit->coffee_variant], 
            ['total_weight_kg' => 0]
        );
        $stock->increment('total_weight_kg', $weight_verified);
        $msg = $is_lunas_langsung ? 'Kopi Jual Putus 100% berhasil diproses & langsung LUNAS!' : 'Verifikasi Selesai! Grade & DP Tersimpan.';
        return redirect()->route('koperasi.dashboard')->with('success', $msg);
    }

    // ================================================================
    // 3. PROSES PELUNASAN (FINAL)
    // ================================================================
    public function processFinal(Request $request, $id)
    {
        $request->validate([
            'proof_payment_final' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $deposit = CoffeeDeposit::where('id', $id)
                        ->whereIn('status', ['PARTIAL_PAID', 'REQUEST_FINAL'])
                        ->firstOrFail();

        $proofPath = $request->file('proof_payment_final')->store('payment_proofs', 'public');
        $harga_final_hari_ini = DB::table('coffee_prices')
                                ->where('coffee_variant', $deposit->coffee_variant)
                                ->where('grade', $deposit->grade)
                                ->value('price');

        $total_nilai_baru = $deposit->weight_verified * $harga_final_hari_ini;
        $sisa_tagihan = $total_nilai_baru - $deposit->total_dp_amount;

        if ($sisa_tagihan < 0) $sisa_tagihan = 0;

        $deposit->update([
            'price_final_settlement' => $harga_final_hari_ini,
            'total_final_amount'     => $sisa_tagihan,
            'status'                 => 'PAID_OFF',
            'proof_payment_final'    => $proofPath,
            'verified_at'            => now(),
        ]);

        return redirect()->route('koperasi.dashboard')->with('success', 'Pelunasan Berhasil! Bukti transfer tersimpan.');
    }

    // ================================================================
    // 4. TOLAK SETORAN
    // ================================================================
    public function reject(Request $request, $id)
    {
        $request->validate([
            'note' => 'required|string|max:255',
        ]);

        $deposit = CoffeeDeposit::where('id', $id)
                        ->whereIn('status', ['PENDING', 'REQUEST_FINAL'])
                        ->firstOrFail();

        $deposit->update([
            'status' => 'REJECTED',
            'notes'  => 'DITOLAK: ' . strip_tags($request->note)
        ]);

        return redirect()->back()->with('success', 'Setoran berhasil ditolak beserta alasannya.');
    }

    // ================================================================
    // 5. CETAK KWITANSI
    // ================================================================
    public function print($id)
    {
        $deposit = CoffeeDeposit::with('user')->findOrFail($id);
        $pdf = Pdf::loadView('pdf.receipt', compact('deposit'));
        return $pdf->stream('Resi-'.$deposit->id.'.pdf');
    }

    // ================================================================
    // 6. RIWAYAT TRANSAKSI (HISTORY)
    // ================================================================
    public function history(Request $request)
    {
        $query = CoffeeDeposit::with('user')->latest();
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%");
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('date')) {
            $query->whereDate('deposit_date', $request->date);
        }

        $histories = $query->paginate(10)->withQueryString();
        $allPrices = Cache::remember('semua_harga_kopi', 60 * 24, function () {
            return DB::table('coffee_prices')->get();
        });
        $prices = [];
        $grades = [];
        foreach($allPrices as $p) {
            $prices[$p->coffee_variant][$p->grade] = $p->price;
            if(!in_array($p->grade, $grades)) $grades[] = $p->grade;
        }
        sort($grades);

        return view('admin.history.index', compact('histories', 'prices', 'grades'));
    }
}