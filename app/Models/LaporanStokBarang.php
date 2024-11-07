<?php

namespace App\Models;

use App\Observers\LaporanStokObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([LaporanStokObserver::class])]
class LaporanStokBarang extends Model
{
    use HasFactory;
    
    protected $table = 'laporanstokbarang';

    protected $fillable = [
        'barang_id',
        'stok_awal',
        'stok_masuk',
        'stok_keluar',
        'stok_akhir',
        'stok_gudang',
        'stok_minus',
    ];

    public function barang(){
        return $this->belongsTo(Barang::class, foreignKey: 'barang_id');
    }
}
