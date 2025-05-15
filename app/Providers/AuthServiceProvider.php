<?php
namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;
use App\Models\ApplicationRequest;  // Add ApplicationRequest
use App\Policies\UserPolicy;       // Add UserPolicy
use App\Policies\ApplicationRequestPolicy;  // Add ApplicationRequestPolicy

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // Register UserPolicy for the User model
        User::class => UserPolicy::class,
        
        // Register ApplicationRequestPolicy for the ApplicationRequest model
        ApplicationRequest::class => ApplicationRequestPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}

