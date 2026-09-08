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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('website_id')->constrained('websites')->cascadeOnDelete();
            
            // Core reservation details
            $table->string('reference_number', 100)->unique();
            $table->string('customer_name');
            $table->string('customer_email')->index();
            $table->decimal('total_amount', 12, 2);
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending')->index();
            
            // Travel specific dates
            $table->dateTime('check_in_date')->index();
            $table->dateTime('check_out_date')->index();
            
            // Translatable Notes/Requests from the customer
            $table->json('special_requests')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Composite index for fast lookups per website
            $table->index(['website_id', 'status']);
            $table->index(['website_id', 'check_in_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};

