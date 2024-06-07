<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Lapangan;
use Illuminate\Http\Request;
use App\Models\BookingOlahraga;
use App\Models\KategoriLapangan;
use App\Models\PenggunaOlahraga;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function bookNow(Request $request, $id_lapangan)
    {
        // Temukan lapangan berdasarkan ID
        $lapangan = Lapangan::findOrFail($id_lapangan);

        // Kirim data lapangan dan kategori ke halaman form booking
        return view('booking.form', compact('lapangan'));
    }

    public function submitBooking(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'waktu_mulai' => [
                'required',
                'date_format:Y-m-d\TH:i',
                function ($attribute, $value, $fail) {
                    $waktu_mulai = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $value);
                    if ($waktu_mulai->isPast()) {
                        $fail('Waktu mulai tidak boleh di bawah waktu sekarang.');
                    }
                },
            ],
            'waktu_selesai' => [
                'required',
                'date_format:Y-m-d\TH:i',
                'after:waktu_mulai',
                function ($attribute, $value, $fail) use ($request) {
                    $waktu_mulai = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->waktu_mulai);
                    $waktu_selesai = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $value);
                    if ($waktu_selesai->diffInHours($waktu_mulai) > 4) {
                        $fail('Waktu booking tidak boleh lebih dari 4 jam.');
                    }

                    if ($waktu_selesai->hour > 19 || ($waktu_selesai->hour == 19 && $waktu_selesai->minute > 0)) {
                        $fail('Waktu selesai tidak boleh lebih dari jam 7 sore.');
                    }

                    if ($waktu_selesai->diffInHours($waktu_mulai) < 1) {
                        $fail('Waktu selesai harus minimal 1 jam setelah waktu mulai.');
                    }
                },
            ],
            'catatan' => 'nullable|string',
            'lapangan_id' => 'required|exists:lapangan_olahraga,id_lapangan',
            'nama_lapangan' => 'required|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Dapatkan ID pengguna dari sesi
        $id_pengguna = session('id_pengguna');

        // Pastikan ID pengguna ada sebelum menyimpan data
        if (!$id_pengguna) {
            return redirect()->back()->with('error', 'ID pengguna tidak valid.');
        }

        // Dapatkan pengguna terkait
        $pengguna = PenggunaOlahraga::findOrFail($id_pengguna);

        $jenis_pelanggan = session('jenis_pelanggan');

        // Tentukan status booking
        $status = $jenis_pelanggan == 'member' ? 'approve' : 'pending';

        // Simpan data booking
        BookingOlahraga::create([
            'id_pengguna' => $id_pengguna,
            'id_lapangan' => $request->lapangan_id,
            'waktu_mulai_booking' => $request->waktu_mulai,
            'waktu_selesai_booking' => $request->waktu_selesai,
            'catatan' => $request->catatan,
            'nama_pemesan' => $request->nama,
            'email_pemesan' => $request->email,
            'nama_lapangan' => $request->nama_lapangan,
            'status' => $status,
            'created_by' => $request->nama
        ]);

        return redirect()->route('view_lapangan')->with('success', 'Booking berhasil. ' . ($status == 'approve' ? 'Booking Anda telah disetujui.' : 'Silahkan tunggu verifikasi dari admin.'));
    }

    public function bookingList()
    {
        $bookings = BookingOlahraga::with(['lapangan'])->get();

        // Kirim data booking ke view
        return view('booking.list_booking', compact('bookings'));
    }

    public function approve($id)
    {
        // Temukan booking berdasarkan ID
        $booking = BookingOlahraga::findOrFail($id);

        // Ubah status booking menjadi "approve"
        $booking->status = 'approve';
        $booking->save();

        // Ambil data semua booking dari database
        $bookings = BookingOlahraga::with(['lapangan'])->get();

        // Redirect kembali ke halaman daftar booking dengan pesan sukses
        return redirect()->route('booking_list', compact('bookings'))->with('success', 'Booking has been approved successfully.');
    }

    public function info_booking()
    { // Dapatkan ID pengguna dari sesi
        $id_pengguna = session('id_pengguna');

        // Dapatkan informasi booking berdasarkan ID pengguna
        $bookings = BookingOlahraga::where('id_pengguna', $id_pengguna)->get();

        // Tampilkan halaman dengan informasi booking
        return view('booking.info_booking', compact('bookings'));
    }
    public function notApprove($id)
    {
        // Temukan booking berdasarkan ID
        $booking = BookingOlahraga::findOrFail($id);

        // Ubah status booking menjadi "not approve"
        $booking->status = 'not approve';
        $booking->save();

        $bookings = BookingOlahraga::with(['lapangan'])->get();

        // Redirect kembali ke halaman daftar booking dengan pesan sukses
        return redirect()->route('booking_list', compact('bookings'))->with('success', 'Booking has been marked as not approved successfully.');
    }
    public function show($id)
    {
        // Temukan booking berdasarkan ID
        $booking = BookingOlahraga::findOrFail($id);

        // Kirim data booking ke view detail
        return view('booking.detail_booking', compact('booking'));
    }
    public function showDetail($id)
    {
        $booking = BookingOlahraga::findOrFail($id);
        return view('booking.detail_user', compact('booking'));
    }
    public function edit($id)
    {
        $booking = BookingOlahraga::findOrFail($id);
        return view('booking.edit_user', compact('booking'));
    }
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'waktu_mulai' => 'required|date_format:Y-m-d\TH:i',
            'waktu_selesai' => 'required|date_format:Y-m-d\TH:i|after_or_equal:waktu_mulai',
            'catatan' => 'nullable|string',
            // Tambahkan validasi lainnya sesuai kebutuhan
        ]);

        // Temukan booking berdasarkan ID
        $booking = BookingOlahraga::findOrFail($id);

        // Perbarui informasi booking
        $booking->nama_pemesan = $request->nama;
        $booking->email_pemesan = $request->email;
        $booking->waktu_mulai_booking = $request->waktu_mulai;
        $booking->waktu_selesai_booking = $request->waktu_selesai;
        $booking->catatan = $request->catatan;

        // Simpan perubahan
        $booking->save();

        // Redirect kembali ke halaman daftar booking dengan pesan sukses
        return redirect()->route('booking_info')->with('success', 'Booking has been updated successfully.');
    }

    public function showJadwal()
    {
        // Ambil waktu saat ini
        $now = Carbon::now();

        // Ambil data booking olahraga yang waktu mulainya lebih besar dari waktu saat ini dan statusnya adalah 'approve'
        $jadwal = BookingOlahraga::where('waktu_mulai_booking', '>', $now)
            ->where('status', 'approve')
            ->get();

        // Kemudian kembalikan tampilan dengan data jadwal
        return view('booking.jadwal', compact('jadwal'));
    }
}
