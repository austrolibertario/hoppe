<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        view()->composer('*', function ($view) {
            $view->with('currentUser', \Auth::user());
            $view->with('siteStat', app('App\Phphub\Stat\Stat')->getSiteStat());
         });
    }

    public function register()
    {
    }
}
