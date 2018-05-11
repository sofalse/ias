<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Auth;
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

        /**
         * Ability to register new users.
         * Required role: 2 (admin)
         * @param App\User $user
         * @return boolean
         */
        Gate::define('register-user', function() {
            return Auth::user()->role == 2;
        });

        /**
         * Ability to edit its own content.
         * Required to be an author of the content.
         * @param int $author
         * @return boolean
         */
        Gate::define('edit', function($user, $author) {
            return $user->id === $author || $user->role === 2;
        });
    }
}
