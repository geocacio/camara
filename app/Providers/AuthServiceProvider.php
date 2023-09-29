<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\User;
use App\Policies\UserPolicy;
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
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('master-access', [UserPolicy::class, 'masterAccess']);
        Gate::define('secretary-access', [UserPolicy::class, 'secretarieAccess']);
        // Gate::define('view-any-user', [UserPolicy::class, 'viewAny']);
        // Gate::define('create-user', [UserPolicy::class, 'create']);
        // Gate::define('update-user', [UserPolicy::class, 'update']);
        // Gate::define('delete-user', [UserPolicy::class, 'delete']);
    }
}
