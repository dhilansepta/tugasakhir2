<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;


class DaftarBarangExport implements FromQuery, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;

    public function query()
    {
        return Barang::selectRaw("barang.*, 
        null as id, 
        null as nama_barang, 
        null as kategori_id, 
        null as satuan_id, 
        null as harga_beli,
        null as harga_jual,
        null as keuntungan,
        null as stok,
        null as created_at,
        null as updated_at");
    }


    public function headings(): array
    {
        return [
            "id",
            "nama_barang",
            "kategori",
            "satuan",
            "harga_beli",
            "harga_jual",
            "stok",
        ];
    }
}
