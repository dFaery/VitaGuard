<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Data\Value\Account\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Article::class => ArticlePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        // TODO: GANTI KE FOR LOOPS AND MAKE IT MORE ROBUST
        Gate::define(Role::MEMBER->value, function ($user) {
            return $user->role == Role::MEMBER->value;
        });
        Gate::define(Role::DOCTOR->value, function ($user) {
            return $user->role == Role::DOCTOR->value;
        });
        Gate::define(Role::FACILITY_ADMIN->value, function ($user) {
            return $user->role == Role::FACILITY_ADMIN->value;
        });
        Gate::define(Role::ADMIN->value, function ($user) {
            return $user->role == Role::ADMIN->value;
        });
    }
}
