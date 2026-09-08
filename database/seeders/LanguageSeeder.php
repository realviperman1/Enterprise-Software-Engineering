<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        Language::create([
            'name' => 'English',
            'code' => 'en',
            'is_active' => true,
            'is_default' => true,
        ]);

        Language::create([
            'name' => 'French',
            'code' => 'fr',
            'is_active' => true,
            'is_default' => false,
        ]);
    }
}
