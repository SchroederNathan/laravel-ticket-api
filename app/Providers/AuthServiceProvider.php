<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Ticket;
use App\Models\User;
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
        Ticket::class => \App\Policies\V1\TicketPolicy::class,
        User::class => \App\Policies\V1\UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Handle the array format used in ApiController::isAble
        Gate::before(function ($user, $ability, $arguments) {
            if (count($arguments) === 2 && is_array($arguments[0]) && count($arguments[0]) === 2) {
                $model = $arguments[0][0];
                $policyClass = $arguments[0][1];
                
                if (class_exists($policyClass)) {
                    $policy = app($policyClass);
                    if (method_exists($policy, $ability)) {
                        return $policy->$ability($user, $model);
                    }
                }
            }
        });
    }
}