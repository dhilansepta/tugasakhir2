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
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->foreignId('kategori_id')->constrained('kategori')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('satuan_id')->constrained('satuan')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('harga_beli');
            $table->integer('harga_jual');
            $table->integer('keuntungan')->nullable();
            $table->integer('stok')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
