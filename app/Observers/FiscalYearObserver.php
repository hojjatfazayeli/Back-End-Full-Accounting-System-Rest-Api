<?php

namespace App\Observers;

use App\Models\Cheque;
use App\Models\FiscalYear;

class FiscalYearObserver
{

    public function creating(FiscalYear $fiscalYear):void
    {
        $fiscalYear->uuid = \Webpatser\Uuid\Uuid::generate()->string;
    }
    /**
     * Handle the FiscalYear "created" event.
     */
    public function created(FiscalYear $fiscalYear): void
    {
        //
    }

    /**
     * Handle the FiscalYear "updated" event.
     */
    public function updated(FiscalYear $fiscalYear): void
    {
        //
    }

    /**
     * Handle the FiscalYear "deleted" event.
     */
    public function deleted(FiscalYear $fiscalYear): void
    {
        //
    }

    /**
     * Handle the FiscalYear "restored" event.
     */
    public function restored(FiscalYear $fiscalYear): void
    {
        //
    }

    /**
     * Handle the FiscalYear "force deleted" event.
     */
    public function forceDeleted(FiscalYear $fiscalYear): void
    {
        //
    }
}
