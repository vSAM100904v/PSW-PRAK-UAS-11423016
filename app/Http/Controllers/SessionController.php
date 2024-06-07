<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\PenggunaOlahraga;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class SessionController extends Controller
{
    public function index()
    {
        return view('index');
    }
    public function admin()
    {
        return view('dashboard_admin');
    }


    public function form_login()
    {
        return view('login_form')->with('error', session('error'));
    }

    public function logout()
    {

        Auth::logout();


        session()->forget('is_logged_in');
        session()->forget('username');


        return redirect()->route('index')->with('success', 'Logout berhasil!');
    }

    public function validasi(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'Username wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);
    
        $remember = $request->has('remember');
    
        // Simpan username dan password dalam cookie jika opsi "Remember Me" dicentang
        if ($remember) {
            setcookie("username", $request->username, time() + 3600);
            setcookie("password", $request->password, time() + 3600);
        } else {
            // Hapus cookie username dan password jika opsi "Remember Me" tidak dicentang
            setcookie("username", "", time() - 3600);
            setcookie("password", "", time() - 3600);
        }
    
        // Cari pengguna berdasarkan username
        $pengguna = PenggunaOlahraga::where('username_pengguna', $request->username)->first();
    
        if (!$pengguna) {
            // Pengguna tidak ditemukan, redirect kembali ke halaman login dengan pesan error
            return redirect()->route('login')->withErrors(['login' => 'Username salah. Mohon isi dengan benar.'])->withInput();
        }
    
        if (password_verify($request->password, $pengguna->password_pengguna)) {
            // Update last_login field with current timestamp
            $pengguna->update(['last_login' => Carbon::now()]);
    
            // Dapatkan jenis_pelanggan dari hubungan dengan Pelanggan
            $pelanggan = $pengguna->pelanggan()->first();
            $jenis_pelanggan = $pelanggan ? $pelanggan->jenis_pelanggan : null;
    
            // Simpan id_pengguna dan jenis_pengguna ke dalam session
            session([
                'is_logged_in' => true,
                'id_pengguna' => $pengguna->id_pengguna,
                'username' => $request->username,
                'jenis_pengguna' => $pengguna->jenis_pengguna,
                'jenis_pelanggan' => $jenis_pelanggan,
            ]);
    
            // Redirect ke halaman sesuai jenis pengguna
            switch ($pengguna->jenis_pengguna) {
                case 'pemilik':
                    return redirect()->route('admin_dashboard')->with('success', 'Login berhasil.');
                case 'pengelola':
                    return redirect()->route('admin_dashboard')->with('success', 'Login berhasil.');
                case 'pelanggan':
                    return redirect()->route('index')->with('success', 'Login berhasil.');
                default:
                    return redirect()->route('login')->withErrors(['login' => 'Jenis pengguna tidak valid.'])->withInput();
            }
        }
    
        // Password tidak cocok, redirect kembali ke halaman login dengan pesan error
        return redirect()->route('login')->withErrors(['login' => 'Password Anda salah ya, input ulang lagi.'])->withInput();
    }
    
}
