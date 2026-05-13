<?php

use App\Http\Controllers\AdminDepositController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PetaniInventoryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SuperAdminController;
use App\Models\LandingContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

// Rute buat ngeklik link aktivasi dari Email
Route::get('/aktivasi-akun/{id}', [App\Http\Controllers\SuperAdminController::class, 'activateAccount'])
    ->name('user.activate')
    ->middleware('signed');

// ====================================================
// MESIN PENGIRIM EMAIL (POP-UP HUBUNGI KAMI)
// ====================================================
Route::post('/contact/send', function (Request $request) {
    // 1. Validasi inputan biar gak diisi sembarangan
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'message' => 'required|string',
    ]);

    // 2. Desain isi suratnya (Bisa pake HTML biar cakep)
        $htmlContent = "
            <h2>Ada Pesan Baru dari Contact Form!</h2>
            <p><strong>Nama Lengkap:</strong> " . e($request->name) . "</p>
            <p><strong>Email Pengirim:</strong> " . e($request->email) . "</p>
            <p><strong>Pesan:</strong><br/>" . nl2br(e($request->message)) . "</p>
        ";

    // 3. Eksekusi Kirim Email!
    Mail::html($htmlContent, function ($msg) use ($request) {
        $msg->to('edel354313@gmail.com')
            ->subject('Pesan VIP dari: ' . $request->name)
            ->replyTo($request->email);
    });

    // 4. Balik ke halaman Tentang Kami bawa notif Sukses
    return back()->with('success_contact', 'Email Terkirim, Mohon tunggu beberapa saat untuk direspon.');
});

//cms route
Route::get('/', function () {
    // Panggil data CMS dari database
    $content = \App\Models\LandingContent::first();
    
    // Jaga-jaga kalau databasenya kosong biar web lu gak meledak
    if (!$content) {
        $content = (object)[
            'hero_title' => 'Ubah Panen Kopi <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-leaf-green">Jadi Uang Tunai</span><br> Lebih Cepat',
            'hero_subtitle' => 'Solusi Petani Modern',
            'hero_text' => 'Sistem resi gudang digital terpercaya. Simpan hasil panen Anda dengan aman dan dapatkan pembiayaan instan.',
            'hero_image' => 'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?q=80&w=2070&auto=format&fit=crop'
        ];
    }

    // Kirim datanya ke welcome.blade.php
    return view('welcome', compact('content'));
});

Route::get('/tentang-kami', function () {
    $content = \App\Models\LandingContent::first();
    return view('about', compact('content'));
})->name('about');

Route::get('/fitur', function () {
    $content = \App\Models\LandingContent::first();
    return view('features', compact('content'));
})->name('features');

Route::get('/redirect', function () {
    $user = Auth::user();
    if ($user->role === 'admin_pt') return redirect()->route('superadmin.dashboard');
    if ($user->role === 'admin_koperasi') return redirect()->route('koperasi.dashboard');
    return redirect()->route('dashboard');
})->middleware(['auth'])->name('redirect');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ====================================================
// ZONA 1: PETANI
// ====================================================
Route::middleware(['auth', 'verified', 'role:petani'])->group(function () {
    Route::get('/dashboard', [ReceiptController::class, 'index'])->name('dashboard');
    Route::get('/riwayat-setoran', [DepositController::class, 'history'])->name('setoran.history');
    Route::get('/deposit/{id}/download', [DepositController::class, 'downloadResi'])->name('deposit.download');
    Route::post('/deposit/{id}/request-final', [DepositController::class, 'requestFinal'])->name('deposit.request_final');
    
    // Nanti teks menunya kita ubah jadi "Transaksi" di bladenya
    Route::get('/stok-saya', [PetaniInventoryController::class, 'index'])->name('petani.inventory.index');
});

// ====================================================
// ZONA 2: ADMIN KOPERASI
// ====================================================
Route::middleware(['auth', 'role:admin_koperasi'])->prefix('koperasi')->name('koperasi.')->group(function () {
    Route::get('/dashboard', [AdminDepositController::class, 'index'])->name('dashboard'); 
    
    Route::get('/setor-kopi', [AdminDepositController::class, 'create'])->name('deposits.create');
    Route::post('/setor-kopi', [AdminDepositController::class, 'store'])->name('deposits.store');

    Route::resource('deposits', AdminDepositController::class)->except(['create', 'store']);
    Route::get('/deposits/{id}/verify', [AdminDepositController::class, 'showVerifyForm'])->name('deposits.verify');
    Route::post('/deposits/{id}/process-dp', [AdminDepositController::class, 'processDp'])->name('deposits.process_dp');
    
    // PELUNASAN
    Route::post('/deposits/{id}/process-final', [AdminDepositController::class, 'processFinal'])->name('deposits.process_final');
    
    Route::post('/deposits/{id}/reject', [AdminDepositController::class, 'reject'])->name('deposits.reject');
    Route::get('/deposits/{id}/print', [AdminDepositController::class, 'print'])->name('deposits.print');
    Route::get('/history', [AdminDepositController::class, 'history'])->name('history');
    
    // INVENTORY ADMIN
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
});

// ====================================================
// ZONA 3: BOS PT (SUPER ADMIN)
// ====================================================
Route::middleware(['auth', 'role:admin_pt'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/prices', [SuperAdminController::class, 'prices'])->name('prices');
    Route::post('/prices', [SuperAdminController::class, 'storePrices'])->name('prices.store');
    Route::delete('/prices/{id}', [SuperAdminController::class, 'deletePrice'])->name('prices.delete');
    Route::get('/users', [SuperAdminController::class, 'users'])->name('users');
    Route::post('/users', [SuperAdminController::class, 'storeUser'])->name('users.store');
    Route::delete('/users/{id}', [SuperAdminController::class, 'deleteUser'])->name('users.delete');
    Route::get('/reports', [SuperAdminController::class, 'reports'])->name('reports');
    Route::get('/reports/{id}/print', [SuperAdminController::class, 'printResi'])->name('reports.print');
    // MENU CMS LANDING PAGE
    Route::get('/cms', [SuperAdminController::class, 'cms'])->name('cms');
    Route::post('/cms', [SuperAdminController::class, 'updateCms'])->name('cms.update');
});

// ====================================================
// MESIN PENGGANTI BAHASA (MULTI-LANGUAGE)
// ====================================================
Route::get('/lang/{locale}', function ($locale) {
    // Kita batesin cuma boleh 'id' (Indonesia) atau 'en' (Inggris)
    if (in_array($locale, ['id', 'en'])) {
        session(['locale' => $locale]); // Simpan pilihan bahasa di memori browser
    }
    return back(); // Balik ke halaman sebelumnya
})->name('lang.switch');

require __DIR__.'/auth.php';