<?php

namespace App\Observers;

use App\Models\ChequeSheet;

class ChequeSheetObserver
{

    public function creating(ChequeSheet $chequeSheet):void
    {
        $chequeSheet->uuid = \Webpatser\Uuid\Uuid::generate()->string;
    }
    /**
     * Handle the ChequeSheet "created" event.
     */
    public function created(ChequeSheet $chequeSheet): void
    {
        //
    }

    /**
     * Handle the ChequeSheet "updated" event.
     */
    public function updated(ChequeSheet $chequeSheet): void
    {
        //
    }

    /**
     * Handle the ChequeSheet "deleted" event.
     */
    public function deleted(ChequeSheet $chequeSheet): void
    {
        //
    }

    /**
     * Handle the ChequeSheet "restored" event.
     */
    public function restored(ChequeSheet $chequeSheet): void
    {
        //
    }

    /**
     * Handle the ChequeSheet "force deleted" event.
     */
    public function forceDeleted(ChequeSheet $chequeSheet): void
    {
        //
    }
}
