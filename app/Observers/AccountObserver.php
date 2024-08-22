<?php

namespace App\Observers;

use App\Models\Account;
use Webpatser\Uuid\Uuid;

class AccountObserver
{
    /**
     * Handle the Account "creating" event.
     */
    public function creating(Account $account): void
    {
        $account->uuid = Uuid::generate()->string;

    }

    /**
     * Handle the Account "created" event.
     */
    public function created(Account $account): void
    {
        //
    }

    /**
     * Handle the Account "updated" event.
     */
    public function updated(Account $account): void
    {
        //
    }

    /**
     * Handle the Account "deleted" event.
     */
    public function deleted(Account $account): void
    {
        //
    }

    /**
     * Handle the Account "restored" event.
     */
    public function restored(Account $account): void
    {
        //
    }

    /**
     * Handle the Account "force deleted" event.
     */
    public function forceDeleted(Account $account): void
    {
        //
    }
}
