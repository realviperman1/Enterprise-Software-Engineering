<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\Website;
use App\Models\Scopes\TenantScope;
use Carbon\Carbon;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        $london = Website::where('domain', 'london-tours.test')->first();
        $paris = Website::where('domain', 'paris-vacations.test')->first();

        // Crucial: Because we are in CLI (no IdentifyTenant middleware ran), 
        // we must disable the TenantScope to manually seed specific tenants.
        $query = Reservation::withoutGlobalScope(TenantScope::class);

        $query->create([
            'website_id' => $london->id,
            'reference_number' => 'LON-1001',
            'customer_name' => 'Arthur Pendragon',
            'customer_email' => 'arthur@camelot.com',
            'total_amount' => 450.00,
            'status' => 'confirmed',
            'check_in_date' => Carbon::now()->addDays(2),
            'check_out_date' => Carbon::now()->addDays(5),
            'special_requests' => ['en' => 'Window seat requested.', 'fr' => 'Siège côté fenêtre demandé.'],
        ]);

        $query->create([
            'website_id' => $paris->id,
            'reference_number' => 'PAR-8022',
            'customer_name' => 'Marie Curie',
            'customer_email' => 'marie@science.fr',
            'total_amount' => 1200.00,
            'status' => 'confirmed',
            'check_in_date' => Carbon::now()->addDays(10),
            'check_out_date' => Carbon::now()->addDays(14),
            'special_requests' => ['en' => 'Vegetarian meals.', 'fr' => 'Repas végétariens.'],
        ]);
    }
}
