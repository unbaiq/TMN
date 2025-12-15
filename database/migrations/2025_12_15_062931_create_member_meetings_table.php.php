<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Main meetings table
        Schema::create('member_meetings', function (Blueprint $table) {
            $table->id();

            // Core info
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->enum('meeting_type', ['1to1', 'cluster'])->default('1to1');
            $table->string('title')->nullable();
            $table->text('agenda')->nullable();

            // Meeting details
            $table->date('meeting_date');
            $table->time('meeting_time')->nullable();
            $table->string('venue')->nullable();

            // Chapter reference
            $table->foreignId('chapter_id')->nullable()->constrained('chapters')->onDelete('set null');

            // Optional notes
            $table->text('key_discussion_points')->nullable();
            $table->text('outcomes')->nullable();

            $table->timestamps();
        });

        // Pivot table for participants
        Schema::create('member_meeting_participants', function (Blueprint $table) {
            $table->id();

            // ✅ FIXED: match relationship key name
            $table->foreignId('member_meeting_id')->constrained('member_meetings')->onDelete('cascade');

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->boolean('attended')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_meeting_participants');
        Schema::dropIfExists('member_meetings');
    }
};
