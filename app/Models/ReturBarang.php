<?php

namespace App\Models;

use App\Observers\ReturBarangObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturBarang extends Model
{
    use HasFactory;

    protected $table = 'retur_barang';

    protected $fillable = [
        'barang_id',
        'jumlah',
        'status',
    ];

    public function barang(){
        return $this->belongsTo(Barang::class, foreignKey: 'barang_id');
    }
}
