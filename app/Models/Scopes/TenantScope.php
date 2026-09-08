<?php

declare(strict_types=1);

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use App\Services\TenantService;

class TenantScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        // Only apply the scope if a tenant has been successfully identified via the middleware
        if (app()->has(TenantService::class)) {
            $tenantService = app(TenantService::class);
            
            if ($tenantService->isIdentified()) {
                $builder->where($model->getTable() . '.website_id', $tenantService->getTenantId());
            }
        }
    }
}
