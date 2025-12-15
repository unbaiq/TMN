<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_recognitions', function (Blueprint $table) {
            $table->id();

            // 🔗 The recognized member
            $table->foreignId('member_id')->constrained('users')->onDelete('cascade');

            // 🔗 The user (member/admin) who gave this recognition
            $table->foreignId('given_by')->nullable()->constrained('users')->onDelete('set null');

            // 🔗 Optional Chapter association
            $table->foreignId('chapter_id')->nullable()->constrained('chapters')->onDelete('set null');

            // 🔗 Optional link to a meeting or event
            $table->foreignId('member_meeting_id')->nullable()->constrained('member_meetings')->onDelete('cascade');

            // 🏅 Recognition details
            $table->string('title'); // e.g. "Top Referrer of the Month"
            $table->enum('category', [
                'referral',       // BNI referral given
                'thank_you',      // Thank you note
                'visitor',        // Invited a visitor
                'leadership',     // Leadership/role contribution
                'training',       // Attended or led training
                'testimony',      // Provided testimonial
                'support',        // Helping another member
                'milestone',      // Years/achievements
                'other'
            ])->default('other');

            // 📜 Description or notes
            $table->text('description')->nullable();

            // 🧾 Optional uploaded proof (certificate, image, thank-you slip, etc.)
            $table->string('evidence_file')->nullable();

            // 🗓 Date of recognition
            $table->date('recognized_on')->default(now());

            // 💰 Business value (for referrals or thank-you)
            $table->decimal('business_value', 12, 2)->nullable();

            // ⭐ Points system for leaderboard scoring
            $table->unsignedInteger('points')->default(0);

            // ✅ Approval workflow
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_recognitions');
    }
};
