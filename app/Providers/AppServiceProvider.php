<?php

namespace App\Providers;

use App\Models\AppSetting;
use App\Models\User;
use App\Models\Wood;
use App\Observers\WoodObserver;
use Illuminate\Support\Facades\Cache;
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

        if (Cache::has('app_settings_config')) {
            $appSetting = Cache::get('app_settings_config');
        } else {
            $appSetting = AppSetting::pluck('value', 'key_name')->toArray();
            Cache::forever('app_settings_config', $appSetting);
        }

        config(['app_settings' => $appSetting]);

        Wood::observe(WoodObserver::class);
    }
}
