<?php

namespace App\Observers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\HargaBeliVersion;
use App\Models\LaporanStokBarang;
use Illuminate\Support\Facades\Log;

class BarangMasukObserver
{
    /**
     * Handle the BarangMasuk "created" event.
     */
    public function created(BarangMasuk $barangMasuk): void
    {
        // Ambil data barang dan laporan stok
        $laporanStok = LaporanStokBarang::where('barang_id', $barangMasuk->barang_id)
            ->orderBy('created_at', 'desc')
            ->first();

        // Update stok masuk dan stok akhir
        $laporanStok->stok_masuk += $barangMasuk->jumlah;
        $laporanStok->stok_akhir = ($laporanStok->stok_awal + $laporanStok->stok_masuk) - $laporanStok->stok_keluar;
        $laporanStok->save();

        //Update Harga Beli Barang
        $BarangId = $barangMasuk->barang_id;

        $barang = Barang::find($BarangId);

        if ($barang) {
            if ($laporanStok && isset($barangMasuk->harga_persatuan)) {
                //Kalau di laporan stok ada barangnya, dan field harga_persatuan terisi
                $barang->harga_beli = $barangMasuk->harga_persatuan;
                $barang->keuntungan = $barang->harga_jual - $barang->harga_beli;
                $barang->save();
            } else {
                // Tangani kasus jika $laporanStok tidak ada atau harga_persatuan tidak terdefinisi
                Log::warning("Laporan stok tidak tersedia atau harga_persatuan tidak terdefinisi.");
            }
        } else {
            // Barang tidak ditemukan
            Log::warning("Barang dengan ID {$BarangId} tidak ditemukan.");
        }
    }

    /**
     * Handle the BarangMasuk "updated" event.
     */
    public function updated(BarangMasuk $barangMasuk): void
    {
        $stokDiff = $barangMasuk->getOriginal('jumlah') - $barangMasuk->jumlah;

        // Ambil data laporan stok untuk barang lama (sebelum update)
        $oldBarangId = (int)$barangMasuk->getOriginal('barang_id');
        $oldLaporanStok = LaporanStokBarang::where('barang_id', $oldBarangId)
            ->orderBy('created_at', 'desc')
            ->first();
        $oldBarang = Barang::find($oldBarangId);

        // Ambil data laporan stok untuk barang baru (setelah update)
        $newBarangId = (int)$barangMasuk->barang_id;
        $newLaporanStok = LaporanStokBarang::where('barang_id', $newBarangId)
            ->orderBy('created_at', 'desc')
            ->first();
        $newBarang = Barang::find($newBarangId);

        //Ambil data harga beli paling pertama (ketika mendaftarkan barang)
        $firstVersion = HargaBeliVersion::where('barang_id', $oldBarangId)
        ->first();

        //Ambil data harga_beli terakhir dari data barangmasuk
        $latestHargaBeli = BarangMasuk::where('barang_id', $oldBarangId)
            ->orderBy('created_at', 'desc')
            ->first();

        //define harga_beli barang masuk agar lebih mudah dimengerti
        $newHargaPersatuan = $barangMasuk->harga_persatuan;

        // Jika barang_id berubah
        if ($oldBarangId != $newBarangId) {
            Log::warning("id barang berubah dari {$oldBarangId} menjadi {$newBarangId}");
            //Cek apakah oldLaporanStok tersedia
            if ($oldLaporanStok) {
                if ($latestHargaBeli) { //Ini jika ketika melakukan update, data harga_beli diambil dari data_barang masuk paling akhir
                    // Kurangi stok masuk barang lama dan hitung ulang stok akhir
                    $oldLaporanStok->stok_masuk -= $barangMasuk->getOriginal('jumlah');
                    $oldLaporanStok->stok_akhir = ($oldLaporanStok->stok_awal + $oldLaporanStok->stok_masuk) - $oldLaporanStok->stok_keluar;
                    $oldBarang->stok -= $barangMasuk->getOriginal('jumlah');
                    Log::warning("stok pada data barang dan laporan stok lama berhasil dikurang");

                    // Ubah harga_beli ke latest version
                    $oldBarang->harga_beli = $latestHargaBeli->harga_persatuan; //ini harusnya cek ke table_barang masuk dengan harga_beli barang paling terakhir
                    $oldBarang->keuntungan = $oldBarang->harga_jual - $oldBarang->harga_beli;
                    $oldLaporanStok->save();
                    $oldBarang->save();
                    Log::warning("Data Harga_beli berhasil dikembalikan sesuai harga_beli paling akhir di data barang masuk");

                } else { //Ini Jika Data Barang Masuk belum ada tapi ambil dari data harga_beli pertama dari data barang
                    // Kurangi stok masuk barang lama dan hitung ulang stok akhir
                    $oldLaporanStok->stok_masuk -= $barangMasuk->getOriginal('jumlah');
                    $oldLaporanStok->stok_akhir = ($oldLaporanStok->stok_awal + $oldLaporanStok->stok_masuk) - $oldLaporanStok->stok_keluar;
                    $oldBarang->stok -= $barangMasuk->getOriginal('jumlah');
                    Log::warning("stok pada data barang dan laporan stok lama berhasil dikurang");

                    // Ubah harga_beli ke latest version
                    $oldBarang->harga_beli = $firstVersion->harga_persatuan;
                    $oldBarang->keuntungan = $oldBarang->harga_jual - $oldBarang->harga_beli;
                    $oldLaporanStok->save();
                    $oldBarang->save();
                    Log::warning("Data Harga_beli berhasil dikembalikan sesuai First Version");
                }
            }
            //Cek apakah newLaporanStok tersedia
            if ($newLaporanStok) {
                //Ubah Stok barang baru
                $newLaporanStok->stok_masuk += (int)$barangMasuk->jumlah;
                $newLaporanStok->stok_akhir = ($newLaporanStok->stok_awal + $newLaporanStok->stok_masuk) - $newLaporanStok->stok_keluar;
                $newBarang->stok += (int)$barangMasuk->jumlah;
                Log::warning("stok pada data barang dan laporan stok baru berhasil ditambah");

                //Ubah Harga Beli barang baru
                $newBarang->harga_beli = $newHargaPersatuan;
                $newBarang->keuntungan = $newBarang->harga_jual - $newBarang->harga_beli;
                $newBarang->save();
                $newLaporanStok->save();
                Log::warning("Data Harga_beli berhasil diubah");
            }
        }
        //Jika barang_id tidak berubah 
        else if ($oldBarangId == $newBarangId) {
            Log::warning("id barang tidak berubah dari {$oldBarangId} menjadi {$newBarangId}");
            if ($newLaporanStok) {
                // Update stok masuk dan stok akhir berdasarkan perbedaan jumlah
                $newLaporanStok->stok_masuk -= $stokDiff;
                $newLaporanStok->stok_akhir = ($newLaporanStok->stok_awal + $newLaporanStok->stok_masuk) - $newLaporanStok->stok_keluar;
                $newBarang->stok -= $stokDiff;
                $newLaporanStok->save();
                $newBarang->save();
                Log::warning("berhasil update stok masuk dan stok akhir berdasarkan perbedaan jumlah");

                //Ubah Harga Beli barang baru
                $newBarang->harga_beli = $newHargaPersatuan;
                $newBarang->keuntungan = $newBarang->harga_jual - $newBarang->harga_beli;
                $newBarang->save();
                $newLaporanStok->save();
                Log::warning("Data Harga_beli berhasil diubah");
            }
        }
    }

    /**
     * Handle the BarangMasuk "deleted" event.
     */
    public function deleted(BarangMasuk $barangMasuk): void
    {
        $laporanStok = LaporanStokBarang::where('barang_id', $barangMasuk->barang_id)
            ->orderBy('created_at', 'desc') // Pastikan ambil data terbaru
            ->first();

        $barangId = $barangMasuk->barang_id;
        $barang = Barang::find($barangId);

        $firstVersion = HargaBeliVersion::where('barang_id', $barangId)
            ->first();

        $latestHargaBeli = BarangMasuk::where('barang_id', $barangId)
            ->orderBy('created_at', 'desc')
            ->value('harga_persatuan');

        if ($laporanStok) {
            //Cek apakah hargabeli pada data barangmasuk sudah ada sebelumnya
            if ($latestHargaBeli) {
                // Kurangi stok masuk barang lama dan hitung ulang stok akhir
                $laporanStok->stok_masuk -= $barangMasuk->jumlah;
                $laporanStok->stok_akhir = ($laporanStok->stok_awal + $laporanStok->stok_masuk) - $laporanStok->stok_keluar;
                $barang->stok -= $barangMasuk->jumlah;
                Log::warning("stok pada data barang dan laporan stok lama berhasil dikurang");

                // Ubah harga_beli ke latest version
                $barang->harga_beli = $latestHargaBeli;
                $laporanStok->save();
                $barang->save();
                Log::warning("Data Harga_beli berhasil dikembalikan sesuai last version");
            } else if ($firstVersion) { //Cek apakah data harga_beli pada barang untuk backup data sudah tersedia atau belum
                // Kurangi stok masuk barang lama dan hitung ulang stok akhir
                $laporanStok->stok_masuk -= $barangMasuk->jumlah;
                $laporanStok->stok_akhir = ($laporanStok->stok_awal + $laporanStok->stok_masuk) - $laporanStok->stok_keluar;
                $barang->stok -= $barangMasuk->jumlah;
                Log::warning("stok pada data barang dan laporan stok lama berhasil dikurang");

                // Ubah harga_beli ke latest version
                $barang->harga_beli = $firstVersion->harga_persatuan;
                $laporanStok->save();
                $barang->save();
                Log::warning("Data Harga_beli berhasil dikembalikan sesuai last version");
            }
        }
    }

    /**
     * Handle the BarangMasuk "restored" event.
     */
    public function restored(BarangMasuk $barangMasuk): void
    {
        //
    }

    /**
     * Handle the BarangMasuk "force deleted" event.
     */
    public function forceDeleted(BarangMasuk $barangMasuk): void
    {
        //
    }
}
