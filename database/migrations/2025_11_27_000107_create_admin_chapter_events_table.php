<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /**
         * =======================
         *  CHAPTER EVENTS TABLE
         * =======================
         */
        Schema::create('chapter_events', function (Blueprint $table) {
            $table->id();

            // Chapter relationship
            $table->foreignId('chapter_id')->constrained('chapters')->onDelete('cascade');

            // Optional link to global events
            $table->foreignId('event_id')->nullable()->constrained('events')->nullOnDelete();

            // Event details
            $table->string('title')->nullable();
            $table->date('event_date')->nullable();
            $table->time('event_time')->nullable();
            $table->string('venue')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });

        /**
         * ============================
         *  EVENT ATTENDEES TABLE
         * ============================
         */
        Schema::create('event_attendees', function (Blueprint $table) {
            $table->id();

            // Member who is attending — now references users table
            $table->foreignId('member_id')->constrained('users')->onDelete('cascade');

            // The chapter event they are attending
            $table->foreignId('chapter_event_id')->constrained('chapter_events')->onDelete('cascade');

            // Confirmation
            $table->boolean('is_confirmed')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_attendees');
        Schema::dropIfExists('chapter_events');
    }
};
