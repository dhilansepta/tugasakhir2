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
        Schema::create('laporanpenjualan', function (Blueprint $table) {
            $table->id(); //auto
            $table->timestamps(); //auto
            $table->foreignId('laporan_id')->constrained('laporanstokbarang')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('harga_jual')->default(0);
            $table->integer('keuntungan_persatuan')->default(0);
            $table->integer('keuntungan')->default(0);
            $table->integer('pendapatan_kotor')->default(0);
            $table->integer('kerugian')->default(0);
            $table->integer('pendapatan_sebenarnya')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporanpenjualan');
    }
};
