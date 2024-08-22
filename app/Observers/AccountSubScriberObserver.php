<?php

namespace App\Observers;

use App\Models\AccountSubScriber;


class AccountSubScriberObserver
{
    public function creating(AccountSubScriber $accountSubScriber):void
    {
        $accountSubScriber->uuid = \Webpatser\Uuid\Uuid::generate()->string;
    }
    /**
     * Handle the AccountSubScriber "created" event.
     */
    public function created(AccountSubScriber $accountSubScriber): void
    {
        //
    }

    /**
     * Handle the AccountSubScriber "updated" event.
     */
    public function updated(AccountSubScriber $accountSubScriber): void
    {
        //
    }

    /**
     * Handle the AccountSubScriber "deleted" event.
     */
    public function deleted(AccountSubScriber $accountSubScriber): void
    {
        //
    }

    /**
     * Handle the AccountSubScriber "restored" event.
     */
    public function restored(AccountSubScriber $accountSubScriber): void
    {
        //
    }

    /**
     * Handle the AccountSubScriber "force deleted" event.
     */
    public function forceDeleted(AccountSubScriber $accountSubScriber): void
    {
        //
    }
}
