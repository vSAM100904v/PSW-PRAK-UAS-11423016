<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use App\Models\PenggunaOlahraga;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function index()
    {
        // Retrieve all members with jenis_pengguna 'pelanggan' from the database
        $players = PenggunaOlahraga::with('pelanggan')->where('jenis_pengguna', 'pelanggan')->get();

        // Pass the players data to the view
        return view('player.player', compact('players'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:pengguna_olahraga,username_pengguna',
            'password' => 'required|min:6',
        ]);

        PenggunaOlahraga::create([
            'username_pengguna' => $request->username,
            'password_pengguna' => Hash::make($request->password),
            'jenis_pengguna' => 'pelanggan',
            'created_by' => 'admin', // Nilai default 'admin'      
            'updated_by' => 'admin', // Nilai default 'admin'      
        ]);

        return redirect()->back()->with('success', 'Player berhasil ditambahkan.');
    }

    public function destroy_member($id)
    {
        // Find the member by ID
        $member = PenggunaOlahraga::findOrFail($id);

        // Delete the member
        $member->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Member has been deleted successfully.');
    }

    public function updateStatus(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_pengguna' => 'required|exists:pelanggan,id_pengguna',
            'id_lokasi' => 'required|in:1,2', // 1 for Member, 2 for Biasa
        ]);

        try {
            // Temukan pelanggan berdasarkan ID
            $pelanggan = Pelanggan::findOrFail($request->id_pengguna);

            // Tentukan jenis pelanggan berdasarkan input
            $jenis_pelanggan = $request->id_lokasi == 1 ? 'member' : 'biasa';

            // Perbarui jenis pelanggan
            $pelanggan->jenis_pelanggan = $jenis_pelanggan;
            $pelanggan->save();

            // Redirect kembali dengan pesan sukses
            return redirect()->back()->with('success', 'Status member berhasil diperbarui.');
        } catch (\Exception $e) {
            // Tangani jika terjadi kesalahan
            return redirect()->back()->with('error', 'Gagal memperbarui status member: ' . $e->getMessage());
        }
    }
}
