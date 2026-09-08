<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('websites', function (Blueprint $table) {
            $table->id();
            $table->string('domain', 255)->unique();
            
            // Translatable Fields (Spatie Laravel Translatable uses JSON natively in MySQL 8+)
            $table->json('name')->nullable();
            $table->json('description')->nullable();
            $table->json('seo_title')->nullable();
            $table->json('slug')->nullable(); // Localized SEO slugs
            
            $table->string('default_locale', 5)->default('en'); // Tenant's fallback language
            $table->json('branding_details')->nullable();
            $table->enum('status', ['active', 'inactive', 'maintenance'])->default('active')->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('websites');
    }
};

