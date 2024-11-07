<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\BarangMasukObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([BarangMasukObserver::class])]
class BarangMasuk extends Model
{
    protected $table = 'barangmasuk';

    protected $fillable = [
        'barang_id',
        'harga_beli',
        'jumlah',
        'harga_persatuan',
    ];

    public function barang(){
        return $this->belongsTo(Barang::class, foreignKey: 'barang_id');
    }
}
