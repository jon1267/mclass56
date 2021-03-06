<?php

namespace App\Providers;

use App\Entity\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        //'App\Model' => 'App\Policies\ModelPolicy',
    ];

    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin-panel', function (User $user) {
            return $user->isAdmin(); //если надо: || $user->isModerator();
        });

        //Gate::define('users-manage', function (User $user) {
        //    return $user->isUsersManager();
        //});
    }
}
