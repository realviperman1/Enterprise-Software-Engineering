<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Website;

class WebsiteSeeder extends Seeder
{
    public function run(): void
    {
        Website::create([
            'domain' => 'london-tours.test',
            'default_locale' => 'en',
            'status' => 'active',
            'branding_details' => [
                'primary_color' => '#e63946', // Vibrant Red
                'secondary_color' => '#f1faee',
            ],
            // Spatie handles arrays natively for JSON translation columns
            'name' => ['en' => 'London Tours', 'fr' => 'Visites de Londres'],
            'description' => ['en' => 'The best premium tours in London.', 'fr' => 'Les meilleures visites premium à Londres.'],
            'seo_title' => ['en' => 'London Tours - Official Site', 'fr' => 'Visites de Londres - Site Officiel'],
            'slug' => ['en' => 'london-tours', 'fr' => 'visites-de-londres'],
        ]);

        Website::create([
            'domain' => 'paris-vacations.test',
            'default_locale' => 'fr',
            'status' => 'active',
            'branding_details' => [
                'primary_color' => '#1d3557', // Deep Navy
                'secondary_color' => '#457b9d',
            ],
            'name' => ['en' => 'Paris Vacations', 'fr' => 'Vacances à Paris'],
            'description' => ['en' => 'Experience the magic of Paris.', 'fr' => 'Vivez la magie de Paris.'],
            'seo_title' => ['en' => 'Paris Vacations - Official Site', 'fr' => 'Vacances à Paris - Site Officiel'],
            'slug' => ['en' => 'paris-vacations', 'fr' => 'vacances-a-paris'],
        ]);
    }
}
