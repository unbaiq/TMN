<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();

            // BASIC INFO
            $table->string('title');
            $table->string('slug')->unique()->nullable();
            $table->text('description')->nullable();
            $table->string('type')->nullable()->comment('e.g. Business Strategy, Marketing, Finance, Legal');
            $table->string('category')->nullable()->comment('e.g. One-on-One, Group, Online Session');

            // CONSULTATION DETAILS
            $table->date('consultation_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->enum('mode', ['online', 'offline', 'hybrid'])->default('online');
            $table->string('meeting_link')->nullable();
            $table->string('venue')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->default('India');

            // CONSULTANT INFO
            $table->unsignedBigInteger('consultant_id')->nullable();
            $table->string('consultant_name')->nullable();
            $table->string('consultant_designation')->nullable();
            $table->string('consultant_email')->nullable();
            $table->string('consultant_phone')->nullable();

            // CLIENT INFO
            $table->unsignedBigInteger('client_id')->nullable();
            $table->string('client_name')->nullable();
            $table->string('client_email')->nullable();
            $table->string('client_phone')->nullable();
            $table->string('organization')->nullable();

            // SESSION DETAILS
            $table->integer('duration_minutes')->nullable();
            $table->decimal('fee_amount', 10, 2)->default(0);
            $table->string('currency', 10)->default('INR');
            $table->boolean('is_paid')->default(false);

            // FEEDBACK & OUTCOMES
            $table->text('key_takeaways')->nullable();
            $table->text('notes')->nullable();
            $table->integer('rating')->nullable()->comment('1 to 5 stars');
            $table->boolean('follow_up_required')->default(false);
            $table->date('follow_up_date')->nullable();

            // STATUS & FLAGS
            $table->enum('status', ['scheduled', 'completed', 'cancelled', 'rescheduled'])->default('scheduled');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_public')->default(false);
            $table->boolean('is_active')->default(true);

            // ANALYTICS
            $table->integer('views')->default(0);
            $table->integer('registrations')->default(0);
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
            $table->foreign('consultant_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('client_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('approved_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
