<?php

namespace App\Observers;

use App\Models\Wood;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Auth;

class WoodObserver implements ShouldHandleEventsAfterCommit
{
    /* Handle the Wood "creating" event. */
    public function creating(Wood $wood): void
    {
        $wood->user_created = Auth::id();
        $wood->user_updated = Auth::id();
    }

    /* Handle the Wood "updating" event. */
    public function updating(Wood $wood): void
    {
        $wood->user_updated = Auth::id();
    }

    /* Handle the Wood "deleting" event. */
    public function deleting(Wood $wood): void
    {
        $wood->user_updated = Auth::id();
        $wood->saveQuietly();
    }

    /* Handle the Wood "restoring" event. */
    public function restoring(Wood $wood): void
    {
        $wood->user_updated = Auth::id();
        $wood->saveQuietly();
    }

    /* Handle the Wood "force deleting" event. */
    public function forceDeleting(Wood $wood): void
    {
        $wood->user_updated = Auth::id();
        $wood->saveQuietly();
    }
}
