<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Passport::tokensCan([
           'manage-user'            => 'Manage user',
           'read-only-user'         => 'Read only user',
           'edit-only-user'         => 'Edit only user',
           'manage-attendant'       => 'Manage attendant',
           'read-only-attendant'    => 'Read only attendant',
           'edit-only-attendant'    => 'Edit only attendant',
        ]);

         Passport::tokensExpireIn(now()->addDays(30));
//
//        Passport::refreshTokensExpireIn(now()->addHours(1));
    }
}
