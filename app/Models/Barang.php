<?php

namespace App\Models;

use App\Observers\BarangObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

#[ObservedBy([BarangObserver::class])]
class Barang extends Model
{

    use Notifiable;
    
    protected $table = 'barang';

    protected $fillable = [
        'nama_barang',
        'kategori_id',
        'satuan_id',
        'harga_beli',
        'harga_jual',
        'keuntungan',
        'stok',
    ];

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'satuan_id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class, 'barang_id');
    }

    public function barangKeluar()
    {
        return $this->hasMany(BarangKeluar::class, 'barang_id');
    }

    public function laporanstok()
    {
        return $this->hasMany(LaporanStokBarang::class, 'barang_id');
    }

    public function hargaBeliVersion()
    {
        return $this->hasMany(HargaBeliVersion::class);
    }
}
