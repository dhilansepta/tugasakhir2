<?php

namespace App\Observers;

use App\Models\Barang;
use App\Models\LaporanStokBarang;
use App\Models\ReturBarang;

class ReturBarangObserver
{
    /**
     * Handle the ReturBarang "created" event.
     */
    public function created(ReturBarang $returBarang): void
    {
        $barangId = $returBarang->barang_id;
        $barang = Barang::find($barangId);
    }

    /**
     * Handle the ReturBarang "updated" event.
     */
    public function updated(ReturBarang $returBarang): void
    {
        //
    }

    /**
     * Handle the ReturBarang "deleted" event.
     */
    public function deleted(ReturBarang $returBarang): void
    {
        //
    }

    /**
     * Handle the ReturBarang "restored" event.
     */
    public function restored(ReturBarang $returBarang): void
    {
        //
    }

    /**
     * Handle the ReturBarang "force deleted" event.
     */
    public function forceDeleted(ReturBarang $returBarang): void
    {
        //
    }
}
