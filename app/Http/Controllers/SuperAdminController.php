<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CoffeeDeposit;
use App\Models\WarehouseStock;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\LandingContent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        $robustaPrice = DB::table('coffee_prices')->where('coffee_variant', 'Robusta')->where('grade', 'A')->value('price');
        $arabicaPrice = DB::table('coffee_prices')->where('coffee_variant', 'Arabica')->where('grade', 'A')->value('price');

        $total_stok = WarehouseStock::sum('total_weight_kg');
        $total_uang_keluar = CoffeeDeposit::whereIn('status', ['PARTIAL_PAID', 'REQUEST_FINAL', 'PAID_OFF'])
                                ->sum(DB::raw('COALESCE(total_dp_amount, 0) + COALESCE(total_final_amount, 0)'));

        $stats = [
            'total_koperasi' => User::where('role', 'admin_koperasi')->count(),
            'total_petani'   => User::where('role', 'petani')->count(),
            'robusta_price'  => $robustaPrice ?? 0,
            'arabica_price'  => $arabicaPrice ?? 0,
            'total_stok'     => $total_stok,
            'total_keuangan' => $total_uang_keluar,
        ];

        return view('superadmin.dashboard', compact('stats'));
    }

    public function prices()
    {
        $prices = DB::table('coffee_prices')->orderBy('coffee_variant', 'asc')->orderBy('grade', 'asc')->get();
        return view('superadmin.prices', compact('prices'));
    }

    public function storePrices(Request $request)
    {
        $request->validate([
            'coffee_variant' => 'required|string|max:50',
            'grade'          => 'required|string|max:10',
            'price'          => 'required|numeric|min:0',
        ]);

        $adminId = Auth::id();
        $now = now();

        $exists = DB::table('coffee_prices')->where('coffee_variant', $request->coffee_variant)->where('grade', $request->grade)->first();

        if ($exists) {
            DB::table('coffee_prices')->where('id', $exists->id)->update([
                    'price' => $request->price, 
                    'updated_at' => $now, 
                    'updated_by' => $adminId
                ]);
            $msg = "Harga {$request->coffee_variant} Grade {$request->grade} berhasil diupdate!";
        } else {
            DB::table('coffee_prices')->insert([
                'coffee_variant' => $request->coffee_variant,
                'grade'          => $request->grade,
                'price'          => $request->price,
                'created_at'     => $now,
                'updated_at'     => $now,
                'updated_by'     => $adminId
            ]);
            $msg = "Varian & Grade Baru ({$request->coffee_variant} Grade {$request->grade}) berhasil ditambahkan!";
        }

        // 🔥 HANCURKAN INGATAN LAMA KARENA BOS BARUSAN UPDATE HARGA!
        \Illuminate\Support\Facades\Cache::forget('semua_harga_kopi');

        return back()->with('success', $msg);
    }

    public function deletePrice($id)
    {
        DB::table('coffee_prices')->where('id', $id)->delete();
        
        // 🔥 HANCURKAN INGATAN LAMA KARENA BOS BARUSAN NGAPUS HARGA!
        \Illuminate\Support\Facades\Cache::forget('semua_harga_kopi');

        return back()->with('success', 'Grade Kopi berhasil dihapus dari sistem.');
    }

    public function users()
    {
        $users = User::where('id', '!=', Auth::id())->latest()->get();
        return view('superadmin.users', compact('users'));
    }

    // ==========================================================
    // AUTO-PASSWORD & VALIDASI EMAIL ASLI
    // ==========================================================

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns|unique:users',
            'role' => 'required',
            'password' => 'required|min:6'
        ], [
            'email.dns' => 'Domain email tidak ditemukan!'
        ]);

        // 1. Simpan user dengan status PENDING (Belum bisa login)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password), 
            'status' => 'pending' // <--- STATUS AWAL DITAHAN
        ]);

        // 2. Bikin Link Aktivasi Khusus (Signed Route)
        $activationUrl = URL::signedRoute('user.activate', ['id' => $user->id]);

        // 3. Kirim Email beserta Link Aktivasinya
        try {
            Mail::send('emails.new_user_welcome', [
                'user' => $user, 
                'password' => $request->password,
                'activationUrl' => $activationUrl // <--- LEMPAR LINK KE EMAIL
            ], function($message) use ($user) {
                $message->to($user->email);
                $message->subject('Aktivasi Akun ResiGudang Anda');
            });
        } catch (\Exception $e) {
            return back()->with('error', 'User dibuat (Pending), tapi gagal ngirim email. Cek koneksi SMTP.');
        }

        return back()->with('success', 'User berhasil ditambahkan dengan status PENDING. Link aktivasi telah dikirim!');
    }

    public function deleteUser($id)
    {
        User::destroy($id);
        return back()->with('success', 'User berhasil dihapus.');
    }

    public function reports()
    {
        $deposits = CoffeeDeposit::with('user')->latest()->get();
        return view('superadmin.reports', compact('deposits'));
    }

    public function printResi($id)
    {
        $deposit = CoffeeDeposit::with('user')->findOrFail($id);
        return view('admin.deposits.print', compact('deposit'));
    }

    public function cms()
    {
        $content = LandingContent::first();
        
        if (!$content) {
            $content = LandingContent::create([
                'hero_title' => 'Ubah Panen Kopi <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-leaf-green">Jadi Uang Tunai</span><br> Lebih Cepat',
                'hero_subtitle' => 'Solusi Petani Modern',
                'hero_text' => 'Sistem resi gudang digital terpercaya. Simpan hasil panen Anda dengan aman dan dapatkan pembiayaan instan.',
                'hero_image' => 'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?q=80&w=2070&auto=format&fit=crop'
            ]);
        }

        return view('superadmin.cms', compact('content'));
    }

    public function updateCms(Request $request)
    {
        $request->validate([
            'hero_title' => 'required|string',
            'hero_subtitle' => 'required|string|max:255',
            'hero_text' => 'required|string',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'about_title' => 'nullable|string|max:255',
            'about_text' => 'nullable|string',
            'feature_1_title' => 'nullable|string|max:255',
            'feature_1_text' => 'nullable|string',
            'feature_2_title' => 'nullable|string|max:255',
            'feature_2_text' => 'nullable|string',
            'feature_3_title' => 'nullable|string|max:255',
            'feature_3_text' => 'nullable|string',
            'about_val1_title' => 'nullable|string|max:255',
            'about_val1_text' => 'nullable|string',
            'about_val2_title' => 'nullable|string|max:255',
            'about_val2_text' => 'nullable|string',
            'about_cta_title' => 'nullable|string|max:255',
            'about_cta_text' => 'nullable|string',
            'features_header_title' => 'nullable|string|max:255',
            'features_header_subtitle' => 'nullable|string',
        ]);

        $content = LandingContent::first();
        $data = $request->only([
            'hero_title', 'hero_subtitle', 'hero_text',
            'about_title', 'about_text',
            'feature_1_title', 'feature_1_text',
            'feature_2_title', 'feature_2_text',
            'feature_3_title', 'feature_3_text',
            'about_val1_title', 'about_val1_text',
            'about_val2_title', 'about_val2_text',
            'about_cta_title', 'about_cta_text',
            'features_header_title', 'features_header_subtitle',
        ]);

        if ($request->hasFile('hero_image')) {
            $imagePath = $request->file('hero_image')->store('landing', 'public');
            $data['hero_image'] = '/storage/' . $imagePath;
        }

        $content->update($data);
        return back()->with('success', 'Mantap Bos! Tampilan Website berhasil diperbarui!');
    }

    // ==========================================================
    // FUNGSI BUAT NGE-AKTIFIN AKUN DARI EMAIL
    // ==========================================================
    public function activateAccount(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Kalau udah aktif, gak usah diaktifin lagi
        if ($user->status === 'active') {
            return redirect()->route('login')->with('success', 'Akun Anda sudah aktif sebelumnya. Silakan login!');
        }

        // Ubah status dari pending jadi active
        $user->update(['status' => 'active']);

        // Lempar ke halaman login bawaan Laravel
        return redirect()->route('login')->with('success', 'Selamat! Akun Anda berhasil diaktifkan. Silakan login.');
    }
}