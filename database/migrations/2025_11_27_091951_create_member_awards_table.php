<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_awards', function (Blueprint $table) {
            $table->id();

            // reference users table for the member who receives the award
            $table->foreignId('member_id')->constrained('users')->cascadeOnDelete();

            $table->string('title');
            $table->string('category')->nullable();
            $table->text('description')->nullable();
            $table->string('award_event')->nullable();
            $table->date('award_date')->nullable();
            $table->string('certificate_file')->nullable();
            $table->string('trophy_image')->nullable();

            // who gave the award (nullable user id)
            $table->foreignId('given_by')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('given_by_role', ['admin', 'chapter'])->default('admin');

            $table->enum('status', ['active', 'archived'])->default('active');
            $table->text('admin_notes')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_awards');
    }
};
