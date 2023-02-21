<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // owner session
        if (request()->is('owner*')) {
            config(['session.cookie' => 'session.cookie_owner']);
        }

        // admin session
        if (request()->is('admin*')) {
            config(['session.cookie' => 'session.cookie_admin']);
        }
    }
}
