<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('meetups', function (Blueprint $table) {
            $table->id();

            // BASIC DETAILS
            $table->string('title');
            $table->string('slug')->unique()->nullable();
            $table->string('tagline')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();

            // EVENT TIMING
            $table->date('event_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('timezone')->default('Asia/Kolkata');

            // VENUE DETAILS
            $table->string('venue_name')->nullable();
            $table->string('address_line1')->nullable();
            $table->string('address_line2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->default('India');
            $table->string('pincode', 10)->nullable();
            $table->string('google_map_link')->nullable();

            // CAPACITY AND ATTENDEES
            $table->integer('max_capacity')->nullable()->comment('Maximum attendees allowed');
            $table->integer('registered_count')->default(0);
            $table->boolean('is_registration_open')->default(true);
            $table->string('registration_link')->nullable();

            // ORGANIZER / HOST
            $table->unsignedBigInteger('organizer_id')->nullable(); // Linked to users
            $table->string('organizer_name')->nullable();
            $table->string('organizer_designation')->nullable();
            $table->string('organizer_phone')->nullable();
            $table->string('organizer_email')->nullable();

            // MEDIA
            $table->string('banner')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('gallery')->nullable(); // JSON of multiple images
            $table->string('brochure')->nullable(); // Optional event PDF

            // EVENT TYPE & TOPICS
            $table->string('category')->nullable()->comment('e.g. Networking, Workshop, Seminar');
            $table->string('theme')->nullable();
            $table->string('topics')->nullable(); // Comma separated tags

            // STATUS & VISIBILITY
            $table->enum('status', ['draft', 'upcoming', 'ongoing', 'completed', 'cancelled'])->default('upcoming');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_public')->default(true);
            $table->boolean('is_active')->default(true);

            // ANALYTICS
            $table->integer('views')->default(0);
            $table->integer('registrations')->default(0);
            $table->integer('check_ins')->default(0);
            $table->integer('feedback_count')->default(0);
            $table->decimal('average_rating', 3, 2)->nullable()->default(null);

            // SEO & META
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            // AUDIT TRAIL
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();

            // FOREIGN KEYS
            $table->foreign('organizer_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('approved_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meetups');
    }
};
