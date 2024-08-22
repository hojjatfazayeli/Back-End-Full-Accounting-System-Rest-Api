<?php

namespace App\Observers;

use App\Models\FiscalDocument;
use App\Models\Receipt;
use Illuminate\Support\Facades\Auth;

class ReceiptObserver
{
    public function creating(Receipt $receipt):void
    {
        $fiscal_document = FiscalDocument::find($receipt->fiscal_document_id);
        $receipt->uuid = \Webpatser\Uuid\Uuid::generate()->string;
        $receipt->creator_id = Auth::user()->id;
        $receipt->title = 'فیش بانکی سند شماره'.' '.$fiscal_document->serial_code;
    }
    /**
     * Handle the Receipt "created" event.
     */
    public function created(Receipt $receipt): void
    {
        //
    }

    /**
     * Handle the Receipt "updated" event.
     */
    public function updated(Receipt $receipt): void
    {
        //
    }

    /**
     * Handle the Receipt "deleted" event.
     */
    public function deleted(Receipt $receipt): void
    {
        //
    }

    /**
     * Handle the Receipt "restored" event.
     */
    public function restored(Receipt $receipt): void
    {
        //
    }

    /**
     * Handle the Receipt "force deleted" event.
     */
    public function forceDeleted(Receipt $receipt): void
    {
        //
    }
}
