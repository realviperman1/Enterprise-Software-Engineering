<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Website;
use App\Services\TenantService;
use Symfony\Component\HttpFoundation\Response;

class IdentifyTenant
{
    public function __construct(
        private readonly TenantService $tenantService
    ) {}

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();

        // Resolve the tenant based on the requested domain
        $website = Website::where('domain', $host)
            ->where('status', 'active')
            ->first();

        if (!$website) {
            abort(404, 'Website not found or is currently inactive.');
        }

        // Bind the active tenant into our dedicated service
        $this->tenantService->setTenant($website);
        
        // Bind the Website model directly into the Service Container for easy dependency injection
        app()->instance(Website::class, $website);

        return $next($request);
    }
}
