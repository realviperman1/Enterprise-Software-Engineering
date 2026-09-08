<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Tour;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class BookingService
{
    /**
     * Retrieves the strictly scoped availability dates for a specific tour.
     * Since $tour is retrieved under the global TenantScope, this method
     * inherently respects the domain boundaries.
     */
    public function getAvailableDates(Tour $tour, Carbon $startDate, Carbon $endDate): Collection
    {
        return $tour->availabilities()
            ->whereBetween('date', [$startDate->toDateString(), $endDate->toDateString()])
            ->where('available_spots', '>', 0)
            ->orderBy('date', 'asc')
            ->get();
    }
}

