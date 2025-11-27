<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chapter_event_attendance', function (Blueprint $table) {
            $table->id();

            // Member
            $table->unsignedBigInteger('member_id');

            // Chapter Event reference
            $table->unsignedBigInteger('chapter_event_id'); 
            // This links to your chapter events table

            // Attendance status
            $table->enum('attendance_status', [
                'present',
                'absent',
                'interested'
            ])->default('interested');

            // Optional proof (image/pdf of participation)
            $table->string('proof_file')->nullable();

            // Notes by member
            $table->text('member_notes')->nullable();

            // Admin verification
            $table->enum('verification_status', [
                'pending',
                'verified',
                'rejected'
            ])->default('pending');

            $table->unsignedBigInteger('verified_by')->nullable();
            $table->text('rejection_reason')->nullable();

            // Admin notes
            $table->text('admin_notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign Keys
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('chapter_event_id')->references('id')->on('chapter_events')->onDelete('cascade');
            $table->foreign('verified_by')->references('id')->on('admins')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chapter_event_attendance');
    }
};
