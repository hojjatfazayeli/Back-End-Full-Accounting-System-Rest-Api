<?php

namespace App\Observers;

use App\Models\AccountGroupe;
use Webpatser\Uuid\Uuid;

class AccountGroupeObserer
{

    /**
     * Handle the AccountGroupe "creating" event.
     */
    public function creating(AccountGroupe $accountGroupe): void
    {
        $accountGroupe->uuid = Uuid::generate()->string;
    }

    /**
     * Handle the AccountGroupe "created" event.
     */
    public function created(AccountGroupe $accountGroupe): void
    {
        //
    }

    /**
     * Handle the AccountGroupe "updated" event.
     */
    public function updated(AccountGroupe $accountGroupe): void
    {
        //
    }

    /**
     * Handle the AccountGroupe "deleted" event.
     */
    public function deleted(AccountGroupe $accountGroupe): void
    {
        //
    }

    /**
     * Handle the AccountGroupe "restored" event.
     */
    public function restored(AccountGroupe $accountGroupe): void
    {
        //
    }

    /**
     * Handle the AccountGroupe "force deleted" event.
     */
    public function forceDeleted(AccountGroupe $accountGroupe): void
    {
        //
    }
}
