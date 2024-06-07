<?php

namespace App\Http\Controllers;

use App\Models\BookingOlahraga;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class GeneratePdf extends Controller
{
    public function generatePDF()
    {
        try {
            // Ambil semua data booking
            $bookings = BookingOlahraga::all();

            // Pengecekan jika data bookings kosong
            if ($bookings->isEmpty()) {
                throw new \Exception("Tidak ada data booking yang tersedia.");
            }

            // Siapkan data untuk dikirim ke view
            $data = ['bookings' => $bookings];

            // Buat PDF dari view
            $pdf = PDF::loadView('pdf.booking_list', $data);

            // Pengecekan jika PDF gagal dibuat
            if (!$pdf) {
                throw new \Exception("Gagal membuat PDF.");
            }

            // Download file PDF
            return $pdf->download('booking_list.pdf');
        } catch (\Exception $e) {
            // Tangani pengecualian dan kembali ke halaman sebelumnya dengan pesan error
            return redirect()->back()->with('error', 'Gagal membuat PDF: ' . $e->getMessage());
        }
    }
}
