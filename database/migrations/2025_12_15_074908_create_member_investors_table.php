<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_investors', function (Blueprint $table) {
            $table->id();

            // 👤 Linked Member
            $table->foreignId('member_id')->constrained('users')->onDelete('cascade');

            // 🏢 Optional Chapter link
            $table->foreignId('chapter_id')->nullable()->constrained('chapters')->onDelete('set null');

            // 🧾 Investor Personal Details
            $table->string('investor_name');
            $table->string('designation')->nullable();
            $table->string('company_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('alternate_phone', 20)->nullable();

            // 📍 Address
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('linkedin_profile')->nullable();

            // 💼 Investment Info
            $table->string('investment_focus')->nullable(); // e.g., “Technology, Healthcare”
            $table->decimal('investment_capacity', 15, 2)->nullable(); // Expected investable capital
            $table->decimal('invested_value', 15, 2)->nullable(); // Amount already invested
            $table->string('preferred_stage')->nullable(); // Seed / Series A / Growth
            $table->string('preferred_ticket_size')->nullable(); // e.g. 10L–50L
            $table->integer('years_of_experience')->nullable();

            // 🧠 Relationship Insights
            $table->enum('relationship_type', ['personal', 'professional', 'referral'])->default('professional');
            $table->string('referral_source')->nullable();
            $table->text('notes')->nullable();

            // ⚙️ Status & Audit
            $table->enum('status', ['potential', 'active', 'inactive'])->default('potential');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_investors');
    }
};
