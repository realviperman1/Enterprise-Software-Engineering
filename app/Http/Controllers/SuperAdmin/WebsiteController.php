<?php

declare(strict_types=1);

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Website;
use App\Models\Language;
use App\Models\Reservation;
use App\Models\Scopes\TenantScope;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WebsiteController extends Controller
{
    /**
     * Display a centralized list of all websites and global system activity.
     */
    public function index(): View
    {
        // SuperAdmins manage all sites. Website model isn't tenant scoped natively, 
        // but we eagerly load counts to strictly prevent N+1 queries.
        $websites = Website::withCount('reservations')->get();

        // Architectural Crucial Step: By default, Reservation has a BelongsToTenant trait enforcing TenantScope.
        // As a SuperAdmin, we strip the global scope entirely to view data across ALL 5 tenants simultaneously.
        // We also strictly eager load the `website` relationship to prevent N+1 issues when rendering the view.
        $globalReservations = Reservation::withoutGlobalScope(TenantScope::class)
            ->with('website')
            ->latest()
            ->take(15)
            ->get();

        return view('superadmin.websites.index', compact('websites', 'globalReservations'));
    }

    /**
     * Show the form for editing the translatable settings of a specific tenant.
     */
    public function edit(Website $website): View
    {
        // Eager load active languages to generate the translation UI tabs.
        $languages = Language::where('is_active', true)->get();

        return view('superadmin.websites.edit', compact('website', 'languages'));
    }
}
