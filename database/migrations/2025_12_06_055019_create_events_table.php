<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            // basic details
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('location')->nullable();

            // schedule
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();

            // capacity & visibility
            $table->unsignedInteger('capacity')->nullable()->default(null);
            $table->enum('status', ['draft','published','cancelled'])->default('draft');

            // optional poster / image
            $table->string('poster_path')->nullable();

            // who created (admin user id if you have users)
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            // indexes for searching/filtering
            $table->index(['starts_at']);
            $table->index(['status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
