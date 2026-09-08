<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\Website;
use App\Models\Reservation;
use App\Models\Scopes\TenantScope;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Main Admin Dashboard
     */
    public function dashboard()
    {
        $websitesCount = Website::count();
        $toursCount = Tour::withoutGlobalScope(TenantScope::class)->count();
        $reservationsCount = Reservation::withoutGlobalScope(TenantScope::class)->count();
        $totalRevenue = Reservation::withoutGlobalScope(TenantScope::class)->where('status', 'confirmed')->sum('total_amount');
        
        return view('admin.dashboard', compact('websitesCount', 'toursCount', 'reservationsCount', 'totalRevenue'));
    }

    /**
     * List all Tours (Master + Overrides)
     */
    public function tours()
    {
        $tours = Tour::withoutGlobalScope(TenantScope::class)
            ->with(['website', 'parentTour'])
            ->get();
            
        $websites = Website::all();
            
        return view('admin.tours', compact('tours', 'websites'));
    }

    /**
     * Save a Master Tour or an Override for a specific Tenant
     */
    public function saveTour(Request $request)
    {
        $validated = $request->validate([
            'tour_id' => 'required|integer', // 0 for new
            'name_en' => 'required|string',
            'name_fr' => 'required|string',
            'description_en' => 'required|string',
            'description_fr' => 'required|string',
            'base_price' => 'required|numeric',
            'website_id' => 'nullable|integer|exists:websites,id',
            'parent_tour_id' => 'nullable|integer|exists:tours,id',
        ]);
        
        $data = [
            'name' => ['en' => $validated['name_en'], 'fr' => $validated['name_fr']],
            'description' => ['en' => $validated['description_en'], 'fr' => $validated['description_fr']],
            'base_price' => $validated['base_price'],
            'website_id' => $validated['website_id'],
            'parent_tour_id' => $validated['parent_tour_id'],
        ];
        
        if ($validated['tour_id'] > 0) {
            $tour = Tour::withoutGlobalScope(TenantScope::class)->findOrFail($validated['tour_id']);
            $tour->update($data);
            $msg = 'Tour updated successfully.';
        } else {
            Tour::withoutGlobalScope(TenantScope::class)->create($data);
            $msg = 'Override created successfully.';
        }
        
        return back()->with('success', $msg);
    }

    /**
     * Centralized Bookings Table
     */
    public function bookings()
    {
        $reservations = Reservation::withoutGlobalScope(TenantScope::class)
            ->with('website')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('admin.bookings', compact('reservations'));
    }
}
