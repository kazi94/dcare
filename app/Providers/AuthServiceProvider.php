<?php

namespace App\Providers;

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
        Models\Versement::class => PostPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('isAdmin', function ($user) {
            if ($user->role_id == '1')
                return true;
            else  false;
        });
        Gate::define('isDentist', function ($user) {
            if ($user->role_id == '2')
                return true;
            else  false;
        });
        Gate::define('isSecretary', function ($user) {
            if ($user->role_id == '3')
                return true;
            else  false;
        });
        Gate::define('payment.delete', 'App\Policies\PaymentPolicy@delete');
    }
}
