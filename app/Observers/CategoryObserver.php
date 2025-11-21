<?php

namespace App\Observers;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryObserver
{
    /* Handle the Category "creating" event. */
    public function creating(Category $category): void
    {
        $category->user_created = Auth::id();
        $category->user_updated = Auth::id();
    }

    /* Handle the Category "updating" event. */
    public function updating(Category $category): void
    {
        $category->user_updated = Auth::id();
    }

    /* Handle the Category "deleting" event. */
    public function deleting(Category $category): void
    {
        $category->user_updated = Auth::id();
        $category->saveQuietly();
    }

    /* Handle the Category "restoring" event. */
    public function restoring(Category $category): void
    {
        $category->user_updated = Auth::id();
        $category->saveQuietly();
    }

    /* Handle the Category "force deleting" event. */
    public function forceDeleting(Category $category): void
    {
        $category->user_updated = Auth::id();
        $category->saveQuietly();
    }
}
