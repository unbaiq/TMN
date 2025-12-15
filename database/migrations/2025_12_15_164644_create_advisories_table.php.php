<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('advisories', function (Blueprint $table) {
            $table->id();

            // BASIC DETAILS
            $table->string('title');
            $table->string('slug')->unique()->nullable();
            $table->string('tagline')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();

            // CATEGORY & TYPE
            $table->string('category')->nullable()->comment('e.g. Business, Finance, Legal, Strategy');
            $table->string('type')->nullable()->comment('e.g. Webinar, One-on-One, Panel Discussion');

            // SESSION DETAILS
            $table->date('session_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->enum('mode', ['online', 'offline', 'hybrid'])->default('online');
            $table->string('venue')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->default('India');
            $table->string('meeting_link')->nullable();
            $table->string('timezone')->default('Asia/Kolkata');

            // ADVISOR DETAILS
            $table->unsignedBigInteger('advisor_id')->nullable();
            $table->string('advisor_name')->nullable();
            $table->string('advisor_designation')->nullable();
            $table->string('advisor_email')->nullable();
            $table->string('advisor_phone')->nullable();
            $table->string('organization')->nullable();

            // MATERIALS
            $table->string('banner')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('resources')->nullable()->comment('Comma-separated file names or JSON');
            $table->string('presentation')->nullable();
            $table->string('brochure')->nullable();

            // PARTICIPATION
            $table->integer('max_participants')->nullable();
            $table->integer('registered_count')->default(0);
            $table->boolean('is_registration_open')->default(true);
            $table->string('registration_link')->nullable();

            // FEEDBACK & METRICS
            $table->integer('views')->default(0);
            $table->integer('registrations')->default(0);
            $table->integer('feedback_count')->default(0);
            $table->decimal('average_rating', 3, 2)->nullable();

            // STATUS & VISIBILITY
            $table->enum('status', ['draft', 'scheduled', 'ongoing', 'completed', 'cancelled'])->default('scheduled');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_public')->default(true);
            $table->boolean('is_active')->default(true);

            // SEO
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
            $table->foreign('advisor_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('approved_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('advisories');
    }
};
