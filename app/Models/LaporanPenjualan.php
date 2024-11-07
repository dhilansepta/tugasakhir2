<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanPenjualan extends Model
{
    use HasFactory;

    protected $table = 'laporanpenjualan';

    protected $fillable = [
        'laporan_id',
        'harga_jual',
        'keuntungan_persatuan',
        'keuntungan',
        'pendapatan_kotor',
        'kerugian',
        'pendapatan_sebenarnya',
    ];

    public function laporanstok(){
        return $this->belongsTo(LaporanStokBarang::class, foreignKey:'laporan_id');
    }
}
