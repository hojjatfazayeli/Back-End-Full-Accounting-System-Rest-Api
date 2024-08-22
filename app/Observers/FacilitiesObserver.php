<?php

namespace App\Observers;

use App\Models\Facilities;

class FacilitiesObserver
{
    public function creating(Facilities $facilities):void
    {
        $facilities->uuid = \Webpatser\Uuid\Uuid::generate()->string;
        $facilities->code = rand(11111,99999);
    }
    /**
     * Handle the Facilities "created" event.
     */
    public function created(Facilities $facilities): void
    {
        //
    }

    /**
     * Handle the Facilities "updated" event.
     */
    public function updated(Facilities $facilities): void
    {
        //
    }

    /**
     * Handle the Facilities "deleted" event.
     */
    public function deleted(Facilities $facilities): void
    {
        //
    }

    /**
     * Handle the Facilities "restored" event.
     */
    public function restored(Facilities $facilities): void
    {
        //
    }

    /**
     * Handle the Facilities "force deleted" event.
     */
    public function forceDeleted(Facilities $facilities): void
    {
        //
    }
}
