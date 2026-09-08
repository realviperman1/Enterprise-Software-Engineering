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
        Schema::table('tours', function (Blueprint $table) {
            // Make website_id nullable since master tours belong to no specific website
            $table->foreignId('website_id')->nullable()->change();
            
            // Self-referencing foreign key for tenant-specific overrides
            $table->foreignId('parent_tour_id')->nullable()->constrained('tours')->cascadeOnDelete()->after('website_id');
        });
    }

    public function down(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->dropForeign(['parent_tour_id']);
            $table->dropColumn('parent_tour_id');
            // Reverting website_id to non-nullable might fail if there are nulls, but this is a POC.
            $table->foreignId('website_id')->nullable(false)->change();
        });
    }
};
