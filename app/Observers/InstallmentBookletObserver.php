<?php

namespace App\Observers;

use App\Models\InstallmentBooklet;

class InstallmentBookletObserver
{
    public function creating(InstallmentBooklet $installmentBooklet):void
    {
        $installmentBooklet->uuid = \Webpatser\Uuid\Uuid::generate()->string;
    }
    /**
     * Handle the InstallmentBooklet "created" event.
     */
    public function created(InstallmentBooklet $installmentBooklet): void
    {
        //
    }

    /**
     * Handle the InstallmentBooklet "updated" event.
     */
    public function updated(InstallmentBooklet $installmentBooklet): void
    {
        //
    }

    /**
     * Handle the InstallmentBooklet "deleted" event.
     */
    public function deleted(InstallmentBooklet $installmentBooklet): void
    {
        //
    }

    /**
     * Handle the InstallmentBooklet "restored" event.
     */
    public function restored(InstallmentBooklet $installmentBooklet): void
    {
        //
    }

    /**
     * Handle the InstallmentBooklet "force deleted" event.
     */
    public function forceDeleted(InstallmentBooklet $installmentBooklet): void
    {
        //
    }
}
