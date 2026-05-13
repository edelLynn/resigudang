<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReceiptController;

// Pintu masuk API (Gak usah pake uri: action: biar simpel)
Route::post('/buat-resi', [ReceiptController::class, 'store']);