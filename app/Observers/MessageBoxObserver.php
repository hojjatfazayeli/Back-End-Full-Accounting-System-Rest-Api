<?php

namespace App\Observers;

use App\Models\Message;
use App\Models\MessageBox;
use Illuminate\Support\Facades\Auth;

class MessageBoxObserver
{
    public function creating(MessageBox $messageBox):void
    {
        $messageBox->sender_id = Auth::user()->id;
        $messageBox->sender_role = Auth::user()->role;
    }
    /**
     * Handle the MessageBox "created" event.
     */
    public function created(MessageBox $messageBox): void
    {
        //
    }

    /**
     * Handle the MessageBox "updated" event.
     */
    public function updated(MessageBox $messageBox): void
    {
        //
    }

    /**
     * Handle the MessageBox "deleted" event.
     */
    public function deleted(MessageBox $messageBox): void
    {
        //
    }

    /**
     * Handle the MessageBox "restored" event.
     */
    public function restored(MessageBox $messageBox): void
    {
        //
    }

    /**
     * Handle the MessageBox "force deleted" event.
     */
    public function forceDeleted(MessageBox $messageBox): void
    {
        //
    }
}
