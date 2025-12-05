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

            $table->unsignedBigInteger('cluster_meeting_id');
            $table->unsignedBigInteger('member_id');

            // Attendance options match frontend exactly
            $table->enum('attendance', [
                'pending',
                'accepted',
                'rejected',
                'present',
                'absent',
            ])->default('pending');

            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign Keys
            $table->foreign('cluster_meeting_id')
                ->references('id')->on('cluster_meetings')
                ->onDelete('cascade');

            $table->foreign('member_id')
                ->references('id')->on('members')
                ->onDelete('cascade');

            // Prevent duplicate member entry in same meeting
            $table->unique(['cluster_meeting_id', 'member_id'], 'cluster_member_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cluster_meeting_participants');
    }
};
