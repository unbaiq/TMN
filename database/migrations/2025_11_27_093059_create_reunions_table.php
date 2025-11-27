<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reunions', function (Blueprint $table) {
            $table->id();

            // Basic Reunion Info
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('theme')->nullable();

            // Venue details
            $table->string('venue')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();

            // Date & Time
            $table->date('reunion_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

            // Media
            $table->string('banner_image')->nullable();

            // Description / Agenda
            $table->longText('description')->nullable();

            // Admin who created the reunion
            $table->unsignedBigInteger('created_by')->nullable();

            // Reunion Status
            $table->enum('status', [
                'upcoming',
                'completed',
                'cancelled'
            ])->default('upcoming');

            $table->timestamps();
            $table->softDeletes();

            // Foreign key
            $table->foreign('created_by')->references('id')->on('admins')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reunions');
    }
};
