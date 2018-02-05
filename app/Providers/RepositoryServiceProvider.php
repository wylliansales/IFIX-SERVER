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
        \App::bind('App\Repositories\EquipmentRepository','App\Repositories\EquipmentRepositoryEloquent');
        \App::bind('App\Repositories\DepartmentRepository','App\Repositories\DepartmentRepositoryEloquent');
        \App::bind('App\Repositories\CategoryRepository','App\Repositories\CategoryRepositoryEloquent');
        \App::bind('App\Repositories\RequestRepository','App\Repositories\RequestRepositoryEloquent');
        \App::bind('App\Repositories\AttendantRepository','App\Repositories\AttendantRepositoryEloquent');
    }
}
