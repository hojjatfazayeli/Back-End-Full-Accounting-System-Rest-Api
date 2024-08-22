<?php

namespace App\Observers;

use App\Models\FiscalDocument;
use Illuminate\Support\Facades\Auth;

class FiscalDocumentObserver
{
    public function creating(FiscalDocument $fiscalDocument):void
    {
        $fiscalDocument->uuid = \Webpatser\Uuid\Uuid::generate()->string;
        $fiscalDocument->creator_id = Auth::user()->id;
        $fiscalDocument->serial_code = mt_rand('11111' , '99999');
    }
    /**
     * Handle the FiscalDocument "created" event.
     */
    public function created(FiscalDocument $fiscalDocument): void
    {
        //
    }

    /**
     * Handle the FiscalDocument "updated" event.
     */
    public function updated(FiscalDocument $fiscalDocument): void
    {
        //
    }

    /**
     * Handle the FiscalDocument "deleted" event.
     */
    public function deleted(FiscalDocument $fiscalDocument): void
    {
        //
    }

    /**
     * Handle the FiscalDocument "restored" event.
     */
    public function restored(FiscalDocument $fiscalDocument): void
    {
        //
    }

    /**
     * Handle the FiscalDocument "force deleted" event.
     */
    public function forceDeleted(FiscalDocument $fiscalDocument): void
    {
        //
    }
}
