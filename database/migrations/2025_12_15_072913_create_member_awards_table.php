<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_awards', function (Blueprint $table) {
            $table->id();

            // 🔗 The member who received the award
            $table->foreignId('member_id')->constrained('users')->onDelete('cascade');

            // 🔗 Chapter association (BNI chapters)
            $table->foreignId('chapter_id')->nullable()->constrained('chapters')->onDelete('set null');

            // 🔗 Optional meeting/event link
            $table->foreignId('member_meeting_id')->nullable()->constrained('member_meetings')->onDelete('set null');
            $table->foreignId('event_id')->nullable()->constrained('events')->onDelete('set null');

            // 🏅 Award details
            $table->string('title'); // e.g. "Member of the Month"
            $table->enum('award_type', [
                'performance',     // based on metrics
                'leadership',      // chapter roles or leadership
                'referral',        // referral count/value
                'training',        // educational contribution
                'visitor',         // visitor invitations
                'support',         // helping chapter operations
                'special',         // special recognition
                'milestone',       // years or anniversaries
                'other'
            ])->default('other');

            // 📜 Optional description / reason
            $table->text('description')->nullable();

            // 🏆 Award month/year
            $table->string('month')->nullable(); // e.g. "December"
            $table->year('year')->nullable();

            // 🧾 Business value or points
            $table->decimal('business_value', 12, 2)->nullable();
            $table->unsignedInteger('points')->default(0);

            // 🖼️ Certificate or proof upload
            $table->string('certificate_file')->nullable();

            // ✅ Approval & audit
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();

            // 🧾 Created info
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_awards');
    }
};
