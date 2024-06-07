<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriLapangan;

class KategoriLapanganController extends Controller
{
    public function create()
    {
        return view('court.kategori_lapangan');
    }
    public function store(Request $request)
    {
        // Validasi data input
        $validatedData = $request->validate([
            'nama_katlapangan' => 'required|string|max:500',
            'jenis_lapangan' => 'required|string|max:100', // Assuming harga_katlapangan is also required
            'file_katlapangan' => 'required|string|max:700',
            'jumlah_lapangan' => 'required|integer', // Add this line for jumlah_lapangan
            'created_at' => 'nullable|date',
            'updated_at' => 'nullable|date',
        ]);
        // Tambahkan nilai default untuk created_by
        $validatedData['created_by'] = 'admin';

        // Simpan data ke dalam database
        KategoriLapangan::create($validatedData);

        // Redirect ke halaman yang sesuai dengan kebutuhan aplikasi Anda
        return redirect()->route('lapangan_index')->with('success', 'Kategori lapangan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $kategori = KategoriLapangan::findOrFail($id);
        return view('court.kategori_lapangan_detail', ['kategori' => $kategori]);
    }

    public function edit($id)
    {
        $kategori_lapangan = KategoriLapangan::findOrFail($id);
        return view('court.kategori_lapangan_update', compact('kategori_lapangan'));
    }
    public function update(Request $request, $id)
    {
        // Validasi data input
        $validatedData = $request->validate([
            'nama_katlapangan' => 'required|string|max:255',
            'jenis_lapangan' => 'required|string|max:100',
            'file_katlapangan' => 'required|string|max:255',
            'jumlah_lapangan' => 'required|integer',
        ], [
            'nama_katlapangan.required' => 'Nama kategori lapangan wajib diisi.',
            'nama_katlapangan.max' => 'Nama kategori lapangan tidak boleh melebihi 255 karakter.',
            'jenis_lapangan.required' => 'Jenis lapangan wajib diisi.',            
            'file_katlapangan.required' => 'Deskripsi kategori lapangan wajib diisi.',
            'file_katlapangan.max' => 'Deskripsi kategori lapangan tidak boleh melebihi 255 karakter.',
            'jumlah_lapangan.required' => 'Jumlah lapangan wajib diisi.',
            'jumlah_lapangan.integer' => 'Jumlah lapangan harus berupa bilangan bulat.'
        ]);

        // Temukan kategori lapangan berdasarkan ID
        $kategoriLapangan = KategoriLapangan::findOrFail($id);

        // Perbarui data kategori lapangan
        $kategoriLapangan->update($validatedData);

        // Redirect ke halaman detail kategori lapangan
        return redirect()->route('lapangan_index', $kategoriLapangan->id)
            ->with('success', 'Kategori lapangan berhasil diperbarui.');
    }
    public function destroy($id)
    {
        // Temukan kategori lapangan berdasarkan ID
        $kategoriLapangan = KategoriLapangan::findOrFail($id);

        // Hapus kategori lapangan dari database
        $kategoriLapangan->delete();

        // Redirect ke halaman index atau halaman yang sesuai
        return redirect()->route('lapangan_index')
            ->with('success', 'Kategori lapangan berhasil dihapus.');
    }
}
