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
        Schema::create('barangmasuk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barang')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('harga_beli');
            $table->integer('jumlah');
            $table->integer('harga_persatuan')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangmasuk');
    }
};
