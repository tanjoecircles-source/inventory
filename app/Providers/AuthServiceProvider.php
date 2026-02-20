<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('isSeller', function($user) {
            return $user->type == 'seller';
        }); 
        Gate::define('isSellerDealer', function($user) {
            return $user->type == 'seller' && $user->ifseller == 'dealer';
        });        
        Gate::define('isAgent', function($user) {
            return $user->type == 'agent';
        });
        Gate::define('isAdmin', function($user) {
            return $user->type == 'admin';
        });
    }
}
