<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_attendances', function (Blueprint $table) {
            $table->id();

            // Event & Member
            $table->unsignedBigInteger('event_id')->index();
            $table->unsignedBigInteger('user_id')->index(); // attendee

            // Attendance details
            $table->enum('attendance_status', ['present', 'absent'])
                  ->default('absent')
                  ->index();

            $table->timestamp('check_in_time')->nullable();
            $table->timestamp('check_out_time')->nullable();

            // Optional note
            $table->text('remarks')->nullable();

            // Avoid duplicate for same event + user
            $table->unique(['event_id', 'user_id']);

            $table->timestamps();
        });

        // Foreign keys
        Schema::table('event_attendances', function (Blueprint $table) {
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('event_attendances', function (Blueprint $table) {
            $table->dropForeign(['event_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('event_attendances');
    }
};
