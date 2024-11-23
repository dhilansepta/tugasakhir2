<?php

namespace App\Http\Controllers\Pdf;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class PDFController extends Controller
{
    public function viewLaporan()
    {
        $laporanPenjualan = session('laporanPenjualan', collect());
        $tanggal = session('tanggal', collect());

        $pendapatanKotor = DB::table('laporanpenjualan')
            ->whereDate('created_at', $tanggal)
            ->sum('pendapatan_kotor');

        $pendapatanSebenarnya = DB::table('laporanpenjualan')
            ->whereDate('created_at', $tanggal)
            ->sum('pendapatan_sebenarnya');

        $pendapatanBersih = DB::table('laporanpenjualan')
            ->whereDate('created_at', $tanggal)
            ->sum('keuntungan');

        $data = [
            'laporanPenjualan' => $laporanPenjualan,
            'tanggal' => $tanggal,
            'pendapatanKotor' => $pendapatanKotor,
            'pendapatanBersih' => $pendapatanBersih,
            'pendapatanSebenarnya' => $pendapatanSebenarnya,
        ];

        return view('pdf.laporanPenjualan', compact('laporanPenjualan', 'pendapatanKotor',  'pendapatanSebenarnya', 'pendapatanBersih', 'tanggal'));
    }

    public function downloadLaporanPenjualan(): mixed
    {
        // Mengambil data dari sesi
        $laporanPenjualan = session('laporanPenjualan', collect());
        $tanggal = session('tanggal', collect());

        $pendapatanKotor = DB::table('laporanpenjualan')
            ->whereDate('created_at', $tanggal)
            ->sum('pendapatan_kotor');

        $pendapatanSebenarnya = DB::table('laporanpenjualan')
            ->whereDate('created_at', $tanggal)
            ->sum('pendapatan_sebenarnya');

        $pendapatanBersih = DB::table('laporanpenjualan')
            ->whereDate('created_at', $tanggal)
            ->sum('keuntungan');

        $data = [
            'laporanPenjualan' => $laporanPenjualan,
            'tanggal' => $tanggal,
            'pendapatanKotor' => $pendapatanKotor,
            'pendapatanBersih' => $pendapatanBersih,
            'pendapatanSebenarnya' => $pendapatanSebenarnya
        ];

        // Load view dengan data dan generate PDF
        $pdf = Pdf::loadView('pdf.laporanPenjualan', $data)->setPaper('A4', 'landscape'); // A4 dengan orientasi landscape;

        // Download PDF dengan nama invoice.pdf
        return $pdf->download('laporanPenjualan_' . $tanggal . '.pdf');
    }

    public function downloadLaporanStok(): mixed
    {
        $laporanStok = session('laporanStok', collect());
        $tanggal = session('tanggal', collect());
        
        $data = [
            'laporanStok' => $laporanStok,
            'tanggal' => $tanggal,
        ];

        $pdf = Pdf::loadView('pdf.laporanStok', $data)->setPaper('A4', 'landscape'); // A4 dengan orientasi landscape;

        return $pdf->download('laporanStok_' . $tanggal . '.pdf');
    }
}
