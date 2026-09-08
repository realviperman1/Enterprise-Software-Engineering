<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Website;
use App\Models\Tour;
use App\Models\Scopes\TenantScope;

class TourSeeder extends Seeder
{
    public function run(): void
    {
        $london = Website::where('domain', 'london-tours.test')->first();
        $paris = Website::where('domain', 'paris-vacations.test')->first();

        $query = Tour::withoutGlobalScope(TenantScope::class);

        $tours = [];

        if ($london) {
            $tours[] = $query->create([
                'website_id' => $london->id,
                'name' => ['en' => 'Tower of London VIP Tour', 'fr' => 'Tour VIP de la Tour de Londres'],
                'description' => ['en' => 'Experience the history of the Tower of London with early access.', 'fr' => 'Découvrez l\'histoire de la Tour de Londres avec un accès anticipé.'],
                'base_price' => 120.00,
            ]);

            $tours[] = $query->create([
                'website_id' => $london->id,
                'name' => ['en' => 'Thames River Cruise', 'fr' => 'Croisière sur la Tamise'],
                'description' => ['en' => 'A relaxing evening cruise along the Thames.', 'fr' => 'Une croisière relaxante en soirée sur la Tamise.'],
                'base_price' => 45.00,
            ]);
        }

        if ($paris) {
            $tours[] = $query->create([
                'website_id' => $paris->id,
                'name' => ['en' => 'Eiffel Tower Summit Access', 'fr' => 'Accès au Sommet de la Tour Eiffel'],
                'description' => ['en' => 'Skip the line and go straight to the top.', 'fr' => 'Évitez la file d\'attente et montez directement au sommet.'],
                'base_price' => 85.00,
            ]);

            $tours[] = $query->create([
                'website_id' => $paris->id,
                'name' => ['en' => 'Louvre Museum Guided Tour', 'fr' => 'Visite Guidée du Musée du Louvre'],
                'description' => ['en' => 'See the Mona Lisa and more with an expert guide.', 'fr' => 'Voyez la Joconde et bien plus avec un guide expert.'],
                'base_price' => 65.00,
            ]);
        }

        // Seed 30 days of availability for each tour
        foreach ($tours as $tour) {
            for ($i = 0; $i < 30; $i++) {
                // Skip some random days to make the calendar look realistic
                if (rand(1, 10) > 8) continue;

                \App\Models\TourAvailability::create([
                    'tour_id' => $tour->id,
                    'date' => now()->addDays($i)->toDateString(),
                    'available_spots' => rand(5, 20),
                ]);
            }
        }
    }
}
