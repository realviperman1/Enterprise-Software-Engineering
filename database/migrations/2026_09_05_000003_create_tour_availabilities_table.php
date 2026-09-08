<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tour_availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained('tours')->cascadeOnDelete();
            
            // Calendar specific fields
            $table->date('date')->index();
            $table->integer('available_spots')->default(0);
            
            $table->timestamps();
            
            // Ensure we don't have duplicate dates for a single tour
            $table->unique(['tour_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_availabilities');
    }
};

