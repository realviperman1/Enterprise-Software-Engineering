<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Website;
use Illuminate\View\View;

class StorefrontController extends Controller
{
    /**
     * Show the highly-optimized public homepage for the active tenant.
     */
    public function index(): View
    {
        // 1. O(1) resolution of the active tenant instantly from the Service Container.
        // The IdentityTenant middleware guaranteed this binding before the controller even booted.
        $tenant = app(Website::class);

        // 2. Dummy data for Phase 4 proof of concept.
        // In Phase 5, this will be dynamically retrieved via: Tour::all() (which is inherently TenantScoped).
        $tours = [
            [
                'title' => 'City Highlights',
                'description' => 'Discover the best monuments and hidden gems with our expert local guides.',
                'price' => 49.99,
                'image_url' => 'https://via.placeholder.com/600x400?text=City+Highlights'
            ],
            [
                'title' => 'VIP Exclusive Experience',
                'description' => 'Skip the lines with premium service, private transport, and champagne.',
                'price' => 199.99,
                'image_url' => 'https://via.placeholder.com/600x400?text=VIP+Experience'
            ],
            [
                'title' => 'Gastronomy Tour',
                'description' => 'Taste the absolute best local cuisines in authentic historical venues.',
                'price' => 89.50,
                'image_url' => 'https://via.placeholder.com/600x400?text=Gastronomy'
            ]
        ];

        return view('home', compact('tenant', 'tours'));
    }
}
