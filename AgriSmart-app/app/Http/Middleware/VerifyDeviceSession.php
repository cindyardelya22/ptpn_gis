<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifyDeviceSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $currentIp = $request->ip();
            $currentUserAgent = $request->userAgent() ?? '';

            $deviceExists = Auth::user()->devices()
                ->where('ip_address', $currentIp)
                ->where('user_agent', $currentUserAgent)
                ->exists();

            if (!$deviceExists) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // Flash message untuk ditampilkan di halaman login
                session()->flash('error', 'Sesi Anda telah dihentikan dari perangkat lain.');
                
                return redirect()->route('login');
            }
            
            // Opsional: Perbarui last_activity_at setiap ada request agar tetap akurat
            // Namun untuk menghindari query berlebih, kita bisa membatasinya hanya update jika sudah lewat waktu tertentu,
            // atau biarkan saja (di-update hanya saat login/aktivitas khusus).
        }

        return $next($request);
    }
}
