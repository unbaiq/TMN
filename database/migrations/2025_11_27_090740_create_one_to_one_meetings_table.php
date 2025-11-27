<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('one_to_one_meetings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('chapter_id')->nullable()->constrained('chapters')->nullOnDelete();
            $table->foreignId('requester_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('requested_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('scheduled_at')->nullable();
            $table->enum('status', ['requested','scheduled','completed','cancelled'])->default('requested');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('one_to_one_meetings');
    }
};
