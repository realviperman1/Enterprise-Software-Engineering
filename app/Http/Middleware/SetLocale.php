<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Models\Language;
use App\Services\TenantService;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function __construct(
        private readonly TenantService $tenantService
    ) {}

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Get the first segment of the URL which should represent the locale
        $localeSegment = $request->segment(1);

        // 2. Fetch active languages from the DB (In production, this is heavily cached)
        $activeLocales = Language::where('is_active', true)->pluck('code')->toArray();

        // 3. Determine if the URL contains a valid active locale
        if ($localeSegment && in_array($localeSegment, $activeLocales, true)) {
            App::setLocale($localeSegment);
        } else {
            // 4. Fallback if no valid locale is present in the URL
            // Read the active tenant's default locale, otherwise default to global 'en'
            if ($this->tenantService->isIdentified()) {
                $tenant = $this->tenantService->getTenant();
                App::setLocale($tenant->default_locale ?? 'en');
            } else {
                App::setLocale('en');
            }
        }

        return $next($request);
    }
}
