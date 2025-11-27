<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cluster_meetings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('chapter_id')->nullable()->constrained('chapters')->nullOnDelete();
            $table->string('title')->nullable();
            $table->text('agenda')->nullable();
            $table->timestamp('meeting_at')->nullable();
            $table->string('venue')->nullable();
            $table->enum('status', ['planned','completed','cancelled'])->default('planned')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cluster_meetings');
    }
};
