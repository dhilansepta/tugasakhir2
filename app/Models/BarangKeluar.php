<?php

namespace App\Models;

use App\Observers\BarangKeluarObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([BarangKeluarObserver::class])]
class BarangKeluar extends Model
{
    use HasFactory;

    protected $table = 'barangkeluar';

    protected $fillable = [
        'barang_id',
        'karyawan_id',
        'jumlahKeluar',
    ];

    public function barang(){
        return $this->belongsTo(Barang::class, foreignKey: 'barang_id');
    }
    public function users(){
        return $this->belongsTo(User::class, foreignKey: 'karyawan_id');
    }
}
