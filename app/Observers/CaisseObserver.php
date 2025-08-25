<?php

namespace App\Observers;

use App\Models\Caisse;

class CaisseObserver
{
    /**
     * Handle the Caisse "created" event.
     */
    public function created(Caisse $caisse): void
    {
        //
    }

    /**
     * Handle the Caisse "updated" event.
     */
    public function updated(Caisse $caisse): void
    {
        //
    }

    /**
     * Handle the Caisse "deleted" event.
     */
    public function deleted(Caisse $caisse): void
    {
        //
    }

    /**
     * Handle the Caisse "restored" event.
     */
    public function restored(Caisse $caisse): void
    {
        //
    }

    /**
     * Handle the Caisse "force deleted" event.
     */
    public function forceDeleted(Caisse $caisse): void
    {
        //
    }
}
