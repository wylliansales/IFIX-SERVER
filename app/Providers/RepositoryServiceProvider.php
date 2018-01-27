<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        \App::bind('App\Repositories\UserRepository','App\Repositories\UserRepositoryEloquent');
        \App::bind('App\Repositories\SectorRepository','App\Repositories\SectorRepositoryEloquent');
    }
}
