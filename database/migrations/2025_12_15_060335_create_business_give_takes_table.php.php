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
        Schema::create('business_give_takes', function (Blueprint $table) {
            $table->id();

            // 🔗 Basic Relationships
            $table->foreignId('giver_id')->constrained('users')->onDelete('cascade'); // Member giving referral/business
            $table->foreignId('taker_id')->constrained('users')->onDelete('cascade'); // Member receiving referral/business
            $table->foreignId('chapter_id')->nullable()->constrained('chapters')->onDelete('set null');

            // 🧾 Core Details
            $table->string('service_name');
            $table->text('description')->nullable();
            $table->decimal('business_value', 15, 2)->nullable()->comment('Value of the business in INR');
            $table->enum('status', ['pending', 'accepted', 'rejected', 'closed', 'cancelled'])->default('pending');

            // 💼 Referral Specifics (BNI-style)
            $table->enum('referral_type', ['referral', 'thank_you', '1to1', 'visitor', 'training', 'testimony'])
                ->default('referral')
                ->comment('Type of business activity');
            $table->enum('referral_level', ['tier_1', 'tier_2', 'tier_3'])->nullable()->comment('Strength of referral (1st/2nd/3rd hand)');
            $table->string('referral_company')->nullable()->comment('Company to which the referral was given');
            $table->string('referral_contact_person')->nullable();
            $table->string('referral_contact_phone')->nullable();
            $table->string('referral_contact_email')->nullable();

            // 🙏 Thank You Note
            $table->boolean('thank_you_given')->default(false);
            $table->text('thank_you_message')->nullable();
            $table->decimal('thank_you_amount', 15, 2)->nullable()->comment('Monetary value of thank-you note');

            // ⏳ Progress & Follow-Up
            $table->enum('follow_up_status', ['not_started', 'in_progress', 'completed'])->default('not_started');
            $table->timestamp('follow_up_date')->nullable();
            $table->text('follow_up_notes')->nullable();

            // 📄 Supporting Files
            $table->string('reference_document')->nullable();
            $table->text('internal_notes')->nullable();

            // ❌ Rejection Details
            $table->text('reject_reason')->nullable();

            // 📅 Timeline
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamp('closed_at')->nullable();

            // 🧠 Flags
            $table->boolean('taker_request')->default(false)->comment('True if initiated by taker');
            $table->boolean('is_visible_to_chapter')->default(true)->comment('Hide or show in chapter stats');

            // 👤 Audit
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_give_takes');
    }
};
