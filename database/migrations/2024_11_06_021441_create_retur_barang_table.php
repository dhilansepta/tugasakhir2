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
        Schema::create('retur_barang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barang')->onUpdate('cascade');
            $table->string('jumlah');
            $table->enum('status', ['expired', 'rusak', 'dikembalikan'])->default('expired');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retur_barang');
    }
};
