<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('connects', function (Blueprint $table) {
            $table->id();

            $table->foreignId('chapter_id')->nullable()->constrained('chapters')->nullOnDelete();
            $table->foreignId('from_member_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('to_member_id')->constrained('users')->onDelete('cascade');
            $table->text('purpose')->nullable();
            $table->timestamp('connected_at')->nullable();
            $table->enum('status', ['initiated','accepted','closed','rejected'])->default('initiated')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('connects');
    }
};
