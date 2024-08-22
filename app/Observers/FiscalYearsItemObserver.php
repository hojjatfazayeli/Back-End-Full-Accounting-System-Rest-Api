<?php

namespace App\Observers;

use App\Models\FiscalYearsItem;

class FiscalYearsItemObserver
{

    public function creating(FiscalYearsItem $fiscalYearsItem):void
    {
        $fiscalYearsItem->uuid = \Webpatser\Uuid\Uuid::generate()->string;
    }
    /**
     * Handle the FiscalYearsItem "created" event.
     */
    public function created(FiscalYearsItem $fiscalYearsItem): void
    {
        //
    }

    /**
     * Handle the FiscalYearsItem "updated" event.
     */
    public function updated(FiscalYearsItem $fiscalYearsItem): void
    {
        //
    }

    /**
     * Handle the FiscalYearsItem "deleted" event.
     */
    public function deleted(FiscalYearsItem $fiscalYearsItem): void
    {
        //
    }

    /**
     * Handle the FiscalYearsItem "restored" event.
     */
    public function restored(FiscalYearsItem $fiscalYearsItem): void
    {
        //
    }

    /**
     * Handle the FiscalYearsItem "force deleted" event.
     */
    public function forceDeleted(FiscalYearsItem $fiscalYearsItem): void
    {
        //
    }
}
