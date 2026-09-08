<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\WebsiteRepositoryInterface;
use App\Repositories\WebsiteRepository;
use App\Services\TenantService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind the interface to the concrete implementation for Dependency Injection
        $this->app->bind(WebsiteRepositoryInterface::class, WebsiteRepository::class);
        
        // Register TenantService as a Singleton to persist the tenant state across the request
        $this->app->singleton(TenantService::class, fn () => new TenantService());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

