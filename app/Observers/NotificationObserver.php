<?php

namespace App\Observers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationObserver
{
    public function creating(Notification $notification):void
    {
        $notification->uuid = \Webpatser\Uuid\Uuid::generate()->string;
        $notification->sender_id = Auth::user()->id;
        $notification->sender_role = Auth::user()->role;
    }
    /**
     * Handle the Notification "created" event.
     */
    public function created(Notification $notification): void
    {
        //
    }

    /**
     * Handle the Notification "updated" event.
     */
    public function updated(Notification $notification): void
    {
        //
    }

    /**
     * Handle the Notification "deleted" event.
     */
    public function deleted(Notification $notification): void
    {
        //
    }

    /**
     * Handle the Notification "restored" event.
     */
    public function restored(Notification $notification): void
    {
        //
    }

    /**
     * Handle the Notification "force deleted" event.
     */
    public function forceDeleted(Notification $notification): void
    {
        //
    }
}
