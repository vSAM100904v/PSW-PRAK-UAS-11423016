<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Islogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        // Periksa apakah pengguna sudah terautentikasi
        if (!session('is_logged_in')) {
            // Jika tidak, kembalikan pengguna ke halaman login
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }


        // Periksa apakah pengguna adalah pemilik atau pengelola
        if (session('jenis_pengguna') !== 'pemilik' && session('jenis_pengguna') !== 'pengelola') {
            // Jika pengguna bukan pemilik atau pengelola, kembalikan ke halaman login
            return redirect()->route('login')->with('error', 'Anda harus login sebagai admin.');
        }


        // Lanjutkan ke permintaan berikutnya jika pengguna terautentikasi dan adalah admin
        return $next($request);
    }
}
