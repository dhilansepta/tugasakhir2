<?php

namespace App\Imports;

use App\Models\Kategori;
use App\Models\Satuan;
use App\Models\Barang;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DaftarBarangImport implements ToCollection, WithHeadingRow
{
    /**
     * Process the imported collection.
     *
     * @param Collection $rows
     * @throws \Exception
     */

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Hitung keuntungan
            $keuntungan = $row['harga_jual'] - $row['harga_beli'];

            $barang = Barang::where('nama_barang', $row['nama_barang'])->first();

            if ($barang) {
                throw new \Exception("Gagal Input Data Barang, Karena Data barang " . json_encode($row["nama_barang"] . " Sudah Terdapat Dalam Database"));
            }

            // Cek jika ada kolom yang null pada baris ini
            if (
                is_null($row['nama_barang']) ||
                is_null($row['kategori']) ||
                is_null($row['satuan']) ||
                is_null($row['harga_beli']) ||
                is_null($row['harga_jual']) ||
                is_null($row['stok'])
            ) {
                throw new \Exception("Data tidak boleh kosong pada baris ke: " . json_encode($row));
            }

            if ($keuntungan <= 0) {
                throw new \Exception("Keuntungan persatuan 0 atau kurang dari 0 pada baris ke: " . json_encode($row));
            }

            // Cari kategori dan satuan berdasarkan nama
            $kategori = Kategori::where('kategori', $row['kategori'])->first();
            $satuan = Satuan::where('satuan', $row['satuan'])->first();

            if (!$kategori || !$satuan) {
                throw new \Exception("Kategori atau Satuan tidak ditemukan untuk data: " . json_encode($row));
            }

            // Data untuk update atau create
            $data = [
                'nama_barang' => $row['nama_barang'],
                'kategori_id' => $kategori->id,
                'satuan_id' => $satuan->id,
                'harga_beli' => $row['harga_beli'],
                'harga_jual' => $row['harga_jual'],
                'keuntungan' => $keuntungan,
                'stok' => $row['stok'],
            ];

            // Update or create barang
            Barang::updateOrCreate(
                $data
            );
        }
    }
}
