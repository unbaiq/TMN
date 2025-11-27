<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chapter_events', function (Blueprint $table) {
            $table->id();

            $table->foreignId('chapter_id')->constrained('chapters')->onDelete('cascade');

            // Optionally link to global events table
            $table->foreignId('event_id')->nullable()->constrained('events')->nullOnDelete();

            // Basic event data (in case it's chapter-specific record)
            $table->string('title')->nullable();
            $table->date('event_date')->nullable();
            $table->time('event_time')->nullable();
            $table->string('venue')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chapter_events');
    }
};
