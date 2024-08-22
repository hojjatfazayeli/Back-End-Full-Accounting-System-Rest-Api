<?php

namespace App\Observers;

use App\Models\FamilySubScriber;
class FamilySubScriberObserver
{
    public function creating(FamilySubScriber $familySubScriber):void
    {
        $familySubScriber->uuid = \Webpatser\Uuid\Uuid::generate()->string;
    }
    /**
     * Handle the FamilySubScriberObserver "created" event.
     */
    public function created(FamilySubScriber $familySubScriber): void
    {
        //
    }

    /**
     * Handle the FamilySubScriberObserver "updated" event.
     */
    public function updated(FamilySubScriber $familySubScriber): void
    {
        //
    }

    /**
     * Handle the FamilySubScriberObserver "deleted" event.
     */
    public function deleted(FamilySubScriber $familySubScriber): void
    {
        //
    }

    /**
     * Handle the FamilySubScriberObserver "restored" event.
     */
    public function restored(FamilySubScriber $familySubScriber): void
    {
        //
    }

    /**
     * Handle the FamilySubScriberObserver "force deleted" event.
     */
    public function forceDeleted(FamilySubScriber $familySubScriber): void
    {
        //
    }
}
