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

            // Member → users table
            $table->foreignId('member_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Event reference
            $table->foreignId('chapter_event_id')
                  ->constrained('chapter_events')
                  ->onDelete('cascade');

            // Attendance
            $table->enum('attendance_status', [
                'present',
                'absent',
                'interested'
            ])->default('interested');

            $table->string('proof_file')->nullable();
            $table->text('member_notes')->nullable();

            // Verification
            $table->enum('verification_status', [
                'pending',
                'verified',
                'rejected'
            ])->default('pending');

            $table->foreignId('verified_by')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');

            $table->text('rejection_reason')->nullable();
            $table->text('admin_notes')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chapter_event_attendance');
    }
};
