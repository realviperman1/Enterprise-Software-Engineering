<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\TourAvailability;
use Illuminate\Http\JsonResponse;

class TourController extends Controller
{
    /**
     * Return JSON availability for the Vanilla JS Booking Calendar.
     * Inherently protected by TenantScope because $tour is resolved via Route Model Binding
     * which automatically applies the active website_id filter.
     */
    public function availability(Tour $tour): JsonResponse
    {
        $availabilities = TourAvailability::where('tour_id', $tour->id)
            ->where('date', '>=', now()->toDateString())
            ->where('available_spots', '>', 0)
            ->orderBy('date')
            ->get(['date', 'available_spots']);
            
        return response()->json($availabilities);
    }
}
