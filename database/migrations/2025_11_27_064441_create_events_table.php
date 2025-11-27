<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            // Basic Event Details
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // Event Schedule
            $table->date('event_date')->nullable();
            $table->time('event_time')->nullable();

            // Location
            $table->string('venue')->nullable();
            $table->string('city')->nullable();

            // Media
            $table->string('banner')->nullable();

            // Registration
            $table->integer('capacity')->nullable();
            $table->integer('registered_count')->default(0);

            $table->boolean('is_registration_open')->default(true);

            // Status
            $table->enum('status', ['active', 'inactive'])->default('active');

            // SEO Fields
            $table->string('meta_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
