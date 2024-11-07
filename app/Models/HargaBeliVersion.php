<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HargaBeliVersion extends Model
{
    protected $table = 'harga_beli_version';

    // Define which fields are mass assignable
    protected $fillable = ['barang_id','harga_persatuan'];

    // Relationship back to BarangMasuk
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
