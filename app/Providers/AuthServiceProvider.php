<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\ApplicationRequest;
use App\Policies\ApplicationRequestPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        ApplicationRequest::class => ApplicationRequestPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
