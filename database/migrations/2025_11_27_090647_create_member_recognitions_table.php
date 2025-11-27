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

            // Member receiving the recognition
            $table->unsignedBigInteger('member_id');

            // Recognition title (Award, Appreciation, Certificate)
            $table->string('title');

            // Category (optional): Award, Star Performer, Business Champion, Leadership Badge
            $table->string('category')->nullable();

            // Description / Reason for recognition
            $table->text('description')->nullable();

            // Optional certificate or recognition image
            $table->string('certificate_file')->nullable();
            $table->string('badge_image')->nullable();

            // Given by admin or chapter
            $table->unsignedBigInteger('given_by')->nullable();
            $table->enum('given_by_role', ['admin', 'chapter'])->default('admin');

            // Date of recognition
            $table->date('recognized_at')->nullable();

            // Status
            $table->enum('status', ['active', 'inactive'])->default('active');

            // Notes
            $table->text('admin_notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('given_by')->references('id')->on('admins')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_recognitions');
    }
};
