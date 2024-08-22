<?php

namespace App\Observers;

use App\Models\Admin;
use Faker\Core\Uuid;
use Illuminate\Support\Facades\Storage;

class AdminObserver
{

    public function creating(Admin $admin):void
    {
        $admin->uuid = \Webpatser\Uuid\Uuid::generate()->string;
    }
    /**
     * Handle the Admin "created" event.
     */
    public function created(Admin $admin): void
    {
        //
    }

    public function updating(Admin $admin)
    {
        //
    }

    /**
     * Handle the Admin "updated" event.
     */
    public function updated(Admin $admin): void
    {
    //
    }

    public function deleting(Admin $admin):void
    {
        if (request()->has('avatar'))
        {
            Storage::delete($admin->avatar);
        }
    }

    /**
     * Handle the Admin "deleted" event.
     */
    public function deleted(Admin $admin): void
    {
        //
    }

    /**
     * Handle the Admin "restored" event.
     */
    public function restored(Admin $admin): void
    {
        //
    }

    /**
     * Handle the Admin "force deleted" event.
     */
    public function forceDeleted(Admin $admin): void
    {
        //
    }
}
