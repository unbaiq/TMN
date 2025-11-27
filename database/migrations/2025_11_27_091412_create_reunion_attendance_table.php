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

            $table->foreignId('reunion_id')->constrained('reunions')->onDelete('cascade');
            $table->foreignId('member_id')->constrained('users')->onDelete('cascade');

            $table->enum('status', ['registered','attended','absent','cancelled'])->default('registered');

            $table->timestamp('registered_at')->useCurrent();

            $table->timestamps();
            $table->unique(['reunion_id','member_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reunion_attendance');
    }
};
