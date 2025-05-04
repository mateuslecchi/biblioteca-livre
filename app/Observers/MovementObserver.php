<?php

namespace App\Observers;

use App\Models\Movement;

class MovementObserver
{
    /**
     * Handle the Movement "created" event.
     */
    public function created(Movement $movement): void
    {
        $movement->asset->update(['location'=>$movement->destination_location]);
    }

    /**
     * Handle the Movement "updated" event.
     */
    public function updated(Movement $movement): void
    {
        $movement->asset->update(['location'=>$movement->destination_location]);
    }

    /**
     * Handle the Movement "deleted" event.
     */
    public function deleted(Movement $movement): void
    {
        $movement->asset->update(['location'=>$movement->origin_location]);
    }
}
