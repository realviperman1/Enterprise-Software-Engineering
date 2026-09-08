<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Scopes\TenantScope;
use App\Models\Website;
use App\Services\TenantService;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToTenant
{
    /**
     * Boot the BelongsToTenant trait.
     */
    protected static function bootBelongsToTenant(): void
    {
        // Automatically apply the global scope to strictly isolate data
        static::addGlobalScope(new TenantScope());

        // Automatically assign the active tenant ID upon creation
        static::creating(function ($model) {
            if (! $model->website_id && app()->has(TenantService::class)) {
                $tenantService = app(TenantService::class);
                
                if ($tenantService->isIdentified()) {
                    $model->website_id = $tenantService->getTenantId();
                }
            }
        });
    }

    /**
     * Define the relationship to the Website (Tenant).
     */
    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class);
    }
}
