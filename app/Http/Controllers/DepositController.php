<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\CoffeeDeposit;
use Illuminate\Support\Facades\Storage;
use App\Models\WarehouseStock;
use Barryvdh\DomPDF\Facade\Pdf;

class DepositController extends Controller
{
    public function create()
    {
        return view('petani.setor_kopi'); 
    }

    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'deposit_date'   => 'required|date',
            'coffee_variant' => 'required',
            'grade'          => 'required',
            'coffee_form'    => 'required',
            'weight_input'   => 'required|numeric',
            'weight_unit'    => 'required',
            'bag_count'      => 'required|integer',
            'dp_percentage'  => 'required|integer|min:10|max:60',
            'notes'          => 'nullable|string',
            'photo_proof'    => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        // 2. Konversi Berat
        $berat_final_kg = $request->weight_input;
        if ($request->weight_unit == 'KWINTAL') {
            $berat_final_kg = $request->weight_input * 100;
        } elseif ($request->weight_unit == 'TON') {
            $berat_final_kg = $request->weight_input * 1000;
        }

        // 3. Upload Foto
        $path = null;
        if ($request->hasFile('photo_proof')) {
            $path = $request->file('photo_proof')->store('deposits', 'public');
        }

        // 4. Simpan DB
        CoffeeDeposit::create([
            'user_id'          => Auth::id(),
            'deposit_date'     => $request->deposit_date,
            'coffee_variant'   => $request->coffee_variant,
            'grade'          => $request->grade,
            'coffee_form'      => $request->coffee_form,
            'weight_input'     => $berat_final_kg,
            'weight_verified'  => null, 
            'bag_count'        => $request->bag_count,
            'dp_percentage'    => $request->dp_percentage,
            'notes'            => $request->notes,
            'photo_proof_path' => $path,
            'status'           => 'PENDING',
        ]);

        return redirect()->route('dashboard')->with('success', 'Setoran berhasil diajukan! Menunggu verifikasi timbangan.');
    }

    public function index()
    {
        $deposits = CoffeeDeposit::where('user_id', Auth::id())->latest()->get();
        $stok_arabica = WarehouseStock::where('coffee_type', 'Arabica')->sum('total_weight_kg');
        $stok_robusta = WarehouseStock::where('coffee_type', 'Robusta')->sum('total_weight_kg');

        return view('deposits.index', compact('deposits', 'stok_arabica', 'stok_robusta'));
    }

    public function history(Request $request)
    {
        $status = $request->query('status');
        $query = CoffeeDeposit::where('user_id', Auth::id());

        // LOGIC FILTER TAB
        if ($status && $status !== 'semua') {
            if ($status == 'pending') {
                $query->where('status', 'PENDING');
            } 
            elseif ($status == 'verified') {
                $query->whereIn('status', ['VERIFIED', 'PARTIAL_PAID', 'REQUEST_FINAL', 'PAID_OFF']);
            } 
            elseif ($status == 'rejected') {
                $query->where('status', 'REJECTED');
            }
        }

        // PENTING: Ganti nama variabel jadi $histories & pake paginate
        $histories = $query->latest()->paginate(10);

        // Kirim ke view dengan nama 'histories'
        return view('riwayat_setoran', compact('histories', 'status'));
    }

    public function downloadResi($id)
    {
        $deposit = CoffeeDeposit::with('user')
                        ->where('id', $id)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();
        $pdf = Pdf::loadView('pdf.receipt', compact('deposit'));
        return $pdf->download('Resi-Gudang-RG'.$deposit->id.'.pdf');
    }

    // --- REQUEST PELUNASAN ---
    public function requestFinal($id)
    {
        $deposit = CoffeeDeposit::where('id', $id)
                        ->where('user_id', Auth::id()) 
                        ->firstOrFail();

        if ($deposit->status !== 'PARTIAL_PAID') {
            return redirect()->back()->with('error', 'Gagal! Kopi ini belum di-DP atau sudah Lunas.');
        }

        $deposit->update([
            'status' => 'REQUEST_FINAL'
        ]);

        return redirect()->back()->with('success', 'Request pelunasan terkirim! Admin akan menghitung sisa pembayaran.');
    }
    
}