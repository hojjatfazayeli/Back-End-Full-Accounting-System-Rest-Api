<?php

namespace App\Observers;

use App\Models\FamilySubScriber;
use App\Models\FiscalDocumentItem;
use Illuminate\Support\Facades\Auth;

class FiscalDocumentItemObserver
{
    public function creating(FiscalDocumentItem $fiscalDocumentItem):void
    {
        $fiscalDocumentItem->uuid = \Webpatser\Uuid\Uuid::generate()->string;
        $fiscalDocumentItem->creator_id = Auth::user()->id;
    }
    /**
     * Handle the FiscalDocumentItem "created" event.
     */
    public function created(FiscalDocumentItem $fiscalDocumentItem): void
    {
        //
    }

    /**
     * Handle the FiscalDocumentItem "updated" event.
     */
    public function updated(FiscalDocumentItem $fiscalDocumentItem): void
    {
        //
    }

    /**
     * Handle the FiscalDocumentItem "deleted" event.
     */
    public function deleted(FiscalDocumentItem $fiscalDocumentItem): void
    {
        //
    }

    /**
     * Handle the FiscalDocumentItem "restored" event.
     */
    public function restored(FiscalDocumentItem $fiscalDocumentItem): void
    {
        //
    }

    /**
     * Handle the FiscalDocumentItem "force deleted" event.
     */
    public function forceDeleted(FiscalDocumentItem $fiscalDocumentItem): void
    {
        //
    }
}
