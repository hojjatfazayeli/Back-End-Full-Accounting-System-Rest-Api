<?php

namespace App\Observers;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageObserver
{
    public function creating(Message $message):void
    {
        $message->uuid = \Webpatser\Uuid\Uuid::generate()->string;
        $message->sender_id = Auth::user()->id;
        $message->sender_role = Auth::user()->role;
    }
    /**
     * Handle the Message "created" event.
     */
    public function created(Message $message): void
    {
        //
    }

    /**
     * Handle the Message "updated" event.
     */
    public function updated(Message $message): void
    {
        //
    }

    /**
     * Handle the Message "deleted" event.
     */
    public function deleted(Message $message): void
    {
        //
    }

    /**
     * Handle the Message "restored" event.
     */
    public function restored(Message $message): void
    {
        //
    }

    /**
     * Handle the Message "force deleted" event.
     */
    public function forceDeleted(Message $message): void
    {
        //
    }
}
