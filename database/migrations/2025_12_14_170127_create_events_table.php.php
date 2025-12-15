<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            // Type of event: General or Chapter-based
            $table->enum('event_type', ['general', 'chapter'])->default('general');

            // Chapter association (nullable for general events)
            $table->foreignId('chapter_id')->nullable()->constrained('chapters')->onDelete('cascade');

            // Basic event details
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // Organizer/Host details
            $table->foreignId('organizer_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('host_name')->nullable();
            $table->string('host_contact')->nullable();
            $table->string('host_email')->nullable();

            // Event location details
            $table->string('venue_name')->nullable();
            $table->string('address_line1')->nullable();
            $table->string('address_line2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('pincode', 15)->nullable();

            // Event timing
            $table->date('event_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

            // Agenda and optional meeting details
            $table->text('agenda')->nullable();
            $table->text('notes')->nullable();

            // For online events
            $table->boolean('is_online')->default(false);
            $table->string('meeting_link')->nullable();
            $table->string('meeting_password')->nullable();

            // Attendance and status
            $table->integer('max_attendees')->nullable();
            $table->integer('registered_attendees')->default(0);
            $table->enum('status', ['upcoming', 'ongoing', 'completed', 'cancelled'])->default('upcoming');

            // Visibility and featured flag
            $table->boolean('is_public')->default(true);
            $table->boolean('is_featured')->default(false);

            // Optional cover image or banner
            $table->string('banner_image')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('events');
    }
};
