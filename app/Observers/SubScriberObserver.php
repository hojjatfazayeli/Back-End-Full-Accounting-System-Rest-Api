<?php

namespace App\Observers;

use App\Models\SubScriber;
use Illuminate\Support\Facades\Storage;

class SubScriberObserver
{

    public function creating(SubScriber $subScriber):void
    {
        $subScriber->uuid = \Webpatser\Uuid\Uuid::generate()->string;
    }
    /**
     * Handle the SubScriber "created" event.
     */
    public function created(SubScriber $subScriber): void
    {
        //
    }

    public function updating(SubScriber $subScriber): void
    {
        /*        if (request()->has('avatar'))
                {
                    Storage::delete($subScriber->avatar);
                }*/
    }
    /**
     * Handle the SubScriber "updated" event.
     */
    public function updated(SubScriber $subScriber): void
    {
/*        if (request()->has('avatar'))
        {
            Storage::delete($subScriber->avatar);
        }*/
    }

    /**
     * Handle the SubScriber "deleted" event.
     */
    public function deleted(SubScriber $subScriber): void
    {
        //
    }

    /**
     * Handle the SubScriber "restored" event.
     */
    public function restored(SubScriber $subScriber): void
    {
        //
    }

    /**
     * Handle the SubScriber "force deleted" event.
     */
    public function forceDeleted(SubScriber $subScriber): void
    {
        //
    }
}
