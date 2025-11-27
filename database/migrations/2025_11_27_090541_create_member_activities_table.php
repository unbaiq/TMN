<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_activities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('chapter_id')->nullable()->constrained('chapters')->nullOnDelete();
            $table->foreignId('member_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('related_member_id')->nullable()->constrained('users')->nullOnDelete()->comment('Optional: other member involved in the activity');

            // type covers: events_attended, chapter_event, connect, give, take, referral, business, one_to_one, cluster_meeting, recognition
            $table->enum('type', [
                'event_attended',
                'chapter_event',
                'connect',
                'give',
                'take',
                'referral',
                'business',
                'one_to_one',
                'cluster_meeting',
                'recognition'
            ])->index();

            // optional links to other entities
            $table->foreignId('event_id')->nullable()->constrained('events')->nullOnDelete();
            $table->foreignId('chapter_event_id')->nullable()->constrained('chapter_events')->nullOnDelete();
            $table->foreignId('referral_id')->nullable()->constrained('referrals')->nullOnDelete();

            // details & numeric value (e.g., business amount, referral count)
            $table->decimal('value', 14, 2)->nullable()->comment('Optional numeric value related to activity (e.g., business amount)');
            $table->text('notes')->nullable();

            // timestamp of activity (when it happened)
            $table->timestamp('activity_at')->nullable();

            $table->boolean('is_verified')->default(false)->index();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_activities');
    }
};
