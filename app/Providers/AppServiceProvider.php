<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Wood;
use App\Observers\WoodObserver;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /* Register any application services. */
    public function register(): void
    {
        //
    }

    /* Bootstrap any application services. */
    public function boot(): void
    {
        Gate::define('admin', function (User $user) {
            return $user->role === 1;
        });
        Gate::define('user', function (User $user) {
            return $user->role === 2;
        });
        Gate::define('guest', function (User $user) {
            return $user->role === 3;
        });

        Wood::observe(WoodObserver::class);
    }
}
