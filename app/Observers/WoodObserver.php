<?php

namespace App\Observers;

use App\Models\Wood;
use Illuminate\Support\Facades\Auth;

class WoodObserver
{
    /* Handle the Wood "created" event. */
    public function created(Wood $wood): void
    {
        $wood->user_created = Auth::id();
        $wood->user_updated = Auth::id();
    }

    /* Handle the Wood "updated" event. */
    public function updated(Wood $wood): void
    {
        $wood->user_updated = Auth::id();
    }

    /* Handle the Wood "deleted" event. */
    public function deleted(Wood $wood): void
    {
        if ($wood->isDirty('deleted_at')) {
            $wood->user_updated = Auth::id();
            $wood->saveQuietly();
        }
    }

    /* Handle the Wood "restored" event. */
    public function restored(Wood $wood): void
    {
        $wood->user_updated = Auth::id();
        $wood->saveQuietly();
    }

    /* Handle the Wood "force deleted" event. */
    public function forceDeleted(Wood $wood): void
    {
        $wood->user_updated = Auth::id();
        $wood->saveQuietly();
    }
}
