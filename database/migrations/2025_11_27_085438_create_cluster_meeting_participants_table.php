<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cluster_meeting_participants', function (Blueprint $table) {
            $table->id();

            // Cluster meeting reference
            $table->unsignedBigInteger('cluster_meeting_id');

            // Member participating in the meeting
            $table->unsignedBigInteger('member_id');

            // Attendance status
            $table->enum('attendance', [
                'pending',      // invited but not responded
                'accepted',     // accepted invitation
                'rejected',     // declined
                'present',      // attended
                'absent'
            ])->default('pending');

            // Notes
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign Keys
            $table->foreign('cluster_meeting_id')
                  ->references('id')->on('cluster_meetings')->onDelete('cascade');

            $table->foreign('member_id')
                  ->references('id')->on('members')->onDelete('cascade');

            // Prevent duplicate participation
            $table->unique(['cluster_meeting_id', 'member_id'], 'cluster_member_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cluster_meeting_participants');
    }
};
