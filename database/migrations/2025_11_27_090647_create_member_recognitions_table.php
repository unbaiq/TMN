<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_recognitions', function (Blueprint $table) {
            $table->id();

            // reference users table for member who is recognized
            $table->foreignId('member_id')->constrained('users')->cascadeOnDelete();

            $table->string('title');
            $table->string('category')->nullable();
            $table->text('description')->nullable();
            $table->string('certificate_file')->nullable();
            $table->string('badge_image')->nullable();

            // given_by references users (admin user), nullable
            $table->foreignId('given_by')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('given_by_role', ['admin', 'chapter'])->default('admin');

            $table->date('recognized_at')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->text('admin_notes')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_recognitions');
    }
};
