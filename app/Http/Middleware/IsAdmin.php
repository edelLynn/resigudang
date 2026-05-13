<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // LOGIC SATPAM:
        // 1. Cek apakah user login?
        // 2. Cek apakah role-nya 'admin'?
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request); // Silakan masuk, Bos!
        }

        // Kalau bukan admin, tendang keluar (Error 403 Forbidden)
        abort(403, 'Eits! Anda dilarang masuk area Admin.');
    }
}