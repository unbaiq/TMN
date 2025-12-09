<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_attendance', function (Blueprint $table) {
            $table->id();

            // ========== Foreign Keys ==========
            $table->unsignedBigInteger('event_id');   // event belongs to events table
            $table->unsignedBigInteger('member_id');  // member belongs to users/members table

            // ========== UI Fields ==========
            $table->string('chapter')->nullable();    // Delhi NCR, Mumbai, etc.
            $table->dateTime('attended_at')->nullable(); // When they attended
            $table->enum('status', ['Present', 'Late', 'Absent'])
                  ->default('Present'); // Matches your UI radio buttons

            $table->timestamps();

            // ========== Optional Foreign Keys ==========
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->foreign('member_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_attendance');
    }
};
