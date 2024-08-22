<?php

namespace App\Observers;

use App\Models\Cheque;

class ChequeObserver
{
    public function creating(Cheque $cheque):void
    {
        $cheque->uuid = \Webpatser\Uuid\Uuid::generate()->string;
    }
    /**
     * Handle the Cheque "created" event.
     */
    public function created(Cheque $cheque): void
    {
        //
    }

    /**
     * Handle the Cheque "updated" event.
     */
    public function updated(Cheque $cheque): void
    {
        //
    }

    /**
     * Handle the Cheque "deleted" event.
     */
    public function deleted(Cheque $cheque): void
    {
        //
    }

    /**
     * Handle the Cheque "restored" event.
     */
    public function restored(Cheque $cheque): void
    {
        //
    }

    /**
     * Handle the Cheque "force deleted" event.
     */
    public function forceDeleted(Cheque $cheque): void
    {
        //
    }
}
