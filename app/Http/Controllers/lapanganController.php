<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Models\Lapangan;
use Illuminate\Http\Request;
use App\Models\KategoriLapangan;
use App\Models\PenggunaOlahraga;
use Illuminate\Support\Facades\Storage;

class lapanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function lapangan()
    {
        // Ambil semua data lapangan
        $data_lapangan = Lapangan::all();
        // Ambil semua data lokasi
        $data = Lokasi::all();

        // Kirim data lapangan dan data lokasi ke tampilan
        return view('court.lapangan', compact('data_lapangan', 'data'));
    }

    public function lapangan_user()
    {
        $data_lapangan = Lapangan::all();
        return view('court.lapangan_user', ['data_lapangan' => $data_lapangan]);
    }


    public function show_lapangan($id)
    {
        $lapangan = Lapangan::with('kategori')->findOrFail($id);
        return view('court.lapangan_show', compact('lapangan'));
    }

    public function user_court_show($id)
    {
        $lapangan = Lapangan::findOrFail($id); // Menggantikan "Lapangan" dengan model Anda yang sesuai
        return view('court.lapangan_user_show', compact('lapangan'));
    }


    public function lapangan_create()
    {
        $data_lokasi = Lokasi::all(); // Fetch all Lokasi data
        return view('court.lapangan_create', ['data_lokasi' => $data_lokasi]);
    }

    public function lapangan_store(Request $request)
    {
        $messages = [
            'nama_lapangan.required' => 'Nama lapangan wajib diisi.',
            'harga_lapangan.required' => 'Harga sewa lapangan wajib diisi.',
            'deskripsi_lapangan.required' => 'Deskripsi lapangan wajib diisi.',
        ];

        $validatedData = $request->validate([
            'nama_lapangan' => 'required|string|max:255',
            'harga_lapangan' => 'required|numeric',
            'deskripsi_lapangan' => 'required|string', // Ubah jumlahLapangan menjadi deskripsi_lapangan
            'id_lokasi' => 'required|exists:lokasi,id_lokasi', // Validasi untuk ID kategori lapangan
            'img_lapangan' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk gambar
        ], $messages);


        if ($request->hasFile('img_lapangan')) {
            $fileNameWithExt = $request->file('img_lapangan')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('img_lapangan')->getClientOriginalExtension();
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
            $path = $request->file('img_lapangan')->storeAs('public/img', $fileNameToStore);
            $validatedData['img_lapangan'] = 'img/' . $fileNameToStore;
        }

        // Simpan data lapangan beserta ID kategori lapangan yang dipilih
        Lapangan::create($validatedData);

        return redirect()->route('lapangan_index')->with('success', 'Lapangan added successfully');
    }


    public function edit_lapangan($id_lapangan)
    {
        $lapangan = Lapangan::findOrFail($id_lapangan);
        return view('court.lapangan_edit', compact('lapangan'));
    }
    public function update_lapangan(Request $request, string $id_lapangan)
    {
        // Temukan lapangan berdasarkan ID
        $lapangan = Lapangan::findOrFail($id_lapangan);

        // Validasi data yang dikirimkan oleh form
        $validatedData = $request->validate([
            'nama_lapangan' => 'required|string|max:255',
            'harga_lapangan' => 'required|numeric',
            'deskripsi_lapangan' => 'required|string', // Ubah jumlahLapangan menjadi deskripsi_lapangan
            'img_lapangan' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk file gambar
        ], [
            'nama_lapangan.required' => 'Nama lapangan wajib diisi.',
            'harga_lapangan.required' => 'Harga lapangan wajib diisi.',
            'deskripsi_lapangan.required' => 'Deskripsi lapangan wajib diisi.', // Ubah pesan validasi
            'harga_lapangan.numeric' => 'Harga harus berupa angka.',
            'img_lapangan.image' => 'File harus berupa gambar.',
            'img_lapangan.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'img_lapangan.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
        ]);

        // Periksa apakah ada file gambar yang diunggah
        if ($request->hasFile('img_lapangan')) {
            // Hapus gambar lama jika ada
            if ($lapangan->img_lapangan) {
                // Hapus gambar lama dari penyimpanan
                Storage::delete($lapangan->img_lapangan);
            }

            // Simpan gambar baru
            $fileNameWithExt = $request->file('img_lapangan')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('img_lapangan')->getClientOriginalExtension();
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
            $path = $request->file('img_lapangan')->storeAs('public/img', $fileNameToStore);

            // Tambahkan path gambar ke data yang divalidasi
            $validatedData['img_lapangan'] = 'img/' . $fileNameToStore;
        }

        // Perbarui informasi lapangan dengan data yang divalidasi
        $lapangan->update($validatedData);

        // Redirect kembali ke halaman index lapangan dengan pesan sukses
        return redirect()->route('lapangan_index')->with('success', 'Lapangan updated successfully');
    }


    public function destroy_lapangan(string $id_lapangan)
    {

        $lapangan = Lapangan::findOrFail($id_lapangan);


        $lapangan->delete();


        return redirect()->route('lapangan_index')->with('success', 'Lapangan deleted successfully');
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
