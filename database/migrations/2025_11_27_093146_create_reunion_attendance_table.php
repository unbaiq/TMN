<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reunion_attendance', function (Blueprint $table) {
            $table->id();

            // Member who is attending
            $table->unsignedBigInteger('member_id');

            // Reunion event
            $table->unsignedBigInteger('reunion_id');

            // Attendance status
            $table->enum('attendance_status', [
                'interested',   // member clicked interested
                'registered',   // member registered
                'present',      // member attended
                'absent'        // did not attend
            ])->default('interested');

            // Optional proof (image/pdf)
            $table->string('proof_file')->nullable();

            // Notes
            $table->text('member_notes')->nullable();
            $table->text('admin_notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign Keys
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('reunion_id')->references('id')->on('reunions')->onDelete('cascade');

            // Prevent duplicate attendance record
            $table->unique(['member_id', 'reunion_id'], 'unique_reunion_attendance');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reunion_attendance');
    }
};
