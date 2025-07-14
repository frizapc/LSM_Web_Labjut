<?php

namespace App\Observers;

use App\Models\user;
use Illuminate\Support\Facades\Storage;

class ProfileObserver
{
    /**
     * Handle the user "created" event.
     */
    public function created(user $user): void
    {
        //
    }

    /**
     * Handle the user "updating" event.
     */
    public function updating(user $user): void
    {
        if ($user->photo) {
            Storage::delete($user->getOriginal('photo') ?: '');
            $filename = uniqid('course_') . '.' . $user->photo->extension();
            $user->photo = $user->photo->storeAs('profiles', $filename);
        } else {
            unset($user->photo);
        }
    }

    /**
     * Handle the user "deleted" event.
     */
    public function deleted(user $user): void
    {
        //
    }

    /**
     * Handle the user "restored" event.
     */
    public function restored(user $user): void
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     */
    public function forceDeleted(user $user): void
    {
        //
    }
}
