<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Cek apakah user sudah login?
        if (! $request->user()) {
            return redirect('/login');
        }

        // 2. Cek apakah Role user sesuai dengan yang diminta pintu gerbang?
        // Contoh: Pintu butuh 'admin_pt', tapi user cuma 'petani' -> TENDANG!
        if ($request->user()->role !== $role) {
            abort(403, 'Eits! Anda tidak punya akses ke area ini, Wak!');
        }

        // 3. Kalau aman, silakan masuk
        return $next($request);
    }
}