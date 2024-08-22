<?php

namespace App\Observers;

use App\Models\FiscalDocument;
use App\Models\FiscalTransaction;
use Illuminate\Support\Facades\Auth;

class FiscalTransactionObserver
{
    public function creating(FiscalTransaction $fiscalTransaction):void
    {
        $fiscalTransaction->uuid = \Webpatser\Uuid\Uuid::generate()->string;
        $fiscalTransaction->status = 'pending';
    }
    /**
     * Handle the FiscalTransaction "created" event.
     */
    public function created(FiscalTransaction $fiscalTransaction): void
    {
        //
    }

    /**
     * Handle the FiscalTransaction "updated" event.
     */
    public function updated(FiscalTransaction $fiscalTransaction): void
    {
        //
    }

    /**
     * Handle the FiscalTransaction "deleted" event.
     */
    public function deleted(FiscalTransaction $fiscalTransaction): void
    {
        //
    }

    /**
     * Handle the FiscalTransaction "restored" event.
     */
    public function restored(FiscalTransaction $fiscalTransaction): void
    {
        //
    }

    /**
     * Handle the FiscalTransaction "force deleted" event.
     */
    public function forceDeleted(FiscalTransaction $fiscalTransaction): void
    {
        //
    }
}
