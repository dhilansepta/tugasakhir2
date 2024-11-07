<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporanstokbarang', function (Blueprint $table) {
            $table->id(); //auto
            $table->timestamps(); //auto
            $table->foreignId('barang_id')->constrained('barang')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('stok_awal');
            $table->integer('stok_masuk')->default(0);
            $table->integer('stok_keluar')->default(0);
            $table->integer('stok_akhir');
            $table->integer('stok_gudang')->default(0);
            $table->integer('stok_minus')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporanstokbarang');
    }
};
